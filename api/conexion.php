<?php
// Conexión PDO a PostgreSQL
$host = 'localhost';
$db = 'postgres';
$user = 'postgres'; // Cambia por tu usuario de PostgreSQL
$pass = 'Hv2725502';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
try {
    $conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pass, $options);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
