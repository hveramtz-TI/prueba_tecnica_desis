<?php
// Devuelve lista de bodegas (PostgreSQL)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once 'conexion.php';

try {
	$sql = "SELECT id, nombre FROM bodegas ORDER BY nombre ASC";
	$result = $conn->query($sql);
	$bodegas = $result->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($bodegas);
} catch (PDOException $e) {
	echo json_encode([]);
}
