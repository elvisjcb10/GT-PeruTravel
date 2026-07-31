from __future__ import annotations

import hashlib
import json
import os
from pathlib import Path
from typing import Any

from PIL import Image, ImageOps

ROOT = Path(__file__).resolve().parents[1]
IMAGE_DIR = ROOT / "images" / "blog" / "posts"
DATA_DIR = ROOT / "data" / "blog"
REPORT_PATH = ROOT / "scripts" / "image-optimization-report.json"
MAX_SIZE = (1920, 1920)
QUALITY = 82
IMAGE_EXTENSIONS = {".jpg", ".jpeg", ".png", ".webp"}
TEXT_EXTENSIONS = {".php", ".js", ".css", ".html", ".json", ".md", ".txt"}
SKIP_DIRS = {".git", "node_modules", "vendor"}


def sha256(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def rel(path: Path) -> str:
    return path.relative_to(ROOT).as_posix()


def transform_strings(value: Any, replacements: dict[str, str]) -> Any:
    if isinstance(value, str):
        for old, new in replacements.items():
            value = value.replace(old, new)
        return value
    if isinstance(value, list):
        return [transform_strings(item, replacements) for item in value]
    if isinstance(value, dict):
        return {key: transform_strings(item, replacements) for key, item in value.items()}
    return value


def update_json_files(replacements: dict[str, str]) -> int:
    if not replacements:
        return 0
    updated = 0
    for path in DATA_DIR.glob("*.json"):
        data = json.loads(path.read_text(encoding="utf-8"))
        changed = transform_strings(data, replacements)
        if changed != data:
            path.write_text(
                json.dumps(changed, ensure_ascii=False, indent=2) + "\n",
                encoding="utf-8",
            )
            updated += 1
    return updated


_EXTERNAL_TEXT: str | None = None


def referenced_elsewhere(relative_path: str) -> bool:
    global _EXTERNAL_TEXT
    if _EXTERNAL_TEXT is None:
        chunks: list[str] = []
        for path in ROOT.rglob("*"):
            if not path.is_file() or path.suffix.lower() not in TEXT_EXTENSIONS:
                continue
            if any(part in SKIP_DIRS for part in path.parts):
                continue
            if path == REPORT_PATH or DATA_DIR in path.parents:
                continue
            try:
                chunks.append(path.read_text(encoding="utf-8", errors="ignore").replace("\\", "/"))
            except OSError:
                continue
        _EXTERNAL_TEXT = "\n".join(chunks)
    return relative_path.replace("\\", "/") in _EXTERNAL_TEXT


def unique_webp_path(source: Path) -> Path:
    candidate = source.with_suffix(".webp")
    if candidate == source or not candidate.exists():
        return candidate
    suffix = sha256(source)[:8]
    return source.with_name(f"{source.stem}-{suffix}.webp")


def save_optimized(source: Path, target: Path) -> tuple[int, int] | None:
    original_size = source.stat().st_size
    temp = target.with_name(f".{target.stem}.optimizing.webp")
    try:
        with Image.open(source) as image:
            if getattr(image, "is_animated", False):
                return None
            image = ImageOps.exif_transpose(image)
            image.thumbnail(MAX_SIZE, Image.Resampling.LANCZOS)
            if image.mode not in {"RGB", "RGBA"}:
                image = image.convert("RGBA" if "transparency" in image.info else "RGB")
            image.save(temp, "WEBP", quality=QUALITY, method=6, optimize=True)
        optimized_size = temp.stat().st_size
        if optimized_size >= original_size:
            temp.unlink(missing_ok=True)
            return None
        os.replace(temp, target)
        return original_size, optimized_size
    except Exception:
        temp.unlink(missing_ok=True)
        raise


def main() -> None:
    before_files = [path for path in IMAGE_DIR.iterdir() if path.is_file()]
    before_bytes = sum(path.stat().st_size for path in before_files)
    replacements: dict[str, str] = {}
    converted: list[dict[str, Any]] = []
    recompressed: list[dict[str, Any]] = []
    retained_referenced: list[str] = []
    errors: list[dict[str, str]] = []

    for temp in IMAGE_DIR.glob(".*.optimizing.webp"):
        temp.unlink(missing_ok=True)

    for source in sorted(before_files):
        if source.suffix.lower() not in IMAGE_EXTENSIONS:
            continue
        existing_target = source.with_suffix(".webp")
        if source.suffix.lower() != ".webp" and existing_target.exists():
            replacements[rel(source)] = rel(existing_target)
            continue
        target = unique_webp_path(source)
        try:
            result = save_optimized(source, target)
        except Exception as exc:
            errors.append({"file": rel(source), "error": str(exc)})
            continue
        if result is None:
            continue
        old_size, new_size = result
        if source.suffix.lower() == ".webp":
            recompressed.append({"file": rel(source), "before": old_size, "after": new_size})
            continue

        old_rel = rel(source)
        new_rel = rel(target)
        replacements[old_rel] = new_rel
        converted.append({"from": old_rel, "to": new_rel, "before": old_size, "after": new_size})

    json_files_updated = update_json_files(replacements)

    for old_rel in replacements:
        source = ROOT / old_rel
        if not source.exists():
            continue
        if referenced_elsewhere(old_rel):
            retained_referenced.append(old_rel)
        else:
            source.unlink()

    duplicate_replacements: dict[str, str] = {}
    duplicate_deleted: list[dict[str, Any]] = []
    hash_groups: dict[str, list[Path]] = {}
    for path in IMAGE_DIR.iterdir():
        if path.is_file() and path.suffix.lower() in IMAGE_EXTENSIONS:
            hash_groups.setdefault(sha256(path), []).append(path)

    for paths in hash_groups.values():
        if len(paths) < 2:
            continue
        paths.sort(key=lambda item: (len(item.name), item.name))
        canonical = paths[0]
        for duplicate in paths[1:]:
            duplicate_replacements[rel(duplicate)] = rel(canonical)

    json_files_updated += update_json_files(duplicate_replacements)

    for old_rel, new_rel in duplicate_replacements.items():
        duplicate = ROOT / old_rel
        if not duplicate.exists():
            continue
        if referenced_elsewhere(old_rel):
            retained_referenced.append(old_rel)
        else:
            size = duplicate.stat().st_size
            duplicate.unlink()
            duplicate_deleted.append({"from": old_rel, "to": new_rel, "bytes": size})

    after_files = [path for path in IMAGE_DIR.iterdir() if path.is_file()]
    after_bytes = sum(path.stat().st_size for path in after_files)
    report = {
        "settings": {"max_size": MAX_SIZE, "webp_quality": QUALITY},
        "before": {"files": len(before_files), "bytes": before_bytes},
        "after": {"files": len(after_files), "bytes": after_bytes},
        "saved_bytes": before_bytes - after_bytes,
        "converted": converted,
        "recompressed": recompressed,
        "duplicates_removed": duplicate_deleted,
        "retained_because_referenced": sorted(set(retained_referenced)),
        "json_files_updated": json_files_updated,
        "errors": errors,
    }
    REPORT_PATH.write_text(json.dumps(report, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(json.dumps({
        "before_mb": round(before_bytes / 1024 / 1024, 2),
        "after_mb": round(after_bytes / 1024 / 1024, 2),
        "saved_mb": round((before_bytes - after_bytes) / 1024 / 1024, 2),
        "converted": len(converted),
        "recompressed": len(recompressed),
        "duplicates_removed": len(duplicate_deleted),
        "retained_referenced": len(set(retained_referenced)),
        "json_files_updated": json_files_updated,
        "errors": len(errors),
    }, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
