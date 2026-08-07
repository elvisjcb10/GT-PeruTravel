<?php require_once __DIR__ . '/config/bootstrap.php'; ?>
<?php
// para cargar promociones
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$GLOBALS['lang'] = $idioma;
route_redirect_static('home', $idioma);
$site_meta = [
    'es' => [
        'title' => 'GT Peru Travel | Tours a Machu Picchu, Cusco y experiencias únicas en Perú',
        'description' => 'Descubre tours en Cusco y Machu Picchu con GT Peru Travel, operador turístico local. Vive experiencias auténticas con guías expertos en Perú.',
        'keywords' => 'tours a Machu Picchu, tours en Cusco, viajes a Perú, paquetes turísticos',
    ],

    'en' => [
        'title' => 'GT Peru Travel | Cusco & Machu Picchu Tours in Peru',
        'description' => 'Discover Cusco and Machu Picchu tours with GT Peru Travel, a local tour operator. Enjoy authentic experiences with expert guides in Peru.',
        'keywords' => 'Machu Picchu tours, Cusco tours, Peru travel, Peru tour packages',
    ],

    'pt' => [
        'title' => 'GT Peru Travel | Passeios em Cusco e Machu Picchu no Peru',
        'description' => 'Descubra Cusco e Machu Picchu com a GT Peru Travel, operadora de turismo local. Viva experiências autênticas com guias especializados no Peru.',
        'keywords' => 'passeios em Machu Picchu, passeios em Cusco, viagens ao Peru, pacotes turísticos',
    ],
][$idioma];
$site_ui = [
    'es' => ['from' => 'desde'],
    'en' => ['from' => 'from'],
    'pt' => ['from' => 'a partir de'],
][$idioma];

$json = file_get_contents(__DIR__ . "/promotions/promotions.json");
$promotions = json_decode($json, true)['promotions'];
?>

<!-- section hero / home .jon-->
 <?php 
 $hero = file_get_contents(__DIR__ . "/locale/$idioma/hero.json");
 $hero_text = json_decode($hero, true);
 ?>
<!-- SECTION VIDOE .JSON -->
<?php
$video_json = file_get_contents(__DIR__ . "/locale/$idioma/video.json");
$video_text = json_decode($video_json, true);
?>

<!-- SECTION ABOUT .JSON -->
<?php
$about_file = __DIR__ . "/locale/$idioma/about.json";
$about_json = file_get_contents($about_file);
$about_text = json_decode($about_json, true);
?>
<!-- SECTION destinos .JSON -->
<!-- SECTION destinos .JSON -->
<?php
$destinos_json = file_get_contents(__DIR__ . "/locale/$idioma/destinos.json");
$destinos = json_decode($destinos_json, true);
?>
<!-- SECTION GLACIARES .JSON -->
<?php
$glaciares_json = file_get_contents(__DIR__ . "/locale/$idioma/glaciares.json");
$glaciares = json_decode($glaciares_json, true);
?>
<!-- SECTION TITULO EXPERIENCIAS .JSON -->
<?php
$exp_title_json = file_get_contents(__DIR__ . "/locale/$idioma/experiencias_title.json");
$experiencias_text = json_decode($exp_title_json, true);
?>

<!-- SECTION EXPERIENCIAS .JSON -->
<?php
$exp_json = file_get_contents(__DIR__ . "/locale/$idioma/experiencias.json");
$exp_all = json_decode($exp_json, true);
$experiencias = $exp_all["cards"];
?>
<!-- SECTION TRIPADVISOR .JSON -->
<?php
$trip_file = __DIR__ . "/locale/$idioma/tripadvisor.json";
$trip_json = file_get_contents($trip_file);
$trip_text = json_decode($trip_json, true);
?>

<!-- SECTION POPULAR PACKAGES TEXT .JSON -->
<?php
$popular_json = file_get_contents(__DIR__ . "/locale/$idioma/popular_packages_text.json");
$popular_text = json_decode($popular_json, true);
?>

<!-- SECTION PAQUETES .JSON -->
<?php
$packages_json = file_get_contents(__DIR__ . "/locale/$idioma/packages.json");
$packages_text = json_decode($packages_json, true);
?>

