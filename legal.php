<?php require_once __DIR__ . '/config/bootstrap.php'; ?>
<!-- PLANTILLA COPIADA DEL INDEX PARA FUNCIONAR EN LEGAL
tener en cuenta cuando se agregue a index algo 
tambien agregar aca. 
-->


<!-- solo para legal.php estos datos  -->
<?php
// 1. Idioma actual
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$GLOBALS['lang'] = $idioma;

// 2. Documento solicitado
$doc = $_GET['doc'] ?? 'quienes-somos';

// Normalizamos: guiones → guiones bajos
$doc = str_replace('-', '_', $doc);

// 3. Cargar archivo JSON legal del idioma
$legal_file = __DIR__ . "/lang/legal-$idioma.json";

if (!file_exists($legal_file)) {
    die("Archivo legal-$idioma.json no encontrado");
}

$legal_json = json_decode(file_get_contents($legal_file), true);

// 4. Verificar que exista la sección dentro del JSON
if (!isset($legal_json[$doc])) {
    http_response_code(404); require __DIR__ . '/404.php'; exit;
}

$page = $legal_json[$doc];
if (PHP_SAPI !== 'cli' && str_ends_with((string)(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? ''), '.php')) { header('Location: ' . route_legal_path($doc, $idioma), true, 301); exit; }
?>

<!-- end solo para legal.php estos datos  -->

<?php
// para cargar promociones
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$GLOBALS['lang'] = $idioma; // lenguaje actual

$json = file_get_contents(__DIR__ . "/promotions/promotions.json");
$promotions = json_decode($json, true)['promotions'];
?>


<!-- SECTION VIDOE .JSON -->
<?php
$video_json = file_get_contents(__DIR__ . "/locale/$idioma/video.json");
$video_text = json_decode($video_json, true);
?>

<!-- SECTION TRIPADVISOR .JSON -->
<?php
$trip_file = __DIR__ . "/locale/$idioma/tripadvisor.json";
$trip_json = file_get_contents($trip_file);
$trip_text = json_decode($trip_json, true);
?>

<!-- SECTION PAQUETES .JSON -->
<?php
$packages_json = file_get_contents(__DIR__ . "/locale/$idioma/packages.json");
$packages_text = json_decode($packages_json, true);
?>

<!-- SECTION PAQUETES_TARJETAS .JSON -->
<?php
$cards_json = file_get_contents(__DIR__ . "/locale/$idioma/packages_cards.json");
$cards_all = json_decode($cards_json, true);
$cards = $cards_all["cards"];
?>

<!-- SECTION TITULO TOURS .JSON -->
<?php
$tours_json = file_get_contents(__DIR__ . "/locale/$idioma/tours_title.json");
$tours_text = json_decode($tours_json, true);
?>

<!-- SECTION TOURS .JSON -->
<?php
$tours_json = file_get_contents(__DIR__ . "/locale/$idioma/tours.json");
$tours_all = json_decode($tours_json, true);
$tours = $tours_all["cards"];
?>

<!-- SECTION MAS TOURS .JSON -->
<?php
$more_tours_json = file_get_contents(__DIR__ . "/locale/$idioma/more_tours.json");
$more_tours = json_decode($more_tours_json, true);
?>

<!-- SECTION NUEVOS DESTINOS .JSON -->
<?php
$new_dest_json = file_get_contents(__DIR__ . "/locale/$idioma/new_destinations.json");
$new_dest = json_decode($new_dest_json, true);
?>

<!-- SECTION TOURS MISTICOS .JSON -->
<?php
$mystic_json = file_get_contents(__DIR__ . "/locale/$idioma/mystic_tours.json");
$mystic = json_decode($mystic_json, true);
?>

<!-- SECTION DESCUENTO DE TEMPORADA .JSON -->
<?php
$season_json = file_get_contents(__DIR__ . "/locale/$idioma/season_discount.json");
$season = json_decode($season_json, true);
?>

