<?php

//conectar a bbdd pdo

$usuario = "root";
$clave = "";

$host = "localhost";
$dbname = "Tema2Blobs";

$dns = "mysql:host=$host;dbname=$dbname";

try {
    $pdo = new PDO($dns, $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//-----------------------------------------------------------
//consulta de datos

$consulta = "select * from Profesores";

$sta = $pdo->prepare($consulta);

$sta = $pdo->prepare($consulta);

$param = array();

$sta->execute($param);

//opcion 1

$filas = $sta->fetchAll(PDO::FETCH_ASSOC);

foreach ($filas as $fila) {
    echo $fila['Apellido1'] . " " . $fila['Apellido2'] . " " . $fila['Nombre'];
    echo "<br>";
}

/* opcion 2

while($fila=$sta->fetch(PDO::FETCH_ASSOC))
{
    echo $fila['Apellido1']." ".$fila['Apellido2']." ".$fila['Nombre'];
    echo "<br>";
}
*/

/* ejemplo simple con pdo

$nif = "11111111A";

$consulta = "delete from Profesores where NIF=:nif";

$sta=$pdo->prepare($consulta);

$param = array(":nif"=>$nif);

//$sta->bindParam(":nif", $nif);

$sta->execute($param);
*/

//para cerrar la conexion
$pdo = null;
?>