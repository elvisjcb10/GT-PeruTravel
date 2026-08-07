<?php require_once __DIR__ . '/../config/bootstrap.php'; ?>
<!-- VERIFICACIONES DE ERRORES EN PHP -->
<?php
?>

<!-- VARIABLES DE PROMOCIONES - HEADER -->
<?php
$promotions_path = __DIR__ . "/../promotions/promotions.json";
$promotions = file_exists($promotions_path)
    ? json_decode(file_get_contents($promotions_path), true)
    : [];
?>

<!-- CARGANDO TOUR + IDIOMA -->
<?php
$lang = (string) ($_GET['lang'] ?? 'es');
if (!in_array($lang, ['es', 'en', 'pt'], true)) {
    $lang = 'es';
}
$tour = (string) ($_GET['tour'] ?? 'machupicchu');
if (!preg_match('/\A[a-zA-Z0-9_-]{1,120}\z/D', $tour)) {
    app_redirect('/404.php?lang=' . rawurlencode($lang));
}
$idioma = $lang;
$GLOBALS['lang'] = $lang;
$template_ui = [
    'es' => ['service' => 'Grupal / Privado', 'package' => 'Paquete', 'empty_itinerary' => 'No hay información de itinerario disponible.', 'from' => 'desde'],
    'en' => ['service' => 'Group / Private', 'package' => 'Package', 'empty_itinerary' => 'No itinerary information is available.', 'from' => 'from'],
    'pt' => ['service' => 'Grupo / Privado', 'package' => 'Pacote', 'empty_itinerary' => 'Não há informações de roteiro disponíveis.', 'from' => 'a partir de'],
][$lang];

$json_file = __DIR__ . "/../data/tours/{$tour}.{$lang}.json";

if (!file_exists($json_file)) {
    app_redirect('/404.php?lang=' . rawurlencode($lang));
}

$data = json_decode(file_get_contents($json_file), true);
route_redirect_legacy('tour', $lang, $tour);

$meta_title = $data['seo_title'] ?? $data['title'];
$meta_description = $data['seo_description'] ?? $data['short_description'];
$meta_keywords = $data['seo_keywords'] ?? '';
$seo_image_cover = ltrim(str_replace('\\', '/', (string)($data['image_cover'] ?? '')), '/');
if ($seo_image_cover === ''
    || !preg_match('~\A[a-zA-Z0-9._/-]+\z~D', $seo_image_cover)
    || preg_match('~(?:^|/)\.\.(?:/|$)~', $seo_image_cover)) {
    $seo_image_cover = 'template-image-tour.jpg';
}
?>

<!-- TEXTOS GLOBALES -->
<?php
$global_path = __DIR__ . "/../lang/global-{$lang}.json";
if (!file_exists($global_path)) {
    $global_path = __DIR__ . "/../lang/global-es.json";
}
$global = json_decode(file_get_contents($global_path), true);
?>

<!-- FOOTER (una sola vez, ANTES de renderizar el HTML) -->
<?php
$footer_json = __DIR__ . "/../locale/$lang/footer.json";
$footer = file_exists($footer_json)
    ? json_decode(file_get_contents($footer_json), true)
    : [];
?>
<!-- ASESORES (compartido con Contacto y Nosotros) -->
<?php
$asesores_json = __DIR__ . "/../locale/$lang/asesores.json";
$asesores_data = file_exists($asesores_json)
    ? json_decode(file_get_contents($asesores_json), true)
    : ['asesores' => []];
