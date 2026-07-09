<?php
$idioma = $_GET['lang'] ?? 'es';
$destino_slug = $_GET['destino'] ?? null;

if (!$destino_slug) {
    die("Destino no especificado");
}

$destino_file = __DIR__ . "/../data/destinos/{$destino_slug}.{$idioma}.json";

if (!file_exists($destino_file)) {
    die("Destino no encontrado");
}

$destino_json = file_get_contents($destino_file);
$destino = json_decode($destino_json, true);

$footer_json = file_get_contents(__DIR__ . "/../locale/$idioma/footer.json");
$footer = json_decode($footer_json, true);

$base_url = "..";
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $destino['titulo'] ?> - Tours | GT Peru Travel</title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17034229022"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-17034229022');
    </script>


    <!-- faviicon -->
    <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">

    <!-- Whatssap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- icon from menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS (CDN) -->
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

    <!-- google fonts ANTON - 1 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <!-- Google Fonts POPPINS - 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="css/style.css">

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
    <section class="relative w-full min-h-[550px] bg-black overflow-hidden">

        <img src="<?= $base_url . $destino['background'] ?>"
             alt="<?= $destino['titulo'] ?>"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/20"></div>

        <!-- CONTENIDO -->
        <div class="relative z-10 container-custom mx-auto px-4 pt-24 pb-16">

            <span class="inline-block bg-orange-custom/90 text-white text-xs font-bold font-poppins uppercase tracking-wide px-4 py-1.5 rounded-full mb-4">
                <?= $destino['badge'] ?>
            </span>

            <h1 class="text-white text-5xl md:text-6xl font-anton mb-4">
                <?= $destino['titulo'] ?>
            </h1>

            <p class="text-white/85 font-poppins font-light text-base md:text-lg max-w-xl">
                <?= $destino['descripcion'] ?>
            </p>

        </div>

        <!-- BARRA DE ESTADISTICAS -->
        <div class="absolute bottom-0 left-0 w-full z-10 bg-black/30 backdrop-blur-sm">
            <div class="container-custom mx-auto px-4 py-5 relative">

                <div class="flex flex-wrap justify-center gap-x-16 gap-y-4">
                    <?php foreach ($destino['stats'] as $stat): ?>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid <?= $stat['icono'] ?> text-orange-custom text-2xl"></i>
                            <div class="text-left flex flex-col gap-1">
                                <p class="text-white text-2xl font-anton leading-none"><?= $stat['numero'] ?></p>
                                <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $stat['titulo'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- BADGE FLOTANTE -->
                <div class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 items-center gap-2 bg-orange-custom text-white text-sm font-bold font-poppins px-4 py-2 rounded-full shadow-lg">
                    <i class="fa-solid fa-star"></i>
                    <?= $destino['badge_flotante']['calificacion'] ?> <?= $destino['badge_flotante']['texto'] ?>
                </div>

            </div>
        </div>

    </section>

    <!-- ******************** 
         FILTROS + GRID DE TOURS
     *********************** -->
    <section class="container-custom mx-auto px-4 py-14">

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
                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>"
                   class="tour-card block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300"
                   data-categoria="<?= $t['categoria'] ?>">

                    <div class="h-56 w-full overflow-hidden">
                        <img src="<?= $base_url ?>/images/<?= $t['image'] ?>"
                             alt="<?= $t['title'] ?>"
                             class="w-full h-full object-cover">
                    </div>

                    <div class="px-4 pt-4">
                        <p class="text-orange-custom text-sm font-bold font-poppins mb-1">
                            <?= $t['duracion'] ?>
                        </p>
                        <h3 class="text-base font-bold font-poppins text-gray-900 leading-snug mb-1">
                            <?= $t['title'] ?>
                        </h3>
                        <p class="text-gray-500 text-sm font-poppins font-light leading-snug">
                            <?= $t['description'] ?>
                        </p>
                    </div>

                    <div class="mt-4 border-t border-gray-200"></div>

                    <div class="flex items-center justify-between px-4 py-4">
                        <div>
                            <span class="block text-xs text-gray-400 font-poppins leading-none mb-1">desde</span>
                            <span class="text-2xl font-bold text-orange-custom">$<?= $t['price'] ?></span>
                        </div>
                        <span class="bg-orange-custom hover:bg-[#c2660a] text-white text-sm font-bold px-6 py-2.5 rounded-full transition">
                            Reservar
                        </span>
                    </div>

                </a>
            <?php endforeach; ?>

        </div>

    </section>

    <?php include(__DIR__ . '/../footer.php') ?>

    <script src="<?= $base_url ?>/js/filtro-tours.js"></script>

</body>
</html>