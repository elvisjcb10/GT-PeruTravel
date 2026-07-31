from __future__ import annotations

import argparse
import json
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
AREAS = [ROOT / "data", ROOT / "lang", ROOT / "locale"]
MARKERS = ("Ã", "Â", "â", "ð", "ï")


def build_map() -> dict[str, str]:
    mapping: dict[str, str] = {}
    ranges = [(0x00A0, 0x0250), (0x2000, 0x2200), (0x1F000, 0x1FB00)]
    for start, end in ranges:
        for codepoint in range(start, end):
            char = chr(codepoint)
            raw = char.encode("utf-8")
            for encoding in ("cp1252", "latin1"):
                try:
                    broken = raw.decode(encoding)
                except UnicodeDecodeError:
                    continue
                if broken != char and any(marker in broken for marker in MARKERS):
                    mapping[broken] = char
    return dict(sorted(mapping.items(), key=lambda item: len(item[0]), reverse=True))


def repair(text: str, mapping: dict[str, str]) -> tuple[str, int]:
    total = 0
    for _ in range(3):
        changed = 0
        for broken, fixed in mapping.items():
            count = text.count(broken)
            if count:
                text = text.replace(broken, fixed)
                changed += count
        total += changed
        if not changed:
            break
    return text, total


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--apply", action="store_true")
    args = parser.parse_args()
    mapping = build_map()
    changed_files: list[tuple[str, int]] = []
    invalid: list[str] = []
    for area in AREAS:
        for path in sorted(area.rglob("*.json")):
            original = path.read_text(encoding="utf-8")
            repaired, count = repair(original, mapping)
            if not count or repaired == original:
                continue
            try:
                json.loads(repaired)
            except Exception as exc:
                invalid.append(f"{path.relative_to(ROOT).as_posix()}: {exc}")
                continue
            changed_files.append((path.relative_to(ROOT).as_posix(), count))
            if args.apply:
                path.write_text(repaired, encoding="utf-8")
    print(json.dumps({
        "mode": "apply" if args.apply else "dry-run",
        "changed_files": len(changed_files),
        "replacements": sum(count for _, count in changed_files),
        "invalid": invalid,
        "examples": changed_files[:30],
    }, ensure_ascii=False, indent=2))
    if invalid:
        raise SystemExit(2)


if __name__ == "__main__":
    main()