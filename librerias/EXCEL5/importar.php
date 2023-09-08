<?php
$hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet";
$username_conexion1 = "acycia_root";
$password_conexion1 = "ac2006";
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
 ?>
<?php
//obtenemos el archivo .csv
$tipo = $_FILES['archivo']['type'];
 
$tamanio = $_FILES['archivo']['size'];
 
$archivotmp = $_FILES['archivo']['tmp_name'];
 
//cargamos el archivo
$lineas = file($archivotmp);
 
//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea

//Recorremos el bucle para leer línea por línea
foreach ($lineas as $linea_num => $linea)
{ 
   //abrimos bucle
   /*si es diferente a 0 significa que no se encuentra en la primera línea 
   (con los títulos de las columnas) y por lo tanto puede leerla*/
   for($i=0;$i <=$linea;$i++) 
   { 
       //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
       /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
       leyendo hasta que encuentre un ; */
       $datos = explode(";",$linea);
       //Almacenamos los datos que vamos leyendo en una variable
       /*$nombre = trim($datos[0]);
       $edad = trim($datos[1]);
       $profesion = trim($datos[2]);*/
	   
	   //CREAMOS UN HISTORIAL
	   /*mysql_query("INSERT INTO TblInventarioHistory (Fecha, Cod_ref, Codigo, SaldoInicial, Entrada, Salida,  CostoUnd, Acep, Tipo, Responsable, Modifico)
	SELECT Fecha, Cod_ref, Codigo, SaldoInicial, Entrada, Salida,  CostoUnd, Acep, Tipo, Responsable, Modifico FROM TblInventarioListado ORDER BY idInv ASC");*/
	   //CONSULTO SI EXISTE
	   $sqlvi="SELECT Codigo FROM TblInventarioListado WHERE Codigo = '$datos[1]'";
	   $resultvi= mysql_query($sqlvi);
	   $numvi= mysql_num_rows($resultvi);
	   
	   $codigo = explode("-",$datos[1]);
	   $cod_ref = $codigo[0];
		
	   if($numvi >='1')
	   { 
        //UPDATE en base de datos la línea que existe
	    mysql_query("UPDATE TblInventarioListado SET Fecha='$datos[0]', Cod_ref='$cod_ref', Codigo='$datos[1]', SaldoInicial='$datos[2]', Entrada = '$datos[3]', Salida= '$datos[4]', Final= '$datos[5]', CostoUnd='$datos[6]', Acep='0', Tipo='1', Modifico='Almacen' WHERE Codigo = '$datos[2]'");	   
 	   }else{
        //INSERT en base de datos la línea leida que no existe
        mysql_query("INSERT INTO TblInventarioListado(Fecha, Cod_ref, Codigo, SaldoInicial, Entrada, Salida, Final, CostoUnd, Acep, Tipo, Responsable) VALUES ('$datos[0]','$cod_ref','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','0','1','Almacen')");
 	   }//cerramos condición
   }//for cerramos bucle
}
echo "Importación exitosa!";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="importar.php" enctype="multipart/form-data" method="post">
   <input id="archivo" accept=".csv" name="archivo" type="file" /> 
   <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
   <input name="enviar" type="submit" value="Importar" />
</form>
</body>
</html>