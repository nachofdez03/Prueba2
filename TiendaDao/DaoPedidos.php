<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Pedido.php';

class DaoPedidos extends DB
{
    public $pedidos = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function insertar($pedido)      //Recibe como parámetro un objeto con la situación administrativa
    {
        $consulta = "insert into pedido values(:Id,:Cliente,:Fecha)";

        $param = array();

        $param[":Id"] = $pedido->__get("Id");
        $param[":Cliente"] = $pedido->__get("Cliente");
        $param[":Fecha"] = $pedido->__get("Fecha");

        $this->ConsultaSimple($consulta, $param);


    }



    public function obtener($cod)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "select * from producto where cod=:cod";
        $param = array(":cod" => $cod);

        $this->pedidos = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        $pro = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno 

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $pro = new Pedido();

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

        $this->pedidos = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $pro = new Pedido();

            $pro->__set("cod", $fila['cod']);
            $pro->__set("nombre", $fila['nombre']);
            $pro->__set("descripcion", $fila['descripcion']);
            $pro->__set("PVP", $fila['PVP']);
            $pro->__set("familia", $fila['familia']);
            $pro->__set("Foto", $fila['Foto']);

            $this->pedidos[] = $pro;   //Insertamos el objeto con los valores de esa fila en el array de objetos

        }

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