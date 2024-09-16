<?php

class Importe
{
    private $cod;
    private $PVP;
    private $total_dinero;

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