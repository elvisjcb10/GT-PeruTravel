<!-- home -->
<main>
    <!-- ******************** 
          Hero
     *********************** -->
    <section id="video" class="relative w-full h-[82vh] min-h-[650px] bg-black overflow-hidden">
        <!--- mantener para futuras referncias-->
        <!-- VIDEO PC 
        <video autoplay muted loop playsinline
            class="hidden md:block absolute top-0 left-0 w-full h-full object-cover">
             <source src="<?= $base_url ?>/video/slider-pc.webm" type="video/webm"> 
            <source src="<?= $base_url ?>/video/slider-machupicchu-web-pc-mobil.mp4" type="video/mp4">
        </video>

        VIDEO MOBILE (más liviano) 
        <video autoplay muted loop playsinline
            class="block md:hidden absolute top-0 left-0 w-full h-full object-cover">
             <source src="<?= $base_url ?>/video/slider-mobile.webm" type="video/webm"> 
            <source src="<?= $base_url ?>/video/slider-machupicchu-web-pc-mobil.mp4" type="video/mp4">
        </video> -->

        <!-- imagen de fondo -->
        <img class="absolute top-0 left-0 w-full h-full object-cover"
             src="<?= $base_url ?>/images/inicio/hero.webp"
             alt="Machu Picchu - GT Peru Travel">

        <!-- overlays para legibilidad del texto -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

        <!-- contenido principal -->
        <div class="relative z-10  h-full flex items-center justify-center">
            <div class="container-custom  px-20    w-full">
                <div class="max-w-2xl">

                    <h1 class="text-white text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.05] drop-shadow-lg">
                        <?= html_entity_decode($hero_text['titulo']) ?>
                    </h1>

                    <p class="mt-6 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                        <?= html_entity_decode($hero_text['subtitulo']) ?>
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">

                        <a href="paquete/template-paquete.php?paquete=peru-mistico&lang=<?= htmlspecialchars($idioma) ?>"
                            class="inline-flex items-center px-7 py-3.5 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            <?= html_entity_decode($hero_text['boton1']) ?>
                        </a>

                        <a href="#experiencias"
                            class="inline-flex items-center px-7 py-3.5 text-sm md:text-base border-2 border-white/70 text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-white hover:text-black">
                            <?= html_entity_decode($hero_text['boton2']) ?>
                        </a>

                    </div>

                </div>
            </div>
        </div>

        <!-- logo tripadvisor -->
        <div class="absolute z-10 bottom-24 md:bottom-28 right-4 md:right-10 flex justify-end">
            <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
            <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
            <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
            <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor Travelers' Choice" class="h-20 md:h-28">
        </div>

        <!-- barra de estadísticas -->
        <div class="absolute bottom-0 left-0 w-full z-10 bg-black/20 backdrop-blur-sm ">
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
         nosotros - empresa
     *********************** -->
    
    <section class="container-custom mx-auto px-20 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">

            <!-- IMAGEN + BADGE AÑOS -->
            <div class="relative">
                <img src="<?= $base_url . $about_text['img'] ?>"
                    alt="<?= $about_text['title_primary'] . ' ' . $about_text['title_secondary'] ?>"
                    class="w-full h-[420px] md:h-[480px] object-cover rounded-2xl shadow-lg">

                <div class="absolute -bottom-6 right-6 md:right-10 w-28 h-28 md:w-32 md:h-32 bg-orange-custom rounded-full flex flex-col items-center justify-center text-white text-center shadow-lg ">
                    <span class="text-3xl md:text-4xl font-anton leading-none"><?= $about_text['años']['numero'] ?>+</span>
                    <span class="text-[0.6rem] md:text-xs font-poppins uppercase tracking-wide leading-tight px-2">
                        <?= $about_text['años']['titulo'] ?>
                    </span>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div>
                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $about_text['subtitle'] ?>
                </p>

                <h2 class="text-3xl md:text-5xl font-anton mb-4 leading-tight">
                    <span class="text-gray-900"><?= $about_text['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $about_text['title_secondary'] ?></span>
                </h2>

                <p class="text-gray-600 font-poppins font-light text-base md:text-lg mb-8">
                    <?= $about_text['description'] ?>
                </p>

                <!-- FEATURES 2x2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <?php
                    $icons = [
                        'f1' => 'fa-person-hiking',
                        'f2' => 'fa-user-shield',
                        'f3' => 'fa-people-group',
                        'f4' => 'fa-mountain',
                    ];
                    foreach ($about_text['features'] as $key => $feature): ?>
                        <div class="flex items-start gap-3">
                            <i class="fa-solid <?= $icons[$key] ?? 'fa-check' ?> text-black text-xl mt-1"></i>
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

                <a href="#experiencias"
                class="inline-flex items-center px-7 py-3 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                    <?= $about_text['boton'] ?>
                </a>
            </div>

        </div>
    </section>
   <!-- ************************ 
        mejores TOURS 
     *********************** -->

    <section id="tours" class="py-12 bg-white">

        <div class="container-custom mx-auto px-20 space-y-8">

            <!-- Titulo -->
            <div class="container-custom mx-auto px-4 ">

                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    Mejores tours
                </p>

                <h2 class="text-3xl md:text-5xl font-anton mb-4 leading-tight">
                    <span class="text-gray-900"><?= $tours_text['tours'] ?></span>
                    <span class="text-orange-custom"><?= $tours_text['mas_solicitados'] ?></span>
                </h2>

                <p class="text-gray-600 font-poppins font-light text-base md:text-sm">
                    <?= $tours_text['descripcion'] ?>
                </p>
                
            </div>

            <!-- ************************ 
                GRID DE TOURS (sin carrusel)
            *********************** -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php foreach ($tours as $t) : ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">

                        <!-- Link envolvente -->
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>" class="block">

                            <!-- IMAGEN -->
                            <div class="relative h-72 md:h-80 w-full overflow-hidden px-1 pt-1"> 
                                <img src="<?= $base_url ?>/images/<?= $t['image'] ?>"
                                    alt="<?= $t['title'] ?>"
                                    class="w-full h-full object-cover rounded-lg shadow-md">

                                <!-- Badge Promo (si existe) -->
                                <!-- <?php if (isset($t['promo']['active']) && $t['promo']['active']) : ?>
                                    <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg font-poppins">
                                        <?= $t['promo']['label'] ?>
                                    </div>
                                <?php endif; ?> -->
                            </div>

                            <!-- CONTENIDO -->
                            <div class="p-4">

                                <!-- DURACION -->
                                <!-- <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                    <?= $t['duracion'] ?>
                                </p> -->

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
                                <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none">desde</span>

                                <!-- <?php if (isset($t['promo']['active']) && $t['promo']['active']) : ?>
                                    <span class="text-xs line-through text-gray-300 mr-1"><?= $t['promo']['old_price'] ?></span>
                                <?php endif; ?> -->

                                <span class="text-3xl font-bold text-orange-custom"><?= $t['price'] ?></span>
                            </div>

                            <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>"
                            class="inline-flex items-center px-7 py-3 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-lg transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                                <?= $t['reservar'] ?>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>
     <!-- ******************** 
        nuestros destinos
    *********************** -->
    <section id="destinos" class="container-custom mx-auto px-20 py-14">

        <!-- Titulo (mismo estilo que "Nosotros") -->
        <div class="text-left mb-8">
            <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                Explora Perú
            </p>

            <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                <span class="text-gray-900"><?= $destinos_text['title_primary'] ?? 'Nuestros' ?></span>
                <span class="text-orange-custom"><?= $destinos_text['title_secondary'] ?? 'Destinos' ?></span>
            </h2>
        </div>

        <!-- FILA SUPERIOR: Cusco (grande) + Lima / Puno (apiladas) -->
        <div class="grid grid-cols-1 md:grid-cols-3 md:grid-rows-2 gap-4 mb-4 md:h-[450px]">

            <!-- CUSCO - grande, ocupa 2 columnas y 2 filas -->
            <div class="relative md:col-span-2 md:row-span-2 rounded-xl overflow-hidden group h-72 md:h-full">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=cusco&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['cusco']['img'] ?>"
                        alt="<?= $destinos['cusco']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 text-white">
                        <h3 class="text-2xl md:text-3xl font-bold font-poppins"><?= $destinos['cusco']['nombre'] ?></h3>
                        <p class="text-white/80 text-sm font-poppins font-light"><?= $destinos['cusco']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

            <!-- LIMA -->
            <div class="relative rounded-xl overflow-hidden group h-56 md:h-full">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=lima&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['lima']['img'] ?>"
                        alt="<?= $destinos['lima']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold font-poppins"><?= $destinos['lima']['nombre'] ?></h3>
                        <p class="text-white/80 text-xs font-poppins font-light"><?= $destinos['lima']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

            <!-- PUNO -->
            <div class="relative rounded-xl overflow-hidden group h-56 md:h-full">
                <a href="<?= $base_url ?>/destino/template-destino.php?destino=puno&lang=<?= $idioma ?>">
                    <img src="<?= $base_url . $destinos['puno']['img'] ?>"
                        alt="<?= $destinos['puno']['nombre'] ?>"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold font-poppins"><?= $destinos['puno']['nombre'] ?></h3>
                        <p class="text-white/80 text-xs font-poppins font-light"><?= $destinos['puno']['descripcion'] ?></p>
                    </div>
                </a>
            </div>

        </div>

        <!-- FILA INFERIOR: Manu / Arequipa / Huaraz -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <?php
            $bottom = ['manu', 'arequipa', 'huaraz'];
            foreach ($bottom as $key): ?>
                <div class="relative rounded-xl overflow-hidden group h-56">
                    <a href="<?= $base_url ?>/destino/template-destino.php?destino=<?= $key ?>&lang=<?= $idioma ?>">
                        <img src="<?= $base_url . $destinos[$key]['img'] ?>"
                            alt="<?= $destinos[$key]['nombre'] ?>"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold font-poppins"><?= $destinos[$key]['nombre'] ?></h3>
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
    <section id="glaciares" class="relative w-full py-16 px-20 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $glaciares['background_img'] ?>"
            alt="<?= $glaciares['title_primary'] . ' ' . $glaciares['title_secondary'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>
        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <!-- COLUMNA IZQUIERDA: TEXTO -->
                <div>

                    <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-3">
                        <?= $glaciares['kicker'] ?>
                    </p>

                    <h2 class="text-4xl md:text-5xl font-anton leading-tight mb-4">
                        <span class="text-white"><?= $glaciares['title_primary'] ?></span><br>
                        <span class="text-orange-custom"><?= $glaciares['title_secondary'] ?></span>
                    </h2>

                    <p class="text-white/80 font-poppins font-light text-base md:text-lg mb-8 max-w-md">
                        <?= $glaciares['description'] ?>
                    </p>

                    <!-- ESTADISTICAS -->
                    <div class="grid grid-cols-3 gap-4 mb-8 max-w-md">
                        <?php foreach ($glaciares['stats'] as $stat): ?>
                            <div class="text-left">
                                <p class="text-orange-custom text-2xl md:text-3xl font-anton leading-none mb-1">
                                    <?= $stat['numero'] ?>
                                </p>
                                <p class="text-white/70 text-[0.65rem] md:text-xs font-poppins uppercase tracking-wide">
                                    <?= $stat['titulo'] ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- BOTONES -->
                    <div class="flex flex-wrap items-center gap-4">

                        <a href="#tours-glaciares"
                        class="inline-flex items-center px-7 py-3.5 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            <?= $glaciares['boton_primario'] ?>
                        </a>

                       
                    </div>

                </div>

                <!-- COLUMNA DERECHA: CARDS APILADAS -->
                <div class="flex flex-col gap-5">

                    <?php foreach ($glaciares['cards'] as $card): ?>
                        <a href="<?= $base_url ?>/destino/template-glaciar.php?glaciar=<?= $card['url'] ?>&lang=<?= $idioma ?>"
                        class="block rounded-xl overflow-hidden shadow-lg group">

                            <!-- IMAGEN -->
                            <div class="relative h-40 md:h-48 overflow-hidden">
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
     experiencias unicas
    *********************** -->
    <section id="experiencias" class="container-custom mx-auto px-20 py-14">

        <!-- TITULO + VER TODOS -->
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $experiencias_text['kicker'] ?>
                </p>

                <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                    <span class="text-gray-900"><?= $experiencias_text['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $experiencias_text['title_secondary'] ?></span>
                </h2>
            </div>

            <a href="<?= $base_url ?>/experiencias/template-experiencias.php?lang=<?= $idioma ?>"
            class="inline-flex items-center gap-2 text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
                <?= $experiencias_text['ver_todos'] ?>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- GRID: card grande + 2 cards horizontales -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

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

            <!-- CARD GRANDE (izquierda) -->
            <?php if ($destacada): ?>
                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $destacada['url'] ?>&lang=<?= $idioma ?>"
                class="block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">

                    <!-- IMAGEN -->
                    <div class="h-72 md:h-96 w-full overflow-hidden">
                        <img src="<?= $base_url . $destacada['img'] ?>"
                            alt="<?= $destacada['titulo'] ?>"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- CONTENIDO -->
                    <div class="px-5 pt-4">
                        <p class="text-orange-custom text-sm font-bold font-poppins mb-1">
                            <?= $destacada['duracion'] ?>
                        </p>
                        <h3 class="text-lg font-bold font-poppins text-gray-900 leading-snug mb-1">
                            <?= $destacada['titulo'] ?>
                        </h3>
                        <p class="text-gray-500 text-sm font-poppins font-light leading-snug">
                            <?= $destacada['descripcion'] ?>
                        </p>
                    </div>

                    <div class="mt-4 border-t border-gray-200"></div>

                    <!-- PRECIO + BOTON -->
                    <div class="flex items-center justify-between px-5 py-4">
                        <div>
                            <span class="block text-xs text-gray-400 font-poppins leading-none mb-1">desde</span>
                            <span class="text-2xl font-bold text-orange-custom"><?= $destacada['precio'] ?></span>
                        </div>
                        <span class="bg-orange-custom hover:bg-[#c2660a] text-white text-sm font-bold px-6 py-2.5 rounded-full transition">
                            <?= $destacada['reservar'] ?>
                        </span>
                    </div>

                </a>
            <?php endif; ?>

            <!-- CARDS HORIZONTALES (derecha, apiladas) -->
            <div class="flex flex-col gap-6">

                <?php foreach ($secundarias as $e): ?>
                    <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $e['url'] ?>&lang=<?= $idioma ?>"
                    class="flex bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">

                        <!-- IMAGEN -->
                        <div class="w-2/5 flex-shrink-0">
                            <img src="<?= $base_url . $e['img'] ?>"
                                alt="<?= $e['titulo'] ?>"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- CONTENIDO -->
                        <div class="w-3/5 p-4 flex flex-col justify-between">
                            <div>
                                <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                    <?= $e['duracion'] ?>
                                </p>
                                <h3 class="text-base font-bold font-poppins text-gray-900 leading-snug mb-1">
                                    <?= $e['titulo'] ?>
                                </h3>
                                <p class="text-gray-500 text-xs font-poppins font-light leading-snug">
                                    <?= $e['descripcion'] ?>
                                </p>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-200 flex items-center justify-between">
                                <div>
                                    <span class="block text-[0.65rem] text-gray-400 font-poppins leading-none mb-1">desde</span>
                                    <span class="text-lg font-bold text-orange-custom"><?= $e['precio'] ?></span>
                                </div>
                                <span class="bg-orange-custom hover:bg-[#c2660a] text-white text-xs font-bold px-4 py-2 rounded-full transition">
                                    <?= $e['reservar'] ?>
                                </span>
                            </div>
                        </div>

                    </a>
                <?php endforeach; ?>

            </div>

        </div>

    </section>
   


    <!-- ******************** 
        Titulo Paquetes mas populares
     *********************** -->
    <!-- ******************** 
     Titulo Paquetes mas populares
 *********************** -->
    <section id="paquetes-populares" class="py-8  bg-white">
        <div class="container-custom mx-auto px-20">

            <!-- TITULO + VER TODOS (mismo patrón que las demás secciones) -->
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $popular_text['kicker'] ?>
                    </p>

                    <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                        <span class="text-gray-900"><?= $popular_text['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $popular_text['title_secondary'] ?></span>
                    </h2>
                </div>

                <a href="<?= $base_url ?>/paquetes/template-paquetes.php?lang=<?= $idioma ?>"
                class="inline-flex items-center gap-2 text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
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

    <div class="container-custom mx-auto px-20 pb-8 md:pb-16">
        <div class="swiper mySwiperPopular px-1 relative">
            <div class="swiper-wrapper">

                <?php foreach ($promo_packages as $p) : ?>
                    <div class="swiper-slide h-auto">
                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $p['url'] ?>&lang=<?= $idioma ?>"
                        class="block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full">

                            <!-- IMAGEN -->
                            <?php
                            $imagenes = [];
                            if (isset($p['image'])) {
                                $imagenes = is_array($p['image']) ? $p['image'] : [$p['image']];
                            }
                            ?>
                            <div class="relative h-56 w-full overflow-hidden">

                                <?php if (count($imagenes) > 1): ?>
                                    <div class="card-slider relative w-full h-full">
                                        <?php foreach ($imagenes as $i => $img): ?>
                                            <img src="<?= $base_url ?>/images/<?= $img ?>"
                                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 <?= $i === 0 ? 'opacity-100' : 'opacity-0' ?>">
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <img src="<?= $base_url ?>/images/<?= $imagenes[0] ?>"
                                        class="absolute inset-0 w-full h-full object-cover">
                                <?php endif; ?>

                                <!-- BADGE PROMO -->
                                <?php if (isset($p['promo']['active']) && $p['promo']['active']): ?>
                                    <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg font-poppins">
                                        <?= $p['promo']['label'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- CONTENIDO -->
                            <div class="px-4 pt-4">

                                <!-- TITULO -->
                                <h3 class="text-base font-bold font-poppins text-gray-900 leading-snug mb-1">
                                    <?= $p['title'] ?>
                                </h3>

                                <!-- UBICACION -->
                                <p class="text-gray-500 text-sm font-poppins mb-3">
                                    <?= $p['ubicacion'] ?? '' ?>
                                </p>

                                <!-- DURACION + MAX PERSONAS -->
                                <div class="flex items-center gap-4 text-xs text-gray-600 font-poppins mb-3">
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
                                            <span class="text-[0.65rem] font-bold font-poppins uppercase px-3 py-1 rounded-full border
                                                <?= $i === 0 ? 'border-orange-custom text-orange-custom' : 'border-orange-200 bg-orange-50 text-orange-400' ?>">
                                                <?= $cat ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="border-t border-gray-200 mx-4"></div>

                            <!-- PRECIO + BOTON -->
                            <div class="flex items-center justify-between px-4 py-4">
                                <div>
                                    <span class="block text-xs text-gray-400 font-poppins leading-none mb-1">desde</span>

                                    <?php if (isset($p['promo']['active']) && $p['promo']['active'] && isset($p['promo']['old_price'])): ?>
                                        <span class="text-xs line-through text-gray-300 mr-1"><?= $p['promo']['old_price'] ?></span>
                                    <?php endif; ?>

                                    <span class="text-2xl font-bold text-orange-custom">
                                        $<?= $p['price'] ?> <span class="text-sm text-gray-700 font-semibold"><?= $p['moneda'] ?? 'USD' ?></span>
                                    </span>
                                </div>
                                <span class="bg-orange-custom hover:bg-[#c2660a] text-white text-xs font-bold px-5 py-2.5 rounded-lg transition uppercase">
                                    <?= $p['reservar'] ?>
                                </span>
                            </div>

                        </a>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- BOTON ANTERIOR -->
            <div class="custom-prev-popular w-14 h-14 bg-white/90 hover:bg-white rounded-full flex items-center justify-center absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 cursor-pointer shadow-lg z-50 transition-all duration-300">
                <div class="w-0 h-0 border-t-[8px] border-b-[8px] border-r-[12px] border-t-transparent border-b-transparent border-r-[#ff9300]"></div>
            </div>

            <!-- BOTON SIGUIENTE -->
            <div class="custom-next-popular w-14 h-14 bg-white/90 hover:bg-white rounded-full flex items-center justify-center absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 cursor-pointer shadow-lg z-50 transition-all duration-300">
                <div class="w-0 h-0 border-t-[8px] border-b-[8px] border-l-[12px] border-t-transparent border-b-transparent border-l-[#ff9300]"></div>
            </div>

        </div>
    </div>
    <!-- ******************** 
        cta - aventura en los andes
    *********************** -->
    <section id="cta-aventura" class="relative w-full py-24 md:py-32 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $cta['background_img'] ?>"
            alt="<?= $cta['title_primary'] ?> <?= $cta['title_highlight'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-black/55"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">

                <p class="text-orange-custom text-sm md:text-base font-bold font-poppins mb-3">
                    <?= $cta['kicker'] ?>
                </p>

                <h2 class="text-3xl sm:text-4xl md:text-5xl font-anton leading-tight mb-6">
                    <span class="text-white"><?= $cta['title_primary'] ?></span><br>
                    <span class="text-white"><?= $cta['title_secondary'] ?></span>
                    <span class="text-orange-custom"><?= $cta['title_highlight'] ?></span>
                </h2>

                <p class="text-white/85 font-poppins font-light text-base md:text-lg mb-10 max-w-2xl mx-auto">
                    <?= $cta['description'] ?>
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4">

                    <!-- BOTON WHATSAPP -->
                    <a href="https://wa.me/<?= $cta['boton_whatsapp']['numero'] ?>"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-2 px-7 py-3.5 text-sm md:text-base bg-[#25D366] text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-[#1ebe5a] shadow-md">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <?= $cta['boton_whatsapp']['texto'] ?>
                    </a>

                    <!-- BOTON CONTACTO -->
                    <a href="<?= $cta['boton_contacto']['url'] ?>"
                    class="inline-flex items-center px-7 py-3.5 text-sm md:text-base border-2 border-white/70 text-white font-bold font-poppins rounded-full transition duration-300 ease-in-out hover:bg-white hover:text-black">
                        <?= $cta['boton_contacto']['texto'] ?>
                    </a>

                </div>

            </div>
        </div>

    </section>
    <!-- ******************** 
        trip-advisor
    *********************** -->
    <section id="trip-advisor" class="bg-white py-14">
        <div class="container-custom mx-auto px-20">

            <!-- TITULO (mismo patrón que las demás secciones) -->
            <div class="mb-10">
                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $trip_text['kicker'] ?>
                </p>

                <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                    <span class="text-gray-900"><?= $trip_text['title_primary'] ?></span><br>
                    <span class="text-gray-900"><?= explode(' ', $trip_text['title_secondary'])[0] ?></span>
                    <span class="text-orange-custom"><?= explode(' ', $trip_text['title_secondary'], 2)[1] ?? '' ?></span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">

                <!-- LADO IZQUIERDO: LOGOS -->
                <div class="md:col-span-3 flex flex-col items-start gap-4">

                    <div class="flex items-center gap-3">
                        <img src="<?= $base_url ?>/images/trofy-1.png" alt="Travelers Choice 2020" class="h-20">
                        <img src="<?= $base_url ?>/images/trofy-2.png" alt="Travelers Choice 2019" class="h-20">
                    </div>

                    <a href="https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html"
                    target="_blank" rel="noopener"
                    class="flex items-center gap-2">
                        <img src="<?= $base_url ?>/images/tripadvisor-icon.png" alt="Tripadvisor" class="h-9 w-9">
                        <span class="text-2xl font-bold text-gray-900">Tripadvisor</span>
                    </a>

                </div>

                <!-- LADO DERECHO: CARRUSEL DE TESTIMONIOS -->
                <div class="md:col-span-9">
                    <div class="swiper mySwiper relative">
                        <div class="swiper-wrapper">

                            <?php foreach ($trip_text['slides'] as $slide): ?>
                                <div class="swiper-slide h-auto">
                                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 h-full flex flex-col">

                                        <!-- ESTRELLAS -->
                                        <div class="flex gap-1 mb-4">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fa-solid fa-star text-orange-custom text-lg"></i>
                                            <?php endfor; ?>
                                        </div>

                                        <!-- TESTIMONIO -->
                                        <p class="text-gray-700 font-poppins text-sm leading-relaxed italic flex-1">
                                            "<?= $slide['texto'] ?>"
                                        </p>

                                        <!-- NOMBRE + FECHA + AVATAR -->
                                        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                                            <div>
                                                <p class="text-orange-custom text-sm font-bold font-poppins">
                                                    - <?= ucwords(strtolower($slide['nombre'])) ?>
                                                </p>
                                                <p class="text-gray-500 text-xs font-poppins">
                                                    <?= $slide['fecha'] ?>
                                                </p>
                                            </div>
                                            <img src="<?= $base_url ?>/images/testimonials/<?= $slide['img'] ?>"
                                                alt="<?= $slide['nombre'] ?>"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-orange-custom">
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ******************** 
     videos testimoniales
    *********************** -->
    <section id="videos-testimoniales" class="relative w-full py-16 md:py-20 overflow-hidden">

        <!-- IMAGEN DE FONDO -->
        <img src="<?= $base_url . $videos_test['background_img'] ?>"
            alt="<?= $videos_test['title'] ?>"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4">

            <!-- TITULO CENTRADO -->
            <div class="text-center mb-10">
                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $videos_test['kicker'] ?>
                </p>

                <h2 class="text-4xl md:text-5xl font-anton text-white leading-tight">
                    <?= $videos_test['title'] ?>
                </h2>
            </div>

            <!-- GRID DE VIDEOS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-6xl mx-auto">

                <?php foreach ($videos_test['videos'] as $video): ?>
                    <button type="button"
                            class="video-trigger relative rounded-xl overflow-hidden shadow-lg group h-56 md:h-64"
                            data-video-url="<?= htmlspecialchars($video['video_url']) ?>">

                        <img src="<?= $base_url . $video['thumbnail'] ?>"
                            alt="<?= $video['titulo'] ?>"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                        <!-- OVERLAY SUTIL SOBRE THUMBNAIL -->
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>

                        <!-- BOTON PLAY -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-orange-custom rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-play text-white text-lg md:text-xl ml-1"></i>
                            </div>
                        </div>

                    </button>
                <?php endforeach; ?>

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
    <section id="blog" class="bg-white py-14">
        <div class="container-custom mx-auto px-20">

            <!-- TITULO + VER TODOS -->
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $blog_text['kicker'] ?>
                    </p>

                    <h2 class="text-3xl md:text-5xl font-anton leading-tight mb-2">
                        <span class="text-gray-900"><?= $blog_text['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $blog_text['title_secondary'] ?></span>
                    </h2>

                    <p class="text-gray-500 font-poppins font-light text-base">
                        <?= $blog_text['description'] ?>
                    </p>
                </div>

                <a href="<?= $base_url ?>/blog/template-blog.php?lang=<?= $idioma ?>"
                class="inline-flex items-center gap-2 text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide hover:text-[#c2660a] transition">
                    <?= $blog_text['ver_todos'] ?>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- GRID DE POSTS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php foreach ($blog_posts as $post): ?>
                    <a href="<?= $base_url ?>/blog/template-articulo.php?articulo=<?= $post['url'] ?>&lang=<?= $idioma ?>"
                    class="block bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">

                        <!-- IMAGEN -->
                        <div class="h-48 w-full overflow-hidden">
                            <img src="<?= $base_url . $post['img'] ?>"
                                alt="<?= $post['titulo'] ?>"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- CONTENIDO -->
                        <div class="p-4">

                            <p class="text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide mb-2">
                                <?= $post['categoria'] ?>
                            </p>

                            <h3 class="text-lg font-bold font-poppins text-gray-900 leading-snug mb-2">
                                <?= $post['titulo'] ?>
                            </h3>

                            <p class="text-gray-500 text-sm font-poppins font-light leading-snug mb-3">
                                <?= $post['descripcion'] ?>
                            </p>

                            <span class="inline-flex items-center gap-1.5 text-orange-custom text-sm font-bold font-poppins">
                                <?= $post['link_text'] ?>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </span>

                        </div>

                    </a>
                <?php endforeach; ?>

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

        <!-- OVERLAY OSCURO -->
        <div class="absolute inset-0 bg-black/45"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4">

            <!-- TITULO CENTRADO -->
            <div class="text-center mb-10">
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
                    <div class="flex flex-col items-center w-32 sm:w-36 md:w-40">
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