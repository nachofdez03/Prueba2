<html>
<?php

require_once 'DaoAlumnos.php';

$base = "Tema2Blobs";

$daoAlum = new DaoAlumnos($base);

function FotoAnterior($NIF)   //Recibimos el NIf y devolvemos la foto anterior
{
    global $daoAlum;

    $alu = $daoAlum->obtener($NIF);

    return $alu->__get("Foto");

}


function ConvertirLegible($fechaSeg)
{
    $campos = getdate($fechaSeg);

    $fechaLeg = $campos['mday'] . "/" . $campos['mon'] . "/" . $campos['year'];

    return $fechaLeg;
}




if (isset($_POST['Actualizar']) && isset($_POST['Selec']))  //ÇSi hemos seleccionado algun alumno y marcado actualizar
{

    $selec = $_POST['Selec']; //Recogemos los códigos del los checkboxes seleccionados

    //Recogemos el resto de los arrays con los datos de los alumnos

    $nombres = $_POST['Nombres'];
    $apellido1s = $_POST['Apellidos1'];
    $apellido2s = $_POST['Apellidos2'];
    $telefonos = $_POST['Telefonos'];
    $premioss = $_POST['Premios'];
    $fechaNacs = $_POST['Fechas'];


    foreach ($selec as $clave => $valor) //Para cada uno de los alumnos seleccinados
    {
        $camposFecha = explode("/", $fechaNacs[$clave]);  //Convertimos la fecha dd/mm/yyyy a segundos Epoch

        $fechaEpoch = mktime(0, 0, 0, $camposFecha[1], $camposFecha[0], $camposFecha[2]);

        $foto = FotoAnterior($clave); //Suponemos por defecto que el valor del campo foto es vacio

        if ($_FILES['Fotos']['name'][$clave] != '')   //Si hemos adjuntado el nombre de un archivo
        {

            $temp = $_FILES['Fotos']['tmp_name'][$clave];

            $conte = file_get_contents($temp);

            $conte = base64_encode($conte);

            $foto = $conte;
        }


        $alu = new Alumno();

        $alu->__set("NIF", $clave);
        $alu->__set("Nombre", $nombres[$clave]);
        $alu->__set("Apellido1", $apellido1s[$clave]);
        $alu->__set("Apellido2", $apellido2s[$clave]);
        $alu->__set("Telefono", $telefonos[$clave]);
        $alu->__set("Premios", $premioss[$clave]);
        $alu->__set("FechaNac", $fechaEpoch);
        $alu->__set("Foto", $foto);

        $daoAlum->actualizar($alu);  // Actualizamos ese alumno

    }


}

if (isset($_POST['Borrar']) && isset($_POST['Selec']))  //ÇSi hemos seleccionado algun alumno y marcado actualizar
{

    $selec = $_POST['Selec']; //Recogemos los códigos del los checkboxes seleccionados

    foreach ($selec as $clave => $valor) //Para cada uno de los alumnos seleccinados
    {
        $daoAlum->borrar($clave);  // Actualizamos ese alumno

    }


}

if (isset($_POST['Insertar']))  //Si hemos pulsado insertar
{
    $nif = $_POST['NIF'];
    $nombre = $_POST['Nombre'];
    $apellido1 = $_POST['Apellido1'];
    $apellido2 = $_POST['Apellido2'];
    $telefono = $_POST['Telefono'];
    $premios = $_POST['Premio'];
    $fechaNac = $_POST['Fecha'];

    $camposFecha = explode("/", $fechaNac);  //Convertimos la fecha dd/mm/yyyy a segundos Epoch

    $fechaEpoch = mktime(0, 0, 0, $camposFecha[1], $camposFecha[0], $camposFecha[2]);

    $foto = ""; //Suponemos por defecto que el valor del campo foto es vacio

    if ($_FILES['Foto']['name'] != '')   //Si hemos adjuntado el nombre de un archivo
    {

        $temp = $_FILES['Foto']['tmp_name'];

        $conte = file_get_contents($temp);

        $conte = base64_encode($conte);

        $foto = $conte;
    }

    /*
    
    echo "$nif $nombre $apellido1 $apellido2 $telefono $premios $fechaEpoch <br>";
    
    echo $foto;
    
    */

    $alu = new Alumno();

    $alu->__set("NIF", $nif);
    $alu->__set("Nombre", $nombre);
    $alu->__set("Apellido1", $apellido1);
    $alu->__set("Apellido2", $apellido2);
    $alu->__set("Telefono", $telefono);
    $alu->__set("Premios", $premios);
    $alu->__set("FechaNac", $fechaEpoch);
    $alu->__set("Foto", $foto);

    $daoAlum->insertar($alu);



}











