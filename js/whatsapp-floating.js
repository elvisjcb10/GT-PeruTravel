(function() {

    function renderWhatsAppButton() {

        if (document.querySelector('.whatsapp-float')) return;

        /* ===== ESTILOS ===== */
        const style = document.createElement("style");
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
        const container = document.createElement("div");
        container.className = "whatsapp-float";

        const link = document.createElement("a");

        /* ===== UTILIDADES ===== */
        const cleanText = (text) =>
            text.replace(/[\u{1F300}-\u{1FAFF}]/gu, '').trim();

        const getParam = (name) =>
            new URLSearchParams(window.location.search).get(name);

        const formatPackageName = (slug) =>
            slug ? slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '';

        const forceUTF8 = (text) => {
            try {
                return decodeURIComponent(escape(text));
            } catch {
                return text;
            }
        };

        /* ===== IDIOMA (i18n) ===== */
        const lang =
            getParam('lang') ||
            (location.pathname.startsWith('/en') && 'en') ||
            (location.pathname.startsWith('/pt') && 'pt') ||
            'es';

        const texts = {
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

        const t = texts[lang] || texts.es;

        /* ===== ORIGEN ===== */
        let label = '[WEB]';
        if (location.pathname.startsWith('/blog')) label = '[BLOG]';
        if (location.pathname.startsWith('/paquete')) label = '[TOUR]';
        if (location.pathname === '/' || location.pathname === '') label = '[HOME]';

        /* ===== DATOS DINÁMICOS ===== */
        const title = cleanText(forceUTF8(document.title));
        const url = window.location.href;
        const packageName = formatPackageName(getParam('paquete'));

        /* ===== MENSAJE ===== */
        let messageText = `${label}
${t.hello}
${t.page}: ${title}`;

        if (packageName) {
            messageText += `
${t.package}: ${packageName}`;
        }

        messageText += `
${url}`;

        const message = encodeURIComponent(messageText);

        /* ===== ROTACIÓN ALEATORIA DE NÚMEROS ===== */
        const phoneNumbers = [
            '51997379201',
            '51997379201',
            '51997379201'
        ];

        const randomPhone = phoneNumbers[Math.floor(Math.random() * phoneNumbers.length)];

        link.href = `https://wa.me/${randomPhone}?text=${message}`;
        link.target = "_blank";
        link.rel = "noopener";
            }
        });


        // Guardar URL global (para menú)
        window.GT_WHATSAPP_URL = link.href;

        /* ===== ICONO ===== */
        const icon = document.createElement("div");
        icon.innerHTML = `
      <svg class="whatsapp-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48 2 2 6.21 2 11.4c0 2.08.73 4.01 1.97 5.56L2 22l5.2-1.72c1.45.76 3.1 1.2 4.8 1.2 5.52 0 10-4.21 10-9.4S17.52 2 12 2zm0 17.07c-1.52 0-3.01-.4-4.3-1.15l-.31-.18-3.09 1.02 1.01-2.93-.2-.3A7.3 7.3 0 0 1 4.7 11.4c0-4.04 3.29-7.33 7.3-7.33 4.02 0 7.3 3.29 7.3 7.33 0 4.03-3.28 7.34-7.3 7.34zm4.01-5.45c-.22-.11-1.3-.64-1.5-.71-.2-.07-.35-.11-.5.11-.15.22-.58.71-.71.86-.13.15-.26.17-.48.06-.22-.11-.94-.35-1.79-1.12-.66-.59-1.1-1.32-1.23-1.54-.13-.22-.01-.34.1-.45.1-.1.22-.26.33-.39.11-.13.15-.22.22-.37.07-.15.04-.28-.02-.39-.06-.11-.5-1.2-.69-1.64-.18-.43-.36-.37-.5-.38h-.43c-.15 0-.39.06-.6.28-.21.22-.78.76-.78 1.85 0 1.09.8 2.15.91 2.3.11.15 1.58 2.38 3.83 3.34.54.23.96.37 1.29.47.54.17 1.03.15 1.42.09.43-.06 1.3-.53 1.48-1.04.18-.52.18-.96.13-1.04-.05-.08-.19-.13-.41-.24z"/>
      </svg>
    `;

        const text = document.createElement("span");
        text.className = "whatsapp-text";

        link.appendChild(icon);
        link.appendChild(text);
        container.appendChild(link);
        document.body.appendChild(container);

        /* ===== TEXTO BOTÓN SEGÚN IDIOMA ===== */
        const buttonTexts = {
            es: {
                mobile: "Consulta Gratis",
                desktop: "Escríbenos ahora"
            },
            en: {
                mobile: "Free Consult",
                desktop: "Write to us now"
            },
            pt: {
                mobile: "Consulta Gratuita",
                desktop: "Escreva para nós agora"
            }
        };

        /* ===== TEXTO RESPONSIVE ===== */
        const updateText = () => {
            const tBtn = buttonTexts[lang] || buttonTexts.es; // español por defecto
            text.innerText = window.innerWidth <= 768 ? tBtn.mobile : tBtn.desktop;
        };

        updateText();
        window.addEventListener("resize", updateText);

    }

    /* ===== INICIALIZAR ===== */
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", renderWhatsAppButton);
    } else {
        renderWhatsAppButton();
    }

    /* ===== CONECTAR MENÚ ===== */
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.GT_WHATSAPP_URL) return;

        document.querySelectorAll('a').forEach(a => {
            if (a.textContent.trim().toLowerCase() === 'consultas gratis') {
                a.href = window.GT_WHATSAPP_URL;
                a.target = "_blank";
            }
        });
    });

})();