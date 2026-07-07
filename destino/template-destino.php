<?php
// ¿Qué destino se pidió?
$idioma = $_GET['lang'] ?? 'es';
$destino_slug = $_GET['destino'] ?? null;

if (!$destino_slug) {
    die("Destino no especificado");
}

// Cargar info general del destino (nombre, descripción, imagen de portada)
$destinos_json = file_get_contents(__DIR__ . "/../locale/$idioma/destinos.json");
$destinos = json_decode($destinos_json, true);

if (!isset($destinos[$destino_slug])) {
    die("Destino no encontrado");
}

$destino_actual = $destinos[$destino_slug];

// Cargar los tours que pertenecen a ESTE destino específico
$tours_destino_file = __DIR__ . "/../data/tours-por-destino/{$destino_slug}.{$idioma}.json";

if (!file_exists($tours_destino_file)) {
    die("No hay tours disponibles para este destino todavía");
}

$tours_destino_json = file_get_contents($tours_destino_file);
$tours_destino = json_decode($tours_destino_json, true)['tours'];
// ⬇️ AGREGAR ESTO: cargar el footer, igual que en index.php
$footer_json = file_get_contents(__DIR__ . "/../locale/$idioma/footer.json");
$footer = json_decode($footer_json, true);
$base_url = "..";
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $destino_actual['nombre'] ?> - Tours | GT Peru Travel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

+

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


    <!-- favicon -->
    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">

    <!-- WhatsApp icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- font awesome -->
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

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts POPPINS - 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- COMPILADO PARA CARGAR VANDERAS PARA TELEFONO -->
    <!-- INICIALIZACION DEL IMPUT DE TELEFONO -->
    <!-- TELEFONO INTERNACIONAL -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/css/intlTelInput.min.css" />
    <!-- END CARGAR VANDERAS PARA TELEFONO -->

    <!-- swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>

    <?php include(__DIR__ . '/../header.php') ?>

    <!-- HERO DEL DESTINO -->
    <section class="relative w-full h-[50vh] min-h-[400px]">
        <img src="<?= $base_url . $destino_actual['img'] ?>"
             alt="<?= $destino_actual['nombre'] ?>"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 h-full flex items-center justify-center text-center px-4">
            <div>
                <h1 class="text-white text-4xl md:text-6xl font-anton"><?= $destino_actual['nombre'] ?></h1>
                <p class="text-white/85 font-poppins mt-3"><?= $destino_actual['descripcion'] ?></p>
            </div>
        </div>
    </section>

    <!-- GRID DE TOURS DE ESTE DESTINO -->
    <section class="container-custom mx-auto px-4 py-14">
        <h2 class="text-3xl font-anton mb-8">Tours en <?= $destino_actual['nombre'] ?></h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($tours_destino as $t): ?>
                <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $t['url'] ?>&lang=<?= $idioma ?>"
                   class="block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                    <img src="<?= $base_url ?>/images/<?= $t['image'] ?>" class="w-full h-52 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold font-poppins"><?= $t['title'] ?></h3>
                        <p class="text-gray-500 text-sm mt-1"><?= $t['description'] ?></p>
                        <span class="text-orange-custom font-bold text-xl mt-2 block">$<?= $t['price'] ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

     <?php include(__DIR__ . '/../footer.php') ?>

</body>
</html>