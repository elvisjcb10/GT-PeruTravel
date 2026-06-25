<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit("Método no permitido");

function limpiar($s)
{
    return htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8');
}

$tipo = limpiar($_POST['tipo_formulario'] ?? '');
$nombre = limpiar($_POST['nombre'] ?? '');
$apellido = limpiar($_POST['apellido'] ?? '');
$numero = limpiar($_POST['numero'] ?? '');
$correo = limpiar($_POST['correo'] ?? '');
$mensaje = limpiar($_POST['mensaje'] ?? '');
$fecha = limpiar($_POST['fecha'] ?? '');
$servicio = limpiar($_POST['categoria_servicio'] ?? '');
$paquete = limpiar($_POST['paquete'] ?? '');
$lang = limpiar($_POST['lang'] ?? 'es');

// Cargar mensajes multi-idioma
$mensajes_path = __DIR__ . '/../lang/mensajes.json';
$mensajes = json_decode(file_get_contents($mensajes_path), true);

// Validaciones
if (!$nombre || !$correo || !$mensaje) exit($mensajes[$lang]['faltan_datos']);
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) exit($mensajes[$lang]['correo_invalido']);

// Validar reCAPTCHA
$recaptcha = $_POST['g-recaptcha-response'] ?? '';
if (!$recaptcha) exit($mensajes[$lang]['captcha_requerido']);

$secretKey = "6LdyCx4sAAAAAM7_ALrJWxj02F9KHd9K4IkK6AzI";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['secret' => $secretKey, 'response' => $recaptcha]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$verificacion = json_decode($response);
if (!$verificacion->success) exit($mensajes[$lang]['captcha_invalido']);

// Armar correo
switch ($tipo) {
    case "tour":
        $asunto = "Nueva Reserva de Tour";
        break;
    case "paquete":
        $asunto = "Nueva Reserva de Paquete";
        break;
    default:
        $asunto = "Nuevo mensaje de Contacto";
        break;
}
if (!$paquete && $tipo === 'contacto') $paquete = 'Contacto general';

$cuerpo = "
<b>Nombre / Título:</b> $paquete<br>
<b>Tipo:</b> $tipo<br>
<b>Nombre:</b> $nombre $apellido<br>
<b>Numero Mobil:</b> $numero<br>
<b>Correo:</b> $correo<br>
<b>Fecha:</b> $fecha<br>
<b>Servicio:</b> $servicio<br>
<b>Idioma:</b> $lang<br><br>
<b>Mensaje:</b><br>$mensaje
";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: GT Peru Travel <no-reply@gtperutravel.com>\r\n";

if (mail("info@gtperutravel.com", $asunto, $cuerpo, $headers)) {
    echo 'OK'; // → dispara la conversión en Google Ads
} else {
    echo 'ERROR_MAIL';  // → no dispara la conversión
}
