<html>

<?php 

require_once 'DaoPedidos.php';


$base="tiendadao";

$daoPed = new DaoPedidos($base);


$ord="";

$base="tiendadao";

if (isset($_POST['Orden']))
{
    $ord=$_POST['Orden'];
}

?>

 <body>

  <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'      > 
     <fieldset><legend>Estadísticas de Pedidos</legend>
      
      <label for='Orden'><b>Consultar Importes de Pedidos</b></label>
      <select name='Orden'>
      <option value=''></option> 
      <?php 
     
       $orden=array("Mayor","Menor","Media");
        
       foreach ($orden as $clave=>$valor)
       {
         echo "<option value='$clave' ";    
       
         if ($ord==$clave)
         {
          echo " selected ";  
         }
           
           
         echo ">$valor</option>";
     
       }
       
      ?>
      </select> 
      
      <input type='submit' name='Mostrar' value='Mostrar'>
  
     
     </fieldset>
     
     <?php 
     
     if ($_POST['Mostrar'] )
     {
         echo "<fieldset><legend>Resultado de la Consulta</legend>";   
        
         /*
         echo "<table border='2'>";
         echo "<th>Cod</th><th>Nombre</th><th>Descripcion</th><th>PVP</th>";
         
         */
         
         if ( ($ord==0) || ($ord==1) )  //El pedido con mayor importe
         {
            $ImpPed=$daoPed->ImportesPed($ord);             //Le indicamos que nos muestre el beneficio por unidades según el Stock
           
            echo "El Pedido es el número:".$ImpPed->__get("Id")." con importe ".$ImpPed->__get("Importe")." € ";
            
         }
         else 
         {
             $ImpPed=$daoPed->MediaPed();
             
             echo "La media de los importe de los pedidos es:".round($ImpPed->__get("Importe"),2)  ." € ";
         }
         
         
         
        
   
         
        echo "</fieldset>"; 
     }
     
     
     
     
     
     
     
     
     
     
     ?>
     
     
     
     
     
     
     
     
  </form>   
 </body>
</html>  