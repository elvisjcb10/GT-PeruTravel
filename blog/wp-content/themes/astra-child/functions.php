<?php
/**
 * Astra Child Theme – Custom Functions
 */

/* Evitar acceso directo */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ✅ CARGAR ESTILOS DEL TEMA PADRE (IMPRESCINDIBLE) */
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css'
    );
}

/* ✅ BOTÓN FLOTANTE WHATSAPP */
add_action('wp_footer', 'gt_whatsapp_floating_button');
function gt_whatsapp_floating_button() {
?>
<script>
(function () {

  function renderWhatsAppButton() {

    if (document.querySelector('.whatsapp-float')) return;

    /* ===== ESTILOS ===== */
    var style = document.createElement("style");
    style.innerHTML = `
      .whatsapp-float {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: inherit;
      }

      .whatsapp-float a {
        background: #25D366;
        color: #fff;
        padding: 14px 18px;
        border-radius: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 6px 16px rgba(0,0,0,.25);
        transition: transform .2s ease;
      }

      .whatsapp-float a:hover {
        transform: scale(1.05);
      }

      .whatsapp-icon {
        width: 32px;
        height: 32px;
        fill: #fff;
        flex-shrink: 0;
      }

      .whatsapp-text {
        font-size: 15px;
        font-weight: 700;
        white-space: nowrap;
      }
    `;
    document.head.appendChild(style);

    /* ===== CONTENEDOR ===== */
    var container = document.createElement("div");
    container.className = "whatsapp-float";

    /* ===== LINK CON MENSAJE DINÁMICO ===== */
    var link = document.createElement("a");

    /* ===== UTILIDADES ===== */
    function cleanText(text) {
      return text.replace(/[\u{1F300}-\u{1FAFF}]/gu, '').trim();
    }

    function getParam(name) {
      return new URLSearchParams(window.location.search).get(name);
    }

    function formatPackageName(slug) {
      if (!slug) return '';
      return slug
        .replace(/-/g, ' ')
        .replace(/\b\w/g, l => l.toUpperCase());
    }

    function forceUTF8(text) {
      try {
        return decodeURIComponent(escape(text));
      } catch (e) {
        return text;
      }
    }

    /* ===== DETECTAR IDIOMA ===== */
    var lang =
      getParam('lang') ||
      (window.location.pathname.startsWith('/en') && 'en') ||
      (window.location.pathname.startsWith('/pt') && 'pt') ||
      'es';

    /* ===== TEXTOS POR IDIOMA ===== */
    var texts = {
      es: {
        hello: 'Hola, me puede informar sobre los tours.',
        page: 'Enlace',
        package: 'Paquete'
      },
      en: {
        hello: 'Hello, could you please provide information about the tours?',
        page: 'Link',
        package: 'Package'
      },
      pt: {
        hello: 'Oi, pode me informar sobre os passeios?',
        page: 'Link',
        package: 'Pacote'
      }
    };

    var t = texts[lang] || texts.es;

    /* ===== DETECTAR ORIGEN ===== */
    var label = '[WEB]';

    if (window.location.pathname.startsWith('/blog')) {
      label = '[BLOG]';
    }

    if (window.location.pathname.startsWith('/paquete')) {
      label = '[TOUR]';
    }

    if (window.location.pathname === '/' || window.location.pathname === '') {
      label = '[HOME]';
    }

    /* ===== DATOS DINÁMICOS ===== */
    var title = cleanText(forceUTF8(document.title));
    var url = window.location.href;

    var packageSlug = getParam('paquete');
    var packageName = formatPackageName(packageSlug);

    /* ===== MENSAJE FINAL ===== */
    var messageText = `${label}
${t.hello}
${t.page}: ${title}`;

    if (packageName) {
      messageText += `
${t.package}: ${packageName}`;
    }

    messageText += `
${url}`;

    /* ===== CODIFICAR ===== */
    var message = encodeURIComponent(messageText);

    /* ===== NÚMEROS DE WHATSAPP ===== */
    var phoneNumbers = [
      "51997379201",
      "51997379201",
      "51997379201"
    ];

    /* ===== ROTAR NÚMERO SEGÚN CARGA ===== */
    var currentIndex = parseInt(localStorage.getItem('whatsappIndex') || '0', 10);
    var phone = phoneNumbers[currentIndex];
    currentIndex = (currentIndex + 1) % phoneNumbers.length;
    localStorage.setItem('whatsappIndex', currentIndex);

    /* ===== LINK FINAL ===== */
    link.href = `https://wa.me/${phone}?text=${message}`;
    link.target = "_blank";
    link.rel = "noopener";

    // GUARDADO EN MEMORIA
    window.GT_WHATSAPP_URL = link.href;

    /* ===== ICONO SVG WHATSAPP ===== */
    var icon = document.createElement("div");
    icon.innerHTML = `
      <svg class="whatsapp-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48 2 2 6.21 2 11.4c0 2.08.73 4.01 1.97 5.56L2 22l5.2-1.72c1.45.76 3.1 1.2 4.8 1.2 5.52 0 10-4.21 10-9.4S17.52 2 12 2zm0 17.07c-1.52 0-3.01-.4-4.3-1.15l-.31-.18-3.09 1.02 1.01-2.93-.2-.3A7.3 7.3 0 0 1 4.7 11.4c0-4.04 3.29-7.33 7.3-7.33 4.02 0 7.3 3.29 7.3 7.33 0 4.03-3.28 7.34-7.3 7.34zm4.01-5.45c-.22-.11-1.3-.64-1.5-.71-.2-.07-.35-.11-.5.11-.15.22-.58.71-.71.86-.13.15-.26.17-.48.06-.22-.11-.94-.35-1.79-1.12-.66-.59-1.1-1.32-1.23-1.54-.13-.22-.01-.34.1-.45.1-.1.22-.26.33-.39.11-.13.15-.22.22-.37.07-.15.04-.28-.02-.39-.06-.11-.5-1.2-.69-1.64-.18-.43-.36-.37-.5-.38h-.43c-.15 0-.39.06-.6.28-.21.22-.78.76-.78 1.85 0 1.09.8 2.15.91 2.3.11.15 1.58 2.38 3.83 3.34.54.23.96.37 1.29.47.54.17 1.03.15 1.42.09.43-.06 1.3-.53 1.48-1.04.18-.52.18-.96.13-1.04-.05-.08-.19-.13-.41-.24z"/>
      </svg>
    `;

    /* ===== TEXTO ===== */
    var text = document.createElement("span");
    text.className = "whatsapp-text";

    link.appendChild(icon);
    link.appendChild(text);
    container.appendChild(link);
    document.body.appendChild(container);

    /* ===== CAMBIO DE TEXTO SEGÚN DISPOSITIVO ===== */
    function updateText() {
      text.innerText = window.innerWidth <= 768
        ? "Consulta Gratis"
        : "Consulta ahora";
    }

    updateText();
    window.addEventListener("resize", updateText);
  }

  document.readyState === "loading"
    ? document.addEventListener("DOMContentLoaded", renderWhatsAppButton)
    : renderWhatsAppButton();
    
  // ===== CONECTAR MENU "CONSULTAS GRATIS" =====
  document.addEventListener('DOMContentLoaded', function () {
    if (!window.GT_WHATSAPP_URL) return;

    document.querySelectorAll('a').forEach(function (a) {
      if (a.textContent.trim().toLowerCase() === 'consultas gratis') {
        a.href = window.GT_WHATSAPP_URL;
        a.target = "_blank";
      }
    });
  });

})();
</script>
<?php
}
