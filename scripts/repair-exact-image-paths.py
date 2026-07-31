from __future__ import annotations
import json,re
from pathlib import Path
ROOT=Path(__file__).resolve().parents[1]
IMG=ROOT/'images'
EXT={'.jpg','.jpeg','.png','.webp','.avif','.gif','.svg'}
files=[p for p in IMG.rglob('*') if p.is_file() and p.suffix.lower() in EXT]
by_name={}
for p in files:by_name.setdefault(p.name.lower(),[]).append(p)
explicit={
'images/nosotros/fondo-alianzas.webp':'images/inicio/bg-licencias.webp',
'images/experiencias_unicas/experiencias-hero.webp':'images/experiencias_unicas/principal.webp',
'images/paquetes/paquetes-hero.webp':'images/paquetes.jpg',
'images/city-tour/city-tour-cover.jpg':'images/tours/cusco/city-tour/card.webp',
'images/valle-sagrado/valle-sagrado-cover.jpg':'images/tours/valle-sagrado-card.jpg',
'images/valle-sur/valle-sur-cover.jpg':'images/tours/valle-sagrado-card.jpg',
'images/humantay-cover.jpg':'images/tours/laguna-humantay-card.jpg',
'images/vinicunca-cover.jpg':'images/tours/montana-de-7-colores-card.jpg',
'images/manu-nacional-park-cover.jpg':'images/tours/manu/manu3d/hero.webp',
'images/waqrapukara-card.jpg':'images/tours/waqrapukara-card.jpg',
'images/quelccaya/img_header.webp':'images/tours/glaciares/quelccaya/img_header.webp',
'images/quelccaya/quelccaya-fd/hero.webp':'images/tours/glaciares/quelccaya/hero.webp',
'images/maras_pachamanca/img_header.webp':'images/experiencias_unicas/maras_pachamanca/img_header.webp',
'images/misticas/img_header.webp':'images/experiencias_unicas/misticas/img_header.webp',
'images/pachamanca/img_header.webp':'images/experiencias_unicas/pachamanca/img_header.webp',
'images/ritual_andino/img_header.webp':'images/experiencias_unicas/ritual_andino/img_header.webp'}
for n in range(1,7):
 explicit[f'images/tours/quelccaya/quelccaya-fd/galeria{n}.webp']=f'images/tours/glaciares/quelccaya/galeria{n}.webp'
 explicit[f'images/tours/ausangate/glaciares-fd/galeria{n}.webp']='images/tours/glaciares/ausangate/hero.webp'
 explicit[f'images/tours/city-tour/city-tour-md/galeria{n}.webp']='images/tours/cusco/city-tour/card.webp'
 explicit[f'images/tours/manu/manu3d/galeria{n}.webp']='images/tours/manu/manu3d/hero.webp'
 explicit[f'images/tours/mistico/mistico-fd/galeria{n}.webp']='images/experiencias_unicas/misticas/img_header.webp'
rx=re.compile(r'/?images/[A-Za-z0-9_./%+ -]+\.(?:jpe?g|png|webp|avif|gif|svg)',re.I)
changed=0;mapping={}
for pattern in ('*.php','*.json','*.css','*.js','*.html'):
 for path in ROOT.rglob(pattern):
  if any(x in path.parts for x in ('.git','.agents','.codex')):continue
  try:text=path.read_text(encoding='utf-8')
  except:continue
  def fix(m):
   raw=m.group(0);lead='/' if raw.startswith('/') else '';src=raw.lstrip('/')
   if (ROOT/src).is_file():return raw
   target=explicit.get(src)
   if not target:
    candidates=by_name.get(Path(src).name.lower(),[])
    if len(candidates)==1:target=candidates[0].relative_to(ROOT).as_posix()
   if target and (ROOT/target).is_file():mapping[src]=target;return lead+target
   return raw
  out=rx.sub(fix,text)
  if out!=text:path.write_text(out,encoding='utf-8',newline='\n');changed+=1
report={'changed_files':changed,'repaired_paths':len(mapping),'mapping':dict(sorted(mapping.items()))}
(ROOT/'scripts/exact-image-path-repair-report.json').write_text(json.dumps(report,indent=2)+'\n',encoding='utf-8')
print(json.dumps({'changed_files':changed,'repaired_paths':len(mapping)},indent=2))