<?php require_once __DIR__ . '/../config/bootstrap.php'; ?>
<?php
$idioma = (string) ($_GET['lang'] ?? 'es');
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$articulo = (string) ($_GET['articulo'] ?? 'como-llegar-a-machu-picchu-guia-completa');
if (!preg_match('/\A[a-zA-Z0-9_-]{1,220}\z/D', $articulo)) {
    app_redirect('../404.php?lang=' . rawurlencode($idioma));
    exit;
}
$GLOBALS['lang'] = $idioma;
$blog_labels = [
    'es' => [
        'contents' => 'Contenido',
        'contents_label' => 'Contenido del artículo',
        'related' => 'Artículos relacionados',
        'keep_reading' => 'Seguir leyendo',
        'more_start' => 'Más artículos que te',
        'more_end' => 'pueden interesar',
        'load_error' => 'No se pudo cargar el artículo.',
    ],
    'en' => [
        'contents' => 'Contents',
        'contents_label' => 'Article contents',
        'related' => 'Related articles',
        'keep_reading' => 'Keep reading',
        'more_start' => 'More articles you may',
        'more_end' => 'be interested in',
        'load_error' => 'The article could not be loaded.',
    ],
    'pt' => [
        'contents' => 'Conteúdo',
        'contents_label' => 'Conteúdo do artigo',
        'related' => 'Artigos relacionados',
        'keep_reading' => 'Continue lendo',
        'more_start' => 'Mais artigos que podem',
        'more_end' => 'interessar você',
        'load_error' => 'Não foi possível carregar o artigo.',
    ],
];
$labels = $blog_labels[$idioma];
$base_url = '..';

$translation_map_path = __DIR__ . '/../data/blog/translations.json';
$translation_groups = file_exists($translation_map_path)
    ? (json_decode(file_get_contents($translation_map_path), true)['groups'] ?? [])
    : [];

$find_translation = static function (string $slug, string $target_language) use ($translation_groups): ?string {
    foreach ($translation_groups as $group) {
        if (in_array($slug, $group, true) && !empty($group[$target_language])) {
            return (string) $group[$target_language];
        }
    }
    return null;
};

$article_path = __DIR__ . "/../data/blog/{$articulo}.{$idioma}.json";
if (!file_exists($article_path)) {
    $translated_slug = $find_translation($articulo, $idioma);
    $translated_path = $translated_slug
        ? __DIR__ . "/../data/blog/{$translated_slug}.{$idioma}.json"
        : '';
    if ($translated_slug && file_exists($translated_path)) {
        app_redirect(route_path('blog', $idioma, $translated_slug), 301);
        exit;
    }
    app_redirect(route_static_path('blog', $idioma));
    exit;
}

$data = json_decode(file_get_contents($article_path), true);
route_redirect_legacy('blog', $idioma, $articulo);
if (!is_array($data)) {
    http_response_code(500);
    exit($labels['load_error']);
}

$article_language = (string) ($data['language'] ?? '');
if ($article_language === '') {
    $source_url = (string) ($data['source_url'] ?? '');
    $article_language = preg_match('~/blog/en(?:/|$)~i', $source_url)
        ? 'en'
        : (preg_match('~/blog/pt(?:/|$)~i', $source_url) ? 'pt' : 'es');
}
if ($article_language !== $idioma) {
    $translated_slug = $find_translation($articulo, $idioma);
    if ($translated_slug) {
        app_redirect(route_path('blog', $idioma, $translated_slug), 301);
        exit;
    }
    app_redirect(route_static_path('blog', $idioma));
    exit;
}

$footer_path = __DIR__ . "/../locale/{$idioma}/footer.json";
if (!file_exists($footer_path)) {
    $footer_path = __DIR__ . '/../locale/es/footer.json';
}
$footer = json_decode(file_get_contents($footer_path), true);

