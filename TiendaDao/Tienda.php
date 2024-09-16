<?php

class Tienda
{
    private $cod;
    private $nombre;
    private $tlf;

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