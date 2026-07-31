document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-contacto");
    if (!form) return;

    const language = document.documentElement.lang || "es";
    const messages = {
        es: { sending: "Enviando...", success: "¡Mensaje enviado! Te contactaremos pronto.", error: "Hubo un error al enviar el mensaje. Intenta nuevamente.", connection: "Hubo un error de conexión. Intenta nuevamente." },
        en: { sending: "Sending...", success: "Message sent! We will contact you soon.", error: "The message could not be sent. Please try again.", connection: "Connection error. Please try again." },
        pt: { sending: "Enviando...", success: "Mensagem enviada! Entraremos em contato em breve.", error: "Não foi possível enviar a mensagem. Tente novamente.", connection: "Erro de conexão. Tente novamente." },
    }[language] || null;

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const submitButton = form.querySelector("button[type='submit']");
        if (!submitButton) return;
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = messages.sending;

        try {
            const response = await fetch("procesar-contacto.php", { method: "POST", body: formData });
            if (!response.ok) throw new Error("send");
            form.reset();
            alert(messages.success);
        } catch (error) {
            alert(error.message === "send" ? messages.error : messages.connection);
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    });
});