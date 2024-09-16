<html>
<?php

require_once 'DaoAlumnos.php';

$dao = new DaoAlumnos("Tema2Blobs");

if (isset($_POST['Guardar'])) {
  $nif = $_POST['NIF'];
  $nombre = $_POST['Nombre'];
  $apellido1 = $_POST['Apellido1'];
  $apellido2 = $_POST['Apellido2'];
  $telefono = $_POST['Telefono'];
  $premios = $_POST['Premios'];
  $fechaNac = $_POST['FechaNac'];

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

  $alu = new Alumno();

  $alu->__set("NIF", $nif);
  $alu->__set("Nombre", $nombre);
  $alu->__set("Apellido1", $apellido1);
  $alu->__set("Apellido2", $apellido2);
  $alu->__set("Telefono", $telefono);
  $alu->__set("Premios", $premios);
  $alu->__set("FechaNac", $fechaEpoch);
  $alu->__set("Foto", $foto);

  $dao->insertar($alu);

}

?>

<body>

  <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
    <fieldset>
      <legend>Datos de Alumnos</legend>

      <label for='NIF'>NIF </label><input type='text' name='NIF'><br>
      <label for='Nombre'>Nombre </label><input type='text' name='Nombre'><br>
      <label for='Apellido1'>Apellido1 </label><input type='text' name='Apellido1'><br>
      <label for='Apellido2'>Apellido2 </label><input type='text' name='Apellido2'><br>
      <label for='Telefono'>Telefono </label><input type='text' name='Telefono'><br>
      <label for='Premios'>Premios </label><input type='text' name='Premios'><br>
      <label for='FechaNac'>Fecha Nac </label><input type='text' name='FechaNac' placeholder='dd/mm/year'>
      <label for='Foto'>Foto</label><input type='file' name='Foto'>
      <input type='submit' name='Guardar' value='Guardar'>

    </fieldset>
  </form>
</body>

</html>