<html>

<body>
    <?php

    //Creamos un objeto PDO para establecer la conexión
    
    require_once 'libreriaPDO.php';

    function SigIdFoto($IdPro)   //Función que nos indica cual es el siguiente IdFoto para ese producto
    {
        global $db;

        $consulta = "SELECT max(IdFoto) as UltId
              FROM FotosProB
              Where IdPro=:IdPro";

        $param = array(":IdPro" => $IdPro);

        $db->onsultaDatos($consulta, $param);

        $fila = $db->filas[0];

        $IdFotS = $fila['UltId'] + 1;

        return $IdFotS;

    }

    $db = new DB("Tema2Blobs");


    $pro = "";

    if (isset($_POST['Producto'])) {
        $pro = $_POST['Producto'];
    }


    if (isset($_POST['Guardar'])) {
        if ($_FILES['NuevaF']['name'] != "")   //
        {
            $conte = file_get_contents($_FILES['NuevaF']['tmp_name']);

            $conte = base64_encode($conte);

            $IdFoto = SigIdFoto($pro);  //funcion devuelve el Id de la última foto para ese producto
    

            $consulta = "insert into FotosProB values(:IdPro,:IdFoto,:Foto)";

            $param = array(":IdPro" => $pro, ":IdFoto" => $IdFoto, ":Foto" => $conte);

            $db->ConsultaSimple($consulta, $param);

        }


    }




    ?>


    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>

        <fieldset>
            <legend><b>Mostrar imagenes del Producto</b></legend>

            <label for='Producto'>Producto</label>

            <select name='Producto'>
                <option value=""></option>

                <?php

                $param = array();

                $consulta = "select Id,Nombre from Productos";

                $db->ConsultaDatos($consulta, $param);

                foreach ($db->filas as $fila) {
                    echo "<option value=$fila[Id] ";

                    if ($pro == $fila['Id']) {
                        echo " selected ";
                    }

                    echo "> $fila[Nombre]</option>";
                }


                ?>

            </select>
            <br>

            <input type='submit' name='Mostrar' value='Mostrar'>

        </fieldset>

        <?php

        if (isset($_POST['Mostrar'])) {
            echo "<fieldset><legend><b>Imagenes del producto seleccionado</b></legend>";

            $consulta = "select IdFoto,Foto from FotosProB where IdPro=:IdPro";

            $param = array(":IdPro" => $pro);

            $db->ConsultaDatos($consulta, $param);

            foreach ($db->filas as $fila) {
                echo "<img src='data:image/jpg;base64,$fila[Foto]' width=70 height=70>";

            }

            echo "<input type='file' name='NuevaF' value='Nueva Foto'>";

            echo "<input type='submit' name='Guardar' value='Añadir Foto'>";



            echo "</fieldset>";
        }







        ?>




    </form>
</body>

</html>