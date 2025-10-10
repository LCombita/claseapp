<?php

// Validar y sanitizar el parámetro "redirect" para evitar Open Redirect
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = filter_var($_GET['redirect'], FILTER_SANITIZE_URL);

    // Lista blanca de páginas internas permitidas
    $allowed_pages = ['info.php', 'home.php', 'index.php'];

    // Extraer solo el nombre del archivo (sin ruta ni parámetros)
    $redirect_path = parse_url($redirect, PHP_URL_PATH);
    $redirect_file = basename($redirect_path);

    // Validar que el destino esté en la lista blanca
    if (in_array($redirect_file, $allowed_pages, true)) {
        header("Location: " . htmlspecialchars($redirect_file, ENT_QUOTES, 'UTF-8'));
        exit;
    } else {
        http_response_code(400);
        ?>
        <p>Redirección no permitida. Solo se permiten páginas internas autorizadas.</p>
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

