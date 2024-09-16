<?php

session_start();

require_once 'DaoProductos.php';

$base = "tiendadao";

$daoProd = new DaoProductos($base);

function InsertarCesta($selec, $solic)
{

    foreach ($selec as $clave => $valor) {
        if (isset($_SESSION['cesta'][$clave]))  //Si eseproducto ya estaba en la cesta actualizaamos su cantidad
        {
            $_SESSION['cesta'][$clave] = $_SESSION['cesta'][$clave] + $solic[$clave];
        } else  // Sino inicializamos la cantidad de ese producto
        {
            $_SESSION['cesta'][$clave] = $solic[$clave]; //Insertariamos en la cesta una entrada para ese producto y la cantidad
        }
    }

}



function MostrarCesta()
{

    global $daoProd;

    $total = 0;

    echo "<b>---Contenido de la cesta---</b><br>";

    echo "<fieldset>";
    echo "<form name='f2' method='post' action='Cesta.php'>";

    echo "<table border='2'>";

    echo "<th>Eliminar</th><th>Cod</th><th>Nombre</th><th>Cantidad</th><th>Precio</th>";

    foreach ($_SESSION['cesta'] as $clave => $valor) {

        $pro = $daoProd->obtener($clave);

        echo "<tr>";

        echo "<td><input type='checkbox' name='Deletes[" . $clave . "]'></td>";

        echo "<td>" . $clave . "</td>";

        echo "<td>" . $pro->__get("nombre") . "</td>";

        echo "<td><input type='number' name='CantDelete[" . $clave . "]' value='" . $valor . "'></td>";

        echo "<td>" . $pro->__get("PVP") * $valor . "</td>";

        echo "</tr>";

        $total += ($pro->__get("PVP") * $valor);

    }

    echo "<th></th><th></th><th></th><th></th><th>Total</th>";

    echo "<tr>";

    echo "<td></td><td></td><td></td><td></td>";

    echo "<td>" . $total . "</td>";

    echo "</tr>";

    echo "</table>";

    echo "<br>";

    echo "<input type='submit' name='Borrar' value='Borrar de la cesta'>";


    echo "<a href='Pedidos.php'> Continuar comprando </a>";

    echo "</form>";

    echo "</fieldset>";
}


function CantidadesOk($selec, $solic)
{
    foreach ($selec as $clave => $valor) //Para los códigos de lo checkbox marcados
    {
        if ((!is_numeric($solic[$clave])) || ($solic[$clave] <= 0)) {
            return false;
        }
    }

    return true;
}




if (isset($_POST['Selec'])) // Con esto comprobamos si me llegan códigos de productos
{
    $selec = $_POST['Selec'];
    $solic = $_POST['Solicitados'];

    if (CantidadesOk($selec, $solic)) // Comprobamos que en todos los productos hay alguna cantidad
    {
        InsertarCesta($selec, $solic);
    } else // Lo redireccionamos a pagina de pedidos
    {
        echo "<b>Insercción no realizada!!!!</b><br>";
        echo "<b>Revise las cantidades de los productos seleccionados</b><br<br>";
        header("Refresh:3; url=Pedidos.php", true, 303);
    }


}

if (isset($_SESSION['cesta'])) // Si existe la cesta es porque tiene productos insertados
{

    MostrarCesta();

}

if (isset($_POST['Borrar']) && isset($_POST['Deletes'])) {
    $deletes = $_POST['Deletes'];
    $cantDeletes = $_POST['CantDelete'];

    foreach ($deletes as $key => $value) {

        if ($cantDeletes[$key] < $_SESSION['cesta'][$key]) {
            $_SESSION['cesta'][$key] = $_SESSION['cesta'][$key] - $cantDeletes[$key];
        } else {
            unset($_SESSION['cesta'][$key]);
        }
    }
}