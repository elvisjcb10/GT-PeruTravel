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
    <section id="banner-promotions" class="bg-[#1C1C1C]  text-white text-sm font-poppins">
        <div class="container-custom  ">
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
    <section id="banner-social" class="bg-white shadow-sm border-b ">
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
    <!--navbar menu-->
    <section id="nav-menu">
        <div class="bg-[#F97316] text-white shadow-md font-poppins">
            <div class="container-custom mx-auto px-4">

                <nav class="relative">

                    <!-- Botón mobile -->
                    <button id="menu-btn"
                        class="absolute left-0 top-1/2 -translate-y-1/2 md:hidden text-white z-50">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Menu desktop -->
                    <ul id="menu"
                        class="hidden md:flex relative w-full items-center justify-center gap-12 h-12 text-[14px] font-semibold uppercase tracking-[0.4px]">

                        <!-- DESTINOS -->
                        <li class="group">
                            <a href="<?= $base_url ?>/?lang=<?= $idioma ?>"
                                class="flex items-center gap-1 px-2 h-12 hover:text-orange-100 transition">
                                <?= $header_text['menu']['destinos'] ?>

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 opacity-80"
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
                                        group-hover:opacity-100
                                        group-hover:visible
                                        transition-all duration-300
                                        z-[9999]  ">

                                <div class="bg-white shadow-2xl rounded-b-2xl p-8">
                                    <div class="grid grid-cols-5 gap-6">

                                        <!-- lima-->
                                        <a href="#" class="group block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['lima']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['lima']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- Manu -->
                                        <a href="#" class="group block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['manu_tambopata']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['manu_tambopata']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="group block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['arequipa']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['arequipa']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="group block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['puno']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-3">
                                                    <span class="text-white text-lg font-bold">
                                                        <?= $header_text['mega_menu']['destinos']['puno']['nombre'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="group block rounded-xl overflow-hidden shadow-md">
                                            <div class="relative h-48">
                                                <img src="<?= $base_url ?><?= $header_text['mega_menu']['destinos']['huaraz']['img'] ?>"
                                                    alt="Lima"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

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
                        <li>
                            <a href="#" class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['tour_cusco'] ?>
                            </a>
                        </li>

                        <!-- MACHU PICCHU -->
                        <li>
                            <a href="#" class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['machupicchu'] ?>
                            </a>
                        </li>

                        <!-- GLACIARES -->
                        <li>
                            <a href="#" class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['glaciares_cusco'] ?>
                            </a>
                        </li>

                        <!-- EXPERIENCIA -->
                        <li>
                            <a href="#" class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['experiencia_unica'] ?>
                            </a>
                        </li>

                        <!-- PAQUETES -->
                        <li>
                            <a href="#" class="flex items-center gap-1 hover:text-orange-100 transition">
                                <?= $header_text['menu']['paquete_peru'] ?>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </section>

</header>