<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}


$honeypot = trim((string) ($_POST['website'] ?? ''));
if ($honeypot !== '') {
    http_response_code(204);
    exit;
}
$form_started = (int) ($_POST['form_started'] ?? 0);
if ($form_started > 0 && time() - $form_started < 2) {
    http_response_code(429);
    exit('Envío demasiado rápido');
}

function form_rate_limit_exceeded(string $identity, int $limit = 10, int $window = 600): bool
{
    $directory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'gt-perutravel-form-rate';
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) return false;
    $file = $directory . DIRECTORY_SEPARATOR . hash('sha256', $identity) . '.json';
    $handle = @fopen($file, 'c+');
    if (!$handle || !flock($handle, LOCK_EX)) return false;
    $raw = stream_get_contents($handle);
    $entries = is_string($raw) ? (json_decode($raw, true) ?: []) : [];
    $minimum = time() - $window;
    $entries = array_values(array_filter($entries, static fn($stamp): bool => is_int($stamp) && $stamp >= $minimum));
    $blocked = count($entries) >= $limit;
    if (!$blocked) $entries[] = time();
    ftruncate($handle, 0); rewind($handle); fwrite($handle, json_encode($entries)); fflush($handle);
    flock($handle, LOCK_UN); fclose($handle);
    return $blocked;
}
function clean_form_value(string $value, int $max_length = 500): string
{
    $value = trim($value);
    $value = mb_substr($value, 0, $max_length, 'UTF-8');
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$lang = (string) ($_POST['lang'] ?? 'es');
if (!in_array($lang, ['es', 'en', 'pt'], true)) {
    $lang = 'es';
}

$messages_path = __DIR__ . '/../lang/mensajes.json';
$all_messages = is_file($messages_path)
    ? json_decode((string) file_get_contents($messages_path), true)
    : [];
$messages = $all_messages[$lang] ?? $all_messages['es'] ?? [];

$type = clean_form_value((string) ($_POST['tipo_formulario'] ?? ''), 30);
$name = clean_form_value((string) ($_POST['nombre'] ?? ''), 100);
$last_name = clean_form_value((string) ($_POST['apellido'] ?? ''), 100);
$phone = clean_form_value((string) ($_POST['numero'] ?? ''), 50);
$email_raw = trim((string) ($_POST['correo'] ?? ''));
$email = clean_form_value($email_raw, 180);
$message = clean_form_value((string) ($_POST['mensaje'] ?? ''), 5000);
$date = clean_form_value((string) ($_POST['fecha'] ?? ''), 30);
$service = clean_form_value((string) ($_POST['categoria_servicio'] ?? ''), 150);
$package = clean_form_value((string) ($_POST['paquete'] ?? ''), 200);

if ($name === '' || $email_raw === '' || $message === '') {
    http_response_code(422);
    exit($messages['faltan_datos'] ?? 'Missing required fields');
}
if (!filter_var($email_raw, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    exit($messages['correo_invalido'] ?? 'Invalid email');
}
if (form_rate_limit_exceeded((string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown'))) {
    http_response_code(429);
    exit('Demasiados intentos. Inténtalo nuevamente en unos minutos.');
}
$captcha_token = trim((string) ($_POST['g-recaptcha-response'] ?? ''));
if ($captcha_token === '') {
    http_response_code(422);
    exit($messages['captcha_requerido'] ?? 'Captcha required');
}

$recaptcha_secret = trim((string) getenv('RECAPTCHA_SECRET_KEY'));
if ($recaptcha_secret === '') {
    error_log('RECAPTCHA_SECRET_KEY is not configured.');
    http_response_code(503);
    exit($messages['captcha_invalido'] ?? 'Captcha validation unavailable');
}

$verification_payload = [
    'secret' => $recaptcha_secret,
    'response' => $captcha_token,
];
if (!empty($_SERVER['REMOTE_ADDR'])) {
    $verification_payload['remoteip'] = (string) $_SERVER['REMOTE_ADDR'];
}

$curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($verification_payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
]);
$verification_response = curl_exec($curl);
$curl_error = curl_error($curl);
curl_close($curl);

$verification = is_string($verification_response)
    ? json_decode($verification_response, true)
    : null;
$captcha_valid = is_array($verification) && ($verification['success'] ?? false) === true;

$allowed_host = strtolower(trim((string) getenv('RECAPTCHA_ALLOWED_HOST')));
if ($captcha_valid && $allowed_host !== '') {
    $verified_host = strtolower((string) ($verification['hostname'] ?? ''));
    $captcha_valid = hash_equals($allowed_host, $verified_host);
}

if (!$captcha_valid) {
    if ($curl_error !== '') {
        error_log('reCAPTCHA verification error: ' . $curl_error);
    }
    http_response_code(422);
    exit($messages['captcha_invalido'] ?? 'Invalid captcha');
}

$subjects = [
    'tour' => 'Nueva reserva de tour',
    'paquete' => 'Nueva reserva de paquete',
    'contacto' => 'Nuevo mensaje de contacto',
];
$subject = $subjects[$type] ?? $subjects['contacto'];
if ($package === '' && $type === 'contacto') {
    $package = 'Contacto general';
}

$body = "
<b>Nombre / título:</b> {$package}<br>
<b>Tipo:</b> {$type}<br>
<b>Nombre:</b> {$name} {$last_name}<br>
<b>Número móvil:</b> {$phone}<br>
<b>Correo:</b> {$email}<br>
<b>Fecha:</b> {$date}<br>
<b>Servicio:</b> {$service}<br>
<b>Idioma:</b> {$lang}<br><br>
<b>Mensaje:</b><br>{$message}
";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: GT Peru Travel <no-reply@gtperutravel.com>\r\n";
$headers .= "Reply-To: {$email_raw}\r\n";

if (mail('info@gtperutravel.com', $subject, $body, $headers)) {
    echo 'OK';
    exit;
}

error_log('The contact email could not be sent.');
http_response_code(500);
echo 'ERROR_MAIL';