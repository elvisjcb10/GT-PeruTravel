<?php require_once __DIR__ . '/config/bootstrap.php'; ?>
<?php
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}

$base_url = '.';
$GLOBALS['lang'] = $idioma;
route_redirect_static('blog', $idioma);

$footer_path = __DIR__ . "/locale/{$idioma}/footer.json";
if (!file_exists($footer_path)) {
    $footer_path = __DIR__ . '/locale/es/footer.json';
}
$footer = json_decode(file_get_contents($footer_path), true);

$textos = [
    'es' => [
        'meta_title' => 'Blog de viajes por Perú | GT Peru Travel',
        'meta_description' => 'Guías de viaje, consejos prácticos y experiencias auténticas para descubrir Cusco, Machu Picchu y los Andes del Perú.',
        'hero_kicker' => 'Blog de viajeros',
        'hero_title_1' => 'Inspiración para tu',
        'hero_title_2' => 'próxima aventura',
        'hero_description' => 'Guías de viaje, consejos prácticos y experiencias auténticas desde los Andes del Perú. Todo lo que necesitas saber antes de partir.',
        'featured_kicker' => 'Destacado',
        'featured_title_1' => 'Artículos',
        'featured_title_2' => 'Principales',
        'recent_kicker' => 'Recientes',
        'recent_title_1' => 'Todos los',
        'recent_title_2' => 'Artículos',
        'all' => 'Todos',
        'new' => 'Nuevo',
        'read' => 'Leer artículo',
        'destinations' => 'Destinos',
        'travelers' => 'Viajeros',
        'rating' => 'Calificación',
        'experience' => 'Años de exp.',
    ],
    'en' => [
        'meta_title' => 'Peru travel blog | GT Peru Travel',
        'meta_description' => 'Travel guides, practical advice and authentic experiences for exploring Cusco, Machu Picchu and the Peruvian Andes.',
        'hero_kicker' => 'Travelers blog',
        'hero_title_1' => 'Inspiration for your',
        'hero_title_2' => 'next adventure',
        'hero_description' => 'Travel guides, practical advice and authentic experiences from the Peruvian Andes. Everything you need to know before you go.',
        'featured_kicker' => 'Featured',
        'featured_title_1' => 'Main',
        'featured_title_2' => 'Articles',
        'recent_kicker' => 'Recent',
        'recent_title_1' => 'All',
        'recent_title_2' => 'Articles',
        'all' => 'All',
        'new' => 'New',
        'read' => 'Read article',
        'destinations' => 'Destinations',
        'travelers' => 'Travelers',
        'rating' => 'Rating',
        'experience' => 'Years of exp.',
    ],
    'pt' => [
        'meta_title' => 'Blog de viagens pelo Peru | GT Peru Travel',
        'meta_description' => 'Guias de viagem, conselhos práticos e experiências autênticas para descobrir Cusco, Machu Picchu e os Andes peruanos.',
        'hero_kicker' => 'Blog de viajantes',
        'hero_title_1' => 'Inspiração para sua',
        'hero_title_2' => 'próxima aventura',
        'hero_description' => 'Guias de viagem, conselhos práticos e experiências autênticas dos Andes peruanos. Tudo o que você precisa saber antes de viajar.',
        'featured_kicker' => 'Destaque',
        'featured_title_1' => 'Artigos',
        'featured_title_2' => 'Principais',
        'recent_kicker' => 'Recentes',
        'recent_title_1' => 'Todos os',
        'recent_title_2' => 'Artigos',
        'all' => 'Todos',
        'new' => 'Novo',
        'read' => 'Ler artigo',
        'destinations' => 'Destinos',
        'travelers' => 'Viajantes',
        'rating' => 'Avaliação',
        'experience' => 'Anos de exp.',
    ],
][$idioma];

$blog_index_path = __DIR__ . "/data/blog/index.{$idioma}.json";
if (!file_exists($blog_index_path)) {
    $blog_index_path = __DIR__ . '/data/blog/index.es.json';
}
$blog_index = file_exists($blog_index_path)
    ? json_decode(file_get_contents($blog_index_path), true)
    : ['posts' => []];
