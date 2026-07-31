from concurrent.futures import ThreadPoolExecutor, as_completed
import importlib.util
import json
from pathlib import Path

ROOT = Path(r"C:\Users\elvis\GT-PeruTravel")
module_path = ROOT / "scripts" / "translate-missing-site-content.py"
spec = importlib.util.spec_from_file_location("site_translation", module_path)
site = importlib.util.module_from_spec(spec)
spec.loader.exec_module(site)

def merge_missing(source, target, lang):
    changed = False
    if isinstance(source, dict) and isinstance(target, dict):
        for key, value in source.items():
            if key not in target:
                target[key] = site.translate_tree({"value": value}, lang)["value"]
                changed = True
            else:
                changed = merge_missing(value, target[key], lang) or changed
    elif isinstance(source, list) and isinstance(target, list):
        for index, value in enumerate(source):
            if index >= len(target):
                target.append(site.translate_tree({"value": value}, lang)["value"])
                changed = True
            else:
                changed = merge_missing(value, target[index], lang) or changed
    return changed

jobs = []
for lang in ("en", "pt"):
    for source in sorted((ROOT / "locale" / "es").glob("*.json")):
        if source.name.endswith("-old.json"):
            continue
        target = ROOT / "locale" / lang / source.name
        if target.exists():
            jobs.append((source, target, lang))
    for folder in ("tours", "paquetes", "destinos"):
        for source in sorted((ROOT / "data" / folder).glob("*.es.json")):
            stem = source.name[:-8]
            target = ROOT / "data" / folder / f"{stem}.{lang}.json"
            if target.exists():
                jobs.append((source, target, lang))

def process(job):
    source_path, target_path, lang = job
    source = json.loads(source_path.read_text(encoding="utf-8"))
    target = json.loads(target_path.read_text(encoding="utf-8"))
    changed = merge_missing(source, target, lang)
    if changed:
        target_path.write_text(json.dumps(target, ensure_ascii=False, indent=4), encoding="utf-8")
    return changed, target_path.relative_to(ROOT)

changed_count = 0
with ThreadPoolExecutor(max_workers=6) as executor:
    futures = [executor.submit(process, job) for job in jobs]
    for future in as_completed(futures):
        changed, path = future.result()
        if changed:
            changed_count += 1
            print(f"ACTUALIZADO {path}", flush=True)
print(f"ARCHIVOS_ACTUALIZADOS={changed_count}", flush=True)
