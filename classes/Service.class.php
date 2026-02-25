<?php

class Service {

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;

    // Categorías válidas
    const CATEGORIAS = ['Desarrollo Web', 'Marketing', 'Soporte Técnico'];

    const PRECIO_MIN = 50;
    const PRECIO_MAX = 10000;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria) {

        $this->validarDatos($nombre, $descripcion, $precio, $categoria);

        $this->id = $id;
        $this->nombre = htmlspecialchars($nombre);
        $this->descripcion = htmlspecialchars($descripcion);
        $this->precio = floatval($precio);
        $this->categoria = $categoria;
    }

    private function validarDatos($nombre, $descripcion, $precio, $categoria) {

        if (empty($nombre) || empty($descripcion)) {
            throw new Exception("Nombre y descripción son obligatorios");
        }

        if ($precio < self::PRECIO_MIN || $precio > self::PRECIO_MAX) {
            throw new Exception("Precio fuera de rango permitido");
        }

        if (!in_array($categoria, self::CATEGORIAS)) {
            throw new Exception("Categoría inválida");
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public static function getCatalogoCompleto() {
        return [
            ["obj" => new self(1, "Diseño Web Básico", "Sitio web informativo responsive", 600, "Desarrollo Web"), "img" => "assets/img/diseno-web-basico.jpg", "delivery" => "Entrega 5 días"],
            ["obj" => new self(2, "Tienda Online", "E-commerce completo", 1200, "Desarrollo Web"), "img" => "assets/img/tienda-online.jpg", "delivery" => "Listo en 7 días hábiles"],
            ["obj" => new self(3, "Landing Page", "Página optimizada para conversión", 450, "Desarrollo Web"), "img" => "assets/img/landing page.webp", "delivery" => "Implementación en 3 días"],
            ["obj" => new self(4, "SEO Básico", "Optimización para buscadores", 500, "Marketing"), "img" => "assets/img/seo-basico.webp", "delivery" => "Resultados en 15 días"],
            ["obj" => new self(5, "Publicidad en Redes", "Campañas digitales", 700, "Marketing"), "img" => "assets/img/publicidad-redes.jpg", "delivery" => "Campañas en 10 días"],
            ["obj" => new self(6, "Email Marketing", "Automatización de correos", 650, "Marketing"), "img" => "assets/img/email-marketing.webp", "delivery" => "Configuración en 4 días"],
            ["obj" => new self(7, "Soporte Técnico Mensual", "Mantenimiento empresarial", 300, "Soporte Técnico"), "img" => "assets/img/soporte-tecnico.webp", "delivery" => "Disponible el mismo día"],
            ["obj" => new self(8, "Instalación de Redes", "Configuración de red empresarial", 900, "Soporte Técnico"), "img" => "assets/img/instalacion-redes.webp", "delivery" => "Instalación en 2 días"],
            ["obj" => new self(9, "Respaldo de Información", "Backup y recuperación de datos", 400, "Soporte Técnico"), "img" => "assets/img/respaldo-informacion.webp", "delivery" => "Backup programado inmediato"],
            ["obj" => new self(10, "Auditoría Web", "Análisis técnico completo", 700, "Desarrollo Web"), "img" => "assets/img/auditoria-web.webp", "delivery" => "Informe en 5 días"],
            ["obj" => new self(11, "Branding Empresarial", "Diseño de identidad visual", 1100, "Marketing"), "img" => "assets/img/branding-empresarial.webp", "delivery" => "Propuesta en 6 días"],
            ["obj" => new self(12, "Seguridad Informática", "Protección contra vulnerabilidades", 1500, "Soporte Técnico"), "img" => "assets/img/seguridad-informatica.webp", "delivery" => "Evaluación en 8 días"],
        ];
    }
}