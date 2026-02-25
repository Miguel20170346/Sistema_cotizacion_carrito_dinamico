<?php
session_start();
$quotes = $_SESSION['quotes'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cotizaciones - ServicePOO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark shadow py-3">
  <div class="container">
    <span class="navbar-brand fw-bold fs-4">
        📄 Historial de Cotizaciones
    </span>
    <a href="../index.php" class="btn btn-outline-light">
        ⬅ Volver al Catálogo
    </a>
  </div>
</nav>

<div class="container py-5">
    <?php if (empty($quotes)): ?>
        <div class="alert alert-info text-center shadow-sm">
            <h4>No hay cotizaciones generadas aún.</h4>
            <p>Ve al catálogo, agrega servicios al carrito y genera tu primera cotización.</p>
            <a href="../index.php" class="btn btn-primary mt-2">Ir al Catálogo</a>
        </div>
    <?php else: ?>
        
        <div class="table-responsive d-none d-md-block shadow-sm bg-white rounded p-3">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Vencimiento</th> 
                        <th>Emisión</th> 
                        <th>Cant. Servicios</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($quotes) as $q): 
                        // Calculamos el total de items comprados
                        $totalItems = array_sum(array_column($q['items'], 'cantidad'));
                    ?>
                        <tr>
                            <td><span class="badge bg-primary fs-6"><?= $q['codigo'] ?></span></td>
                            <td><?= htmlspecialchars($q['cliente']['nombre']) ?></td>
                            <td><span class="text-danger fw-bold"><?= date('d/m/Y h:i A', strtotime($q['validez'])) ?></span></td>
                            <td><?= date('d/m/Y h:i A', strtotime($q['fecha'])) ?></td>
                            <td><?= $totalItems ?> servicios</td>
                            <td class="fw-bold text-success">$<?= number_format($q['total'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-md-none">
            <h5 class="mb-3 text-muted">Tus Cotizaciones</h5>
            <?php foreach (array_reverse($quotes) as $q): 
                $totalItems = array_sum(array_column($q['items'], 'cantidad'));
            ?>
                <div class="card mb-3 shadow-sm border-0 border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary"><?= $q['codigo'] ?></span>
                            <span class="fw-bold text-success fs-5">$<?= number_format($q['total'], 2) ?></span>
                        </div>
                        <h6 class="card-title fw-bold mb-1"><?= htmlspecialchars($q['cliente']['nombre']) ?></h6>
                        <p class="text-muted small mb-2">📅 <?= date('d/m/Y', strtotime($q['fecha'])) ?></p>
                        <p class="text-muted small mb-1">📅 Emisión: <?= date('d/m/Y', strtotime($q['fecha'])) ?></p>
                        <p class="text-danger small fw-bold mb-2">⏳ Válida hasta: <?= date('d/m/Y', strtotime($q['validez'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>