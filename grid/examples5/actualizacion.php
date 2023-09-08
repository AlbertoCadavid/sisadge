
<?php
//Desarrollado por Jesus Liñán
//webmaster@ribosomatic.com
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

//variables POST
$idemp=$_POST['idempleado'];
$nom=$_POST['nombres'];
$dep=$_POST['departamento'];
$suel=$_POST['sueldo'];

//actualiza los datos del empleados
$sql="UPDATE empleados SET nombres='$nom', departamento='$dep', sueldo='$suel' WHERE idempleado=$idemp";

mysql_query($sql,$con);

include('consulta.php');
?>