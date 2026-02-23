<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cotización</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/services-catalog.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container d-flex justify-content-between">

        <span class="navbar-brand">
            Sistema de Cotización de Servicios
        </span>

        <div>
            <button class="btn btn-light position-relative" id="cartButton">
                🛒 Carrito
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                      id="cart-count">
                    0
                </span>
            </button>

            <a href="pages/view-quotes.php" class="btn btn-outline-light ms-2">
                Ver Cotizaciones
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">
    <?php include "pages/services-catalog.php"; ?>
</div>

<script src="assets/js/services-catalog.js"></script>

</body>
</html>