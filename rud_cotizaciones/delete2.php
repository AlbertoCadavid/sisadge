<?php require_once('Connections/conexion1.php'); ?>
<?php
mysql_select_db($database_conexion1, $conexion1);
/*----------VARIABLES------------*/
$delete_bolsa=$_GET['delete_bolsa'];
$delete_lamina=$_GET['delete_lamina'];
$delete_mp=$_GET['delete_mp'];
$delete_pl=$_GET['delete_pl'];
/*----------EJECUCION DEL CODIGO BOLSA------------*/
if($delete_bolsa!=''){
$sqlbolsa="DELETE FROM Tbl_cotiza_bolsa WHERE N_cotizacion='$delete_bolsa'";
$resultbolsa=mysql_query($sqlbolsa);
$sqlrefe="DELETE FROM Tbl_cliente_referencia WHERE N_cotizacion='$delete_bolsa'";
$resultrefe=mysql_query($sqlrefe);
$sqltex="DELETE FROM Tbl_cotiza_bolsa_obs WHERE N_cotizacion='$delete_bolsa'";
$resulttex=mysql_query($sqltex);
header('location:cotizacion_general_bolsas.php');}
/*----------EJECUCION DEL CODIGO LAMINAS------------*/
if($delete_lamina!=''){
$sqllamina="DELETE FROM Tbl_cotiza_laminas WHERE N_cotizacion='$delete_lamina'";
$resultlamina=mysql_query($sqllamina);
$sqllaminarefe="DELETE FROM Tbl_cliente_referencia WHERE N_cotizacion='$delete_lamina'";
$resultlaminarefe=mysql_query($sqllaminarefe);
$sqllaminatex="DELETE FROM Tbl_cotiza_lamina_obs WHERE N_cotizacion='$delete_lamina'";
$resultlaminatex=mysql_query($sqllaminatex);
header('location:cotizacion_general_laminas.php');}
/*----------EJECUCION DEL CODIGO ,ATERIA PRIMA------------*/
if($delete_mp!=''){
$sqlmp="DELETE FROM Tbl_cotiza_materia_p WHERE N_cotizacion='$delete_mp'";
$resultmp=mysql_query($sqlmp);
$sqlmprefe="DELETE FROM Tbl_cliente_referencia WHERE N_cotizacion='$delete_mp'";
$resultmprefe=mysql_query($sqlmprefe);
$sqlmptex="DELETE FROM Tbl_cotiza_materia_p_obs WHERE N_cotizacion='$delete_mp'";
$resultmptex=mysql_query($sqlmptex);
header('location:cotizacion_general_materia_prima.php');}

/*----------EJECUCION DEL CODIGO PACKING LIST------------*/
if($delete_pl!=''){
$sqlpl="DELETE FROM Tbl_cotiza_packing WHERE N_cotizacion='$delete_pl'";
$resultpl=mysql_query($sqlpl);
$sqlplrefe="DELETE FROM Tbl_cliente_referencia WHERE N_cotizacion='$delete_pl'";
$resulpltrefe=mysql_query($sqlplrefe);
$sqlpltex="DELETE FROM Tbl_cotiza_packing_obs WHERE N_cotizacion='$delete_pl'";
$resultpltex=mysql_query($sqlpltex);
header('location:cotizacion_general_packingList.php');}
?>