<!-- SECTION PAQUETES_TARJETAS .JSON -->
<?php
$cards_json = file_get_contents(__DIR__ . "/locale/$idioma/packages_cards.json");
$cards_all = json_decode($cards_json, true);
$localized_cards = $cards_all["cards"] ?? [];
$cards_by_slug = [];
foreach ($localized_cards as $localized_card) {
    $card_slug = (string) ($localized_card['url'] ?? '');
    if ($card_slug !== '' && !isset($cards_by_slug[$card_slug])) {
        $cards_by_slug[$card_slug] = $localized_card;
    }
}

$cards = [];
$packages_destination_path = __DIR__ . "/data/destinos/paquete-peru.$idioma.json";
$packages_destination = is_file($packages_destination_path)
    ? json_decode(file_get_contents($packages_destination_path), true)
    : ['tours' => []];

foreach ($packages_destination['tours'] ?? [] as $destination_package) {
    $package_slug = (string) ($destination_package['url'] ?? '');
    if ($package_slug === '' || ($destination_package['tipo'] ?? 'paquete') !== 'paquete') {
        continue;
    }

    $existing_card = $cards_by_slug[$package_slug] ?? [];
    $cards[] = array_replace([
        'title' => (string) ($destination_package['title'] ?? $package_slug),
        'subtitle' => (string) ($destination_package['duracion'] ?? ''),
        'ubicacion' => '',
        'max_personas' => '12',
        'categorias' => !empty($destination_package['categoria'])
            ? [(string) $destination_package['categoria']]
            : [],
        'description' => (string) ($destination_package['description'] ?? ''),
        'price' => (string) ($destination_package['price'] ?? ''),
        'moneda' => 'USD',
        'image' => (string) ($destination_package['image'] ?? 'paquetes/peru-magico.jpg'),
        'url' => $package_slug,
        'reservar' => [
            'es' => 'VER PAQUETE',
            'en' => 'VIEW PACKAGE',
            'pt' => 'VER PACOTE',
        ][$idioma],
    ], $existing_card);
}
?>
<!-- SECTION VIDEOS TESTIMONIALES .JSON -->
<?php
$videos_json = file_get_contents(__DIR__ . "/locale/$idioma/videos_testimoniales.json");
$videos_test = json_decode($videos_json, true);
?>
<!-- SECTION CTA AVENTURA .JSON -->
<?php
$cta_json = file_get_contents(__DIR__ . "/locale/$idioma/cta_aventura.json");
$cta = json_decode($cta_json, true);
?>
<!-- SECTION TITULO BLOG .JSON -->
<?php
$blog_title_json = file_get_contents(__DIR__ . "/locale/$idioma/blog_title.json");
$blog_text = json_decode($blog_title_json, true);
?>
<!-- SECTION RECONOCIMIENTOS .JSON -->
<?php
$reconocimientos_json = file_get_contents(__DIR__ . "/locale/$idioma/reconocimientos.json");
$reconocimientos = json_decode($reconocimientos_json, true);
?>
<!-- SECTION BLOG POSTS .JSON -->
<?php
$blog_posts_json = file_get_contents(__DIR__ . "/locale/$idioma/blog_posts.json");
$blog_all = json_decode($blog_posts_json, true);
$legacy_blog_posts = $blog_all["posts"] ?? [];
$blog_read_label = $legacy_blog_posts[0]['link_text'] ?? [
    'es' => 'Leer artículo',
    'en' => 'Read article',
    'pt' => 'Ler artigo',
][$idioma];

$blog_index_path = __DIR__ . "/data/blog/index.$idioma.json";
$blog_index = is_file($blog_index_path)
    ? json_decode(file_get_contents($blog_index_path), true)
    : ['posts' => []];

$blog_posts = array_map(static function (array $post) use ($blog_read_label): array {
    $image = (string) ($post['image'] ?? '');
    if ($image === '' || !is_file(__DIR__ . '/' . ltrim($image, '/'))) {
        $image = (string) ($post['image_remote'] ?? '');
    }
    if ($image === '') {
        $image = 'images/blog/1.webp';
    }

    return [
        'img' => '/' . ltrim($image, '/'),
        'categoria' => (string) ($post['category'] ?? 'Blog'),
        'titulo' => (string) ($post['title'] ?? ''),
        'descripcion' => (string) ($post['excerpt'] ?? ''),
        'link_text' => $blog_read_label,
        'url' => (string) ($post['slug'] ?? ''),
    ];
}, array_slice($blog_index['posts'] ?? [], 0, 6));

