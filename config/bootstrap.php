<?php
declare(strict_types=1);

$app_environment = strtolower((string) (getenv('APP_ENV') ?: 'production'));
$app_is_development = in_array($app_environment, ['local', 'development', 'dev'], true);

if (!function_exists('app_optimize_html')) {
    function app_optimize_html(string $html): string
    {
        if (stripos($html, '<html') === false || stripos($html, '<img') === false) return $html;
        static $dimensions = null;
        if ($dimensions === null) {
            $file = dirname(__DIR__) . '/data/image-dimensions.json';
            $dimensions = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
        }
        return (string) preg_replace_callback('~<img\b[^>]*>~i', static function (array $match) use ($dimensions): string {
            $tag = $match[0]; $src = '';
            if (preg_match('~\bsrc\s*=\s*(["\'])(.*?)\1~i', $tag, $srcMatch)) $src = html_entity_decode($srcMatch[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $path = rawurldecode((string) (parse_url($src, PHP_URL_PATH) ?: '')); $attrs = [];
            if (!preg_match('~\balt\s*=~i', $tag)) $attrs[] = 'alt=""';
            if (!preg_match('~\bdecoding\s*=~i', $tag)) $attrs[] = 'decoding="async"';
            $hero = preg_match('~\b(?:hero|tour-hero)\b~i', $tag) === 1 || preg_match('~\bfetchpriority\s*=\s*["\']high["\']~i', $tag) === 1;
            $eager = $hero || preg_match('~/(?:gt-peru-travel|es|en|pt)\.png$~i', $path) === 1;
            if (!preg_match('~\bloading\s*=~i', $tag)) $attrs[] = $eager ? 'loading="eager"' : 'loading="lazy"';
            if ($hero && !preg_match('~\bfetchpriority\s*=~i', $tag)) $attrs[] = 'fetchpriority="high"';
            $hasWidth = preg_match('~\bwidth\s*=~i', $tag) === 1;
            $hasHeight = preg_match('~\bheight\s*=~i', $tag) === 1;
            if (!$hasWidth && !$hasHeight && $path !== '' && isset($dimensions[$path]) && is_array($dimensions[$path])) {
                $attrs[] = 'width="' . (int) $dimensions[$path][0] . '"';
                $attrs[] = 'height="' . (int) $dimensions[$path][1] . '"';
            }
            return $attrs ? (preg_replace('~\s*/?>$~', ' ' . implode(' ', $attrs) . '>', $tag) ?: $tag) : $tag;
        }, $html);
    }
}

if (!in_array('app_optimize_html', ob_list_handlers(), true)) {
    ob_start('app_optimize_html');
}

if (!function_exists('app_finalize_html')) {
    function app_finalize_html(string $html): string
    {
        if (stripos($html, '<html') === false) return $html;
        $html = (string) preg_replace('~<!--(?!\[if).*?-->~s', '', $html);
        $root = dirname(__DIR__);
        $html = (string) preg_replace_callback('~\b(src|href)=(["\'])([^"\']+\.(?:css|js))\2~i', static function (array $match) use ($root): string {
            $url = html_entity_decode($match[3], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ((string) parse_url($url, PHP_URL_HOST) !== '' || str_contains($url, '?')) return $match[0];
            $path = (string) (parse_url($url, PHP_URL_PATH) ?: '');
            $relative = preg_replace('~^(?:\.\./)+~', '', ltrim($path, '/')) ?: '';
            $file = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            return is_file($file) ? $match[1] . '=' . $match[2] . $url . '?v=' . filemtime($file) . $match[2] : $match[0];
        }, $html);
        if (!preg_match('~<link\b[^>]*rel=["\']preload["\'][^>]*as=["\']image["\']~i', $html) && preg_match('~<img\b(?=[^>]*fetchpriority=["\']high["\'])[^>]*src=["\']([^"\']+)["\']~i', $html, $heroMatch)) {
            $preload = '<link rel="preload" as="image" href="' . htmlspecialchars(html_entity_decode($heroMatch[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8') . '">';
            $html = (string) preg_replace('~</head>~i', $preload . "\n</head>", $html, 1);
        }
        return $html;
    }
}
if (!in_array('app_finalize_html', ob_list_handlers(), true)) ob_start('app_finalize_html');
if (!function_exists('app_redirect')) {
    function app_redirect(string $location, int $status = 302): void
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Location: ' . $location, true, $status);
        exit;
    }
}

error_reporting(E_ALL);
ini_set('display_errors', $app_is_development ? '1' : '0');
ini_set('display_startup_errors', $app_is_development ? '1' : '0');
ini_set('log_errors', '1');

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
    header('Cross-Origin-Opener-Policy: same-origin-allow-popups');
    $contentSecurityPolicy = "default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://connect.facebook.net https://www.googletagmanager.com https://www.google.com https://www.gstatic.com https://www.youtube.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://fonts.googleapis.com; font-src 'self' data: https://cdnjs.cloudflare.com https://fonts.gstatic.com; img-src 'self' data: blob: https:; media-src 'self' blob:; frame-src 'self' https://www.google.com https://www.youtube.com https://www.youtube-nocookie.com; connect-src 'self' https://www.google.com https://www.google-analytics.com https://region1.google-analytics.com https://www.googletagmanager.com https://googleads.g.doubleclick.net https://www.facebook.com https://ipapi.co";
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') $contentSecurityPolicy .= '; upgrade-insecure-requests';
    header('Content-Security-Policy: ' . $contentSecurityPolicy);
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}
require_once __DIR__ . '/../includes/seo.php';

require_once __DIR__ . '/../includes/routes.php';
