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

 ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SISADGE AC &amp; CIA</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 </head>
<body>
<?php
 
//Filtra remision, FECHA
mysql_select_db($database_conexion1, $conexion1);
//Filtra todos vacios
/* if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref == '0' && $vende =='0')
{ 
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND  rdint_mp_io_rd=ioid_mp_vta_io",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY rdid_rd ASC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais"); 
} */
//Filtra fecha lleno
if($fecha != '0' && $mes != '0' && $dia != '0' && $cod_ref == '0' && $vende =='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND rd.fecha_rd =  '$fecha'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");
 
}
//Filtra ref lleno
 if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende =='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_items_ordenc io,Tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND rd.int_ref_io_rd = '$cod_ref'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais"); 
}
//Filtra año lleno
 if($id_c =='0' && $anual != '0' && $mes == '0' && $dia == '0' && $cod_ref == '0' && $vende =='0')
{ 
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND YEAR(rd.fecha_rd) = '$anual'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais"); 

}
//Filtra ref  y cliente llenos
if($id_c !='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende =='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_items_ordenc io,Tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND rd.int_ref_io_rd = '$cod_ref' AND oc.id_c_oc='$id_c'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.int_remision DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  ;
}
//Filtra año y mes llenos *
if($id_c =='0' && $anual != '0' && $mes != '0' && $dia == '0' && $cod_ref == '0' && $vende =='0')
{
  //$registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.b_borrado_r='0' AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=io.str_numero_io AND rd.int_ref_io_rd=io.int_cod_ref_io and rd.int_item_io_rd=io.id_items and YEAR(rd.fecha_rd) = '$anual' AND MONTH(ro.fecha_r) = '$mes'",'GROUP BY ro.str_numero_oc_r,rd.int_ref_io_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  
  $registros = $conexion->llenaListas('tbl_orden_compra oc,tbl_items_ordenc io,tbl_remisiones ro,tbl_remision_detalle rd',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND YEAR(ro.fecha_r) = '$anual' AND MONTH(ro.fecha_r) = '$mes'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  
}
//Filtra año y mes, REF Y VENDE llenos
if($id_c =='0' && $anual != '0' && $mes != '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND YEAR(rd.fecha_rd) = '$anual' AND MONTH(ro.fecha_r) = '$mes' AND rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vende'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  
}
//Filtra fecha y VENDE llenos
if($id_c =='0' && $anual != '0' && $mes != '0' && $dia != '0' && $cod_ref == '0' && $vende !='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' and rd.fecha_rd =  '$fecha' AND oc.str_elaboro_oc='$vende'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais"); 

} 
//Filtra MES, REF Y VENDE llenos
if($id_c =='0' && $anual == '0' && $mes != '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' and MONTH(ro.fecha_r) = '$mes' and rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vende'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  

} 
//Filtra REF Y VENDE llenos
if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref != '0' && $vende !='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' and rd.int_ref_io_rd = '$cod_ref' AND oc.str_elaboro_oc='$vende'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");  

} 
//Filtra vende lleno
if($id_c =='0' && $anual == '0' && $mes == '0' && $dia == '0' && $cod_ref == '0' && $vende !='0')
{
  $registros = $conexion->llenaListas('Tbl_orden_compra oc,Tbl_remisiones ro,Tbl_remision_detalle rd,Tbl_items_ordenc io',"WHERE ro.id_pedido_oc=oc.id_pedido AND ro.int_remision=rd.int_remision_r_rd AND rd.str_numero_oc_rd=ro.str_numero_oc_r AND rd.int_ref_io_rd=io.int_cod_ref_io AND rd.int_item_io_rd=io.id_items AND ro.b_borrado_r='0' AND oc.str_elaboro_oc='$vende'",'GROUP BY rd.int_item_io_rd, rd.int_ref_io_rd, rd.int_cant_rd ORDER BY ro.fecha_r DESC',"rd.id_rd, rd.fecha_rd, rd.str_numero_oc_rd, ro.str_numero_oc_r, rd.int_ref_io_rd, oc.id_pedido, ro.str_transportador_r, ro.str_guia_r, ro.factura_r, rd.int_remision_r_rd, ro.ciudad_pais");
} 
 
