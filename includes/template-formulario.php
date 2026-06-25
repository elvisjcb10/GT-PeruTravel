<?php
// $lang y $tipo_formulario vienen del template padre
$form_path = __DIR__ . "/../lang/form-{$lang}.json";
if (!file_exists($form_path)) {
    $form_path = __DIR__ . "/../lang/form-es.json";
}
$form = json_decode(file_get_contents($form_path), true);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/css/intlTelInput.css">


<form id="formulario-contacto" action="/mail/enviar.php" method="POST" class="bg-gray-50 p-6 rounded-2xl shadow-lg">

    <input type="hidden" name="tipo_formulario" value="<?= $tipo_formulario ?>">
    <input type="hidden" name="paquete" value="<?= $data['title'] ?? '' ?>">
    <input type="hidden" name="lang" value="<?= $lang ?>">

    <h3 class="text-xl font-bold text-gray-900 mb-2 text-center font-poppins">
        <?= $form['titulo'] ?>
    </h3>

    <p class="text-sm text-gray-500 text-center mb-4 font-poppins">
        <?= $form['subtitle'] ?>
    </p>

    <div class="grid grid-cols-1 gap-4">

        <label class="text-sm text-gray-600 font-medium font-poppins">
            <?= $form['nombre'] ?>
        </label>
        <input name="nombre" type="text" placeholder="<?= $form['nombre-placeholder'] ?>"
            class="text-gray-900 border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-[#ff9300] focus:outline-none font-poppins">

        <label class="text-sm text-gray-600 font-medium font-poppins">
            <?= $form['numero'] ?>
        </label>
        <input id="telefono" name="numero" type="tel" autocomplete="tel" placeholder="<?= $form['numero-placeholder'] ?>"
            class="text-gray-900 border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-[#ff9300] focus:outline-none font-poppins">

        <label class="text-sm text-gray-600 font-medium font-poppins">
            <?= $form['correo'] ?>
        </label>
        <input name="correo" type="email" placeholder="<?= $form['correo-placeholder'] ?>"
            class="text-gray-900 border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-[#ff9300] focus:outline-none font-poppins">

        <label class="text-sm text-gray-600 font-medium font-poppins">
            <?= $form['fecha'] ?>
        </label>
        <input id="fecha" name="fecha" type="date"
            class="border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-[#ff9300] focus:outline-none text-black font-poppins">

        <label class="text-sm text-gray-600 font-medium font-poppins">
            <?= $form['mensaje'] ?>
        </label>
        <textarea name="mensaje" placeholder="<?= $form['mensaje-placeholder'] ?>"
            class="text-gray-900 border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-[#ff9300] focus:outline-none font-poppins"></textarea>

    </div>

    <!-- Google reCAPTCHA -->
    <div class="w-full flex justify-center mt-4">
        <div class="g-recaptcha" data-sitekey="6LdyCx4sAAAAAELQ_dpHqqj8_LjMaqWA4wa4ZiTF"></div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <button class="bg-[#ff9300] hover:bg-[#ff7a00] text-white w-full mt-5 py-3 rounded-md font-bold transition">
        <?= $form['boton'] ?>
    </button>

    <div id="form-mensaje" class="mt-4 text-center text-sm font-medium"></div>

</form>

<!-- LIBRERIA TELEFONO -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js"></script>

<script>
    const formMessages = {
        success: "<?= $form['success'] ?>",
        error: "<?= $form['error'] ?>"
    };
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const inputTelefono = document.querySelector("#telefono");

        const iti = window.intlTelInput(inputTelefono, {
            initialCountry: "auto",
            preferredCountries: ["us", "br", "es", "pe"],
            separateDialCode: true,
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("pe"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js"
        });

        const form = document.getElementById('formulario-contacto');
        const mensajeDiv = document.getElementById('form-mensaje');

        form.addEventListener('submit', function(e) {

            e.preventDefault();
            mensajeDiv.innerHTML = '';

            inputTelefono.value = iti.getNumber();

            const formData = new FormData(form);

            const captchaResponse = grecaptcha.getResponse();
            formData.set('g-recaptcha-response', captchaResponse);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {

                    if (data.includes("OK")) {

                        // 🔥 CONVERSIÓN GOOGLE ADS
                        gtag('event', 'conversion', {
                            'send_to': 'AW-17034229022/CXvjCMDS74scEJ7qxro_'
                        });

                        mensajeDiv.innerHTML = '<span class="text-green-600">' + formMessages.success + '</span>';

                        form.reset();
                        grecaptcha.reset();
                        iti.setCountry("pe");

                    } else {

                        mensajeDiv.innerHTML = '<span class="text-red-600">' + data + '</span>';

                    }

                })
                .catch(err => {

                    mensajeDiv.innerHTML = '<span class="text-red-600">' + formMessages.error + '</span>';
                    console.error(err);

                });

        });

    });
</script>