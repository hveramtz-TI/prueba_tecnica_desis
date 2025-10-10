
<?php
// Devuelve lista de monedas (PostgreSQL)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once '../database/conexion.php';

try {
	$sql = "SELECT id, nombre FROM monedas ORDER BY nombre ASC";
	$result = $conn->query($sql);
	$monedas = $result->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($monedas);
} catch (PDOException $e) {
	echo json_encode([]);
}
