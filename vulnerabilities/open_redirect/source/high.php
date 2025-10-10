<?php

// Validar y sanitizar el parámetro "redirect" para evitar Open Redirect
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = filter_var($_GET['redirect'], FILTER_SANITIZE_URL);

    // Definir una lista blanca (whitelist) de rutas permitidas
    $allowed_pages = ['info.php'];

    // Extraer solo el nombre del archivo sin parámetros ni rutas
    $redirect_path = parse_url($redirect, PHP_URL_PATH);
    $redirect_file = basename($redirect_path);

    if (in_array($redirect_file, $allowed_pages, true)) {
        // Redirección segura dentro del dominio actual
        header("Location: " . htmlspecialchars($redirect_file, ENT_QUOTES, 'UTF-8'));
        exit;
    } else {
        http_response_code(400);
        ?>
        <p>Redirección no permitida. Solo puedes acceder a la página de información.</p>
        <?php
        exit;
    }
}

http_response_code(400);
?>
<p>Falta el destino de redirección.</p>
<?php
exit;
?>

