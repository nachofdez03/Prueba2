<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Stock.php';

class DaoStocks extends DB
{
    public $stocks = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function insertar($stock)      //Recibe como parámetro un objeto con la situación administrativa
    {
        $consulta = "insert into stock values(:producto,:tienda,:unidades)";

        $param = array();

        $param[":producto"] = $stock->__get("producto");
        $param[":tienda"] = $stock->__get("tienda");
        $param[":unidades"] = $stock->__get("unidades");

        $this->ConsultaSimple($consulta, $param);


    }



    public function obtener($cod)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "select * from producto where cod=:cod";
        $param = array(":cod" => $cod);

        $this->stocks = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        $pro = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno 

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $pro = new Producto();

            $pro->__set("cod", $fila['cod']);
            $pro->__set("nombre", $fila['nombre']);
            $pro->__set("descripcion", $fila['descripcion']);
            $pro->__set("PVP", $fila['PVP']);
            $pro->__set("familia", $fila['familia']);
            $pro->__set("Foto", $fila['Foto']);

        }

        return $pro;  //Retornamos el objeto con los datos del producto
    }

    public function listFamTien($familia, $tienda)       //Lista los productos de una familia
    {
        $consulta = "SELECT p.*
                FROM  producto p, stock s
                where p.cod=s.producto and p.familia=:familia and s.tienda=:tienda; ";

        $param = array(":familia" => $familia, ":tienda" => $tienda);

        $this->stocks = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $pro = new Producto();

            $pro->__set("cod", $fila['cod']);
            $pro->__set("nombre", $fila['nombre']);
            $pro->__set("descripcion", $fila['descripcion']);
            $pro->__set("PVP", $fila['PVP']);
            $pro->__set("familia", $fila['familia']);
            $pro->__set("Foto", $fila['Foto']);

            $this->stocks[] = $pro;   //Insertamos el objeto con los valores de esa fila en el array de objetos

        }

    }

    public function haysuficienteStock($cod, $cantidad)
    {

        $condicion = true;

        $consulta = "SELECT SUM(:unidades) as unidades where producto=:cod";
        $param = array(":cod" => $cod, ":cantidad" => $cantidad);

        $this->stocks = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        if ($this->filas[0]['unidades'] > $cantidad) {

            $condicion = false;
        }

        return $condicion;

    }



}

?>