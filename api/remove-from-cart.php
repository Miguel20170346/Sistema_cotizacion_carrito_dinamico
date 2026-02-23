<?php
session_start();
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    echo json_encode([
        "success" => true,
        "message" => "Servicio eliminado",
        "cart" => $_SESSION['cart']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No se pudo eliminar"]);
}