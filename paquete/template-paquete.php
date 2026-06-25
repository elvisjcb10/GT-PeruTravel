<!-- VERIFICACIONES DE ERRORES EN PHP -->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!-- VARIABLES DE PROMOCIONES - HEADER .JSON -->
<?php
$promotions_path = __DIR__ . "/../promotions/promotions.json";

if (file_exists($promotions_path)) {
    $promotions = json_decode(file_get_contents($promotions_path), true);
} else {
    $promotions = [];
}
?>

<!-- CARGANDO TOURS-TEMPLATE Y CARDS .JSON -->
<?php
$paquete = $_GET['paquete'] ?? 'peru-premium';
$lang = $_GET['lang'] ?? 'es';

$json_file = __DIR__ . "/../data/paquetes/{$paquete}.{$lang}.json";

if (!file_exists($json_file)) {
    header("Location: /404.php");
    exit;
}

$data = json_decode(file_get_contents($json_file), true);

//<!-- VERIFICACIONES DE SEO TOURS .JSON -->
// Para SEO
$meta_title = $data['seo_title'] ?? $data['title'];
$meta_description = $data['seo_description'] ?? $data['short_description'];
$meta_keywords = $data['seo_keywords'] ?? ''; // puedes agregar un campo opcional en el JSON
?>

<!-- ==========================
     CARGAR TEXTOS GLOBALES
=========================== -->
<?php
$allowed = ['es', 'en', 'pt'];
if (!in_array($lang, $allowed)) $lang = 'es';

$global_path = __DIR__ . "/../lang/global-{$lang}.json";
if (!file_exists($global_path)) {
    $global_path = __DIR__ . "/../lang/global-es.json";
}

$global = json_decode(file_get_contents($global_path), true);
?>



