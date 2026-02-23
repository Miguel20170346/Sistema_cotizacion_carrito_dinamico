<?php

class Service {

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;

    // Categorías válidas (requerimiento del PDF)
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
}