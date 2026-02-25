<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../classes/Service.class.php";
require_once __DIR__ . "/../classes/Quote.class.php";

$id = $_POST['id'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);

    $services = Service::getCatalogoCompleto();
    $quote = new Quote($_SESSION['cart'], $services);

    echo json_encode([
        "success" => true,
        "message" => "Servicio eliminado",
        "cart" => $_SESSION['cart'],
        "totals" => $quote->getTotalesJSON()
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No se pudo eliminar"]);
}