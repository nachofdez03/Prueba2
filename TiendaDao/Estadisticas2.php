<html>

<?php 

require_once 'DaoStock.php';

$ord="";

$base="tiendadao";

$daoStock = new DaoStocks($base);

if (isset($_POST['Orden']))
{
    $ord=$_POST['Orden'];
}

$bene="";

if (isset($_POST['Beneficio']))
{
    $bene=$_POST['Beneficio'];
}








?>

 <body>

  <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'      > 
     <fieldset><legend>Estadísticas de venta por Familias de Productos</legend>
      
      <label for='Orden'><b>Criterio de ordenacion</b></label>
      <select name='Orden'>
      <option value=''></option> 
      <?php 
     
       $orden=array("Mayor","Menor");
        
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
      
      <label for='Beneficio'><b>Criterio de Beneficio:</b></label>
  
      <?php 
      
      $beneficio=array('Unidades','Importe');  //Inidicamos si queremos expresar el beneficio por número de unidades o por importe 
      
      foreach($beneficio as $clave=>$valor)
      {
          echo "$valor<input type='radio' name='Beneficio' value='$clave' ";

          if ($bene==$clave)
          {
            echo " checked ";
          }
          echo ">";
          
      }
      
      ?>
  
      <input type='submit' name='Mostrar' value='Mostrar'>
  
     
     </fieldset>
     
     <?php 
     
     if ($_POST['Mostrar'] )
     {
         echo "<fieldset><legend>Resultado de la Consulta</legend></fieldset>";   
        
         echo "<table border='2'>";
         echo "<th>Cod</th><th>Nombre</th><th>Descripcion</th><th>PVP</th>";
         
         if ($bene==0) //Si queremos el beneficion en unidades
         {
             $daoStock->BenePorUni($ord);   //Le indicamos que nos muestre el beneficio por unidades según el Stock
    
             echo "<th>Total Uni</th>";
            
         }
         else 
         {
             $daoStock->BenePorImp($ord);   //Le indicamos que nos muestre el beneficio por importe total generado
             
             echo "<th>Total Importe</th>";
         
         }
        
         foreach ($daoStock->stocks as $pro)
         {
             echo "<tr>";
             echo "<td>".$pro->__get("cod")."</td>";
             echo "<td>".$pro->__get("nombre")."</td>";
             echo "<td>".$pro->__get("descripcion")."</td>";
             echo "<td>".$pro->__get("PVP")."</td>";
             echo "<td>".$pro->__get("TotUni")."</td>";
             
             echo  "</tr>";
         }
         
         echo "</table>";
         
        echo "</fieldset>"; 
     }
     
     
     
     
     
     
     
     
     
     
     ?>
     
     
     
     
     
     
     
     
  </form>   
 </body>
</html>  