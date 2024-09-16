<html>

<body>
    <?php

    require_once 'DaoTiendas.php';
    require_once 'DaoFamilias.php';
    require_once 'DaoProductos.php';
    require_once 'DaoStock.php';

    function FormAlta($cod)
    {
        global $base;

        echo "<fieldset><legend>Proceda al alta del producto</legend>";

        echo "Cod<input type='text' name='cod' value='$cod' readonly='readonly'><br>";
        echo "Nombre <input type='text' name='nombre' value=''><br>";

        echo "Descripción<textarea name='descripcion' rows='3' cols='40'></textarea><br>";
        echo "PVP<input type='text' name='PVP' value=''><br>";

        echo "Familia<select name='familia' >";
        echo "<option value=''></option>";

        $daoFami = new DaoFamilias($base);

        $daoFami->listar();

        $familia = '';

        foreach ($daoFami->familias as $fami) {
            echo "<option value=" . $fami->__get("cod");

            if ($familia == $fami->__get("cod")) {
                echo " selected ";
            }

            echo ">" . $fami->__get("nombre") . "</option>";
        }

        echo "</select></br>";

        echo "Foto<input type='file' name='Foto'><br>";

        echo "<br>";

        echo "<input type='submit' name='Alta' value='Alta'>";

        echo "</fieldset>";

    }

    function FormStock($cod)
    {
        global $base;

        echo "<fieldset><legend>Seleccione la tienda y la cantidad para ese producto</legend>";

        echo "Cod<input type='text' name='cod' value='$cod' readonly='readonly'><br>";

        echo "Tienda<select name='tienda' >";
        echo "<option value=''></option>";

        $daoTien = new DaoTiendas($base);

        $daoTien->listar();

        $tienda = '';

        foreach ($daoTien->tiendas as $tien) {
            echo "<option value=" . $tien->__get("cod");

            if ($tienda == $tien->__get("cod")) {
                echo " selected ";
            }

            echo ">" . $tien->__get("nombre") . "</option>";
        }

        echo "</select>";

        echo "Cantidad <input type='number' name='cantidad' value=''><br>";


        echo "<input type='submit' name='Stock' value='Almacenar'>";

        echo "</fieldset>";

    }

    $base = "tiendadao";


    if (isset($_POST['Alta'])) {
        $cod = $_POST['cod'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $PVP = $_POST['PVP'];
        $familia = $_POST['familia'];

        $conte = "";

        if ($_FILES['Foto']['name'] != "") {
            $temp = $_FILES['Foto']['tmp_name'];
            $conte = base64_encode(file_get_contents($temp));
        }


        $pro = new Producto();

        $pro->__set("cod", $cod);
        $pro->__set("nombre", $nombre);
        $pro->__set("descripcion", $descripcion);
        $pro->__set("PVP", $PVP);
        $pro->__set("familia", $familia);
        $pro->__set("Foto", $conte);

        $daoProd = new DaoProductos($base);

        $daoProd->insertar($pro);


    }

    if (isset($_POST['Stock']))    //Si hay que registrar el producto en la tabla Stock
    {
        $cod = $_POST['cod'];
        $tienda = $_POST['tienda'];
        $cantidad = $_POST['cantidad'];

        $sto = new Stock();

        $sto->__set("producto", $cod);
        $sto->__set("tienda", $tienda);
        $sto->__set("unidades", $cantidad);

        //echo " $cod $tienda $cantidad";
    
        $daoStock = new DaoStocks($base);

        $daoStock->insertar($sto);

    }






    $tienda = "";

    if (isset($_POST['Tienda'])) {
        $tienda = $_POST['Tienda'];
    }

    $cod = '';

    if (isset($_POST['CodPro'])) {
        $cod = $_POST['CodPro'];
    }

    if (isset($_POST['cod'])) {
        $cod = $_POST['cod'];
    }



    ?>


    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>

        <fieldset>
            <legend><b>Introduzca el código del producto a almacenar</b></legend>



            <label for='CodPro'>Producto</label>
            <input type='text' name='CodPro' value='<?php echo $cod; ?>'>

            <input type='submit' name='Comprobar' value='Comprobar'>
            <br>

            <?php

            if (isset($_POST['Comprobar'])) {

                $daoProd = new DaoProductos($base);

                $producto = $daoProd->obtener($cod);

                if ($producto == null) {
                    FormAlta($cod);     //Fomrulario de alta de un producto
                } else {
                    FormStock($cod);  //Formulario de alta en tabla Stock
                }


            }

            ?>

        </fieldset>
    </form>
</body>

</html>