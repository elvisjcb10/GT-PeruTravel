<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <meta name="robots" content="noindex, follow">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        a {
            color: #ff6600;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div>
        <h1 style="font-size: 4rem; margin: 0;">404</h1>
        <p style="font-size: 1.2rem; margin-top: 10px;">La página que buscas no existe.</p>
        <p><a href="/">Volver al inicio</a></p>
    </div>

</body>

</html>