?>

    <table id="tabla1" border=1>
        <tr> 
          <td id="nivel2">FECHA ENTREGA REM.</td>
          <td id="nivel2">CLIENTE</td>
          <td id="nivel2">O.C</td>
          <td id="nivel2">REF. AC</td> 
          <td id="nivel2">CANT.DESPACHADA</td>
          <td id="nivel2">CANT.PENDIENTE</td>
          <td id="nivel2">TRANSPORTADOR</td>
          <td id="nivel2">GUIA</td>
          <td id="nivel2">FACTURA</td>                
          <td id="nivel2">REMISION</td>
          <td id="nivel2">PAIS / CIUDAD</td>
          <td id="nivel2">DIRECCION ENTREGA</td>
          </tr>                
        <?php foreach($registros as $row_remision) {  ?>
          <tr> 
            <td id="talla2"><?php echo $row_remision['fecha_rd'];?></td>
            <td id="talla2"><?php $clientes=$row_remision['str_numero_oc_rd']; 
            $ocremi=$row_remision['str_numero_oc_r'];
            $refer=$row_remision['int_ref_io_rd'];
            $id_pedido=$row_remision['id_pedido']; 
            $id_rd=$row_remision['id_rd']; 
            
          if(!empty($clientes))
            {
            $resultmp = $conexion->llenarCampos('tbl_orden_compra oc, cliente c', "WHERE oc.id_c_oc= c.id_c and oc.id_pedido = '$id_pedido' ", '','distinct c.nombre_c, c.direccion_c, c.ciudad_c, c.pais_c' );

            $nombre_c=$resultmp['nombre_c'];  
              $ciudad_c=$resultmp['ciudad_c']; 
              $direccion_c = $resultmp['direccion_c'];  
              $pais_c = $resultmp['pais_c']; 
              echo htmlentities($nombre_c); 
            }
           ?></td>
            <td id="talla2"><?php echo $row_remision['str_numero_oc_rd']; ?></td>                  
            <td id="talla1"><?php echo $row_remision['int_ref_io_rd']; ?> </td> 
            <td id="talla2"><?php 
            $mp=$row_remision['str_numero_oc_r'];
            if($mp!='')
            { 
              $resultio = $conexion->llenarCampos('tbl_items_ordenc', "WHERE id_pedido_io = '$id_pedido' AND int_cod_ref_io='$refer'", 'GROUP BY int_cod_ref_io ORDER BY id_items DESC','id_items,int_cod_ref_io, int_cantidad_io, int_cantidad_rest_io, str_direccion_desp_io,(int_cantidad_io - int_cantidad_rest_io) as despachada ' ); 
              $resultdetallesremision = $conexion->llenarCampos('tbl_remision_detalle rd', "WHERE id_rd = '$id_rd'", 'GROUP BY id_rd ','int_cant_rd as despachada'); 
              //$despachada = $resultio['despachada']; 
              $despachada = $resultdetallesremision['despachada']; 
              $int_cantidad_io = $resultio['int_cantidad_io']; 
              $int_cantidad_rest_io = $resultio['int_cantidad_rest_io']; 
              $str_direccion_desp_io = $resultio['str_direccion_desp_io']; 
            }  
             ?><?php  echo $despachada =='' ? '0.00' :$despachada;//O PUEDE SER ESTE $row_remision['int_cant_rd'] ?>  
             </td>
            <td  id="talla2"><?php echo $int_cantidad_rest_io; // $row_remision['int_cant_rd']; ?></td>  
            <td  id="talla2"><?php echo $row_remision['str_transportador_r']; ?></td>
            <td  id="talla2"><?php echo $row_remision['str_guia_r']; ?></td>
            <td  id="talla2"><?php echo $row_remision['factura_r']; ?></td>
            <td  id="talla2"><?php echo $row_remision['int_remision_r_rd']; ?></td> 
            <td  id="talla2"><?php echo htmlentities($row_remision['ciudad_pais'])?></td>
            <td id="talla2"><?php  echo htmlentities($str_direccion_desp_io); ?> </td>
          </tr>
          <?php }  ?>

    </table>

</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($remision);
?>