<!-- SECTION NUESTRAS MARCAS .JSON -->
<?php
$our_brands_json = file_get_contents(__DIR__ . "/locale/$idioma/our_brands.json");
$our_brands = json_decode($our_brands_json, true);
?>

<!-- SECTION COMPANY .JSON -->
<?php
$company_json = file_get_contents(__DIR__ . "/locale/$idioma/company_brands.json");
$company = json_decode($company_json, true);
?>

<!-- SECTION INFO SUPPORT .JSON -->
<?php
$info_support_json = file_get_contents(__DIR__ . "/locale/$idioma/info_support.json");
$info_support = json_decode($info_support_json, true);
?>

<!-- SECTION FOOTER .JSON -->
<?php
$footer_json = file_get_contents(__DIR__ . "/locale/$idioma/footer.json");
$footer = json_decode($footer_json, true);
?>

<!-- TOURS IDIOMA PLANTILLA -->
<?php
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$GLOBALS['lang'] = $idioma;
$slug = 'machupicchu';

$data_json = file_get_contents(__DIR__ . "/data/tours/{$slug}.{$idioma}.json");
$data = json_decode($data_json, true);
?>



<!DOCTYPE html>
<html lang="<?= htmlspecialchars($idioma) ?>">

<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?php echo $page['title']; ?> | GT Peru Travel</title>
    <meta name="description" content="<?php echo $page['desc']; ?>">
    <?php seo_render([
        'title' => (string)$page['title'] . ' | GT Peru Travel', 'description' => (string)$page['desc'],
        'path' => route_legal_path($doc, $idioma), 'params' => [], 'language' => $idioma,
        'alternates' => route_legal_alternates($doc),
    ]); ?>
    <meta name="keywords" content="<?php echo $page['keywords']; ?>">

    <!-- Google tag (gtag.js) -->



    <!-- faviicon -->
    <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">

    <!-- Whatssap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- icon from menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS (CDN) -->
    

    <!-- google fonts ANTON - 1 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <!-- google fonts ROBOTO - 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- COMPILADO PARA CARGAR VANDERAS PARA TELEFONO -->
    <!-- INICIALIZACION DEL IMPUT DE TELEFONO -->

    <!-- END CARGAR VANDERAS PARA TELEFONO -->

    <!-- swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


</head>

