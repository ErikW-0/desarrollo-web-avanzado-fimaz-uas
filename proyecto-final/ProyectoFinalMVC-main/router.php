<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si el archivo existe físicamente, servirlo directamente
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false;
}

// Redirigir todo lo demás a index.php
require __DIR__ . '/index.php';
