<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    require_once "LibreriaPDO.php";
    require_once "Alumno";
    function FechaValida($fecha)    //Recibimos la fecha en formato dd/mm/yyyy
    {
        $valida = FALSE;

        $campos = explode("/", $fecha);

        if (($campos[1] > 0) && ($campos[1] < 13)) {
            $Numdias = DiasMes($campos[1], $campos[2]);   //Comprobamos los dias de ese mes
    
            if (($campos[0] > 0) && ($campos[0] <= $Numdias)) {
                $valida = TRUE;
            }

        }

        return $valida;
    }

    if (isset($_POST['Guardar'])) {

        $nif = $_POST['Nif'];
        $nombre = $_POST['Nombre'];
        $apellido1 = $_POST['Apellido'];
        $apellido2 = $_POST['Apellido2'];
        $telefono = $_POST['Numero'];
        $premios = $_POST['Premios'];
        $fechaNac = $_POST['FechaNac'];

    }

    if ($_FILES['Foto']['Name'] != " ") {
        $temp = $_FILES['Foto']['Name'];
        $conte = file_get_contents($temps);
        $conte = base64_encode($conte);

    }




    ?>

    <form name="f1" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>

        <fieldset>
            <legend>Alta de alumnos</legend>
            <label for="Nif">Nif</label><input type="text" name="Nif" /><br>
            <label for="Nombre">Nombre</label><input type="text" name="Nombre" /><br>
            <label for="Apellido">Apellido1</label><input type="text" name="Apellido" /><br>
            <label for="Apellido2">Apellido2</label><input type="text" name="Apellido2" /><br>
            <label for="Numero">Telefono</label><input type="text" name="Numero" /><br>
            <label for="Premios">Premios</label><input type="number" name="Premios" /><br>
            <label for='FechaNac'>FechaNac: </label><input type='text' name='FechaNac' />
            <label for='Foto'>Foto: </label><input type='file' name='Foto' />


            <input type="submit" name="Guardar" value="Guardar" />
        </fieldset>
    </form>
</body>

</html>