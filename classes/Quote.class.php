<?php

class Quote {
    // 1. Propiedades privadas exigidas por el documento
    private $codigo;
    private $cliente;
    private $items = []; 
    private $subtotal = 0;
    private $descuento = 0;
    private $iva = 0;
    private $total = 0;

    const IVA_RATE = 0.13; // 13% de IVA

    public function __construct($itemsInCart, $allServices) {
        // Usamos el método agregarItem exigido para llenar el carrito
        foreach ($itemsInCart as $id => $qty) {
            $this->agregarItem($id, $qty, $allServices);
        }
        
        // Llamamos a los métodos de cálculo separados exigidos
        $this->calcularSubtotal();
        $this->calcularDescuento();
        $this->calcularIVA();
        $this->calcularTotal();
    }

    // 2. Método agregarItem()
    public function agregarItem($id, $qty, $services) {
        foreach ($services as $s) {
            if ($s['obj']->getId() == $id) {
                $this->items[] = ['service' => $s['obj'], 'qty' => $qty];
                break;
            }
        }
    }
    
    // 3. Método calcularSubtotal()
    public function calcularSubtotal() {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item['service']->getPrecio() * $item['qty'];
        }
        return $this->subtotal;
    }

    // 4. Método calcularDescuento()
    public function calcularDescuento() {
        if ($this->subtotal >= 2500) $porc = 0.15;
        elseif ($this->subtotal >= 1000) $porc = 0.10;
        elseif ($this->subtotal >= 500) $porc = 0.05;
        else $porc = 0;

        $this->descuento = $this->subtotal * $porc;
        return $this->descuento;
    }

    // 5. Método calcularIVA()
    public function calcularIVA() {
        $this->iva = ($this->subtotal - $this->descuento) * self::IVA_RATE;
        return $this->iva;
    }

    // 6. Método calcularTotal()
    public function calcularTotal() {
        $this->total = ($this->subtotal - $this->descuento) + $this->iva;
        return $this->total;
    }

    public function getTotalesJSON() {
        // NUEVO: Extraemos los detalles (nombre y subtotal individual) para el Frontend
        $itemsDetalle = [];
        foreach ($this->items as $item) {
            $id = $item['service']->getId();
            $itemsDetalle[$id] = [
                'nombre' => $item['service']->getNombre(),
                'subtotal' => number_format($item['service']->getPrecio() * $item['qty'], 2)
            ];
        }

        return [
            "subtotal" => number_format($this->subtotal, 2),
            "descuento" => number_format($this->descuento, 2),
            "iva" => number_format($this->iva, 2),
            "total" => number_format($this->total, 2),
            "count" => array_sum(array_column($this->items, 'qty')),
            "itemsDetalle" => $itemsDetalle // Lo enviamos a JavaScript
        ];
    }

    // 7. Método estático validarMonto()
    public static function validarMonto($subtotal) {
        return $subtotal >= 100;
    }

    // 8. Método estático generarCodigo()
    public static function generarCodigo() {
        if (!isset($_SESSION['quote_counter'])) {
            $_SESSION['quote_counter'] = 1;
        }
        $num = str_pad($_SESSION['quote_counter'], 4, '0', STR_PAD_LEFT);
        $year = date('Y');
        $_SESSION['quote_counter']++; 
        
        return "COT-{$year}-{$num}";
    }

    // 9. Método generar()
    public function generar($clienteDatos) {
        $fechaActual = date('Y-m-d H:i:s');
        $validez = date('Y-m-d H:i:s', strtotime('+7 days'));
        
        // Asignamos a las propiedades privadas exigidas
        $this->codigo = self::generarCodigo();
        $this->cliente = $clienteDatos;

        $itemsGuardar = [];
        foreach ($this->items as $item) {
            $itemsGuardar[] = [
                'nombre' => $item['service']->getNombre(),
                'precio' => $item['service']->getPrecio(),
                'cantidad' => $item['qty']
            ];
        }

        $cotizacion = [
            'codigo' => $this->codigo,
            'cliente' => $this->cliente,
            'fecha' => $fechaActual,
            'validez' => $validez,
            'items' => $itemsGuardar,
            'subtotal' => round($this->subtotal, 2),
            'descuento' => round($this->descuento, 2),
            'iva' => round($this->iva, 2),
            'total' => round($this->total, 2)
        ];

        if (!isset($_SESSION['quotes'])) {
            $_SESSION['quotes'] = [];
        }
        $_SESSION['quotes'][] = $cotizacion;

        return $cotizacion;
    }
}