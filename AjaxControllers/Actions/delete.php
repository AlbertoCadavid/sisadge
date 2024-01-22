<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 
?>
<?php
 require_once('conexion1.php'); ?>
<?php
mysql_select_db($database_conexion1, $conexion1);

$conexion = new ApptivaDB();
 
$id_fantasma=$_GET['id_fantasma'];
if($id_fantasma !='') {

   $sqlcn="SELECT id_op_rp,rollo_rp FROM Tbl_reg_produccion WHERE id_rp=$id_fantasma";
   $resultcn= mysql_query($sqlcn);
   $numcn= mysql_num_rows($resultcn);
   if($numcn >='1') {
      $op_sell=mysql_result($resultcn,0,'id_op_rp');
      $rollo_imp=mysql_result($resultcn,0,'rollo_rp');

    }

   $sqlrtRollo="DELETE FROM TblImpresionRollo WHERE id_op_r=$op_sell and rollo_r=$rollo_imp " ;
   $resulrtRollo=mysql_query($sqlrtRollo);
   $sqlrttiempo="DELETE FROM tbl_reg_tiempo WHERE op_rt=$op_sell and int_rollo_rt=$rollo_imp and id_proceso_rt='2'" ;
   $resulrttiempo=mysql_query($sqlrttiempo);
   $sqlrttiempop="DELETE FROM tbl_reg_tiempo_preparacion WHERE op_rtp=$op_sell and int_rollo_rtp=$rollo_imp and id_proceso_rtp='2'" ;
   $resulrttiempop=mysql_query($sqlrttiempop);
   $sqlrtdes="DELETE FROM tbl_reg_desperdicio WHERE op_rd=$op_sell and int_rollo_rd=$rollo_imp and id_proceso_rd='2' " ;
   $resulrtdes=mysql_query($sqlrtdes);
   $sqlrt="DELETE FROM Tbl_reg_produccion WHERE id_rp=$id_fantasma";
   $resulrt=mysql_query($sqlrt); 

   if($resulrt==1){
      echo 'ok';
   }else{
      echo 'ko!';    
   }

}

$id_fantasmasell=$_GET['id_fantasmasell'];
if($id_fantasmasell !='') {

   $sqlcn="SELECT id_op_rp,rollo_rp FROM Tbl_reg_produccion WHERE  id_rp='$id_fantasmasell'";
   $resultcn= mysql_query($sqlcn);
   $numcn= mysql_num_rows($resultcn);
   if($numcn >='1') {
      $op_sell=mysql_result($resultcn,0,'id_op_rp');
      $rollo_sell=mysql_result($resultcn,0,'rollo_rp');

    }
 
      $sqlrt="DELETE FROM Tbl_reg_produccion WHERE id_rp='$id_fantasmasell'";
      $resulrt=mysql_query($sqlrt);
 
      if($resulrt){
         $sqlrtRollo="DELETE FROM TblSelladoRollo WHERE id_op_r=$op_sell and rollo_r=$rollo_sell " ;
         $resulrtRollo=mysql_query($sqlrtRollo);
      }
      if($resulrtRollo){
         $sqlrttiempo="DELETE FROM tbl_reg_tiempo WHERE op_rt=$op_sell and int_rollo_rt=$rollo_sell and id_proceso_rt='4' " ;
         $resulrttiempo=mysql_query($sqlrttiempo);
         $sqlrttiempop="DELETE FROM tbl_reg_tiempo_preparacion WHERE op_rtp=$op_sell and int_rollo_rtp=$rollo_sell and id_proceso_rtp='4' " ;
         $resulrttiempop=mysql_query($sqlrttiempop);
         $sqlrtdes="DELETE FROM tbl_reg_desperdicio WHERE op_rd=$op_sell and int_rollo_rd=$rollo_sell and id_proceso_rd='4' " ;
         $resulrtdes=mysql_query($sqlrtdes);
      }
      
   if($resulrt==1){
      echo 'ok';
   }else{
      echo 'ko!';    
   }

}

$id_numeracion=$_GET['id_numeracion'];
if($id_numeracion !='') {

   $sqlrt="DELETE FROM tbl_numeracion WHERE id_numeracion = '$id_numeracion'";
   $resulrt=mysql_query($sqlrt);
   if($resulrt==1){
      echo 'ok';
   }else{
      echo 'ko!';    
   }

}

//DELETE ITEMS REMISION INTERNA
 if(isset($_GET['id_items'],$_GET['pagina'],$_GET['id_add']) && $_GET['id_items']!='' ) { 
 
   $sqlegp="DELETE FROM tbl_items_remision_interna WHERE id='".$_GET['id_items']."' ";
   $resultegp=mysql_query($sqlegp);
   header($_GET['pagina'].'?remision_id='.$_GET['id_add']);
} 


//DELETE BODEGAS DEL CLIENTE
 if(isset($_GET['id_bodega'],$_GET['pagina'] ) && $_GET['id_bodega']!='' ) { 
 
   $sqlegp="DELETE FROM tbl_destinatarios WHERE id='".$_GET['id_bodega']."' ";
   $resultegp=mysql_query($sqlegp);

   if($resultado=$conexion->llenaListas("tbl_destinatarios tir ","WHERE tir.id_d=".$_GET['id_add'],""," * ")){  
      
     echo json_encode( $resultado); 
   } 
   //header($_GET['pagina'].'?id_c='.$_GET['id_cliente']);
} 

//DELETE ITEMS REMISION INTERNA
 if(isset($_GET['idplanchas'],$_GET['pagina'],$_GET['id_add']) && $_GET['idplanchas']!='' ) { 
 
   $sqlegp="DELETE FROM tblreporteplanchas WHERE id='".$_GET['idplanchas']."' ";
   $resultegp=mysql_query($sqlegp);
   header($_GET['pagina'].'?id_verif='.$_GET['id_add']);
} 



$id_salirExt=$_GET['id_salirExt'];
if($id_salirExt !='') {

   $sqlrt="DELETE FROM tbl_reg_produccion WHERE id_rp = '$id_salirExt'";
   $resulrt=mysql_query($sqlrt);
   if($resulrt==1){
      echo 'ok';
   }else{
      echo 'ko!';    
   }
   require_once($_GET['pagina']);

}

$id_matPrima=$_GET['id_rkp'];
if($id_matPrima !='') {

   $sqlrt="DELETE FROM tbl_reg_kilo_producido WHERE id_rkp = '$id_matPrima'";
   $resulrt=mysql_query($sqlrt);
  
   

}

?>