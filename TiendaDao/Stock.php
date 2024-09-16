<?php

class Stock
{
    private $producto;
    private $tienda;
    private $unidades;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }

}

?>