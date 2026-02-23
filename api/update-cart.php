<?php
session_start();
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null; // 'add' o 'remove'

if ($id && isset($_SESSION['cart'][$id])) {
    if ($action === 'add' && $_SESSION['cart'][$id] < 10) {
        $_SESSION['cart'][$id]++;
    } elseif ($action === 'remove' && $_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id]--;
    }

    echo json_encode([
        "success" => true,
        "cart" => $_SESSION['cart']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar"]);
}