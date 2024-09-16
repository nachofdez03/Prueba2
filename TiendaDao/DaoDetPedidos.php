<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'DetPedido.php';

class DaoDetPedidos extends DB
{
    public $detpedidos = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function insertar($detped)      //Recibe como parámetro un objeto con la situación administrativa
    {
        $consulta = "insert into detpedido values(:IdPed,:IdPro,:Cantidad)";

        $param = array();
        $param[":IdPed"] = $detped->__get("IdPed");
        $param[":IdPro"] = $detped->__get("IdPro");
        $param[":Cantidad"] = $detped->__get("Cantidad");

        $this->ConsultaSimple($consulta, $param);

    }

    public function recuperarId($cliente, $fecha)
    {

        $id = "";

        $consulta = "select Id=:Id from pedido where Cliente=:Cliente and Fecha=:Fecha";

        $param = array();
        $param[":Cliente"] = $cliente;
        $param[":Fecha"] = $fecha;

        $this->ConsultaDatos($consulta, $param);

        if (count($this->filas) == 1) {

            $id = $this->filas[0];

        }
        return $id;

    }
}
?>