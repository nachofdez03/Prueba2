<?php

class Persona
{

    public $nombre;
    public $apellido1;



    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }



}

$per1 = array("nombre" => "Juan", "apellido1" => "Lopez");
$per2 = array("nombre" => "Pepe", "apellido1" => "Moreno");
$per3 = array("nombre" => "David", "apellido1" => "Suarez");

$personas = array();

$personas[] = $per1;
$personas[] = $per2;
$personas[] = $per3;

$personasObj = array();


// $p1 = new Persona();

foreach ($personas as $persona) {



    $p1->__set("nombre", $persona["nombre"]);
    $p1->__set("apellido1", $persona["apellido1"]);

    $personasObj[] = $p1;

}


foreach ($personasObj as $persona) {

    echo $p1->__get("nombre") . " " . $p1->__get("apellido1") . "<br>";

}



?>