from pathlib import Path
import copy
import json
import re
import time
from bs4 import BeautifulSoup, NavigableString
from deep_translator import GoogleTranslator

ROOT = Path(r"C:\Users\elvis\GT-PeruTravel")
DATA = ROOT / "data" / "blog"
LANGUAGES = {"en": "english", "pt": "portuguese"}
SEPARATOR = "\n[[[GTSEP42]]]\n"
CATEGORY = {
    "en": {"Machu Picchu": "Machu Picchu", "Glaciares": "Glaciers", "GastronomÃ­a": "Gastronomy", "Cusco": "Cusco", "Consejos": "Travel tips"},
    "pt": {"Machu Picchu": "Machu Picchu", "Glaciares": "Geleiras", "GastronomÃ­a": "Gastronomia", "Cusco": "Cusco", "Consejos": "Dicas"},
}
AUTHOR = {
    "en": {
        "role": "Author Â· GT Peru Travel",
        "bio": "Content prepared by the GT Peru Travel team to help you plan a safe and authentic experience in Peru.",
        "location": "Cusco, Peru",
        "reading": "min read",
    },
    "pt": {
        "role": "Autor Â· GT Peru Travel",
        "bio": "ConteÃºdo preparado pela equipe da GT Peru Travel para ajudar vocÃª a planejar uma experiÃªncia segura e autÃªntica no Peru.",
        "location": "Cusco, Peru",
        "reading": "min de leitura",
    },
}
cache = {}

def load(path):
    return json.loads(path.read_text(encoding="utf-8"))

def save(path, data):
    path.write_text(json.dumps(data, ensure_ascii=False, indent=4), encoding="utf-8")

def translate_group(values, lang):
    values = [v for v in values]
    if not values:
        return []
    missing = [v for v in values if (lang, v) not in cache]
    if missing:
        translator = GoogleTranslator(source="es", target=lang)
        for attempt in range(5):
            try:
                joined = SEPARATOR.join(missing)
                result = translator.translate(joined)
                parts = result.split(SEPARATOR)
                if len(parts) != len(missing):
                    raise ValueError("El separador de traducciÃ³n fue alterado")
                for original, translated in zip(missing, parts):
                    cache[(lang, original)] = translated.strip()
                break
            except Exception:
                if attempt == 4:
                    for original in missing:
                        cache[(lang, original)] = translate_one(original, lang)
                    break
                time.sleep(1.5 * (attempt + 1))
    return [cache[(lang, value)] for value in values]

def translate_one(value, lang):
    if not value or not value.strip():
        return value
    key = (lang, value)
    if key in cache:
        return cache[key]
    for attempt in range(6):
        try:
            translated = GoogleTranslator(source="es", target=lang).translate(value)
            cache[key] = translated.strip()
            return cache[key]
        except Exception:
            if attempt == 5:
                raise
            time.sleep(2 * (attempt + 1))
    return value

def translate_values(values, lang, limit=3200):
    result = [""] * len(values)
    group, positions, size = [], [], 0
    for index, value in enumerate(values):
        value = value.strip()
        if not value:
            result[index] = value
            continue
        extra = len(value) + (len(SEPARATOR) if group else 0)
        if group and size + extra > limit:
            translated = translate_group(group, lang)
            for pos, text in zip(positions, translated):
                result[pos] = text
            group, positions, size = [], [], 0
        group.append(value)
        positions.append(index)
        size += extra
    if group:
        translated = translate_group(group, lang)
        for pos, text in zip(positions, translated):
            result[pos] = text
    return result

def translate_html(html, lang):
    soup = BeautifulSoup(html or "", "html.parser")
    nodes = []
    originals = []
    for node in soup.find_all(string=True):
        if node.parent and node.parent.name in {"script", "style", "code", "pre"}:
            continue
        text = str(node)
        if not text.strip():
            continue
        nodes.append(node)
        originals.append(text.strip())
    translated = translate_values(originals, lang)
    for node, text in zip(nodes, translated):
        original = str(node)
        leading = original[:len(original) - len(original.lstrip())]
        trailing = original[len(original.rstrip()):]
        node.replace_with(NavigableString(leading + text + trailing))
    for tag in soup.find_all(True):
        for attribute in ("alt", "title"):
            if tag.has_attr(attribute) and str(tag[attribute]).strip():
                tag[attribute] = translate_one(str(tag[attribute]), lang)
    return str(soup)

