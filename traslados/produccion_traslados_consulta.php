<?php require_once('../Connections/conexion1.php'); ?>
<?php
if(isset($_GET['getClientId'])){
  mysql_select_db($database_conexion1, $conexion1);
    $query_sql = "SELECT id_op FROM Tbl_orden_produccion ORDER BY id_op DESC LIMIT 1";
	$res = mysql_query($query_sql, $conexion1) or die(mysql_error());
 	
    if($inf = mysql_fetch_array($res)){
		$nueva_op =$inf["id_op"]+1;
		
 	echo "formObj.op_destino.value = '".$nueva_op."';\n"; 

    }else{
 	echo "formObj.op_destino.value = '';\n"; 
  }    
}
?>