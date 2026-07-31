<?php
http_response_code(404);
$idioma = $_GET['lang'] ?? 'es';
if (!in_array($idioma, ['es', 'en', 'pt'], true)) {
    $idioma = 'es';
}
$text = [
    'es' => ['title' => 'Página no encontrada', 'message' => 'La página que buscas no existe.', 'back' => 'Volver al inicio'],
    'en' => ['title' => 'Page not found', 'message' => 'The page you are looking for does not exist.', 'back' => 'Back to home'],
    'pt' => ['title' => 'Página não encontrada', 'message' => 'A página que você procura não existe.', 'back' => 'Voltar ao início'],
][$idioma];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($idioma) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — <?= htmlspecialchars($text['title']) ?> | GT Peru Travel</title>
    <meta name="robots" content="noindex, follow">
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #111; color: #fff; font-family: Arial, sans-serif; text-align: center; }
        h1 { margin: 0; font-size: clamp(4rem, 15vw, 8rem); color: #ff8a00; }
        p { margin: 1rem 0; font-size: 1.1rem; }
        a { display: inline-flex; margin-top: .75rem; border-radius: 999px; background: #ff8a00; padding: .8rem 1.4rem; color: #fff; font-weight: 700; text-decoration: none; }
        a:hover { background: #d97700; }
    </style>
</head>
<body>
    <main>
        <h1>404</h1>
        <p><?= htmlspecialchars($text['message']) ?></p>
        <a href="/?lang=<?= rawurlencode($idioma) ?>"><?= htmlspecialchars($text['back']) ?></a>
    </main>
</body>
</html>