<?php
class Quote {
    private $items = []; // Formato: ['id' => ['service' => obj, 'qty' => n]]
    private $subtotal = 0;
    private $descuento = 0;
    private $iva = 0;
    private $total = 0;

    const IVA_RATE = 0.13; // Requerimiento: 13% [cite: 37]

    public function __construct($itemsInCart, $allServices) {
        $this->items = $this->mapearCarrito($itemsInCart, $allServices);
        $this->calcularTodo();
    }

    private function mapearCarrito($cart, $services) {
        $mapped = [];
        foreach ($cart as $id => $qty) {
            foreach ($services as $s) {
                if ($s['obj']->getId() == $id) {
                    $mapped[] = ['service' => $s['obj'], 'qty' => $qty];
                }
            }
        }
        return $mapped;
    }

    private function calcularTodo() {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item['service']->getPrecio() * $item['qty'];
        }

        // Reglas de Negocio: Opción A - Por Monto [cite: 54]
        if ($this->subtotal >= 2500) $porc = 0.15;
        elseif ($this->subtotal >= 1000) $porc = 0.10;
        elseif ($this->subtotal >= 500) $porc = 0.05;
        else $porc = 0;

        $this->descuento = $this->subtotal * $porc;
        $this->iva = ($this->subtotal - $this->descuento) * self::IVA_RATE;
        $this->total = ($this->subtotal - $this->descuento) + $this->iva;
    }

    public function getTotalesJSON() {
        return [
            "subtotal" => number_format($this->subtotal, 2),
            "descuento" => number_format($this->descuento, 2),
            "iva" => number_format($this->iva, 2),
            "total" => number_format($this->total, 2),
            "count" => array_sum(array_column($this->items, 'qty'))
        ];
    }
}