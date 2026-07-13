<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$idioma = $_GET['lang'] ?? 'es';
$allowed = ['es', 'en', 'pt'];
if (!in_array($idioma, $allowed)) {
    $idioma = 'es';
}

$base_url = ".";

$contacto_json = file_get_contents(__DIR__ . "/locale/$idioma/contacto.json");
$contacto = json_decode($contacto_json, true);

$footer_json = __DIR__ . "/locale/$idioma/footer.json";
$footer = file_exists($footer_json) ? json_decode(file_get_contents($footer_json), true) : [];
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos | GT Peru Travel</title>
    <meta name="description" content="Contáctanos y planifica tu próxima aventura por el Perú con GT Peru Travel.">
    <meta name="keywords" content="contacto, nosotros, about, email, correo, contact, tours a Machu Picchu, turismo en Cusco, viajes a Perú, paquetes turísticos, GT Peru Travel">

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
             HERO CONTACTO
         *********************** -->
        <section class="relative w-full h-[75vh] min-h-[550px] bg-black overflow-hidden">

            <img src="<?= $base_url . $contacto['hero']['background'] ?>"
                 alt="<?= htmlspecialchars($contacto['hero']['title_primary'] . ' ' . $contacto['hero']['title_secondary']) ?>"
                 class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>

            <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4">

                <span class="inline-block bg-orange-custom/20 border border-orange-custom text-orange-custom text-xs font-bold font-poppins uppercase tracking-wide px-4 py-1.5 rounded-full mb-4">
                    <?= $contacto['hero']['kicker'] ?>
                </span>

                <h1 class="text-white text-4xl sm:text-5xl md:text-6xl font-anton leading-tight max-w-3xl">
                    <?= htmlspecialchars($contacto['hero']['title_primary']) ?><br>
                    <span class="text-orange-custom"><?= htmlspecialchars($contacto['hero']['title_secondary']) ?></span>
                </h1>

                <p class="mt-5 text-white/90 text-base md:text-lg font-poppins font-light max-w-xl">
                    <?= htmlspecialchars($contacto['hero']['description']) ?>
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <?php foreach ($contacto['hero']['badges'] as $badge): ?>
                        <span class="bg-white/95 text-gray-800 text-sm font-poppins font-semibold px-5 py-2.5 rounded-full shadow-md">
                            <?= htmlspecialchars($badge) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>

        <!-- ******************** 
             FORMULARIO + INFO DE CONTACTO
         *********************** -->
        <section class="bg-white py-14">
            <div class="container-custom mx-auto px-4 md:px-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    <!-- COLUMNA IZQUIERDA: FORMULARIO -->
                    <div>
                        <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                            <?= $contacto['formulario']['kicker'] ?>
                        </p>

                        <h2 class="text-3xl md:text-4xl font-anton mb-3 leading-tight">
                            <span class="text-gray-900"><?= htmlspecialchars($contacto['formulario']['title_primary']) ?></span>
                            <span class="text-orange-custom"><?= htmlspecialchars($contacto['formulario']['title_secondary']) ?></span>
                        </h2>

                        <p class="text-gray-500 font-poppins text-sm mb-8">
                            <?= htmlspecialchars($contacto['formulario']['description']) ?>
                        </p>

                        <form id="form-contacto" class="space-y-5">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['nombre']['label'] ?>
                                    </label>
                                    <input type="text" name="nombre" required
                                           placeholder="<?= $contacto['formulario']['campos']['nombre']['placeholder'] ?>"
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['apellido']['label'] ?>
                                    </label>
                                    <input type="text" name="apellido" required
                                           placeholder="<?= $contacto['formulario']['campos']['apellido']['placeholder'] ?>"
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['whatsapp']['label'] ?>
                                    </label>
                                    <input type="tel" name="whatsapp" required
                                           placeholder="<?= $contacto['formulario']['campos']['whatsapp']['placeholder'] ?>"
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['email']['label'] ?>
                                    </label>
                                    <input type="email" name="email" required
                                           placeholder="<?= $contacto['formulario']['campos']['email']['placeholder'] ?>"
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['fecha']['label'] ?>
                                    </label>
                                    <input type="date" name="fecha_viaje"
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                        <?= $contacto['formulario']['campos']['personas']['label'] ?>
                                    </label>
                                    <select name="personas"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition text-gray-500">
                                        <option value="">Seleccionar</option>
                                        <option value="1">1 persona</option>
                                        <option value="2">2 personas</option>
                                        <option value="3-5">3 a 5 personas</option>
                                        <option value="6+">6 o más personas</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold font-poppins uppercase tracking-wide text-gray-700 mb-2">
                                    <?= $contacto['formulario']['campos']['mensaje']['label'] ?>
                                </label>
                                <textarea name="mensaje" rows="4"
                                          placeholder="<?= $contacto['formulario']['campos']['mensaje']['placeholder'] ?>"
                                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-poppins text-sm focus:outline-none focus:border-orange-custom transition resize-none"></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-orange-custom hover:bg-[#c2660a] text-white font-bold font-poppins py-3.5 rounded-lg transition">
                                <?= $contacto['formulario']['boton'] ?>
                            </button>

                            <p class="text-center text-gray-400 text-xs font-poppins">
                                <?= $contacto['formulario']['nota_privacidad'] ?>
                            </p>

                        </form>
                    </div>

                    <!-- COLUMNA DERECHA: INFO DE CONTACTO -->
                    <div class="bg-[#faf9f7] rounded-2xl p-6 md:p-8">

                        <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-6">
                            <?= $contacto['info_contacto']['kicker'] ?>
                        </p>

                        <!-- ASESORES -->
                        <div class="space-y-4 mb-6">
                            <?php foreach ($contacto['info_contacto']['asesores'] as $asesor): ?>
                                <div class="flex items-center gap-3">
                                    <img src="<?= $base_url . $asesor['foto'] ?>"
                                         alt="<?= htmlspecialchars($asesor['nombre']) ?>"
                                         class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                    <div class="flex-1">
                                        <p class="text-orange-custom text-xs font-bold font-poppins uppercase"><?= htmlspecialchars($asesor['cargo']) ?></p>
                                        <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($asesor['nombre']) ?></p>
                                        <p class="text-gray-500 text-xs font-poppins"><?= htmlspecialchars($asesor['telefono']) ?></p>
                                    </div>
                                    <a href="https://wa.me/<?= $asesor['whatsapp'] ?>"
                                       target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 bg-[#25D366] hover:bg-[#1ebe5a] text-white text-xs font-bold font-poppins px-4 py-2 rounded-full transition">
                                        Consultar
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- EMAIL -->
                        <div class="flex items-start gap-3 mb-4 pt-4 border-t border-gray-200">
                            <div class="w-9 h-9 flex-shrink-0 bg-[#2a2a2a] rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-envelope text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold font-poppins uppercase tracking-wide text-gray-500"><?= $contacto['info_contacto']['email']['titulo'] ?></p>
                                <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($contacto['info_contacto']['email']['valor']) ?></p>
                                <p class="text-gray-400 text-xs font-poppins"><?= htmlspecialchars($contacto['info_contacto']['email']['nota']) ?></p>
                            </div>
                        </div>

                        <!-- OFICINA -->
                        <div class="flex items-start gap-3 mb-6">
                            <div class="w-9 h-9 flex-shrink-0 bg-[#2a2a2a] rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-location-dot text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold font-poppins uppercase tracking-wide text-gray-500"><?= $contacto['info_contacto']['oficina']['titulo'] ?></p>
                                <p class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($contacto['info_contacto']['oficina']['direccion']) ?></p>
                                <p class="text-gray-400 text-xs font-poppins"><?= htmlspecialchars($contacto['info_contacto']['oficina']['nota']) ?></p>
                            </div>
                        </div>

                        <!-- REDES -->
                        <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-3">
                            <?= $contacto['info_contacto']['redes']['titulo'] ?>
                        </p>
                        <div class="flex items-center gap-3 mb-8">
                            <a href="<?= $contacto['info_contacto']['redes']['facebook'] ?>" target="_blank" rel="noopener"
                               class="w-9 h-9 bg-[#2a2a2a] hover:bg-orange-custom rounded-full flex items-center justify-center transition">
                                <i class="fa-brands fa-facebook-f text-white text-sm"></i>
                            </a>
                            <a href="<?= $contacto['info_contacto']['redes']['instagram'] ?>" target="_blank" rel="noopener"
                               class="w-9 h-9 bg-[#2a2a2a] hover:bg-orange-custom rounded-full flex items-center justify-center transition">
                                <i class="fa-brands fa-instagram text-white text-sm"></i>
                            </a>
                            <a href="<?= $contacto['info_contacto']['redes']['tiktok'] ?>" target="_blank" rel="noopener"
                               class="w-9 h-9 bg-[#2a2a2a] hover:bg-orange-custom rounded-full flex items-center justify-center transition">
                                <i class="fa-brands fa-tiktok text-white text-sm"></i>
                            </a>
                            <a href="<?= $contacto['info_contacto']['redes']['youtube'] ?>" target="_blank" rel="noopener"
                               class="w-9 h-9 bg-[#2a2a2a] hover:bg-orange-custom rounded-full flex items-center justify-center transition">
                                <i class="fa-brands fa-youtube text-white text-sm"></i>
                            </a>
                            <a href="<?= $contacto['info_contacto']['redes']['threads'] ?>" target="_blank" rel="noopener"
                               class="w-9 h-9 bg-[#2a2a2a] hover:bg-orange-custom rounded-full flex items-center justify-center transition">
                                <i class="fa-brands fa-threads text-white text-sm"></i>
                            </a>
                        </div>

                        <!-- MAPA -->
                        <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-3">
                            <?= $contacto['info_contacto']['mapa']['titulo'] ?>
                        </p>
                        <div class="rounded-xl overflow-hidden mb-8 h-64">
                            <iframe
                                src="<?= htmlspecialchars($contacto['info_contacto']['mapa']['embed_url']) ?>"
                                class="w-full h-full border-0"
                                allowfullscreen loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <!-- HORARIO -->
                        <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-3">
                            <?= $contacto['info_contacto']['horario']['titulo'] ?>
                        </p>
                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($contacto['info_contacto']['horario']['items'] as $item): ?>
                                <div class="rounded-lg p-3 <?= !empty($item['destacado']) ? 'bg-green-50 border border-green-200' : 'bg-white border border-gray-200' ?>">
                                    <p class="text-gray-500 text-xs font-poppins"><?= htmlspecialchars($item['dias']) ?></p>
                                    <p class="font-bold font-poppins text-sm <?= !empty($item['destacado']) ? 'text-green-700' : 'text-gray-900' ?>"><?= htmlspecialchars($item['horas']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- ******************** 
             BANNER WHATSAPP
         *********************** -->
        <section class="bg-[#2a2a2a] py-8">
            <div class="container-custom mx-auto px-4 md:px-20">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-white text-xl md:text-2xl font-bold font-poppins">
                            <?= htmlspecialchars($contacto['whatsapp_banner']['titulo_primary']) ?>
                            <span class="text-orange-custom"><?= htmlspecialchars($contacto['whatsapp_banner']['titulo_secondary']) ?></span>?
                        </h3>
                        <p class="text-gray-400 text-sm font-poppins mt-1 max-w-lg">
                            <?= htmlspecialchars($contacto['whatsapp_banner']['descripcion']) ?>
                        </p>
                    </div>
                    <a href="https://wa.me/<?= $contacto['whatsapp_banner']['numero'] ?>"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1ebe5a] text-white font-bold font-poppins px-7 py-3.5 rounded-full transition flex-shrink-0">
                        <?= $contacto['whatsapp_banner']['boton'] ?>
                    </a>
                </div>
            </div>
        </section>

        <!-- ******************** 
             FAQ
         *********************** -->
        <section class="bg-white py-14">
            <div class="container-custom mx-auto px-4 md:px-20">

                <p class="text-orange-custom text-sm font-bold font-poppins uppercase tracking-wide mb-2">
                    <?= $contacto['faq']['kicker'] ?>
                </p>

                <h2 class="text-3xl md:text-4xl font-anton mb-8 leading-tight">
                    <span class="text-gray-900"><?= htmlspecialchars($contacto['faq']['title_primary']) ?></span>
                    <span class="text-orange-custom"><?= htmlspecialchars($contacto['faq']['title_secondary']) ?></span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($contacto['faq']['preguntas'] as $item): ?>
                        <div class="faq-contacto-item border border-gray-200 rounded-xl overflow-hidden">
                            <button type="button" class="faq-contacto-toggle w-full flex items-center justify-between gap-3 p-4 text-left hover:bg-gray-50 transition">
                                <span class="font-bold font-poppins text-gray-900 text-sm"><?= htmlspecialchars($item['pregunta']) ?></span>
                                <i class="fa-solid fa-chevron-down text-orange-custom text-sm faq-contacto-icon transition-transform flex-shrink-0"></i>
                            </button>
                            <?php if (!empty($item['respuesta'])): ?>
                                <div class="faq-contacto-panel hidden px-4 pb-4">
                                    <p class="text-gray-500 text-sm font-poppins leading-relaxed"><?= htmlspecialchars($item['respuesta']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

    </main>

    <?php include('footer.php') ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="js/mobile-menu.js"></script>
    <script src="js/mega-menu.js"></script>

    <!-- FAQ acordeon (contacto) -->
    <script src="js/contacto-faq-accordion.js"></script>
    <!-- Envío del formulario -->
    <script src="js/contacto-form.js"></script>

</body>
</html>