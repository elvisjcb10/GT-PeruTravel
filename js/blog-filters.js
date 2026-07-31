document.addEventListener("DOMContentLoaded", () => {
    const filters = [...document.querySelectorAll(".blog-filter")];
    const cards = [...document.querySelectorAll("[data-blog-card]")];
    const recentCards = [...document.querySelectorAll(".blog-card[data-blog-card]")];
    const empty = document.getElementById("blog-empty");
    const featuredHeading = document.getElementById("blog-featured-heading");
    const featuredContent = document.getElementById("blog-featured-content");
    const featuredSection = document.getElementById("blog-featured-section");
    const filterToolbar = document.getElementById("blog-filter-toolbar");
    const recentSection = document.getElementById("blog-recent-section");
    const recentHeading = document.getElementById("blog-recent-heading");
    const pagination = document.getElementById("blog-pagination");
    const pageNumbers = document.getElementById("blog-page-numbers");
    const previousButton = document.getElementById("blog-page-prev");
    const nextButton = document.getElementById("blog-page-next");

    if (!filters.length || !recentCards.length) return;

    const language = document.documentElement.lang || "es";
    const pageLabel = {
        es: "Ir a la página ",
        en: "Go to page ",
        pt: "Ir para a página ",
    }[language] || "Ir a la página ";
    const pageSize = 9;
    let selectedFilter = "all";
    let currentPage = 1;

    const matchingCards = () => recentCards.filter(
        (card) => selectedFilter === "all" || card.dataset.category === selectedFilter
    );

    const paginationItems = (current, total) => {
        if (total <= 5) return Array.from({ length: total }, (_, index) => index + 1);
        const items = [1];
        const start = Math.max(2, current - 1);
        const end = Math.min(total - 1, current + 1);
        if (start > 2) items.push("ellipsis-start");
        for (let page = start; page <= end; page += 1) items.push(page);
        if (end < total - 1) items.push("ellipsis-end");
        items.push(total);
        return items;
    };

    const renderPageNumbers = (totalPages) => {
        if (!pageNumbers) return;
        pageNumbers.replaceChildren();

        paginationItems(currentPage, totalPages).forEach((item) => {
            if (typeof item !== "number") {
                const ellipsis = document.createElement("span");
                ellipsis.className = "flex h-10 min-w-6 items-center justify-center font-poppins text-xs text-gray-400";
                ellipsis.textContent = "…";
                pageNumbers.appendChild(ellipsis);
                return;
            }

            const button = document.createElement("button");
            const active = item === currentPage;
            button.type = "button";
            button.textContent = item;
            button.setAttribute("aria-label", pageLabel + item);
            if (active) button.setAttribute("aria-current", "page");
            button.className = active
                ? "flex h-10 min-w-10 items-center justify-center rounded-full bg-orange-custom px-3 font-poppins text-xs font-bold text-white shadow-sm"
                : "flex h-10 min-w-10 items-center justify-center rounded-full border border-gray-200 bg-white px-3 font-poppins text-xs font-semibold text-gray-600 transition hover:border-orange-custom hover:text-orange-custom";
            button.addEventListener("click", () => {
                currentPage = item;
                renderArticles(true);
            });
            pageNumbers.appendChild(button);
        });
    };

    const renderArticles = (scrollToResults = false) => {
        const matching = matchingCards();
        const totalPages = Math.max(1, Math.ceil(matching.length / pageSize));
        currentPage = Math.min(Math.max(currentPage, 1), totalPages);
        const start = (currentPage - 1) * pageSize;
        const visibleCards = new Set(matching.slice(start, start + pageSize));

        recentCards.forEach((card) => card.classList.toggle("hidden", !visibleCards.has(card)));
        const hasResults = matching.length > 0;
        empty?.classList.toggle("hidden", hasResults);
        pagination?.classList.toggle("hidden", !hasResults || totalPages <= 1);
        if (previousButton) previousButton.disabled = currentPage === 1;
        if (nextButton) nextButton.disabled = currentPage === totalPages;
        renderPageNumbers(totalPages);

        if (scrollToResults) {
            const scrollTarget = recentHeading && !recentHeading.classList.contains("hidden")
                ? recentHeading
                : recentSection;
            scrollTarget?.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    };

    const applyFilter = (button) => {
        selectedFilter = button.dataset.filter || "all";
        currentPage = 1;
        const showFeatured = selectedFilter === "all";

        featuredHeading?.classList.toggle("blog-featured-heading-filtered", !showFeatured);
        featuredContent?.classList.toggle("hidden", !showFeatured);
        recentHeading?.classList.toggle("hidden", !showFeatured);

        if (featuredSection) {
            featuredSection.style.paddingTop = "";
            featuredSection.style.paddingBottom = showFeatured ? "" : "0";
        }
        if (filterToolbar) filterToolbar.style.marginBottom = showFeatured ? "" : "0";
        if (recentSection) recentSection.style.paddingTop = showFeatured ? "" : "0.5rem";

        filters.forEach((item) => {
            const active = item === button;
            item.classList.toggle("active", active);
            item.classList.toggle("bg-orange-custom", active);
            item.classList.toggle("text-white", active);
            item.classList.toggle("border", !active);
            item.classList.toggle("border-gray-200", !active);
            item.classList.toggle("bg-white", !active);
            item.classList.toggle("text-gray-600", !active);
        });

        cards.filter((card) => !card.classList.contains("blog-card"))
            .forEach((card) => card.classList.toggle("hidden", !showFeatured));
        renderArticles(false);
    };

    filters.forEach((button) => button.addEventListener("click", () => applyFilter(button)));
    previousButton?.addEventListener("click", () => {
        if (currentPage <= 1) return;
        currentPage -= 1;
        renderArticles(true);
    });
    nextButton?.addEventListener("click", () => {
        const totalPages = Math.ceil(matchingCards().length / pageSize);
        if (currentPage >= totalPages) return;
        currentPage += 1;
        renderArticles(true);
    });

    applyFilter(filters.find((button) => button.classList.contains("active")) || filters[0]);
});