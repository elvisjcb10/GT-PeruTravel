<?php require_once __DIR__ . '/../config/bootstrap.php'; ?>

<?php
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$GLOBALS['lang'] = $idioma;
$destination_ui = [
    'es' => ['missing' => 'Destino no especificado', 'not_found' => 'Destino no encontrado', 'from' => 'desde'],
    'en' => ['missing' => 'Destination not specified', 'not_found' => 'Destination not found', 'from' => 'from'],
    'pt' => ['missing' => 'Destino não especificado', 'not_found' => 'Destino não encontrado', 'from' => 'a partir de'],
][$idioma];
$destino_slug = (string) ($_GET['destino'] ?? '');
if ($destino_slug !== '' && !preg_match('/\A[a-zA-Z0-9_-]{1,120}\z/D', $destino_slug)) {
    app_redirect('/404.php?lang=' . rawurlencode($idioma));
}

if ($destino_slug === '') {
    exit($destination_ui['missing']);
}

$destino_file = __DIR__ . "/../data/destinos/{$destino_slug}.{$idioma}.json";

if (!file_exists($destino_file)) {
    exit($destination_ui['not_found']);
}

$destino_json = file_get_contents($destino_file);
$destino = json_decode($destino_json, true);
route_redirect_legacy('destino', $idioma, $destino_slug);

$footer_json = file_get_contents(__DIR__ . "/../locale/$idioma/footer.json");
$footer = json_decode($footer_json, true);

$base_url = "..";
$hero = file_get_contents(__DIR__ . "/../locale/$idioma/hero.json");
$hero_text = json_decode($hero, true);
?>

<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?= htmlspecialchars(seo_clean_text((string)$destino['titulo'] . ' - Tours | GT Peru Travel', 65)) ?></title>
    <meta name="description" content="<?= htmlspecialchars(seo_clean_text((string)($destino['descripcion'] ?? ''), 160)) ?>">
    <?php seo_render([
        'title' => (string)$destino['titulo'] . ' - Tours | GT Peru Travel',
        'description' => (string)($destino['descripcion'] ?? ''),
        'path' => route_path('destino', $idioma, $destino_slug), 'params' => [], 'language' => $idioma,
        'image' => (string)($destino['background'] ?? '/images/gt-peru-travel.png'),
        'alternates' => route_alternates('destino', $destino_slug),
    ]); ?>
    <!-- Google tag (gtag.js) -->



    <!-- faviicon -->
    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">

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
    <link rel="stylesheet" href="../css/style.css">

    <!-- COMPILADO PARA CARGAR VANDERAS PARA TELEFONO -->
    <!-- INICIALIZACION DEL IMPUT DE TELEFONO -->

    <!-- END CARGAR VANDERAS PARA TELEFONO -->

    <!-- swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- (mismo <head> que tus otras plantillas) -->
