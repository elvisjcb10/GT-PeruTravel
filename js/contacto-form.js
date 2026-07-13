document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-contacto");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const submitBtn = form.querySelector("button[type='submit']");
        const originalText = submitBtn.textContent;

        submitBtn.disabled = true;
        submitBtn.textContent = "Enviando...";

        try {
            const response = await fetch("procesar-contacto.php", {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                form.reset();
                alert("¡Mensaje enviado! Te contactaremos pronto.");
            } else {
                alert("Hubo un error al enviar el mensaje. Intenta nuevamente.");
            }
        } catch (err) {
            alert("Hubo un error de conexión. Intenta nuevamente.");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});