<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../classes/Service.class.php";
require_once __DIR__ . "/../classes/Quote.class.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $_POST['id'] ?? null;

if ($id) {
    $cantidadActual = $_SESSION['cart'][$id] ?? 0;

    if ($cantidadActual < 10) {
        $_SESSION['cart'][$id] = $cantidadActual + 1;

        $services = Service::getCatalogoCompleto();
        $quote = new Quote($_SESSION['cart'], $services);

        echo json_encode([
            "success" => true,
            "message" => "Servicio agregado al carrito",
            "cart" => $_SESSION['cart'],
            "totals" => $quote->getTotalesJSON()
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Máximo 10 unidades permitidas por servicio"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID de servicio no válido"]);
}