$posts = array_values($blog_index['posts'] ?? []);
$unique_posts = [];
$seen_post_titles = [];
foreach ($posts as $post) {
    $title_key = trim(mb_strtolower(html_entity_decode(strip_tags((string) ($post['title'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8'), 'UTF-8'));
    $title_key = preg_replace('/\s+/u', ' ', $title_key);
    if ($title_key === '' || isset($seen_post_titles[$title_key])) {
        continue;
    }
    $seen_post_titles[$title_key] = true;
    $unique_posts[] = $post;
}
$posts = $unique_posts;

function blog_listing_image(array $post, string $base_url): string
{
    $image = (string) ($post['image'] ?? '');
    if ($image !== '' && file_exists(__DIR__ . '/' . ltrim($image, '/'))) {
        return rtrim($base_url, '/') . '/' . ltrim($image, '/');
    }
    $remote = (string) ($post['image_remote'] ?? '');
    return $remote !== '' ? $remote : rtrim($base_url, '/') . '/images/blog/1.webp';
}

if (empty($posts)) {
    $posts[] = [
        'slug' => 'como-llegar-a-machu-picchu-guia-completa',
        'category' => 'Machu Picchu',
        'title' => 'Cómo llegar a Machu Picchu: guía completa',
        'excerpt' => 'Todo lo que necesitas saber para organizar tu visita.',
        'image' => 'images/blog/1.webp',
        'image_remote' => '',
        'author' => 'GT Peru Travel',
        'initials' => 'GT',
        'date' => '',
        'time' => '8 min'
    ];
}
$categories = array_values(array_unique(array_column($posts, 'category')));
$featured = $posts[0];
$secondary_featured = array_slice($posts, 1, 3);
$recent_posts = array_slice($posts, 4);
$detail_slug = $featured['slug'];

$selected_category = trim((string) ($_GET['category'] ?? 'all'));
if ($selected_category !== 'all' && !in_array($selected_category, $categories, true)) {
    $selected_category = 'all';
}

$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1],
]);
if (!is_int($page) || $page < 1) {
    $page = 1;
}

$pagination_source = $selected_category === 'all'
    ? $recent_posts
    : array_values(array_filter($posts, static fn(array $post): bool => ($post['category'] ?? '') === $selected_category));

$posts_per_page = 9;
$total_articles = count($pagination_source);
$total_pages = max(1, (int) ceil($total_articles / $posts_per_page));
$page = min($page, $total_pages);
$page_posts = array_slice($pagination_source, ($page - 1) * $posts_per_page, $posts_per_page);
$show_featured = $selected_category === 'all' && $page === 1;

$pagination_text = [
    'es' => ['previous' => 'Anterior', 'next' => 'Siguiente', 'page' => 'Página', 'empty' => 'No hay artículos en esta categoría.', 'filter' => 'Filtrar artículos'],
    'en' => ['previous' => 'Previous', 'next' => 'Next', 'page' => 'Page', 'empty' => 'There are no articles in this category.', 'filter' => 'Filter articles'],
    'pt' => ['previous' => 'Anterior', 'next' => 'Próxima', 'page' => 'Página', 'empty' => 'Não há artigos nesta categoria.', 'filter' => 'Filtrar artigos'],
][$idioma];

function blog_page_url(string $base_url, string $language, string $category, int $page): string
{
    $query = ['lang' => $language];
    if ($category !== 'all') {
        $query['category'] = $category;
    }
    if ($page > 1) {
        $query['page'] = $page;
    }
    unset($query['lang']);
    return route_static_path('blog', $language) . ($query ? '?' . http_build_query($query) : '') . '#blog-recent-section';
}

function blog_pagination_items(int $current, int $total): array
{
    if ($total <= 5) {
        return range(1, $total);
    }
    $items = [1];
    $start = max(2, $current - 1);
    $end = min($total - 1, $current + 1);
    if ($start > 2) $items[] = null;
    for ($number = $start; $number <= $end; $number++) $items[] = $number;
    if ($end < $total - 1) $items[] = null;
    $items[] = $total;
    return $items;
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($idioma) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?= htmlspecialchars(seo_clean_text((string)$textos['meta_title'], 65)) ?></title>
    <meta name="description" content="<?= htmlspecialchars($textos['meta_description']) ?>">
    <?php
    $blog_seo_params = ['lang' => $idioma];
    if ($selected_category !== 'all') $blog_seo_params['category'] = $selected_category;
    if ($page > 1) $blog_seo_params['page'] = $page;
    seo_render([
        'title' => $textos['meta_title'], 'description' => $textos['meta_description'],
        'path' => route_static_path('blog', $idioma), 'params' => array_diff_key($blog_seo_params, ['lang' => true]), 'language' => $idioma,
        'image' => '/images/glaciares/hero.webp',
        'alternates' => $selected_category === 'all' ? route_static_alternates('blog', $page > 1 ? ['page' => $page] : []) : [],
    ]); ?>
    <link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/tailwind.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="blog-page bg-white">
    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <section class="page-hero page-hero--with-stats responsive-hero relative w-full overflow-hidden bg-black">
            <img src="<?= $base_url ?>/images/glaciares/hero.webp" loading="eager" fetchpriority="high" decoding="async"
                alt="<?= htmlspecialchars($textos['hero_title_1'] . ' ' . $textos['hero_title_2']) ?>"
                class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/10"></div>

            <div class="page-hero-content relative z-10 flex h-full items-center">
                <div class="container-custom mx-auto w-full px-4 sm:px-6 md:px-10 lg:px-20">
                    <div class="max-w-2xl">
                        <div class="hero-section-kicker mb-4">
                            <span class="hero-section-kicker__line" aria-hidden="true"></span>
                            <span><?= htmlspecialchars($textos['hero_kicker']) ?></span>
                        </div>
                        <h1 class="font-anton text-4xl leading-[1.05] text-white sm:text-5xl md:text-6xl lg:text-7xl">
                            <?= htmlspecialchars($textos['hero_title_1']) ?><br>
                            <span class="text-orange-custom"><?= htmlspecialchars($textos['hero_title_2']) ?></span>
                        </h1>
                        <p class="mt-5 max-w-xl font-poppins text-sm leading-7 text-white/85 sm:text-base md:text-lg">
                            <?= htmlspecialchars($textos['hero_description']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="page-hero-stats absolute bottom-0 left-0 z-10 w-full bg-black/30 backdrop-blur-md">
                <div class="container-custom mx-auto grid grid-cols-2 gap-4 px-4 py-4 sm:grid-cols-4 sm:px-6 md:px-10 lg:px-20">
                    <?php
                    $stats = [
                        ['icon' => 'fa-mountain-sun', 'number' => '150+', 'label' => $textos['destinations']],
                        ['icon' => 'fa-user-group', 'number' => '12K+', 'label' => $textos['travelers']],
                        ['icon' => 'fa-star', 'number' => '4.9', 'label' => $textos['rating']],
                        ['icon' => 'fa-earth-americas', 'number' => '10+', 'label' => $textos['experience']],
                    ];
                    foreach ($stats as $stat):
                    ?>
                        <div class="flex items-center justify-center gap-3">
                            <i class="fa-solid <?= $stat['icon'] ?> text-lg text-orange-custom sm:text-xl"></i>
                            <div>
                                <p class="font-anton text-xl leading-none text-orange-custom sm:text-2xl"><?= $stat['number'] ?></p>
                                <p class="mt-1 font-poppins text-[0.6rem] uppercase tracking-wide text-white/65 sm:text-xs"><?= htmlspecialchars($stat['label']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="blog-featured-section" class="<?= $show_featured ? 'py-12 sm:py-14 lg:py-16' : 'pt-8 pb-0 sm:pt-10' ?>">
            <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <div id="blog-filter-toolbar" class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div id="blog-featured-heading" class="<?= $show_featured ? 'order-2 lg:order-1' : 'hidden' ?>">
                        <p class="section-kicker font-poppins text-xs font-bold uppercase tracking-wide text-orange-custom sm:text-sm">
                            <?= htmlspecialchars($textos['featured_kicker']) ?>
                        </p>
                        <h2 class="mt-2 font-anton text-3xl text-gray-900 sm:text-4xl">
                            <?= htmlspecialchars($textos['featured_title_1']) ?>
                            <span class="text-orange-custom"><?= htmlspecialchars($textos['featured_title_2']) ?></span>
                        </h2>
                    </div>

                    <div class="blog-filter-list order-1 flex gap-2 overflow-x-auto pb-2 lg:order-2 lg:ml-auto lg:justify-end lg:pb-0" role="group" aria-label="<?= htmlspecialchars($pagination_text['filter']) ?>">
                        <a href="<?= htmlspecialchars(route_static_path('blog', $idioma)) ?>"
                            class="blog-filter shrink-0 rounded-full px-5 py-2.5 font-poppins text-xs font-semibold transition <?= $selected_category === 'all' ? 'bg-orange-custom text-white' : 'border border-gray-200 bg-white text-gray-600  ' ?>">
                            <?= htmlspecialchars($textos['all']) ?>
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <a href="<?= htmlspecialchars(blog_page_url($base_url, $idioma, $category, 1)) ?>"
                                class="blog-filter shrink-0 rounded-full px-5 py-2.5 font-poppins text-xs font-semibold transition <?= $selected_category === $category ? 'bg-orange-custom text-white' : 'border border-gray-200 bg-white text-gray-600  ' ?>">
                                <?= htmlspecialchars($category) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($show_featured): ?>
                <div id="blog-featured-content" class="grid grid-cols-1 gap-5 lg:grid-cols-[1.65fr_1fr]">
                    <article class="group relative min-h-[360px] overflow-hidden rounded-2xl bg-gray-900 sm:min-h-[430px]" data-blog-card data-category="<?= htmlspecialchars($featured['category']) ?>">
                        <a href="<?= route_path('blog', $idioma, (string)($featured['slug'])) ?>"
                            class="absolute inset-0 z-20"
                            aria-label="<?= htmlspecialchars($textos['read'] . ': ' . $featured['title']) ?>"></a>
                        <img src="<?= blog_listing_image($featured, $base_url) ?>" alt="<?= htmlspecialchars($featured['title']) ?>"
                            class="absolute inset-0 h-full w-full object-cover transition duration-700 ">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-5 sm:p-7">
                            <span class="inline-flex rounded-md bg-orange-custom px-3 py-1.5 font-poppins text-[0.65rem] font-bold text-white">
                                <?= htmlspecialchars($featured['category']) ?>
                            </span>
                            <h3 class="mt-3 max-w-2xl font-poppins text-xl font-bold leading-snug text-white sm:text-2xl">
                                <?= htmlspecialchars($featured['title']) ?>
                            </h3>
                            <p class="mt-2 hidden max-w-2xl font-poppins text-sm leading-6 text-white/70 sm:block">
                                <?= htmlspecialchars($featured['excerpt']) ?>
                            </p>
                            <div class="mt-4 flex flex-wrap items-center gap-3 font-poppins text-xs text-white/70">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-custom font-bold text-white"><?= $featured['initials'] ?></span>
                                <span><?= htmlspecialchars($featured['author']) ?></span>
                                <span>•</span>
                                <span><?= htmlspecialchars($featured['date']) ?></span>
                                <span>•</span>
                                <span><?= htmlspecialchars($featured['time']) ?></span>
                            </div>
                        </div>
                    </article>

                    <div class="grid gap-4">
                        <?php foreach ($secondary_featured as $post): ?>
                            <article class="group relative grid min-h-[125px] grid-cols-[120px_1fr] overflow-hidden rounded-xl border border-gray-200 bg-white transition   sm:grid-cols-[155px_1fr]" data-blog-card data-category="<?= htmlspecialchars($post['category']) ?>">
                                <a href="<?= route_path('blog', $idioma, (string)($post['slug'])) ?>" class="absolute inset-0 z-10" aria-label="<?= htmlspecialchars($textos['read'] . ': ' . $post['title']) ?>"></a>
                                <div class="overflow-hidden">
                                    <img src="<?= blog_listing_image($post, $base_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                                        loading="lazy" class="h-full w-full object-cover transition duration-500 ">
                                </div>
                                <div class="flex min-w-0 flex-col justify-center p-4">
                                    <p class="font-poppins text-[0.62rem] font-bold uppercase tracking-[0.12em] text-orange-custom"><?= htmlspecialchars($post['category']) ?></p>
                                    <h3 class="mt-1 line-clamp-2 font-poppins text-sm font-bold leading-5 text-gray-900"><?= htmlspecialchars($post['title']) ?></h3>
                                    <p class="mt-2 font-poppins text-[0.65rem] text-gray-400"><?= htmlspecialchars($post['time']) ?> · <?= htmlspecialchars($post['date']) ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <section id="blog-recent-section" class="bg-[#fafafa] py-12 sm:py-14 lg:py-16">
            <div class="container-custom mx-auto px-4 sm:px-6 md:px-10 lg:px-20">
                <div id="blog-recent-heading" class="<?= $selected_category === 'all' ? '' : 'hidden' ?>">
                <p class="section-kicker font-poppins text-xs font-bold uppercase tracking-wide text-orange-custom sm:text-sm">
                    <?= htmlspecialchars($textos['recent_kicker']) ?>
                </p>
                <h2 class="mt-2 mb-8 font-anton text-3xl text-gray-900 sm:text-4xl">
                    <?= htmlspecialchars($textos['recent_title_1']) ?>
                    <span class="text-orange-custom"><?= htmlspecialchars($textos['recent_title_2']) ?></span>
                </h2>
                </div>

                <div id="blog-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($page_posts as $post): ?>
                        <article id="<?= htmlspecialchars($post['slug']) ?>" class="blog-card group relative flex h-full flex-col overflow-hidden rounded-xl border border-gray-200 bg-white transition duration-300   " data-blog-card data-category="<?= htmlspecialchars($post['category']) ?>">
                            <a href="<?= route_path('blog', $idioma, (string)($post['slug'])) ?>" class="absolute inset-0 z-20" aria-label="<?= htmlspecialchars($textos['read'] . ': ' . $post['title']) ?>"></a>
                            <div class="relative h-52 overflow-hidden sm:h-56">
                                <img src="<?= blog_listing_image($post, $base_url) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                                    loading="lazy" class="h-full w-full object-cover transition duration-500 ">
                                <span class="absolute left-3 top-3 rounded-md bg-orange-custom px-3 py-1.5 font-poppins text-[0.65rem] font-bold text-white">
                                    <?= htmlspecialchars($textos['new']) ?>
                                </span>
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <p class="font-poppins text-[0.65rem] font-bold uppercase tracking-[0.13em] text-orange-custom"><?= htmlspecialchars($post['category']) ?></p>
                                <h3 class="mt-2 font-poppins text-base font-bold leading-6 text-gray-900"><?= htmlspecialchars($post['title']) ?></h3>
                                <p class="mt-3 line-clamp-3 font-poppins text-xs leading-5 text-gray-500"><?= htmlspecialchars($post['excerpt']) ?></p>
                                <div class="mt-auto flex items-center justify-between gap-3 pt-5 font-poppins text-[0.68rem] text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-custom font-bold text-white"><?= $post['initials'] ?></span>
                                        <span><?= htmlspecialchars($post['author']) ?></span>
                                    </div>
                                    <span><?= htmlspecialchars($post['time']) ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <p id="blog-empty" class="<?= $total_articles > 0 ? 'hidden' : '' ?> py-12 text-center font-poppins text-sm text-gray-500"><?= htmlspecialchars($pagination_text['empty']) ?></p>
                <?php if ($total_pages > 1): ?>
                <nav id="blog-pagination" class="mt-10 flex flex-wrap items-center justify-center gap-2" aria-label="<?= htmlspecialchars($pagination_text['page']) ?>">
                    <?php if ($page > 1): ?>
                        <a href="<?= htmlspecialchars(blog_page_url($base_url, $idioma, $selected_category, $page - 1)) ?>"
                            class="inline-flex h-10 items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-4 font-poppins text-xs font-semibold text-gray-600 transition  ">
                            <i class="fa-solid fa-chevron-left text-[0.65rem]"></i>
                            <span class="hidden sm:inline"><?= htmlspecialchars($pagination_text['previous']) ?></span>
                        </a>
                    <?php endif; ?>

                    <?php foreach (blog_pagination_items($page, $total_pages) as $page_number): ?>
                        <?php if ($page_number === null): ?>
                            <span class="flex h-10 min-w-6 items-center justify-center font-poppins text-xs text-gray-400">…</span>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars(blog_page_url($base_url, $idioma, $selected_category, $page_number)) ?>"
                                aria-label="<?= htmlspecialchars($pagination_text['page'] . ' ' . $page_number) ?>"
                                <?= $page_number === $page ? 'aria-current="page"' : '' ?>
                                class="flex h-10 min-w-10 items-center justify-center rounded-full px-3 font-poppins text-xs font-semibold transition <?= $page_number === $page ? 'bg-orange-custom font-bold text-white shadow-sm' : 'border border-gray-200 bg-white text-gray-600  ' ?>">
                                <?= $page_number ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="<?= htmlspecialchars(blog_page_url($base_url, $idioma, $selected_category, $page + 1)) ?>"
                            class="inline-flex h-10 items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-4 font-poppins text-xs font-semibold text-gray-600 transition  ">
                            <span class="hidden sm:inline"><?= htmlspecialchars($pagination_text['next']) ?></span>
                            <i class="fa-solid fa-chevron-right text-[0.65rem]"></i>
                        </a>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>

    <script src="js/mobile-menu.js"></script>
    <script src="js/mega-menu.js"></script>
</body>
</html>
