<!-- home -->
<main>
    <!-- ******************** 
          Hero
     *********************** -->
    <section id="video" class="relative w-full h-[92vh] sm:h-[85vh] md:h-[82vh] min-h-[600px] sm:min-h-[650px] bg-black overflow-hidden">

        <!-- imagen de fondo -->
        <img class="absolute top-0 left-0 w-full h-full object-cover"
            src="<?= $base_url ?>/images/inicio/hero.webp"
            alt="Machu Picchu - GT Peru Travel">

        <!-- overlays para legibilidad del texto -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

        <!-- contenido principal -->
        <div class="relative z-10 h-full flex items-center justify-center pb-28 sm:pb-0">
            <div class="container-custom px-5 sm:px-8 md:px-20 w-full">
                <div class="max-w-2xl">

                    <h1 class="text-white text-[2rem] sm:text-4xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.1] drop-shadow-lg">
                        <?= html_entity_decode($hero_text['titulo']) ?>
                    </h1>

                    <p class="mt-4 sm:mt-6 text-white/90 text-sm sm:text-base md:text-lg font-poppins font-light max-w-xl">
                        <?= html_entity_decode($hero_text['subtitulo']) ?>
                    </p>

                    <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-3 sm:gap-4">

                        <a href="paquete/template-paquete.php?paquete=peru-mistico&lang=<?= htmlspecialchars($idioma) ?>"
                            class="inline-flex items-center px-5 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            <?= html_entity_decode($hero_text['boton1']) ?>
                        </a>

                        <a href="#experiencias"
                            class="inline-flex items-center px-5 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base border-2 border-white/70 text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-white hover:text-black">
                            <?= html_entity_decode($hero_text['boton2']) ?>
                        </a>

                    </div>

                </div>
            </div>
        </div>

        <!-- logo tripadvisor (visible en todos los tamaños, más chico en mobile) -->
        <div class="flex absolute z-10 bottom-28 left-1/2 -translate-x-1/2 sm:left-auto sm:right-10 sm:translate-x-0 gap-1 sm:gap-2">
            <img src="<?= $base_url ?>/images/tripadvisor/sticker2024.png" alt="Tripadvisor Travelers' Choice" class="h-20 sm:h-20 md:h-28">
            <img src="<?= $base_url ?>/images/tripadvisor/sticker2025.png" alt="Tripadvisor Travelers' Choice" class="h-20 sm:h-20 md:h-28">
            <img src="<?= $base_url ?>/images/tripadvisor/sticker2026.png" alt="Tripadvisor Travelers' Choice" class="h-20 sm:h-20 md:h-28">
        </div>

        <!-- barra de estadísticas -->
        <div class="absolute bottom-0 left-0 w-full z-10 bg-black/30 sm:bg-black/20 backdrop-blur-sm">
            <div class="container-custom mx-auto px-4 sm:px-6 py-3 sm:py-5">
                <div class="grid grid-cols-2 sm:flex sm:flex-wrap sm:justify-center gap-y-3 gap-x-4 sm:gap-x-10 md:gap-x-16 lg:gap-x-20">

                    <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                        <i class="fa-solid fa-mountain text-orange-custom text-lg sm:text-2xl"></i>
                        <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                            <p class="text-white text-base sm:text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['destinos']['numero'] ?>+</p>
                            <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['destinos']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                        <i class="fa-solid fa-people-group text-orange-custom text-lg sm:text-2xl"></i>
                        <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                            <p class="text-white text-base sm:text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['viajeros']['numero'] ?>+</p>
                            <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['viajeros']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                        <i class="fa-solid fa-star text-orange-custom text-lg sm:text-2xl"></i>
                        <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                            <p class="text-white text-base sm:text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['calificacion']['numero'] ?></p>
                            <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['calificacion']['titulo'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                        <i class="fa-solid fa-globe text-orange-custom text-lg sm:text-2xl"></i>
                        <div class="text-left flex flex-col gap-0.5 sm:gap-1">
                            <p class="text-white text-base sm:text-2xl font-anton leading-none"><?= $hero_text['caracteristicas']['años']['numero'] ?>+</p>
                            <p class="text-white/70 text-[0.6rem] sm:text-xs font-poppins uppercase tracking-wide"><?= $hero_text['caracteristicas']['años']['titulo'] ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- ******************** 
         nosotros - empresa
     *********************** -->
    <section class="container-custom mx-auto px-5 sm:px-8 md:px-20 py-12 sm:py-16 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 md:gap-16 items-center">

            <!-- IMAGEN + BADGE AÑOS -->
            <div class="relative reveal-left">
                <img src="<?= $base_url . $about_text['img'] ?>"
                    alt="<?= $about_text['title_primary'] . ' ' . $about_text['title_secondary'] ?>"
                    class="w-full h-[280px] sm:h-[360px] md:h-[480px] object-cover object-bottom rounded-2xl shadow-lg">

                <div class="absolute -bottom-5 right-4 sm:-bottom-6 sm:right-6 md:right-10 w-20 h-20 sm:w-28 sm:h-28 md:w-32 md:h-32 bg-orange-custom rounded-full flex flex-col items-center justify-center text-white text-center shadow-lg">
                    <span class="text-xl sm:text-3xl md:text-4xl font-anton leading-none"><?= $about_text['años']['numero'] ?>+</span>
                    <span class="text-[0.5rem] sm:text-[0.6rem] md:text-xs font-poppins uppercase tracking-wide leading-tight px-1 sm:px-2">
                        <?= $about_text['años']['titulo'] ?>
                    </span>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="reveal-right mt-8 md:mt-0">
                <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $about_text['subtitle'] ?>
                </p>

                <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton mb-3 sm:mb-4 leading-tight">
                    <span class="text-gray-900"><?= $about_text['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $about_text['title_secondary'] ?></span>
                </h2>

                <p class="text-gray-600 font-poppins font-light text-sm sm:text-base md:text-lg mb-6 sm:mb-8">
                    <?= $about_text['description'] ?>
                </p>

                <!-- FEATURES 2x2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <?php
                    $icons = [
                        'f1' => 'fa-person-hiking',
                        'f2' => 'fa-user-shield',
                        'f3' => 'fa-people-group',
                        'f4' => 'fa-mountain',
                    ];
                    foreach ($about_text['features'] as $key => $feature): ?>
                        <div class="flex items-start gap-3">
                            <i class="fa-solid <?= $icons[$key] ?? 'fa-check' ?> text-black text-lg sm:text-xl mt-1"></i>
                            <div>
                                <h4 class="font-bold font-poppins text-sm md:text-base text-gray-900">
                                    <?= $feature['title'] ?>
                                </h4>
                                <p class="text-gray-500 font-poppins text-xs md:text-sm">
                                    <?= $feature['description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <a href="<?= $base_url ?>/nosotros.php?lang=<?= $idioma ?>"
                class="hover:scale-105 inline-flex items-center w-full sm:w-auto justify-center px-6 sm:px-7 py-3 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                    <?= $about_text['boton'] ?>
                </a>
            </div>

        </div>
    </section>
    <!-- ************************ 
        mejores TOURS 
    *********************** -->
    <section id="tours" class="py-12 bg-white">

        <div class="container-custom mx-auto px-5 sm:px-8 md:px-20 space-y-6 sm:space-y-8 reveal">

            <!-- Titulo -->
            <div class="container-custom mx-auto px-0">

                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $tours_text['kicker'] ?>
                </p>

                <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton mb-3 sm:mb-4 leading-tight">
                    <span class="text-gray-900"><?= $tours_text['tours'] ?></span>
                    <span class="text-orange-custom"><?= $tours_text['mas_solicitados'] ?></span>
                </h2>

                <p class="text-gray-600 font-poppins font-light text-sm sm:text-base">
                    <?= $tours_text['descripcion'] ?>
                </p>

            </div>

            <!-- ************************ 
                CARRUSEL DE TOURS
            *********************** -->
            <div class="swiper-outer">
                <div class="auto-swiper relative" data-desktop="3" data-tablet="2" data-mobile="1" data-gap="24">
                    <div class="swiper-wrapper">

                        <?php foreach ($tours as $t) : ?>
                            <div class="swiper-slide h-auto">
                                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">

                                    <!-- Link envolvente -->
                                    <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>" class="block">

                                        <!-- IMAGEN -->
                                        <div class="relative h-56 sm:h-72 md:h-80 w-full overflow-hidden px-1 pt-1">
                                            <img src="<?= $base_url ?>/images/<?= $t['image'] ?>"
                                                alt="<?= $t['title'] ?>"
                                                class="w-full h-full object-cover rounded-lg shadow-md">
                                        </div>

                                        <!-- CONTENIDO -->
                                        <div class="p-4">

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
                                    <div class="px-4 mt-auto">
                                        <hr class="border-t border-gray-200">
                                    </div>

                                    <!-- PRECIO + BOTON -->
                                    <div class="flex items-center justify-between p-4 pb-4">
                                        <div>
                                            <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none">desde</span>
                                            <span class="text-2xl sm:text-3xl font-bold text-orange-custom"><?= $t['price'] ?></span>
                                        </div>

                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>"
                                        class="inline-flex items-center px-5 sm:px-6 py-2 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-lg transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                                            <?= $t['reservar'] ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        </div>
    </section>
     <!-- ******************** 
        nuestros destinos
    *********************** -->
    <section id="destinos" class="container-custom mx-auto px-5 sm:px-8 md:px-20 py-12 sm:py-16 md:py-20">

        <!-- Titulo (mismo estilo que "Nosotros") -->
        <div class="text-left mb-6 sm:mb-8 reveal">
            <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                Explora Perú
            </p>

            <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton leading-tight">
                <span class="text-gray-900"><?= $destinos_text['title_primary'] ?? 'Nuestros' ?></span>
                <span class="text-orange-custom"><?= $destinos_text['title_secondary'] ?? 'Destinos' ?></span>
            </h2>
        </div>

        <!-- FILA SUPERIOR: Cusco (grande) + Lima / Puno (apiladas) -->
        <div class="grid grid-cols-1 md:grid-cols-3 md:grid-rows-2 gap-3 sm:gap-4 mb-3 sm:mb-4 md:h-[450px]">

            <!-- CUSCO - grande, ocupa 2 columnas y 2 filas -->
            <div class="relative md:col-span-2 md:row-span-2 rounded-xl overflow-hidden group h-64 sm:h-80 md:h-full reveal-zoom">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=cusco&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['cusco']['img'] ?>"
                        alt="<?= $destinos['cusco']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <!-- OVERLAY HOVER: VER TOURS -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                        <span class="inline-flex items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-white text-white text-xs sm:text-sm md:text-base font-bold font-poppins uppercase tracking-wide rounded-full">
                            Ver Tours
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-white">
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold font-poppins"><?= $destinos['cusco']['nombre'] ?></h3>
                        <p class="text-white/80 text-xs sm:text-sm font-poppins font-light"><?= $destinos['cusco']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

            <!-- LIMA -->
            <div class="relative rounded-xl overflow-hidden group h-48 sm:h-56 md:h-full reveal reveal-delay-1">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=lima&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['lima']['img'] ?>"
                        alt="<?= $destinos['lima']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <!-- OVERLAY HOVER: VER TOURS -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                        <span class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 border-2 border-white text-white text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide rounded-full">
                            Ver Tours
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </div>

                    <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 text-white">
                        <h3 class="text-lg sm:text-xl font-bold font-poppins"><?= $destinos['lima']['nombre'] ?></h3>
                        <p class="text-white/80 text-xs font-poppins font-light"><?= $destinos['lima']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

            <!-- PUNO -->
            <div class="relative rounded-xl overflow-hidden group h-48 sm:h-56 md:h-full reveal reveal-delay-1">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=puno&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['puno']['img'] ?>"
                        alt="<?= $destinos['puno']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <!-- OVERLAY HOVER: VER TOURS -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                        <span class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 border-2 border-white text-white text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide rounded-full">
                            Ver Tours
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </div>

                    <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 text-white">
                        <h3 class="text-lg sm:text-xl font-bold font-poppins"><?= $destinos['puno']['nombre'] ?></h3>
                        <p class="text-white/80 text-xs font-poppins font-light"><?= $destinos['puno']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

        </div>

        <!-- FILA INFERIOR: Manu / Arequipa / Huaraz -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">

            <?php
            $bottom = ['manu', 'arequipa', 'huaraz'];
            foreach ($bottom as $idx => $key): ?>
                <div class="relative rounded-xl overflow-hidden group h-48 sm:h-56 reveal reveal-delay-<?= $idx + 1 ?>">
                    <a href="<?= $base_url ?>/destino/template-destino.php?destino=<?= $key ?>&lang=<?= $idioma ?>">
                        <img src="<?= $base_url . $destinos[$key]['img'] ?>"
                            alt="<?= $destinos[$key]['nombre'] ?>"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                        <!-- OVERLAY HOVER: VER TOURS -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                            <span class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 border-2 border-white text-white text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide rounded-full">
                                Ver Tours
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </span>
                        </div>

                        <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 text-white">
                            <h3 class="text-lg sm:text-xl font-bold font-poppins"><?= $destinos[$key]['nombre'] ?></h3>
                            <p class="text-white/80 text-xs font-poppins font-light"><?= $destinos[$key]['descripcion'] ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>

    </section>
<!-- ******************** 
     glaciares
    *********************** -->
    <section id="glaciares" class="relative w-full py-12 sm:py-16 md:py-16 px-5 sm:px-8 md:px-20 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $glaciares['background_img'] ?>"
            alt="<?= $glaciares['title_primary'] . ' ' . $glaciares['title_secondary'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>
        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-0 sm:px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center">

                <!-- COLUMNA IZQUIERDA: TEXTO -->
                <div class="reveal-left">

                    <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2 sm:mb-3">
                        <?= $glaciares['kicker'] ?>
                    </p>

                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-anton leading-tight mb-3 sm:mb-4">
                        <span class="text-white"><?= $glaciares['title_primary'] ?></span><br>
                        <span class="text-orange-custom"><?= $glaciares['title_secondary'] ?></span>
                    </h2>

                    <p class="text-white/80 font-poppins font-light text-sm sm:text-base md:text-lg mb-6 sm:mb-8 max-w-md">
                        <?= $glaciares['description'] ?>
                    </p>

                    <!-- ESTADISTICAS -->
                    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8 max-w-md">
                        <?php foreach ($glaciares['stats'] as $stat): ?>
                            <div class="text-left">
                                <p class="text-orange-custom text-xl sm:text-2xl md:text-3xl font-anton leading-none mb-1">
                                    <?= $stat['numero'] ?>
                                </p>
                                <p class="text-white/70 text-[0.6rem] sm:text-[0.65rem] md:text-xs font-poppins uppercase tracking-wide">
                                    <?= $stat['titulo'] ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- BOTONES -->
                    <div class="flex flex-wrap items-center gap-4">

                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=glaciares&lang=<?= $idioma ?>" 
                        class="hover:scale-105 inline-flex items-center px-6 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            <?= $glaciares['boton_primario'] ?>
                        </a>

                       
                    </div>

                </div>

                <!-- COLUMNA DERECHA: CARDS -->

                <!-- MOBILE: CARRUSEL (solo visible en mobile) -->
                <div class="md:hidden reveal-right">
                    <div class="swiper-outer">
                        <div class="auto-swiper relative" data-desktop="1" data-tablet="1" data-mobile="1" data-gap="16">
                            <div class="swiper-wrapper">

                                <?php foreach ($glaciares['cards'] as $card): ?>
                                    <div class="swiper-slide h-auto">
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $card['url'] ?>&lang=<?= $idioma ?>"
                                        class="block rounded-xl overflow-hidden shadow-lg group h-full">

                                            <!-- IMAGEN -->
                                            <div class="relative h-48 sm:h-56 overflow-hidden">
                                                <img src="<?= $base_url . $card['img'] ?>"
                                                    alt="<?= $card['nombre'] ?>"
                                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>

                                            <!-- CONTENIDO -->
                                            <div class="bg-[#2a2a2a] p-4">
                                                <h3 class="text-white text-base sm:text-lg font-bold font-poppins mb-1">
                                                    <?= $card['nombre'] ?>
                                                </h3>
                                                <p class="text-white/70 text-xs sm:text-sm font-poppins font-light mb-2">
                                                    <?= $card['descripcion'] ?>
                                                </p>
                                                <span class="text-orange-custom text-xs sm:text-sm font-bold font-poppins">
                                                    <?= $card['link_text'] ?> →
                                                </span>
                                            </div>

                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLET/DESKTOP: APILADAS (oculto en mobile) -->
                <div class="hidden md:flex flex-col gap-5 reveal-right">

                    <?php foreach ($glaciares['cards'] as $card): ?>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $card['url'] ?>&lang=<?= $idioma ?>"
                        class="block rounded-xl overflow-hidden shadow-lg group">

                            <!-- IMAGEN -->
                            <div class="relative h-60 overflow-hidden">
                                <img src="<?= $base_url . $card['img'] ?>"
                                    alt="<?= $card['nombre'] ?>"
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>

                            <!-- CONTENIDO -->
                            <div class="bg-[#2a2a2a] p-4">
                                <h3 class="text-white text-lg font-bold font-poppins mb-1">
                                    <?= $card['nombre'] ?>
                                </h3>
                                <p class="text-white/70 text-sm font-poppins font-light mb-2">
                                    <?= $card['descripcion'] ?>
                                </p>
                                <span class="text-orange-custom text-sm font-bold font-poppins">
                                    <?= $card['link_text'] ?> →
                                </span>
                            </div>

                        </a>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>

    </section>
        <!-- ******************** 
     Titulo Paquetes mas populares
     *********************** -->

    <section id="paquetes-populares" class="py-6 sm:py-8 bg-white">
        <div class="container-custom mx-auto px-5 sm:px-8 md:px-20">

            <!-- TITULO + VER TODOS -->
            <div class="flex flex-wrap items-end justify-between gap-3 sm:gap-4 mb-6 sm:mb-8 reveal">
                <div>
                    <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $popular_text['kicker'] ?>
                    </p>

                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton leading-tight">
                        <span class="text-gray-900"><?= $popular_text['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $popular_text['title_secondary'] ?></span>
                    </h2>
                </div>

                <a href="<?= $base_url ?>/destino/template-destino.php?destino=paquete-peru&lang=<?= $idioma ?>" 
                class="inline-flex items-center gap-2 text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
                    <?= $popular_text['ver_todos'] ?>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </section>
        <!-- ************************ 
        carrusel paquetes mas populares
    *********************** -->
    <?php
    $promo_packages = array_filter($cards, function ($p) {
        return isset($p['promo']['active']) && $p['promo']['active'] === true;
    });
    ?>

    <div class="mx-auto px-5 sm:px-8 md:px-20 pb-6 sm:pb-10 md:pb-16 reveal">
        <div class="swiper-outer">
            <div class="auto-swiper relative" data-desktop="3" data-tablet="2" data-mobile="1" data-gap="24">
                <div class="swiper-wrapper">

                    <?php foreach ($promo_packages as $p) : ?>
                        <div class="swiper-slide h-auto">

                            <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $p['url'] ?>&lang=<?= $idioma ?>"
                            class="block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full">

                                <!-- IMAGEN -->
                                <?php
                                $imagenes = [];
                                if (isset($p['image'])) {
                                    $imagenes = is_array($p['image']) ? $p['image'] : [$p['image']];
                                }
                                ?>
                                <div class="relative h-56 sm:h-64 md:h-80 w-full overflow-hidden px-1 pt-1">

                                    <?php if (count($imagenes) > 1): ?>
                                        <div class="card-slider relative w-full h-full">
                                            <?php foreach ($imagenes as $i => $img): ?>
                                                <img src="<?= $base_url ?>/images/<?= $img ?>"
                                                    class="absolute rounded-lg inset-0 w-full h-full object-cover transition-opacity duration-1000 <?= $i === 0 ? 'opacity-100' : 'opacity-0' ?>">
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <img src="<?= $base_url ?>/images/<?= $imagenes[0] ?>"
                                            class="relative inset-0 w-full rounded-lg h-full object-cover">
                                    <?php endif; ?>

                                    
                                </div>

                                <!-- CONTENIDO -->
                                <div class="px-4 pt-4">

                                    <!-- TITULO -->
                                    <h3 class="text-sm sm:text-base font-bold font-poppins text-gray-900 leading-snug mb-1">
                                        <?= $p['title'] ?>
                                    </h3>

                                    <!-- UBICACION -->
                                    <p class="text-gray-500 text-xs sm:text-sm font-poppins mb-3">
                                        <?= $p['ubicacion'] ?? '' ?>
                                    </p>

                                    <!-- DURACION + MAX PERSONAS -->
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-600 font-poppins mb-3">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-orange-custom"></i>
                                            <?= $p['subtitle'] ?>
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-people-group text-orange-custom"></i>
                                            Max <?= $p['max_personas'] ?? '12' ?> personas
                                        </span>
                                    </div>

                                    <!-- TAGS / CATEGORIAS -->
                                    <?php if (!empty($p['categorias'])): ?>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <?php foreach ($p['categorias'] as $i => $cat): ?>
                                                <span class="text-[0.6rem] sm:text-[0.65rem] font-bold font-poppins uppercase px-2.5 sm:px-3 py-1 rounded-full border
                                                    <?= $i === 0 ? 'border-orange-custom text-orange-custom' : 'border-orange-200 bg-orange-50 text-orange-400' ?>">
                                                    <?= $cat ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="border-t border-gray-200 mx-4"></div>

                                <!-- PRECIO + BOTON -->
                                <div class="flex items-center justify-between px-4 py-3 sm:py-4 gap-2">
                                    <div>
                                        <span class="block text-[0.65rem] sm:text-xs text-gray-400 font-poppins leading-none mb-1">desde</span>

                                        <?php if (isset($p['promo']['active']) && $p['promo']['active'] && isset($p['promo']['old_price'])): ?>
                                            <span class="text-xl sm:text-2xl md:text-3xl line-through text-gray-300 mr-1"><?= $p['promo']['old_price'] ?></span>
                                        <?php endif; ?>

                                        <span class="text-xl sm:text-2xl md:text-3xl font-bold text-orange-custom">
                                            $<?= $p['price'] ?> <span class="text-xs sm:text-sm text-gray-700 font-semibold"><?= $p['moneda'] ?? 'USD' ?></span>
                                        </span>
                                    </div>
                                    <span class="font-poppins bg-orange-custom hover:bg-[#c2660a] text-white text-xs sm:text-sm font-bold px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg transition uppercase whitespace-nowrap">
                                        <?= $p['reservar'] ?>
                                    </span>
                                </div>

                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
    <!-- ******************** 
        experiencias unicas
    *********************** -->
    <section id="experiencias" class="bg-white py-14">
        <div class="container-custom mx-auto px-5 sm:px-8 md:px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center">

                <!-- COLUMNA IZQUIERDA: TEXTO -->
                <div class="reveal-left">

                    <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-3">
                        <?= $experiencias_text['kicker'] ?>
                    </p>

                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-anton leading-tight mb-4">
                        <span class="text-gray-900"><?= $experiencias_text['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $experiencias_text['title_secondary'] ?></span>
                    </h2>

                    <p class="text-gray-600 font-poppins font-light text-sm sm:text-base md:text-lg mb-6 sm:mb-8 max-w-md">
                        <?= $experiencias_text['description'] ?? '' ?>
                    </p>

                    <!-- ESTADISTICAS -->
                    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8 max-w-md">
                        <?php foreach ($experiencias_text['stats'] as $stat): ?>
                            <div class="text-left">
                                <p class="text-orange-custom text-xl sm:text-2xl md:text-3xl font-anton leading-none mb-1">
                                    <?= $stat['numero'] ?>
                                </p>
                                <p class="text-gray-500 text-[0.6rem] sm:text-[0.65rem] md:text-xs font-poppins uppercase tracking-wide">
                                    <?= $stat['titulo'] ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- BOTON -->
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="<?= $base_url ?>/destino/template-destino.php?destino=experiencias-unicas&lang=<?= $idioma ?>"
                        class="hover:scale-105 inline-flex items-center px-6 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            <?= $experiencias_text['ver_todos'] ?>
                            <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
                        </a>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: CARD DESTACADA + CARRUSEL -->
                <div class="reveal-right">

                    <?php
                    $destacada = null;
                    $secundarias = [];
                    foreach ($experiencias as $e) {
                        if (!empty($e['destacado']) && $destacada === null) {
                            $destacada = $e;
                        } else {
                            $secundarias[] = $e;
                        }
                    }
                    ?>


                    <!-- CARRUSEL DE LAS DEMAS EXPERIENCIAS -->
                    <div class="swiper-outer">
                        <div class="auto-swiper relative" data-desktop="1" data-tablet="1" data-mobile="1" data-gap="20">
                            <div class="swiper-wrapper">

                                <?php foreach ($secundarias as $e): ?>
                                    <div class="swiper-slide h-auto">
                                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $e['url'] ?>&lang=<?= $idioma ?>"
                                        class="tour-card block bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300 h-full">

                                            <!-- IMAGEN -->
                                            <div class="relative h-44 sm:h-52 md:h-60 w-full overflow-hidden">
                                                <img src="<?= $base_url . $e['img'] ?>"
                                                    alt="<?= $e['titulo'] ?>"
                                                    class="w-full h-full object-cover">
                                            </div>

                                            <!-- CONTENIDO -->
                                            <div class="p-4">
                                                <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                                    <?= $e['duracion'] ?>
                                                </p>
                                                <h3 class="text-base md:text-lg font-bold font-poppins text-gray-900 leading-snug">
                                                    <?= $e['titulo'] ?>
                                                </h3>
                                                <p class="text-gray-500 text-xs md:text-sm font-poppins font-light mt-1 line-clamp-2">
                                                    <?= $e['descripcion'] ?>
                                                </p>
                                            </div>

                                            <!-- linea divisoria -->
                                            <div class="px-4">
                                                <hr class="border-t border-gray-200">
                                            </div>

                                            <!-- PRECIO + BOTON -->
                                            <div class="flex items-center justify-between p-4">
                                                <div>
                                                    <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none">desde</span>
                                                    <span class="text-xl sm:text-2xl font-bold text-orange-custom"><?= $e['precio'] ?></span>
                                                </div>
                                                <span class="inline-flex items-center px-5 py-2 text-sm bg-orange-custom text-white font-bold font-poppins rounded-lg transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                                                    <?= $e['reservar'] ?>
                                                </span>
                                            </div>

                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>


    <!-- ******************** 
        cta - aventura en los andes
    *********************** -->
    <section id="cta-aventura" class="relative w-full py-16 sm:py-24 md:py-32 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $cta['background_img'] ?>"
            alt="<?= $cta['title_primary'] ?> <?= $cta['title_highlight'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-black/55"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-5 sm:px-8">
            <div class="max-w-3xl mx-auto text-center reveal-zoom">

                <p class="text-orange-custom text-xs sm:text-sm md:text-base font-bold font-poppins mb-3">
                    <?= $cta['kicker'] ?>
                </p>

                <h2 class="text-2xl sm:text-4xl md:text-5xl font-anton leading-tight mb-4 sm:mb-6">
                    <span class="text-white"><?= $cta['title_primary'] ?></span><br>
                    <span class="text-white"><?= $cta['title_secondary'] ?></span>
                    <span class="text-orange-custom"><?= $cta['title_highlight'] ?></span>
                </h2>

                <p class="text-white/85 font-poppins font-light text-sm sm:text-base md:text-lg mb-8 sm:mb-10 max-w-2xl mx-auto">
                    <?= $cta['description'] ?>
                </p>

                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">

                    <!-- BOTON WHATSAPP -->
                    <a href="https://wa.me/<?= $cta['boton_whatsapp']['numero'] ?>"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base bg-[#25D366] text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#1ebe5a] shadow-md">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <?= $cta['boton_whatsapp']['texto'] ?>
                    </a>

                    <!-- BOTON CONTACTO -->
                    <a href="<?= $base_url ?>/contacto.php?lang=<?= $idioma ?>"
                    class="inline-flex items-center px-5 sm:px-7 py-3 sm:py-3.5 text-sm md:text-base border-2 border-white/70 text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-white hover:text-black">
                        <?= $cta['boton_contacto']['texto'] ?>
                    </a>

                </div>

            </div>
        </div>

    </section>

    <!-- ******************** 
        trip-advisor
    *********************** -->
    <section id="trip-advisor" class="bg-white py-10 sm:py-14">
        <div class="container-custom mx-auto px-5 sm:px-8 md:px-20">

            <!-- TITULO + VER TODOS -->
            <div class="flex flex-wrap items-end justify-between gap-3 sm:gap-4 mb-8 sm:mb-10 reveal">
                <div>
                    <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $trip_text['kicker'] ?>
                    </p>

                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton leading-tight">
                        <span class="text-gray-900"><?= $trip_text['title_primary'] ?></span><br>
                        <span class="text-gray-900"><?= explode(' ', $trip_text['title_secondary'])[0] ?></span>
                        <span class="text-orange-custom"><?= explode(' ', $trip_text['title_secondary'], 2)[1] ?? '' ?></span>
                    </h2>
                </div>

                <a href="https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html"
                target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
                    Ver todas las reseñas
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-center">

                <!-- LADO IZQUIERDO: LOGOS -->
                <div class="md:col-span-3 flex flex-row sm:flex-col items-center sm:items-start justify-between sm:justify-start gap-4 reveal-left">

                    <div class="flex items-center gap-2 sm:gap-3">
                        <img src="<?= $base_url ?>/images/tripadvisor/trofy-1.png" alt="Travelers Choice 2024" class="h-14 sm:h-20">
                        <img src="<?= $base_url ?>/images/tripadvisor/trofy-2.png" alt="Travelers Choice 2025" class="h-14 sm:h-20">
                        <img src="<?= $base_url ?>/images/tripadvisor/trofy-3.png" alt="Travelers Choice 2026" class="h-14 sm:h-20">
                    </div>

                    <a href="https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html"
                    target="_blank" rel="noopener"
                    class="flex items-center gap-2 group">
                        <img src="<?= $base_url ?>/images/tripadvisor/tripadvisor-logo.png" alt="Tripadvisor" class="h-7 w-7 sm:h-9 sm:w-9">
                        <span class="text-lg sm:text-2xl font-bold text-gray-900 group-hover:text-[#00AF87] transition-colors">Tripadvisor</span>
                    </a>

                </div>

                <!-- LADO DERECHO: CARRUSEL DE TESTIMONIOS -->
                <div class="md:col-span-9 reveal-right">
                    <div class="swiper mySwiper relative">
                        <div class="swiper-wrapper">

                            <?php foreach ($trip_text['slides'] as $slide): ?>
                                <div class="swiper-slide h-auto">
                                    <a href="<?= $slide['review_url'] ?? 'https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html' ?>"
                                    target="_blank" rel="noopener"
                                    class="group block bg-white border border-gray-200 hover:border-[#00AF87] rounded-2xl shadow-sm hover:shadow-md p-5 sm:p-6 h-full flex flex-col transition-all duration-300">

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
        </div>
    </section>
    <!-- ******************** 
        MODAL DE VIDEO
    *********************** -->
    <div id="video-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 px-4">
        <div class="relative w-full max-w-3xl">
            <button type="button" id="video-modal-close"
                    class="absolute -top-10 right-0 text-white text-2xl hover:text-orange-custom transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="aspect-video w-full rounded-xl overflow-hidden bg-black">
                <iframe id="video-modal-iframe"
                        class="w-full h-full"
                        src=""
                        title="Video testimonial"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- ******************** 
        blog de viajeros
    *********************** -->
    <section id="blog" class="bg-white py-10 sm:py-14">
        <div class="container-custom mx-auto px-5 sm:px-8 md:px-20">

            <!-- TITULO + VER TODOS -->
            <div class="flex flex-wrap items-end justify-between gap-3 sm:gap-4 mb-6 sm:mb-8 reveal">
                <div>
                    <p class="text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $blog_text['kicker'] ?>
                    </p>

                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-anton leading-tight mb-2">
                        <span class="text-gray-900"><?= $blog_text['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $blog_text['title_secondary'] ?></span>
                    </h2>

                    <p class="text-gray-500 font-poppins font-light text-sm sm:text-base">
                        <?= $blog_text['description'] ?>
                    </p>
                </div>

                <a href="<?= $base_url ?>/blog/template-blog.php?lang=<?= $idioma ?>"
                class="inline-flex items-center gap-2 text-orange-custom text-xs sm:text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
                    <?= $blog_text['ver_todos'] ?>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- CARRUSEL DE POSTS -->
            <div class="swiper-outer reveal">
                <div class="auto-swiper relative" data-desktop="3" data-tablet="2" data-mobile="1" data-gap="24">
                    <div class="swiper-wrapper">

                        <?php foreach ($blog_posts as $post): ?>
                            <div class="swiper-slide h-auto">
                                <a href="<?= $base_url ?>/blog/template-articulo.php?articulo=<?= $post['url'] ?>&lang=<?= $idioma ?>"
                                class="block bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full">

                                    <!-- IMAGEN -->
                                    <div class="h-52 sm:h-64 md:h-80 w-full overflow-hidden">
                                        <img src="<?= $base_url . $post['img'] ?>"
                                            alt="<?= $post['titulo'] ?>"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <!-- CONTENIDO -->
                                    <div class="p-4">

                                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                                            <?= $post['categoria'] ?>
                                        </p>

                                        <h3 class="text-base sm:text-lg font-bold font-poppins text-gray-900 leading-snug mb-2">
                                            <?= $post['titulo'] ?>
                                        </h3>

                                        <p class="text-gray-500 text-xs sm:text-sm font-poppins font-light leading-snug mb-3">
                                            <?= $post['descripcion'] ?>
                                        </p>

                                        <span class="inline-flex items-center gap-1.5 text-orange-custom text-xs sm:text-sm font-bold font-poppins">
                                            <?= $post['link_text'] ?>
                                            <i class="fa-solid fa-arrow-right text-xs"></i>
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
    <!-- ******************** 
        reconocimientos y licencias
    *********************** -->
    <section id="reconocimientos" class="relative w-full py-16 md:py-20 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $reconocimientos['background_img'] ?>"
            alt="<?= $reconocimientos['title_primary'] ?> <?= $reconocimientos['title_secondary'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->c
        <div class="absolute inset-0 bg-black/45"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4">

            <!-- TITULO CENTRADO -->
            <div class="text-center mb-10 reveal">
                <p class="text-orange-custom text-sm md:text-base font-bold font-poppins mb-2">
                    <?= $reconocimientos['kicker'] ?>
                </p>

                <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                    <span class="text-white"><?= $reconocimientos['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $reconocimientos['title_secondary'] ?></span>
                </h2>
            </div>

            <!-- CERTIFICADOS -->
            <div class="flex flex-wrap justify-center gap-6 md:gap-8 mb-12">

                <?php foreach ($reconocimientos['certificados'] as $cert): ?>
                    <div class="flex flex-col items-center w-32 sm:w-36 md:w-40 reveal reveal-delay-<?= ($i % 5) + 1 ?>">
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full aspect-[3/4]">
                            <img src="<?= $base_url . $cert['img'] ?>"
                                alt="<?= $cert['label'] ?>"
                                class="w-full h-full object-cover">
                        </div>
                        <p class="text-orange-custom text-sm md:text-base font-bold font-poppins mt-3 text-center">
                            <?= $cert['label'] ?>
                        </p>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- PAGOS SEGUROS -->
            <div class="flex flex-wrap items-center justify-center gap-4">
                <span class="text-white/70 text-sm font-poppins uppercase tracking-wide">
                    <?= $reconocimientos['pagos']['texto'] ?>
                </span>

                <div class="flex items-center gap-3">
                    <?php foreach ($reconocimientos['pagos']['metodos'] as $metodo): ?>
                        <img src="<?= $base_url . $metodo['img'] ?>"
                            alt="<?= $metodo['nombre'] ?>"
                            class="h-8 md:h-9 rounded shadow-sm">
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </section>


</main>