def translated_article(source, lang):
    article = copy.deepcopy(source)
    title = translate_one(str(source.get("title", "")), lang)
    excerpt = translate_one(str(source.get("excerpt", "")), lang)
    intro = translate_one(str(source.get("intro", "")), lang)
    article["language"] = lang
    article["title"] = title
    article["excerpt"] = excerpt
    article["intro"] = intro
    article["category"] = CATEGORY[lang].get(str(source.get("category", "")), str(source.get("category", "")))
    article["content_html"] = translate_html(str(source.get("content_html", "")), lang)
    article["toc"] = [
        {**item, "title": translate_one(str(item.get("title", "")), lang)}
        for item in source.get("toc", [])
    ]
    article["tags"] = translate_values([str(tag) for tag in source.get("tags", [])], lang)
    minutes = re.search(r"\d+", str(source.get("reading_time", "1")))
    article["reading_time"] = f"{minutes.group(0) if minutes else '1'} {AUTHOR[lang]['reading']}"
    article["author"] = {
        **source.get("author", {}),
        "role": AUTHOR[lang]["role"],
        "bio": AUTHOR[lang]["bio"],
        "location": AUTHOR[lang]["location"],
    }
    article["seo"] = {
        "title": title + " | GT Peru Travel",
        "description": excerpt,
    }
    article["machine_translated_from"] = "es"
    return article

def listing(article):
    minutes = re.search(r"\d+", str(article.get("reading_time", "1")))
    return {
        "slug": article["slug"],
        "title": article["title"],
        "category": article["category"],
        "excerpt": article["excerpt"],
        "image": article.get("hero_image", ""),
        "image_remote": article.get("hero_image_remote", ""),
        "author": article.get("author", {}).get("name", "GT Peru Travel"),
        "initials": article.get("author", {}).get("initials", "GT"),
        "date": article.get("date", ""),
        "date_iso": article.get("date_iso", ""),
        "time": (minutes.group(0) if minutes else "1") + " min",
    }


def main():
    es_index = load(DATA / "index.es.json")["posts"]
    existing_indexes = {lang: load(DATA / f"index.{lang}.json")["posts"] for lang in LANGUAGES}
    existing_by_image = {}
    for lang, posts in existing_indexes.items():
        mapping = {}
        for post in posts:
            image = post.get("image_remote", "")
            if image:
                mapping.setdefault(image, []).append(post)
        existing_by_image[lang] = mapping
    
    used = {lang: set() for lang in LANGUAGES}
    canonical = {"es": [], "en": [], "pt": []}
    groups = []
    total_missing = {"en": 0, "pt": 0}
    
    for number, es_post in enumerate(es_index, 1):
        es_path = DATA / f"{es_post['slug']}.es.json"
        es_article = load(es_path)
        group = {"es": es_article}
        image = es_post.get("image_remote", "")
    
        for lang in LANGUAGES:
            match = None
            for candidate in existing_by_image[lang].get(image, []):
                if candidate["slug"] not in used[lang]:
                    match = candidate
                    break
            generated_path = DATA / f"{es_post['slug']}.{lang}.json"
            if match:
                used[lang].add(match["slug"])
                target = load(DATA / f"{match['slug']}.{lang}.json")
            elif generated_path.exists():
                candidate = load(generated_path)
                if candidate.get("machine_translated_from") == "es":
                    target = candidate
                else:
                    target = translated_article(es_article, lang)
                    save(generated_path, target)
                    total_missing[lang] += 1
            else:
                target = translated_article(es_article, lang)
                save(generated_path, target)
                total_missing[lang] += 1
            group[lang] = target
            print(f"{number}/{len(es_index)} {lang.upper()} {target['slug']}", flush=True)
    
        translations = {lang: group[lang]["slug"] for lang in ("es", "en", "pt")}
        for lang in ("es", "en", "pt"):
            group[lang]["translations"] = translations
            save(DATA / f"{group[lang]['slug']}.{lang}.json", group[lang])
            canonical[lang].append(listing(group[lang]))
        groups.append(translations)
    
    for lang in ("es", "en", "pt"):
        canonical[lang].sort(key=lambda item: item.get("date_iso", ""), reverse=True)
        save(DATA / f"index.{lang}.json", {"language": lang, "posts": canonical[lang]})
    
    save(DATA / "translations.json", {"groups": groups})
    print("COMPLETADO " + " ".join(f"{lang.upper()}={len(canonical[lang])}" for lang in canonical), flush=True)
    print("GENERADAS " + " ".join(f"{lang.upper()}={total_missing[lang]}" for lang in total_missing), flush=True)

if __name__ == "__main__":
    main()
