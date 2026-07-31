document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-contacto");
    if (!form) return;
    const language = document.documentElement.lang || "es";
    const messages = {
        es: { sending: "Enviando...", success: "?Mensaje enviado! Te contactaremos pronto.", error: "No se pudo enviar el mensaje.", captcha: "Completa el reCAPTCHA." },
        en: { sending: "Sending...", success: "Message sent! We will contact you soon.", error: "The message could not be sent.", captcha: "Complete the reCAPTCHA." },
        pt: { sending: "Enviando...", success: "Mensagem enviada! Entraremos em contato em breve.", error: "N?o foi poss?vel enviar a mensagem.", captcha: "Preencha o reCAPTCHA." }
    }[language];
    const status = document.getElementById("contacto-form-status");
    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        const button = form.querySelector("button[type='submit']");
        const original = button.textContent;
        const captcha = typeof grecaptcha !== "undefined" ? grecaptcha.getResponse() : "";
        if (!captcha) { status.textContent = messages.captcha; status.className = "text-center text-sm font-poppins text-red-600"; return; }
        button.disabled = true; button.textContent = messages.sending; status.textContent = "";
        try {
            const body = new FormData(form); body.set("g-recaptcha-response", captcha);
            const response = await fetch(form.action, { method: "POST", body });
            const text = await response.text();
            if (!response.ok || !text.includes("OK")) throw new Error(text || messages.error);
            status.textContent = messages.success; status.className = "text-center text-sm font-poppins text-green-600";
            if (typeof gtag === "function") {
                gtag("event", "generate_lead", { method: "contact_form" });
                gtag("event", "conversion", { send_to: "AW-17034229022/CXvjCMDS74scEJ7qxro_" });
            }
            form.reset(); grecaptcha.reset();
        } catch (error) {
            status.textContent = error.message || messages.error; status.className = "text-center text-sm font-poppins text-red-600";
        } finally { button.disabled = false; button.textContent = original; }
    });
});
