
<?php

/*Pagina que empleando PDO vuelque el contenido de las fotos de la tabla FotosPro en la tabla FotosProBlob.
 * HAy que tenener en cuenta que en la primera las fotos están en la carpeta y hay que volcarlas como tipo blob en
 * el campo foto equivalente
 * 
 * 
 * 
 */
 

//Conectar a BBDD con PDO

$usuario="root";
$clave="";

$host="localhost";
$dbname="Tema2Blobs";

$dns="mysql:host=$host;dbname=$dbname";


try {
    $pdo = new PDO($dns, $usuario, $clave);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e)
{
    echo $e->getMessage();
    
}

$consulta="select * from FotosPro";

$sta=$pdo->prepare($consulta);  //Preparamos la consulta y recibimos el obejto de tipo statement

$param=array();

$sta->execute($param);   //Ejecutamos la consulta

$filas=$sta->fetchAll(PDO::FETCH_ASSOC);



$carpeta="Fotos";

foreach ($filas as $fila)
{
    
    $idFot=$fila['IdFoto'];
    $idPro=$fila['IdPro'];
   
    $archivoImag=$carpeta."/".$fila['Foto'];
   
    $conte=file_get_contents($archivoImag);
 
    $conte=base64_encode($conte);
    
    $consulta="insert into FotosProB values(:idPro,:idFot,:foto)";
    
    $sta=$pdo->prepare($consulta);
    
    $param=array();
    
    $param[":idFot"]=$idFot;
    $param[":idPro"]=$idPro;
    $param[":foto"]=$conte;
    
    $sta->execute($param);

}


$pdo=null; //Cerramos la conexión









