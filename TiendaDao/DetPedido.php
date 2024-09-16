<?php

class DetPedido
{
    private $IdPed;
    private $IdPro;
    private $Cantidad;
    
    public function __get($propiedad)
    {
        return $this->$propiedad;
    }
    
    public function __set($propiedad,$valor)
    {
        $this->$propiedad=$valor;
    }
    
}

?>
