<?php
require_once __DIR__ . "/config/environment.php";
?>

<header>

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
    $idioma = $GLOBALS['lang'] ?? ($_GET['lang'] ?? "es");

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

    <!-- banner infp    -->
    <section id="banner-promotions" class="bg-[#1C1C1C] text-white text-sm font-poppins">
        <div class="container-custom mx-auto px-4">
            
            <div class="flex flex-col md:flex-row items-center justify-between py-2 gap-3">

                <!-- Left -->
                <div class="flex items-center gap-6">
                    
                    <p class="text-[#A0A0A0] text-[13px] flex items-center gap-2">
                        <?= get_icon('clock', 'w-4 h-4'); ?>
                         <?= $header_text['banner_social']['horario'] ?>
                    </p>

                    <p class="text-[#A0A0A0] text-[13px] flex items-center gap-2" >
                        <?= get_icon('phone', 'w-4 h-4'); ?>
                        <?= $header_text['banner_social']['telefono'] ?>
                    </p>

                </div>

                <div class="flex items-center gap-4">

                    <!-- redes sociales -->
                    <div class="flex items-center gap-4">
                        
                        <a href="https://www.facebook.com/gtperutravel"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-[#1877F2] transition duration-300">
                                <?= get_icon('facebook', 'w-5 h-5'); ?>
                            </span>
                            <span class="absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                Facebook
                            </span>
                        </a>

                        <a href="https://www.instagram.com/gtperutravel_oficial/"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-pink-500 transition duration-300">
                                <?= get_icon('instagram', 'w-5 h-5'); ?>
                            </span>
                            <span class="absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                Instagram
                            </span>
                        </a>

                        <a href="https://www.youtube.com/@gtperutravel9213"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-red-500 transition duration-300">
                                <?= get_icon('youtube', 'w-5 h-5'); ?>
                            </span>
                            <span class="absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                YouTube
                            </span>
                        </a>

                        <a href="https://www.tiktok.com/@gt_peru_travel"
                        target="_blank"
                        class="relative group">
                            <span class="text-gray-400 group-hover:text-cyan-400 transition duration-300">
                                <?= get_icon('tiktok', 'w-5 h-5'); ?>
                            </span>
                            <span class="absolute top-full mt-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-black px-2 py-1 rounded text-xs whitespace-nowrap transition z-50">
                                TikTok
                            </span>
                        </a>

                    </div>

                    <!-- linea -->
                    <div class="w-px h-5 bg-gray-600"></div>

                    <!-- idiomas -->
                    <div class="hidden md:flex items-center gap-2">
                        <a href="<?= cambiarIdioma('es') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/es.png" width="24" alt="Español">
                        </a>

                        <a href="<?= cambiarIdioma('en') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/en.png" width="24" alt="English">
                        </a>

                        <a href="<?= cambiarIdioma('pt') ?>" class="hover:scale-110 transition">
                            <img src="<?= $base_url ?>/images/pt.png" width="24" alt="Português">
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- banner social-->
    <section id="banner-social" class="bg-white shadow-sm border-b border-gray-100">
        <div class="container-custom  px-4 font-poppins">

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 py-3">

                <!-- Logo -->
                <div class="shrink-0">
                    <a href="<?= $base_url ?>?lang=<?= $idioma ?>">
                        <img 
                            src="<?= $base_url ?>/images/gt-peru-travel.png"
                            alt="GT Peru Travel"
                            class="w-24 md:w-36 hover:scale-105 transition duration-300"
                        >
                    </a>
                </div>

                <!-- Links -->
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-[#333]">

                    <a href="https://www.gtperutravel.com/blog"
                    target="_blank"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['blog'] ?>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>

                    <a href="https://www.gtperutravel.com/recomendaciones"
                    target="_blank"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['testimonios'] ?>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>
                    <a href="https://www.gtperutravel.com/recomendaciones"
                    target="_blank"
                    class="group flex items-center gap-1 hover:text-[#ff9300] transition duration-300">
                        <?= $header_text['banner_social']['extra_links']['nosotros'] ?>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h6m0 0v6m0-6L10 16"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/<?= $footer['whatsapp'] ?>"
                    target="_blank"
                    class="inline-flex items-center gap-2 bg-[#ff9300] hover:bg-[#ff7a00]
                            hover:shadow-lg hover:-translate-y-0.5
                            transition duration-300 text-white px-5 py-2.5 rounded-lg font-semibold group">

                        <?= $header_text['banner_social']['extra_links']['impacto'] ?>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 group-hover:translate-x-1 transition duration-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 12h18m0 0l-4-4m4 4l-4 4"/>
                        </svg>
                    </a>

                </div>


            </div>

        </div>
    </section>
    <!--Linuz-->
    <section id="nav-menu">
        <div class="bg-[#F97316] text-white shadow-md font-poppins">
            <div class="container-custom mx-auto px-4">

                <nav class="relative">

                    <!-- Botón mobile -->
                    <button id="menu-btn"
                        class="absolute left-0 top-1/2 -translate-y-1/2 md:hidden text-white z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Menu desktop -->
                    <ul id="menu"
                        class="hidden md:flex items-center justify-center gap-12 h-12 text-[14px] font-semibold uppercase tracking-[0.4px]">

                        <li>
                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['destinos'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="#"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['tour_cusco'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="#"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['machupicchu'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="#"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['glaciares_cusco'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="#"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['experiencia_unica'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="#"
                            class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['paquete_peru'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
                                    fill="none"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 8l4 4 4-4"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
    </section>


    <section id="nav-menu">
        <div class="bg-black text-white relative z-50 bg-[#F97316]">
            <div class="container-custom mx-auto px-4">
                <nav class="flex flex-col md:flex-row items-center justify-center py-3 relative">

                    <!-- Botón hamburguesa (solo visible en móviles) -->
                    <button id="menu-btn" class="absolute left-4 md:hidden text-white focus:outline-none z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Enlaces del menú (centrados en PC) -->
                    <ul id="menu"
                        class="hidden md:flex justify-center items-center space-x-6 text-[1rem] font-medium w-full">
                        <li>
                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['destinos'] ?>
                            </a>
                        </li>

                        <!-- Adjuntar en la URL Siempre el idioma para que redireccione -->
                        <li class="relative group">
                            <a href="#"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['tour_cusco'] ?>
                            </a>

                            <!-- Sub menú -->
                            <div class="absolute left-1/2 -translate-x-1/2 top-full hidden group-hover:block bg-black text-white shadow-2xl rounded-lg z-[999] min-w-[700px] max-w-[90vw] pt-4">
                                <div class="grid grid-cols-3 gap-8 p-8 text-sm">

                                    <!-- Columna 1 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['col1_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=vallesagrado-machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['machupicchu_valle'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=short-inca-trail&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['camino_inca_corto'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['col2_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-magico&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_magico'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-prime&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_prime'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=cusco-magico&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['cusco_magico'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 3 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['col3_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-premium&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_premium'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-mistico&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_mistico'] ?>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="mt-4">
                                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#nuestros-paquetes" class="font-semibold text-orange-custom hover:underline">
                                                <?= $header_text['mega_menu']['paquetes_turisticos']['ver_todos'] ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>


                        <li class="relative group">
                            <a href="#"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['machupicchu'] ?>
                            </a>

                            <!-- Sub menú Machu Picchu -->
                            <div class="absolute left-1/2 -translate-x-1/2 top-full hidden group-hover:block bg-black text-white shadow-2xl rounded-lg z-[999] min-w-[700px] max-w-[90vw] pt-4">
                                <div class="grid grid-cols-3 gap-8 p-8 text-sm">

                                    <!-- Columna 1 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['col1_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_1_dia'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=vallesagrado-machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_2d_1n'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['tren_panoramico'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['col2_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['huayna_picchu'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['montana_mp'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['huchuy_picchu'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 3 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['col3_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=vallesagrado-machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_valle'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['tren_lujo'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_premium'] ?>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="mt-4">
                                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#nuestros-paquetes" class="font-semibold text-orange-custom hover:underline">
                                                <?= $header_text['mega_menu']['paquetes_machupicchu']['ver_todos'] ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>


                        <li class="relative group">
                            <a href="#"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['glaciares_cusco'] ?>
                            </a>

                            <!-- Mega menú Tours -->
                            <div class="absolute left-1/2 -translate-x-1/2 top-full hidden group-hover:block bg-black text-white shadow-2xl rounded-lg z-[999] min-w-[700px] max-w-[90vw] pt-4">
                                <div class="grid grid-cols-3 gap-8 p-8 text-sm">

                                    <!-- Columna 1 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['tours']['col1_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['machupicchu'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=laguna-humantay&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['humantay'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=montana-colores&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['rainbow'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['tours']['col2_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=glaciar-quelccaya-suyuparina&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['quelccaya'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=puente-inca&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['qeswachaka'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=fortaleza-cuernos&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['waqrapukara'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Columna 3 -->
                                    <div>
                                        <h4 class="font-semibold text-orange-custom mb-3">
                                            <?= $header_text['mega_menu']['tours']['col3_title'] ?>
                                        </h4>
                                        <ul class="space-y-2">
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['mp_full_day'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['mp_montana'] ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=short-inca-trail&lang=<?= $idioma ?>" class="hover-orange-custom transition-colors duration-200">
                                                    <?= $header_text['mega_menu']['tours']['links']['mp_huayna'] ?>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="mt-4">
                                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#tours" class="font-semibold text-orange-custom hover:underline">
                                                <?= $header_text['mega_menu']['tours']['ver_todos'] ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>


                        <li>
                            <a href="<?= $base_url ?>/legal.php?doc=contacto&lang=<?= $idioma ?>"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['experiencia_unica'] ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $base_url ?>/legal.php?doc=contacto&lang=<?= $idioma ?>"
                                class="inline-flex items-center justify-center rounded-md bg-black-custom text-white px-4 py-2 text-sm font-semibold hover:bg-black-custom-hov transition-colors duration-200 shadow-sm">
                                <?= $header_text['menu']['paquete_peru'] ?>
                            </a>
                        </li>

                    </ul>
                </nav>


                <!-- Menú móvil lateral -->
                <div id="mobile-menu" class="hidden fixed inset-0 bg-black/80 z-50 md:hidden">

                    <!-- Panel lateral -->
                    <div id="menu-panel"
                        class="bg-black text-white w-64 h-full p-5 flex flex-col space-y-6 animate-slide-in font-[Poppins] relative">

                        <!-- Botón cerrar -->
                        <button id="closeMenuBtn"
                            class="absolute top-3 right-3 text-3xl text-white hover:text-orange-400">&times;</button>

                        <!-- Enlaces del menú -->
                        <ul class="flex flex-col space-y-3 text-[1rem] font-medium mt-10">
                            <li>
                                <a href="<?= $base_url ?>/?lang=<?= $idioma ?>" class="hover:text-orange-400">
                                    <?= $header_text['menu']['inicio'] ?>
                                </a>
                            </li>

                            <li>
                                <button class="w-full flex justify-between items-center toggle-submenu hover:text-orange-custom">
                                    <?= $header_text['menu']['paquetes_turisticos'] ?>
                                    <span>+</span>
                                </button>

                                <ul class="submenu hidden pl-4 mt-2 space-y-2 text-sm">
                                    <li class="text-orange-custom font-semibold mt-2">
                                        <?= $header_text['mega_menu']['paquetes_turisticos']['col1_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=vallesagrado-machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['links']['machupicchu_valle'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=short-inca-trail&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['links']['camino_inca_corto'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['paquetes_turisticos']['col2_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-magico&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_magico'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['paquetes_turisticos']['col3_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=peru-premium&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['links']['peru_premium'] ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#nuestros-paquetes" class="block text-orange-custom font-semibold mt-2">
                                            <?= $header_text['mega_menu']['paquetes_turisticos']['ver_todos'] ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <button class="w-full flex justify-between items-center toggle-submenu hover:text-orange-custom">
                                    <?= $header_text['menu']['paquetes_machupicchu'] ?>
                                    <span>+</span>
                                </button>

                                <ul class="submenu hidden pl-4 mt-2 space-y-2 text-sm">

                                    <li class="text-orange-custom font-semibold mt-2">
                                        <?= $header_text['mega_menu']['paquetes_machupicchu']['col1_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_1_dia'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=vallesagrado-machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_2d_1n'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['paquetes_machupicchu']['col2_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['huayna_picchu'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['montana_mp'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['paquetes_machupicchu']['col3_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['links']['mp_premium'] ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#nuestros-paquetes" class="block text-orange-custom font-semibold mt-2">
                                            <?= $header_text['mega_menu']['paquetes_machupicchu']['ver_todos'] ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <button class="w-full flex justify-between items-center toggle-submenu hover:text-orange-custom">
                                    <?= $header_text['menu']['tours'] ?>
                                    <span>+</span>
                                </button>

                                <ul class="submenu hidden pl-4 mt-2 space-y-2 text-sm">

                                    <li class="text-orange-custom font-semibold mt-2">
                                        <?= $header_text['mega_menu']['tours']['col1_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['machupicchu'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=laguna-humantay&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['humantay'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=montana-colores&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['rainbow'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['tours']['col2_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=glaciar-quelccaya-suyuparina&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['quelccaya'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=puente-inca&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['qeswachaka'] ?>
                                        </a>
                                    </li>

                                    <li class="text-orange-custom font-semibold mt-3">
                                        <?= $header_text['mega_menu']['tours']['col3_title'] ?>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=machupicchu&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['mp_full_day'] ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=short-inca-trail&lang=<?= $idioma ?>" class="block hover-orange-custom">
                                            <?= $header_text['mega_menu']['tours']['links']['mp_huayna'] ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= $base_url ?>/?lang=<?= $idioma ?>#tours" class="block text-orange-custom font-semibold mt-2">
                                            <?= $header_text['mega_menu']['tours']['ver_todos'] ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <a href="<?= $base_url ?>/legal.php?doc=contacto&lang=<?= $idioma ?>" class="hover:text-orange-400">
                                    <?= $header_text['menu']['contacto'] ?>
                                </a>
                            </li>

                        </ul>

                        <hr class="border-gray-700">

                        <!-- Horario y contacto -->
                        <div class="text-sm leading-tight space-y-1">
                            <p>🕘 <?= $header_text['banner_social']['horario'] ?></p>
                            <p><a href="https://wa.me/51982770013" target="_blank" class="hover:text-orange-400">📞 +51 982 770 013</a></p>
                        </div>

                        <hr class="border-gray-700">

                        <!-- Enlaces adicionales -->
                        <div class="flex flex-col space-y-2 text-sm font-medium">
                            <a href="<?= $base_url ?>/blog" target="_blank" class="hover:text-orange-400"><?= $header_text['banner_social']['extra_links']['blog'] ?></a>
                            <a href="<?= $base_url ?>/recomendaciones" target="_blank" class="hover:text-orange-400"><?= $header_text['banner_social']['extra_links']['tips'] ?></a>
                            <a href="<?= $base_url ?>/proyectos" target="_blank" class="hover:text-orange-400"><?= $header_text['banner_social']['extra_links']['impacto'] ?></a>
                        </div>

                        <hr class="border-gray-700">

                        <!-- Banderas idiomas -->
                        <div class="flex flex-row space-x-2 text-sm font-medium">
                            <a href="<?= cambiarIdioma('es') ?>"><img src="<?= $base_url ?>/images/es.png" width="32"></a>
                            <a href="<?= cambiarIdioma('en') ?>"><img src="<?= $base_url ?>/images/en.png" width="32"></a>
                            <a href="<?= cambiarIdioma('pt') ?>"><img src="<?= $base_url ?>/images/pt.png" width="32"></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


</header>