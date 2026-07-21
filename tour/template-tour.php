<!-- VERIFICACIONES DE ERRORES EN PHP -->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
$tour = $_GET['tour'] ?? 'machupicchu';
$lang = $_GET['lang'] ?? 'es';
$idioma = $lang; // alias usado en otras partes del sitio
$GLOBALS['lang'] = $lang;

$allowed = ['es', 'en', 'pt'];
if (!in_array($lang, $allowed)) {
    $lang = 'es';
}

$json_file = __DIR__ . "/../data/tours/{$tour}.{$lang}.json";

if (!file_exists($json_file)) {
    header("Location: /404.php");
    exit;
}

$data = json_decode(file_get_contents($json_file), true);

$meta_title = $data['seo_title'] ?? $data['title'];
$meta_description = $data['seo_description'] ?? $data['short_description'];
$meta_keywords = $data['seo_keywords'] ?? '';
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

    <title><?= htmlspecialchars($meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17034229022"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'AW-17034229022');
    </script>

    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        anton: ['Anton', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>

    <?php include('../header.php') ?>

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
        <section id="video" class="relative w-full h-[82vh] min-h-[650px] bg-black overflow-hidden">

            <!-- imagen de fondo -->
            <img class="absolute top-0 left-0 w-full h-full object-cover"
                src="<?= htmlspecialchars($base_url . '/' . $imgPath) ?>"
                alt="<?= ($data['title']) ?>">

            <!-- overlays para legibilidad del texto -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

            <!-- contenido principal -->
            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="container-custom px-20 w-full">
                    <div class="max-w-2xl">

                        <h1 class="text-white text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.05] drop-shadow-lg">
                            <?= ($data['title']) ?>
                        </h1>

                        <p class="mt-6 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                            <?= htmlspecialchars($data['short_description']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- logo tripadvisor -->
            <div class="absolute z-10 bottom-24 md:bottom-28 right-4 md:right-10 flex justify-end">
                <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
                <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
                <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
            </div>

            <!-- barra de estadísticas del tour -->
            <div class="absolute bottom-0 left-0 w-full z-10 bg-black/20 backdrop-blur-sm">
                <div class="container-custom mx-auto py-5">
                    <div class="flex flex-wrap justify-center gap-y-4 gap-x-20">

                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-clock text-orange-custom text-2xl"></i>
                            <div class="text-left flex flex-col gap-1">
                                <p class="text-white text-2xl font-anton leading-none"><?= htmlspecialchars($data['duration']) ?></p>
                                <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $global['duracion'] ?? 'Duración' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-person-hiking text-orange-custom text-2xl"></i>
                            <div class="text-left flex flex-col gap-1">
                                <p class="text-white text-2xl font-anton leading-none"><?= htmlspecialchars($dificultad) ?></p>
                                <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $global['dificultad'] ?? 'Dificultad' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-mountain text-orange-custom text-2xl"></i>
                            <div class="text-left flex flex-col gap-1">
                                <p class="text-white text-2xl font-anton leading-none"><?= htmlspecialchars($altitud) ?></p>
                                <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $global['altitud_maxima'] ?? 'Altitud Máxima' ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-people-group text-orange-custom text-2xl"></i>
                            <div class="text-left flex flex-col gap-1">
                                <p class="text-white text-2xl font-anton leading-none">Grupal / Privado</p>
                                <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $global['tipo_servicio'] ?? 'Tipo De Servicio' ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!-- ******************** 
             CONTENIDO: TABS + SIDEBAR
         *********************** -->
        <section class="container-custom mx-auto px-4 md:px-20 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- COLUMNA IZQUIERDA: CONTENIDO CON TABS -->
                <div class="lg:col-span-2">

                    <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $global['sobre_el_paquete'] ?? 'Sobre El Paquete' ?>
                    </p>

                    <h2 class="text-3xl md:text-4xl font-anton mb-4 leading-tight text-gray-900">
                        <?= ($data['title']) ?>
                    </h2>

                    <p class="text-gray-600 font-poppins font-light text-base mb-8">
                        <?= $data['long_description'] ?>
                    </p>

                    <!-- TABS -->
                    <div class="flex flex-wrap gap-2 mb-8">
                        <button type="button" class="tab-tour-btn active px-5 py-2 rounded-full text-sm font-bold font-poppins bg-orange-custom text-white transition" data-tab="itinerario">
                            <?= $global['itinerario'] ?? 'Itinerario' ?>
                        </button>
                        <button type="button" class="tab-tour-btn px-5 py-2 rounded-full text-sm font-bold font-poppins bg-white text-gray-700 border border-gray-300 transition" data-tab="incluye">
                            <?= $global['incluye'] ?? 'Incluye' ?>
                        </button>
                        <button type="button" class="tab-tour-btn px-5 py-2 rounded-full text-sm font-bold font-poppins bg-white text-gray-700 border border-gray-300 transition" data-tab="mapa">
                            <?= $global['mapa'] ?? 'Mapa' ?>
                        </button>
                        <button type="button" class="tab-tour-btn px-5 py-2 rounded-full text-sm font-bold font-poppins bg-white text-gray-700 border border-gray-300 transition" data-tab="galeria">
                            <?= $global['galeria'] ?? 'Galeria' ?>
                        </button>
                        <button type="button" class="tab-tour-btn px-5 py-2 rounded-full text-sm font-bold font-poppins bg-white text-gray-700 border border-gray-300 transition" data-tab="recomendaciones">
                            <?= $global['recomendaciones'] ?? 'Recomendaciones' ?>
                        </button>
                        <button type="button" class="tab-tour-btn px-5 py-2 rounded-full text-sm font-bold font-poppins bg-white text-gray-700 border border-gray-300 transition" data-tab="precio">
                            <?= $global['precio'] ?? 'Precio' ?>
                        </button>
                    </div>

                    <!-- ============ TAB: ITINERARIO ============ -->
                    <!-- ============ TAB: ITINERARIO ============ -->
                    <div class="tab-tour-content" data-tab-content="itinerario">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['dia_a_dia'] ?? 'Dia A Dia' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-8">
                            <span class="text-gray-900"><?= $global['itinerario_titulo'] ?? 'Itinerario' ?></span>
                            <span class="text-orange-custom"><?= $global['itinerario_subtitulo'] ?? 'Completo' ?></span>
                        </h3>

                        <?php if (!empty($data['days'])): ?>
                            <ul class="relative">
                                <?php foreach ($data['days'] as $index => $day): ?>
                                    <li class="itinerario-item relative hover:bg-gray-50 transition pl-12 pr-2 rounded-lg">

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
                            <p class="text-gray-500">No hay información de itinerario disponible.</p>
                        <?php endif; ?>
                    </div>

                    <!-- ============ TAB: INCLUYE ============ -->
                    <div class="tab-tour-content hidden" data-tab-content="incluye">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6">
                            <span class="text-gray-900"><?= $global['que'] ?? 'Que' ?></span>
                            <span class="text-orange-custom"><?= $global['incluye'] ?? 'Incluye' ?></span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-[#2a2a2a] rounded-xl p-6">
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

                            <div class="bg-white border border-gray-200 rounded-xl p-6">
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
                        </div>
                    </div>

                    <!-- ============ TAB: MAPA / RUTA ============ -->
                    <div class="tab-tour-content hidden" data-tab-content="mapa">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6">
                            <span class="text-gray-900"><?= $global['mapa_del'] ?? 'Mapa Del' ?></span>
                            <span class="text-orange-custom"><?= $global['recorrido'] ?? 'Recorrido' ?></span>
                        </h3>

                        <?php
                        $mapa = !empty($data['map']) ? $data['map'] : 'template-citytour.jpg';
                        ?>
                        <a href="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>" target="_blank">
                            <img src="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>"
                                 alt="Mapa del tour <?= htmlspecialchars($data['title']) ?>"
                                 class="w-full h-auto rounded-xl shadow-md hover:scale-[1.01] transition duration-300"
                                 loading="lazy">
                        </a>
                    </div>

                    <!-- ============ TAB: GALERIA ============ -->
                    <div class="tab-tour-content hidden" data-tab-content="galeria">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['explora_peru'] ?? 'Explora Peru' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6">
                            <span class="text-gray-900"><?= $global['galeria_de'] ?? 'Galeria De' ?></span>
                            <span class="text-orange-custom"><?= $global['fotos'] ?? 'Fotos' ?></span>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <?php foreach (($data['gallery'] ?? []) as $img): ?>
                                <div class="rounded-xl overflow-hidden h-40 sm:h-48">
                                    <img src="<?= $base_url ?>/images/tours/<?= htmlspecialchars($img) ?>"
                                         alt="<?= htmlspecialchars($data['title']) ?>"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- ============ TAB: RECOMENDACIONES ============ -->
                    <div class="tab-tour-content hidden" data-tab-content="recomendaciones">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['recomendaciones'] ?? 'Recomendaciones' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6 text-gray-900">
                            <?= $global['recomendaciones'] ?? 'Recomendaciones' ?>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <?php foreach (($data['recommendations'] ?? []) as $rec): ?>
                                <div class="text-center">
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

                    <!-- ============ TAB: PRECIO (usa tus categorías existentes) ============ -->
                    <div class="tab-tour-content hidden" data-tab-content="precio">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['precio'] ?? 'Precio' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6 text-gray-900">
                            <?= $global['precio_y_disponibilidad'] ?? 'Precio Y Disponibilidad' ?>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php foreach (($data['categories'] ?? []) as $key => $cat): ?>
                                <div class="border border-gray-200 rounded-xl p-5">
                                    <h4 class="font-bold font-poppins text-gray-900 mb-1"><?= htmlspecialchars($cat['titulo']) ?></h4>
                                    <p class="text-gray-500 text-sm font-poppins mb-3"><?= htmlspecialchars($cat['descripcion']) ?></p>
                                    <span class="text-2xl font-bold text-orange-custom">$<?= htmlspecialchars($cat['precio']) ?></span>
                                    <p class="text-gray-400 text-xs font-poppins mt-1"><?= htmlspecialchars($cat['nota']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- ============ FAQ (fija, debajo de las tabs) ============ -->
                    <?php if (!empty($data['faq'])): ?>
                    <div class="mt-14">
                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['preguntas'] ?? 'Preguntas' ?>
                        </p>
                        <h3 class="text-2xl md:text-3xl font-anton mb-6">
                            <span class="text-gray-900"><?= $global['preguntas'] ?? 'Preguntas' ?></span>
                            <span class="text-orange-custom"><?= $global['frecuentes'] ?? 'Frecuentes' ?></span>
                        </h3>

                        <div class="space-y-3">
                            <?php foreach ($data['faq'] as $item): ?>
                                <div class="faq-item border border-gray-800 rounded-lg overflow-hidden bg-[#2a2a2a]">
                                    <button type="button" class="faq-toggle w-full flex items-center justify-between p-4 text-left text-white font-poppins font-semibold">
                                        <?= htmlspecialchars($item['pregunta']) ?>
                                        <i class="fa-solid fa-chevron-down text-orange-custom faq-icon transition-transform"></i>
                                    </button>
                                    <div class="faq-panel hidden px-4 pb-4">
                                        <p class="text-gray-300 text-sm font-poppins leading-relaxed">
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
                <aside class="space-y-6">
                    <!-- BLOQUE PRECIO -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">

                        <p class="text-gray-900 text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $global['precio_desde'] ?? 'Precio Desde' ?>
                        </p>

                        <h3 id="precio" class="text-5xl font-medium text-orange-custom leading-none mb-4">
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
                                    <div class="flex items-center gap-3">
                                        <img src="<?= $base_url . $asesor['foto'] ?>"
                                            alt="<?= htmlspecialchars($asesor['nombre']) ?>"
                                            class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                        <div class="flex-1">
                                            <p class="text-orange-custom text-xs font-bold font-poppins uppercase"><?= htmlspecialchars($asesor['cargo']) ?></p>
                                            <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($asesor['nombre']) ?></p>
                                            <p class="text-gray-500 text-xs font-poppins"><?= htmlspecialchars($asesor['telefono']) ?></p>
                                        </div>
                                        <a href="https://wa.me/<?= $asesor['whatsapp'] ?>"
                                        target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-1.5 bg-[#FF9300] hover:bg-[#1ebe5a] text-white text-xs font-bold font-poppins px-4 py-2 rounded-full transition">
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
        <section class="bg-white py-14">
            <div class="container-custom mx-auto px-20">
                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $trip_text['kicker'] ?? 'Preguntas' ?>
                </p>
                <h2 class="text-3xl md:text-4xl font-anton leading-tight mb-8">
                    <span class="text-gray-900"><?= $trip_text['title_primary'] ?? 'Opiniones De' ?></span>
                    <span class="text-orange-custom"><?= $trip_text['title_secondary'] ?? 'Nuestros Viajeros' ?></span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <?php foreach (array_slice($trip_text['slides'], 0, 3) as $slide): ?>
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex flex-col">
                            <div class="flex gap-1 mb-4">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="fa-solid fa-star text-orange-custom text-lg"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 font-poppins text-sm leading-relaxed italic flex-1">
                                "<?= $slide['texto'] ?>"
                            </p>
                            <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                                <div>
                                    <p class="text-orange-custom text-sm font-bold font-poppins">- <?= ucwords(strtolower($slide['nombre'])) ?></p>
                                    <p class="text-gray-500 text-xs font-poppins"><?= $slide['fecha'] ?></p>
                                </div>
                                <img src="<?= $base_url ?>/images/testimonials/<?= $slide['img'] ?>"
                                     alt="<?= $slide['nombre'] ?>"
                                     class="w-12 h-12 rounded-full object-cover border-2 border-orange-custom">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- ******************** 
            TOURS RELACIONADOS
        *********************** -->
        <?php if (!empty($data['tours_relacionados'])): ?>
        <section class="bg-white py-14">
            <div class="container-custom mx-auto px-20">

                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $global['explora_peru'] ?? 'Explora Peru' ?>
                </p>

                <h2 class="text-3xl md:text-4xl font-anton leading-tight mb-8">
                    <span class="text-gray-900"><?= $global['tours'] ?? 'Tours' ?></span>
                    <span class="text-orange-custom"><?= $global['relacionados'] ?? 'Relacionados' ?></span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($data['tours_relacionados'] as $t): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $lang ?>"
                        class="block bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">

                            <div class="relative h-56 w-full overflow-hidden">
                                <img src="<?= $base_url ?>/images/<?= htmlspecialchars($t['image']) ?>"
                                    alt="<?= htmlspecialchars($t['title']) ?>"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="p-4">
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

                            <div class="flex items-center justify-between p-4">
                                <div>
                                    <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none">desde</span>
                                    <span class="text-xl font-bold text-orange-custom">$<?= htmlspecialchars($t['price']) ?></span>
                                </div>
                                <span class="bg-orange-custom text-white text-xs font-bold font-poppins rounded-full  px-4 py-2 rounded-full">
                                    Reservar
                                </span>
                            </div>

                        </a>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
        <?php endif; ?>
    </main>

    <?php include('../footer.php') ?>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="../js/mobile-menu.js"></script>
    <script src="../js/swiper-trip-comments.js"></script>
    <script src="../js/swiper-tours.js"></script>

    <!-- TABS DEL TOUR -->
    <script src="../js/tour-tabs.js"></script>

    <!-- ITINERARIO ACORDEON -->
    <script src="../js/tour-itinerario-accordion.js"></script>

    <!-- FAQ ACORDEON -->
    <script src="../js/tour-faq-accordion.js"></script>

    <!-- CATEGORIAS + PASAJEROS + PRECIO -->
    <script>
        const categoriasData = <?= json_encode($data['categories'] ?? [], JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/tour-price-calculator.js"></script>

</body>
</html>