<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $_POST['id'] ?? null;

if ($id) {
    // Validar cantidad máxima de 10 unidades (Requerimiento 2.2)
    $cantidadActual = $_SESSION['cart'][$id] ?? 0;
    
    if ($cantidadActual < 10) {
        $_SESSION['cart'][$id] = $cantidadActual + 1;
        echo json_encode([
            "success" => true,
            "message" => "Servicio agregado al carrito",
            "cart" => $_SESSION['cart']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Máximo 10 unidades permitidas por servicio"
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID de servicio no válido"]);
}