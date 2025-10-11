<?php
// Conexión PDO a PostgreSQL
// Cambia los valores de usuario y contraseña según tu entorno local
$host = 'localhost';
$db = 'productos_db';
$user = 'postgres'; // Cambia por tu usuario de PostgreSQL
$pass = '1234';     // Cambia por tu contraseña de PostgreSQL
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
try {
    $conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pass, $options);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
