<?php
require_once __DIR__ . "/../classes/Service.class.php";
require_once __DIR__ . "/../classes/Quote.class.php"; // 1. Agregamos la clase Quote

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($base === '/') $base = '';

$services = Service::getCatalogoCompleto();

// 2. Calculamos los datos del carrito actual directamente en PHP
$quote = new Quote($_SESSION['cart'], $services);
$initialCartData = json_encode([
    "cart" => $_SESSION['cart'],
    "totals" => $quote->getTotalesJSON()
]);
?>

<div class="row">
<?php foreach ($services as $item): 
    $service = $item["obj"];
?>
    <div class="col-md-4 mb-4">
        <div class="card custom-card shadow-lg h-100 border-0">

            <!-- Imagen -->
            <img src="<?= $base ?>/assets/img/<?= rawurlencode(basename($item['img'])); ?>" 
                 class="card-img-top" alt="<?= htmlspecialchars($service->getNombre()); ?>">

            <div class="card-body">

                <!-- Nombre -->
                <h4 class="fw-bold"><?= $service->getNombre(); ?></h4>
                <p class="text-primary fw-semibold"><?= $service->getCategoria(); ?></p>
                
                <!-- Descripción -->
                <p class="text-muted small mb-3">
                    <?= $service->getDescripcion(); ?>
                </p>

                <!-- Caja gris tipo especificaciones -->
                <div class="info-box d-flex justify-content-between">
                    <span>🛠 Servicio Profesional</span>
                    <span>⏱ <?= htmlspecialchars($item['delivery']); ?></span>
                </div>

                <!-- Precio verde -->
                <div class="price-box text-center">
                    $<?= number_format($service->getPrecio(), 2); ?>
                </div>

                <!-- Características -->
                <div class="tags mt-3">
                    <span>✔ Garantía</span>
                    <span>✔ Soporte</span>
                    <span>✔ Calidad</span>
                </div>

                <!-- Botones (solo añadir al carrito) -->
                <div class="d-flex gap-2 mt-4">
                    <button class="btn add-to-cart flex-grow-1"
                            data-id="<?= $service->getId(); ?>">
                        🛒 Añadir al carrito
                    </button>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<script>
    window.initialCartData = <?= $initialCartData ?>;
</script>