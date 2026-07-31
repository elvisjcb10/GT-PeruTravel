from __future__ import annotations

import json
import re
from datetime import datetime, timezone
from pathlib import Path
from urllib.parse import unquote, urlsplit

ROOT = Path(__file__).resolve().parents[1]
SITEMAP = ROOT / "sitemap.xml"
ROUTES = json.loads((ROOT / "data/routes.json").read_text(encoding="utf-8"))["types"]
SECTION_MAP = {
    "tours": ("tour", ROOT / "data/tours"),
    "paquetes": ("paquete", ROOT / "data/paquetes"),
    "destinos": ("destino", ROOT / "data/destinos"),
    "blog": ("blog", ROOT / "data/blog"),
}
STATIC_FILES = {"": "index.php", "blog": "blog.php", "contacto": "contacto.php", "nosotros": "nosotros.php"}


def iso_date(value: object) -> str | None:
    if not isinstance(value, str) or not value.strip():
        return None
    text = value.strip().replace("Z", "+00:00")
    try:
        return datetime.fromisoformat(text).date().isoformat()
    except ValueError:
        for fmt in ("%Y-%m-%d", "%d/%m/%Y", "%d %b %Y"):
            try:
                return datetime.strptime(text, fmt).date().isoformat()
            except ValueError:
                pass
    return None


def file_date(path: Path) -> str:
    return datetime.fromtimestamp(path.stat().st_mtime, tz=timezone.utc).date().isoformat()


def lastmod(url: str) -> str:
    segments = [unquote(part) for part in urlsplit(url).path.strip("/").split("/") if part]
    if not segments:
        return file_date(ROOT / "index.php")
    lang = segments[0]
    if len(segments) == 1:
        return file_date(ROOT / "index.php")
    section = segments[1]
    if len(segments) == 2 and section in STATIC_FILES:
        return file_date(ROOT / STATIC_FILES[section])
    if section == "legal" and len(segments) == 3:
        return file_date(ROOT / f"lang/legal-{lang}.json")
    if section in SECTION_MAP and len(segments) == 3:
        route_type, directory = SECTION_MAP[section]
        internal = ROUTES.get(route_type, {}).get(lang, {}).get("public_to_internal", {}).get(segments[2])
        if internal:
            path = directory / f"{internal}.{lang}.json"
            if path.exists():
                if route_type == "blog":
                    data = json.loads(path.read_text(encoding="utf-8"))
                    for key in ("modified_iso", "date_modified", "date_iso", "date"):
                        parsed = iso_date(data.get(key))
                        if parsed:
                            return parsed
                return file_date(path)
    return file_date(ROOT / "router.php")


text = SITEMAP.read_text(encoding="utf-8")
pattern = re.compile(r"(<url>\s*<loc>([^<]+)</loc>)(?:\s*<lastmod>[^<]+</lastmod>)?", re.I)
count = 0


def inject(match: re.Match[str]) -> str:
    global count
    count += 1
    return f"{match.group(1)}\n    <lastmod>{lastmod(match.group(2))}</lastmod>"

updated = pattern.sub(inject, text)
SITEMAP.write_text(updated, encoding="utf-8")
print(json.dumps({"urls": count, "lastmod": updated.count("<lastmod>")}, indent=2))