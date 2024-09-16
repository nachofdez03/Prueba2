<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Familia.php';

class DaoFamilias extends DB
{
    public $familias = array();  //Array de objetos con el resultado de las consultas

    public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function listar()       //Lista el contenido de la tabla
    {
        $consulta = "select * from familia ";
        $param = array();

        $this->familias = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $fami = new Familia();

            $fami->__set("cod", $fila['cod']);
            $fami->__set("nombre", $fila['nombre']);

            $this->familias[] = $fami;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }
    }

    public function obtener($cod)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "select * from familia where Cod=:Cod";
        $param = array(":Cod" => $cod);

        $this->familias = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $fami = new Familia();

            $fami->__set("Cod", $fila['Cod']);
            $fami->__set("Nombre", $fila['Nombre']);

        } else {
            echo "<b>El Id introducido no corresponde con ninguna situación administrativa</b>";
        }

        return $fami;
    }

    public function borrar($cod)      //Elimina una situación de la tabla
    {
        $consulta = "delete from familia where Cod=:Cod";
        $param = array(":Cod" => $cod);

        $this->familias = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaSimple($consulta, $param);

    }

    public function insertar($fami)      //Recibe como parámetro un objeto con la situación administrativa
    {
        $consulta = "insert into Familia values(:Cod,:Nombre)";

        $param = array();

        $param[":Cod"] = $fami->__get("Cod");
        $param[":Nombre"] = $fami->__get("Nombre");

        $this->ConsultaSimple($consulta, $param);

    }

    public function actualizar($fami)     //Recibimos como parámetro un objeto con los datos a actualizar   
    {
        $consulta = "update Familia set Nombre=:Nombre where Cod=:Cod";

        $param = array();

        $param[":Cod"] = $fami->__get("Cod");
        $param[":Nombre"] = $fami->__get("Nombre");

        $this->ConsultaSimple($consulta, $param);


    }




}

?>