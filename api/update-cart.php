<?php
session_start();
header('Content-Type: application/json');

// Requerir las clases
require_once __DIR__ . "/../classes/Service.class.php";
require_once __DIR__ . "/../classes/Quote.class.php";

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
    if ($action === 'add' && $_SESSION['cart'][$id] < 10) {
        $_SESSION['cart'][$id]++;
    } elseif ($action === 'remove' && $_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id]--;
    }

    // Obtenemos el catálogo de forma limpia
    $services = Service::getCatalogoCompleto();
    
    // Calculamos totales
    $quote = new Quote($_SESSION['cart'], $services);
    $totales = $quote->getTotalesJSON();

    echo json_encode([
        "success" => true,
        "cart" => $_SESSION['cart'],
        "totals" => $totales
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar"
    ]);
}