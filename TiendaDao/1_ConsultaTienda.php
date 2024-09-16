<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ejercicio 1 TiendaDAO </title>
</head>

<body>

    <?php

    require_once 'DaoTiendas.php';
    require_once 'DaoFamilias.php';
    require_once 'DaoProductos.php';

    $base = "tiendadao";

    $tienda = "";

    if (isset($_POST['Tienda'])) {

        $tienda = $_POST['Tienda'];
    }

    $familia = "";

    if (isset($_POST['Familia'])) {
        $familia = $_POST['Familia'];
    }


    ?>

    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
        <fieldset>
            <legend> Mostrar productos segun tienda y familia</legend>

            <label for="Tienda">Tienda</label>
            <select name="Tienda">
                <option value=""></option>

                <?php

                // Instanciamos un daoTienda
                $daoTienda = new DaoTiendas($base);

                // Los listamos y se almacenaran en el array de tiendas de la clase
                $daoTienda->listar();

                foreach ($daoTienda->tiendas as $tiend) {

                    echo "<option value =" . $tiend->__get("cod");

                    if ($tienda == $tiend->__get("cod")) {
                        echo " selected ";
                    }

                    echo ">" . $tiend->__get("nombre") . "</option>";
                }

                ?>

            </select>

            <label for="Familia">Familia</label>
            <select name="Familia">
                <option value=""></option>
                <?php

                $daoFamilia = new DaoFamilias($base);
                $daoFamilia->listar();

                foreach ($daoFamilia->familias as $family) {

                    echo "<option value=" . $family->__get("cod");

                    if ($familia == $family->__get("cod")) {

                        echo " selected ";

                    }

                    echo ">" . $family->__get("nombre") . " </option>";
                }

                ?>
            </select>
            <input type='submit' name='Mostrar' value='Mostrar'>
        </fieldset>

    </form>

    <?php

    if (isset($_POST['Mostrar'])) {

        echo "<fieldset><legend>Productos de la familia $familia</legend>";

        // Ahora vamos a instanciar un daoProductos para conseguir todos los productos que coincidad con la seleccion en el despegable
    
        $daoProductos = new DaoProductos($base);

        $daoProductos->listFamTien($familia, $tienda);

        echo "<table border='2'>";
        echo "<th>Cod</th><th>Nombre</th><th>Descripcion</th><th>PVP</th><th>Familia</th>";

        foreach ($daoProductos->productos as $produ) {

            echo "<tr>";

            echo "<td>" . $produ->__get("cod") . "</td>";
            echo "<td>" . $produ->__get("nombre") . "</td>";
            echo "<td>" . $produ->__get("descripcion") . "</td>";
            echo "<td>" . $produ->__get("PVP") . "</td>";
            echo "<td>" . $produ->__get("familia") . "</td>";

            echo "</tr>";

        }


        echo "</table>";



        echo "</fieldset>";
    }




    ?>

</body>

</html>