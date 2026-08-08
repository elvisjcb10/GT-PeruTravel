(function () {

    "use strict";

    function renderWhatsAppButton() {

        // Evitar crear el botón más de una vez
        if (document.querySelector(".whatsapp-float")) {
            return;
        }


        /* =====================================================
           ESTILOS DEL BOTÓN FLOTANTE
        ===================================================== */

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
                color: #ffffff;
                padding: 14px 18px;
                border-radius: 14px;
                text-decoration: none;

                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;

                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);

                transition:
                    transform 0.2s ease,
                    box-shadow 0.2s ease;
            }

            .whatsapp-float a:hover {
                transform: scale(1.05);
                box-shadow: 0 8px 22px rgba(0, 0, 0, 0.30);
            }

            .whatsapp-float a:active {
                transform: scale(0.98);
            }

            .whatsapp-icon {
                width: 32px;
                height: 32px;
                fill: #ffffff;
                flex-shrink: 0;
            }

            .whatsapp-text {
                font-size: 15px;
                font-weight: 700;
                white-space: nowrap;
            }


            /* ============================
               MOBILE
            ============================ */

            @media (max-width: 768px) {

                .whatsapp-float {
                    bottom: 16px;
                    right: 16px;
                }

                .whatsapp-float a {
                    padding: 12px 15px;
                    gap: 9px;
                    border-radius: 13px;
                }

                .whatsapp-icon {
                    width: 28px;
                    height: 28px;
                }

                .whatsapp-text {
                    font-size: 13px;
                }

            }
        `;

        document.head.appendChild(style);



        /* =====================================================
           CONTENEDOR
        ===================================================== */

        const container = document.createElement("div");

        container.className = "whatsapp-float";



        /* =====================================================
           LINK
        ===================================================== */

        const link = document.createElement("a");

        link.setAttribute(
            "aria-label",
            "Contactar con GT Peru Travel por WhatsApp"
        );



        /* =====================================================
           DETECTAR IDIOMA
        ===================================================== */

        const path = window.location.pathname;

        let lang = "es";

        if (
            path === "/en" ||
            path === "/en/" ||
            path.startsWith("/en/")
        ) {
            lang = "en";
        }

        if (
            path === "/pt" ||
            path === "/pt/" ||
            path.startsWith("/pt/")
        ) {
            lang = "pt";
        }



        /* =====================================================
           TEXTOS SEGÚN IDIOMA
        ===================================================== */

        const texts = {

            es: {
                hello: "Hola, me puede informar sobre los tours.",
                page: "Página",
                buttonMobile: "Consulta Gratis",
                buttonDesktop: "Escríbenos ahora"
            },

            en: {
                hello: "Hello, could you please provide information about the tours?",
                page: "Page",
                buttonMobile: "Free Consult",
                buttonDesktop: "Write to us now"
            },

            pt: {
                hello: "Olá, poderia me dar informações sobre os passeios?",
                page: "Página",
                buttonMobile: "Consulta Gratuita",
                buttonDesktop: "Escreva para nós agora"
            }

        };

        const t = texts[lang] || texts.es;



        /* =====================================================
           DETECTAR DESDE QUÉ TIPO DE PÁGINA VIENE EL CLIENTE
        ===================================================== */

        let label = "[WEB]";


        // HOME
        if (
            path === "/" ||
            path === "/es/" ||
            path === "/en/" ||
            path === "/pt/"
        ) {
            label = "[HOME]";
        }


        // TOURS
        else if (
            path.includes("/tours/")
        ) {
            label = "[TOUR]";
        }


        // PAQUETES
        else if (
            path.includes("/paquetes/")
        ) {
            label = "[PAQUETE]";
        }


        // DESTINOS
        else if (
            path.includes("/destinos/")
        ) {
            label = "[DESTINO]";
        }


        // BLOG
        else if (
            path.includes("/blog/")
        ) {
            label = "[BLOG]";
        }



        /* =====================================================
           DATOS DE LA PÁGINA
        ===================================================== */

        const title = document.title.trim();

        const url = window.location.href;



        /* =====================================================
           CREAR MENSAJE
        ===================================================== */

        const messageText =
`${label}
${t.hello}
${t.page}: ${title}
${url}`;


        const message = encodeURIComponent(messageText);



        /* =====================================================
           NÚMEROS DE WHATSAPP
        ===================================================== */

        const phoneNumbers = [

            "51997379201"

        ];


        const randomPhone =
            phoneNumbers[
                Math.floor(
                    Math.random() * phoneNumbers.length
                )
            ];



        /* =====================================================
           GENERAR URL WHATSAPP
        ===================================================== */

        link.href =
            `https://wa.me/${randomPhone}?text=${message}`;

        link.target = "_blank";

        link.rel = "noopener noreferrer";



        /* =====================================================
           GUARDAR URL GLOBAL
           Sirve para otros botones de WhatsApp del sitio
        ===================================================== */

        window.GT_WHATSAPP_URL = link.href;



        /* =====================================================
           ICONO WHATSAPP
        ===================================================== */

        const icon = document.createElement("div");

        icon.innerHTML = `
            <svg
                class="whatsapp-icon"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >

                <path d="
                    M12 2
                    C6.48 2 2 6.21 2 11.4
                    c0 2.08.73 4.01 1.97 5.56
                    L2 22
                    l5.2-1.72
                    c1.45.76 3.1 1.2 4.8 1.2
                    5.52 0 10-4.21 10-9.4
                    S17.52 2 12 2zm0 17.07
                    c-1.52 0-3.01-.4-4.3-1.15
                    l-.31-.18-3.09 1.02
                    1.01-2.93-.2-.3
                    A7.3 7.3 0 0 1 4.7 11.4
                    c0-4.04 3.29-7.33 7.3-7.33
                    4.02 0 7.3 3.29 7.3 7.33
                    0 4.03-3.28 7.34-7.3 7.34zm4.01-5.45
                    c-.22-.11-1.3-.64-1.5-.71
                    -.2-.07-.35-.11-.5.11
                    -.15.22-.58.71-.71.86
                    -.13.15-.26.17-.48.06
                    -.22-.11-.94-.35-1.79-1.12
                    -.66-.59-1.1-1.32-1.23-1.54
                    -.13-.22-.01-.34.1-.45
                    .1-.1.22-.26.33-.39
                    .11-.13.15-.22.22-.37
                    .07-.15.04-.28-.02-.39
                    -.06-.11-.5-1.2-.69-1.64
                    -.18-.43-.36-.37-.5-.38
                    h-.43
                    c-.15 0-.39.06-.6.28
                    -.21.22-.78.76-.78 1.85
                    0 1.09.8 2.15.91 2.3
                    .11.15 1.58 2.38 3.83 3.34
                    .54.23.96.37 1.29.47
                    .54.17 1.03.15 1.42.09
                    .43-.06 1.3-.53 1.48-1.04
                    .18-.52.18-.96.13-1.04
                    -.05-.08-.19-.13-.41-.24z
                "/>

            </svg>
        `;



        /* =====================================================
           TEXTO DEL BOTÓN
        ===================================================== */

        const text = document.createElement("span");

        text.className = "whatsapp-text";



        /* =====================================================
           RESPONSIVE DEL TEXTO
        ===================================================== */

        const updateText = function () {

            if (window.innerWidth <= 768) {

                text.innerText = t.buttonMobile;

            } else {

                text.innerText = t.buttonDesktop;

            }

        };


        updateText();


        window.addEventListener(
            "resize",
            updateText
        );



        /* =====================================================
           ARMAR BOTÓN
        ===================================================== */

        link.appendChild(icon);

        link.appendChild(text);

        container.appendChild(link);

        document.body.appendChild(container);



        /* =====================================================
           CONECTAR OTROS BOTONES DEL SITIO
        ===================================================== */

        connectWhatsAppLinks();

    }



    /* =========================================================
       CONECTAR BOTONES DEL HEADER / WEB
    ========================================================= */

    function connectWhatsAppLinks() {

        if (!window.GT_WHATSAPP_URL) {
            return;
        }


        const whatsappTexts = [

            "consultas gratis",
            "consulta gratis",

            "free consult",
            "free consultation",

            "consulta gratuita",

            "escríbenos ahora",
            "write to us now",
            "escreva para nós agora"

        ];


        document.querySelectorAll("a").forEach(function (a) {

            const text =
                a.textContent
                    .trim()
                    .toLowerCase();


            if (
                whatsappTexts.includes(text)
            ) {

                a.href =
                    window.GT_WHATSAPP_URL;

                a.target =
                    "_blank";

                a.rel =
                    "noopener noreferrer";

            }

        });

    }



    /* =========================================================
       INICIAR
    ========================================================= */

    if (
        document.readyState === "loading"
    ) {

        document.addEventListener(
            "DOMContentLoaded",
            renderWhatsAppButton
        );

    } else {

        renderWhatsAppButton();

    }


})();