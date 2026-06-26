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
                            class="group flex items-center gap-1 px-2 h-12 hover:text-orange-200 transition">
                                
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
                                        group-hover:opacity-100
                                        group-hover:visible
                                        transition-all duration-300
                                        z-[9999]  ">

                                <div class="bg-white shadow-2xl rounded-2xl p-8">
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
                            <a href="#" class=" group flex items-center gap-1 px-2 h-12 hover:text-orange-200 transition">
                                <?= $header_text['menu']['tour_cusco'] ?>
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
                            
                        </li>

                                                <!-- MACHU PICCHU -->
                        <li class="group relative">

                            <a href="#" class="flex items-center gap-1 px-2 h-12 hover:text-orange-200 transition">
                                <?= $header_text['menu']['machupicchu'] ?>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 opacity-80 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" viewBox="0 0 20 20">
                                    <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- MEGA MENU -->
                            <div id="mega-menu-mp"
                                class="fixed left-0 w-screen
                                    opacity-0 invisible pointer-events-none
                                    group-hover:opacity-100 group-hover:visible group-hover:pointer-events-auto
                                    transition-all duration-300 z-[9999]"
                                style="top: var(--header-nav-bottom, 144px);">

                                <div class="container-custom mx-auto">
                                    <div class="bg-white shadow-2xl rounded-2xl p-8 grid grid-cols-2 gap-8 text-[#333] text-sm font-normal normal-case">

                                        <!-- LEFT: lista de tours -->
                                        <div class="flex flex-col gap-1">
                                            <?php foreach($header_text['mega_menu']['machupicchu']['links'] as $key => $tour): ?>
                                                <a href="#"
                                                    class="tour-item group/item flex items-center justify-between gap-2 p-4 rounded-xl hover:bg-[#FFF7EF] transition duration-200 cursor-pointer"
                                                    data-title="<?= htmlspecialchars($tour['nombre']) ?>"
                                                    data-desc="<?= htmlspecialchars($tour['descripcion']) ?>"
                                                    data-price="<?= htmlspecialchars($tour['precio']) ?>"
                                                    data-time="<?= htmlspecialchars($tour['tiempo']) ?>"
                                                    data-difficulty="<?= htmlspecialchars($tour['dificultad']) ?>"
                                                    data-transport="<?= htmlspecialchars($tour['transporte']) ?>"
                                                    data-img="<?= $base_url ?>/images/tours/machupicchu/<?= $key ?>.webp">

                                                    <span class="group-hover/item:text-orange-500 transition duration-200 font-medium">
                                                        <?= $tour['nombre'] ?>
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
                                        <div id="preview-box" class="grid grid-cols-2 gap-4"
                                            data-default-title="Tours Machupicchu"
                                            data-default-desc="Descubre el corazón del Imperio Incaico con experiencias únicas diseñadas para todos los viajeros."
                                            data-default-price="---"
                                            data-default-time="-"
                                            data-default-difficulty="-"
                                            data-default-transport="-"
                                            >

                                            <!-- Título y descripción -->
                                            <div class="">
                                                <h3 id="preview-title" class="text-xl font-bold text-orange-500 mb-2 leading-snug transition-all duration-200">
                                                    <?= $header_text['mega_menu']['machupicchu']['nombre'] ?>
                                                </h3>
                                                <p id="preview-desc" class="text-gray-500 leading-relaxed text-sm transition-all duration-200">
                                                    <?= $header_text['mega_menu']['machupicchu']['descripcion'] ?>
                                                </p>
                                                    <!-- Detalles -->
                                                <div class="flex flex-col gap-2 text-sm text-gray-600">

                                                    <div class="flex items-center gap-2">
                                                        <!-- ícono reloj -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                                                        </svg>
                                                        <span id="preview-time">-</span>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <!-- ícono dificultad -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l4-8 4 4 4-6 4 10"/>
                                                        </svg>
                                                        <span>Dificultad: <span id="preview-difficulty">-</span></span>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <!-- ícono transporte -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <rect x="1" y="3" width="15" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
                                                        </svg>
                                                        <span id="preview-transport">-</span>
                                                    </div>

                                                </div>

                                                <!-- Precio -->
                                                <div id="preview-price-wrap" class="hidden mt-auto pt-3 border-t border-gray-100">
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Desde</p>
                                                    <p class="text-2xl font-bold text-orange-500">
                                                        USD <span id="preview-price">---</span>
                                                    </p>
                                                </div>
                                            </div>


                                            <!-- Imagen -->
                                            <div id=" preview-img-wrap" class="grid grid-cols-2 gap-4 rounded-xl  overflow-hidden bg-gray-100  transition-all duration-200">
                                                <div class="col-span-2">
                                                    <img id="preview-img"
                                                        src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['pr'] ?>"
                                                        alt="Tour preview"
                                                        class="w-full h-full object-cover transition duration-300"
                                                        onerror="this.style.display='none'"
                                                    >
                                                </div>
                                                <div class="col-span-1">
                                                    <img id="preview-img"
                                                        src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['sec1'] ?>"
                                                        alt="Tour preview"
                                                        class="w-full h-full object-cover transition duration-300"
                                                        onerror="this.style.display='none'"
                                                    >
                                                </div>
                                                <div class="col-span-1">
                                                    <img id="preview-img"
                                                        src="<?= $base_url . $header_text['mega_menu']['machupicchu']['imgs']['sec2'] ?>"
                                                        alt="Tour preview"
                                                        class="w-full h-full object-cover transition duration-300"
                                                        onerror="this.style.display='none'"
                                                    >
                                                </div>
                                                
                                            </div>  

                                            

                                        </div>

                                    </div>
                                </div>
                            </div>
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