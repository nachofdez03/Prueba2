<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Unidades.php';


class DaoUnidades extends DB
{
    public $unidades = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function Unidades($orden)
    {

        $consulta = "SELECT idPro, Cantidad FROM detPedido ORDER BY idPro $orden limit 1";
        $param = array();

        $this->unidades = array();

        $this->ConsultaDatos($consulta, $param);

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $unidades = new Unidades();

            $unidades->__set("idPro", $fila['idPro']);
            $unidades->__set("cantidad", $fila['Cantidad']);

        }

        return $unidades;


    }
}