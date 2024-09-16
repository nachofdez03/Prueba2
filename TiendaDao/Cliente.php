<?php

class Cliente
{
    private $NIF;
    private $Nombre;
    private $Apellido1;
    private $Apellido2;
    private $FechaNac;
    private $Sexo;
    private $Direccion;
    private $Estado;
    private $Telefono;
    private $CP;
    private $Foto;
    
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
