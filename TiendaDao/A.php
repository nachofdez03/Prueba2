<?php

session_start();    // Iniciamos la sesion

require_once 'DaoProductos.php';
require_once 'DaoStock.php';

$base = "tiendadao";

$daoProd = new DaoProductos($base);
$daoStock = new DaoStocks($base);

function obtener($productos, $solicitados)
{

    // La clave es el id/cod del producto
    foreach ($productos as $clave => $valor) {

        echo "hola + " . $clave;

        if (isset($_SESSION['cesta'][$clave])) {

            $_SESSION['cesta'][$clave] = $_SESSION['cesta'][$clave] + $solicitados[$clave];


        } else { // Si no existe lo creamos


            // Al compartir clave estará ligado
            $_SESSION['cesta'][$clave] = $solicitados[$clave];


        }

    }

}


if (isset($_POST['Selec']) || isset($_SESSION['cesta'])) {   // Si hemos seleccionado algun producto en los chexbox

    if (isset($_POST['Selec'])) {

        $productosCodigos = $_POST['Selec']; // Cogemos esos productos seleccionados
        $cantidades = $_POST['Solicitados']; // Recogemos las cantidades
        obtener($productosCodigos, $cantidades);

    }



    global $daoProd;

    echo "<b>---Contenido de la cesta---</b><br>";

    echo "<form method='post' action='A.php'>"; // Agregado un formulario

    echo "<fieldset>";

    echo "<table border='2'>";

    echo "<th>Eliminar</th><th>Cod</th><th>Nombre</th><th>Cantidad</th><th>Precio</th>";

    if (isset($_SESSION['cesta'])) {


        foreach ($_SESSION['cesta'] as $clave => $valor) {

            $pro = $daoProd->obtener($clave);

            echo "<tr>";

            echo "<td><input type='checkbox' name='Deletes[" . $clave . "]'></td>";

            echo "<td>" . $clave . "</td>";

            echo "<td>" . $pro->__get("nombre") . "</td>";

            echo "<td>" . $valor . "</td>";

            echo "<td>" . $pro->__get("PVP") . "</td>";

            echo "</tr>";

        }



        echo "</table>";
        echo "<br>";
        echo "<input type='submit' name='Borrar' value='Borrar de la cesta'>";
        echo "</fieldset>";

        echo "<br>";

        echo "<a href='Pedidos.php'> Continuar comprando </a>";

        echo "</form>";


    }

}

if ((isset($_POST['Borrar'])) && (isset($_POST['Deletes']))) {

    $deletes = $_POST['Deletes'];

    foreach ($deletes as $clave => $valor) {

        unset($_SESSION['cesta'][$clave]);

    }

    header("Location: A.php");  // Redirecciona después de realizar las eliminaciones

}

?>