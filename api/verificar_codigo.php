<?php
// Verifica si el código de producto es único
header('Content-Type: application/json');
require_once 'conexion.php';
$codigo = $_GET['codigo'] ?? '';
$sql = "SELECT COUNT(*) as total FROM productos WHERE codigo = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$codigo]);
$row = $stmt->fetch();
echo json_encode(['unico' => ($row['total'] == 0)]);
