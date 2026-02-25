<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../classes/Service.class.php";
require_once __DIR__ . "/../classes/Quote.class.php";

// 1. Validar carrito no vacío
if (empty($_SESSION['cart'])) {
    echo json_encode(["success" => false, "message" => "El carrito está vacío. Agrega servicios primero."]);
    exit;
}

// 2. Obtener y Sanitizar datos del cliente
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$empresa = htmlspecialchars(trim($_POST['empresa'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$telefono = trim($_POST['telefono'] ?? '');

// Validación de campos vacíos
if (empty($nombre) || empty($email) || empty($telefono)) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios."]);
    exit;
}

// Validación de formato de correo (Backend)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "El formato del correo electrónico no es válido."]);
    exit;
}

// Validación de formato de teléfono (Backend) usando Regex
if (!preg_match('/^[\d\s\-+]{8,}$/', $telefono)) {
    echo json_encode(["success" => false, "message" => "El formato del teléfono no es válido."]);
    exit;
}

$cliente = [
    'nombre' => $nombre,
    'empresa' => $empresa,
    'email' => $email,
    'telefono' => $telefono
];

// Validar campos obligatorios
if (empty($cliente['nombre']) || empty($cliente['email']) || empty($cliente['telefono'])) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios del cliente."]);
    exit;
}

// 3. Recrear la cotización para validar el total
$services = Service::getCatalogoCompleto();
$quote = new Quote($_SESSION['cart'], $services);
$totales = $quote->getTotalesJSON(); // Ya es un arreglo, no usamos json_decode

// 4. Validar monto mínimo de $100
// Limpiamos el formato "1,200.00" para convertirlo a número real (1200.00)
$subtotalNumerico = (float) str_replace(',', '', $totales['subtotal']);

if (!Quote::validarMonto($subtotalNumerico)) {
    echo json_encode(["success" => false, "message" => "El subtotal debe ser mínimo de $100.00 para generar cotización."]);
    exit;
}

// 5. Generar y guardar la cotización
$cotizacionGenerada = $quote->generar($cliente);

// 6. Vaciar el carrito
$_SESSION['cart'] = [];

// 7. Retornar éxito con los datos para el Modal
echo json_encode([
    "success" => true,
    "message" => "Cotización generada con éxito.",
    "quote" => $cotizacionGenerada
]);
