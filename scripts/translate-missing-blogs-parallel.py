from concurrent.futures import ThreadPoolExecutor, as_completed
import importlib.util
from pathlib import Path

MODULE_PATH = Path(r"C:\Users\elvis\GT-PeruTravel\scripts\translate-missing-blogs.py")
spec = importlib.util.spec_from_file_location("blog_translator", MODULE_PATH)
mod = importlib.util.module_from_spec(spec)
spec.loader.exec_module(mod)

es_index = mod.load(mod.DATA / "index.es.json")["posts"]
existing_indexes = {lang: mod.load(mod.DATA / f"index.{lang}.json")["posts"] for lang in mod.LANGUAGES}
existing_by_image = {}
for lang, posts in existing_indexes.items():
    mapping = {}
    for post in posts:
        image = post.get("image_remote", "")
        if image:
            mapping.setdefault(image, []).append(post)
    existing_by_image[lang] = mapping

used = {lang: set() for lang in mod.LANGUAGES}
jobs = []
for es_post in es_index:
    image = es_post.get("image_remote", "")
    for lang in mod.LANGUAGES:
        match = None
        for candidate in existing_by_image[lang].get(image, []):
            if candidate["slug"] not in used[lang]:
                match = candidate
                used[lang].add(candidate["slug"])
                break
        if match:
            continue
        path = mod.DATA / f"{es_post['slug']}.{lang}.json"
        if path.exists():
            data = mod.load(path)
            if data.get("machine_translated_from") == "es":
                continue
        jobs.append((es_post, lang, path))

print(f"PENDIENTES={len(jobs)}", flush=True)

def process(job):
    es_post, lang, path = job
    source = mod.load(mod.DATA / f"{es_post['slug']}.es.json")
    translated = mod.translated_article(source, lang)
    mod.save(path, translated)
    return lang, es_post["slug"]

completed = 0
with ThreadPoolExecutor(max_workers=8) as executor:
    futures = [executor.submit(process, job) for job in jobs]
    for future in as_completed(futures):
        lang, slug = future.result()
        completed += 1
        print(f"{completed}/{len(jobs)} {lang.upper()} {slug}", flush=True)

mod.main()