?>


<body>
    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
        <fieldset>
            <legend><b>Mantenimiento(CRUD) de la tabla Alumnos</b></legend>

            <?php

            echo "<input type='submit' name='Actualizar' value='Actualizar'>";

            echo "<input type='submit' name='Borrar' value='Borrar'>";

            $daoAlum->listar();

            if (count($daoAlum->alumnos) > 0)    //Si he alumnos que listar
            {
                echo "<table border='2'>";
                echo "<th>Selec</th>
             <th>NIF</th>
             <th>Nombre</th>
             <th>Apellido1</th>
             <th>Apellido2</th>
             <th>Telefono</th>
             <th>Premios</th>
             <th>Fecha Nac</th>
             <th>Foto</th>";

                //Creamos la fila de insercción
            
                echo "<tr>";

                echo "<td><input type='submit' name='Insertar' value='Insertar'></td>";
                echo "<td><input type='text' name=NIF size='9'></td>";
                echo "<td><input type='text' name=Nombre size='9'></td>";
                echo "<td><input type='text' name=Apellido1 size='9'></td>";
                echo "<td><input type='text' name=Apellido2 size='9'></td>";
                echo "<td><input type='text' name=Telefono size='9'></td>";
                echo "<td><input type='text' name=Premio size='4' ></td>";

                echo "<td><input type='text' name=Fecha placeholder='dd/mm/yyyy' size='9' ></td>";

                echo "<td><input type='File' name='Foto'></td>";

                echo "</tr>";



                foreach ($daoAlum->alumnos as $alu) {
                    echo "<tr>";

                    echo "<td><input type='checkbox' name=Selec[" . $alu->__get("NIF") . "]></td>";
                    echo "<td>" . $alu->__get("NIF") . "</td>";
                    echo "<td><input type='text' name=Nombres[" . $alu->__get("NIF") . "] value=" . $alu->__get("Nombre") . " size='9'></td>";
                    echo "<td><input type='text' name=Apellidos1[" . $alu->__get("NIF") . "] value=" . $alu->__get("Apellido1") . " size='9'></td>";
                    echo "<td><input type='text' name=Apellidos2[" . $alu->__get("NIF") . "] value=" . $alu->__get("Apellido2") . " size='9'></td>";
                    echo "<td><input type='text' name=Telefonos[" . $alu->__get("NIF") . "] value=" . $alu->__get("Telefono") . " size='9'></td>";
                    echo "<td><input type='text' name=Premios[" . $alu->__get("NIF") . "] value=" . $alu->__get("Premios") . " size='4' ></td>";

                    $fechaLeg = ConvertirLegible($alu->__get("FechaNac"));  //Hay que convertir la fecha de nacimiento a formato legible
            
                    echo "<td><input type='text' name=Fechas[" . $alu->__get("NIF") . "] value=" . $fechaLeg . " size='9' ></td>";

                    $conte = $alu->__get("Foto");

                    echo "<td>";
                    echo "<img src='data:image/jpg;base64,$conte' width=70 height=70>";
                    echo "<input type='file' name='Fotos[" . $alu->__get("NIF") . "]'>";

                    echo "</td>";

                    echo "</tr>";
                }



                echo "</table>";
            }






            ?>
        </fieldset>
    </form>
</body>

</html>