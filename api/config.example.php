<?php
// Plantilla de configuracion de base de datos.
// Copie este archivo como api/config.php y complete sus credenciales reales.
// El archivo api/config.php NO debe subirse a Git (esta en .gitignore).

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'productos_db');
    define('DB_USER', 'postgres');
    define('DB_PASS', 'SU_PASSWORD_AQUI');
}
