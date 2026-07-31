<!-- Google Analytics 4 + Google Ads: carga ?nica global -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-X1PVK4XP7K"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){ dataLayer.push(arguments); }
gtag('js', new Date());
gtag('config', 'G-X1PVK4XP7K');
gtag('config', 'AW-17034229022');

// Todos los accesos a WhatsApp cuentan como lead en GA4 y Google Ads.
document.addEventListener('click', function(event) {
    const link = event.target.closest('a[href*="wa.me"]');
    if (!link) return;
    gtag('event', 'generate_lead', { method: 'whatsapp', link_url: link.href });
    gtag('event', 'conversion', { send_to: 'AW-17034229022/CXvjCMDS74scEJ7qxro_' });
});
</script>
