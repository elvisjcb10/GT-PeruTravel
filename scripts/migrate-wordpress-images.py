from __future__ import annotations

import hashlib
import html
import io
import json
import re
import sys
import urllib.parse
import urllib.request
from pathlib import Path
from typing import Any

from PIL import Image, ImageFile, ImageOps

ImageFile.LOAD_TRUNCATED_IMAGES = True
ROOT = Path(__file__).resolve().parents[1]
DATA_DIR = ROOT / "data" / "blog"
IMAGE_DIR = ROOT / "images" / "blog" / "content"
REPORT_PATH = ROOT / "scripts" / "wordpress-image-migration-report.json"
MAX_SIZE = (1400, 1400)
QUALITY = 78
URL_RE = re.compile(r"https?://(?:www\.)?gtperutravel\.com/blog/wp-content/[^\s\"'<>\\]+", re.I)
SIZE_SUFFIX_RE = re.compile(r"-\d{2,5}x\d{2,5}(?=\.[a-zA-Z0-9]{2,5}$)")


def collect_strings(value: Any, output: list[str]) -> None:
    if isinstance(value, str):
        output.append(value)
    elif isinstance(value, list):
        for item in value:
            collect_strings(item, output)
    elif isinstance(value, dict):
        for item in value.values():
            collect_strings(item, output)


def canonical_url(url: str) -> str:
    decoded = html.unescape(url).replace("\\/", "/")
    parts = urllib.parse.urlsplit(decoded)
    path = SIZE_SUFFIX_RE.sub("", urllib.parse.unquote(parts.path))
    return urllib.parse.urlunsplit((parts.scheme.lower(), parts.netloc.lower(), path, "", ""))


def safe_url(url: str) -> str:
    parts = urllib.parse.urlsplit(html.unescape(url).replace("\\/", "/"))
    return urllib.parse.urlunsplit((
        parts.scheme,
        parts.netloc,
        urllib.parse.quote(urllib.parse.unquote(parts.path), safe="/%:@"),
        urllib.parse.quote_plus(urllib.parse.unquote_plus(parts.query), safe="=&"),
        "",
    ))


def target_path(canonical: str) -> Path:
    stem = Path(urllib.parse.unquote(urllib.parse.urlsplit(canonical).path)).stem
    stem = re.sub(r"[^a-zA-Z0-9_-]+", "-", stem).strip("-").lower() or "blog-image"
    stem = stem[:90]
    suffix = hashlib.sha256(canonical.encode("utf-8")).hexdigest()[:10]
    return IMAGE_DIR / f"{stem}-{suffix}.webp"


def download(url: str) -> bytes:
    request = urllib.request.Request(safe_url(url), headers={"User-Agent": "Mozilla/5.0 GT-PeruTravel image migration"})
    with urllib.request.urlopen(request, timeout=35) as response:
        content_type = response.headers.get("Content-Type", "").lower()
        raw = response.read(25 * 1024 * 1024)
    if not raw or (content_type and "image" not in content_type):
        raise ValueError(f"unexpected content type: {content_type or 'unknown'}")
    return raw


def optimize(raw: bytes, target: Path) -> tuple[int, int, int]:
    with Image.open(io.BytesIO(raw)) as source:
        source = ImageOps.exif_transpose(source)
        source.thumbnail(MAX_SIZE, Image.Resampling.LANCZOS)
        width, height = source.size
        if getattr(source, "is_animated", False):
            source.seek(0)
        if source.mode not in {"RGB", "RGBA"}:
            source = source.convert("RGBA" if "transparency" in source.info else "RGB")
        temp = target.with_suffix(".tmp.webp")
        source.save(temp, "WEBP", quality=QUALITY, method=6, optimize=True)
        temp.replace(target)
    return target.stat().st_size, width, height


