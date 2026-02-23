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
    <div class="container">
        <span class="navbar-brand mb-0 h1">
            Sistema de Cotización de Servicios
        </span>

        <a href="pages/view-quotes.php" class="btn btn-light">
            Ver Cotizaciones
        </a>
    </div>
</nav>

<div class="container mt-4">
    <?php include "pages/services-catalog.php"; ?>
</div>

<script src="assets/js/services-catalog.js"></script>

</body>
</html>