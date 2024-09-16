<?php

require_once 'LibreriaPDO2.php';

// $db = new DB("Tema2Blobs");

$consulta = "insert into Situaciones values(5, 'Despedido')";

$db->ConsultaSimple($consulta);

/*
$consulta = "select Nombre, Apellido1, Apellido2 from Alumnos";

$filas=$db->ConsultaDatos($consulta);

foreach($filas as $fila)
{
    echo $fila["Nombre"]." ".$fila["Apellido1"]." ".$fila["Apellido2"];

    echo "<br>";
}

echo "---Mostramos los profesores---<br>";

$consulta = "select Nombre, Apellido1, Apellido2 from Profesores";

$filas=$db->ConsultaDatos($consulta);

foreach($filas as $fila)
{
    echo $fila["Nombre"]." ".$fila["Apellido1"]." ".$fila["Apellido2"];

    echo "<br>";
}
*/
?>