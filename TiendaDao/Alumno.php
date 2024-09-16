<?php

class Alumno
{
    private $NIF;
    private $Nombre;
    private $Apellido1;
    private $Apellido2;
    private $Telefono;
    private $Premios;
    private $FechaNac;
    private $Foto;


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