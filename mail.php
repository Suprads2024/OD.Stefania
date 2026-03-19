<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// Sanitizar datos
$nombre  = trim(strip_tags($_POST["nombre"] ?? ""));
$email   = trim($_POST["email"] ?? "");
$asunto  = trim(strip_tags($_POST["asunto"] ?? ""));
$mensaje = trim(strip_tags($_POST["mensaje"] ?? ""));

// Validaciones básicas
if (empty($nombre) || empty($email) || empty($mensaje)) {
    exit("Faltan campos obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("El email ingresado no es válido.");
}

// Destinatario provisorio
$destinatario = "ignaciosoraka@gmail.com";

// Asunto del correo
$asuntoCorreo = !empty($asunto) ? "Consulta web: " . $asunto : "Nueva consulta desde la web";

// Cuerpo del mail
$cuerpo  = "Recibiste una nueva consulta desde el formulario web.\n\n";
$cuerpo .= "Nombre: " . $nombre . "\n";
$cuerpo .= "Email: " . $email . "\n";
$cuerpo .= "Asunto: " . ($asunto ?: "Sin asunto") . "\n\n";
$cuerpo .= "Mensaje:\n" . $mensaje . "\n";

// Headers
$headers  = "From: Web Odontologia <no-reply@" . $_SERVER['HTTP_HOST'] . ">\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envío
if (mail($destinatario, $asuntoCorreo, $cuerpo, $headers)) {
    header("Location: gracias.html");
    exit;
} else {
    exit("Hubo un error al enviar el formulario. Probá nuevamente.");
}
?>