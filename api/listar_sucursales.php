<?php
// Devuelve las sucursales de la bodega indicada por bodega_id (PostgreSQL)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once 'conexion.php';

$bodega_id = filter_input(INPUT_GET, 'bodega_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($bodega_id === false || $bodega_id === null) {
    // Sin bodega valida no hay sucursales que mostrar
    echo json_encode([]);
    exit;
}

try {
	$sql = "SELECT id, nombre FROM sucursales WHERE bodega_id = ? ORDER BY nombre ASC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$bodega_id]);
	$sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($sucursales);
} catch (PDOException $e) {
	echo json_encode([]);
}
