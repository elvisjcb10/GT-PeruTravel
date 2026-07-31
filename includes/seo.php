<?php
declare(strict_types=1);
if (!function_exists('seo_site_url')) {
 function seo_site_url(): string { return rtrim((string)(getenv('SITE_URL') ?: 'https://www.gtperutravel.com'), '/'); }
 function seo_absolute_url(string $path='/', array $params=[]): string { $url=seo_site_url().'/'.ltrim($path,'/'); return $url.($params?'?'.http_build_query($params,'','&',PHP_QUERY_RFC3986):''); }
 function seo_clean_text(string $value,int $limit=200): string { $value=trim((string)preg_replace('/\s+/u',' ',html_entity_decode(strip_tags($value),ENT_QUOTES|ENT_HTML5,'UTF-8'))); return mb_strlen($value)<=$limit?$value:rtrim(mb_substr($value,0,$limit-1)).'…'; }
 function seo_language_alternates(string $path,array $base=[]): array { $out=[]; foreach(['es','en','pt'] as $lang){$out[$lang]=['path'=>$path,'params'=>array_merge($base,['lang'=>$lang])];} return $out; }
 function seo_render(array $o): void {
  $title=seo_clean_text((string)($o['title']??'GT Peru Travel'),65); $description=seo_clean_text((string)($o['description']??''),160);
  $path=(string)($o['path']??'/'); $params=(array)($o['params']??[]); $canonical=seo_absolute_url($path,$params); $lang=(string)($o['language']??'es');
  $image=(string)($o['image']??'/images/gt-peru-travel.png'); $image=preg_match('~^https?://~i',$image)?$image:seo_absolute_url($image);
  $type=(string)($o['type']??'website'); $alternates=(array)($o['alternates']??[]);
  echo "\n<link rel=\"canonical\" href=\"".htmlspecialchars($canonical,ENT_QUOTES,'UTF-8')."\">\n";
  foreach($alternates as $code=>$alt){if(!is_array($alt))continue;$href=seo_absolute_url((string)($alt['path']??$path),(array)($alt['params']??[]));echo '<link rel="alternate" hreflang="'.htmlspecialchars((string)$code,ENT_QUOTES,'UTF-8').'" href="'.htmlspecialchars($href,ENT_QUOTES,'UTF-8')."\">\n";}
  if($alternates){$default=$alternates['es']??reset($alternates);$href=seo_absolute_url((string)($default['path']??$path),(array)($default['params']??[]));echo '<link rel="alternate" hreflang="x-default" href="'.htmlspecialchars($href,ENT_QUOTES,'UTF-8')."\">\n";}
  $robots=(string)($o['robots']??'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1');
  $tags=[['name','robots',$robots],['property','og:type',$type==='article'?'article':'website'],['property','og:site_name','GT Peru Travel'],['property','og:locale',['es'=>'es_PE','en'=>'en_US','pt'=>'pt_BR'][$lang]??'es_PE'],['property','og:title',$title],['property','og:description',$description],['property','og:url',$canonical],['property','og:image',$image],['name','twitter:card','summary_large_image'],['name','twitter:title',$title],['name','twitter:description',$description],['name','twitter:image',$image]];
  foreach($tags as [$key,$name,$content])echo '<meta '.$key.'="'.htmlspecialchars($name,ENT_QUOTES,'UTF-8').'" content="'.htmlspecialchars($content,ENT_QUOTES,'UTF-8')."\">\n";
  $org=['@type'=>['TravelAgency','LocalBusiness'],'@id'=>seo_site_url().'/#organization','name'=>'GT Peru Travel','url'=>seo_site_url().'/','logo'=>seo_absolute_url('/images/gt-peru-travel.png'),'telephone'=>'+51987370201','email'=>'info@gtperutravel.com','priceRange'=>'$$','address'=>['@type'=>'PostalAddress','streetAddress'=>'Asociación D-9, Huancaro','addressLocality'=>'Cusco','addressRegion'=>'Cusco','addressCountry'=>'PE'],'areaServed'=>['@type'=>'Country','name'=>'Peru']];
  $page=['@type'=>$type==='article'?'Article':'WebPage','@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$title,'description'=>$description,'inLanguage'=>$lang,'isPartOf'=>['@id'=>seo_site_url().'/#website'],'primaryImageOfPage'=>['@type'=>'ImageObject','url'=>$image]];
  if($type==='article'){$page['headline']=$title;$page['image']=[$image];$page['author']=['@id'=>seo_site_url().'/#organization'];$page['publisher']=['@id'=>seo_site_url().'/#organization'];if(!empty($o['date_published']))$page['datePublished']=$o['date_published'];if(!empty($o['date_modified']))$page['dateModified']=$o['date_modified'];}
  $graph=[['@type'=>'WebSite','@id'=>seo_site_url().'/#website','url'=>seo_site_url().'/','name'=>'GT Peru Travel','publisher'=>['@id'=>seo_site_url().'/#organization'],'inLanguage'=>['es','en','pt']],$org,$page];
  if($path!=='/' && $path!==''){$homeNames=['es'=>'Inicio','en'=>'Home','pt'=>'Início'];$graph[]=['@type'=>'BreadcrumbList','@id'=>$canonical.'#breadcrumb','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>$homeNames[$lang]??'Inicio','item'=>seo_absolute_url(route_static_path('home',$lang))],['@type'=>'ListItem','position'=>2,'name'=>$title,'item'=>$canonical]]];}
  if(($o['schema_type']??'')==='TouristTrip'){$graph[]=['@type'=>'TouristTrip','@id'=>$canonical.'#trip','name'=>$title,'description'=>$description,'image'=>$image,'url'=>$canonical,'provider'=>['@id'=>seo_site_url().'/#organization'],'touristType'=>(string)($o['tourist_type']??'Cultural tourism')];}
  $schema=['@context'=>'https://schema.org','@graph'=>$graph];
  echo '<script type="application/ld+json">'.json_encode($schema,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."</script>\n";
 }
}