</head>
<body>

    <?php include(__DIR__ . '/../header.php') ?>

    <!-- ******************** 
         HERO DEL DESTINO
     *********************** -->
    <section class="page-hero page-hero--with-stats responsive-hero relative w-full bg-black overflow-hidden">

        <img src="<?= $base_url . $destino['background'] ?>" loading="eager" fetchpriority="high" decoding="async"
            alt="<?= $destino['titulo'] ?>"
            class="hero-bg absolute inset-0 w-full h-full object-cover">
        <!-- overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/0 to-black/10"></div>
        <!-- <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div> -->

        <!-- CONTENIDO -->
        <div class="page-hero-content relative z-10 h-full flex items-center justify-center">
            <div class="container-custom  px-20    w-full">
                <div class="max-w-2xl">
                    <!-- BADGE DESTI¿NO -->
                    <div class="hero-section-kicker mb-4" aria-label="<?= htmlspecialchars($destino['badge'] ?? 'Destino') ?>">
                        <span class="hero-section-kicker__line" aria-hidden="true"></span>
                        <span><?= htmlspecialchars($destino['badge'] ?? 'Destino') ?></span>
                    </div>
                    <h1 class="text-white text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.05] drop-shadow-lg">
                        <?= $destino['titulo'] ?>
                    </h1>

                    <p class="mt-6 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                        <?= $destino['descripcion'] ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- logo tripadvisor -->
        <div class="page-hero-awards hero-awards-standard absolute z-10 bottom-24 md:bottom-28 right-4 md:right-10 flex justify-end">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2024.png" alt="Tripadvisor Travelers' Choice 2024">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2025.png" alt="Tripadvisor Travelers' Choice 2025">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2026.png" alt="Tripadvisor Travelers' Choice 2026">
        </div>
        <!-- barra de estadísticas -->
        <div class="page-hero-stats absolute bottom-0 left-0 w-full z-10 bg-black/20 backdrop-blur-sm">
            <div class="container-custom mx-auto  py-5">
                <div class="flex flex-wrap justify-center gap-y-4   gap-x-20">

                    <div class="flex items-center  gap-3">
                        <i class="fa-solid fa-mountain text-orange-custom text-2xl"></i>
                        <div class="text-left flex flex-col gap-1">
                            <p class="text-white text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['destinos']['numero'] ?>+</p>
                            <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['destinos']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center  gap-3">
                        <i class="fa-solid fa-people-group text-orange-custom text-2xl"></i>
                        <div class="text-left flex flex-col gap-1">
                            <p class="text-white text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['viajeros']['numero'] ?>+</p>
                            <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['viajeros']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-star text-orange-custom text-2xl"></i>
                        <div class="text-left flex flex-col gap-1">
                            <p class="text-white text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['calificacion']['numero'] ?></p>
                            <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['calificacion']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center  gap-3">
                        <i class="fa-solid fa-globe text-orange-custom text-2xl"></i>
                        <div class="text-left flex flex-col gap-1">
                            <p class="text-white text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['años']['numero'] ?>+</p>
                            <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['años']['titulo'] ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>

    <!-- ******************** 
         FILTROS + GRID DE TOURS
     *********************** -->
    <section class="container-custom mx-auto px-20 py-14">

        <!-- TABS DE FILTRO -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <?php foreach ($destino['filtros'] as $i => $filtro): ?>
                <button type="button"
                        class="filtro-tour-btn <?= $i === 0 ? 'active' : '' ?> px-6 py-2.5 rounded-full text-sm font-bold font-poppins border transition
                               <?= $i === 0
                                   ? 'bg-orange-custom text-white border-orange-custom'
                                   : 'bg-white text-gray-700 border-gray-300 hover:border-orange-custom' ?>"
                        data-filtro="<?= $filtro['id'] ?>">
                    <?= $filtro['label'] ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- GRID DE TOURS -->
        <div id="grid-tours" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php foreach ($destino['tours'] as $t): ?>
                <?php
                    $tipo_ficha = ($t['tipo'] ?? 'tour') === 'paquete' ? 'paquete' : 'tour';
                    if (route_public_slug($tipo_ficha, $idioma, (string)$t['url']) === null) {
                        $tipo_ficha = route_public_slug('paquete', $idioma, (string)$t['url']) !== null ? 'paquete' : 'tour';
                    }
                    $url_ficha = route_path($tipo_ficha, $idioma, (string)$t['url']);
                    $es_paquete = ($t['tipo'] ?? ($destino_slug === 'paquete-peru' ? 'paquete' : 'tour')) === 'paquete';
                    $image_relative = ltrim(str_replace('\\', '/', (string)($t['image'] ?? '')), '/');
                    $valid_image_path = $image_relative !== ''
                        && preg_match('~\A[a-zA-Z0-9._/-]+\z~D', $image_relative)
                        && !preg_match('~(?:^|/)\.\.(?:/|$)~', $image_relative);

                    if ($valid_image_path && $es_paquete && strpos($image_relative, '/') === false) {
                        $image_relative = 'paquetes/' . $image_relative;
                    }

                    $image_file = $valid_image_path ? __DIR__ . '/../images/' . $image_relative : '';
                    if (!$valid_image_path || !is_file($image_file)) {
                        $image_relative = $es_paquete ? 'paquetes/template-image-tour.jpg' : 'img-prueba-1.png';
                    }
                    $card_image = $base_url . '/images/' . $image_relative;
                ?>
                <div class="tour-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300"
                    data-categoria="<?= $t['categoria'] ?>">

                    <!-- Link envolvente -->
                    <a href="<?= htmlspecialchars($url_ficha) ?>" class="block">

                        <!-- IMAGEN -->
                        <div class="relative h-72 md:h-80 w-full overflow-hidden px-1 pt-1">
                            <img src="<?= htmlspecialchars($card_image) ?>"
                                alt="<?= htmlspecialchars($t['title']) ?>"
                                loading="lazy" decoding="async"
                                class="w-full h-full object-cover rounded-lg shadow-md">
                        </div>

                        <!-- CONTENIDO -->
                        <div class="p-4">

                            <!-- DURACION -->
                            <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                <?= $t['duracion'] ?>
                            </p>

                            <!-- TITULO -->
                            <h3 class="text-base md:text-lg font-bold font-poppins text-gray-900 leading-snug">
                                <?= $t['title'] ?>
                            </h3>

                            <!-- DESCRIPCION -->
                            <p class="text-gray-500 text-xs md:text-sm font-poppins font-light mt-1 line-clamp-3">
                                <?= $t['description'] ?>
                            </p>

                        </div>
                    </a>

                    <!-- linea divisoria -->
                    <div class="px-4">
                        <hr class="border-t border-gray-200">
                    </div>

                    <!-- PRECIO + BOTON -->
                    <div class="flex items-center justify-between p-4 pb-4">
                        <div>
                            <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none"><?= htmlspecialchars($destination_ui['from']) ?></span>
                            <span class="text-3xl font-bold text-orange-custom">$<?= $t['price'] ?></span>
                        </div>

                        <a href="<?= htmlspecialchars($url_ficha) ?>"
                        class="inline-flex items-center px-6 py-2 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-lg transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            Reservar
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </section>

    <?php include(__DIR__ . '/../footer.php') ?>

    <script src="<?= $base_url ?>/js/filtro-tours.js"></script>
    <script src="../js/mobile-menu.js"></script>
    <script src="../js/mega-menu.js"></script> 
</body>
</html>