?>
<?php
$base_url = "..";
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">

    <title><?= htmlspecialchars(seo_clean_text((string)$meta_title, 65)) ?></title>
    <meta name="description" content="<?= htmlspecialchars(seo_clean_text((string)$meta_description, 160)) ?>">
    <?php seo_render([
        'title' => $meta_title, 'description' => $meta_description,
        'path' => route_path('tour', $lang, $tour), 'params' => [], 'language' => $lang,
        'image' => '/images/tours/' . $seo_image_cover,
        'alternates' => route_alternates('tour', $tour),
        'schema_type' => 'TouristTrip', 'tourist_type' => 'Cultural and adventure tourism',
        'robots' => $tour === 'short-inca-trail' ? 'noindex, follow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
    ]); ?>
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">


    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>

    <?php include(__DIR__ . '/../header.php') ?>

    <main>
        <!-- ******************** 
            HERO DEL TOUR
        *********************** -->
        <?php
        $imageName = $data['image_cover'] ?? '';
        $imgPath = "images/tours/" . $imageName;
        $imgFullPath = __DIR__ . '/../' . $imgPath;

        if (!file_exists($imgFullPath) || empty($imageName)) {
            $imgPath = "images/tours/template-image-tour.jpg";
        }

        // Helper para tomar un valor de "caracteristicas" por su label
        function get_caracteristica($caracteristicas, $label) {
            foreach (($caracteristicas ?? []) as $c) {
                if (strcasecmp($c['label'], $label) === 0) {
                    return $c['valor'];
                }
            }
            return null;
        }

        $dificultad = get_caracteristica($data['caracteristicas'] ?? [], 'Dificultad') ?? '—';
        $altitud    = get_caracteristica($data['caracteristicas'] ?? [], 'Altitud Máxima') ?? '—';
        ?>
        <section id="video" class="tour-hero relative w-full h-[92vh] sm:h-[85vh] md:h-[82vh] min-h-[680px] sm:min-h-[650px] bg-black overflow-hidden">

            <!-- imagen de fondo -->
            <img class="hero-bg absolute top-0 left-0 w-full h-full object-cover" loading="eager" fetchpriority="high" decoding="async"
                src="<?= htmlspecialchars($base_url . '/' . $imgPath) ?>"
                alt="<?= ($data['title']) ?>">

            <!-- overlays para legibilidad del texto -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/40 to-black/10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

            <!-- contenido principal -->
            <div class="tour-hero-content z-10 flex items-center justify-center">
                <div class="container-custom px-5 sm:px-8 md:px-20 w-full">
                    <div class="max-w-2xl">

                        <h1 class="tour-hero-title text-white text-[2.55rem] sm:text-4xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[0.98] sm:leading-[1.1] drop-shadow-lg">
                            <?= ($data['title']) ?>
                        </h1>

                        <p class="tour-hero-description mt-4 sm:mt-6 text-white/90 text-sm sm:text-base md:text-lg leading-relaxed font-poppins font-light max-w-xl">
                            <?= htmlspecialchars($data['short_description']) ?>
                        </p>

                        <!-- Reconocimientos integrados al contenido en móvil y tablet -->
                        <div class="tour-hero-awards flex lg:hidden items-center gap-2 sm:gap-3 mt-5 sm:mt-6">
                            <img src="<?= $base_url ?>/images/tripadvisor/sticker2024.png" alt="Tripadvisor Travelers' Choice 2024" class="h-16 sm:h-20 w-auto">
                            <img src="<?= $base_url ?>/images/tripadvisor/sticker2025.png" alt="Tripadvisor Travelers' Choice 2025" class="h-16 sm:h-20 w-auto">
                            <img src="<?= $base_url ?>/images/tripadvisor/sticker2026.png" alt="Tripadvisor Travelers' Choice 2026" class="h-16 sm:h-20 w-auto">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reconocimientos en escritorio -->
            <div class="hero-awards-standard hidden lg:flex absolute z-10 bottom-28 right-10 gap-2">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2024.png" alt="Tripadvisor Travelers' Choice 2024">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2025.png" alt="Tripadvisor Travelers' Choice 2025">
                <img src="<?= $base_url ?>/images/tripadvisor/sticker2026.png" alt="Tripadvisor Travelers' Choice 2026">
            </div>

            <!-- barra de estadísticas del tour -->
            <div class="absolute bottom-0 left-0 w-full z-10 bg-black/30 sm:bg-black/20 backdrop-blur-sm">
                <div class="container-custom mx-auto px-5 sm:px-6 py-4 sm:py-5">
                    <div class="grid grid-cols-2 sm:flex sm:flex-wrap sm:justify-center gap-y-4 gap-x-5 sm:gap-x-10 md:gap-x-16 lg:gap-x-20">

                        <div class="flex items-center gap-2.5 sm:gap-3 justify-start">
                            <i class="fa-solid fa-clock text-orange-custom text-lg sm:text-2xl w-5 shrink-0 text-center"></i>
                            <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                                <p class="text-white text-[0.95rem] sm:text-2xl font-anton leading-none"><?= htmlspecialchars($data['duration']) ?></p>
                                <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $global['duracion'] ?? 'Duración' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 sm:gap-3 justify-start">
                            <i class="fa-solid fa-person-hiking text-orange-custom text-lg sm:text-2xl w-5 shrink-0 text-center"></i>
                            <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                                <p class="text-white text-[0.95rem] sm:text-2xl font-anton leading-none"><?= htmlspecialchars($dificultad) ?></p>
                                <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $global['dificultad'] ?? 'Dificultad' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 sm:gap-3 justify-start">
                            <i class="fa-solid fa-mountain text-orange-custom text-lg sm:text-2xl w-5 shrink-0 text-center"></i>
                            <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                                <p class="text-white text-[0.95rem] sm:text-2xl font-anton leading-none"><?= htmlspecialchars($altitud) ?></p>
                                <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $global['altitud_maxima'] ?? 'Altitud Máxima' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 sm:gap-3 justify-start">
                            <i class="fa-solid fa-people-group text-orange-custom text-lg sm:text-2xl w-5 shrink-0 text-center"></i>
                            <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                                <p class="text-white text-[0.95rem] sm:text-2xl font-anton leading-none"><?= htmlspecialchars($template_ui['service']) ?></p>
                                <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $global['tipo_servicio'] ?? 'Tipo De Servicio' ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!-- ******************** 
             CONTENIDO: TABS + SIDEBAR
         *********************** -->
        <section class="tour-detail-section container-custom mx-auto px-4 md:px-20 py-10 sm:py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-12">

                <!-- COLUMNA IZQUIERDA: CONTENIDO CON TABS -->
                <div class="lg:col-span-2">

                    <header class="tour-intro mb-8 sm:mb-10">
                        <div class="tour-intro-kicker flex items-center gap-3 mb-3 sm:mb-4">
                            <span class="block w-8 sm:w-10 h-[3px] rounded-full bg-[#ff9300]" aria-hidden="true"></span>
                            <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-[0.12em]">
                                <?= $global['sobre_el_paquete'] ?? 'Sobre El Paquete' ?>
                            </p>
                        </div>

                        <h2 class="tour-intro-title font-anton text-gray-900">
                            <?= ($data['title']) ?>
                        </h2>

                        <div class="tour-intro-description text-gray-600 font-poppins font-light">
                            <?= $data['long_description'] ?>
                        </div>
                    </header>

                    <?php
                    $mapa = trim((string) ($data['map'] ?? ''));
                    $tiene_mapa = $mapa !== '' && file_exists(__DIR__ . '/../images/mapas/' . $mapa);

                    $tabs_tour = array_filter([
                        'itinerario' => !empty($data['days']) ? ($global['itinerario'] ?? 'Itinerario') : null,
                        'incluye' => (!empty($data['includes']) || !empty($data['not_includes'])) ? ($global['incluye'] ?? 'Incluye') : null,
                        'mapa' => $tiene_mapa ? ($global['mapa'] ?? 'Mapa') : null,
                        'galeria' => !empty($data['gallery']) ? ($global['galeria'] ?? 'Galeria') : null,
                        'recomendaciones' => !empty($data['recommendations']) ? ($global['recomendaciones'] ?? 'Recomendaciones') : null,
                        'precio' => !empty($data['categories']) ? ($global['precio'] ?? 'Precio') : null,
                    ]);
                    $primer_tab = array_key_first($tabs_tour);
                    ?>

                    <!-- TABS -->
                    <?php if (!empty($tabs_tour)): ?>
                    <div class="tour-tabs-nav flex flex-nowrap lg:flex-wrap gap-2 mb-8 overflow-x-auto" role="tablist" aria-label="<?= $global['sobre_el_paquete'] ?? 'Información del tour' ?>">
                        <?php foreach ($tabs_tour as $tab_id => $tab_label): ?>
                            <?php $es_primer_tab = $tab_id === $primer_tab; ?>
                            <button type="button"
                                id="tab-<?= $tab_id ?>"
                                role="tab"
                                aria-controls="panel-<?= $tab_id ?>"
                                aria-selected="<?= $es_primer_tab ? 'true' : 'false' ?>"
                                tabindex="<?= $es_primer_tab ? '0' : '-1' ?>"
                                class="tab-tour-btn <?= $es_primer_tab ? 'active bg-orange-custom text-white' : 'bg-white text-gray-700 border border-gray-300' ?> px-5 py-2 rounded-full text-sm font-bold font-poppins transition"
                                data-tab="<?= $tab_id ?>">
                                <?= htmlspecialchars($tab_label) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <!-- ============ TAB: ITINERARIO ============ -->
                    <!-- ============ TAB: ITINERARIO ============ -->
                    <?php if (isset($tabs_tour['itinerario'])): ?>
                    <div id="panel-itinerario" class="tab-tour-content<?= $primer_tab === 'itinerario' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-itinerario" data-tab-content="itinerario">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['dia_a_dia'] ?? 'Dia A Dia' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-8">
                            <span class="text-gray-900"><?= $global['itinerario_titulo'] ?? 'Itinerario' ?></span>
                            <span class="text-orange-custom"><?= $global['itinerario_subtitulo'] ?? 'Completo' ?></span>
                        </h3>

                        <?php if (!empty($data['days'])): ?>
                            <ul class="relative">
                                <?php foreach ($data['days'] as $index => $day): ?>
                                    <li class="itinerario-item relative hover:bg-gray-50 transition pl-10 sm:pl-12 pr-1 sm:pr-2 rounded-lg">

                                        <!-- Línea conectora vertical -->
                                        <?php if ($index < count($data['days']) - 1): ?>
                                            <div class="absolute left-4 top-12 bottom-0 w-[3.5px] bg-gray-700"></div>
                                        <?php endif; ?>

                                        <!-- Círculo numerado (posición absoluta, no afecta el layout del resto) -->
                                        <span class="itinerario-numero absolute left-0 top-4 z-10 w-8 h-8 bg-[#2a2a2a] text-white rounded-full flex items-center justify-center text-sm transition-colors">
                                            <?= $index + 1 ?>
                                        </span>

                                        <!-- Wrapper con el borde AL FINAL (header + panel juntos) -->
                                        <div class="   border-b border-gray-700">

                                            <button type="button"
                                                    class=" itinerario-toggle w-full flex items-center justify-between gap-4 py-4 text-left ">

                                                <span class="flex-1">
                                                    <span class="itinerario-titulo block font-bold font-poppins text-gray-900 transition-colors">
                                                        <?= htmlspecialchars($day['title']) ?>
                                                    </span>
                                                    <span class="block text-gray-400 text-xs font-poppins uppercase tracking-wide mt-0.5">
                                                        <?= htmlspecialchars($day['lugar'] ?? '') ?>
                                                    </span>
                                                </span>

                                                <i class="fa-solid fa-chevron-down text-orange-custom itinerario-icon transition-transform"></i>
                                            </button>

                                            <div class="itinerario-panel hidden pb-5">
                                                <div class="flex flex-col sm:flex-row gap-4">
                                                    <?php if (!empty($day['imagen'])): ?>
                                                        <div class="w-full sm:w-32 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                                            <img src="<?= $base_url ?>/images/tours/<?= htmlspecialchars($day['imagen']) ?>"
                                                                alt="<?= htmlspecialchars($day['title']) ?>"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                    <?php endif; ?>
                                                    <p class="text-gray-500 font-poppins text-sm leading-relaxed">
                                                        <?= $day['text'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                                    <!--linea final-->
                                            <div></div>
                                        </div>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-gray-500"><?= htmlspecialchars($template_ui['empty_itinerary']) ?></p>
                        <?php endif; ?>
                    </div>

                    <?php endif; ?>

                    <!-- ============ TAB: INCLUYE ============ -->
                    <?php if (isset($tabs_tour['incluye'])): ?>
                    <div id="panel-incluye" class="tab-tour-content<?= $primer_tab === 'incluye' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-incluye" data-tab-content="incluye">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-6">
                            <span class="text-gray-900"><?= $global['que'] ?? 'Que' ?></span>
                            <span class="text-orange-custom"><?= $global['incluye'] ?? 'Incluye' ?></span>
                        </h3>

                        <div class="grid grid-cols-1 <?= !empty($data['includes']) && !empty($data['not_includes']) ? 'sm:grid-cols-2' : '' ?> gap-6">
                            <?php if (!empty($data['includes'])): ?>
                            <div class="tour-info-card bg-[#2a2a2a] rounded-xl p-5 sm:p-6">
                                <h4 class="text-[#34e0a1] font-bold font-poppins uppercase mb-4">
                                    <?= $global['incluye'] ?? 'Incluye' ?>
                                </h4>
                                <ul class="space-y-2">
                                    <?php foreach (($data['includes'] ?? []) as $item): ?>
                                        <li class="flex items-start gap-2 text-white text-sm font-poppins">
                                            <i class="fa-solid fa-check text-[#34e0a1] mt-1"></i>
                                            <?= htmlspecialchars($item) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <?php endif; ?>

                            <?php if (!empty($data['not_includes'])): ?>
                            <div class="tour-info-card bg-white border border-gray-200 rounded-xl p-5 sm:p-6">
                                <h4 class="text-red-500 font-bold font-poppins uppercase mb-4">
                                    <?= $global['no_incluye'] ?? 'No Incluye' ?>
                                </h4>
                                <ul class="space-y-2">
                                    <?php foreach (($data['not_includes'] ?? []) as $item): ?>
                                        <li class="flex items-start gap-2 text-gray-700 text-sm font-poppins">
                                            <i class="fa-solid fa-xmark text-red-500 mt-1"></i>
                                            <?= htmlspecialchars($item) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php endif; ?>

                    <!-- ============ TAB: MAPA / RUTA ============ -->
                    <?php if (isset($tabs_tour['mapa'])): ?>
                    <div id="panel-mapa" class="tab-tour-content<?= $primer_tab === 'mapa' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-mapa" data-tab-content="mapa">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-6">
                            <span class="text-gray-900"><?= $global['mapa_del'] ?? 'Mapa Del' ?></span>
                            <span class="text-orange-custom"><?= $global['recorrido'] ?? 'Recorrido' ?></span>
                        </h3>


                        <a href="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>" target="_blank">
                            <img src="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>"
                                 alt="Mapa del tour <?= htmlspecialchars($data['title']) ?>"
                                 class="w-full h-auto rounded-xl shadow-md hover:scale-[1.01] transition duration-300"
                                 loading="lazy">
                        </a>
                    </div>

                    <?php endif; ?>

                    <!-- ============ TAB: GALERIA ============ -->
                    <!-- ============ TAB: GALERIA ============ -->
                    <?php if (isset($tabs_tour['galeria'])): ?>
                    <div id="panel-galeria" class="tab-tour-content<?= $primer_tab === 'galeria' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-galeria" data-tab-content="galeria">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['explora_peru'] ?? 'Explora Peru' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-6">
                            <span class="text-gray-900"><?= $global['galeria_de'] ?? 'Galeria De' ?></span>
                            <span class="text-orange-custom"><?= $global['fotos'] ?? 'Fotos' ?></span>
                        </h3>

                        <div class="tour-gallery-grid grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                            <?php foreach (($data['gallery'] ?? []) as $index => $img): ?>
                                <button type="button"
                                        class="gallery-item rounded-xl overflow-hidden aspect-[4/3] group cursor-pointer"
                                        data-index="<?= $index ?>">
                                    <img src="<?= $base_url ?>/images/tours/<?= htmlspecialchars($img) ?>"
                                        alt="<?= htmlspecialchars($data['title']) ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php endif; ?>

                    <!-- ============ TAB: RECOMENDACIONES ============ -->
                    <?php if (isset($tabs_tour['recomendaciones'])): ?>
                    <div id="panel-recomendaciones" class="tab-tour-content<?= $primer_tab === 'recomendaciones' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-recomendaciones" data-tab-content="recomendaciones">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['recomendaciones'] ?? 'Recomendaciones' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-6 text-gray-900">
                            <?= $global['recomendaciones'] ?? 'Recomendaciones' ?>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <?php foreach (($data['recommendations'] ?? []) as $rec): ?>
                                <div class="tour-recommendation-card text-center">
                                    <div class="bg-gray-100 rounded-lg h-24 flex items-center justify-center overflow-hidden mb-2">
                                        <img src="<?= $base_url ?>/images/<?= htmlspecialchars($rec['img']) ?>"
                                             alt="<?= htmlspecialchars($rec['nombre']) ?>"
                                             class="max-h-full object-contain">
                                    </div>
                                    <p class="text-xs font-poppins text-gray-700"><?= htmlspecialchars($rec['nombre']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php endif; ?>

                    <!-- ============ TAB: PRECIO (usa tus categorías existentes) ============ -->
                    <?php if (isset($tabs_tour['precio'])): ?>
                    <div id="panel-precio" class="tab-tour-content<?= $primer_tab === 'precio' ? '' : ' hidden' ?>" role="tabpanel" aria-labelledby="tab-precio" data-tab-content="precio">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['precio'] ?? 'Precio' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-6 text-gray-900">
                            <?= $global['precio_y_disponibilidad'] ?? 'Precio Y Disponibilidad' ?>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach (($data['categories'] ?? []) as $key => $cat): ?>
                                <div class="tour-price-card border border-gray-200 rounded-xl p-5">
                                    <h4 class="font-bold font-poppins text-gray-900 mb-1"><?= htmlspecialchars($cat['titulo']) ?></h4>
                                    <p class="text-gray-500 text-sm font-poppins mb-3"><?= htmlspecialchars($cat['descripcion']) ?></p>
                                    <span class="text-2xl font-bold text-orange-custom">$<?= htmlspecialchars($cat['precio']) ?></span>
                                    <p class="text-gray-400 text-xs font-poppins mt-1"><?= htmlspecialchars($cat['nota']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php endif; ?>

                    <!-- ============ FAQ (fija, debajo de las tabs) ============ -->
                    <?php if (!empty($data['faq'])): ?>
                    <div class="tour-faq mt-10 sm:mt-12 lg:mt-14">
                        <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="tour-section-title font-anton mb-4 sm:mb-6">
                            <span class="text-gray-900"><?= $global['preguntas'] ?? 'Preguntas' ?></span>
                            <span class="text-orange-custom"><?= $global['frecuentes'] ?? 'Frecuentes' ?></span>
                        </h3>

                        <div class="space-y-2.5 sm:space-y-3">
                            <?php foreach ($data['faq'] as $item): ?>
                                <div class="faq-item border border-gray-800 rounded-xl overflow-hidden bg-[#2a2a2a]">
                                    <button type="button"
                                            class="faq-toggle w-full flex items-center justify-between gap-3 px-4 py-2.5 sm:px-5 sm:py-3 text-left text-sm sm:text-base leading-snug text-white font-poppins font-semibold"
                                            aria-expanded="false">
                                        <span class="flex-1 min-w-0 break-words">
                                            <?= htmlspecialchars($item['pregunta']) ?>
                                        </span>
                                        <i class="fa-solid fa-chevron-down text-orange-custom faq-icon flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/5 transition-transform"></i>
                                    </button>
                                    <div class="faq-panel hidden px-4 pb-4 sm:px-5 sm:pb-5">
                                        <p class="break-words text-gray-300 text-sm sm:text-[0.95rem] font-poppins leading-7">
                                            <?= htmlspecialchars($item['respuesta']) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- COLUMNA DERECHA: SIDEBAR (precio + formulario) -->
                <aside class="tour-booking-sidebar min-w-0 self-start content-start grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 sm:gap-6 items-start">
                    <!-- BLOQUE PRECIO -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">

                        <p class="text-gray-900 text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['precio_desde'] ?? 'Precio Desde' ?>
                        </p>

                        <h3 id="precio" class="text-4xl sm:text-5xl font-medium text-orange-custom leading-none mb-4">
                            $<?= htmlspecialchars($data['price']) ?>
                        </h3>

                        <p class="font-bold font-poppins text-gray-900 text-sm mb-1">
                            <?= $global['por_persona'] ?? 'Por Persona' ?>
                        </p>

                        <p id="nota-precio" class="text-gray-500 text-sm font-poppins leading-relaxed">
                            <?= htmlspecialchars($data['price_note']) ?>
                        </p>

                        <!-- <a href="https://wa.me/51987370201?text=<?= urlencode('Hola, quiero consultar sobre ' . $data['title']) ?>"
                        target="_blank" rel="noopener"
                        class="mt-6 inline-flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-orange-custom text-white font-bold font-poppins rounded-lg hover:bg-[#c2660a] transition">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            <?= $global['consultar_reservar'] ?? 'Consultar / Reservar' ?>
                        </a> -->

                        <!-- ASESORES -->
                        <?php if (!empty($asesores_data['asesores'])): ?>
                            <div class="mt-6 pt-6 border-t border-gray-200 space-y-4">
                                <?php foreach ($asesores_data['asesores'] as $asesor): ?>
                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                                        <img src="<?= $base_url . $asesor['foto'] ?>"
                                            alt="<?= htmlspecialchars($asesor['nombre']) ?>"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-orange-custom text-xs font-bold font-poppins uppercase"><?= htmlspecialchars($asesor['cargo']) ?></p>
                                            <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($asesor['nombre']) ?></p>
                                            <p class="text-gray-500 text-xs font-poppins"><?= htmlspecialchars($asesor['telefono']) ?></p>
                                        </div>
                                        <a href="https://wa.me/<?= $asesor['whatsapp'] ?>"
                                        target="_blank" rel="noopener"
                                        class="inline-flex items-center justify-center gap-1.5 bg-[#FF9300] hover:bg-[#1ebe5a] text-white text-xs font-bold font-poppins px-4 py-2 rounded-full transition max-sm:w-full">
                                            Consultar
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- FORMULARIO -->
                    <?php
                    $tipo_formulario = "tour";
                    include __DIR__ . "/../includes/template-formulario.php";
                    ?>

                </aside>

            </div>
        </section>

        <!-- ******************** 
             OPINIONES (usa tripadvisor.json global, reutilizado)
         *********************** -->
        <?php
        $trip_json_path = __DIR__ . "/../locale/$lang/tripadvisor.json";
        $trip_text = file_exists($trip_json_path) ? json_decode(file_get_contents($trip_json_path), true) : null;
        ?>
        <?php if ($trip_text): ?>
        <section class="bg-white py-10 sm:py-12 lg:py-14">
            <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $trip_text['kicker'] ?? 'Preguntas' ?>
                </p>
                <h2 class="tour-section-title font-anton leading-tight mb-6 sm:mb-8">
                    <span class="text-gray-900"><?= $trip_text['title_primary'] ?? 'Opiniones De' ?></span>
                    <span class="text-orange-custom"><?= $trip_text['title_secondary'] ?? 'Nuestros Viajeros' ?></span>
                </h2>

                <div class="">
                    <div class="testimonial-swiper swiper mySwiper relative">
                        <div class="swiper-wrapper">

                            <?php foreach ($trip_text['slides'] as $slide): ?>
                                <div class="swiper-slide h-auto">
                                    <a href="<?= $slide['review_url'] ?? 'https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html' ?>"
                                    target="_blank" rel="noopener"
                                    class="testimonial-card group block bg-white border border-gray-200 hover:border-[#00AF87] rounded-2xl shadow-sm hover:shadow-md p-5 sm:p-6 h-full flex flex-col transition-all duration-300">

                                        <!-- ESTRELLAS + LOGO -->
                                        <div class="flex justify-between items-center mb-2 sm:mb-3">
                                            <div class="flex gap-1">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <i class="fa-solid fa-star text-orange-custom text-base sm:text-lg"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <img src="<?= $base_url ?>/images/tripadvisor/tripadvisor-logo.png" alt="Tripadvisor" class="h-6 w-6 sm:h-7 sm:w-7 opacity-70 group-hover:opacity-100 transition-opacity">
                                        </div>

                                        <!-- TESTIMONIO -->
                                        <p class="text-gray-700 font-poppins text-xs sm:text-sm leading-relaxed italic flex-1">
                                            "<?= $slide['texto'] ?>"
                                        </p>

                                        <!-- NOMBRE + FECHA + AVATAR -->
                                        <div class="flex items-center justify-between mt-4 sm:mt-5 pt-3 sm:pt-4 border-t border-gray-100">
                                            <div>
                                                <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins">
                                                    - <?= ucwords(strtolower($slide['nombre'])) ?>
                                                </p>
                                                <p class="text-gray-500 text-[0.65rem] sm:text-xs font-poppins">
                                                    <?= $slide['fecha'] ?>
                                                </p>
                                            </div>
                                            <img src="<?= $base_url ?>/images/testimonials/<?= $slide['img'] ?>"
                                                alt="<?= $slide['nombre'] ?>"
                                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-orange-custom">
                                        </div>

                                    </a>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- ******************** 
            TOURS RELACIONADOS
        *********************** -->
        <?php if (!empty($data['tours_relacionados'])): ?>
        <section class="bg-white py-10 sm:py-12 lg:py-14">
            <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">

                <p class="section-kicker text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $global['explora_peru'] ?? 'Explora Peru' ?>
                </p>

                <h2 class="tour-section-title font-anton leading-tight mb-6 sm:mb-8">
                    <span class="text-gray-900"><?= $global['tours'] ?? 'Tours' ?></span>
                    <span class="text-orange-custom"><?= $global['relacionados'] ?? 'Relacionados' ?></span>
                </h2>

                <div class="swiper-outer">
                    <div class="auto-swiper relative" data-desktop="3" data-tablet="2" data-mobile="1" data-gap="24">
                        <div class="swiper-wrapper">
                    <?php foreach ($data['tours_relacionados'] as $t): ?>
                        <div class="swiper-slide h-auto">
                        <a href="<?= route_path('tour', $idioma ?? $lang, (string)($t['url'])) ?>"
                        class="flex flex-col bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300 h-full">

                            <div class="relative h-56 w-full overflow-hidden">
                                <img src="<?= $base_url ?>/images/<?= htmlspecialchars($t['image']) ?>"
                                    alt="<?= htmlspecialchars($t['title']) ?>"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="p-4 flex-1">
                                <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                    <?= htmlspecialchars($t['duracion']) ?>
                                </p>
                                <h3 class="text-base font-bold font-poppins text-gray-900 leading-snug">
                                    <?= htmlspecialchars($t['title']) ?>
                                </h3>
                                <p class="text-gray-500 text-xs font-poppins font-light mt-1 line-clamp-2">
                                    <?= htmlspecialchars($t['description']) ?>
                                </p>
                            </div>

                            <div class="border-t border-gray-200 mx-4"></div>

                            <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                                <div>
                                    <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none"><?= htmlspecialchars($template_ui['from']) ?></span>
                                    <span class="text-xl font-bold text-orange-custom">$<?= htmlspecialchars($t['price']) ?></span>
                                </div>
                                <span class="bg-orange-custom text-white text-xs font-bold font-poppins px-4 py-2 rounded-full">
                                    Reservar
                                </span>
                            </div>

                        </a>
                        </div>
                    <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <?php endif; ?>
    </main>

    <?php include(__DIR__ . '/../footer.php') ?>
    <!-- ******************** 
     LIGHTBOX DE GALERIA
 *********************** -->
    <div id="gallery-lightbox" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/90 px-3 sm:px-4">

        <!-- Botón cerrar -->
        <button type="button" id="gallery-close"
                class="absolute top-3 right-3 sm:top-5 sm:right-5 w-10 h-10 flex items-center justify-center text-white text-2xl sm:text-3xl hover:text-orange-custom transition z-10">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Flecha anterior -->
        <button type="button" id="gallery-prev"
                class="absolute left-2 sm:left-3 md:left-8 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-12 sm:h-12 flex items-center justify-center bg-white/10 hover:bg-orange-custom rounded-full text-white text-sm sm:text-xl transition z-10">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Imagen -->
        <div class="max-w-5xl w-full px-8 sm:px-12">
            <img id="gallery-image" src="" alt="Galería"
                class="w-full max-h-[75svh] sm:max-h-[80vh] object-contain rounded-lg mx-auto" loading="lazy" decoding="async">
            <p id="gallery-counter" class="text-center text-white/70 text-sm font-poppins mt-4"></p>
        </div>

        <!-- Flecha siguiente -->
        <button type="button" id="gallery-next"
                class="absolute right-2 sm:right-3 md:right-8 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-12 sm:h-12 flex items-center justify-center bg-white/10 hover:bg-orange-custom rounded-full text-white text-sm sm:text-xl transition z-10">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>
    <!-- SCRIPTS -->
    
    <script src="../js/mobile-menu.js"></script>
    <script src="../js/swiper-trip-comments.js"></script>
    <script src="../js/auto-swiper.js"></script>
    <!-- Mobile menu -->
    <script src="../js/mega-menu.js"></script> 
    <!-- TABS DEL TOUR -->
    <script src="../js/tour-tabs.js"></script>

    <!-- ITINERARIO ACORDEON -->
    <script src="../js/tour-itinerario-accordion.js"></script>

    <!-- FAQ ACORDEON -->
    <script src="../js/tour-faq-accordion.js"></script>
    <script src="../js/tour-gallery-lightbox.js"></script>
    <!-- CATEGORIAS + PASAJEROS + PRECIO -->
    <script>
        const categoriasData = <?= json_encode($data['categories'] ?? [], JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/tour-price-calculator.js"></script>

</body>
</html>