def replace_strings(value: Any, replacements: dict[str, str]) -> Any:
    if isinstance(value, str):
        for old, new in replacements.items():
            value = value.replace(old, new)
        if "content_html" not in value:
            return value
        return value
    if isinstance(value, list):
        return [replace_strings(item, replacements) for item in value]
    if isinstance(value, dict):
        changed: dict[str, Any] = {}
        for key, item in value.items():
            new_item = replace_strings(item, replacements)
            if key == "content_html" and isinstance(new_item, str):
                new_item = re.sub(r"\s+srcset=(['\"]).*?\1", "", new_item, flags=re.I | re.S)
                new_item = re.sub(r"\s+sizes=(['\"]).*?\1", "", new_item, flags=re.I | re.S)
            changed[key] = new_item
        return changed
    return value


def main() -> None:
    IMAGE_DIR.mkdir(parents=True, exist_ok=True)
    documents: dict[Path, Any] = {}
    found: set[str] = set()
    for path in sorted(DATA_DIR.glob("*.json")):
        data = json.loads(path.read_text(encoding="utf-8"))
        documents[path] = data
        strings: list[str] = []
        collect_strings(data, strings)
        for text in strings:
            for match in URL_RE.findall(text.replace("\\/", "/")):
                found.add(html.unescape(match))

    groups: dict[str, list[str]] = {}
    for url in sorted(found):
        groups.setdefault(canonical_url(url), []).append(url)

    replacements: dict[str, str] = {}
    migrated: list[dict[str, Any]] = []
    failures: list[dict[str, Any]] = []
    downloaded_bytes = 0
    optimized_bytes = 0

    for index, (canonical, variants) in enumerate(sorted(groups.items()), 1):
        target = target_path(canonical)
        candidates = [canonical] + [url for url in variants if url != canonical]
        error = ""
        if target.exists():
            try:
                with Image.open(target) as check:
                    check.verify()
                local = target.relative_to(ROOT).as_posix()
                for variant in variants:
                    replacements[variant] = local
                migrated.append({"source": canonical, "local": local, "variants": len(variants), "cached": True, "bytes": target.stat().st_size})
                continue
            except Exception:
                target.unlink(missing_ok=True)
        for candidate in candidates:
            try:
                raw = download(candidate)
                size, width, height = optimize(raw, target)
                downloaded_bytes += len(raw)
                optimized_bytes += size
                local = target.relative_to(ROOT).as_posix()
                for variant in variants:
                    replacements[variant] = local
                migrated.append({"source": candidate, "local": local, "variants": len(variants), "cached": False, "downloaded_bytes": len(raw), "bytes": size, "width": width, "height": height})
                error = ""
                break
            except Exception as exc:
                error = str(exc)
        if error:
            failures.append({"canonical": canonical, "variants": variants, "error": error})
        if index % 25 == 0:
            print(f"processed {index}/{len(groups)}", flush=True)

    updated_files = 0
    for path, data in documents.items():
        changed = replace_strings(data, replacements)
        if changed != data:
            path.write_text(json.dumps(changed, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
            updated_files += 1

    remaining: set[str] = set()
    for path in DATA_DIR.glob("*.json"):
        raw = path.read_text(encoding="utf-8").replace("\\/", "/")
        remaining.update(URL_RE.findall(raw))

    report = {
        "settings": {"max_size": MAX_SIZE, "quality": QUALITY},
        "remote_urls_found": len(found),
        "canonical_groups": len(groups),
        "groups_migrated": len(migrated),
        "groups_failed": len(failures),
        "json_files_updated": updated_files,
        "downloaded_bytes": downloaded_bytes,
        "optimized_bytes": optimized_bytes,
        "saved_transfer_bytes": downloaded_bytes - optimized_bytes,
        "remaining_remote_urls": sorted(remaining),
        "migrated": migrated,
        "failures": failures,
    }
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    sys.stdout.buffer.write((json.dumps({key: value for key, value in report.items() if key not in {"migrated", "failures", "remaining_remote_urls"}}, ensure_ascii=False, indent=2) + "\n").encode("utf-8"))
    if failures:
        sys.exit(2)


if __name__ == "__main__":
    main()