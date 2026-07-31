<?php
/**
 * Footer — GT Perú Travel
 * Diseño: Frame_427318309.png
 * Stack: Tailwind CSS + Font Awesome + PHP data binding
 */
$footer_language = $idioma ?? ($GLOBALS['lang'] ?? 'es');
$footer_ui = [
    'es' => ['hours' => 'Horario', 'phone' => 'Teléfono', 'address' => 'Dirección', 'email' => 'Correo', 'payments' => 'Pagos seguros'],
    'en' => ['hours' => 'Hours', 'phone' => 'Phone', 'address' => 'Address', 'email' => 'Email', 'payments' => 'Secure payments'],
    'pt' => ['hours' => 'Horário', 'phone' => 'Telefone', 'address' => 'Endereço', 'email' => 'E-mail', 'payments' => 'Pagamentos seguros'],
][$footer_language] ?? ['hours' => 'Horario', 'phone' => 'Teléfono', 'address' => 'Dirección', 'email' => 'Correo', 'payments' => 'Pagos seguros'];
?>

<footer class="bg-[#2b2b2b] text-white pt-14 pb-8">

    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- ══════════════════════════════════
             COL 1 · MARCA + REDES + BADGES
        ═══════════════════════════════════ -->
        <div class="space-y-5">

            <!-- Logo -->
            <a href="<?= $base_url ?>/" class="inline-block">
                <img src="<?= $base_url ?>/images/logo/footer.svg"
                     alt="GT Perú Travel"
                     class="h-16 w-auto">
            </a>

            <!-- Descripción -->
            <p class="text-sm leading-relaxed text-gray-400 font-poppins max-w-[220px]">
                <?= htmlspecialchars($footer['description']) ?>
            </p>

            <!-- Redes sociales -->
            <div>
                <p class="text-xs font-bold tracking-widest text-[#ff9300] uppercase mb-3">
                    Síguenos
                </p>
                <div class="flex items-center gap-2">
                    <a href="#" aria-label="Facebook"
                       class="w-9 h-9 rounded-lg bg-[#3a3a3a] hover:bg-[#ff9300] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-facebook-f text-sm text-white"></i>
                    </a>
                    <a href="#" aria-label="Instagram"
                       class="w-9 h-9 rounded-lg bg-[#3a3a3a] hover:bg-[#ff9300] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-instagram text-sm text-white"></i>
                    </a>
                    <a href="#" aria-label="TikTok"
                       class="w-9 h-9 rounded-lg bg-[#3a3a3a] hover:bg-[#ff9300] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-tiktok text-sm text-white"></i>
                    </a>
                    <a href="#" aria-label="YouTube"
                       class="w-9 h-9 rounded-lg bg-[#3a3a3a] hover:bg-[#ff9300] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-youtube text-sm text-white"></i>
                    </a>
                    <a href="#" aria-label="Threads"
                       class="w-9 h-9 rounded-lg bg-[#3a3a3a] hover:bg-[#ff9300] transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-threads text-sm text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Badges TripAdvisor / PromPerú -->
            <div class="flex items-center gap-3 pt-1">
                <span class="flex items-center gap-1.5 text-xs text-gray-400 font-poppins">
                    <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                    TripAdvisor 2025
                </span>
                <span class="flex items-center gap-1.5 text-xs text-gray-400 font-poppins">
                    <span class="w-2 h-2 rounded-full bg-[#ff9300] inline-block"></span>
                    PromPerú
                </span>
            </div>
        </div>


        <!-- ══════════════════════════════════
             COL 2 · ENLACES ÚTILES
        ═══════════════════════════════════ -->
        <div>
            <h3 class="text-xs font-bold tracking-widest text-[#ff9300] uppercase mb-5">
                <?= htmlspecialchars($footer['enlaces_title']) ?>
            </h3>

            <ul class="space-y-3">
                <?php foreach ($footer['enlaces'] as $enlace): ?>
                <li class="flex items-center gap-2">

                    <a href="<?= $base_url ?>/<?= htmlspecialchars($enlace['url']) ?>"
                       class="text-sm text-gray-300 font-poppins hover:text-[#ff9300] transition-colors duration-200">
                        <?= htmlspecialchars($enlace['name']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <!-- ══════════════════════════════════
             COL 3 · DESTINOS
        ═══════════════════════════════════ -->
        <div>
            <h3 class="text-xs font-bold tracking-widest text-[#ff9300] uppercase mb-5">
                <?= htmlspecialchars($footer['destinos_title']) ?>
            </h3>

            <ul class="space-y-3">
                <?php foreach ($footer['destinos'] as $destino): ?>
                <li class="flex items-center gap-2">
                    <a href="<?= $base_url ?>/tour/template-tour.php?tour=<?= htmlspecialchars($destino['url']) ?>&lang=<?= $idioma ?>"
                       class="text-sm text-gray-300 font-poppins hover:text-[#ff9300] transition-colors duration-200">
                        <?= htmlspecialchars($destino['name']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <!-- ══════════════════════════════════
             COL 4 · CONTÁCTENOS
        ═══════════════════════════════════ -->
        <div class="space-y-5">
            <h3 class="text-xs font-bold tracking-widest text-[#ff9300] uppercase">
                <?= htmlspecialchars($footer['contact_title']) ?>
            </h3>

            <!-- Horario -->
            <div>
                <p class="text-xs    tracking-wide mb-1"><?= htmlspecialchars($footer_ui['hours']) ?></p>
                <p class="flex items-center gap-1.5 text-sm text-gray-400 font-poppins">
                    <i class="far fa-clock text-gray-500 text-xs"></i>
                    <?= htmlspecialchars($footer['horario']) ?>
                </p>
            </div>

            <!-- Teléfono / WhatsApp -->
            <div>
                <p class="text-xs   tracking-wide mb-1"><?= htmlspecialchars($footer_ui['phone']) ?></p>
                <a href="https://wa.me/<?= htmlspecialchars($footer['whatsapp']) ?>"
                   target="_blank" rel="noopener"
                   class="flex items-center gap-1.5 text-sm text-gray-400 font-poppins hover:text-[#ff9300] transition-colors">
                    <i class="far fa-comment-dots text-gray-500 text-xs"></i>
                    +<?= htmlspecialchars($footer['whatsapp']) ?>
                </a>
            </div>

            <!-- Dirección -->
            <div>
                <p class="text-xs    tracking-wide mb-1"><?= htmlspecialchars($footer_ui['address']) ?></p>
                <p class="flex items-start gap-1.5 text-sm text-gray-400 font-poppins leading-snug">
                    <i class="far fa-map-marker-alt text-gray-500 text-xs mt-0.5 flex-shrink-0"></i>
                    <?= htmlspecialchars($footer['direccion']) ?>
                </p>
            </div>

            <!-- Correo -->
            <div>
                <p class="text-xs   tracking-wide mb-1"><?= htmlspecialchars($footer_ui['email']) ?></p>
                <a href="mailto:<?= htmlspecialchars($footer['email']) ?>"
                   class="flex items-center gap-1.5 text-sm text-gray-400 font-poppins hover:text-[#ff9300] transition-colors">
                    <i class="far fa-envelope text-gray-500 text-xs"></i>
                    <?= htmlspecialchars($footer['email']) ?>
                </a>
            </div>

            <!-- Pagos seguros -->
            <div>
                <p class="text-xs text-gray-500 font-poppins uppercase tracking-wide mb-2"><?= htmlspecialchars($footer_ui['payments']) ?></p>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="rounded px-2 py-1 flex items-center">
                        <img src="<?= $base_url ?>/images/visa.png" alt="Visa" class="h-5 w-auto">
                    </span>
                    <span class=" rounded px-2 py-1 flex items-center">
                        <img src="<?= $base_url ?>/images/mastercard.png" alt="Mastercard" class="h-5 w-auto">
                    </span>
                    <span class=" rounded px-2 py-1 flex items-center">
                        <img src="<?= $base_url ?>/images/amex.png" alt="Amex" class="h-5 w-auto">
                    </span>
                    <span class="border border-gray-500 rounded px-2 py-1 text-xs text-gray-300 font-poppins">
                        Transferencia
                    </span>
                </div>
            </div>

            <!-- Botón Contactar -->
            <a href="https://wa.me/<?= htmlspecialchars($footer['whatsapp']) ?>"
               target="_blank" rel="noopener"
               class="block w-full text-center bg-[#ff9300] hover:bg-[#e07f00] active:bg-[#cc7200] transition-colors duration-200 text-white text-sm font-bold font-poppins py-3 rounded-md tracking-wide">
                <?= htmlspecialchars($footer['boton']) ?>
            </a>

        </div><!-- /col4 -->

    </div><!-- /grid -->


    <!-- ══════════════════════════════════
         BARRA LEGAL
    ═══════════════════════════════════ -->
    <div class="border-t border-gray-700 mt-12 pt-6 text-center font-poppins text-xs text-gray-600">
        <?= htmlspecialchars($footer['footer_legal']) ?>
    </div>

</footer>


<!-- ── Scripts externos ──────────────────────────── -->
<script src="<?= $base_url ?>/js/whatsapp-floating.js" defer></script>

<!-- Analytics -->
<?php include __DIR__ . '/includes/analytics.php'; ?>

<!-- Meta Pixel -->
<?php include __DIR__ . '/includes/meta.php'; ?>