// Compatibilidad con los artículos migrados desde WordPress.
if (!empty($data['hero_image']) && !preg_match('~^https?://~i', (string) $data['hero_image'])) {
    $local_hero = __DIR__ . '/../' . ltrim((string) $data['hero_image'], '/');
    if (!file_exists($local_hero) && !empty($data['hero_image_remote'])) {
        $data['hero_image'] = $data['hero_image_remote'];
    }
}

$toc_items = !empty($data['sections'])
    ? array_map(fn($section) => ['id' => $section['id'], 'title' => $section['title']], $data['sections'])
    : ($data['toc'] ?? []);

$blog_index_path = __DIR__ . '/../data/blog/index.' . $idioma . '.json';
$blog_index = file_exists($blog_index_path)
    ? json_decode(file_get_contents($blog_index_path), true)
    : ['posts' => []];
$recommendations = array_values(array_filter($blog_index['posts'] ?? [], function ($post) use ($articulo) {
    return ($post['slug'] ?? '') !== $articulo;
}));
$category_recommendations = array_values(array_filter($recommendations, function ($post) use ($data) {
    return ($post['category'] ?? '') === ($data['category'] ?? '');
}));
$ordered_recommendations = array_merge($category_recommendations, $recommendations);
$seen_recommendations = [];
$ordered_recommendations = array_values(array_filter($ordered_recommendations, function ($post) use (&$seen_recommendations) {
    $slug = $post['slug'] ?? '';
    if ($slug === '' || isset($seen_recommendations[$slug])) return false;
    $seen_recommendations[$slug] = true;
    return true;
}));

$normalize_recommendation = function ($post) {
    $image = (string) ($post['image'] ?? '');
    if ($image === '' || !file_exists(__DIR__ . '/../' . ltrim($image, '/'))) {
        $image = (string) ($post['image_remote'] ?? '');
    }
    return [
        'slug' => $post['slug'] ?? '',
        'category' => $post['category'] ?? 'Blog',
        'title' => $post['title'] ?? '',
        'time' => $post['time'] ?? '',
        'date' => $post['date'] ?? '',
        'image' => $image,
    ];
};

if (empty($data['related'])) {
    $data['related'] = array_map($normalize_recommendation, array_slice($ordered_recommendations, 0, 3));
}
if (empty($data['more_articles'])) {
    $data['more_articles'] = array_map($normalize_recommendation, array_slice($ordered_recommendations, 3, 6));
}

if (!empty($data['content_html'])) {
    $data['content_html'] = preg_replace('~<h1(\s[^>]*)?>~i', '<h2$1>', $data['content_html']);
    $data['content_html'] = preg_replace('~</h1>~i', '</h2>', $data['content_html']);
    $data['content_html'] = preg_replace_callback(
        '~href="https?://(?:www\.)?gtperutravel\.com/blog/(?:en/|pt/)?([^/"#?]+)/*(?:[?#][^"]*)?"~i',
        static function ($matches) use ($idioma) {
            return 'href="' . route_path('blog', $idioma, (string)$matches[1]) . '"';
        },
        $data['content_html']
    );
    $data['content_html'] = preg_replace_callback(
        '~href="(https?://(?:www\.)?gtperutravel\.com/(?:tour|paquete|destino)/template-[^"]+\.php\?[^"]+)"~i',
        static function ($matches) use ($idioma) {
            return 'href="' . route_content_url((string)$matches[1], $idioma) . '"';
        },
        $data['content_html']
    );
}

function blog_image_url(string $path, string $base_url): string
{
    if (preg_match('~^https?://~i', $path)) {
        return $path;
    }
    return rtrim($base_url, '/') . '/' . ltrim($path, '/');
}

function blog_link_url(string $url, string $base_url): string
{
    if (preg_match('~^(?:https?://|mailto:|tel:)~i', $url)) {
        return $url;
    }
    return rtrim($base_url, '/') . '/' . ltrim($url, '/');
}

