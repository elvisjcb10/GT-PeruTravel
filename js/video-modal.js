document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("video-modal");
    const iframe = document.getElementById("video-modal-iframe");
    const closeBtn = document.getElementById("video-modal-close");

    function toEmbedUrl(url) {
        // Convierte enlaces de YouTube normales a formato embed
        const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/);
        if (ytMatch) {
            return `https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1`;
        }
        return url;
    }

    document.querySelectorAll(".video-trigger").forEach(btn => {
        btn.addEventListener("click", () => {
            const url = btn.dataset.videoUrl;
            iframe.src = toEmbedUrl(url);
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        iframe.src = ""; // detiene la reproducción
    }

    closeBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });
});