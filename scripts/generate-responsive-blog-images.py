from __future__ import annotations
import json,re
from pathlib import Path
from PIL import Image,ImageOps
ROOT=Path(__file__).resolve().parents[1]
IMAGE_DIR=ROOT/'images/blog/content'
DATA_DIR=ROOT/'data/blog'
SIZES=(640,1024)
variants={};created=[]
for source in sorted(IMAGE_DIR.glob('*.webp')):
    with Image.open(source) as image:
        image=ImageOps.exif_transpose(image)
        width,height=image.size
        items=[]
        for target_width in SIZES:
            if width<=target_width: continue
            target=source.with_name(f'{source.stem}-{target_width}.webp')
            if not target.exists():
                resized=image.copy();resized.thumbnail((target_width,10000),Image.Resampling.LANCZOS)
                resized.save(target,'WEBP',quality=76,method=6,optimize=True)
                created.append(target.relative_to(ROOT).as_posix())
            items.append((target.relative_to(ROOT).as_posix(),target_width))
        items.append((source.relative_to(ROOT).as_posix(),width))
        variants[source.relative_to(ROOT).as_posix()]=items
img_re = re.compile(
    r"<img\b([^>]*?)\bsrc=([`'\"])(images/blog/content/[a-zA-Z0-9._-]+\.webp)\2([^>]*)>",
    re.I | re.S,
)
updated=0
def enhance(match:re.Match[str])->str:
    before,quote,src,after=match.groups()
    if 'srcset=' in (before+after).lower() or src not in variants:return match.group(0)
    candidates=[];seen=set()
    for path,width in variants[src]:
        if width not in seen:candidates.append(f'{path} {width}w');seen.add(width)
    return f'<img{before}src={quote}{src}{quote} srcset={quote}{", ".join(candidates)}{quote} sizes={quote}(max-width: 768px) 100vw, 900px{quote}{after}>'
for path in DATA_DIR.glob('*.json'):
    data=json.loads(path.read_text(encoding='utf-8'))
    html=data.get('content_html')
    if not isinstance(html,str):continue
    changed=img_re.sub(enhance,html)
    if changed!=html:
        data['content_html']=changed
        path.write_text(json.dumps(data,ensure_ascii=False,indent=2)+'\n',encoding='utf-8');updated+=1
report={'source_images':len(variants),'created_variants':len(created),'json_files_updated':updated,'variant_bytes':sum((ROOT/p).stat().st_size for p in created)}
(ROOT/'scripts/responsive-blog-images-report.json').write_text(json.dumps(report,indent=2)+'\n',encoding='utf-8')
print(json.dumps(report,indent=2))
