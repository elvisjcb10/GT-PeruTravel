<?php
declare(strict_types=1);
function route_map(): array {
 static $routes=null;if($routes!==null)return $routes;
 $file=dirname(__DIR__).'/data/routes.json';
 $routes=is_file($file)?(json_decode(file_get_contents($file),true)['types']??[]):[];
 return $routes;
}
function route_public_slug(string $type,string $language,string $internal): ?string {
 return route_map()[$type][$language]['internal_to_public'][$internal]??null;
}
function route_internal_slug(string $type,string $language,string $public): ?string {
 return route_map()[$type][$language]['public_to_internal'][$public]??null;
}
function route_path(string $type,string $language,string $internal): string {
 $prefix=['tour'=>'tours','paquete'=>'paquetes','destino'=>'destinos','blog'=>'blog'][$type]??$type;
 $slug=route_public_slug($type,$language,$internal)??$internal;
 return '/'.$language.'/'.$prefix.'/'.rawurlencode($slug).'/';
}
function route_static_path(string $page,string $language): string {
 $paths=['home'=>'','blog'=>'blog/','contacto'=>'contacto/','nosotros'=>'nosotros/'];
 return '/'.$language.'/'.($paths[$page]??trim($page,'/').'/');
}
function route_alternates(string $type,string $internal): array {
 $items=[];foreach(['es','en','pt'] as $lang){if(route_public_slug($type,$lang,$internal)!==null)$items[$lang]=['path'=>route_path($type,$lang,$internal),'params'=>[]];}return $items;
}
function route_legal_path(string $document,string $language): string { $slug=route_public_slug('legal',$language,$document)??str_replace('_','-',trim($document,'/'));return '/'.$language.'/legal/'.$slug.'/'; }
function route_legal_alternates(string $document): array { $items=[];foreach(['es','en','pt'] as $lang)$items[$lang]=['path'=>route_legal_path($document,$lang),'params'=>[]];return $items; }
function route_static_alternates(string $page,array $params=[]): array {
 $items=[];foreach(['es','en','pt'] as $lang)$items[$lang]=['path'=>route_static_path($page,$lang),'params'=>$params];return $items;
}
function route_blog_alternates(string $internal,string $language): array {
 $slugs=[$language=>$internal];$file=dirname(__DIR__).'/data/blog/translations.json';$groups=is_file($file)?(json_decode(file_get_contents($file),true)['groups']??[]):[];
 foreach($groups as $group){if(in_array($internal,$group,true)){foreach(['es','en','pt'] as $lang)if(!empty($group[$lang]))$slugs[$lang]=(string)$group[$lang];break;}}
 $items=[];foreach($slugs as $lang=>$slug)if(route_public_slug('blog',$lang,$slug)!==null)$items[$lang]=['path'=>route_path('blog',$lang,$slug),'params'=>[]];return $items;
}
function route_content_url(string $url,string $language): string {
 $decoded=html_entity_decode($url,ENT_QUOTES|ENT_HTML5,'UTF-8');$parts=parse_url($decoded);$path=(string)($parts['path']??'');parse_str((string)($parts['query']??''),$query);
 if(isset($query['tour']))return route_path('tour',$language,(string)$query['tour']);
 if(isset($query['paquete']))return route_path('paquete',$language,(string)$query['paquete']);
 if(isset($query['destino']))return route_path('destino',$language,(string)$query['destino']);
 if(isset($query['articulo']))return route_path('blog',$language,(string)$query['articulo']);
 if(isset($query['doc']))return route_legal_path((string)$query['doc'],$language);
 if(str_contains($path,'blog.php'))return route_static_path('blog',$language);
 if(str_contains($path,'contacto.php'))return route_static_path('contacto',$language);
 if(str_contains($path,'nosotros.php'))return route_static_path('nosotros',$language);
 if($path===''||$path==='/'||str_ends_with($path,'index.php'))return route_static_path('home',$language);
 return '/'.ltrim($decoded,'/');
}
function route_language_switch(string $target): string {
 $current=(string)($GLOBALS['lang']??($_GET['lang']??'es'));
 foreach(['tour'=>['tour','tour'],'paquete'=>['paquete','paquete'],'destino'=>['destino','destino']] as $key=>$info){if(!empty($_GET[$key])&&route_public_slug($info[0],$target,(string)$_GET[$key])!==null)return route_path($info[0],$target,(string)$_GET[$key]);}
 if(!empty($_GET['articulo'])){$alts=route_blog_alternates((string)$_GET['articulo'],$current);return $alts[$target]['path']??route_static_path('blog',$target);}
 $path=parse_url((string)($_SERVER['REQUEST_URI']??''),PHP_URL_PATH)?:'';
 if(str_contains($path,'blog'))return route_static_path('blog',$target);
 if(str_contains($path,'contacto'))return route_static_path('contacto',$target);
 if(str_contains($path,'nosotros'))return route_static_path('nosotros',$target);
 return route_static_path('home',$target);
}
function route_redirect_static(string $page,string $language): void {
 if(PHP_SAPI==='cli')return;$requestPath=parse_url((string)($_SERVER['REQUEST_URI']??''),PHP_URL_PATH)?:'';
 if($requestPath==='/'||str_ends_with($requestPath,'.php')){header('Location: '.route_static_path($page,$language),true,301);exit;}
}
function route_redirect_legacy(string $type,string $language,string $internal): void {
 if(PHP_SAPI==='cli')return;
 $requestPath=parse_url((string)($_SERVER['REQUEST_URI']??''),PHP_URL_PATH)?:'';
 if(!str_ends_with($requestPath,'.php'))return;
 header('Location: '.route_path($type,$language,$internal),true,301);exit;
}
