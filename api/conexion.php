<?php
// Conexion PDO a PostgreSQL.
// Las credenciales viven en api/config.php (no versionado).
// Si no existe, copie api/config.example.php a api/config.php (ver LEEME.txt).

if (!is_file(__DIR__ . '/config.php')) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'exito' => false,
        'mensaje' => 'Falta la configuracion: copie api/config.example.php como api/config.php y complete sus credenciales (ver LEEME.txt).'
    ]);
    exit;
}
require_once __DIR__ . '/config.php';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
try {
    $conn = new PDO('pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    http_response_code(500);
    die('Error de conexion: ' . $e->getMessage());
}
