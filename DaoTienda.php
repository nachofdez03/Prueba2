<?php
// Necesitamos incluir la libreria y la clase identidad asociada al DAO

require_once('LibreriaPDO.php');
require_once('Tienda.php');

class DaoTienda extends DB
{
    public $tienda = array(); // Array de objetos con el resultado de las consultas

    public function __construct($base) // Al instanciar el dao especificamos la bd
    {
        $this->dbname = $base;
    }

    public function listar()
    {
        $consulta = "select * from tienda";
        $param = array();

        $this->tienda = array();

        $this->consultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $tienda = new Tienda();

            $tienda->__set("cod", $fila['cod']);
            $tienda->__set("nombre", $fila['nombre']);
            $tienda->__set("tlf", $fila['tlf']);

            $this->tienda[] = $tienda;
        }
    }

    public function obtener($Id)
    {
        $consulta = "select * from tienda where Id=:Id";
        $param = array(":Id" => $Id);

        $this->tienda = array();

        $this->consultaDatos($consulta, $param);

        $situacion = new Tienda();

        if (count($this->filas) == 1) {

            $fila = $this->filas[0];

            $situacion->__set("Id", $fila['Id']);
            $situacion->__set("Nombre", $fila['Nombre']);

        } else {
            echo "<b>El Id introducido no corresponde con la situación Administrativa</b>";
        }

        return $situacion;
    }

    public function borrar($Id)
    {
        $consulta = "delete from situaciones where Id=:Id";

        $param = array(":Id" => $Id);

        $this->tienda = array();

        $this->consultaSimple($consulta, $param);
    }

    public function insertar($situ)
    {
        $consulta = "insert into situaciones values(:Id, :Nombre)";

        $param = array();

        $param[":Id"] = $situ->__get("Id");
        $param[":Nombre"] = $situ->__get("Nombre");

        $this->consultaSimple($consulta, $param);
    }

    public function actualizar($situ)
    {
        $consulta = "update situaciones set Nombre=:Nombre where Id=:Id";

        $param = array();

        $param[":Id"] = $situ->__get("Id");
        $param[":Nombre"] = $situ->__get("Nombre");

        $this->consultaSimple($consulta, $param);
    }

}

?>