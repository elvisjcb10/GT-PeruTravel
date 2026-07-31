<?php
require_once __DIR__ . "/config/environment.php";
?>

<header >

    <!------------------------
    CARGAR IDIOMA BOTONES  
    -------------------------->
    <?php
    // Construir URL actual sin modificar parámetros
    $actual = $_SERVER['REQUEST_URI'];
    $query = $_GET;

    // función para reconstruir URL con lang cambiado
    function cambiarIdioma($lang)
    {
        $q = $_GET;
        $q['lang'] = $lang;
        return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($q);
    }
    ?>
     <!---------------------- 
      CARGAR ICONOS 
    ------------------------>
   <?php
    function get_icon($name, $classes = "w-5 h-5") {
        $file_path = __DIR__ . "/assets/icons/{$name}.svg";

        if (file_exists($file_path)) {
            $svg_content = file_get_contents($file_path);

            $svg_with_classes = str_replace(
                '<svg',
                '<svg class="w-full h-full block"',
                $svg_content
            );

            return '<span class="inline-block shrink-0 ' . $classes . '">' . $svg_with_classes . '</span>';
        }

        return ''; // si no existe el svg
    } 
?>
    <!---------------------- 
      CARGAR PROMOCIONES 
    ------------------------>
    <?php
    // Cargar promociones
    $promotions_file = __DIR__ . "/promotions/promotions.json";

    $promotions = [];
    if (file_exists($promotions_file)) {
        $json = json_decode(file_get_contents($promotions_file), true);
        $promotions = $json["promotions"] ?? [];
    }
    ?>

    <!--------------------- 
    SECTION HEADER 
    ---------------------->
    <?php
    // Idioma actual (viene de cookie, sesión, GET, etc.)
    $idioma = $GLOBALS['lang'] ?? ($_GET['lang'] ?? 'es');
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$header_ui = [
    'es' => ['from' => 'Desde'],
    'en' => ['from' => 'From'],
    'pt' => ['from' => 'A partir de'],
][$idioma];

    // Ruta del archivo JSON del idioma elegido
    $ruta = __DIR__ . "/locale/$idioma/header.json";

    // Verificar si existe el archivo
    if (!file_exists($ruta)) {
        // Si no existe, usar español por defecto
        $ruta = __DIR__ . "/locale/es/header.json";
    }

    // Cargar textos
    $header_text = json_decode(file_get_contents($ruta), true);
    ?>

    <!-----------------
    fin enlaces 
    ------------------>

    <!-- banner info    -->
    <!-- banner info -->
    <!-- banner info -->
    <section id="banner-promotions" class="bg-[#2b2b2b] text-white text-sm font-poppins">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row items-center justify-center md:justify-between py-2 gap-3">

                <!-- Left: horario + telefono (oculto en mobile) -->
                <div class="hidden md:flex items-center gap-6">

                    <p class="text-[#A0A0A0] text-[13px] flex items-center gap-2">
                        <?= get_icon('clock', 'w-4 h-4'); ?>
                        <?= $header_text['banner_social']['horario'] ?>
                    </p>

                    <p class="text-[#A0A0A0] text-[13px] flex items-center gap-2">
                        <?= get_icon('phone', 'w-4 h-4'); ?>
                        <?= $header_text['banner_social']['telefono'] ?>
                    </p>

                </div>

                <div class="flex items-center gap-4">

                    <!-- redes sociales (siempre visibles) -->
                    <div class="flex items-center gap-4">

                        <a href="https://www.facebook.com/gtperutravel"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-[#1877F2] transition duration-300">
                                <?= get_icon('facebook', 'w-5 h-5'); ?>
                            </span>
                            <span class="hidden md:block absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                Facebook
                            </span>
                        </a>

                        <a href="https://www.instagram.com/gtperutravel_oficial/"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-pink-500 transition duration-300">
                                <?= get_icon('instagram', 'w-5 h-5'); ?>
                            </span>
                            <span class="hidden md:block absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                Instagram
                            </span>
                        </a>

                        <a href="https://www.youtube.com/@gtperutravel9213"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-red-500 transition duration-300">
                                <?= get_icon('youtube', 'w-5 h-5'); ?>
                            </span>
                            <span class="hidden md:block absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                YouTube
                            </span>
                        </a>

                        <a href="https://www.tiktok.com/@gt_peru_travel"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-cyan-400 transition duration-300">
                                <?= get_icon('tiktok', 'w-5 h-5'); ?>
                            </span>
                            <span class="hidden md:block absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                TikTok
                            </span>
                        </a>

                    </div>

                    <!-- linea (visible tambien en mobile ahora, ya que hay idiomas al lado) -->
                    <div class="block w-px h-5 bg-gray-600"></div>

                    <!-- idiomas (ahora visibles en mobile tambien) -->
                    <div class="flex items-center gap-2">
                        <a href="<?= cambiarIdioma('es') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/es.png" width="20" class="md:w-6" alt="Español">
                        </a>

                        <a href="<?= cambiarIdioma('en') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/en.png" width="20" class="md:w-6" alt="English">
                        </a>

                        <a href="<?= cambiarIdioma('pt') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/pt.png" width="20" class="md:w-6" alt="Português">
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--banner ctae -->
    <section id="banner-social" class="bg-white shadow-sm border-b">
        <div class="container-custom px-4 font-poppins">
            <div class="flex items-center justify-between gap-4 py-3">

                <!-- Logo -->
                <div class="shrink-0">
                    <a href="<?= $base_url ?>?lang=<?= $idioma ?>">
                        <img src="<?= $base_url ?>/images/gt-peru-travel.png"
                            alt="GT Peru Travel"
                            class="w-20 sm:w-24 md:w-32 hover:scale-105 transition duration-300">
                    </a>
                </div>

                <!-- Links (solo desktop) -->
                <div class="hidden lg:flex items-center gap-8 text-sm font-medium text-[#333]"> 

                    <a href="<?= $base_url ?>/blog.php?lang=<?= $idioma ?>"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['blog'] ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>

                    <a href="<?= $base_url ?>/?lang=<?= urlencode($idioma) ?>#trip-advisor"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['testimonios'] ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>

                    <a href="<?= $base_url ?>/nosotros.php?lang=<?= $idioma ?>"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['nosotros'] ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>

                    <a href="<?= $base_url ?>/contacto.php?lang=<?= $idioma ?>"
                    class="inline-flex items-center gap-2 bg-[#ff9300] hover:bg-[#ff7a00] hover:shadow-lg hover:-translate-y-0.5
                            transition duration-300 text-white px-5 py-2.5 rounded-lg font-semibold group">
                        <?= $header_text['banner_social']['extra_links']['impacto'] ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h18m0 0l-4-4m4 4l-4 4"/>
                        </svg>
                    </a>

                </div>

                <!-- Botón CTA visible en mobile/tablet + botón hamburguesa -->
                <div class="flex items-center gap-3 lg:hidden">
                    <a href="<?= $base_url ?>/contacto.php?lang=<?= $idioma ?>"
                    class="hidden sm:inline-flex items-center gap-1.5 bg-[#ff9300] hover:bg-[#ff7a00] transition text-white text-xs px-4 py-2 rounded-lg font-semibold">
                        <?= $header_text['banner_social']['extra_links']['impacto'] ?>
                    </a>

                    <button id="menu-btn-mobile" type="button" aria-label="Abrir menú"
                            class="text-gray-800 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </section>
    <!--navbar menu-->
    <section id="nav-menu" class="hidden lg:block">
        <div class="bg-[#FF9300]  text-white shadow-md font-poppins">
            <div class="container-custom mx-auto ">
                <nav class="relative">
                   
                    <!-- Menu desktop -->
                    <ul class="hidden py-2  md:flex relative w-full items-center  justify-center gap-12  text-[14px] font-semibold uppercase tracking-[0.4px]">
                        <!-- DESTINOS -->
                       <!-- DESTINOS -->
                        <li class="group/menu">
                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>"
                            class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                
                                <?= $header_text['menu']['destinos'] ?>

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible
                                        group-hover/menu:opacity-100
                                        group-hover/menu:visible
                                        transition-all duration-300
                                        z-[9999]  ">

                                <div class="bg-white shadow-2xl rounded-2xl p-8">
                                    <div class="grid grid-cols-5 gap-6">

                                        <!-- lima-->
                                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=lima&lang=<?= $idioma ?>" class="group/card block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48 overflow-hidden">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['lima']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transform transition-transform duration-500 ease-out group-hover/card:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['lima']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- Manu -->
                                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=manu_tambopata&lang=<?= $idioma ?>" class="group/card block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48 overflow-hidden">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['manu_tambopata']['img'] ?>"
                                                    alt="Manu Tambopata"
                                                    class="w-full h-full object-cover transform transition-transform duration-500 ease-out group-hover/card:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['manu_tambopata']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- Arequipa -->
                                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=arequipa&lang=<?= $idioma ?>" class="group/card block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48 overflow-hidden">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['arequipa']['img'] ?>"
                                                    alt="Arequipa"
                                                    class="w-full h-full object-cover transform transition-transform duration-500 ease-out group-hover/card:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['arequipa']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- Puno -->
                                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=puno&lang=<?= $idioma ?>" class="group/card block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48 overflow-hidden">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['puno']['img'] ?>"
                                                    alt="Puno"
                                                    class="w-full h-full object-cover transform transition-transform duration-500 ease-out group-hover/card:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['puno']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- Huaraz -->
                                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=huaraz&lang=<?= $idioma ?>" class="group/card block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48 overflow-hidden">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['huaraz']['img'] ?>"
                                                    alt="Huaraz"
                                                    class="w-full h-full object-cover transform transition-transform duration-500 ease-out group-hover/card:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['huaraz']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- TOURS CUSCO -->
                        <li class="group">
                            <a href="<?= $base_url ?>/destino/template-destino.php?destino=cusco&lang=<?= $idioma ?>" class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                <?= $header_text['menu']['tour_cusco'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible
                                        group-hover:opacity-100
                                        group-hover:visible
                                        transition-all duration-300 z-[9999]">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 text-[#333] text-sm  normal-case">
                                        <!-- 3 columnas -->
                                        <div class="grid grid-cols-3 gap-8">

                                            <!-- COL 1: Tours Tradicionales -->
                                            <div class="flex flex-col gap-1">

                                                <p class="text-xl font-anton-sub font-medium    mb-2 px-2 text-[#FF9300]">
                                                    <?= $header_text['mega_menu']['tour_cusco']['tradicionales']['title'] ?>
                                                </p>

                                                <?php foreach($header_text['mega_menu']['tour_cusco']['tradicionales']['links'] as $key => $nombre): ?>
                                                    <a href="#"
                                                        class="group/item flex items-center justify-between gap-2 px-2 py-2.5
                                                            rounded-lg hover:bg-[#FFF7EF] transition duration-200">
                                                        <span class="group-hover/item:text-orange-500 transition duration-200 font-medium">
                                                            <?= $nombre ?>
                                                        </span>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-3.5 h-3.5 shrink-0 text-gray-300
                                                                group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                                group-hover/item:text-orange-500 transition-all duration-300"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                        </svg>
                                                    </a>
                                                <?php endforeach; ?>

                                            </div>

                                            <!-- COL 2: Tours de Caminata -->
                                            <div class="flex flex-col gap-1">

                                                <p class="text-xl font-anton-sub font-medium   mb-2 px-2 text-[#FF9300]">
                                                    <?= $header_text['mega_menu']['tour_cusco']['caminata']['title'] ?>
                                                </p>

                                                <?php foreach($header_text['mega_menu']['tour_cusco']['caminata']['links'] as $key => $nombre): ?>
                                                    <a href="#"
                                                        class="group/item flex items-center justify-between gap-2 px-2 py-2.5
                                                            rounded-lg hover:bg-[#FFF7EF] transition duration-200">
                                                        <span class="group-hover/item:text-orange-500 transition duration-200 font-medium">
                                                            <?= $nombre ?>
                                                        </span>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-3.5 h-3.5 shrink-0 text-gray-300
                                                                group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                                group-hover/item:text-orange-500 transition-all duration-300"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                        </svg>
                                                    </a>
                                                <?php endforeach; ?>

                                            </div>

                                            <!-- COL 3: Tours de Aventura -->
                                            <div class="flex flex-col gap-1">

                                                <p class="text-xl font-anton-sub font-medium    mb-2 px-2 text-[#FF9300]">
                                                    <?= $header_text['mega_menu']['tour_cusco']['aventura']['title'] ?>
                                                </p>

                                                <?php foreach($header_text['mega_menu']['tour_cusco']['aventura']['links'] as $key => $nombre): ?>
                                                    <a href="#"
                                                        class="group/item flex items-center justify-between gap-2 px-2 py-2.5
                                                            rounded-lg hover:bg-[#FFF7EF] transition duration-200">
                                                        <span class="group-hover/item:text-orange-500 transition duration-200 font-medium">
                                                            <?= $nombre ?>
                                                        </span>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-3.5 h-3.5 shrink-0 text-gray-300
                                                                group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                                group-hover/item:text-orange-500 transition-all duration-300"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                        </svg>
                                                    </a>
                                                <?php endforeach; ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- MACHU PICCHU -->
                        <li class="group" data-megamenu>
                            <a href="<?= $base_url ?>/destino/template-destino.php?destino=machupicchu&lang=<?= $idioma ?>" class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                <?= $header_text['menu']['machupicchu'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible 
                                        group-hover:opacity-100 
                                        group-hover:visible 
                                        transition-all duration-300 z-[9999]">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 grid grid-cols-2 gap-8 text-[#333] text-sm font-normal normal-case">

                                        <!-- LEFT: lista de tours -->
                                        <div class="flex flex-col gap-1">
                                            <?php foreach($header_text['mega_menu']['machupicchu']['links'] as $key => $tour): ?>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= htmlspecialchars($tour['url'] ?? $key) ?>&lang=<?= $idioma ?>"
                                                    class="tour-item group/item flex items-center justify-between gap-2 p-4 rounded-xl hover:bg-[#FFF7EF] transition duration-200 cursor-pointer"
                                                    data-title="<?= htmlspecialchars($tour['nombre']) ?>"
                                                    data-desc="<?= htmlspecialchars($tour['descripcion']) ?>"
                                                    data-price="<?= htmlspecialchars($tour['precio']) ?>"
                                                    data-time="<?= htmlspecialchars($tour['tiempo']) ?>"
                                                    data-difficulty="<?= htmlspecialchars($tour['dificultad']) ?>"
                                                    data-transport="<?= htmlspecialchars($tour['transporte']) ?>"
                                                    data-img="<?= $base_url ?><?= htmlspecialchars($tour['img']) ?>">

                                                    <span class=" transition duration-200 font-medium">
                                                        <?= htmlspecialchars($tour['nombre2'] ?? $tour['nombre'] ?? $key) ?>
                                                    </span>

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 shrink-0 text-gray-300 transition-all duration-300
                                                            group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                            group-hover/item:text-orange-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                    </svg>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- RIGHT: preview dinámico -->
                                        <div class="col-span-1 grid grid-cols-2 gap-4">

                                            <!-- ESTADO DEFAULT -->
                                            <div data-preview="default" class="col-span-2 grid grid-cols-2 gap-4">

                                                <!-- Info -->
                                                <div class="flex flex-col gap-4  ">
                                                    <div>
                                                        <h3 class="text-2xl font-medium font-anton-sub text-[#FF9300] mb-2 leading-snug  ">
                                                            <?= $header_text['mega_menu']['machupicchu']['nombre'] ?>
                                                        </h3>
                                                        <p class="text-gray-500 leading-relaxed text-sm">
                                                            <?= $header_text['mega_menu']['machupicchu']['descripcion'] ?>
                                                        </p>
                                                    </div>

                                                    <!-- Badges -->
                                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                                                            </svg>
                                                            Guías Profesional
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Asistencia 24/7
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Experiencia Local
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                                            </svg>
                                                            Trekking
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Imágenes -->
                                                <div class="grid grid-cols-2 gap-2 rounded-xl overflow-hidden">
                                                    <div class="col-span-2 h-36 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['pr'] ?>"
                                                            alt="Machu Picchu" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['sec1'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['sec2'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- ESTADO HOVER -->
                                            <div data-preview="hover" class="col-span-2 grid grid-cols-2 gap-4 hidden">

                                                <!-- Info del tour -->
                                                <div class="flex flex-col gap-3">
                                                    <h3 data-preview="title" class="text-2xl font-anton-sub font-medium text-[#FF9300] leading-snug"></h3>
                                                    <p  data-preview="desc"  class="text-gray-500 leading-relaxed text-sm"></p>

                                                    <div class="flex flex-col gap-2 text-sm text-gray-600 mt-1">
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                                                            </svg>
                                                            <span data-preview="time"></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l4-8 4 4 4-6 4 10"/>
                                                            </svg>
                                                            <span>Dificultad: <span data-preview="difficulty"></span></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <rect x="1" y="3" width="15" height="13" rx="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8h4l3 3v5h-7V8z"/>
                                                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                                                <circle cx="18.5" cy="18.5" r="2.5"/>
                                                            </svg>
                                                            <span data-preview="transport"></span>
                                                        </div>
                                                    </div>

                                                    <div data-preview="price-wrap" class="hidden mt-auto pt-3 border-t border-gray-100">
                                                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5"><?= htmlspecialchars($header_ui['from']) ?></p>
                                                        <p class="text-2xl font-bold text-orange-500">
                                                            USD <span data-preview="price"></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Imagen del tour -->
                                                <div class="rounded-xl overflow-hidden bg-gray-100 h-full max-h-[300px]">
                                                    <img data-preview="img" src="" alt="Tour preview"
                                                        class="w-full h-full object-cover" style="display:none">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- GLACIARES -->
                        <li class="group" data-megamenu>
                            <a href="<?= $base_url ?>/destino/template-destino.php?destino=glaciares&lang=<?= $idioma ?>" class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                <?= $header_text['menu']['glaciares_cusco'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible 
                                        group-hover:opacity-100 
                                        group-hover:visible 
                                        transition-all duration-300 z-[9999]">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 grid grid-cols-2 gap-8 text-[#333] text-sm font-normal normal-case">

                                        <!-- LEFT: lista de tours -->
                                        <div class="flex flex-col gap-1">
                                            <?php foreach($header_text['mega_menu']['glaciares']['links'] as $key => $tour): ?>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= htmlspecialchars($tour['url'] ?? $key) ?>&lang=<?= $idioma ?>"
                                                    class="tour-item group/item flex items-center justify-between gap-2 p-4 rounded-xl hover:bg-[#FFF7EF] transition duration-200 cursor-pointer"
                                                    data-title="<?= htmlspecialchars($tour['nombre']) ?>"
                                                    data-desc="<?= htmlspecialchars($tour['descripcion']) ?>"
                                                    data-price="<?= htmlspecialchars($tour['precio']) ?>"
                                                    data-time="<?= htmlspecialchars($tour['tiempo']) ?>"
                                                     data-difficulty="<?= htmlspecialchars($tour['dificultad']) ?>"
                                                    data-transport="<?= htmlspecialchars($tour['transporte']) ?>"
                                                    data-img="<?= $base_url ?><?= htmlspecialchars($tour['img']) ?>">

                                                    <span class=" transition duration-200 font-medium">
                                                        <?= htmlspecialchars($tour['nombre2'] ?? $tour['nombre'] ?? $key) ?>
                                                    </span>

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 shrink-0 text-gray-300 transition-all duration-300
                                                            group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                            group-hover/item:text-orange-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                    </svg>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- RIGHT: preview dinámico -->
                                        <div class="col-span-1 grid grid-cols-2 gap-4">

                                            <!-- ESTADO DEFAULT -->
                                            <div data-preview="default" class="col-span-2 grid grid-cols-2 gap-4">

                                                <!-- Info -->
                                                <div class="flex flex-col gap-4">
                                                    <div>
                                                        <h3 class="text-2xl font-medium font-anton-sub text-[#FF9300] mb-2 leading-snug">
                                                            <?= $header_text['mega_menu']['glaciares']['nombre'] ?>
                                                        </h3>
                                                        <p class="text-gray-500 leading-relaxed text-sm">
                                                            <?= $header_text['mega_menu']['glaciares']['descripcion'] ?>
                                                        </p>
                                                    </div>

                                                    <!-- Badges -->
                                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                                                            </svg>
                                                            Guías Profesional
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Asistencia 24/7
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Experiencia Local
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                                            </svg>
                                                            Trekking
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Imágenes -->
                                                <div class="grid grid-cols-2 gap-2 rounded-xl overflow-hidden">
                                                    <div class="col-span-2 h-36 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['glaciares']['imgs']['pr'] ?>"
                                                            alt="Glaciares" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['glaciares']['imgs']['sec1'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['glaciares']['imgs']['sec2'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- ESTADO HOVER -->
                                            <div data-preview="hover" class="col-span-2 grid grid-cols-2 gap-4 hidden">

                                                <!-- Info del tour -->
                                                <div class="flex flex-col gap-3">
                                                    <h3 data-preview="title" class="text-2xl font-medium font-anton-sub text-[#FF9300] leading-snug"></h3>
                                                    <p  data-preview="desc"  class="text-gray-500 leading-relaxed text-sm"></p>

                                                    <div class="flex flex-col gap-2 text-sm text-gray-600 mt-1">
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                                                            </svg>
                                                            <span data-preview="time"></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l4-8 4 4 4-6 4 10"/>
                                                            </svg>
                                                            <span>Dificultad: <span data-preview="difficulty"></span></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <rect x="1" y="3" width="15" height="13" rx="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8h4l3 3v5h-7V8z"/>
                                                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                                                <circle cx="18.5" cy="18.5" r="2.5"/>
                                                            </svg>
                                                            <span data-preview="transport"></span>
                                                        </div>
                                                    </div>

                                                    <div data-preview="price-wrap" class="hidden mt-auto pt-3 border-t border-gray-100">
                                                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5"><?= htmlspecialchars($header_ui['from']) ?></p>
                                                        <p class="text-2xl font-bold text-orange-500">
                                                            USD <span data-preview="price"></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Imagen del tour -->
                                                <div class="rounded-xl overflow-hidden bg-gray-100 h-full max-h-[300px]">
                                                    <img data-preview="img" src="" alt="Tour preview"
                                                        class="w-full h-full object-cover" style="display:none">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- EXPERIENCIA UNICAS -->
                        <li class="group" data-megamenu>
                            <a href="<?= $base_url ?>/destino/template-destino.php?destino=experiencias-unicas&lang=<?= $idioma ?>" class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                <?= $header_text['menu']['experiencia_unica'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible 
                                        group-hover:opacity-100 
                                        group-hover:visible 
                                        transition-all duration-300 z-[9999]">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 grid grid-cols-2 gap-8 text-[#333] text-sm font-normal normal-case">

                                        <!-- LEFT: lista de tours -->
                                        <div class="flex flex-col gap-1">
                                            <?php foreach($header_text['mega_menu']['experiencias_unicas']['links'] as $key => $tour): ?>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= htmlspecialchars($tour['url'] ?? $key) ?>&lang=<?= $idioma ?>"
                                                    class="tour-item group/item flex items-center justify-between gap-2 p-4 rounded-xl hover:bg-[#FFF7EF] transition duration-200 cursor-pointer"
                                                    data-title="<?= htmlspecialchars($tour['nombre']) ?>"
                                                    data-desc="<?= htmlspecialchars($tour['descripcion']) ?>"
                                                    data-price="<?= htmlspecialchars($tour['precio']) ?>"
                                                    data-time="<?= htmlspecialchars($tour['tiempo']) ?>"
                                                    data-difficulty="<?= htmlspecialchars($tour['dificultad']) ?>"
                                                    data-transport="<?= htmlspecialchars($tour['transporte']) ?>"
                                                    data-img="<?= $base_url ?><?= htmlspecialchars($tour['img']) ?>">

                                                    <span class=" transition duration-200 font-medium">
                                                        <?= htmlspecialchars($tour['nombre2'] ?? $tour['nombre'] ?? $key) ?>
                                                    </span>

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 shrink-0 text-gray-300 transition-all duration-300
                                                            group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                            group-hover/item:text-orange-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                    </svg>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- RIGHT: preview dinámico -->
                                        <div class="col-span-1 grid grid-cols-2 gap-4">

                                            <!-- ESTADO DEFAULT -->
                                            <div data-preview="default" class="col-span-2 grid grid-cols-2 gap-4">

                                                <!-- Info -->
                                                <div class="flex flex-col gap-4">
                                                    <div>
                                                        <h3 class="text-2xl font-medium font-anton-sub text-[#FF9300] mb-2 leading-snug">
                                                            <?= $header_text['mega_menu']['experiencias_unicas']['nombre'] ?>
                                                        </h3>
                                                        <p class="text-gray-500 leading-relaxed text-sm">
                                                            <?= $header_text['mega_menu']['experiencias_unicas']['descripcion'] ?>
                                                        </p>
                                                    </div>

                                                    <!-- Badges -->
                                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                                                            </svg>
                                                            Guías Profesional
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Asistencia 24/7
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Experiencia Local
                                                        </div>
                                                        <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                                            </svg>
                                                            Trekking
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Imágenes -->
                                                <div class="grid grid-cols-2 gap-2 rounded-xl overflow-hidden">
                                                    <div class="col-span-2 h-36 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['experiencias_unicas']['imgs']['pr'] ?>"
                                                            alt="Experiencias Únicas" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['experiencias_unicas']['imgs']['sec1'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="h-24 rounded-lg overflow-hidden">
                                                        <img src="<?= $base_url . $header_text['mega_menu']['experiencias_unicas']['imgs']['sec2'] ?>"
                                                            alt="Tour secundario" class="w-full h-full object-cover">
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- ESTADO HOVER -->
                                            <div data-preview="hover" class="col-span-2 grid grid-cols-2 gap-4 hidden">

                                                <!-- Info del tour -->
                                                <div class="flex flex-col gap-3">
                                                    <h3 data-preview="title" class="text-2xl font-medium font-anton-sub text-[#FF9300] leading-snug"></h3>
                                                    <p  data-preview="desc"  class="text-gray-500 leading-relaxed text-sm"></p>

                                                    <div class="flex flex-col gap-2 text-sm text-gray-600 mt-1">
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                                                            </svg>
                                                            <span data-preview="time"></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l4-8 4 4 4-6 4 10"/>
                                                            </svg>
                                                            <span>Dificultad: <span data-preview="difficulty"></span></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <rect x="1" y="3" width="15" height="13" rx="2"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8h4l3 3v5h-7V8z"/>
                                                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                                                <circle cx="18.5" cy="18.5" r="2.5"/>
                                                            </svg>
                                                            <span data-preview="transport"></span>
                                                        </div>
                                                    </div>

                                                    <div data-preview="price-wrap" class="hidden mt-auto pt-3 border-t border-gray-100">
                                                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5"><?= htmlspecialchars($header_ui['from']) ?></p>
                                                        <p class="text-2xl font-bold text-orange-500">
                                                            USD <span data-preview="price"></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Imagen del tour -->
                                                <div class="rounded-xl overflow-hidden bg-gray-100 h-full max-h-[300px]">
                                                    <img data-preview="img" src="" alt="Tour preview"
                                                        class="w-full h-full object-cover" style="display:none">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- PAQUETES PERU -->
                        <li class="group">
                            <a href="<?= $base_url ?>/destino/template-destino.php?destino=paquete-peru&lang=<?= $idioma ?>"  class="group flex items-center gap-1 px-2 hover:text-orange-200 transition">
                                <?= $header_text['menu']['paquete_peru'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- MEGA MENU -->
                            <div class="absolute left-0 top-full w-full
                                        opacity-0 invisible
                                        group-hover:opacity-100
                                        group-hover:visible
                                        transition-all duration-300 z-[9999]">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 text-[#333] text-sm font-normal normal-case">

                                        <!-- Links en grid de 2 columnas -->
                                        <div class="grid grid-cols-2 gap-x-12 gap-y-1">
                                            <?php foreach($header_text['mega_menu']['paquete_peru']['links'] as $key => $nombre): ?>
                                                <a href="#"
                                                    class="group/item flex items-center justify-between gap-2 px-2 py-2.5
                                                        rounded-lg hover:bg-[#FFF7EF] transition duration-200">
                                                    <span class="group-hover/item:text-orange-500 transition duration-200 font-medium">
                                                        <?= $nombre ?>
                                                    </span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-3.5 h-3.5 shrink-0 text-gray-300
                                                            group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5
                                                            group-hover/item:text-orange-500 transition-all duration-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                                                    </svg>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
   <!-- ============================================
     MENU MOBILE (panel deslizable + overlay)
     ============================================ -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-[10000] hidden lg:hidden"></div>

    <div id="mobile-menu-panel"
        class="fixed top-0 right-0 h-full w-[85%] max-w-sm bg-white z-[10001] shadow-2xl
                transform translate-x-full transition-transform duration-300 ease-in-out
                overflow-y-auto lg:hidden">

        <!-- Header del panel -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
            <img src="<?= $base_url ?>/images/gt-peru-travel.png" alt="GT Peru Travel" class="w-24">
            <button id="menu-close-btn" type="button" aria-label="Cerrar menú" class="text-gray-600 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Links principales del sitio (los que estaban en banner-social) -->
        <div class="p-4 border-b border-gray-200 space-y-1">
            <a href="<?= $base_url ?>/blog.php?lang=<?= $idioma ?>"
            class="flex items-center justify-between py-3 px-2 text-gray-700 font-medium text-sm hover:bg-gray-50 rounded-lg">
                <?= $header_text['banner_social']['extra_links']['blog'] ?>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-400"></i>
            </a>
            <a href="<?= $base_url ?>/?lang=<?= urlencode($idioma) ?>#trip-advisor"
            class="flex items-center justify-between py-3 px-2 text-gray-700 font-medium text-sm hover:bg-gray-50 rounded-lg">
                <?= $header_text['banner_social']['extra_links']['testimonios'] ?>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-400"></i>
            </a>
            <a href="<?= $base_url ?>/nosotros.php?lang=<?= $idioma ?>"
            class="flex items-center justify-between py-3 px-2 text-gray-700 font-medium text-sm hover:bg-gray-50 rounded-lg">
                <?= $header_text['banner_social']['extra_links']['nosotros'] ?>
            </a>
        </div>

        <!-- Menú principal (acordeones) -->
        <div class="p-4 space-y-2">

            <!-- DESTINOS -->
            <div class="mobile-accordion border-b border-gray-100 pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['destinos'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class=" font-poppins mobile-accordion-panel hidden pl-2 pb-2 space-y-1">
                    <?php
                    $destinos_menu = ['lima', 'manu_tambopata', 'arequipa', 'puno', 'huaraz'];
                    foreach ($destinos_menu as $d): ?>
                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=<?= $d ?>&lang=<?= $idioma ?>"
                        class="block py-2 text-gray-600 text-sm hover:text-orange-custom">
                            <?= $header_text['mega_menu']['destinos'][$d]['nombre'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- TOUR CUSCO -->
            <div class="mobile-accordion border-b border-gray-100 pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['tour_cusco'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class=" font-poppins mobile-accordion-panel hidden pl-2 pb-2">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mt-2 mb-1"><?= $header_text['mega_menu']['tour_cusco']['tradicionales']['title'] ?></p>
                    <?php foreach ($header_text['mega_menu']['tour_cusco']['tradicionales']['links'] as $key => $nombre): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $nombre ?></a>
                    <?php endforeach; ?>

                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mt-3 mb-1"><?= $header_text['mega_menu']['tour_cusco']['caminata']['title'] ?></p>
                    <?php foreach ($header_text['mega_menu']['tour_cusco']['caminata']['links'] as $key => $nombre): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $nombre ?></a>
                    <?php endforeach; ?>

                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mt-3 mb-1"><?= $header_text['mega_menu']['tour_cusco']['aventura']['title'] ?></p>
                    <?php foreach ($header_text['mega_menu']['tour_cusco']['aventura']['links'] as $key => $nombre): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $nombre ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- MACHUPICCHU -->
            <div class="mobile-accordion border-b border-gray-100 pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['machupicchu'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class=" font-poppins mobile-accordion-panel hidden pl-2 pb-2 space-y-1">
                    <?php foreach ($header_text['mega_menu']['machupicchu']['links'] as $key => $tour): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $tour['nombre'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- GLACIARES -->
            <div class="mobile-accordion border-b border-gray-100 pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['glaciares_cusco'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class=" font-poppins mobile-accordion-panel hidden pl-2 pb-2 space-y-1">
                    <?php foreach ($header_text['mega_menu']['glaciares']['links'] as $key => $tour): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $tour['nombre'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- EXPERIENCIAS UNICAS -->
            <div class="mobile-accordion border-b border-gray-100 pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['experiencia_unica'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class=" font-poppins mobile-accordion-panel hidden pl-2 pb-2 space-y-1">
                    <?php foreach ($header_text['mega_menu']['experiencias_unicas']['links'] as $key => $tour): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $tour['nombre'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PAQUETE PERU -->
            <div class="mobile-accordion pb-2">
                <button type="button" class="mobile-accordion-toggle w-full flex items-center justify-between py-3 text-left font-medium text-gray-900 text-sm uppercase tracking-wide">
                    <?= $header_text['menu']['paquete_peru'] ?>
                    <i class="fa-solid fa-chevron-down text-orange-custom text-xs mobile-accordion-icon transition-transform"></i>
                </button>
                <div class="mobile-accordion-panel hidden pl-2 pb-2 space-y-1 font-poppins ">
                    <?php foreach ($header_text['mega_menu']['paquete_peru']['links'] as $key => $nombre): ?>
                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $key ?>&lang=<?= $idioma ?>" class="block py-2 text-gray-600 text-sm hover:text-orange-custom"><?= $nombre ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- CTA + idiomas al final del panel -->
        <div class="p-4 border-t border-gray-200">
            <a href="<?= $base_url ?>/contacto.php?lang=<?= $idioma ?>"
            class="flex items-center justify-center gap-2 bg-orange-custom hover:bg-[#ff7a00] transition text-white font-medium text-sm px-5 py-3 rounded-lg mb-4">
                <?= $header_text['banner_social']['extra_links']['impacto'] ?>
            </a>
            <div class="flex items-center justify-center gap-3">
                <a href="<?= cambiarIdioma('es') ?>"><img src="<?= $base_url ?>/images/es.png" width="26" alt="Español"></a>
                <a href="<?= cambiarIdioma('en') ?>"><img src="<?= $base_url ?>/images/en.png" width="26" alt="English"></a>
                <a href="<?= cambiarIdioma('pt') ?>"><img src="<?= $base_url ?>/images/pt.png" width="26" alt="Português"></a>
            </div>
        </div>

    </div>
</header>
