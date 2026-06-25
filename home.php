<!-- home -->
<main>

    <!-- ******************** 
          video promotional 
     *********************** -->
    <section id="video" class="relative w-full h-[80vh] bg-black overflow-hidden">

        <!-- VIDEO PC -->
        <video autoplay muted loop playsinline
            class="hidden md:block absolute top-0 left-0 w-full h-full object-cover">
            <!-- <source src="<?= $base_url ?>/video/slider-pc.webm" type="video/webm"> -->
            <source src="<?= $base_url ?>/video/slider-machupicchu-web-pc-mobil.mp4" type="video/mp4">
        </video>

        <!-- VIDEO MOBILE (más liviano) -->
        <video autoplay muted loop playsinline
            class="block md:hidden absolute top-0 left-0 w-full h-full object-cover">
            <!-- <source src="<?= $base_url ?>/video/slider-mobile.webm" type="video/webm"> -->
            <source src="<?= $base_url ?>/video/slider-machupicchu-web-pc-mobil.mp4" type="video/mp4">
        </video>

        <!-- capa de texto -->
        <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 bg-black/50 py-6 text-center">
            <h2 class="text-white text-[2rem] md:text-5xl font-black drop-shadow-lg">
                <?= html_entity_decode($video_text['titulo']) ?>
            </h2>
            <a href="paquete/template-paquete.php?paquete=peru-mistico&lang=<?= htmlspecialchars($idioma) ?>"
                class="mt-4 inline-flex items-center px-6 py-3 text-[0.9rem] bg-white text-black font-semibold rounded-full transition duration-300 ease-in-out hover:bg-[#000000] hover:text-white shadow-md">
                <?= html_entity_decode($video_text['subtitulo']) ?>
            </a>

        </div>

        <!-- imagen encima del video logo tripadvisor -->
        <div class="absolute bottom-4 left-1/2 -translate-x-[620px] max-w-[1240px] w-full flex justify-start px-4">
            <img src="<?= $base_url ?>/images/tripadvisor-video.png" alt="Tripadvisor" class="h-28">
        </div>

    </section>

    <!-- ******************** 
         nosotros - empresa
     *********************** -->
    <section class="container-custom mx-auto px-4 py-14">
        <div class="w-20 h-1 bg-orange-custom mx-auto mb-6 rounded"></div>
        <div class="max-w-4xl mx-auto text-center">

            <!-- titulo -->
            <h1 class="text-3xl md:text-5xl font-anton mb-4">
                <span class="text-gray-900">
                    <?= $about_text['title_primary'] ?>
                </span>
                <span class="text-orange-custom">
                    <?= $about_text['title_secondary'] ?>
                </span>
            </h1>

            <!-- texto -->
            <p class="text-gray-600 font-poppins font-light text-base md:text-lg mb-8">
                <?= $about_text['description'] ?>
            </p>

            <!-- beneficios -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm md:text-base font-poppins text-gray-700">
                <?php foreach ($about_text['features'] as $feature): ?>
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-[#34e0a1] text-lg">✔</span>
                        <?= $feature ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ******************** 
         trip-advisor
     *********************** -->
    <section id="trip-advisor">
        <div class="container-custom mx-auto px-4">
            <div class="py-8 md:py-12">
                <div class="text-center mt-6 mb-6">
                    <img src="<?= $base_url ?>/images/satisfaccion.png"
                        alt="Opiniones de viajeros en TripAdvisor"
                        class="h-16 md:h-18 mx-auto">
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-center font-anton">
                    <span class="text-orange-custom">
                        <?= $trip_text['title_primary'] ?>
                    </span>
                    <span class="text-gray-900">
                        <?= $trip_text['title_secondary'] ?>
                    </span>
                </h2>

                <p class="mt-4 text-gray-600 text-base md:text-lg font-poppins font-light text-center">
                    <?= $trip_text['subtitle'] ?>
                </p>
            </div>

            <div class="distribucion grid grid-cols-1 md:grid-cols-10 gap-6 items-center pb-16">

                <!-- LADO IZQUIERDO 30% -->
                <div class="lado-izquierdo md:col-span-3">
                    <!-- trofy-logo -->
                    <div class="container-custom mx-auto px-4">
                        <div class="flex flex-col items-center md:items-start gap-4 py-3">
                            <div class="flex flex-col items-center">

                                <div class="flex space-x-3 justify-center">
                                    <img src="<?= $base_url ?>/images/trofy-1.png" alt="logo-1" class="h-16">
                                    <img src="<?= $base_url ?>/images/trofy-2.png" alt="logo-2" class="h-16">
                                </div>

                                <a href="https://www.tripadvisor.com/Attraction_Review-g294314-d19390237-Reviews-GT_PERU_TRAVEL-Cusco_Cusco_Region.html" target="_blank">
                                    <img
                                        src="<?= $base_url ?>/images/tripadvisor.png"
                                        alt="logo-central"
                                        class="h-10 md:h-12 lg:h-14 w-auto mt-4 mx-auto">
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- LADO DERECHO 70% -->
                <div class="lado-derecho md:col-span-7">

                    <!-- Slider -->
                    <div class="container-custom mx-auto px-4">
                        <div class="swiper mySwiper py-9">
                            <div class="swiper-wrapper">

                                <?php foreach ($trip_text['slides'] as $slide): ?>
                                    <div class="swiper-slide flex justify-center">
                                        <div class="relative w-full max-w-sm md:max-w-md lg:max-w-lg h-64 border-4 border-[#34e0a1] rounded-3xl shadow-md flex items-center justify-center">

                                            <div class="font-[Poppins] absolute inset-2 bg-[#F1F1F1] rounded-3xl flex flex-col justify-between p-4 text-center">

                                                <div class="flex flex-col items-center">
                                                    <img src="<?= $base_url ?>/images/testimonials/<?= $slide['img'] ?>"
                                                        alt="<?= $slide['nombre'] ?>"
                                                        class="mx-auto -mt-16 h-[80px]">

                                                    <h3 class="font-semibold mt-1 text-sm">
                                                        <?= $slide['nombre'] ?>
                                                    </h3>

                                                    <img src="<?= $base_url ?>/images/trip-points.png"
                                                        alt="trip-points"
                                                        class="h-6 mx-auto mt-1">

                                                    <p class="mt-1 text-xs leading-snug">
                                                        <?= $slide['texto'] ?>
                                                    </p>
                                                </div>

                                                <p class="font-medium text-[0.65rem] mt-2 tracking-wide">
                                                    <?= $slide['fecha'] ?>
                                                </p>

                                            </div>
                                        </div>
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
        Titulo Paquetes mas populares
     *********************** -->
    <section id="paquetes-populares" class="py-8 bg-white">
        <div class="container-custom px-4">
            <div class="text-center mt-6 mb-6">
                <img src="<?= $base_url ?>/images/populares.png"
                    alt="paquetes de tours mas populares"
                    class="h-16 md:h-18 mx-auto">
            </div>
            <h2 class="text-3xl md:text-5xl font-bold font-anton text-center">
                <span class="text-orange-custom">
                    <?= $popular_text['title_primary'] ?>
                </span>
                <span class="text-gray-900">
                    <?= $popular_text['title_secondary'] ?>
                </span>
            </h2>

            <p class="mt-4 text-gray-600 text-base md:text-lg font-poppins font-light text-center">
                <?= $popular_text['description'] ?>
            </p>
        </div>
    </section>


    <!-- ************************ 
         carrusel paquetes mas populares
        ************************ -->

    <?php
    $promo_packages = array_filter($cards, function ($p) {
        return isset($p['promo']['active']) && $p['promo']['active'] === true;
    });
    ?>


    <div class="container-custom mx-auto px-4 py-8 md:py-16">
        <div class="swiper mySwiperPopular px-4 relative">
            <div class="swiper-wrapper">

                <?php foreach ($promo_packages as $p) : ?>
                    <div class="swiper-slide">

                        <div class="relative h-[32rem] shadow-lg overflow-hidden rounded-xl hover:scale-105 transition-transform">

                            <!-- Link -->
                            <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $p['url'] ?>&lang=<?= $idioma ?>"
                                class="absolute inset-0 z-30"></a>

                            <!-- Imagen -->
                            <div class="absolute inset-0 overflow-hidden">

                                <?php
                                $imagenes = [];

                                if (isset($p['image'])) {
                                    if (is_array($p['image'])) {
                                        $imagenes = $p['image'];
                                    } else {
                                        $imagenes = [$p['image']];
                                    }
                                }
                                ?>

                                <?php if (count($imagenes) > 1): ?>

                                    <div class="card-slider relative w-full h-full">

                                        <?php foreach ($imagenes as $i => $img): ?>

                                            <img
                                                src="<?= $base_url ?>/images/<?= $img ?>"
                                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 <?= $i === 0 ? 'opacity-100' : 'opacity-0' ?>">

                                        <?php endforeach; ?>

                                    </div>

                                <?php else: ?>

                                    <img
                                        src="<?= $base_url ?>/images/<?= $imagenes[0] ?>"
                                        class="absolute inset-0 w-full h-full object-cover">

                                <?php endif; ?>

                            </div>

                            <!-- Badge Promo -->
                            <?php if (isset($p['promo']['active']) && $p['promo']['active']) : ?>
                                <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full z-40 shadow-lg font-poppins">
                                    <?= $p['promo']['label'] ?>
                                </div>
                            <?php endif; ?>

                            <!-- INFO -->
                            <div class="absolute bottom-0 w-full bg-gradient-to-t from-black/80 to-transparent p-4 text-white">

                                <!-- CONTENIDO -->
                                <div class="flex flex-col text-left leading-tight">

                                    <h3 class="text-2xl md:text-3xl font-bold font-anton">
                                        <?= $p['title'] ?>
                                    </h3>

                                    <h4 class="text-sm md:text-base font-bold text-[#FF9300] mt-1">
                                        <?= $p['subtitle'] ?>
                                    </h4>

                                    <p class="text-sm font-poppins font-light mt-1">
                                        <?= $p['description'] ?>
                                    </p>

                                </div>

                                <!-- PRECIO + BOTON -->
                                <div class="grid grid-cols-2 items-center mt-4">

                                    <!-- PRECIO -->
                                    <div>

                                        <?php if (isset($p['promo']['active']) && $p['promo']['active']) : ?>

                                            <span class="text-sm line-through text-gray-300">
                                                <?= $p['promo']['old_price'] ?>
                                            </span>

                                            <span class="text-xl font-bold text-[#FF9300] ml-2">
                                                <?= $p['price'] ?>
                                            </span>

                                        <?php else : ?>

                                            <span class="text-xl font-bold text-[#FF9300]">
                                                <?= $p['price'] ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                    <!-- BOTON -->
                                    <div class="flex justify-end">

                                        <button class="bg-[#FF9300] hover:bg-[#ff6f0f] text-white text-sm font-bold px-5 py-2 rounded-xl transition">
                                            <?= $p['reservar'] ?>
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

            <!-- BOTON ANTERIOR -->
            <div class="custom-prev-popular w-16 h-16 bg-white/70 hover:bg-white/90 rounded-full flex items-center justify-center absolute left-4 top-1/2 -translate-y-1/2 cursor-pointer shadow-lg z-50 transition-all duration-300">
                <div class="w-0 h-0 border-t-[10px] border-b-[10px] border-r-[15px] border-t-transparent border-b-transparent border-r-[#FF9300]"></div>
            </div>

            <!-- BOTON SIGUIENTE -->
            <div class="custom-next-popular w-16 h-16 bg-white/70 hover:bg-white/90 rounded-full flex items-center justify-center absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer shadow-lg z-50 transition-all duration-300">
                <div class="w-0 h-0 border-t-[10px] border-b-[10px] border-l-[15px] border-t-transparent border-b-transparent border-l-[#FF9300]"></div>
            </div>

        </div>
    </div>



    <!-- ******************** 
        Nuestros paquetes titulo
*********************** -->
    <section id="nuestros-paquetes" class="py-8 bg-white">
        <div class="container-custom px-4">
            <div class="text-center mt-6 mb-6">
                <img src="<?= $base_url ?>/images/paquetes-turisticos.png"
                    alt="paquetes turisticos"
                    class="h-16 md:h-18 mx-auto">
            </div>
            <h2 class="text-3xl md:text-5xl font-bold font-anton text-center">

                <span class="text-orange-custom">
                    <?= $packages_text['title_primary'] ?>
                </span>

                <span class="text-gray-900">
                    <?= $packages_text['title_secondary'] ?>
                </span>

            </h2>
            <p class="mt-4 text-gray-600 text-base md:text-lg font-poppins font-light text-center">
                <?= $packages_text['description'] ?>
            </p>
        </div>
    </section>

    <!-- ************************ 
        Listado de paquetes
     *********************** -->
    <!-- pakages -->
    <section id="pakages">

        <!-- Paquetes -->
        <div class="bg-white py-12">
            <div class="container-custom mx-auto px-4">

                <!-- GRID de tarjetas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Incio de tarjetas  -->
                    <?php $idioma = $_GET['lang'] ?? 'es'; ?>

                    <!-- Tarjeta modelo -->
                    <?php foreach ($cards as $c): ?>
                        <div class="relative shadow-lg overflow-hidden h-[40rem] rounded-xl">

                            <!-- LINK -->
                            <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $c['url'] ?>&lang=<?= $idioma ?>"
                                class="absolute inset-0 z-30 hover:bg-white/5 transition duration-300"></a>

                            <!-- IMAGEN -->
                            <div class="absolute inset-0 overflow-hidden">

                                <?php
                                $imagenes = [];

                                if (isset($c['image'])) {

                                    if (is_array($c['image'])) {
                                        $imagenes = $c['image']; // varias imágenes
                                    } else {
                                        $imagenes = [$c['image']]; // una sola
                                    }
                                }
                                ?>

                                <?php if (count($imagenes) > 1): ?>

                                    <div class="card-slider relative w-full h-full">

                                        <?php foreach ($imagenes as $i => $img): ?>

                                            <img
                                                src="<?= $base_url ?>/images/<?= $img ?>"
                                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 <?= $i === 0 ? 'opacity-100' : 'opacity-0' ?>">

                                        <?php endforeach; ?>

                                    </div>

                                <?php else: ?>

                                    <img
                                        src="<?= $base_url ?>/images/<?= $imagenes[0] ?>"
                                        class="absolute inset-0 w-full h-full object-cover">

                                <?php endif; ?>

                            </div>

                            <!-- BADGE PROMO -->
                            <?php if (isset($c['promo']['active']) && $c['promo']['active']): ?>
                                <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full z-40 shadow-lg font-poppins">
                                    <?= $c['promo']['label'] ?>
                                </div>
                            <?php endif; ?>

                            <!-- CONTENIDO -->
                            <div class="absolute bottom-0 left-0 w-full z-10 bg-gradient-to-t from-black/70 to-transparent p-5 text-center">

                                <div class="inline-block text-center leading-none">
                                    <h3 class="bg-[#ff9300] text-[1.5rem] font-bold text-white px-6 py-[4px]">
                                        <?= $c['title'] ?>
                                    </h3>

                                    <h4 class="bg-[#12110F] text-[1rem] font-bold text-[#ff9300] px-6 py-[4px]">
                                        <?= $c['subtitle'] ?>
                                    </h4>
                                </div>

                                <p class="text-white mt-2 text-[0.8rem] font-[Poppins] text-left px-6" style="word-spacing: -1px;">
                                    <?= $c['description'] ?>
                                </p>

                                <!-- GRID INFO -->
                                <div class="grid grid-cols-[2fr_0.5fr_1fr] items-center gap-2 mt-4">

                                    <!-- PRECIO POR PERSONA -->
                                    <div class="flex items-center gap-2">

                                        <img src="<?= $base_url ?>/images/person.png" class="w-10 h-10">

                                        <?php
                                        $lang = $_GET['lang'] ?? 'es';

                                        switch ($lang) {
                                            case 'en':
                                                $precio_persona = "Price per person";
                                                break;

                                            case 'pt':
                                                $precio_persona = "Preço por pessoa";
                                                break;

                                            default:
                                                $precio_persona = "Precio por persona";
                                                break;
                                        }
                                        ?>

                                        <span class="text-[0.8rem] font-[Poppins] text-white">
                                            <?= $precio_persona ?>
                                        </span>

                                    </div>

                                    <!-- FLECHA -->
                                    <div class="flex justify-center">
                                        <img src="<?= $base_url ?>/images/arrow-right.png" class="w-16 h-6">
                                    </div>

                                    <!-- PRECIO -->
                                    <div class="text-right">

                                        <a href="<?= $base_url ?>/paquete/template-paquete.php?paquete=<?= $c['url'] ?>&lang=<?= $idioma ?>"
                                            class="bg-[#ff9300] hover:bg-opacity-70 text-black text-xs font-bold px-4 py-2 rounded-xl">
                                            <?= $c['reservar'] ?>
                                        </a>

                                        <!-- PRECIO PROMO -->
                                        <?php if (isset($c['promo']['active']) && $c['promo']['active']): ?>

                                            <?php if (isset($c['promo']['old_price'])): ?>
                                                <div class="text-sm line-through text-gray-300">
                                                    <?= $c['promo']['old_price'] ?>
                                                </div>
                                            <?php endif; ?>

                                            <h5 class="font-bold text-[#FF9300] text-[2rem]">
                                                <?= $c['price'] ?>
                                            </h5>

                                        <?php else: ?>

                                            <h5 class="font-bold text-white text-[2rem]">
                                                <?= $c['price'] ?>
                                            </h5>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                    <!-- fin de tarjetas -->

                </div>
            </div>
        </div>

    </section>


    <!-- ************************ 
        TOURS DE UN DIA
     *********************** -->
    <!-- tours más solicitados -->
    <section id="tours" class="py-12 bg-white">

        <div class="container-custom mx-auto px-4 space-y-8">

            <!-- Contenedor principal dentro del container -->
            <div class="container-custom mx-auto px-4">
                <div class="text-center mt-6 mb-6">
                    <img src="<?= $base_url ?>/images/tours-de-un-dia.png"
                        alt="tours de un dia"
                        class="h-16 md:h-18 mx-auto">
                </div>

                <!-- Titulo -->
                <h2 class="text-3xl md:text-5xl font-bold font-anton text-center leading-tight">

                    <span class="text-orange-custom">
                        <?= $tours_text['tours'] ?>
                    </span>

                    <span class="text-gray-900">
                        <?= $tours_text['mas_solicitados'] ?>
                    </span>

                </h2>

                <!-- Descripción -->
                <p class="mt-4 text-gray-600 text-base md:text-lg font-poppins font-light text-center">
                    <?= $tours_text['descripcion'] ?>
                </p>

            </div>


            <!-- ************************ 
                 CARRUSEL DE TOURS
            *********************** -->
            <div class="swiper mySwiperTours px-4 relative">
                <div class="swiper-wrapper">

                    <?php foreach ($tours as $t) : ?>
                        <div class="swiper-slide">

                            <div class="relative h-[32rem] shadow-lg overflow-hidden rounded-xl hover:scale-105 transition-transform">

                                <!-- Link hacia template-tour.php -->
                                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>" class="absolute inset-0 z-30"></a>

                                <!-- Imagen -->
                                <img src="<?= $base_url ?>/images/<?= $t['image'] ?>" class="absolute inset-0 w-full h-full object-cover">

                                <!-- Badge Promo (si existe) -->
                                <?php if (isset($t['promo']['active']) && $t['promo']['active']) : ?>
                                    <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full z-40 shadow-lg font-poppins">
                                        <?= $t['promo']['label'] ?>
                                    </div>
                                <?php endif; ?>

                                <!-- INFO -->
                                <div class="absolute bottom-0 w-full bg-gradient-to-t from-black/80 to-transparent p-4 text-white">

                                    <div class="flex flex-col text-left leading-tight">
                                        <h3 class="text-2xl md:text-3xl font-bold font-anton"><?= $t['title'] ?></h3>
                                        <h4 class="text-sm md:text-base font-bold text-[#FF9300] mt-1"><?= $t['subtitle'] ?></h4>
                                        <p class="text-sm font-poppins font-light mt-1"><?= $t['description'] ?></p>
                                    </div>

                                    <!-- PRECIO + BOTON -->
                                    <div class="grid grid-cols-2 items-center mt-4">
                                        <div>
                                            <?php if (isset($t['promo']['active']) && $t['promo']['active']) : ?>
                                                <span class="text-sm line-through text-gray-300"><?= $t['promo']['old_price'] ?></span>
                                                <span class="text-xl font-bold text-[#FF9300] ml-2"><?= $t['price'] ?></span>
                                            <?php else : ?>
                                                <span class="text-xl font-bold text-[#FF9300]"><?= $t['price'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex justify-end">
                                            <button class="bg-[#FF9300] hover:bg-[#ff6f0f] text-white text-sm font-bold px-5 py-2 rounded-xl transition">
                                                <?= $t['reservar'] ?>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- BOTON ANTERIOR -->
                <div class="custom-prev-tour w-16 h-16 bg-white/70 hover:bg-white/90 rounded-full flex items-center justify-center absolute left-4 top-1/2 -translate-y-1/2 cursor-pointer shadow-lg z-50 transition-all duration-300">
                    <div class="w-0 h-0 border-t-[10px] border-b-[10px] border-r-[15px] border-t-transparent border-b-transparent border-r-[#ff9300]"></div>
                </div>

                <!-- BOTON SIGUIENTE -->
                <div class="custom-next-tour w-16 h-16 bg-white/70 hover:bg-white/90 rounded-full flex items-center justify-center absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer shadow-lg z-50 transition-all duration-300">
                    <div class="w-0 h-0 border-t-[10px] border-b-[10px] border-l-[15px] border-t-transparent border-b-transparent border-l-[#ff9300]"></div>
                </div>

            </div>
        </div>
    </section>


    <!-- ************************ 
        MAS TOURS
    *********************** -->

    <!-- tours -->
    <section id="tours-video2" class="relative w-full h-[80vh] bg-black overflow-hidden">

        <!-- video (solo visible en pantallas medianas hacia arriba) -->
        <video autoplay muted loop playsinline
            class="absolute top-0 left-0 w-full h-full object-cover">
            <source src="<?= $base_url ?>/video/tours.mp4" type="video/mp4">
        </video>

        <!-- Contenedor del título y párrafo -->
        <div class="absolute top-[80%] left-1/2 -translate-x-1/2 -translate-y-1/2 text-center z-10">

            <!-- Solo el h2 con fondo -->
            <div class="bg-black/50 px-6 py-3 rounded-lg inline-block mb-1"> <!-- mb-1 en lugar de mb-4 -->
                <h2 class="text-white text-3xl md:text-5xl font-black drop-shadow-lg">
                    <span class="text-orange-custom text-[2.5rem]"><?= $more_tours['title'] ?></span>
                </h2>
            </div>

            <!-- Párrafo sin fondo -->
            <p class="relative bg-black px-4 py-2 rounded-lg text-center z-10 max-w-[300px] 
        text-white font-[Poppins] mt-1 mx-auto text-[0.8rem]"> <!-- mt-1 en lugar de mt-3 -->
                <?= $more_tours['description'] ?>
            </p>

        </div>

    </section>


    <!-- ************************ 
       NUEVOS DESTINOS
    *********************** -->
    <!-- new destinations -->
    <section id="new-destinations" class="bg-white text-white py-12">
        <div class="container-custom mx-auto px-4 space-y-6">

            <!-- Fila 1: Título + Imagen grande -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">

                <!-- Columna de texto -->
                <!-- Columna de texto -->
                <div class="flex flex-col justify-center h-full">
                    <div class="mx-auto w-full max-w-[1240px]">
                        <h2 class="bg-[#ff9300] font-bold text-black px-[3.2rem] py-[1rem] text-center leading-[1] shadow-lg w-full">
                            <div class="inline-flex flex-col items-center w-full scale-[0.89]">
                                <!-- NUEVOS -->
                                <span class="block text-[clamp(4rem,13.5vw,20rem)] font-black tracking-tight">
                                    <?= $new_dest['title_1'] ?>
                                </span>
                                <!-- DESTINOS -->
                                <span class="block text-[clamp(3.3rem,11vw,16rem)] font-black tracking-tight">
                                    <?= $new_dest['title_2'] ?>
                                </span>
                            </div>
                        </h2>
                    </div>
                </div>



                <!-- Columna de Imagen grande -->
                <div class="h-full">
                    <img src="<?= $base_url ?>/images/destinos-1.gif" alt="Destino 1" class="w-full h-full object-cover rounded-lg border-4 border-[#ff9300]">
                </div>

            </div>

            <!-- Fila 2: Texto B + Imágenes B y C -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">

                <!-- Columna de texto B -->
                <div class="flex flex-col justify-center h-full">
                    <p class="text-lg md:text-xl text-center px-4 py-4 font-[Poppins] text-black " style="word-spacing: -0.5px;">
                        <?= $new_dest['paragraph'] ?>
                    </p>
                </div>

                <!-- Columna de imágenes B y C -->
                <div class="grid grid-cols-2 gap-4">
                    <img src="<?= $base_url ?>/images/destinos-2.gif" alt="Destino 2" class="w-full h-64 md:h-full object-cover rounded-lg border-4 border-[#ff9300]">
                    <img src="<?= $base_url ?>/images/destinos-3.jpg" alt="Destino 3" class="w-full h-64 md:h-full object-cover rounded-lg border-4 border-[#ff9300]">
                </div>

            </div>

        </div>
    </section>


    <!-- ************************ 
       NUESTRAS MARCAS
    *********************** -->
    <!-- Contenedor relativo general -->
    <div class="relative w-full">

        <!-- Línea naranja superior -->
        <div class="bg-[#ff9300] h-[1rem] w-full absolute -top-4 left-0 z-20"></div>

        <!-- Sección principal -->
        <section id="nuestras-marcas"
            class="relative w-full bg-black m-0 p-0 -mb-[2px] overflow-hidden"
            style="height: 36vh; min-height: 300px; max-height: 400px;">

            <!-- Fondo con imagen -->
            <div class="relative w-full h-full bg-cover bg-center bg-no-repeat flex items-center justify-center overflow-hidden"
                style="background-image: url('<?= $base_url ?>/images/fondo-manta.jpg');">

                <div class="container-custom mx-auto px-4">

                    <!-- Contenido principal -->
                    <div
                        class="absolute inset-0 flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-8 text-center sm:text-left z-10">

                        <h2
                            class="text-3xl sm:text-4xl md:text-[6rem] font-black text-white leading-none drop-shadow-lg -mt-4 sm:-mt-[8rem]">
                            <?= $our_brands['title_start'] ?? 'NUESTRAS' ?>
                        </h2>

                        <img src="<?= $base_url ?>/images/personaje-fondo-manta.svg" alt="gt-animado"
                            class="w-[140px] sm:w-[200px] md:w-[280px] object-contain md:translate-y-[1rem]">

                        <h2
                            class="text-3xl sm:text-4xl md:text-[6rem] font-black text-white leading-none drop-shadow-lg mt-[0.5rem] sm:-mt-[8rem]">
                            <?= $our_brands['title_end'] ?? 'MARCAS' ?>
                        </h2>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- ************************ 
       COMPANIA NUESTRAS MARCAS
    *********************** -->
    <section id="company">
        <div class="bg-white text-white py-9">
            <div class="container-custom mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-[3.5rem] font-bold text-[#ff9300] mb-4">
                    <?= $company['company_title'] ?>
                </h2>
                <p class="text-center text-[#000000] text-[1.2rem] font-[Poppins]" style="word-spacing: -0.5px;">
                    <?= $company['company_paragraph'] ?>
                    <br><span class="text-[#ff9300] font-semibold">
                        <?= $company['company_highlight'] ?>
                    </span>
                </p>

            </div>
        </div>

        <!-- MARCAS -->
        <div class="bg-white">
            <div class="container-custom mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- PALCOYO TREKKING -->
                <div class="rounded-2xl shadow-lg p-6 flex flex-col text-left">
                    <!-- Imagen centrada -->
                    <a href="https://palcoyotrekking.com/" target="_blank"><img src="<?= $base_url ?>/images/palcoyo-trekking-logo.png" alt="Palcoyo Trekking" class="w-48 h-32 object-contain mb-4 mx-auto"></a>

                    <!-- Título alineado con el texto -->
                    <h3 class="text-center text-[1.3rem] font-bold bg-[#ff9300] text-black px-3 py-1 rounded-lg mb-2 inline-block">
                        <?= $company['brands']['palcoyo']['title'] ?>
                    </h3>

                    <!-- Texto justificado -->
                    <p class="text-[#000000] mb-6 text-center text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['palcoyo']['description'] ?>
                    </p>

                    <!-- Enlace en lugar de botón -->
                    <div class="flex items-center justify-center space-x-2">
                        <a href="https://palcoyotrekking.com/" target="_blank" class="font-bold text-[#ff9300] hover:text-[#ff9f57] font-[Poppins] text-sm transition" style="word-spacing: -0.5px;">
                            <?= $company['brands']['palcoyo']['link_text'] ?>
                        </a>
                        <img src="<?= $base_url ?>/images/arrow-link.png" alt="arrow" class="h-3 w-8">
                    </div>

                    <!-- Texto inferior alineado a la izquierda -->
                    <p class="text-center mt-4 text-sm text-[#000000] text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['palcoyo']['footer'] ?>
                    </p>
                </div>



                <!-- GT PERU TRAVEL -->
                <div class="rounded-2xl shadow-lg p-6 flex flex-col text-left">
                    <!-- Imagen centrada -->
                    <a href="https://www.gtperutravel.com/" target="_blank"><img src="<?= $base_url ?>/images/gt-peru-travel.png" alt="Palcoyo Trekking" class="w-48 h-32 object-contain mb-4 mx-auto"></a>

                    <!-- Título alineado con el texto -->
                    <h3 class="text-center text-[1.3rem] font-bold bg-[#ff9300] text-black px-3 py-1 rounded-lg mb-2 inline-block">
                        <?= $company['brands']['gt']['title'] ?>
                    </h3>

                    <!-- Texto justificado -->
                    <p class="text-[#000000] mb-6 text-center text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['gt']['description'] ?>
                    </p>

                    <!-- Enlace en lugar de botón -->
                    <div class="flex items-center justify-center space-x-2">
                        <a href="https://www.gtperutravel.com/" target="_blank" class="font-bold text-[#ff9300] hover:text-[#ff9f57] font-[Poppins] text-sm transition" style="word-spacing: -0.5px;">
                            <?= $company['brands']['gt']['link_text'] ?>
                        </a>
                        <img src="<?= $base_url ?>/images/arrow-link.png" alt="arrow" class="h-3 w-8">
                    </div>


                    <!-- Texto inferior alineado a la izquierda -->
                    <p class="text-center mt-4 text-sm text-[#000000] text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['gt']['footer'] ?>
                    </p>
                </div>


                <!-- SUNRISE EXPERIENCE CUSCO -->
                <div class="rounded-2xl shadow-lg p-6 flex flex-col text-left">
                    <!-- Imagen centrada -->
                    <a href="https://sunriseexperiencecusco.com/" target="_blank"><img src="<?= $base_url ?>/images/logo-sunriseexperiencecusco.png" alt="Palcoyo Trekking" class="w-48 h-32 object-contain mb-4 mx-auto"></a>

                    <!-- Título alineado con el texto -->
                    <h3 class="text-center text-[1.3rem] font-bold bg-[#ff9300] text-black px-3 py-1 rounded-lg mb-2 inline-block">
                        <?= $company['brands']['sunrise']['title'] ?>
                    </h3>

                    <!-- Texto justificado -->
                    <p class="text-[#000000] mb-6 text-center text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['sunrise']['description'] ?>
                    </p>

                    <!-- Enlace en lugar de botón -->
                    <div class="flex items-center justify-center space-x-2">
                        <a href="https://sunriseexperiencecusco.com/" target="_blank" class="font-bold text-[#ff9300] hover:text-[#ff9f57] font-[Poppins] text-sm transition" style="word-spacing: -0.5px;">
                            <?= $company['brands']['sunrise']['link_text'] ?>
                        </a>
                        <img src="<?= $base_url ?>/images/arrow-link.png" alt="arrow" class="h-3 w-8">
                    </div>

                    <!-- Texto inferior alineado a la izquierda -->
                    <p class="text-center mt-4 text-sm text-[#000000] text-sm font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $company['brands']['sunrise']['footer'] ?>
                    </p>


                </div>


            </div>
        </div>
    </section>


    <!-- ************************ 
       INFORMACION Y SOPORTE
    *********************** -->
    <section id="links-importantes" class="bg-white py-12">

        <div class="container-custom mx-auto px-12">
            <h2 class="text-3xl md:text-[1.4rem] text-left text-black mb-6 tracking-wide">
                <?= $info_support['section_title'] ?>
            </h2>
        </div>

        <div class="container-custom mx-auto px-12 grid md:grid-cols-4 gap-8">

            <!-- Columna Modelo -->
            <?php foreach ($info_support['columns'] as $col): ?>
                <div>
                    <h3 class="text-lg font-bold mb-4 text-black">
                        <?= $col['title'] ?>
                    </h3>

                    <ul class="space-y-2 text-gray-500 font-[Poppins]">
                        <?php foreach ($col['links'] as $link): ?>
                            <li>
                                <a
                                    href="<?= isset($link['external']) ? $link['url'] : $base_url . $link['url'] ?>"
                                    <?= isset($link['external']) ? 'target="_blank" rel="noopener"' : '' ?>
                                    class="hover:text-[#ff9300] flex items-center gap-2">
                                    <svg class="h-3 w-3 text-gray-400 group-hover:text-[#ff9300] transition duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span><?= $link['text'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>

        </div>
    </section>



</main>