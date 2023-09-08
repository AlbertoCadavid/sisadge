
<?php
//Desarrollado por Jesus Liñán
//ribosomatic.com
//Puedes hacer lo que quieras con el código
//pero visita la web cuando te acuerdes

//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "acycia_root"; 
$bd_password = "ac2006"; 
$bd_base = "acycia_intranet"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 

//consulta los datos del empleado por su id
$idemp=$_POST['idemp'];

$sql=mysql_query("SELECT * FROM empleados WHERE idempleado=$idemp",$con);

$row = mysql_fetch_array($sql);

//valores de las consultas
$nom=$row['nombres'];
$dep=$row['departamento'];
$suel=$row['sueldo'];

//muestra los datos consultados en los campos del formulario
?>
<form name="frmempleado" action="" 
onsubmit="enviarDatosEmpleado(); return false">
	<input name="idempleado" type="hidden" value="<?php echo $idemp; ?>" />
  <p>Nombres 
    <input name="nombres" type="text" value="<?php echo $nom; ?>" />
  </p>
  <p>Departamento 
    <select name="departamento">
      <?php
	  echo "<option value=\"".$dep."\">".$dep."</option>"
	  ?>
      <option value="Informatica">Informatica</option>
      <option value="Contabilidad">Contabilidad</option>
      <option value="Administracion">Administracion</option>
      <option value="Logistica">Logistica</option>
    </select>
  </p>
  <p>Sueldo <strong>S/.</strong>
    <input name="sueldo" type="text" value="<?php echo $suel; ?>" />
  </p>
  <p>
    <input type="submit" name="Submit" value="Actualizar" />
  </p>
</form>