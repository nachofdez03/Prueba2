<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Importe.php';


class DaoImporte extends DB
{
    public $importe = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function dineroProducto($orden)
    {

        $consulta = "SELECT p.cod, p.PVP, SUM(dp.Cantidad * p.PVP) as total_dinero FROM Producto p,
         detpedido dp WHERE p.cod = dp.IdPro GROUP BY p.cod ORDER BY total_dinero $orden limit 1";

        $param = array();

        $this->importe = array();

        $this->ConsultaDatos($consulta, $param);

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $importe = new Importe();

            $importe->__set("cod", $fila['cod']);
            $importe->__set("PVP", $fila['PVP']);
            $importe->__set("total_dinero", $fila['total_dinero']);

        }

        return $importe;


    }


}