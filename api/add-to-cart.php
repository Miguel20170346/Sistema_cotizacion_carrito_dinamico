<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $_POST['id'] ?? null;

if ($id) {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    echo json_encode([
        "success" => true,
        "message" => "Servicio agregado al carrito",
        "cart" => $_SESSION['cart']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "ID inválido"
    ]);
}