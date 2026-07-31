from __future__ import annotations
import json
from pathlib import Path
from PIL import Image, ImageFile
ImageFile.LOAD_TRUNCATED_IMAGES = True
ROOT=Path(__file__).resolve().parents[1]
folders=[ROOT/'images',ROOT/'assets']
extensions={'.jpg','.jpeg','.png','.webp','.gif','.avif'}
dimensions={}
errors=[]
for folder in folders:
    for path in folder.rglob('*'):
        if not path.is_file() or path.suffix.lower() not in extensions:
            continue
        try:
            with Image.open(path) as image:
                dimensions['/'+path.relative_to(ROOT).as_posix()]=[int(image.width),int(image.height)]
        except Exception as exc:
            errors.append({'file':path.relative_to(ROOT).as_posix(),'error':str(exc)})
out=ROOT/'data/image-dimensions.json'
out.write_text(json.dumps(dimensions,ensure_ascii=False,separators=(',',':'))+'\n',encoding='utf-8')
print(json.dumps({'images':len(dimensions),'errors':errors,'bytes':out.stat().st_size},ensure_ascii=False,indent=2))