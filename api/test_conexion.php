<?php
require_once 'conexion.php';

try {
    $stmt = $conn->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "Conexión exitosa a PostgreSQL. Versión: $version";
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
