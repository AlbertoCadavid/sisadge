<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
require (ROOT_BBDD); 
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php
header('Pragma: public'); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past    
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1 
header('Pragma: no-cache'); 
header('Expires: 0'); 
header('Content-Transfer-Encoding: none'); 
header('Content-Type: application/vnd.ms-excel'); // This should work for IE & Opera 
header('Content-type: application/x-msexcel'); // This should work for the rest 
header('Content-Disposition: attachment; filename="Despachos.xls"');
?>
 
<?php
$conexion = new ApptivaDB();

$currentPage = $_SERVER["PHP_SELF"];

$int_remision = $_GET['int_remision'];
$str_numero= $_GET['str_numero'];
$id_c = $_GET['id_c'];
$cod_ref=$_GET['cod_ref'];
$estado_oc = $_GET['estado_oc'];
$estado_rd = $_GET['estado_rd'];
$anual=$_GET['fecha'];
$mes=$_GET['mensual']; 
$dia = $_GET['dia'];
$fecha = $anual.'-'.$mes.'-'. $dia;
$vende = $_GET['vende'];
$anualActual = date("Y");

mysql_select_db($database_conexion1, $conexion1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
  <?php

if($vende!='0'){
  $elvendedor = $conexion->llenarCampos("vendedor","WHERE id_vendedor=$vende","","nombre_vendedor");
  $vendedor = $elvendedor['nombre_vendedor'];
}
    //Filtra solo vendedor **
    if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref == '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro, tbl_items_ordenc io, tbl_remision_detalle rd',"WHERE ro.b_borrado_r='0' AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND oc.str_elaboro_oc='$vendedor' AND ro.id_pedido_oc=oc.id_pedido AND YEAR(ro.fecha_r) = '$anualActual' AND ro.int_remision = rd.int_remision_r_rd AND ro.str_numero_oc_r = rd.str_numero_oc_rd ",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd  ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
  //Filtra solo referencia. **
   if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende =='0')
    {
      //$registros = $conexion->llenaListas("tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd","WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision = rd.int_remision_r_rd AND ro.str_numero_oc_r=oc.str_numero_oc AND oc.id_pedido = io.id_pedido_io AND io.int_cod_ref_io = '$cod_ref' AND ro.b_borrado_r='0'","GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC","rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais" );
      $registros = $conexion->llenaListas("tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd","WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision = rd.int_remision_r_rd AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND rd.int_ref_io_rd = '$cod_ref' AND ro.b_borrado_r='0'","GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC","rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais" );
    }
    //solo anual * demasiado grande la busqueda(excede el tiempo)
    if($id_c =='0' && $anual != '0' && $mes == '0' && $dia == '0' && $cod_ref == '0' && $vende =='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_items_ordenc io,tbl_remisiones ro,tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND ro.int_remision = rd.int_remision_r_rd AND ro.b_borrado_r='0' AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND YEAR(ro.fecha_r) = '$anual'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    //anual y mes. **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia == '0' && $cod_ref == '0' && $vende =='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_items_ordenc io,tbl_remisiones ro,tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND ro.int_remision = rd.int_remision_r_rd AND ro.b_borrado_r='0' AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND YEAR(ro.fecha_r) = '$anual' AND MONTH(ro.fecha_r) = '$mes'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais");  
    }
    //anual, mes, dia. **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia != '0' && $cod_ref == '0' && $vende =='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_items_ordenc io,tbl_remisiones ro,tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND ro.int_remision = rd.int_remision_r_rd AND ro.b_borrado_r='0' AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.fecha_r =  '$fecha'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    //Filtra anual, mes, dia y vendedor **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia != '0' && $cod_ref == '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io, tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND ro.int_remision = rd.int_remision_r_rd AND ro.b_borrado_r='0' AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.fecha_r =  '$fecha' AND oc.str_elaboro_oc='$vendedor'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais");  
    }
    //Filtra  anual, mes, vendedor **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia == '0' && $cod_ref == '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND oc.id_pedido = io.id_pedido_io AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND YEAR(ro.fecha_r) = '$anual' AND MONTH(ro.fecha_r) = '$mes' AND oc.str_elaboro_oc='$vendedor' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    //Filtra  anual, mes, ref, vendedor **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
    {
      /* $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd and ro.id_pedido_oc=oc.id_pedido and oc.id_pedido = io.id_pedido_io and YEAR(ro.fecha_r) = '$anual' AND MONTH(ro.fecha_r) = '$mes' AND io.int_cod_ref_io = '$cod_ref' and oc.str_responsable_oc='$vendedor' and ro.b_borrado_r='0'",'GROUP BY ro.str_numero_oc_r,rd.int_ref_io_rd ORDER BY ro.int_remision DESC',"ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, rd.int_ref_io_rd, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais");  */
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND YEAR(ro.fecha_r) = '$anual' AND MONTH(ro.fecha_r) = '$mes' AND rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vendedor' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    //Filtra anual, mes, dia, ref, vendedor **
    if($id_c =='0' && $anual != '0' && $mes != '0' && $dia != '0' && $cod_ref != '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.fecha_r = '$fecha' AND rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vendedor' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    //Filtra anual. ref, vendedor **
    if($id_c =='0' && $anual != '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND YEAR(ro.fecha_r) = '$anual' AND rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vendedor' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais");  
    }
    //Filtra ref, cliente llenos 
    if($id_c !='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende =='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND rd.int_ref_io_rd = '$cod_ref' AND oc.id_c_oc='$id_c' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    
    //Filtra ref, vendedor **
    if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_items_ordenc io,tbl_remisiones ro,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND oc.str_elaboro_oc='$vendedor' AND rd.int_ref_io_rd = '$cod_ref' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais");   
    }
    //Filtra ref, MES, vendedor
    if($id_c =='0' && $anual == '0' && $mes != '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
    {
      $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_remisiones ro,tbl_items_ordenc io,tbl_remision_detalle rd',"WHERE ro.int_remision = rd.int_remision_r_rd AND ro.id_pedido_oc=oc.id_pedido AND ro.str_numero_oc_r = rd.str_numero_oc_rd AND oc.id_pedido = io.id_pedido_io AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND MONTH(ro.fecha_r) = '$mes' AND oc.str_elaboro_oc='$vendedor' AND rd.int_ref_io_rd = '$cod_ref' AND ro.b_borrado_r='0'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd ,rd.int_item_io_rd, ro.int_remision, oc.fecha_ingreso_oc, io.fecha_entrega_io, ro.fecha_r, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, ro.ciudad_pais"); 
    }
    

 
  ?>

  <table id="tabla1" border=1>
    <tr> 
      <td nowrap="nowrap" id="nivel2">REMISION</td>
      <td nowrap="nowrap" id="nivel2">FECHA INGRESO O.C.</td>
      <td nowrap="nowrap" id="nivel2">FECHA ENTREGA PACTADA</td>
      <td nowrap="nowrap" id="nivel2">FECHA ENTREGA REM.</td>
      <td nowrap="nowrap" id="nivel2">CLIENTE</td>
      <td nowrap="nowrap" id="nivel2">O.C</td>
      <td nowrap="nowrap" id="nivel2">REF. AC</td>  
      <td nowrap="nowrap" id="nivel2">CANT.DESPACHADA</td>
      <td nowrap="nowrap" id="nivel2">CANT.PENDIENTE</td>
      <td nowrap="nowrap" id="nivel2">TRANSPORTADOR</td>
      <td nowrap="nowrap" id="nivel2">GUIA</td>
      <td nowrap="nowrap" id="nivel2">FACTURA</td>                
      <td nowrap="nowrap" id="nivel2">PAIS / CIUDAD</td>
      <td nowrap="nowrap" id="nivel2">DIRECCION ENTREGA</td>
      <td nowrap="nowrap" id="nivel2">VENDEDOR</td>
    </tr>                
   <?php foreach($registros as $row_remision) {  ?>
    <tr>
      <td id="talla2"><?php echo $row_remision['int_remision']; ?></td>  
      <td id="talla2"><?php echo $row_remision['fecha_ingreso_oc']; ?></td>
      <td id="talla2"><?php echo $row_remision['fecha_entrega_io']; ?></td>
      <td id="talla2"><?php echo $row_remision['fecha_r'];//$row_remision['fecha_entrega_io']; ?></td>
      <td id="talla2"><?php $clientes=$row_remision['str_numero_oc_r'];
      $refer=$row_remision['int_ref_io_rd'];
      $id_pedido=$row_remision['id_pedido']; 
      $id_rd=$row_remision['id_rd']; 
      
      if(!empty($clientes))
      {
       $sqln = $conexion->llenarCampos('tbl_orden_compra oc, cliente c', "WHERE oc.id_c_oc= c.id_c and oc.id_pedido = '$id_pedido' ", '','distinct c.nombre_c, c.direccion_c, c.ciudad_c, c.pais_c' );

        $nombre_c=$sqln['nombre_c'];  
        $ciudad_c=$sqln['ciudad_c']; 
        $direccion_c = $sqln['direccion_c'];  
        $pais_c = $sqln['pais_c']; 
        echo htmlentities($nombre_c); 
      }
      ?> 
      </td>
     <td id="talla2"><?php echo $row_remision['str_numero_oc_r']; ?></td>                  
     <td id="talla1">
      <?php $mp=$row_remision['str_numero_oc_r'];
      if($mp!='')
      { 
        $resultio = $conexion->llenarCampos('tbl_items_ordenc io', "WHERE id_pedido_io = '$id_pedido' AND int_cod_ref_io ='$refer'", 'GROUP BY int_cod_ref_io ','id_items,int_cod_ref_io, int_cantidad_io, int_cantidad_rest_io, str_direccion_desp_io,(int_cantidad_io - int_cantidad_rest_io) as despachada' ); 
        $resultdetallesremision = $conexion->llenarCampos('tbl_remision_detalle rd', "WHERE id_rd = '$id_rd'", 'GROUP BY id_rd ','int_cant_rd as despachada'); 
        //$despachada = $resultio['despachada']; 
        $despachada = $resultdetallesremision['despachada']; 
        $int_cantidad_io = $resultio['int_cantidad_io']; 
        $int_cantidad_rest_io = $resultio['int_cantidad_rest_io']; 
        $str_direccion_desp_io = $resultio['str_direccion_desp_io']; 
      } 
      echo $row_remision['int_ref_io_rd'];
      ?>  
  </td> 
 
  <td id="talla2">
    <?php  echo $despachada =='' ? '0.00' :$despachada;//O PUEDE SER ESTE $row_remision['int_cant_rd'] ?>  
  </td>
  <td  id="talla2"><?php echo $int_cantidad_rest_io =='' ? '0.00' : $int_cantidad_rest_io; ?></td>
  <td  id="talla2"><?php echo $row_remision['str_transportador_r']; ?></td>
  <td  id="talla2"><?php echo $row_remision['str_guia_r']; ?></td>
  <td  id="talla2"><?php echo $row_remision['factura_r']; ?></td>
  <td  id="talla2"><?php echo htmlentities($row_remision['ciudad_pais'])?></td>
  <td id="talla2"><?php echo htmlentities($str_direccion_desp_io); ?></td>
  <td id="talla2">
  <?php 
  $idoc = $row_remision['str_numero_oc_r'];
  $iditem = $row_remision['int_item_io_rd'];
  $select_direccion = $conexion->llenaListas('vendedor ver',"LEFT JOIN tbl_items_ordenc itm on  ver.id_vendedor=itm.int_vendedor_io WHERE itm.str_numero_io= '$idoc' AND id_items = '$iditem'","","distinct ver.nombre_vendedor");
   foreach($select_direccion as $row_direccion) { 
     $vende = $row_direccion['nombre_vendedor']." ";
   } 
   echo $vende; 
   ?> 
 </td> 
</tr>
<?php }  ?>

</table>

</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($ano);

mysql_free_result($mezclas);

mysql_free_result($id_pm);
?>