<body>

    <?php include('header.php') ?>

    <!-- codigo para legal -->
    <main class="max-w-4xl mx-auto px-4 py-12">

        <!-- ========== TÍTULO ========== -->
        <?php if (!empty($page['title'])): ?>
            <h1 class="text-4xl font-bold mb-6">
                <?= $page['title']; ?>
            </h1>
        <?php endif; ?>


        <!-- ========== INTRO (PÁRRAFO CORTO) ========== -->
        <?php if (!empty($page['intro'])): ?>
            <p class="text-lg font-poppins text-gray-700 mb-8">
                <?= $page['intro']; ?>
            </p>
        <?php endif; ?>


        <!-- ========== CONTENIDO PRINCIPAL (HTML) ========== -->
        <?php if (!empty($page['content'])): ?>
            <div class="prose font-poppins max-w-none mb-12">
                <?= $page['content']; ?>
            </div>
        <?php endif; ?>


        <!-- ========== GALERÍA ========== -->
        <?php if (!empty($page['galeria'])): ?>
            <div class="mt-10 mb-12">
                <h2 class="text-2xl font-bold mb-4">Galería</h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php foreach ($page['galeria'] as $img): ?>
                        <img src="<?= $img; ?>" class="rounded-lg shadow">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <!-- ========== BLOQUE DE CERTIFICACIONES ========== -->
        <?php if (!empty($page['certificaciones'])): ?>
            <section class="mb-14">
                <h2 class="text-2xl font-poppins font-bold mb-4">Certificaciones</h2>

                <ul class="space-y-4">
                    <?php foreach ($page['certificaciones'] as $item): ?>
                        <li class="flex items-center gap-4 p-4 border rounded-xl bg-gray-50 shadow-sm">
                            <?php if (!empty($item['img'])): ?>
                                <!-- Link que abre la imagen en nueva pestaña -->
                                <a href="<?= $item['img']; ?>" target="_blank">
                                    <img src="<?= $item['img']; ?>" class="w-16 h-16 object-contain cursor-pointer">
                                </a>
                            <?php endif; ?>

                            <div>
                                <p class="font-bold font-poppins"><?= $item['titulo']; ?></p>
                                <p class="text-sm text-gray-600 font-poppins"><?= $item['desc']; ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>


            </section>
        <?php endif; ?>


        <!-- ========== PREGUNTAS FRECUENTES (FAQ) ========== -->
        <?php if (!empty($page['faq'])): ?>
            <section class="mb-14">
                <h2 class="text-2xl font-poppins font-bold mb-8">Preguntas frecuentes</h2>

                <div class="space-y-4">
                    <?php foreach ($page['faq'] as $faq): ?>
                        <details class="p-4 border rounded-xl bg-gray-50 shadow-sm">
                            <summary class="cursor-pointer font-semibold font-poppins">
                                <?= $faq['pregunta']; ?>
                            </summary>
                            <p class="mt-2 text-gray-700 font-poppins"><?= $faq['respuesta']; ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>


        <!-- ========== FORMULARIO SOLO PARA CONTACTO ========== -->
        <?php if ($doc === 'contacto'): ?>
            <section class="mt-12">
                <?php
                $tipo_formulario = "contacto";
                include __DIR__ . "/includes/template-formulario.php";
                ?>
            </section>
        <?php endif; ?>


        <!-- ========== BLOQUE DE CONTACTO ========== -->
        <?php if (!empty($page['contacto'])): ?>
            <section class="mt-12 p-6 bg-gray-100 rounded-xl shadow">

                <h2 class="text-2xl font-bold mb-6 font-poppins">Información de contacto</h2>

                <div class="space-y-3">

                    <?php if (!empty($page['contacto']['telefono'])): ?>
                        <p><b>📞 Teléfono:</b><span class="font-[Roboto] leading-relaxe"> <?= $page['contacto']['telefono']; ?></span></p>
                    <?php endif; ?>

                    <?php if (!empty($page['contacto']['email'])): ?>
                        <p><b>📧 Email:</b><span class="font-[Roboto] leading-relaxe"> <?= $page['contacto']['email']; ?></span></p>
                    <?php endif; ?>

                    <?php if (!empty($page['contacto']['direccion'])): ?>
                        <p><b>📍 Dirección:</b><span class="font-[Roboto] leading-relaxe"> <?= $page['contacto']['direccion']; ?></span></p>
                    <?php endif; ?>

                    <?php if (!empty($page['contacto']['horarios'])): ?>
                        <p><b>⏰ Horarios:</b><span class="font-[Roboto] leading-relaxe"> <?= $page['contacto']['horarios']; ?></span></p>
                    <?php endif; ?>

                </div>

                <?php if (!empty($page['contacto']['mapa'])): ?>
                    <div class="mt-6">
                        <iframe
                            src="<?= $page['contacto']['mapa']; ?>"
                            class="w-full h-80 rounded-xl shadow">
                        </iframe>
                    </div>
                <?php endif; ?>

            </section>

        <?php endif; ?>


    </main>


    <?php include('footer.php') ?>


    <!-- // scrips // -->

    <!-- Swiper JS -->
    

    <!-- Mobile menu -->
    <script src="js/mobile-menu.js"></script>

    <!-- Swiper Trip Comments -->
    <script src="js/swiper-trip-comments.js"></script>

    <!-- Swiper tours -->
    <script src="js/swiper-tours.js"></script>


</body>

</html>