$seo_title = $data['seo']['title'] ?? $data['title'];
$seo_description = $data['seo']['description'] ?? $data['excerpt'];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($idioma) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?= htmlspecialchars(seo_clean_text((string)$seo_title, 65)) ?></title>
    <meta name="description" content="<?= htmlspecialchars(seo_clean_text((string)$seo_description, 160)) ?>">
    <?php seo_render([
        'title' => $seo_title, 'description' => $seo_description,
        'path' => route_path('blog', $idioma, $articulo), 'params' => [], 'language' => $idioma,
        'image' => (string)($data['hero_image'] ?? '/images/gt-peru-travel.png'), 'type' => 'article',
        'date_published' => (string)($data['date_iso'] ?? ''), 'date_modified' => (string)($data['modified_iso'] ?? $data['date_iso'] ?? ''), 'alternates' => route_blog_alternates($articulo, $idioma),
    ]); ?>
    <link rel="icon" href="../assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="blog-article-page bg-white text-gray-900">
    <?php include __DIR__ . '/../header.php'; ?>

    <main>
        <section class="relative flex min-h-[410px] items-end overflow-hidden bg-gray-950 sm:min-h-[480px] lg:min-h-[540px]">
            <img src="<?= htmlspecialchars(blog_image_url($data['hero_image'], $base_url)) ?>" loading="eager" fetchpriority="high" decoding="async"
                alt="<?= htmlspecialchars($data['title']) ?>"
                class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/55 to-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-black/20"></div>

            <div class="relative z-10 container-custom mx-auto w-full px-4 pb-9 pt-20 sm:px-6 sm:pb-12 sm:pt-24 md:px-10 lg:px-20 lg:pb-16">
                <div class="max-w-3xl">
                    <div class="hero-section-kicker">
                        <span class="hero-section-kicker__line" aria-hidden="true"></span>
                        <span><?= htmlspecialchars($data['category']) ?></span>
                    </div>
                    <h1 class="mt-4 font-poppins text-2xl font-bold leading-tight text-white min-[420px]:text-3xl sm:mt-5 sm:text-4xl md:text-5xl">
                        <?= htmlspecialchars($data['title']) ?>
                    </h1>

                    <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-3 font-poppins text-[0.68rem] text-white/75 sm:mt-6 sm:gap-x-4 sm:text-xs">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-custom font-bold text-white">
                            <?= htmlspecialchars($data['author']['initials']) ?>
                        </span>
                        <div>
                            <p class="font-semibold text-white"><?= htmlspecialchars($data['author']['name']) ?></p>
                            <p class="hidden text-[0.62rem] text-white/55 sm:block"><?= htmlspecialchars($data['author']['role']) ?></p>
                        </div>
                        <span class="hidden h-8 w-px bg-white/20 sm:block"></span>
                        <span><i class="fa-regular fa-calendar mr-1 text-orange-custom"></i><?= htmlspecialchars($data['date']) ?></span>
                        <span><i class="fa-regular fa-clock mr-1 text-orange-custom"></i><?= htmlspecialchars($data['reading_time']) ?></span>

                    </div>
                </div>
            </div>
        </section>

        <section class="py-7 sm:py-10 lg:py-14">
            <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-[minmax(0,1fr)_280px] lg:gap-12">
                    <article class="min-w-0">
                        <div class="mb-7 h-[3px] w-full bg-gradient-to-r from-orange-custom via-orange-custom/35 to-transparent"></div>

                        <details class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white lg:hidden">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-3.5 font-poppins text-xs font-bold uppercase tracking-[0.1em] text-orange-custom">
                                <?= htmlspecialchars($labels['contents_label']) ?>
                                <i class="fa-solid fa-chevron-down text-xs transition-transform"></i>
                            </summary>
                            <ol class="border-t border-gray-100 px-4 py-2">
                                <?php foreach ($toc_items as $index => $section): ?>
                                    <li>
                                        <a href="#<?= htmlspecialchars($section['id']) ?>" class="flex gap-3 border-b border-gray-100 py-3 font-poppins text-xs leading-5 text-gray-600 last:border-0">
                                            <span class="w-6 shrink-0 font-bold text-orange-custom"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                            <span class="min-w-0"><?= htmlspecialchars($section['title']) ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </details>

                        <p class="border-l-4 border-orange-custom pl-5 font-poppins text-sm italic leading-7 text-gray-600 sm:text-base sm:leading-8">
                            <?= htmlspecialchars($data['intro']) ?>
                        </p>

                        <?php if (!empty($data['content_html'])): ?>
                            <div class="wordpress-blog-content">
                                <?= $data['content_html'] ?>
                            </div>
                        <?php else: ?>
                        <?php foreach ($data['sections'] as $section_index => $section): ?>
                            <section id="<?= htmlspecialchars($section['id']) ?>" class="scroll-mt-28 pt-7">
                                <h2 class="border-b border-gray-200 pb-3 font-poppins text-xl font-bold leading-snug text-gray-900 sm:text-2xl">
                                    <?= htmlspecialchars($section['title']) ?>
                                </h2>

                                <div class="mt-4 space-y-4">
                                    <?php foreach (($section['paragraphs'] ?? []) as $paragraph): ?>
                                        <p class="font-poppins text-sm leading-7 text-gray-600 sm:text-[0.95rem] sm:leading-8">
                                            <?= htmlspecialchars($paragraph) ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>

                                <?php if ($section_index === 0 && !empty($data['facts'])): ?>
                                    <?php $facts_total = count($data['facts']); ?>
                                    <div class="mt-5 grid grid-cols-2 overflow-hidden rounded-xl bg-[#2b2b2b] shadow-sm lg:grid-cols-4">
                                        <?php foreach ($data['facts'] as $fact_index => $fact): ?>
                                            <div class="flex min-h-[96px] flex-col items-center justify-center px-3 py-4 text-center sm:min-h-[105px] sm:px-4 lg:min-h-[108px] lg:py-4
                                                <?= $fact_index % 2 === 0 ? 'border-r border-white/20' : '' ?>
                                                <?= $fact_index < $facts_total - 2 ? 'border-b border-white/20 lg:border-b-0' : '' ?>
                                                <?= $fact_index < $facts_total - 1 ? 'lg:border-r lg:border-white/20' : 'lg:border-r-0' ?>">
                                                <p class="font-poppins text-[0.58rem] font-semibold uppercase leading-4 tracking-[0.08em] text-white/55 sm:text-[0.65rem]">
                                                    <?= htmlspecialchars($fact['label']) ?>
                                                </p>
                                                <p class="mt-1.5 font-anton text-xl uppercase tracking-wide text-white sm:text-2xl lg:text-[1.35rem] xl:text-2xl">
                                                    <?= htmlspecialchars($fact['value']) ?>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($section['routes'])): ?>
                                    <div class="mt-6 space-y-5">
                                        <?php foreach ($section['routes'] as $route_index => $route): ?>
                                            <div class="grid grid-cols-[38px_1fr] gap-3 sm:grid-cols-[44px_1fr]">
                                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-custom font-poppins text-sm font-bold text-white sm:h-10 sm:w-10">
                                                    <?= $route_index + 1 ?>
                                                </span>
                                                <div>
                                                    <h3 class="font-poppins text-sm font-bold text-gray-900 sm:text-base"><?= htmlspecialchars($route['title']) ?></h3>
                                                    <p class="mt-1 font-poppins text-xs leading-6 text-gray-600 sm:text-sm"><?= htmlspecialchars($route['description']) ?></p>
                                                    <p class="mt-1 font-poppins text-[0.68rem] text-gray-400"><?= htmlspecialchars($route['meta']) ?></p>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($section['image'])): ?>
                                    <figure class="mt-7">
                                        <img src="<?= htmlspecialchars(blog_image_url($section['image'], $base_url)) ?>"
                                            alt="<?= htmlspecialchars($section['image_caption'] ?? $section['title']) ?>"
                                            class="aspect-[4/3] w-full rounded-xl object-cover sm:aspect-[16/8] lg:aspect-[16/7]">
                                        <?php if (!empty($section['image_caption'])): ?>
                                            <figcaption class="mt-2 text-center font-poppins text-[0.65rem] italic text-gray-400">
                                                <?= htmlspecialchars($section['image_caption']) ?>
                                            </figcaption>
                                        <?php endif; ?>
                                    </figure>
                                <?php endif; ?>

                                <?php if (!empty($section['tip'])): ?>
                                    <div class="mt-7 rounded-xl border border-orange-200 bg-orange-50/60 p-5">
                                        <p class="font-poppins text-[0.65rem] font-bold uppercase tracking-[0.13em] text-orange-custom">
                                            <i class="fa-regular fa-lightbulb mr-2"></i><?= htmlspecialchars($section['tip']['title']) ?>
                                        </p>
                                        <p class="mt-2 font-poppins text-sm leading-7 text-gray-600"><?= htmlspecialchars($section['tip']['text']) ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($section['quote'])): ?>
                                    <blockquote class="mt-7 rounded-xl border border-gray-200 bg-[#faf9f6] px-6 py-7 text-center">
                                        <p class="font-poppins text-sm italic leading-7 text-gray-600 sm:text-base">
                                            “<?= htmlspecialchars($section['quote']) ?>”
                                        </p>
                                        <footer class="mt-3 font-poppins text-xs font-semibold text-orange-custom">
                                            — <?= htmlspecialchars($data['author']['name']) ?>
                                        </footer>
                                    </blockquote>
                                <?php endif; ?>
                            </section>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($data['tags'])): ?>
                            <div class="mt-8 flex flex-wrap gap-2 border-t border-gray-200 pt-6">
                                <?php foreach ($data['tags'] as $tag): ?>
                                    <span class="rounded-full border border-gray-200 bg-[#fafafa] px-3 py-1.5 font-poppins text-[0.65rem] text-gray-500">
                                        # <?= htmlspecialchars($tag) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="mt-7 flex flex-col items-start gap-4 rounded-xl border border-gray-200 bg-[#faf9f6] p-5 min-[420px]:flex-row sm:p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-orange-custom font-poppins font-bold text-white">
                                <?= htmlspecialchars($data['author']['initials']) ?>
                            </span>
                            <div>
                                <p class="font-poppins text-sm font-bold text-gray-900"><?= htmlspecialchars($data['author']['name']) ?></p>
                                <p class="mt-1 font-poppins text-[0.68rem] font-semibold text-orange-custom">
                                    <?= htmlspecialchars($data['author']['role']) ?> · <?= htmlspecialchars($data['author']['location']) ?>
                                </p>
                                <p class="mt-2 font-poppins text-xs leading-6 text-gray-500"><?= htmlspecialchars($data['author']['bio']) ?></p>
                            </div>
                        </div>
                    </article>

                    <aside class="min-w-0">
                        <div class="space-y-5 lg:sticky lg:top-24">
                            <nav class="hidden rounded-xl border border-gray-200 bg-white p-5 lg:block" aria-label="<?= htmlspecialchars($labels['contents_label']) ?>">
                                <p class="font-poppins text-[0.65rem] font-bold uppercase tracking-[0.14em] text-orange-custom"><?= htmlspecialchars($labels['contents']) ?></p>
                                <ol class="mt-4 space-y-1">
                                    <?php foreach ($toc_items as $index => $section): ?>
                                        <li>
                                            <a href="#<?= htmlspecialchars($section['id']) ?>"
                                                class="group flex gap-3 border-b border-gray-100 py-2.5 font-poppins text-xs leading-5 text-gray-500 transition ">
                                                <span class="w-6 shrink-0 whitespace-nowrap font-bold text-orange-custom"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                                <span class="min-w-0"><?= htmlspecialchars($section['title']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>
                            </nav>

                            <?php if (!empty($data['cta'])): ?>
                                <div class="rounded-xl bg-[#2b2b2b] p-6 text-center text-white">
                                    <i class="fa-solid fa-route text-3xl text-orange-custom"></i>
                                    <h2 class="mt-4 font-poppins text-base font-bold"><?= htmlspecialchars($data['cta']['title']) ?></h2>
                                    <p class="mt-2 font-poppins text-xs leading-5 text-white/60"><?= htmlspecialchars($data['cta']['text']) ?></p>
                                    <a href="<?= htmlspecialchars(blog_link_url($data['cta']['url'], $base_url)) ?>"
                                        class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-orange-custom px-4 py-3 font-poppins text-xs font-bold text-white transition ">
                                        <?= htmlspecialchars($data['cta']['button']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($data['related'])): ?>
                                <div class="rounded-xl border border-gray-200 bg-white p-5">
                                    <p class="font-poppins text-[0.65rem] font-bold uppercase tracking-[0.14em] text-orange-custom"><?= htmlspecialchars($labels['related']) ?></p>
                                    <div class="mt-4 space-y-4">
                                        <?php foreach ($data['related'] as $related): ?>
                                            <a href="<?= route_path('blog', $idioma, (string)($related['slug'] ?? '')) ?>" class="grid grid-cols-[70px_1fr] gap-3 rounded-lg transition ">
                                                <img src="<?= htmlspecialchars(blog_image_url($related['image'], $base_url)) ?>"
                                                    alt="<?= htmlspecialchars($related['title']) ?>"
                                                    class="h-16 w-full rounded-lg object-cover">
                                                <div>
                                                    <p class="font-poppins text-[0.58rem] font-bold uppercase tracking-wide text-orange-custom"><?= htmlspecialchars($related['category']) ?></p>
                                                    <p class="mt-1 line-clamp-2 font-poppins text-[0.7rem] font-semibold leading-4 text-gray-800"><?= htmlspecialchars($related['title']) ?></p>
                                                    <p class="mt-1 font-poppins text-[0.6rem] text-gray-400"><?= htmlspecialchars($related['time']) ?></p>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <?php if (!empty($data['more_articles'])): ?>
            <section class="border-t border-gray-100 bg-[#fafafa] py-12 sm:py-14">
                <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                    <p class="section-kicker font-poppins text-xs font-bold uppercase tracking-wide text-orange-custom"><?= htmlspecialchars($labels['keep_reading']) ?></p>
                    <h2 class="mt-2 mb-7 font-anton text-3xl text-gray-900 sm:text-4xl">
                        <?= htmlspecialchars($labels['more_start']) ?> <span class="text-orange-custom"><?= htmlspecialchars($labels['more_end']) ?></span>
                    </h2>
                    <div class="swiper-outer">
                        <div class="auto-swiper relative" data-desktop="3" data-tablet="2" data-mobile="1" data-gap="20" data-autoplay="true">
                            <div class="swiper-wrapper">
                                <?php foreach ($data['more_articles'] as $item): ?>
                                    <div class="swiper-slide h-auto">
                                        <a href="<?= route_path('blog', $idioma, (string)($item['slug'] ?? '')) ?>" class="group block h-full overflow-hidden rounded-xl border border-gray-200 bg-white transition  ">
                                            <div class="h-44 overflow-hidden">
                                                <img src="<?= htmlspecialchars(blog_image_url($item['image'], $base_url)) ?>"
                                                    alt="<?= htmlspecialchars($item['title']) ?>"
                                                    class="h-full w-full object-cover transition duration-500 ">
                                            </div>
                                            <div class="p-4">
                                                <p class="font-poppins text-[0.6rem] font-bold uppercase tracking-[0.12em] text-orange-custom"><?= htmlspecialchars($item['category']) ?></p>
                                                <h3 class="mt-2 font-poppins text-sm font-bold leading-5 text-gray-900"><?= htmlspecialchars($item['title']) ?></h3>
                                                <p class="mt-3 font-poppins text-[0.65rem] text-gray-400"><?= htmlspecialchars($item['time']) ?> · <?= htmlspecialchars($item['date']) ?></p>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../footer.php'; ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="../js/mobile-menu.js"></script>
    <script src="../js/auto-swiper.js"></script>
    <script src="../js/mega-menu.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const target = document.querySelector(link.getAttribute('href'));
                if (!target) return;
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>
