<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 
?>
<?php require_once('conexion1.php'); ?>
<?php
$conexion = new ApptivaDB();

mysql_select_db($database_conexion1, $conexion1);


 
$id_pedido=$_GET['id_pedido'];
$factura=$_GET['valor'];
if($id_pedido !='' && $factura !='') {

   $sqldato="SELECT str_numero_oc FROM tbl_orden_compra WHERE id_pedido='$id_pedido'";
   $resultdato=mysql_query($sqldato);
   $str_numero_oc=mysql_result($resultdato,0,'str_numero_oc');
   
   $factura = strtoupper($factura);
   $sqlfactura="UPDATE Tbl_remisiones SET factura_r = '$factura' WHERE str_numero_oc_r='$str_numero_oc'";//actualiza lel numero factura para todas las remisiones por igual
   $resultfactura=mysql_query($sqlfactura);

   //$actualizo = $conexion->actualizar("tbl_orden_compra", " b_estado_oc='5', factura_oc='$factura'  ", " factura_oc= '".$factura."' " );
   $estados =  $factura== '0' ? '3' : '5';
   echo 'estado: '.$estados .' idpedido:' .$id_pedido;
   $sqlorden="UPDATE tbl_orden_compra SET b_estado_oc = '$estados', factura_oc = '$factura' WHERE id_pedido='$id_pedido'";
   $resultorden=mysql_query($sqlorden);
 
}

$id_proforma=$_GET['id_proforma'];
$proforma=$_GET['valor'];
if($id_proforma !='' && $proforma !='') {
 
   $sqlorden="UPDATE tbl_orden_compra SET proforma_oc = '$proforma' WHERE id_pedido='$id_proforma'";
   $resultorden=mysql_query($sqlorden);
 
}


$int_remision=$_GET['int_remision'];
if($int_remision !='' && $factura !='') {

   $sqldato="SELECT str_numero_oc_r FROM tbl_remisiones WHERE int_remision='$int_remision'";
   $resultdato=mysql_query($sqldato);
   $str_numero_oc=mysql_result($resultdato,0,'str_numero_oc_r');

   $sqlfactura="UPDATE tbl_remisiones SET factura_r = '$factura' WHERE int_remision = '$int_remision'";//actualiza el numero factura para todas las remisiones por igual
   $resultfactura=mysql_query($sqlfactura);
   
   $estados =  $factura== '0' ? '3' : '5';
   echo 'estado: '.$estados .' id o.c:' .$str_numero_oc;
   $sqlorden="UPDATE tbl_orden_compra SET b_estado_oc = '$estados', factura_oc = '$factura' WHERE str_numero_oc='$str_numero_oc'";
   $resultorden=mysql_query($sqlorden);
}



 
if($_GET['UpdateSiTick']!='') {
    $consecInicial=$_GET['consecInicial'];
    $consecFinal=$_GET['consecFinal'];
    $codigoe=$_GET['codigoe'];
    $idenvio=$_GET['idenvio'];
  
   $sqlticket="UPDATE ticket SET consecutivo=$consecInicial,consecutivo2=$consecFinal,codigoe=$codigoe,idenvio=$idenvio  WHERE id='1'";
   $resultorden=mysql_query($sqlticket);
}


   if($resultfactura==1 && $resultorden==1){
      echo 'ok';
   }else{
      echo 'ko!';
   } 
 

  if(isset($_GET['id_remision'])  && $_GET['id_remision']!='' ) {  
    $cliente=$_GET['cliente'];
    $entrada=$_GET['entrada'];
    $fecha=$_GET['fecha'];
    $telefono=$_GET['telefono'];
    $direccion=$_GET['direccion'];
    $elabora=$_GET['elabora'];
    $recibe=$_GET['recibe'];
    $observacion=$_GET['observacion'];
    $sqlremision="UPDATE tbl_remision_interna SET cliente ='$cliente',entrada='$entrada',fecha='$fecha',telefono='$telefono',direccion='$direccion',elabora='$elabora',recibe='$recibe',observacion='$observacion' WHERE  id_remision='".$_GET['id_remision']."' "; 
    $resultremision=mysql_query($sqlremision);
    //header($_GET['pagina']);
 
 }

 /*if(isset($_POST['facturar'])&& $_POST['facturar'] !=''){
  
   if($sqlogs = $conexion->actualizar('tbl_orden_compra', " ", " " )){
      echo json_encode( $sqlogs); 
   }else{
      echo 'ko!';
   } 
   exit();
 } */

 $id_rollo=$_GET['id_r'];
$actualizar=$_GET['act_rollos'];
if($id_rollo !='' && $actualizar !='') {
 
   $query="UPDATE `tblextruderrollo` SET `id_rp`= 0 WHERE `id_r`= $id_rollo";
   $resultorden=mysql_query($query);
 
}

?>