
<?php
// Devuelve lista de sucursales (PostgreSQL)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once '../database/conexion.php';

try {
	$sql = "SELECT id, nombre FROM sucursales ORDER BY nombre ASC";
	$result = $conn->query($sql);
	$sucursales = $result->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($sucursales);
} catch (PDOException $e) {
	echo json_encode([]);
}
