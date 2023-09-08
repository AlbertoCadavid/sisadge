<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 
?> 
<?php require_once('conexion1.php'); ?>
<?php
mysql_select_db($database_conexion1, $conexion1);

$conexion = new ApptivaDB();
 
$autorizado=$_GET['Autorizar'];
if($autorizado !='' ) {
   
   $hoy = date("Y-m-d H:i:s");  
   $sqlautorizado="UPDATE Tbl_orden_compra SET autorizado = 'SI', fecha_autoriza='$hoy' WHERE id_pedido = '$autorizado'";
   $resultautorizado=mysql_query($sqlautorizado);
   
  
   $usuario = $_SESSION['Usuario'];
   $logs = $conexion->insertar("tbl_logs","codigo_id, descrip, fecha, modificacion, usuario"," '$autorizado','OC','$hoy','autorizado SI','$usuario' ");
 
}

$desautorizado=$_GET['Desautorizar'];
if($desautorizado !='' ) {

   $sqlautorizado="UPDATE Tbl_orden_compra SET autorizado = 'NO' WHERE id_pedido = '$desautorizado'";
   $resultautorizado=mysql_query($sqlautorizado);

   $hoy = date("Y-m-d H:i:s");  
   $usuario = $_SESSION['Usuario'];
   $logs = $conexion->insertar("tbl_logs","codigo_id, descrip, fecha, modificacion, usuario"," '$desautorizado','OC','$hoy','autorizado NO','$usuario' ");
 
}

 

   if( $resultautorizado==1 ){
      echo 'ok';
   }else{
      echo 'ko!'; 	
   } 
 
?>