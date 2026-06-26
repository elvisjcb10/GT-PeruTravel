<?php
// para cargar promociones
$idioma = $_GET['lang'] ?? 'es'; // lenguaje actual

$json = file_get_contents(__DIR__ . "/promotions/promotions.json");
$promotions = json_decode($json, true)['promotions'];
?>


<!-- SECTION VIDOE .JSON -->
<?php
$video_json = file_get_contents(__DIR__ . "/locale/$idioma/video.json");
$video_text = json_decode($video_json, true);
?>

<!-- SECTION ABOUT .JSON -->
<?php
$about_file = __DIR__ . "/locale/$idioma/about.json";
$about_json = file_get_contents($about_file);
$about_text = json_decode($about_json, true);
?>

<!-- SECTION TRIPADVISOR .JSON -->
<?php
$trip_file = __DIR__ . "/locale/$idioma/tripadvisor.json";
$trip_json = file_get_contents($trip_file);
$trip_text = json_decode($trip_json, true);
?>

<!-- SECTION POPULAR PACKAGES TEXT .JSON -->
<?php
$popular_json = file_get_contents(__DIR__ . "/locale/$idioma/popular_packages_text.json");
$popular_text = json_decode($popular_json, true);
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
$slug = 'machupicchu';

$data_json = file_get_contents(__DIR__ . "/data/tours/{$slug}.{$idioma}.json");
$data = json_decode($data_json, true);
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GT Peru Travel | Tours a Machu Picchu, Cusco y Experiencias Únicas en Perú</title>
    <meta name="description" content="Descubre los mejores tours en Cusco y Machu Picchu con GT Peru Travel. Experiencias auténticas, guías expertos y aventuras inolvidables en los Andes. Reserva ahora.">
    <meta name="keywords" content="tours a Machu Picchu, turismo en Cusco, viajes a Perú, paquetes turísticos, GT Peru Travel">

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

</head>

<body>

    <?php include('header.php') ?>

    <?php include('home.php') ?>

    <?php include('footer.php') ?>


    <!-- // scrips // -->

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Mobile menu -->
    <script src="js/mobile-menu.js"></script>
    <script src="js/mega-menu.js"></script> 

    <!-- Swiper Trip Comments -->
    <script src="js/swiper-trip-comments.js"></script>

    <!-- Swiper tours -->
    <script src="js/swiper-tours.js"></script>

    <!-- Swiper tours -->
    <script src="js/swiper-popular-packages.js"></script>

    <script>
        document.querySelectorAll(".card-slider").forEach(slider => {

            const images = slider.querySelectorAll("img");
            let index = 0;

            setInterval(() => {

                images[index].classList.remove("opacity-100");
                images[index].classList.add("opacity-0");

                index = (index + 1) % images.length;

                images[index].classList.remove("opacity-0");
                images[index].classList.add("opacity-100");

            }, 2500);

        });
    </script>


</body>

</html>