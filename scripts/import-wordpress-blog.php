<?php
declare(strict_types=1);

if ($argc < 2) {
    fwrite(STDERR, "Uso: php scripts/import-wordpress-blog.php <wordpress-posts.json>\n");
    exit(1);
}

$sourceFile = $argv[1];
$root = dirname(__DIR__);
$outputDir = $root . '/data/blog';
$imageDir = $root . '/images/blog/posts';

if (!is_file($sourceFile)) {
    fwrite(STDERR, "No existe el archivo fuente: {$sourceFile}\n");
    exit(1);
}

$posts = json_decode((string) file_get_contents($sourceFile), true);
if (!is_array($posts)) {
    fwrite(STDERR, "El archivo fuente no contiene JSON válido.\n");
    exit(1);
}

if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);
if (!is_dir($imageDir)) mkdir($imageDir, 0777, true);

function strip_emojis(string $value): string
{
    $pattern = '/[\x{1F1E6}-\x{1F1FF}\x{1F300}-\x{1F5FF}\x{1F600}-\x{1F64F}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE0F}\x{200D}\x{20E3}]/u';
    return (string) preg_replace($pattern, '', $value);
}

function clean_text(string $value): string
{
    $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = strip_emojis($value);
    return trim((string) preg_replace('/\s+/u', ' ', $value));
}

function classify_post(string $title, string $content): string
{
    $haystack = mb_strtolower($title . ' ' . clean_text($content), 'UTF-8');
    $groups = [
        'Machu Picchu' => ['machu picchu', 'machupicchu', 'camino inca', 'aguas calientes', 'huayna picchu'],
        'Glaciares' => ['glaciar', 'quelccaya', 'ausangate', 'pastoruri', 'nevado'],
        'Gastronomía' => ['gastronom', 'comida', 'plato', 'restaurante', 'mercado san pedro', 'pisco', 'ceviche'],
        'Cusco' => ['cusco', 'cuzco', 'valle sagrado', 'sacsayhuam', 'ollantaytambo', 'pisac'],
    ];
    foreach ($groups as $category => $keywords) {
        foreach ($keywords as $keyword) {
            if (str_contains($haystack, $keyword)) return $category;
        }
    }
    return 'Consejos';
}

function prepare_content(string $html): array
{
    $toc = [];
    $used = [];
    $prepared = preg_replace_callback('/<h([2-3])([^>]*)>(.*?)<\/h\1>/isu', function ($match) use (&$toc, &$used) {
        $label = clean_text($match[3]);
        if ($label === '') return $match[0];
        $base = trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $label) ?: $label)), '-');
        if ($base === '') $base = 'seccion';
        $id = $base;
        $suffix = 2;
        while (isset($used[$id])) $id = $base . '-' . $suffix++;
        $used[$id] = true;
        $toc[] = ['id' => $id, 'title' => $label, 'level' => (int) $match[1]];
        $attributes = preg_replace('/\s+id=("|\').*?\1/isu', '', $match[2]);
        return '<h' . $match[1] . $attributes . ' id="' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '">' . $match[3] . '</h' . $match[1] . '>';
    }, $html) ?? $html;

    $prepared = preg_replace('/<script\b[^>]*>.*?<\/script>/isu', '', $prepared) ?? $prepared;
    $prepared = strip_emojis($prepared);
    return [$prepared, $toc];
}

function featured_data(array $post, string $slug): array
{
    $remote = $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? '';
    if (!is_string($remote) || $remote === '') return ['', ''];
    $extension = strtolower(pathinfo((string) parse_url($remote, PHP_URL_PATH), PATHINFO_EXTENSION));
    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) $extension = 'jpg';
    return ['images/blog/posts/' . $slug . '.' . $extension, $remote];
}

$indexes = ['es' => [], 'en' => [], 'pt' => []];
$seenTitles = ['es' => [], 'en' => [], 'pt' => []];
$written = ['es' => 0, 'en' => 0, 'pt' => 0];

$categoryLabels = [
    'es' => [
        'Machu Picchu' => 'Machu Picchu',
        'Glaciares' => 'Glaciares',
        'Gastronomía' => 'Gastronomía',
        'Cusco' => 'Cusco',
        'Consejos' => 'Consejos',
    ],
    'en' => [
        'Machu Picchu' => 'Machu Picchu',
        'Glaciares' => 'Glaciers',
        'Gastronomía' => 'Gastronomy',
        'Cusco' => 'Cusco',
        'Consejos' => 'Travel tips',
    ],
    'pt' => [
        'Machu Picchu' => 'Machu Picchu',
        'Glaciares' => 'Geleiras',
        'Gastronomía' => 'Gastronomia',
        'Cusco' => 'Cusco',
        'Consejos' => 'Dicas',
    ],
];