<!-- TEMPLATE PAQUETE -->
<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">

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

    <?php include('../header.php'); ?>

    <!-- contenido paquete o tour -->
    <main>

        <!-- Imagen de paquete o tours -->
        <section id="img-package-tour" class="relative w-full h-[80vh] overflow-hidden">

            <?php
            // Tomar siempre image_cover
            $imageName = $data['image_cover'] ?? '';

            // Ruta relativa
            $imgPath = "images/paquetes/" . $imageName;

            // Ruta absoluta
            $imgFullPath = __DIR__ . '/../' . $imgPath;

            // Si no existe el archivo o está vacío, usar una imagen por defecto
            if (!file_exists($imgFullPath) || empty($imageName)) {
                $imgPath = "images/paquetes/template-image-tour.jpg";
            }
            ?>

            <img src="<?= htmlspecialchars($base_url . '/' . $imgPath) ?>"
                alt="<?= htmlspecialchars($data['title']) ?>"
                class="absolute top-0 left-0 w-full h-full object-cover">

            <!-- Texto centrado -->
            <div class="relative flex flex-col justify-center items-center h-full text-center text-white px-4">
                <h1 class="text-[clamp(2rem,6vw,5rem)] font-extrabold uppercase drop-shadow-lg">
                    <?= htmlspecialchars($data['title']) ?>
                </h1>
                <p class="mt-4 text-[clamp(1rem,2vw,1.5rem)] font-semibold bg-[#ff9300]/80 px-6 py-2 rounded-lg shadow-md">
                    <?= htmlspecialchars($data['duration']) ?>
                </p>
            </div>
        </section>


        <!-- Categorías de paquetes y tours -->
        <section id="category-package-tour" class="w-full bg-[#ff9300] py-4">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-wrap md:flex-nowrap items-center justify-between text-white text-center gap-4 md:gap-6">

                    <!-- Video circular -->
                    <?php
                    $videoUrl = $data['video'] ?? '';  // Si no existe, queda vacío
                    $hasVideo = !empty($videoUrl);     // true si hay video válido
                    ?>

                    <!-- Video circular -->
                    <div class="flex items-center gap-4">

                        <?php if ($hasVideo): ?>
                            <!-- Si hay video -->
                            <a href="<?= $videoUrl ?>" target="_blank"
                                class="flex items-center justify-center w-14 h-14 bg-black/30 rounded-full hover:opacity-80 transition relative">
                                <!-- Icono Play -->
                                <div class="w-0 h-0 border-l-[18px] border-l-black/40 
                        border-t-[10px] border-t-transparent 
                        border-b-[10px] border-b-transparent ml-[6px]"></div>
                            </a>

                        <?php else: ?>
                            <!-- Si NO hay video -->
                            <div class="flex items-center justify-center w-14 h-14 bg-red-500/40 rounded-full">
                                <span class="text-white text-xl font-bold">✕</span>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Línea vertical -->
                    <div class="w-[2px] h-14 bg-black/40"></div>

                    <!-- TOUR -->
                    <div class="category-item cursor-pointer" data-category="tour">
                        <span class="bg-black px-9 py-1 rounded-xl block text-xs tracking-wide">SOLO</span>
                        <h3 class="text-[2rem] font-bold leading-tight text-black">TOUR</h3>
                    </div>

                    <div class="w-[2px] h-14 bg-black/40"></div>

                    <!-- CONFORT -->
                    <div class="category-item cursor-pointer" data-category="confort">
                        <span class="bg-black px-9 py-1 rounded-xl block text-xs tracking-wide">CATEGORÍA</span>
                        <h3 class="text-[2rem] font-bold leading-tight text-black">CONFORT</h3>
                    </div>

                    <div class="w-[2px] h-14 bg-black/40"></div>

                    <!-- PREMIUM -->
                    <div class="category-item cursor-pointer" data-category="premium">
                        <span class="bg-black px-9 py-1 rounded-xl block text-xs tracking-wide">CATEGORÍA</span>
                        <h3 class="text-[2rem] font-bold leading-tight text-black">PREMIUM</h3>
                    </div>

                    <div class="w-[2px] h-14 bg-black/40"></div>

                    <!-- ELITE -->
                    <div class="category-item cursor-pointer" data-category="elite">
                        <span class="bg-black px-9 py-1 rounded-xl block text-xs tracking-wide">CATEGORÍA</span>
                        <h3 class="text-[2rem] font-bold leading-tight text-black">ELITE</h3>
                    </div>

                </div>
            </div>
        </section>

        <!-- documentos de descarga y enlaces -->
        <?php
        $doc_folder = $base_url . "/docs"; // carpeta donde estarán los PDFs
        $brochure_file = $data['brochure'] ?? '';
        ?>
        <section id="items-package-tour">
            <div class="bg-black py-6">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4 text-white text-center">
                        <?php if ($brochure_file): ?>
                            <a href="<?= $doc_folder . '/' . $brochure_file ?>" download
                                class="inline-flex items-center gap-2 bg-[#ff9300] hover:bg-[#ff7e29] text-black font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                                Brochure
                            </a>
                        <?php else: ?>
                            <span class="text-gray-300">Brochure (próximamente)</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="description-package" class="py-12 bg-white relative text-white">
            <div class="container-custom max-w-7xl mx-auto px-6 md:px-12 grid md:grid-cols-2 gap-12">

                <!-- Columna izquierda -->
                <div class="space-y-10">

                    <!-- Título Descripción -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-6 h-6 bg-[#ff9300] rounded-full"></div>
                            <h2 class="text-2xl font-bold text-black"><?= $global['descripcion'] ?></h2>
                        </div>

                        <p id="descripcion" class="text-black leading-relaxed font-[Poppins]" style="word-spacing: -0.5px;">
                            <?= $data['long_description'] ?? 'Descripción no disponible'; ?>
                        </p>
                    </div>

                    <!-- Título Itinerario -->
                    <div class="flex items-center gap-3 mt-12">
                        <div class="w-6 h-6 bg-[#ff9300] rounded-full"></div>
                        <h2 class="text-2xl font-bold text-black"><?= $global['itinerario'] ?></h2>
                    </div>
                    <p class="text-black leading-relaxed font-[Poppins]" style="word-spacing: -0.5px;">
                        <?= $data['short_description'] ?? 'Descripción no disponible'; ?>
                    </p>

                    <!-- Timeline de días -->
                    <ul class="relative border-l-2 border-[#ff9300]/40 ml-4 pl-6 space-y-10">

                        <?php if (!empty($data['days'])): ?>

                            <!-- Mostrar los primeros 3 días siempre -->
                            <?php foreach ($data['days'] as $index => $day): ?>
                                <?php if ($index < 1): ?>
                                    <li class="relative">
                                        <div class="absolute -left-[33px] top-1 w-4 h-4 bg-[#ff9300] rounded-full flex items-center justify-center text-[10px] font-bold">
                                            <?= $index + 1 ?>
                                        </div>
                                        <h3 class="text-black"><?= htmlspecialchars($day['title']) ?></h3><br>
                                        <p class="text-black leading-relaxed font-[Poppins]" style="word-spacing: -0.5px;"><?= $day['text'] ?></p>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- Contenedor único para TODOS los días "extras" (4,5,6...) -->
                            <div id="dias-extra" class="hidden">
                                <?php foreach ($data['days'] as $index => $day): ?>
                                    <?php if ($index >= 1): ?>
                                        <li class="relative">
                                            <div class="absolute -left-[33px] top-1 w-4 h-4 bg-[#ff9300] rounded-full flex items-center justify-center text-[10px] font-bold">
                                                <?= $index + 1 ?>
                                            </div>
                                            <h3 class="text-black"><?= htmlspecialchars($day['title']) ?></h3><br>
                                            <p class="text-black leading-relaxed font-[Poppins]" style="word-spacing: -0.5px;"><?= $day['text'] ?></p><br>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                        <?php else: ?>
                            <li>No hay información de itinerario disponible.</li>
                        <?php endif; ?>

                    </ul>


                    <!-- Botón para mostrar más -->
                    <?php if (count($data['days']) > 1): ?>
                        <div class="text-center mt-6">
                            <button
                                id="verMasBtn"
                                class="bg-[#ff9300] px-6 py-2 rounded-lg font-semibold text-black hover:bg-[#ff7e29] transition-all">
                                <?= $global['ver_mas_dias'] ?>
                            </button>
                        </div>
                    <?php endif; ?>



                    <!-- Ficha Tecnica -->
                    <div class="flex items-center gap-3 mt-12">
                        <div class="w-6 h-6 bg-[#ff9300] rounded-full"></div>
                        <h2 class="text-black text-2xl font-bold"><?= $global['ficha_tecnica'] ?></h2>
                    </div>
                    <p class="text-black leading-relaxed font-[Poppins]">
                        <?= $data['technical_sheet'] ?? 'Descripción no disponible'; ?>
                    </p>

                    <!-- INCLUYE Y NO INCLUYE -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-12">

                        <!-- INCLUYE -->
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-[#ff9300] rounded-full"></div>
                                <h2 class="text-black text-2xl font-bold"><?= $global['incluye'] ?></h2>
                            </div>
                            <p class="text-black leading-relaxed font-[Poppins] mt-3">
                                <?= $data['includes'] ?? 'Descripción no disponible'; ?>
                            </p>
                        </div>

                        <!-- NO INCLUYE -->
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-[#ff9300] rounded-full"></div>
                                <h2 class="text-black text-2xl font-bold"><?= $global['no_incluye'] ?></h2>
                            </div>
                            <p class="text-black leading-relaxed font-[Poppins] mt-3">
                                <?= $data['not_includes'] ?? 'Descripción no disponible'; ?>
                            </p>
                        </div>

                    </div>


                </div>


                <!-- Columna derecha (sidebar) -->
                <aside class="space-y-8">
                    <!-- Bloque precio -->
                    <div class="bg-gray-50 text-center text-gray-800 rounded-2xl shadow-lg overflow-hidden py-2">

                        <!-- Encabezado negro -->
                        <div class="bg-black py-4 px-6">
                            <h2 id="titulo-paquete" class="text-2xl font-extrabold text-white tracking-wide">
                                <span id="titulo-text"><?= $data['title'] ?? 'Descripción no disponible'; ?></span>
                                <!-- 
                                Etiqueta de categoría "(SOLO)" desactivada.
                                Motivo: generaba confusión en clientes y equipo de ventas.
                                Decisión: se retira del frontend para simplificar el mensaje.
                                Estado: desactivado temporalmente, pendiente de optimización UX.-->
                                <!-- <span id="categoria-titulo" class="ml-2 text-[#ff6600]">(SOLO)</span> -->
                                <span id="dias-paquete" class="text-[#ff9300] ml-2"><?= $data['duration'] ?? 'Descripción no disponible'; ?></span>
                            </h2>
                        </div>

                        <!-- Contenido principal -->
                        <div class="p-6">
                            <p class="text-[#ff9300] text-sm font-semibold mb-1 uppercase text-left"><?= $global['desde'] ?></p>

                            <!-- PRECIO de tour -->
                            <div class="flex flex-col items-center justify-center">
                                <h3 id="precio" class="text-5xl font-extrabold text-[#ff9300] leading-none">$<?= $data['price'] ?? 'Descripción no disponible'; ?></h3>
                            </div>

                            <!-- DESCUENTO (solo si existe y es > 0) -->
                            <div class="flex flex-col items-center justify-center">
                                <h3 id="precio" class="text-5xl font-extrabold text-[#ff9300] leading-none"></h3>

                                <!-- DESCUENTO -->
                                <span id="descuentoTag"
                                    class="hidden mt-2 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full">
                                </span>
                            </div>


                            <!-- DESCRIPCION de tour -->
                            <p id="nota-precio" class="text-gray-600 text-[0.7rem] font-[Poppins] leading-relaxed mt-4">
                                <?= $data['price_note'] ?? 'Descripción no disponible'; ?>
                            </p>

                            <!-- CONTADOR DE PERSONAS -->
                            <div class="flex items-center justify-center gap-4 mt-6">
                                <!-- ICONO DE PERSONAS -->
                                <img src="<?= $base_url ?>/images/cantidad-personas.svg"
                                    alt="Personas"
                                    class="w-8 h-8 select-none">

                                <!-- BOTÓN - -->
                                <button
                                    id="btnMenos"
                                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-white rounded-full text-xl font-bold hover:bg-gray-700 transition">
                                    -
                                </button>

                                <!-- CONTADOR -->
                                <span id="contadorPasajeros" class="text-2xl font-bold text-gray-900">1</span>

                                <!-- BOTÓN + -->
                                <button
                                    id="btnMas"
                                    class="w-8 h-8 flex items-center justify-center bg-gray-800 text-white rounded-full text-xl font-bold hover:bg-gray-700 transition">
                                    +
                                </button>
                            </div>

                        </div>
                    </div>


                    <!-- Formulario -->
                    <?php
                    $tipo_formulario = "paquete";  // dinámico según el template
                    include __DIR__ . "/../includes/template-formulario.php";
                    ?>


                </aside>


            </div>


            <div class="max-w-7xl mx-auto px-6 md:px-12 mt-12">
                <!-- Mapa -->
                <?php
                $mapa = !empty($data['map'])
                    ? $data['map']
                    : 'mapa-paquete-peru-maravilloso-7d-6n-es.jpg';
                ?>

                <div class="overflow-hidden rounded-xl shadow bg-black">
                    <img
                        src="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>"
                        alt="Mapa del tour <?= htmlspecialchars($data['title'] ?? '') ?>"
                        class="w-full h-[200px] sm:h-[220px] md:h-[420px] lg:h-[520px] object-contain md:object-cover"
                        loading="lazy">
                </div>

                <!-- TEXTO CURIOSIDAD (SOLO MÓVIL) -->
                <div class="text-center mt-3">
                    <a
                        href="<?= $base_url ?>/images/mapas/<?= htmlspecialchars($mapa) ?>"
                        target="_blank"
                        class="text-[#ff9300] font-semibold text-sm hover:underline">
                        <?= $global['ver_mapa'] ?>
                    </a>
                </div>
            </div>




        </section>

    </main>
    <!-- fin contenido paquete -->

    <!-- PARA INCLUIR EL FOOTER -->
    <?php
    // idioma
    $idioma = $_GET['lang'] ?? 'es';

    // archivo footer JSON (corrección: subir un nivel)
    $footer_json = __DIR__ . "/../locale/$idioma/footer.json";

    // comprobar y cargar
    if (file_exists($footer_json)) {
        $footer = json_decode(file_get_contents($footer_json), true);
    } else {
        $footer = [];
    }
    ?>
    <!-- FIN PARA INCLUIR EL FOOTER -->


    <?php include('../footer.php'); ?>

    <!-- // scrips // -->

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Mobile menu -->
    <script src="../js/mobile-menu.js"></script>

    <!-- Swiper Trip Comments -->
    <script src="../js/swiper-trip-comments.js"></script>

    <!-- Swiper tours -->
    <script src="../js/swiper-tours.js"></script>

    <!-- ver mas texto-contenido JS -->
    <script src="../js/see-more-text.js"></script>

    <!-- cambio-categoria JS -->
    <script src="../js/change-category.js"></script>

    <!-- cambio-categoria JS -->
    <script src="../js/change-category-text-price.js"></script>


    <!-- ------------------------
    pasando categorias a script   
    ----------------------------- -->
    <script>
        const categorias = <?= json_encode($data['categories']); ?>;
    </script>

    <!-- Cargando de .json -->
    <script>
        const categoriaActual = "tour"; // ← esta variable luego será dinámica

        fetch("/data/categorias.json")
            .then(response => response.json())
            .then(json => {
                const item = json[categoriaActual];

                if (!item) return;

                // Actualizar HTML
                document.getElementById("precio").textContent = "$" + item.precio;
                document.getElementById("nota-precio").textContent = item.nota;
                // Si después agregas más campos, se actualizan aquí
            })
            .catch(err => console.error("Error cargando JSON:", err));
    </script>

    <!-- -----------------------
        + o - de pasajeros  
    ---------------------------- -->
    <script>
        let pasajeros = 1;

        const btnMas = document.getElementById('btnMas');
        const btnMenos = document.getElementById('btnMenos');
        const contador = document.getElementById('contadorPasajeros');
        const precioElemento = document.getElementById('precio');

        // Tomamos el precio base desde PHP (limpiando el $)
        let precioBase = parseFloat("<?= str_replace('$', '', $data['price']); ?>");

        btnMas.addEventListener('click', () => {
            pasajeros++;
            actualizarPrecio();
        });

        btnMenos.addEventListener('click', () => {
            if (pasajeros > 1) {
                pasajeros--;
                actualizarPrecio();
            }
        });

        function actualizarPrecio() {
            contador.textContent = pasajeros;

            let total = precioBase * pasajeros;

            // Mostrar con dos decimales si quieres
            precioElemento.textContent = "$" + total.toFixed(2);
        }
    </script>


    <!-- --------------------------- 
           cargar categorias data 
     -------------------------- -->
    <script>
        const categoriasData = <?= json_encode($data['categories'], JSON_UNESCAPED_UNICODE) ?>;
    </script>


    <!-- -------------------------------------------------- 
    Manejo de Categoría (visual + actualizar hidden/select) BLOQUE
     ------------------------------------------------------- -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const categoryItems = document.querySelectorAll(".category-item");
            const categoriaTituloSpan = document.getElementById("categoria-titulo");
            const selectServicio = document.getElementById("selectServicio");
            const inputCategoria = document.getElementById("inputCategoria");

            const nombresCategorias = {
                tour: "(SOLO)",
                confort: "(CONFORT)",
                premium: "(PREMIUM)",
                elite: "(ELITE)"
            };

            categoryItems.forEach(item => {
                item.addEventListener("click", () => {
                    const categoria = item.dataset.category;

                    // Activar visual
                    categoryItems.forEach(i => i.classList.remove("text-[#ff6600]", "scale-105"));
                    item.classList.add("text-[#ff6600]", "scale-105");

                    // Actualizar UI
                    if (categoriaTituloSpan) categoriaTituloSpan.textContent = nombresCategorias[categoria] || categoria;
                    if (selectServicio) selectServicio.value = categoria;
                    if (inputCategoria) inputCategoria.value = categoria;

                    // Avisar al bloque C : “la categoría cambió”
                    document.dispatchEvent(new CustomEvent("categoriaCambiada", {
                        detail: categoria
                    }));
                });
            });
        });
    </script>

    <!-- -------------------------------------------------- 
    Contador de pasajeros BLOQUE
     ------------------------------------------------------- -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const contadorEl = document.getElementById("contadorPasajeros");
            const btnMas = document.getElementById("btnMas");
            const btnMenos = document.getElementById("btnMenos");

            let pasajeros = parseInt(contadorEl.textContent) || 1;

            btnMas.addEventListener("click", () => {
                pasajeros++;
                contadorEl.textContent = pasajeros;

                // Avisar al bloque C
                document.dispatchEvent(new CustomEvent("pasajerosCambiaron", {
                    detail: pasajeros
                }));
            });

            btnMenos.addEventListener("click", () => {
                if (pasajeros > 1) {
                    pasajeros--;
                    contadorEl.textContent = pasajeros;

                    // Avisar al bloque C
                    document.dispatchEvent(new CustomEvent("pasajerosCambiaron", {
                        detail: pasajeros
                    }));
                }
            });
        });
    </script>

    <!-- -------------------------------------------------- 
    Cálculo de precio BLOQUE
     ------------------------------------------------------- -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const precioEl = document.getElementById("precio");
            const notaEl = document.getElementById("nota-precio");
            const descuentoTag = document.getElementById("descuentoTag");

            let categoria = "tour";
            let pasajeros = 1;

            if (typeof categoriasData === "undefined") {
                console.error("categoriasData no existe");
                return;
            }

            function parsePrecio(v) {
                if (!v) return 0;
                return parseFloat(String(v).replace(/[^0-9.]/g, "")) || 0;
            }

            function actualizarPrecio() {
                let cat = categoriasData[categoria];
                if (!cat) return;

                const base = parsePrecio(cat.precio ?? cat.precio_base ?? 0);
                const desc = parseFloat(cat.descuento ?? 0);
                const precioFinal = base * (1 - desc / 100) * pasajeros;

                precioEl.textContent = "$" + precioFinal.toFixed(2);
                notaEl.textContent = cat.nota ?? "";

                // Mostrar descuento si es mayor a 0
                if (desc > 0) {
                    descuentoTag.textContent = `-${desc}%`;
                    descuentoTag.classList.remove("hidden");
                } else {
                    descuentoTag.classList.add("hidden");
                }
            }

            // Escuchar cambios desde A y B
            document.addEventListener("categoriaCambiada", e => {
                categoria = e.detail;
                actualizarPrecio();
            });

            document.addEventListener("pasajerosCambiaron", e => {
                pasajeros = e.detail;
                actualizarPrecio();
            });

            // Primera carga
            actualizarPrecio();
        });
    </script>



</body>

</html>