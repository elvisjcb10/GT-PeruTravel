from __future__ import annotations
import io, json, re, sys, urllib.parse, urllib.request
from pathlib import Path
from typing import Any
from PIL import Image, ImageFile, ImageOps

ImageFile.LOAD_TRUNCATED_IMAGES = True
ROOT=Path(__file__).resolve().parents[1]
DATA=ROOT/'data/blog'
IMAGES=ROOT/'images/blog/posts'

def walk(value: Any, replacements: dict[str,str]) -> Any:
    if isinstance(value,str):
        for old,new in replacements.items(): value=value.replace(old,new)
        return value
    if isinstance(value,list): return [walk(x,replacements) for x in value]
    if isinstance(value,dict): return {k:walk(v,replacements) for k,v in value.items()}
    return value

sources={}
for path in DATA.glob('*.json'):
    data=json.loads(path.read_text(encoding='utf-8'))
    local=data.get('hero_image','')
    remote=data.get('hero_image_remote','')
    if local and remote:
        target=ROOT/local
        invalid=not target.exists()
        if target.exists():
            try:
                with Image.open(target) as image: image.verify()
            except Exception: invalid=True
        if invalid: sources[local]=remote

replacements={}; failures=[]
for old,remote in sorted(sources.items()):
    target=(ROOT/old).with_suffix('.webp')
    try:
        parts=urllib.parse.urlsplit(remote)
        safe_remote=urllib.parse.urlunsplit((parts.scheme,parts.netloc,urllib.parse.quote(urllib.parse.unquote(parts.path),safe='/'),urllib.parse.quote_plus(urllib.parse.unquote_plus(parts.query),safe='=&'),parts.fragment))
        request=urllib.request.Request(safe_remote,headers={'User-Agent':'Mozilla/5.0 GT-PeruTravel image optimizer'})
        with urllib.request.urlopen(request,timeout=30) as response: raw=response.read()
        with Image.open(io.BytesIO(raw)) as image:
            image=ImageOps.exif_transpose(image)
            image.thumbnail((1920,1920),Image.Resampling.LANCZOS)
            if image.mode not in {'RGB','RGBA'}: image=image.convert('RGB')
            image.save(target,'WEBP',quality=82,method=6,optimize=True)
        with Image.open(target) as check: check.verify()
        replacements[old]=target.relative_to(ROOT).as_posix()
        old_path=ROOT/old
        if old_path.exists() and old_path != target: old_path.unlink()
    except Exception as exc:
        failures.append({'file':old,'url':remote,'error':str(exc)})

updated=0
for path in DATA.glob('*.json'):
    data=json.loads(path.read_text(encoding='utf-8'))
    changed=walk(data,replacements)
    if changed != data:
        path.write_text(json.dumps(changed,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
        updated+=1
report={'repaired':replacements,'updated_json_files':updated,'failures':failures}
(ROOT/'scripts/image-repair-report.json').write_text(json.dumps(report,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
sys.stdout.buffer.write((json.dumps({'requested':len(sources),'repaired':len(replacements),'updated_json_files':updated,'failures':failures},ensure_ascii=False,indent=2)+'\\n').encode('utf-8'))
