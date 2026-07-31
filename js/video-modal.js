document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("video-modal");
    const iframe = document.getElementById("video-modal-iframe");
    const closeBtn = document.getElementById("video-modal-close");
    const triggers = document.querySelectorAll(".video-trigger");

    if (!modal || !iframe || !closeBtn || !triggers.length) return;

    function toEmbedUrl(url) {
        const ytMatch = String(url).match(/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([\w-]+)/);
        if (ytMatch) {
            return `https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1&rel=0`;
        }
        return url;
    }

    function openModal(url) {
        iframe.src = toEmbedUrl(url);
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        document.body.style.overflow = "hidden";
        closeBtn.focus();
    }

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        iframe.src = "";
        document.body.style.overflow = "";
    }

    triggers.forEach(btn => {
        btn.addEventListener("click", () => openModal(btn.dataset.videoUrl));
    });

    closeBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", event => {
        if (event.target === modal) closeModal();
    });
    document.addEventListener("keydown", event => {
        if (event.key === "Escape" && !modal.classList.contains("hidden")) closeModal();
    });
});