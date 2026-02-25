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
        <a href="pages/view-quotes.php" class="btn btn-outline-light btn-lg me-3 shadow-sm">
                <span class="me-1">📄</span> Historial
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
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4>100%</h4>
                    <small>Por expertos</small>
                </div>
                <select id="category-filter" class="form-select" style="max-width: 280px;">
                    <option value="">Todas las categorías</option>
                    <option value="Desarrollo Web">Desarrollo Web</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Soporte Técnico">Soporte Técnico</option>
                </select>
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
        
    <form id="checkout-form" class="mt-3 border-top pt-3 d-none">
        <h6 class="fw-bold">Datos del Cliente</h6>
        <input type="text" name="nombre" class="form-control form-control-sm mb-2" placeholder="Nombre completo" required>
        <input type="text" name="empresa" class="form-control form-control-sm mb-2" placeholder="Empresa (Opcional)">
        <input type="email" name="email" class="form-control form-control-sm mb-2" placeholder="Correo electrónico" required>
        <input type="tel" name="telefono" class="form-control form-control-sm mb-3" placeholder="Teléfono" required>
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">📄 Generar Cotización</button>
    </form>
        
    </div>
  </div>
</div>

<div class="modal fade" id="quoteModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-start">
      <div class="modal-body p-4">
        <div class="text-center mb-4">
            <h1 class="text-success mb-2">✅</h1>
            <h4 class="fw-bold">¡Cotización Creada!</h4>
        </div>
        
        <div class="bg-light border rounded p-3 mb-4">
            <h6 class="fw-bold border-bottom pb-2 mb-3">Detalles de la Cotización</h6>
            <p class="mb-1"><strong>Código:</strong> <span class="badge bg-primary fs-6" id="modal-codigo"></span></p>
            <p class="mb-1"><strong>Cliente:</strong> <span id="modal-cliente"></span></p>
            <p class="mb-1"><strong>Empresa:</strong> <span id="modal-empresa"></span></p>
            <hr class="my-2">
            <p class="mb-1 small"><strong>Emisión:</strong> <span id="modal-fecha"></span></p>
            <p class="mb-0 small"><strong>Válida hasta:</strong> <span id="modal-validez" class="text-danger fw-bold"></span></p>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
            <a href="pages/view-quotes.php" class="btn btn-primary px-4">Ver Historial</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/services-catalog.js"></script>
</body>
</html>