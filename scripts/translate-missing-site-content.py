from concurrent.futures import ThreadPoolExecutor, as_completed
import copy
import importlib.util
import json
import re
from pathlib import Path

ROOT = Path(r"C:\Users\elvis\GT-PeruTravel")
MODULE_PATH = ROOT / "scripts" / "translate-missing-blogs.py"
spec = importlib.util.spec_from_file_location("site_translator", MODULE_PATH)
mod = importlib.util.module_from_spec(spec)
spec.loader.exec_module(mod)

SKIP_KEYS = re.compile(
    r"(?:^|_)(?:id|slug|url|link|href|src|img|image|imagen|icon|icono|video|youtube|map|mapa|"
    r"portada|archivo|file|filename|codigo|code|email|correo|phone|telefono|whatsapp|"
    r"lat|lng|altitud_numero|precio_numero|moneda|target)(?:$|_)",
    re.I,
)
PATH_VALUE = re.compile(r"^(?:https?://|mailto:|tel:|#|/|\.\.?/)|\.(?:webp|jpe?g|png|gif|svg|mp4|webm|pdf)(?:\?.*)?$", re.I)
TECH_VALUE = re.compile(r"^[\w.-]+@[\w.-]+\.[A-Za-z]{2,}$|^\+?[\d\s().-]{6,}$")

def should_translate(key, value):
    if not value or not value.strip():
        return False
    if SKIP_KEYS.search(str(key)):
        return False
    text = value.strip()
    if PATH_VALUE.search(text) or TECH_VALUE.match(text):
        return False
    if text in {"es", "en", "pt", "USD", "PEN", "GT Peru Travel", "Tripadvisor", "Facebook", "Instagram", "TikTok", "YouTube"}:
        return False
    return bool(re.search(r"[A-Za-zÁÉÍÓÚÜÑáéíóúüñ¿¡]", text))

def translate_tree(source, lang):
    data = copy.deepcopy(source)
    refs, values = [], []
    html_refs = []

    def walk(node):
        if isinstance(node, dict):
            for key, value in node.items():
                if isinstance(value, str) and should_translate(key, value):
                    if "<" in value and ">" in value:
                        html_refs.append((node, key, value))
                    else:
                        refs.append((node, key))
                        values.append(value)
                else:
                    walk(value)
        elif isinstance(node, list):
            for index, value in enumerate(node):
                if isinstance(value, str) and should_translate(index, value):
                    if "<" in value and ">" in value:
                        html_refs.append((node, index, value))
                    else:
                        refs.append((node, index))
                        values.append(value)
                else:
                    walk(value)

    walk(data)
    translated = mod.translate_values(values, lang)
    for (container, key), value in zip(refs, translated):
        container[key] = value
    for container, key, value in html_refs:
        container[key] = mod.translate_html(value, lang)
    return data

jobs = []
for lang in ("en", "pt"):
    for source in sorted((ROOT / "locale" / "es").glob("*.json")):
        if source.name.endswith("-old.json"):
            continue
        target = ROOT / "locale" / lang / source.name
        if not target.exists():
            jobs.append((source, target, lang))

    for folder in ("tours", "paquetes", "destinos"):
        source_dir = ROOT / "data" / folder
        for source in sorted(source_dir.glob("*.es.json")):
            stem = source.name[:-8]
            target = source_dir / f"{stem}.{lang}.json"
            if not target.exists():
                jobs.append((source, target, lang))

print(f"ARCHIVOS_PENDIENTES={len(jobs)}", flush=True)

def process(job):
    source, target, lang = job
    data = json.loads(source.read_text(encoding="utf-8"))
    translated = translate_tree(data, lang)
    target.write_text(json.dumps(translated, ensure_ascii=False, indent=4), encoding="utf-8")
    return lang, source.relative_to(ROOT), target.relative_to(ROOT)

with ThreadPoolExecutor(max_workers=6) as executor:
    futures = [executor.submit(process, job) for job in jobs]
    completed = 0
    for future in as_completed(futures):
        lang, source, target = future.result()
        completed += 1
        print(f"{completed}/{len(jobs)} {lang.upper()} {source} -> {target}", flush=True)

print("COMPLETADO", flush=True)