$authorCopy = [
    'es' => [
        'role' => 'Autor · GT Peru Travel',
        'bio' => 'Contenido preparado por el equipo de GT Peru Travel para ayudarte a organizar una experiencia segura y auténtica en el Perú.',
        'location' => 'Cusco, Perú',
        'reading' => ' min de lectura',
    ],
    'en' => [
        'role' => 'Author · GT Peru Travel',
        'bio' => 'Content prepared by the GT Peru Travel team to help you plan a safe and authentic experience in Peru.',
        'location' => 'Cusco, Peru',
        'reading' => ' min read',
    ],
    'pt' => [
        'role' => 'Autor · GT Peru Travel',
        'bio' => 'Conteúdo preparado pela equipe da GT Peru Travel para ajudar você a planejar uma experiência segura e autêntica no Peru.',
        'location' => 'Cusco, Peru',
        'reading' => ' min de leitura',
    ],
];

foreach ($posts as $post) {
    if (($post['status'] ?? '') !== 'publish') continue;

    $sourceUrl = (string) ($post['link'] ?? '');
    $language = preg_match('~/blog/en(?:/|$)~i', $sourceUrl)
        ? 'en'
        : (preg_match('~/blog/pt(?:/|$)~i', $sourceUrl) ? 'pt' : 'es');

    $slug = preg_replace('/[^a-z0-9_-]/', '', (string) ($post['slug'] ?? ''));
    if ($slug === '') continue;

    $title = clean_text((string) ($post['title']['rendered'] ?? ''));
    $titleKey = preg_replace('/\s+/u', ' ', mb_strtolower(trim($title), 'UTF-8'));
    if ($titleKey === '' || isset($seenTitles[$language][$titleKey])) continue;
    $seenTitles[$language][$titleKey] = true;

    $rawContent = (string) ($post['content']['rendered'] ?? '');
    [$contentHtml, $toc] = prepare_content($rawContent);
    $excerpt = clean_text((string) ($post['excerpt']['rendered'] ?? ''));
    if ($excerpt === '') $excerpt = mb_substr(clean_text($rawContent), 0, 220, 'UTF-8');
    $author = clean_text((string) ($post['_embedded']['author'][0]['name'] ?? 'GT Peru Travel'));
    $baseCategory = classify_post($title, $rawContent);
    $category = $categoryLabels[$language][$baseCategory] ?? $baseCategory;
    [$localImage, $remoteImage] = featured_data($post, $slug);
    $plainWords = preg_split('/\s+/u', clean_text($rawContent), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $minutes = max(1, (int) ceil(count($plainWords) / 210));

    $article = [
        'source_id' => $post['id'] ?? null,
        'source_url' => $sourceUrl,
        'language' => $language,
        'slug' => $slug,
        'title' => $title,
        'category' => $category,
        'excerpt' => $excerpt,
        'hero_image' => $localImage,
        'hero_image_remote' => $remoteImage,
        'date_iso' => $post['date'] ?? '',
        'date' => !empty($post['date']) ? date('j/m/Y', strtotime((string) $post['date'])) : '',
        'reading_time' => $minutes . $authorCopy[$language]['reading'],
        'author' => [
            'name' => $author,
            'initials' => mb_strtoupper(mb_substr($author, 0, 1, 'UTF-8'), 'UTF-8'),
            'role' => $authorCopy[$language]['role'],
            'bio' => $authorCopy[$language]['bio'],
            'location' => $authorCopy[$language]['location'],
        ],
        'intro' => $excerpt,
        'content_html' => $contentHtml,
        'toc' => $toc,
        'tags' => array_values(array_map(fn($tag) => clean_text((string) ($tag['name'] ?? '')), $post['_embedded']['wp:term'][1] ?? [])),
        'seo' => [
            'title' => $title . ' | GT Peru Travel',
            'description' => $excerpt,
        ],
    ];

    file_put_contents(
        $outputDir . '/' . $slug . '.' . $language . '.json',
        json_encode($article, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );

    $indexes[$language][] = [
        'slug' => $slug,
        'title' => $title,
        'category' => $category,
        'excerpt' => $excerpt,
        'image' => $localImage,
        'image_remote' => $remoteImage,
        'author' => $author,
        'initials' => $article['author']['initials'],
        'date' => $article['date'],
        'date_iso' => $article['date_iso'],
        'time' => $minutes . ($language === 'en' ? ' min' : ' min'),
    ];
    $written[$language]++;
}

foreach ($indexes as $language => $index) {
    usort($index, fn($a, $b) => strcmp((string) $b['date_iso'], (string) $a['date_iso']));
    file_put_contents(
        $outputDir . '/index.' . $language . '.json',
        json_encode(['language' => $language, 'posts' => $index], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

echo "Artículos migrados: ES={$written['es']} EN={$written['en']} PT={$written['pt']}\n";