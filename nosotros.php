<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$idioma = $_GET['lang'] ?? 'es';
$allowed = ['es', 'en', 'pt'];
if (!in_array($idioma, $allowed)) {
    $idioma = 'es';
}

$base_url = ".";
$about_meta = [
    'es' => ['title' => 'Sobre nosotros | GT Peru Travel', 'description' => 'Conoce a GT Peru Travel, nuestra historia, equipo, misión, visión y certificaciones.'],
    'en' => ['title' => 'About Us | GT Peru Travel', 'description' => 'Meet GT Peru Travel and discover our story, team, mission, vision and certifications.'],
    'pt' => ['title' => 'Sobre nós | GT Peru Travel', 'description' => 'Conheça a GT Peru Travel, nossa história, equipe, missão, visão e certificações.'],
][$idioma];

$nosotros_path = __DIR__ . "/locale/$idioma/nosotros.json";
if (!file_exists($nosotros_path)) {
    $nosotros_path = __DIR__ . "/locale/es/nosotros.json";
}
$nosotros = json_decode(file_get_contents($nosotros_path), true);

$footer_json = __DIR__ . "/locale/$idioma/footer.json";
$footer = file_exists($footer_json) ? json_decode(file_get_contents($footer_json), true) : [];
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($about_meta['title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($about_meta['description']) ?>">
    <meta name="keywords" content="sobre nosotros, gt peru travel, agencia de turismo cusco, quienes somos, certificaciones turismo peru">

    <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">
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
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>

    <?php include('header.php') ?>

    <main>

        <!-- ******************** 
             HERO
         *********************** -->
        <section class="page-hero page-hero--with-stats responsive-hero relative w-full bg-black overflow-hidden">

            <img src="<?= $base_url . $nosotros['hero']['background'] ?>"
                 alt="<?= htmlspecialchars($nosotros['hero']['title_primary'] . ' ' . $nosotros['hero']['title_highlight']) ?>"
                 class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

            <div class="page-hero-content relative z-10 h-full flex items-center">
                <div class="container-custom px-20 w-full">
                    <div class="max-w-2xl">

                        <span class="inline-block bg-orange-custom/90 text-white text-xs font-bold font-poppins uppercase tracking-wide px-4 py-1.5 rounded-full mb-4">
                            <?= htmlspecialchars($nosotros['hero']['kicker']) ?>
                        </span>

                        <h1 class="text-white text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] font-anton font-black leading-[1.05] drop-shadow-lg">
                            <?= htmlspecialchars($nosotros['hero']['title_primary']) ?> <span class="text-orange-custom"><?= htmlspecialchars($nosotros['hero']['title_highlight']) ?></span><br>
                            <?= htmlspecialchars($nosotros['hero']['title_secondary']) ?>
                        </h1>

                        <p class="mt-6 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                            <?= htmlspecialchars($nosotros['hero']['description']) ?>
                        </p>

                    </div>
                </div>
            </div>

            <!-- Trip awards -->
            <div class="page-hero-awards absolute z-10 bottom-24 md:bottom-28 right-4 md:right-10 flex items-center gap-3">
                <?php foreach ($nosotros['hero']['trip_awards'] as $award): ?>
                    <img src="<?= $base_url . $award['img'] ?>" alt="<?= htmlspecialchars($award['alt']) ?>" class="h-16 md:h-24">
                <?php endforeach; ?>
            </div>

            <!-- barra de estadísticas -->
            <div class="page-hero-stats absolute bottom-0 left-0 w-full z-10 bg-black/20 backdrop-blur-sm">
                <div class="container-custom mx-auto py-5 relative">
                    <div class="flex flex-wrap justify-center gap-y-4 gap-x-20">
                        <?php foreach ($nosotros['hero']['stats'] as $stat): ?>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid <?= $stat['icono'] ?> text-orange-custom text-2xl"></i>
                                <div class="text-left flex flex-col gap-1">
                                    <p class="text-white text-2xl font-anton leading-none"><?= $stat['numero'] ?></p>
                                    <p class="text-white/70 text-xs font-poppins uppercase tracking-wide"><?= $stat['titulo'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 items-center gap-2 bg-orange-custom text-white text-sm font-bold font-poppins px-4 py-2 rounded-full shadow-lg">
                        <i class="fa-solid fa-star"></i>
                        <?= $nosotros['hero']['badge_flotante']['calificacion'] ?> <?= $nosotros['hero']['badge_flotante']['texto'] ?>
                    </div>
                </div>
            </div>

        </section>

        <!-- ******************** 
             QUIENES SOMOS
         *********************** -->
        <section class="container-custom mx-auto px-4 md:px-20 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <div class="relative">
                    <img src="<?= $base_url . $nosotros['quienes_somos']['img'] ?>" alt="Equipo GT Peru Travel"
                         class="w-full h-[380px] md:h-[440px] object-cover rounded-2xl shadow-lg">
                    <span class="absolute bottom-4 left-4 bg-orange-custom text-white text-xs font-bold font-poppins uppercase px-4 py-2 rounded-lg shadow-md">
                        <?= htmlspecialchars($nosotros['quienes_somos']['badge_img']) ?>
                    </span>
                </div>

                <div>
                    <p class="section-kicker text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                        <?= $nosotros['quienes_somos']['kicker'] ?>
                    </p>
                    <h2 class="text-3xl md:text-4xl font-anton mb-4 leading-tight">
                        <span class="text-gray-900"><?= $nosotros['quienes_somos']['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $nosotros['quienes_somos']['title_secondary'] ?></span><br>
                        <span class="text-gray-900"><?= $nosotros['quienes_somos']['title_tertiary'] ?></span>
                    </h2>

                    <p class="text-gray-600 font-poppins font-light text-sm md:text-base mb-4 leading-relaxed">
                        <?= htmlspecialchars($nosotros['quienes_somos']['description_1']) ?>
                    </p>
                    <p class="text-gray-600 font-poppins font-light text-sm md:text-base mb-4 leading-relaxed">
                        <?= htmlspecialchars($nosotros['quienes_somos']['description_2']) ?>
                    </p>

                    <div class="grid grid-cols-4 gap-4 mt-6">
                        <?php foreach ($nosotros['quienes_somos']['stats'] as $stat): ?>
                            <div>
                                <p class="text-orange-custom text-xl md:text-2xl font-anton leading-none"><?= $stat['numero'] ?></p>
                                <p class="text-gray-400 text-[0.6rem] md:text-xs font-poppins uppercase tracking-wide"><?= $stat['titulo'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>

        <!-- ******************** 
             EQUIPO
         *********************** -->
        <section class="bg-white py-16">
            <div class="container-custom mx-auto px-4 md:px-20 text-center">

                <p class="section-kicker section-kicker-center text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2"><?= $nosotros['equipo']['kicker'] ?></p>
                <h2 class="text-3xl md:text-4xl font-anton mb-3">
                    <span class="text-gray-900"><?= $nosotros['equipo']['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $nosotros['equipo']['title_secondary'] ?></span>
                </h2>
                <p class="text-gray-500 font-poppins text-sm md:text-base mb-10 max-w-xl mx-auto"><?= $nosotros['equipo']['description'] ?></p>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                    <?php foreach ($nosotros['equipo']['asesores'] as $a): ?>
                        <div class="flex flex-col items-center">
                            <img src="<?= $base_url . $a['foto'] ?>" alt="<?= htmlspecialchars($a['nombre']) ?>"
                                 class="w-24 h-24 rounded-full object-cover mb-3 shadow-md">
                            <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($a['nombre']) ?></p>
                            <p class="text-orange-custom text-[0.65rem] font-bold font-poppins uppercase tracking-wide mb-2"><?= htmlspecialchars($a['cargo']) ?></p>
                            <a href="https://wa.me/<?= $a['whatsapp'] ?>" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 bg-[#25D366] hover:bg-[#1ebe5a] text-white text-xs font-bold font-poppins px-4 py-1.5 rounded-full transition">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ******************** 
             VENTAJAS
         *********************** -->
        <section class="bg-[#faf9f7] py-16">
            <div class="container-custom mx-auto px-4 md:px-20 text-center">

                <p class="section-kicker section-kicker-center text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2"><?= $nosotros['ventajas']['kicker'] ?></p>
                <h2 class="text-3xl md:text-4xl font-anton mb-3">
                    <span class="text-gray-900"><?= $nosotros['ventajas']['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $nosotros['ventajas']['title_secondary'] ?></span>
                </h2>
                <p class="text-gray-500 font-poppins text-sm md:text-base mb-10 max-w-xl mx-auto"><?= $nosotros['ventajas']['description'] ?></p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-left">
                    <?php foreach ($nosotros['ventajas']['items'] as $item): ?>
                        <div class="bg-white rounded-xl p-5 shadow-sm">
                            <div class="w-11 h-11 bg-orange-custom/10 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid <?= $item['icono'] ?> text-orange-custom"></i>
                            </div>
                            <h4 class="font-bold font-poppins text-gray-900 text-sm mb-1"><?= htmlspecialchars($item['titulo']) ?></h4>
                            <p class="text-gray-500 text-xs font-poppins leading-relaxed"><?= htmlspecialchars($item['descripcion']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ******************** 
             HISTORIA (timeline sobre fondo)
         *********************** -->
        <section class="relative w-full py-16 overflow-hidden">

            <img src="<?= $base_url . $nosotros['historia']['background'] ?>" alt="Historia GT Peru Travel"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/70"></div>

            <div class="relative z-10 container-custom mx-auto px-4 md:px-20">

                <div class="text-center mb-12">
                    <p class="section-kicker section-kicker-center text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2"><?= $nosotros['historia']['kicker'] ?></p>
                    <h2 class="text-3xl md:text-4xl font-anton mb-3">
                        <span class="text-white"><?= $nosotros['historia']['title_primary'] ?></span>
                        <span class="text-orange-custom"><?= $nosotros['historia']['title_highlight'] ?></span>
                        <span class="text-white"><?= $nosotros['historia']['title_secondary'] ?></span>
                    </h2>
                    <p class="text-white/70 font-poppins text-sm md:text-base max-w-xl mx-auto"><?= $nosotros['historia']['description'] ?></p>
                </div>

                <div class="max-w-2xl mx-auto space-y-8 relative">
                    <?php
                    $total_hitos = count($nosotros['historia']['hitos']);
                    foreach ($nosotros['historia']['hitos'] as $i => $hito):
                        $esUltimo = $i === $total_hitos - 1;
                    ?>
                        <div class="relative pl-10">
                            <?php if (!$esUltimo): ?>
                                <div class="absolute left-[7px] top-4 bottom-[-2rem] w-[2px] bg-white/20"></div>
                            <?php endif; ?>
                            <span class="absolute left-0 top-1 w-4 h-4 rounded-full <?= $esUltimo ? 'bg-[#34e0a1]' : 'bg-orange-custom' ?>"></span>

                            <div class="bg-white rounded-xl p-5 shadow-lg">
                                <p class="text-orange-custom text-[0.65rem] font-bold font-poppins uppercase tracking-wide mb-1"><?= htmlspecialchars($hito['etiqueta']) ?></p>
                                <h4 class="font-bold font-poppins text-gray-900 mb-2"><?= htmlspecialchars($hito['titulo']) ?></h4>
                                <p class="text-gray-500 text-sm font-poppins leading-relaxed"><?= htmlspecialchars($hito['descripcion']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ******************** 
             MISION / VISION
         *********************** -->
        <section class="bg-white py-16">
            <div class="container-custom mx-auto px-4 md:px-20 text-center">

                <p class="section-kicker section-kicker-center text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2"><?= $nosotros['mision_vision']['kicker'] ?></p>
                <h2 class="text-3xl md:text-4xl font-anton mb-3">
                    <span class="text-gray-900"><?= $nosotros['mision_vision']['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $nosotros['mision_vision']['title_highlight'] ?></span>
                    <span class="text-gray-900"><?= $nosotros['mision_vision']['title_secondary'] ?></span>
                </h2>
                <p class="text-gray-500 font-poppins text-sm md:text-base mb-10 max-w-xl mx-auto"><?= $nosotros['mision_vision']['description'] ?></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto text-left">

                    <div class="bg-white border border-gray-200 rounded-xl p-7">
                        <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid <?= $nosotros['mision_vision']['mision']['icono'] ?> text-gray-700"></i>
                        </div>
                        <h4 class="font-bold font-poppins text-gray-900 mb-2"><?= $nosotros['mision_vision']['mision']['titulo'] ?></h4>
                        <p class="text-gray-500 text-sm font-poppins leading-relaxed"><?= $nosotros['mision_vision']['mision']['descripcion'] ?></p>
                    </div>

                    <div class="bg-white border-2 border-orange-custom rounded-xl p-7">
                        <div class="w-11 h-11 bg-orange-custom/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid <?= $nosotros['mision_vision']['vision']['icono'] ?> text-orange-custom"></i>
                        </div>
                        <h4 class="font-bold font-poppins text-gray-900 mb-2"><?= $nosotros['mision_vision']['vision']['titulo'] ?></h4>
                        <p class="text-gray-500 text-sm font-poppins leading-relaxed"><?= $nosotros['mision_vision']['vision']['descripcion'] ?></p>
                    </div>

                </div>

            </div>
        </section>

        <!-- ******************** 
             ALIANZAS
             (reutiliza tu sección "Nuestras Marcas" / company_brands.json ya armada en el home)
         *********************** -->
        <?php
        $company_json_path = __DIR__ . "/locale/$idioma/company_brands.json";
        $company = file_exists($company_json_path) ? json_decode(file_get_contents($company_json_path), true) : null;
        $our_brands_json_path = __DIR__ . "/locale/$idioma/our_brands.json";
        $our_brands = file_exists($our_brands_json_path) ? json_decode(file_get_contents($our_brands_json_path), true) : null;
        ?>
        <?php
        $alianzas_textos = [
            'es' => ['kicker' => 'Trabajamos juntos', 'titulo_1' => 'Nuestras', 'titulo_2' => 'Alianzas', 'descripcion' => 'Colaboramos con marcas especializadas que comparten nuestros valores de calidad, seguridad y compromiso.'],
            'en' => ['kicker' => 'We work together', 'titulo_1' => 'Our', 'titulo_2' => 'Partners', 'descripcion' => 'We collaborate with specialized brands that share our values of quality, safety and commitment.'],
            'pt' => ['kicker' => 'Trabalhamos juntos', 'titulo_1' => 'Nossas', 'titulo_2' => 'Parcerias', 'descripcion' => 'Colaboramos com marcas especializadas que compartilham nossos valores de qualidade, segurança e compromisso.'],
        ][$idioma] ?? null;
        $alianzas_logos = [
            'palcoyo' => '/images/palcoyo-trekking-logo.png',
            'gt' => '/images/gt-peru-travel-logo-2.svg',
            'sunrise' => '/images/logo-sunriseexperiencecusco.png',
        ];
        $alianzas_links = [
            'palcoyo' => 'https://palcoyotrekking.com/',
            'gt' => 'https://www.gtperutravel.com/',
            'sunrise' => 'https://sunriseexperiencecusco.com/',
        ];
        ?>
        <?php if ($company && $alianzas_textos): ?>
        <section class="relative w-full overflow-hidden py-16 md:py-20">
            <img src="<?= $base_url ?>/images/nosotros/hero.jpg"
                alt="<?= htmlspecialchars($alianzas_textos['titulo_1'] . ' ' . $alianzas_textos['titulo_2']) ?>"
                class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-black/75"></div>

            <div class="relative z-10 container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <div class="mx-auto mb-9 max-w-2xl text-center">
                    <p class="section-kicker section-kicker-center mb-2 font-poppins text-xs font-bold uppercase tracking-[0.14em] text-orange-custom sm:text-sm">
                        <?= htmlspecialchars($alianzas_textos['kicker']) ?>
                    </p>
                    <h2 class="mb-3 font-anton text-3xl leading-tight text-white md:text-4xl">
                        <?= htmlspecialchars($alianzas_textos['titulo_1']) ?>
                        <span class="text-orange-custom"><?= htmlspecialchars($alianzas_textos['titulo_2']) ?></span>
                    </h2>
                    <p class="mx-auto max-w-xl font-poppins text-sm leading-6 text-white/70">
                        <?= htmlspecialchars($alianzas_textos['descripcion']) ?>
                    </p>
                </div>

                <div class="mx-auto grid max-w-5xl grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($company['brands'] as $brand_key => $brand): ?>
                        <a href="<?= htmlspecialchars($alianzas_links[$brand_key]) ?>"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visitar <?= htmlspecialchars($brand['title']) ?>"
                            class="group flex h-full flex-col overflow-hidden rounded-xl border border-white/10 bg-[#242424]/95 shadow-xl transition duration-300 hover:-translate-y-1 hover:border-orange-custom/70 hover:shadow-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-custom focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                            <div class="flex h-36 items-center justify-center bg-white p-6 sm:h-40">
                                <img src="<?= $base_url . ($alianzas_logos[$brand_key] ?? '') ?>"
                                    alt="<?= htmlspecialchars($brand['title']) ?>"
                                    class="max-h-24 max-w-full object-contain transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <div class="flex flex-1 flex-col p-5 text-center">
                                <h3 class="mb-2 font-anton text-lg tracking-wide text-orange-custom">
                                    <?= htmlspecialchars($brand['title']) ?>
                                </h3>
                                <p class="mb-5 flex-1 font-poppins text-xs leading-5 text-white/65">
                                    <?= htmlspecialchars($brand['description']) ?>
                                </p>
                                <div class="border-t border-white/10 pt-4">
                                    <p class="font-poppins text-[0.68rem] text-white/45">
                                        <?= htmlspecialchars($brand['footer']) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ******************** 
             CERTIFICACIONES
         *********************** -->
        <section class="relative w-full py-16 overflow-hidden">

            <img src="<?= $base_url . $nosotros['certificaciones']['background'] ?>" alt="Certificaciones" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/95"></div>

            <div class="relative z-10 container-custom mx-auto px-4 md:px-20 text-center">

                <p class="section-kicker section-kicker-center text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2"><?= $nosotros['certificaciones']['kicker'] ?></p>
                <h2 class="text-3xl md:text-4xl font-anton mb-3">
                    <span class="text-gray-900"><?= $nosotros['certificaciones']['title_primary'] ?></span>
                    <span class="text-orange-custom"><?= $nosotros['certificaciones']['title_secondary'] ?></span>
                </h2>
                <p class="text-gray-500 font-poppins text-sm md:text-base mb-10 max-w-xl mx-auto"><?= $nosotros['certificaciones']['description'] ?></p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                    <?php foreach ($nosotros['certificaciones']['items'] as $c): ?>
                        <div class="bg-white border border-gray-200 rounded-xl p-5">
                            <img src="<?= $base_url . $c['logo'] ?>" alt="<?= htmlspecialchars($c['nombre']) ?>" class="h-20 mx-auto mb-3 object-contain">
                            <p class="font-bold font-poppins text-gray-900 text-xs"><?= htmlspecialchars($c['nombre']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ******************** 
             RECONOCIMIENTOS Y LICENCIAS
             (sección ya armada anteriormente, reutiliza $reconocimientos)
         *********************** -->
        <?php
        $reconocimientos_json_path = __DIR__ . "/locale/$idioma/reconocimientos.json";
        $reconocimientos = file_exists($reconocimientos_json_path) ? json_decode(file_get_contents($reconocimientos_json_path), true) : null;
        ?>
        <?php if ($reconocimientos): ?>
        <section id="reconocimientos" class="relative w-full py-16 md:py-20 overflow-hidden">
            <img src="<?= $base_url . $reconocimientos['background_img'] ?>"
                alt="<?= htmlspecialchars($reconocimientos['title_primary'] . ' ' . $reconocimientos['title_secondary']) ?>"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/45"></div>

            <div class="relative z-10 container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <div class="text-center mb-10 reveal">
                    <p class="section-kicker section-kicker-center text-orange-custom text-sm md:text-base font-bold font-poppins mb-2">
                        <?= htmlspecialchars($reconocimientos['kicker']) ?>
                    </p>
                    <h2 class="text-3xl md:text-5xl font-anton leading-tight">
                        <span class="text-white"><?= htmlspecialchars($reconocimientos['title_primary']) ?></span>
                        <span class="text-orange-custom"><?= htmlspecialchars($reconocimientos['title_secondary']) ?></span>
                    </h2>
                </div>

                <div class="flex flex-wrap justify-center gap-6 md:gap-8 mb-12">
                    <?php foreach ($reconocimientos['certificados'] as $i => $cert): ?>
                        <div class="flex flex-col items-center w-32 sm:w-36 md:w-40 reveal reveal-delay-<?= ($i % 5) + 1 ?>">
                            <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full aspect-[3/4]">
                                <img src="<?= $base_url . $cert['img'] ?>"
                                    alt="<?= htmlspecialchars($cert['label']) ?>"
                                    class="w-full h-full object-cover">
                            </div>
                            <p class="text-orange-custom text-sm md:text-base font-bold font-poppins mt-3 text-center">
                                <?= htmlspecialchars($cert['label']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    <span class="text-white/70 text-sm font-poppins uppercase tracking-wide text-center">
                        <?= htmlspecialchars($reconocimientos['pagos']['texto']) ?>
                    </span>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <?php foreach ($reconocimientos['pagos']['metodos'] as $metodo): ?>
                            <img src="<?= $base_url . $metodo['img'] ?>"
                                alt="<?= htmlspecialchars($metodo['nombre']) ?>"
                                class="h-8 md:h-9 rounded shadow-sm">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php include('footer.php') ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="js/mobile-menu.js"></script>
    <script src="js/mega-menu.js"></script>
    <script src="js/scroll-reveal.js"></script>

</body>
</html>
