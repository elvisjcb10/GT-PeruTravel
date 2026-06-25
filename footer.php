<footer class="bg-[#0f172a] text-white pt-16 pb-10">

    <div class="container-custom mx-auto px-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- 1. MARCA -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-[#ff9300]">
                <?= $footer['company_name'] ?>
            </h2>

            <p class="text-sm font-poppins leading-relaxed text-gray-400">
                <?= $footer['description'] ?>
            </p>
        </div>

        <!-- 2. TOURS (DINÁMICO) -->
        <div>
            <h3 class="text-lg font-bold text-[#ff9300] mb-4 uppercase">
                <?= $footer['tours_title'] ?>
            </h3>

            <ul class="space-y-2 text-sm text-gray-400 font-poppins">
                <?php foreach ($footer['tours'] as $tour): ?>
                    <li>
                        <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= $tour['url'] ?>&lang=<?= $idioma ?>"
                            class="hover:text-[#ff9300] transition duration-300">
                            <?= $tour['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- 3. EMPRESA -->
        <div>
            <h3 class="text-lg font-bold text-[#ff9300] mb-4 uppercase">
                <?= $footer['company_title'] ?>
            </h3>

            <ul class="space-y-2 text-sm text-gray-400 font-poppins">
                <li><?= $footer['company_info']['name'] ?></li>
                <li>RUC: <?= $footer['company_info']['ruc'] ?></li>
                <li><?= $footer['company_info']['email'] ?></li>
                <li><?= $footer['company_info']['address'] ?></li>
            </ul>
        </div>

        <!-- 4. CONTACTO -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-[#ff9300] uppercase">
                <?= $footer['contact_title'] ?>
            </h3>

            <a href="https://wa.me/<?= $footer['whatsapp'] ?>"
                target="_blank"
                class="inline-block bg-[#ff9300] hover:bg-[#ff7a00] transition duration-300 text-white px-4 py-2 rounded font-poppins">
                WhatsApp
            </a>

            <p class="text-sm text-gray-400 font-poppins">
                <?= $footer['email'] ?>
            </p>

            <!-- MÉTODOS DE PAGO (DINÁMICO) -->
            <div class="mt-4">
                <p class="text-sm text-gray-400 mb-2 font-poppins">Pagos seguros con:</p>

                <div class="flex items-center gap-4 opacity-80 hover:opacity-100 transition">
                    <img src="<?= $base_url ?>/images/visa.png" alt="Visa" class="h-9">
                    <img src="<?= $base_url ?>/images/mastercard.png" alt="Mastercard" class="h-9">
                    <img src="<?= $base_url ?>/images/amex.png" alt="American Express" class="h-9">
                </div>
            </div>
        </div>

    </div>

    <!-- Footer legal -->
    <div class="border-t border-gray-700 mt-10 pt-6 text-center font-poppins text-sm text-gray-500">
        <?= $footer['footer_legal'] ?>
    </div>

</footer>

<!-- Whatsapp mensajes -->
<script src="<?= $base_url ?>/js/whatsapp-floating.js" defer></script>


<!-- analtitics -->
<?php include __DIR__ . '/includes/analytics.php'; ?>

<!-- meta pixel code -->
<?php include __DIR__ . '/includes/meta.php'; ?>