<?php require_once('Connections/conexion1.php'); 

mysql_select_db($database_conexion1, $conexion1);
$query_ano = "SELECT * FROM anual ORDER BY anual DESC";
$ano = mysql_query($query_ano, $conexion1) or die(mysql_error());
$row_ano = mysql_fetch_assoc($ano);
$totalRows_ano = mysql_num_rows($ano);
 ?>

<html>
<head>
	<title> Graficas Acycia</title>
    <link href="css/indexcss.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="js/jquery.js"></script>
<script languaje="javascript">
//llena combo dependientes
   $(document).ready(function(){
   $("#proceso").change(function () {
           $("#proceso option:selected").each(function () {
            id_proceso = $(this).val();
			codigo = document.getElementById('codigo').value;
            $.post("subcategories.php", { id_proceso: id_proceso, codigo:codigo }, function(data){
                $("#tipoDesp").html(data);//aqui los imprime
            });            
        });
   })
});
</script> 
<script languaje="javascript">
function opcion1(){
var m=document.getElementById('marco'); 
m.src="grafica_categories.php?proceso="+document.getElementById('proceso').value+'&tipoDesp='+document.getElementById('tipoDesp').value+'&codigo='+document.getElementById('codigo').value+'&ano='+document.getElementById('ano').value;
 }
function tiempoM(){
document.getElementById('button1').hidden = false 
document.getElementById('tipoDesp').hidden = false
document.getElementById('proceso').hidden = false 
document.getElementById('ano').hidden = false 
document.getElementById('codigo').value = '1'
document.getElementById('proceso').value = ''
document.getElementById('tipoDesp').value = '' 
} 
function tiempoP(){
document.getElementById('button1').hidden = false 
document.getElementById('tipoDesp').hidden = false
document.getElementById('proceso').hidden = false 
document.getElementById('ano').hidden = false
document.getElementById('codigo').value = '2'
document.getElementById('proceso').value = ''
document.getElementById('tipoDesp').value = ''
} 
function desp(){
document.getElementById('button1').hidden = false 
document.getElementById('tipoDesp').hidden = false
document.getElementById('proceso').hidden = false 
document.getElementById('ano').hidden = false
document.getElementById('codigo').value = '3'
document.getElementById('proceso').value = ''
document.getElementById('tipoDesp').value = ''
} 
function expo(){
var m=document.getElementById('marco');
m.src="exportar_categories.php?proceso="+document.getElementById('proceso').value+'&tipoDesp='+document.getElementById('tipoDesp').value+'&codigo='+document.getElementById('codigo').value+'&ano='+document.getElementById('ano').value;
 } 
</script>
  </head>
<body>

<div align="center">

 	<table>
    <tr><td colspan="6"  id="titulo">GRAFICA ESPECIFICA</td></tr>
	<tr>
        <td><a href="../menu.php"><input name="logo" src="images/logoacyc.jpg" type="image"></a></td> 
 		<td> <input name="tiempom" src="images/tiempom.png" type="image"   onClick="tiempoM();"class="boton">
	  </td>
		<td><input name="tiempop" src="images/tiempop.png" type="image" onClick="tiempoP();" class="boton"></td>
 		<td><input name="desperdicio" src="images/desperdicio.png" type="image" onClick="desp();" class="boton"> </td>
        <td><input name="exportar" src="images/exportar.png" type="image" onClick="expo();" class="boton"></td>
        <td><a href="../menu.php">
        <input name="menu" src="images/menu.png" type="image" class="boton"></a></td>	
 	</tr>
    <tr ><td><em><strong><a href="index.html">Ir a Grafica General</a></strong></em></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td></tr>
    <tr>
    <td align="right"><input type="hidden" name="codigo" id="codigo" value="">
      <label for="ano"></label>
      <select name="ano" id="ano" hidden="true"> 
          <?php  do {   ?>
      <option value="<?php echo $row_ano['anual']?>"><?php echo $row_ano['anual']?></option> 
      <?php
		  } while ($row_ano = mysql_fetch_assoc($ano));
 			 $rows = mysql_num_rows($ano);
 			 if($rows > 0) {
     	     mysql_data_seek($ano, 0);
	       $row_ano = mysql_fetch_assoc($ano);
  	      }
		  ?>
       </select></td>
    <td> 
    <select name="proceso" id="proceso"  style="width:90px" hidden="true">
    <option>Todos</option>
     <?php
    $result = $conexion->query("SELECT c.id_tipo_proceso, c.nombre_proceso FROM tipo_procesos c ORDER BY c.nombre_proceso ASC");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['id_tipo_proceso'].'">'.$row['nombre_proceso'].'</option>';
        }
    }
    ?>
</select></td>
    <td><select name="tipoDesp" id="tipoDesp" style="width:90px" hidden="true">
    <option value='Todos'>Todos</option>
     </select></td>
    <td>
      <input type="hidden" name="codigo" id="codigo" value="">
      <input type="button" name="button1" id="button1" value="consultar" onClick="opcion1();" hidden="true" ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
	</table>
 <div id="contenido">
<iframe id="marco">

</iframe>
</div>
 
</div> 
</body>

</html>