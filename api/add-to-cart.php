<?php
session_start();
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(["error" => "ID no recibido"]);
    exit;
}

$id = intval($_POST['id']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

echo json_encode([
    "message" => "Servicio agregado al carrito",
    "cart" => $_SESSION['cart']
]);