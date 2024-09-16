<?php

// PDO (PHP Data Objects) es una extensión de PHP que proporciona 
// una interfaz uniforme para acceder a bases de datos en PHP, 
// permite interactuar con bases de datos de manera orientada a objetos

// Clase que interactua con una base de datos

class DB
{
    private $usuario = "root";
    private $clave = "";

    private $host = "localhost";
    protected $dbname = "Tema2blobs";

    private $pdo;

    public $filas = array();

    public function __construct($base)
    {
        $this->dbname = $base;

    }

    private function Conectar()
    {

        $dns = "mysql:host=$this->host;dbname=$this->dbname";

        try {
            $this->pdo = new PDO($dns, $this->usuario, $this->clave);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function ConsultaSimple($consulta, $param = array())
    {
        $this->Conectar();

        $sta = $this->pdo->prepare($consulta);

        if (!$sta->execute($param)) {
            echo "Error en la consulta";
        }

        $this->Cerrar();
    }


    public function ConsultaDatos($consulta, $param = array())
    {
        $this->Conectar();

        $sta = $this->pdo->prepare($consulta);

        $resul = $sta->execute($param);

        if ($resul) {

            $this->filas = $sta->fetchAll(PDO::FETCH_ASSOC);
            //  indica que quieres que las filas se devuelvan como arrays asociativos,
            //  donde los nombres de las columnas son las claves del array.

        } else {
            echo "Error en la consulta";
        }

        $this->Cerrar();

        return $this->filas;
    }

    private function Cerrar()
    {
        $this->pdo = null;
    }
}

?>