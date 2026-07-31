(() => {
    if (window.__gtMotionInitialized) return;
    window.__gtMotionInitialized = true;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const selector = [
        '.reveal', '.reveal-left', '.reveal-right', '.reveal-fade', '.reveal-zoom',
        'main > section:not(:first-child)',
        'main > article',
        'main > div:not(.fixed):not(.absolute)',
        'main article',
        '.tour-detail-section',
        '.faq-item',
        'main details',
        'main aside > div',
        'footer .grid > div'
    ].join(',');

    const shouldSkip = (element) =>
        element.closest('[hidden], .swiper-slide-duplicate') ||
        element.matches('.swiper, .swiper-wrapper, .swiper-slide, script, style');

    const prepare = (root = document) => {
        const elements = [...root.querySelectorAll(selector)].filter((element) => !shouldSkip(element));
        elements.forEach((element, index) => {
            if (!element.matches('.reveal, .reveal-left, .reveal-right, .reveal-fade, .reveal-zoom')) {
                element.classList.add('gt-reveal');
            }
            const siblingIndex = [...element.parentElement.children].indexOf(element);
            element.style.setProperty('--gt-reveal-delay', `${Math.min(siblingIndex, 4) * 70}ms`);
            if (reduceMotion) element.classList.add('reveal-visible');
        });
        return elements;
    };

    const start = () => {
        document.documentElement.classList.add('gt-motion-ready');
        const elements = prepare();
        if (reduceMotion || !('IntersectionObserver' in window)) {
            elements.forEach((element) => element.classList.add('reveal-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('reveal-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -35px 0px' });

        elements.forEach((element) => observer.observe(element));

        const mutations = new MutationObserver((records) => {
            records.forEach((record) => record.addedNodes.forEach((node) => {
                if (!(node instanceof Element)) return;
                prepare(node).forEach((element) => observer.observe(element));
            }));
        });
        mutations.observe(document.body, { childList: true, subtree: true });
    };

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, { once: true });
    else start();
})();
(() => {
    if (window.__gtCardMotionInitialized) return;
    window.__gtCardMotionInitialized = true;

    const cardSelector = [
        'main article',
        'main .group\\/card',
        'main .swiper-slide > a',
        'main .swiper-slide > article',
        'main .swiper-slide > div',
        'main [class*="rounded-2xl"][class*="shadow"]',
        'main [class*="rounded-xl"][class*="border"]',
        'main .grid > [class*="rounded"]',
        'main .grid > [class*="shadow"]',
        'main [class*="tour-card"]',
        'main [class*="package-card"]',
        'main [class*="destination-card"]',
        'main [class*="experience-card"]',
        'main [class*="video-card"]',
        'main [class*="blog-card"]',
        'main [class*="testimonial-card"]'
    ].join(',');

    const decorateCards = (root = document) => {
        const cards = [];
        if (root instanceof Element && root.matches(cardSelector)) cards.push(root);
        root.querySelectorAll?.(cardSelector).forEach((card) => cards.push(card));
        cards.forEach((card) => {
            if (card.closest('.page-hero, form, .tour-booking-sidebar, .tour-faq, .itinerario-item, nav, [role="tablist"]') ||
                card.matches('form, button, input, select, textarea, label, [role="tab"]') ||
                card.classList.contains('rounded-full')) return;

            const rect = card.getBoundingClientRect();
            const classes = typeof card.className === 'string' ? card.className : '';
            const hasCardCue = /card|rounded|shadow|border/i.test(classes) || card.querySelector('img, picture');
            if (!hasCardCue || (rect.width > 0 && rect.width < 150) || (rect.height > 0 && rect.height < 105)) return;
            card.classList.add('gt-motion-card');
        });
    };

    const startCards = () => {
        decorateCards();
        const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (finePointer && !reduceMotion) {
            document.addEventListener('pointermove', (event) => {
                const card = event.target.closest('.gt-motion-card');
                if (!card) return;
                const rect = card.getBoundingClientRect();
                const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
                const y = Math.max(0, Math.min(1, (event.clientY - rect.top) / rect.height));
                card.style.setProperty('--gt-card-rx', `${(0.5 - y) * 1.1}deg`);
                card.style.setProperty('--gt-card-ry', `${(x - 0.5) * 1.2}deg`);
                card.style.setProperty('--gt-card-x', `${x * 100}%`);
                card.style.setProperty('--gt-card-y', `${y * 100}%`);
            }, { passive: true });

            document.addEventListener('pointerout', (event) => {
                const card = event.target.closest('.gt-motion-card');
                if (!card || card.contains(event.relatedTarget)) return;
                card.style.removeProperty('--gt-card-rx');
                card.style.removeProperty('--gt-card-ry');
                card.style.removeProperty('--gt-card-x');
                card.style.removeProperty('--gt-card-y');
            }, { passive: true });
        }

        new MutationObserver((records) => records.forEach((record) =>
            record.addedNodes.forEach((node) => {
                if (node instanceof Element) decorateCards(node);
            })
        )).observe(document.body, { childList: true, subtree: true });
    };

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startCards, { once: true });
    else startCards();
})();