document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("verMasBtn");
    const extraDays = document.getElementById("dias-extra");
    if (!button || !extraDays) return;

    const language = document.documentElement.lang || "es";
    const labels = {
        es: { more: "Ver más días", less: "Ver menos días" },
        en: { more: "See more days", less: "See fewer days" },
        pt: { more: "Ver mais dias", less: "Ver menos dias" },
    }[language] || { more: "Ver más días", less: "Ver menos días" };

    button.addEventListener("click", () => {
        extraDays.classList.toggle("hidden");
        button.textContent = extraDays.classList.contains("hidden") ? labels.more : labels.less;
    });
});