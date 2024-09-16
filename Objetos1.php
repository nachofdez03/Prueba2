<?php

class Persona{

    public $nombre;
    public $apellido1;
    private $fechaNac;
    public static $tipo_sangre = 'A+';

    function __construct($nom,$ape,$fech){ // Método magico que implementa el constructor

        $this->nombre=$nom;
        $this->apellido1=$ape;
        $this->fechaNac=$fech;
    }

    public function getFecha(){
        return $this->fechaNac;
    }

    public function __get($propiedad){
        return $this->$propiedad;
    }

    public function __set($propiedad,$valor){
        $this->$propiedad = $valor;
    }
}

$p1 = new Persona("Steven","Stifleeer","01/02/1970");
$p2 = new Persona("Nacho","Fernández","01/01/2003");

$p2::$tipo_sangre = "0-";

echo "Los datos de las personas creadas son:<br> ";
echo $p1->nombre."<br>";
echo $p1->getFecha();
echo "<br>";
echo $p1->__get("nombre")." ".$p1->__get("apellido1")." ".$p1->__get("fechaNac");

$p1->__set("nombre","Steve");
$p1->__set("apellido1","Stifler");
$p1->__set("fechaNac","1/1/1999");

echo "<br>";
echo "Los datos de las personas modificadas son:<br> ";
echo $p1->__get("nombre")." ".$p1->__get("apellido1")." ".$p1->__get("fechaNac");



?>