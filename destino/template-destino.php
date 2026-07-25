
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
$hero = file_get_contents(__DIR__ . "/../locale/$idioma/hero.json");
$hero_text = json_decode($hero, true);
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
    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">

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
    <link rel="stylesheet" href="../css/style.css">

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
    <section class="relative w-full h-[82vh] min-h-[650px] bg-black overflow-hidden">

        <img src="<?= $base_url . $destino['background'] ?>"
             alt="<?= $destino['titulo'] ?>"
             class="absolute inset-0 w-full h-full object-cover">
        
        <!-- overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/0 to-black/10"></div>
        <!-- <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div> -->

        <!-- CONTENIDO -->
        <div class="relative z-10  h-full flex items-center justify-center">
            <div class="container-custom  px-20    w-full">
                <div class="max-w-2xl">
                    <!-- BADGE DESTI¿NO -->
                    <span class="inline-flex items-center gap-2 bg-orange-500/50 text-white text-xs font-bold font-poppins uppercase tracking-wide px-4 py-1.5 rounded-md mb-4">
                        <?= $destino['badge'] ?? 'Destino' ?>
                    </span>
                    <h1 class="text-white text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.05] drop-shadow-lg">
                        <?= $destino['titulo'] ?>
                    </h1>

                    <p class="mt-6 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                        <?= $destino['descripcion'] ?>
                    </p>
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
         FILTROS + GRID DE TOURS
     *********************** -->
    <section class="container-custom mx-auto px-20 py-14">

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
                <div class="tour-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300"
                    data-categoria="<?= $t['categoria'] ?>">

                    <!-- Link envolvente -->
                    <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>" class="block">

                        <!-- IMAGEN -->
                        <div class="relative h-72 md:h-80 w-full overflow-hidden px-1 pt-1">
                            <img src="<?= $base_url ?>/images/<?= $t['image'] ?>"
                                alt="<?= $t['title'] ?>"
                                class="w-full h-full object-cover rounded-lg shadow-md">
                        </div>

                        <!-- CONTENIDO -->
                        <div class="p-4">

                            <!-- DURACION -->
                            <p class="text-orange-custom text-xs font-bold font-poppins mb-1">
                                <?= $t['duracion'] ?>
                            </p>

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
                            <span class="text-3xl font-bold text-orange-custom">$<?= $t['price'] ?></span>
                        </div>

                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>"
                        class="inline-flex items-center px-6 py-2 text-sm md:text-base bg-orange-custom text-white font-bold font-poppins rounded-lg transition duration-300 ease-in-out hover:bg-[#c2660a] shadow-md">
                            Reservar
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </section>

    <?php include(__DIR__ . '/../footer.php') ?>

    <script src="<?= $base_url ?>/js/filtro-tours.js"></script>
    <script src="../js/mobile-menu.js"></script>
    <script src="../js/mega-menu.js"></script> 
</body>
</html>