if (empty($blog_posts)) {
    $blog_posts = array_slice($legacy_blog_posts, 0, 6);
}
?>
<!-- SECTION TITULO TOURS .JSON -->
<?php
$tours_json = file_get_contents(__DIR__ . "/locale/$idioma/tours_title.json");
$tours_text = json_decode($tours_json, true);
?>

<!-- SECTION TOURS .JSON -->
<?php
$tours_json = file_get_contents(__DIR__ . "/locale/$idioma/tours.json");
$tours_all = json_decode($tours_json, true);
$tours = $tours_all["cards"];
?>

<!-- SECTION MAS TOURS .JSON -->
<?php
$more_tours_json = file_get_contents(__DIR__ . "/locale/$idioma/more_tours.json");
$more_tours = json_decode($more_tours_json, true);
?>

<!-- SECTION NUEVOS DESTINOS .JSON -->
<?php
$new_dest_json = file_get_contents(__DIR__ . "/locale/$idioma/new_destinations.json");
$new_dest = json_decode($new_dest_json, true);
?>

<!-- SECTION NUESTRAS MARCAS .JSON -->
<?php
$our_brands_json = file_get_contents(__DIR__ . "/locale/$idioma/our_brands.json");
$our_brands = json_decode($our_brands_json, true);
?>

<!-- SECTION COMPANY .JSON -->
<?php
$company_json = file_get_contents(__DIR__ . "/locale/$idioma/company_brands.json");
$company = json_decode($company_json, true);
?>

<!-- SECTION INFO SUPPORT .JSON -->
<?php
$info_support_json = file_get_contents(__DIR__ . "/locale/$idioma/info_support.json");
$info_support = json_decode($info_support_json, true);
?>

<!-- SECTION FOOTER .JSON -->
<?php
$footer_json = file_get_contents(__DIR__ . "/locale/$idioma/footer.json");
$footer = json_decode($footer_json, true);
?>

<!-- TOURS IDIOMA PLANTILLA -->
<?php

$slug = 'machupicchu';

$data_json = file_get_contents(__DIR__ . "/data/tours/{$slug}.{$idioma}.json");
$data = json_decode($data_json, true);
?>



<!DOCTYPE html>
<html lang="<?= htmlspecialchars($idioma) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?= htmlspecialchars(seo_clean_text((string)$site_meta['title'], 65)) ?></title>
    <meta name="description" content="<?= htmlspecialchars($site_meta['description']) ?>">
    <?php seo_render([
        'title' => $site_meta['title'], 'description' => $site_meta['description'],
        'path' => route_static_path('home', $idioma), 'params' => [], 'language' => $idioma,
        'alternates' => route_static_alternates('home'),
    ]); ?>
    <meta name="keywords" content="<?= htmlspecialchars($site_meta['keywords']) ?>">

    <!-- Google tag (gtag.js) -->



    <!-- faviicon -->
    <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">

    <!-- Whatssap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- icon from menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS (CDN) -->

    <!-- google fonts ANTON - 1 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <!-- Google Fonts POPPINS - 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- COMPILADO PARA CARGAR VANDERAS PARA TELEFONO -->
    <!-- INICIALIZACION DEL IMPUT DE TELEFONO -->

    <!-- END CARGAR VANDERAS PARA TELEFONO -->

    <!-- swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</head>

<body>

    <?php include('header.php') ?>

    <?php include('home.php') ?>

    <?php include('footer.php') ?>


    <!-- // scrips // -->

    <!-- Swiper JS -->
    
    <script src="js/video-modal.js"></script>

    <!-- Mobile menu -->
    <script src="js/mobile-menu.js"></script>
    <script src="js/mega-menu.js"></script> 

    <!-- Swiper Trip Comments -->
    <script src="js/swiper-trip-comments.js"></script>

    <!-- Swiper tours -->
    <script src="js/swiper-tours.js"></script>

    <!-- Swiper tours -->
    <script src="js/swiper-popular-packages.js"></script>

    <script>
        document.querySelectorAll(".card-slider").forEach(slider => {

            const images = slider.querySelectorAll("img");
            let index = 0;

            setInterval(() => {

                images[index].classList.remove("opacity-100");
                images[index].classList.add("opacity-0");

                index = (index + 1) % images.length;

                images[index].classList.remove("opacity-0");
                images[index].classList.add("opacity-100");

            }, 2500);

        });
    </script>
    <script src="js/auto-swiper.js"></script>
</body>

</html>
