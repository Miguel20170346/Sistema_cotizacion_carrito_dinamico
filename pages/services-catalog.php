<?php
require_once __DIR__ . "/../clases/services.class.php";

$services = [
    ["obj" => new Service(1, "Diseño Web Básico", "Sitio web informativo responsive", 600, "Desarrollo Web"), "img" => "assets/img/diseno-web-basico.jpg", "delivery" => "Entrega 5 días"],
    ["obj" => new Service(2, "Tienda Online", "E-commerce completo", 1200, "Desarrollo Web"), "img" => "assets/img/tienda-online.jpg", "delivery" => "Listo en 7 días hábiles"],
    ["obj" => new Service(3, "Landing Page", "Página optimizada para conversión", 450, "Desarrollo Web"), "img" => "assets/img/landing page.webp", "delivery" => "Implementación en 3 días"],
    ["obj" => new Service(4, "SEO Básico", "Optimización para buscadores", 500, "Marketing"), "img" => "assets/img/seo-basico.webp", "delivery" => "Resultados en 15 días"],
    ["obj" => new Service(5, "Publicidad en Redes", "Campañas digitales", 700, "Marketing"), "img" => "assets/img/publicidad-redes.jpg", "delivery" => "Campañas en 10 días"],
    ["obj" => new Service(6, "Email Marketing", "Automatización de correos", 650, "Marketing"), "img" => "assets/img/email-marketing.webp", "delivery" => "Configuración en 4 días"],
    ["obj" => new Service(7, "Soporte Técnico Mensual", "Mantenimiento empresarial", 300, "Soporte Técnico"), "img" => "assets/img/soporte-tecnico.webp", "delivery" => "Disponible el mismo día"],
    ["obj" => new Service(8, "Instalación de Redes", "Configuración de red empresarial", 900, "Soporte Técnico"), "img" => "assets/img/instalacion-redes.webp", "delivery" => "Instalación en 2 días"],
    ["obj" => new Service(9, "Respaldo de Información", "Backup y recuperación de datos", 400, "Soporte Técnico"), "img" => "assets/img/respaldo-informacion.webp", "delivery" => "Backup programado inmediato"],
    ["obj" => new Service(10, "Auditoría Web", "Análisis técnico completo", 700, "Desarrollo Web"), "img" => "assets/img/auditoria-web.webp", "delivery" => "Informe en 5 días"],
    ["obj" => new Service(11, "Branding Empresarial", "Diseño de identidad visual", 1100, "Marketing"), "img" => "assets/img/branding-empresarial.webp", "delivery" => "Propuesta en 6 días"],
    ["obj" => new Service(12, "Seguridad Informática", "Protección contra vulnerabilidades", 1500, "Soporte Técnico"), "img" => "assets/img/seguridad-informatica.webp", "delivery" => "Evaluación en 8 días"],
];
?>

<div class="row">
<?php foreach ($services as $item): 
    $service = $item["obj"];
?>
    <div class="col-md-4 mb-4">
        <div class="card custom-card shadow-lg h-100 border-0">

            <!-- Imagen -->
            <img src="/Sistema_cotizacion_carrito_dinamico/assets/img/<?= basename($item['img']); ?>" 
                 class="card-img-top">

            <div class="card-body">

                <!-- Nombre -->
                <h4 class="fw-bold"><?= $service->getNombre(); ?></h4>
                <p class="text-primary fw-semibold"><?= $service->getCategoria(); ?></p>

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