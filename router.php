<?php
declare(strict_types=1);
$root=__DIR__;$path=rawurldecode(parse_url((string)($_SERVER['REQUEST_URI']??'/'),PHP_URL_PATH)?:'/');
if ($path === '/') {
    $_GET['lang'] = 'es';
    require $root . '/index.php';
    return true;
}
if ($path === '/es' || $path === '/es/') {
    header('Location: /', true, 301);
    return true;
}
$blocked = preg_match('~^/(?:\.git(?:/|$)|\.env(?:\..*)?$|error_log$|config(?:/|$)|data(?:/|$)|includes(?:/|$)|lang(?:/|$)|locale(?:/|$)|scripts(?:/|$))~i', $path) === 1;
if ($blocked) {
    http_response_code(404);
    require $root . '/404.php';
    return true;
}
$file=realpath($root.$path);if($file&&is_file($file)&&str_starts_with($file,$root)){return false;}
require_once $root.'/config/bootstrap.php';
$segments=array_values(array_filter(explode('/',trim($path,'/')),'strlen'));
$lang=$segments[0]??'';if(!in_array($lang,['es','en','pt'],true)){http_response_code(404);require $root.'/404.php';return true;}
$_GET['lang']=$lang;
$pathAliases = [
    '/pt/blog/cusco-subterraneo-e-misterioso-descubra-o-que-poucos-viajantes-ousam-explorar-em-2026/' => '/pt/blog/cusco-subterraneo-e-misterioso-descubra-o-que-poucos-viajantes-se-atrevem-a-explorar-em-2026/',
    '/en/blog/sacred-valley-of-the-incas-must-see-places-prices-and-how-to-plan-your-day-from-cusco/' => '/en/blog/sacred-valley-of-the-incas-must-see-places-prices-and-how-to-organize-your-day-from-cusco/',
];
if (isset($pathAliases[$path])) {
    header('Location: ' . $pathAliases[$path], true, 301);
    return true;
}
if(count($segments)===1){require $root.'/index.php';return true;}
$section=$segments[1]??'';
if(count($segments)===2){$static=['blog'=>'blog.php','contacto'=>'contacto.php','nosotros'=>'nosotros.php'];if(isset($static[$section])){require $root.'/'.$static[$section];return true;}}
if(count($segments)===3){
 if($section==='legal'){$internal=route_internal_slug('legal',$lang,$segments[2]);if($internal){$_GET['doc']=$internal;require $root.'/legal.php';return true;}}
 $types=['tours'=>['tour','tour','tour/template-tour.php'],'paquetes'=>['paquete','paquete','paquete/template-paquete.php'],'destinos'=>['destino','destino','destino/template-destino.php'],'blog'=>['blog','articulo','blog/template-articulo.php']];
 if(isset($types[$section])){[$type,$key,$template]=$types[$section];$internal=route_internal_slug($type,$lang,$segments[2]);if($internal){$_GET[$key]=$internal;require $root.'/'.$template;return true;}}
}
http_response_code(404);require $root.'/404.php';return true;
