<html>

<?php

require_once 'DaoProductos.php';
$carpeta = "Fotos";
$base = "tiendadao";

session_start();

$cod = '';

if (isset($_POST['Cod'])) {
    $cod = $_POST['Cod'];
}

$nom = '';

if (isset($_POST['Nombre'])) {
    $nom = $_POST['Nombre'];
}

$desc = '';

if (isset($_POST['Descripcion'])) {
    $desc = $_POST['Descripcion'];
}

$pvp = '';

if (isset($_POST['PVP'])) {
    $pvp = $_POST['PVP'];
}

$fam = '';

if (isset($_POST['Fam'])) {
    $fam = $_POST['Fam'];
}

?>

<body>

    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>

        <fieldset>
            <legend>Alta de Productos</legend>

            <label for='Cod'>Código </label><input type='text' name='Cod' value='<?php echo $cod; ?>'>
            <p></p>
            <label for='Nombre'>Nombre </label><input type='text' name='Nombre' value='<?php echo $nom; ?>'>
            <p></p>
            <label for='Descripcion'>Descripción </label><input type='text' name='Descripcion'
                value='<?php echo $desc; ?>'>
            <p></p>
            <label for='PVP'>PVP </label><input type='text' name='PVP' value='<?php echo $pvp; ?>'>
            <p></p>
            <label for='Fam'>Familia </label><input type='text' name='Fam' value=<?php echo $fam; ?>>
            <p></p>
            <input type='file' name='Foto'>
            <p></p>

            <input type='submit' name='Alta' value='Alta'>
            <input type='submit' name='Buscar' value='Buscar'>
            <input type='submit' name='Volcar' value='Volcar'>

        </fieldset>
    </form>

    <?php

    if (isset($_POST['Alta'])) {

        $logoConte = "";

        if ($_FILES['Foto']['tmp_name'] != "") {

            $nomTemp = $_FILES['Foto']['tmp_name'];

            $logoConte = file_get_contents($nomTemp); //Extraemos el contenido en una variable
    
            $logoConte = base64_encode($logoConte); // Codificamos el archivo en base_64 para evitar errores y mostrarlo de manera efectiva. 
        }

        $prod = new Producto();

        $prod->__set("cod", $cod);
        $prod->__set("nombre", $nom);
        $prod->__set("descripcion", $desc);
        $prod->__set("PVP", $pvp);
        $prod->__set("familia", $fam);
        $prod->__set("Foto", $logoConte);


        $_SESSION['Producto'][$prod->__get("cod")] = $prod;

    }

    if (isset($_POST['Buscar'])) {

        echo "<b>---Contenido de la sesión---</b><br>";

        echo "<fieldset>";

        echo "<table border='2'>";

        echo "<th>Cod</th><th>Nombre</th><th>Descripción</th><th>PVP</th><th>Familia</th><th>Foto</th>";

        foreach ($_SESSION['Producto'] as $clave => $valor) {

            if ($clave == $cod) {

                echo "<tr>";

                echo "<td>" . $clave . "</td>";

                echo "<td>" . $valor->__get("nombre") . "</td>";

                echo "<td>" . $valor->__get("descripcion") . "</td>";

                echo "<td>" . $valor->__get("PVP") . "</td>";

                echo "<td>" . $valor->__get("familia") . "</td>";

                echo "<td><img src='data:Fotos/jpg;base64," . $valor->__get("Foto") . "' width='80' height='80'></td>";

                echo "</tr>";

            }

        }


        echo "</table>";
        echo "</fieldset>";

    }

    if (isset($_POST['Volcar'])) {

        foreach ($_SESSION['Producto'] as $clave => $valor) {

            $daoProd = new DaoProductos($base);

            $daoProd->insertar($valor);

        }

        session_destroy();

    }

    ?>

</body>




</html>