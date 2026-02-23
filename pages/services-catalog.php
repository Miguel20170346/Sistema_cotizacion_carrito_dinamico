<?php
require_once __DIR__ . "/../clases/services.class.php";

$services = [
    [
        "obj" => new Service(1, "Diseño Web Básico", "Sitio web informativo responsive", 600, "Desarrollo Web"),
        "img" => "assets/img/diseno-web-basico.jpg"
    ],
    [
        "obj" => new Service(2, "Tienda Online", "E-commerce completo", 1200, "Desarrollo Web"),
        "img" => "assets/img/tienda-online.jpg"
    ],
    [
        "obj" => new Service(3, "Landing Page", "Página optimizada para conversión", 450, "Desarrollo Web"),
        "img" => "assets/img/landing page.webp"
    ],
    [
        "obj" => new Service(4, "SEO Básico", "Optimización para buscadores", 500, "Marketing"),
        "img" => "assets/img/seo-basico.webp"
    ],
    [
        "obj" => new Service(5, "Publicidad en Redes", "Campañas digitales", 700, "Marketing"),
        "img" => "assets/img/publicidad-redes.jpg"
    ],
    [
        "obj" => new Service(6, "Email Marketing", "Automatización de correos", 650, "Marketing"),
        "img" => "assets/img/email-marketing.webp"
    ],
    [
        "obj" => new Service(7, "Soporte Técnico Mensual", "Mantenimiento empresarial", 300, "Soporte Técnico"),
        "img" => "assets/img/soporte-tecnico.webp"
    ],
    [
        "obj" => new Service(8, "Instalación de Redes", "Configuración de red empresarial", 900, "Soporte Técnico"),
        "img" => "assets/img/instalacion-redes.webp"
    ],
    [
        "obj" => new Service(9, "Respaldo de Información", "Backup y recuperación de datos", 400, "Soporte Técnico"),
        "img" => "assets/img/respaldo-informacion.webp"
    ],
    [
        "obj" => new Service(10, "Auditoría Web", "Análisis técnico completo", 700, "Desarrollo Web"),
        "img" => "assets/img/auditoria-web.webp"
    ],
    [
        "obj" => new Service(11, "Branding Empresarial", "Diseño de identidad visual", 1100, "Marketing"),
        "img" => "assets/img/branding-empresarial.webp"
    ],
    [
        "obj" => new Service(12, "Seguridad Informática", "Protección contra vulnerabilidades", 1500, "Soporte Técnico"),
        "img" => "assets/img/seguridad-informatica.webp"
    ]
];
?>

<div class="row">
<?php foreach ($services as $item): 
    $service = $item["obj"];
?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg h-100 border-0">

            <img src="/Sistema_cotizacion_carrito_dinamico/assets/img/<?= basename($item['img']); ?>" 
                class="card-img-top"
                style="height:200px; object-fit:cover;">

            <div class="card-body d-flex flex-column">

                <h5 class="card-title"><?= $service->getNombre(); ?></h5>
                <p class="text-muted"><?= $service->getCategoria(); ?></p>
                <p><?= $service->getDescripcion(); ?></p>

                <h4 class="text-success mt-auto">
                    $<?= number_format($service->getPrecio(), 2); ?>
                </h4>

                <button class="btn btn-primary w-100 mt-2 add-to-cart"
                        data-id="<?= $service->getId(); ?>">
                    Agregar al carrito
                </button>

            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>