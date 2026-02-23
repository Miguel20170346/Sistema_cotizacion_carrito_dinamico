<?php
session_start();

// Inicializar carrito solo si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ServicePOO - Comprometidos con el deber</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/services-catalog.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top py-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-3" href="index.php">
        <span class="me-2">🛡️</span>ServicePOO
    </a>

    <div class="ms-auto d-flex align-items-center">
      <a href="pages/view-quotes.php" class="btn btn-link text-light text-decoration-none me-4 fs-5 nav-link-custom">
          📜 Historial
      </a>

      <button class="btn btn-outline-light position-relative btn-lg px-4" data-bs-toggle="offcanvas" data-bs-target="#cartPanel">
        <span class="me-1">🛒</span> Carrito
        <span id="cart-count" 
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <?= array_sum($_SESSION['cart']); ?>
        </span>
      </button>
    </div>
  </div>
</nav>

<section class="hero-section text-white text-center py-5 ">
    <div class="container">
        <h1 class="fw-bold display-5">
            🌐 Servicios Disponibles
        </h1>
        <p class="lead">
            Tu sistema profesional de cotización de servicios
        </p>

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

<section class="catalog-section py-5">
    <div class="container">
        <?php include "pages/services-catalog.php"; ?>
    </div>
</section>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartPanel" aria-labelledby="cartPanelLabel">
  <div class="offcanvas-header bg-dark text-white">
    <h5 class="offcanvas-title" id="cartPanelLabel">Resumen de Cotización</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div id="cart-content">
        <p class="text-center">Cargando carrito...</p>
    </div>
    
    <hr>
    
    <div id="cart-totals" class="d-none">
        <div class="d-flex justify-content-between mb-1">
            <span>Subtotal:</span>
            <span id="st-val" class="fw-bold">$0.00</span>
        </div>
        <div class="d-flex justify-content-between mb-1 text-danger">
            <span>Descuento:</span>
            <span id="ds-val">-$0.00</span>
        </div>
        <div class="d-flex justify-content-between mb-1">
            <span>IVA (13%):</span>
            <span id="iva-val">$0.00</span>
        </div>
        <div class="d-flex justify-content-between fs-4 fw-bold mt-2 border-top pt-2">
            <span>Total:</span>
            <span id="total-val" class="text-success">$0.00</span>
        </div>
        
        <button class="btn btn-primary w-100 mt-4 fw-bold py-2" id="btn-quote">
            Siguiente: Datos del Cliente
        </button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/services-catalog.js"></script>
</body>
</html>