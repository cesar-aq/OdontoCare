<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_consultas');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// O nome precisa corresponder à pasta dentro de htdocs.
define('BASE_URL', '/crud_consultas');

date_default_timezone_set('America/Araguaina');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header('Location: ' . BASE_URL . $path);
    exit;
}
