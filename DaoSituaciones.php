<?php
// Necesitamos incluir la libreria y la clase identidad asociada al DAO

require_once('LibreriaPDO.php');
require_once('Situacion.php');

// Define la clase DaoSituaciones que extiende de DB (esta representa la conexion a la BBDD),
// y contiene metodos para realizar operaciones CRUD en la tabla situaciones utilizando objetos
// de la clase Situacion
class DaoSituaciones extends DB
{
    public $situaciones = array(); // Array de objetos con el resultado de las consultas

    public function __construct($base) // Al instanciar el dao especificamos la bd
    {
        $this->dbname = $base;
    }

    public function listar()
    {
        $consulta = "select * from situaciones ";
        $param = array();

        // Si el parametro de la funcion fuera $id
        // $consulta = "select * from situaciones where id =: id ";
        // $param = array(":id" => $id);

        // Es la propiedad de la clase pero con esto nos aseguramos que el array este vacio
        $this->situaciones = array();

        $this->consultaDatos($consulta, $param);

        // Itera sobre las filas obtenidas y construye objetos Situacion
        // Se guardaran los resultados del foreach en la propiedad/array situaciones

        foreach ($this->filas as $fila) {
            $situacion = new Situacion();

            // Establece las propiedades del objeto Situacion
            $situacion->__set("Id", $fila['Id']);
            $situacion->__set("Nombre", $fila['Nombre']);

            // El [] indica que estas agregando un nuevo objeto de situaciones  al final del array
            $this->situaciones[] = $situacion;
        }
    }

    public function obtener($Id)
    {
        $consulta = "select from situaciones where Id = :Id";
        $param = array(":Id" => $Id);

        $this->ConsultaDatos($consulta, $param);

        foreach ($this as $key => $value) {
            # code...
        }

    }

    public function borrar($Id)
    {
        $consulta = "delete from situaciones where Id=:Id";

        $param = array(":Id" => $Id);

        $this->situaciones = array();

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