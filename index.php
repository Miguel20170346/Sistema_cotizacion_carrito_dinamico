<?php
session_start();
$_SESSION['cart'] = [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ServicePOO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="assets/css/services-catalog.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
       Comprometidos con el deber
    </a>

    <div class="ms-auto">
      <button class="btn btn-outline-light position-relative">
        🛒 Carrito
        <span id="cart-count"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          0
        </span>
      </button>
    </div>
  </div>
</nav>

<!-- 🔵 HERO / BANNER -->
<section class="hero-section text-white text-center py-5">
    <div class="container">
        <h1 class="fw-bold display-5">
            🌐 Servicios Disponibles
        </h1>
        <p class="lead">
            Tu sistema profesional de cotización de servicios
        </p>

        <!-- Caja flotante estilo AutoPOO -->
        <div class="stats-box mt-4">
            <div>
                <h4>12</h4>
                <small>Servicios Disponibles</small>
            </div>
            <div>
                <h4>3</h4>
                <small>Categorías</small>
            </div>
            <div>
                <h4>100%</h4>
                <small>Por expertos</small>
            </div>
        </div>
    </div>
</section>

<!-- 🟣 CATÁLOGO -->
<section class="catalog-section py-5">
    <div class="container">
        <?php include "pages/services-catalog.php"; ?>
    </div>
</section>

<script src="assets/js/services-catalog.js"></script>
</body>
</html>