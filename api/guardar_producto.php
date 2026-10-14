<?php
// Recibe datos del formulario y guarda el producto en la base de datos con validaciones
header('Content-Type: application/json');
require_once 'conexion.php';

function respuesta($exito, $mensaje) {
    echo json_encode(['exito'=>$exito, 'mensaje'=>$mensaje]);
    exit;
}

$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$bodega = $_POST['bodega'] ?? '';
$sucursal = $_POST['sucursal'] ?? '';
$moneda = $_POST['moneda'] ?? '';
$precio = trim($_POST['precio'] ?? '');
$material = isset($_POST['material']) ? $_POST['material'] : [];
$descripcion = trim($_POST['descripcion'] ?? '');

// 1. Validaciones backend
if ($codigo === '') respuesta(false, 'El código del producto no puede estar en blanco.');
if (mb_strlen($codigo) < 5 || mb_strlen($codigo) > 15) respuesta(false, 'El código del producto debe tener entre 5 y 15 caracteres.');
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{5,15}$/', $codigo)) respuesta(false, 'El código del producto debe contener letras y números');

// Unicidad
$sql = "SELECT COUNT(*) as total FROM productos WHERE codigo = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$codigo]);
$row = $stmt->fetch();
if ($row['total'] > 0) respuesta(false, 'El código del producto ya está registrado.');

if ($nombre === '') respuesta(false, 'El nombre del producto no puede estar en blanco.');
if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 50) respuesta(false, 'El nombre del producto debe tener entre 2 y 50 caracteres.');

if ($precio === '') respuesta(false, 'El precio del producto no puede estar en blanco.');
if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio) || floatval($precio) <= 0) respuesta(false, 'El precio del producto debe ser un número positivo con hasta dos decimales.');

if (!is_array($material) || count($material) < 2) respuesta(false, 'Debe seleccionar al menos dos materiales para el producto.');

if ($bodega === '') respuesta(false, 'Debe seleccionar una bodega.');
if ($sucursal === '') respuesta(false, 'Debe seleccionar una sucursal para la bodega seleccionada.');
if ($moneda === '') respuesta(false, 'Debe seleccionar una moneda para el producto.');

if ($descripcion === '') respuesta(false, 'La descripción del producto no puede estar en blanco.');
if (mb_strlen($descripcion) < 10 || mb_strlen($descripcion) > 1000) respuesta(false, 'La descripción del producto debe tener entre 10 y 1000 caracteres.');

// 2. Verificar que las FK existan en la base de datos y que la sucursal pertenezca a la bodega
if (!ctype_digit((string)$bodega)) respuesta(false, 'Debe seleccionar una bodega.');
$stmt = $conn->prepare("SELECT 1 FROM bodegas WHERE id = ?");
$stmt->execute([(int)$bodega]);
if (!$stmt->fetch()) respuesta(false, 'Debe seleccionar una bodega.');

if (!ctype_digit((string)$sucursal)) respuesta(false, 'Debe seleccionar una sucursal para la bodega seleccionada.');
$stmt = $conn->prepare("SELECT 1 FROM sucursales WHERE id = ? AND bodega_id = ?");
$stmt->execute([(int)$sucursal, (int)$bodega]);
if (!$stmt->fetch()) respuesta(false, 'Debe seleccionar una sucursal para la bodega seleccionada.');

if (!ctype_digit((string)$moneda)) respuesta(false, 'Debe seleccionar una moneda para el producto.');
$stmt = $conn->prepare("SELECT 1 FROM monedas WHERE id = ?");
$stmt->execute([(int)$moneda]);
if (!$stmt->fetch()) respuesta(false, 'Debe seleccionar una moneda para el producto.');

// 3. Insertar producto
$material_str = implode(',', $material);
$sql = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, material, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
try {
    $stmt = $conn->prepare($sql);
    $exito = $stmt->execute([$codigo, $nombre, (int)$bodega, (int)$sucursal, (int)$moneda, $precio, $material_str, $descripcion]);
} catch (PDOException $e) {
    // 23505 = unique_violation: otro request pudo registrar el codigo entre la verificacion y el INSERT
    if ($e->getCode() === '23505' && str_contains($e->getMessage(), 'productos_codigo_key')) {
        respuesta(false, 'El código del producto ya está registrado.');
    }
    throw $e;
}

if($exito){
    respuesta(true, 'Producto guardado correctamente');
} else {
    respuesta(false, 'Error al guardar el producto');
}
