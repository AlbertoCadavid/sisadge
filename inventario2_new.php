<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
require (ROOT_BBDD); 
?> 
<?php require_once('Connections/conexion1.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
} 

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "usuario.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "usuario.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
//FIN
$conexion = new ApptivaDB();

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

//FECHAS DE IMPRESION
$maxRows_costos = 50;
$pageNum_costos = 0;
if (isset($_GET['pageNum_costos'])) {
  $pageNum_costos = $_GET['pageNum_costos'];
}
$startRow_costos = $pageNum_costos * $maxRows_costos;

mysql_select_db($database_conexion1, $conexion1);
if($_GET['fecha_ini']==''){$fecha1=first_month_day();}else{$fecha1=$_GET['fecha_ini'];}
//$fecha1 = $fecha1;
if($_GET['fecha_fin']==''){$fecha2=last_month_day();}else{$fecha2=$_GET['fecha_fin'];}
//$fecha2 = $fecha2;
$tipo = $_GET['tipo'];
//Filtra producto terminado
if($fecha1 != '' && $fecha2 != '')
{
 
 if($tipo==1){
  //$row_registros = $conexion->llenaListas("TblInventarioListado"," WHERE Tipo='$tipo'","ORDER BY CONVERT(Codigo, SIGNED INTEGER) DESC ","*" );
  $row_registros = $conexion->llenaListas("tbl_inventario"," ","ORDER BY CONVERT(referencia, SIGNED INTEGER) DESC ","*" );

 }else if($tipo==2){
  $row_registros = $conexion->llenaListas("insumo","","ORDER BY CONVERT(codigo_insumo, SIGNED INTEGER) ASC ","id_insumo as referencia,codigo_insumo,descripcion_insumo,valor_unitario_insumo,stok_insumo,medida_insumo " );

 }

}
 

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0014)about:internet -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SISADGE AC &amp; CIA</title>
<script src="librerias/sweetalert/dist/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/listado.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
<script type="text/javascript" src="js/formato.js"></script> 

<!-- desde aqui para listados nuevos -->
  <link rel="stylesheet" type="text/css" href="css/general.css"/> 
  <link rel="stylesheet" type="text/css" href="css/desplegable.css"/>

  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script> 
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script> 
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- select2 -->
  <link href="select2/css/select2.min.css" rel="stylesheet"/>
  <script src="select2/js/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/general.css"/>

  <!-- css Bootstrap hace mas grande el formato-->
  <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body ><!-- onload = "JavaScript: AutoRefresh (90000);" -->
<?php //echo $conexion->header('listas'); ?>
<form action="<?php echo $editFormAction; ?>" method="GET" name="form1">

  <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
    <div align="center">
      <table style="width: 98%"><!-- id="tabla1" -->
        <tr>
         <td align="center">
           <div class="row-fluid">
             <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
               <div class="panel panel-primary">
                <div class="panel-heading" align="left" ></div><!--color azul-->
                 <div class="row" >
                   <div class="span12">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/cabecera.jpg"></div>
                   <div class="span12"><h3> INVENTARIO &nbsp;&nbsp;&nbsp; </h3></div>
                 </div>
                 <div class="panel-heading" align="left" ></div><!--color azul-->
                    <div id="cabezamenu">
                     <ul id="menuhorizontal"> 
                      <li id="nombreusuario" ><?php echo $_SESSION['Usuario']; ?></li>
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li> 
                    </ul>
                </div> 
               <div class="panel-body">
                 <br> 
                 <div >  <!--  class="container" si lo quito se amplia todo el listado-->
                   
             <br> 
          <br>
          <!-- grid --> 

          <div class="container-fluid">  
 
              <div class="span3">
              DESDE:
                  <input name="fecha_ini" type="date" id="fecha_ini" required="required"  min="2000-01-02" size="10" value="<?php echo $_GET['fecha_ini']; ?>"/>
                  HASTA:
                  <input name="fecha_fin" type="date" id="fecha_fin" min="2000-01-02" size="10" required="required" value="<?php echo $_GET['fecha_fin']; ?>"/>
              <select name="tipo" id="tipo">
                  <option value="1"<?php if (!(strcmp("1", $tipo))) {echo "selected=\"selected\"";} ?>>PRODUCTO TERMINADO</option>
                  <option value="2"<?php if (!(strcmp("2", $tipo))) {echo "selected=\"selected\"";} ?>>MATERIAS PRIMAS</option>
                  <option value="3"<?php if (!(strcmp("3", $tipo))) {echo "selected=\"selected\"";} ?>>PRODUCTO EN PROCESO</option>
                  <option value="4"<?php if (!(strcmp("4", $tipo))) {echo "selected=\"selected\"";} ?>>MATERIA PRIMA EN PROCESO</option> 
                </select>
                <input type="submit" class="botonGMini" name="button" id="button" value="Consultar" /> 
               </div>
              
                <div class="row" >
                  <div class="span6" style="text-align: left;">
                <strong>Nota: </strong><br>
                      *El saldo en rojo en la columna (INVENTARIO FINAL) es porque hay un stok minimo..<br>
                      *Valor Unidad proviene del valor con el que se vendio en la o.c<br>
                      *En Materias Primas las entradas provienen de los ingresos de almacen de mp y producto terminado desde sellado. y en salidas en materias primas son del consumo por proceso y de producto terminado sus Despachos, todo por fecha<br>
                      *La Medida de venta Unidad o millar debe ser igual en la cotiz como en la o.c<br>
                    </div>
                    <div class="span6" style="text-align: left;">
                    <a href="inventario_add.php"><img src="images/mas.gif" alt="ADD COSTO REFERENCIA" title="ADD COSTO REFERENCIA" border="0" style="cursor:hand;" /></a><a href="produccion_registro_extrusion_listado.php"><img src="images/e.gif" alt="LISTADO EXTRUSION"title="LISTADO EXTRUSION" border="0" style="cursor:hand;" /></a><a href="produccion_registro_impresion_listado.php"><img src="images/i.gif" alt="LISTADO IMPRESION"title="LISTADO IMPRESION" border="0" style="cursor:hand;" /></a><a href="consumo_materias_primas.php"><img src="images/mp.gif" alt="LISTADO DE MATERIAS PRIMAS"title="LISTADO DE MATERIAS PRIMAS" border="0" style="cursor:hand;" /></a><img src="images/impresor.gif" onClick="window.print();" style="cursor:hand;" alt="IMPRIMIR" title="IMPRIMIR" border="0" /><a href="javascript:location.reload()"><img src="images/ciclo1.gif" alt="RESTAURAR" title="RESTAURAR" border="0" style="cursor:hand;"/></a>

                    <input type="button" class="botonGMini" value="Carga Masiva" onclick="window.location = 'inventario_importar.php?tipo=<?php echo $tipo ?>'" />
                    <input type="button" class="botonGMini" value="Descarga Excel" onclick="window.location = 'inventario_excel.php?tipo=<?php echo $tipo ?>'" />

                  </div>
          
             <hr>
 
  </form>

 <form action="inventario2.php" method="POST"  enctype="multipart/form-data" name="form2"> 
  <?php if($tipo=='1') {?>
  <div class="row align-items-start"> 
    <div style="width: 100px;" ><strong>CODIGO</strong></div>
    <div style="width: 100px;" ><strong>DESCRIPCION</strong></div>
    <div style="width: 100px;" ><strong>UNIDAD</strong></div>
    <div style="width: 100px;" ><strong>INV. INICIAL</strong></div>
    <div style="width: 100px;" ><strong>ENTRADAS</strong></div>
    <div style="width: 150px;" ><strong>REMISION (Sistema)</strong></div>
    <div style="width: 100px;" ><strong>SALIDAS(Manual)</strong></div>
    <div style="width: 150px;" title="Suma de inventario inicial + entradas  - Remisiones"><strong>INVENTARIO FINAL</strong></div>
    <div style="width: 100px;" title="Es las cantidades en tabla de insumos" ><strong>STOK</strong></div>
    <div style="width: 100px;" ><strong>$. O.C</strong></div>
    <div style="width: 100px;" ><strong>$. INV.</strong></div>
    <div style="width: 100px;" ><strong>$. TOTAL</strong></div>
    <div style="width: 200px;" ><strong>TIPO</strong></div> 
    <!-- <div style="width: 100px;" ><strong>Modifico</strong></div> -->
    <div style="width: 100px;" ><strong>Fecha</strong></div>           
  </div> 

  <div class="divScrollGigante" id="itemspedido" role="alert" style="text-align: left;"> 
  
   <?php foreach($row_registros as $row_costos) {  ?>
   <div class="row celdaborde1">
       <div style="width: 20px;" id="fondo_2"> </div>
   <div style="width: 100px;" id="fondo_2">
     <?php 
      echo $row_costos['referencia'];
      $Cod_ref=$row_costos['referencia'];

       $descripcion = $conexion->llenarCampos("Tbl_referencia"," WHERE cod_ref='$Cod_ref' ","ORDER BY CONVERT(cod_ref, SIGNED INTEGER) ASC ","tipo_bolsa_ref" );
       $descripcion=$descripcion["tipo_bolsa_ref"];
      ?>
   </div>
     
   <div style="width: 100px;" id="fondo_2"><?php  echo $descripcion; ?></div>
   <div style="width: 100px;" id="fondo_2">
      <?php
    	  $medRefConv = $conexion->llenarCampos("Tbl_items_ordenc"," WHERE int_cod_ref_io = '$Cod_ref' ","ORDER BY id_items DESC ","str_unidad_io,int_precio_io" );

    	  /*$sqlcosto = "SELECT str_unidad_io,int_precio_io FROM Tbl_items_ordenc WHERE int_cod_ref_io = $Cod_ref ORDER BY id_items DESC LIMIT 1";
    	  $resultcosto=mysql_query($sqlcosto); 
    	  $numcosto=mysql_num_rows($resultcosto); */
    	  if ($medRefConv > 0)
    	  { 
    		$valor_ins= $medRefConv['int_precio_io'];
    		echo $medRefConv = $medRefConv['str_unidad_io'];

    		if($medRefConv=='MILLAR')
    		{
    			$medidatipo="MILLAR";
    			($valor_insumo=$valor_ins/1000);}
    		else
    		{
    			$medidatipo="UNIDAD";
    			$valor_insumo=$valor_ins;}
    		  
    	  }  
     ?>
    </div> 
    <div style="width: 100px;" id="fondo_2"> 
      <?php  
	  //INVENTARIO INICIAL  
	  $saldo_inicial = $row_costos['inventario'];
	  if($saldo_inicial==''){echo "0";} else { ?><a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=1','810','250')" style="text-decoration:none;"><?php echo $saldo_inicial ?></a><?php }?>
      
    </div>
    <div style="width: 100px;" id="fondo_2">

	  <?php
	  //ENTRADAS 
    $Cod_ref=$row_costos['referencia'];
	  $numinv = $conexion->llenarCampos("TblSelladoRollo"," WHERE CONVERT(ref_r, SIGNED INTEGER)='$Cod_ref' AND reproceso_r = '0' AND DATE(fechaI_r) BETWEEN '$fecha1' AND '$fecha2' ","","SUM(bolsas_r) AS entrada" );
	 
		  echo $entrada=$numinv['entrada']=='' ? '0' : $numinv['entrada'];
	     
 	  //echo $entrada=$row_costos['Entrada'];
	  ?>
  </div>
    <div style="width: 130px;" id="fondo_2">
      <?php
	  
	  //REMISION SEGUN REMISION 
    $numRem = $conexion->llenarCampos("Tbl_remisiones,Tbl_remision_detalle"," WHERE Tbl_remisiones.int_remision=Tbl_remision_detalle.int_remision_r_rd  AND estado_rd='0' 
    AND Tbl_remision_detalle.fecha_rd BETWEEN '$fecha1' AND '$fecha2' AND Tbl_remision_detalle.int_ref_io_rd='$Cod_ref' ",""," SUM(int_cant_rd) AS salidas " );
     
     $salidaRem=$numRem['salidas']=='' ? "0" : $numRem['salidas'];
 	  
    ?> 
      <!-- inventario_edit.php-->
      <a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=1','810','250')" style="text-decoration:none;">
        <?php echo $salidaRem=='' ? '0' : $salidaRem;?></a>
    </div>
    <div style="width: 150px;" id="fondo_2">

    <?php
	  //SALIDAS (Manual)
 	   echo $salidaExc=$row_costos['despacho']=='' ? '0' : $row_costos['despacho'];
 	   ?>
      
    </div>
    <div style="width: 140px;" id="fondo_2">
      <?php
	  //INVENTARIO FINAL
	  //$saldo_final=(($saldo_inicial+$entrada)-$salidaRem);
    $saldo_final=($saldo_inicial+$entrada)-$salidaRem;
	  if($saldo_final<$stok){
      echo "<span class='rojo_normal'>". numeros_format($saldo_final) ."</spam>";}
      else
        {
          echo numeros_format($saldo_final);
        }
	  ?> 
  </div>
    <div style="width: 100px;" id="fondo_2">
          <?php
             //Stok
             echo $stok=$saldo_final;
          ?>
    </div>
    <div style="width: 100px;" id="fondo_2">

 	  <!--VALOR UNIDAD-->
       <a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=1','810','250')" style="text-decoration:none;"><?php echo $valor_insumo; ?></a>
      </div>
    <div style="width: 100px;" id="fondo_2">

	  <!--//COSTO INV-->
	  <a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=2','810','250')" style="text-decoration:none;"><?php if($medidatipo=='MILLAR')
		{ 
			 
			echo $CostoUnd = ($row_costos['CostoUnd']/1000);
		}else{echo $CostoUnd = $row_costos['CostoUnd'];
		}?></a>
  </div>     
    <div style="width: 100px;" id="fondo_2">
      <?php
	  //COSTO FINAL 
	  $TotalCosto=($saldo_final*$valor_insumo); echo numeros_format($TotalCosto);
	  ?>
  </div>
    <div nowrap="nowrap" style="width: 200px;" id="fondo_2"> 
      <?php if (!(strcmp("1", $tipo))) {echo "PRODUCTO TERMINADO";} ?>
      <?php if (!(strcmp("2", $tipo))) {echo "MATERIAS PRIMAS";} ?>
      <?php if (!(strcmp("3", $tipo))) {echo "PRODUCTO EN PROCESO";} ?>
      <?php if (!(strcmp("4", $tipo))) {echo "MATERIA PRIMA EN PROCESO";} ?>
    </div>
     <!--  <div style="width: 100px;" id="fondo_2"><?php echo $row_costos['Modifico'];?>
    </div> -->
      <div style="width: 100px;" id="fondo_2"><?php echo $row_costos['fecha'];?>
    </div> 
    
   </div>
        <?php } ?>
    <?php }?>  
    </div>



    <!--MATERIAS PRIMAS-->
  <?php if($tipo=='2') {?>
  <div class="row align-items-start">
    <div style="width: 70px;" ><strong>ID</strong></div> 
    <div style="width: 70px;" ><strong>CODIGO</strong></div>
    <div style="width: 300px;" ><strong>DESCRIPCION</strong></div>
    <div style="width: 70px;" ><strong>UNIDAD</strong></div>
    <div style="width: 70px;" ><strong>INV. INICIAL</strong></div>
    <div style="width: 70px;" ><strong>ENTRADAS</strong></div>
    <div style="width: 150px;" ><strong>REMISION (Sistema)</strong></div>
    <div style="width: 100px;" ><strong>SALIDAS(Manual)</strong></div>
    <div style="width: 150px;" title="Suma de inventario inicial + entradas  - Remisiones"><strong>INVENTARIO FINAL</strong></div>
    <div style="width: 70px;" title="Es las cantidades en tabla de insumos"><strong>STOK</strong></div>
    <div style="width: 70px;" ><strong>$. INSUMO</strong></div>
    <div style="width: 70px;" ><strong>$. INV.</strong></div>
    <div style="width: 70px;" ><strong>$. TOTAL</strong></div>
    <div style="width: 200px;" ><strong>TIPO</strong></div> 
    <!-- <div style="width: 70px;" ><strong>Modifico</strong></div> -->
    <div style="width: 70px;" ><strong>Fecha</strong></div>           
  </div> 
  <div class="divScrollGigante" id="itemspedido" role="alert" style="text-align: left;"> 
  
   <?php foreach($row_registros as $row_costos) {  ?>
   <div class="row celdaborde1">
       <div style="width: 20px;" id="fondo_2"> </div>
  <div style="width: 70px;" id="fondo_2">
    <?php  
    $id_insumo=$row_costos['referencia'];  
    $codigo=$row_costos['referencia'];

      $numdescri = $conexion->llenarCampos("insumo"," WHERE id_insumo='$codigo'","","id_insumo,codigo_insumo,descripcion_insumo,valor_unitario_insumo,stok_insumo,medida_insumo " );
      $id_insumo=$numdescri["id_insumo"];
      $medida_insumo=$numdescri["medida_insumo"];
      $codigo_insumo=$numdescri["codigo_insumo"];
      $stok=$numdescri["stok_insumo"];
      $descripcion=$numdescri["descripcion_insumo"];
      $valor_insumo2=$numdescri["valor_unitario_insumo"];
      echo $id_insumo;
      ?>
  </div>
  <div style="width: 70px;" id="fondo_2"><?php echo $codigo_insumo;?></div> 
  <div style="width: 300px;" id="fondo_2"><?php echo $descripcion;?> </div> 
  <div style="width: 70px;" id="fondo_2">
    <?php //UNIDAD MEDIDA
    $medida_insumo=$medida_insumo;
    $numMedida=$conexion->llenarCampos("medida"," WHERE id_medida='$medida_insumo' ","","nombre_medida" );
    $medidasInsumo=$numMedida["nombre_medida"]; 
    echo $medidasInsumo;
    ?> 
    </div>
  <div style="width: 70px;" id="fondo_2">
  <?php
     //INVENTARIO INICIAL 
     $saldo_inicial= $row_costos['inventario'];
     if($saldo_inicial==''){echo "0";} else { ?><a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=1','810','250')" style="text-decoration:none;"><?php echo $saldo_inicial ?></a><?php }
  ?>
  </div>
  <div style="width: 70px;" id="fondo_2">
   <?php
   //ENTRADAS
   $id_rpp_rp=$id_insumo;
   $numinv=$conexion->llenarCampos("TblIngresos"," WHERE id_insumo_ing='$id_rpp_rp' AND fecha_ing BETWEEN '$fecha1' AND '$fecha2' ","","SUM(TblIngresos.ingreso_ing) AS entrada" );
   $entrada=$numinv['entrada'];
   // $entrada=$row_costos['Entrada'];
  ?>
  <a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=1','810','250')" style="text-decoration:none;"><?php  echo numeros_format($entrada) ?></a>
  </div>
  <div style="width: 150px;" id="fondo_2">
   <?php 
    //REMISION (Sistema) PRODUCCION SALIDA TOTALIZADAS DE KILOS
   $id_rpp_rp=$id_insumo;
   $numsal=$conexion->llenarCampos("Tbl_reg_kilo_producido"," WHERE id_rpp_rp='$id_rpp_rp' AND DATE(fecha_rkp) BETWEEN '$fecha1' AND '$fecha2' ","","SUM(valor_prod_rp) AS consumo" );
   $salidasP=numeros_format($numsal['consumo']) == '' ? '0' : numeros_format($numsal['consumo']);
   echo $salidasP;        
  ?>
    </div>
  <div style="width: 100px;" id="fondo_2">
    <?php //SALIDAS(Manual) SALIDAS SEGUN POR DESCUENTOS UNO A UNO
    echo $salidas=$row_costos['despacho']; ?></div>
  <div style="width: 150px;" id="fondo_2">
      <?php //INVENTARIO FINAL
      $saldo_final=(($saldo_inicial+$entrada)-$salidas);
      if($saldo_final < $stok){
        echo "<span class='rojo_normal'>". numeros_format($saldo_final) ."</spam>";}else{echo numeros_format($saldo_final);}
      ?>
  </div>
  <div style="width: 70px;" id="fondo_2">
  <?php //STOK
    echo $stok; ?>
  </div>
  <div style="width: 70px;" id="fondo_2">
      <!--//VALOR O.C-->
       <?php echo numeros_format($valor_insumo2);?>
  </div>
  <div style="width: 70px;" id="fondo_2">
  <!--//COSTO INV-->
      <a href="javascript:verFoto('manteni.php?idInv=<?php echo $row_costos['id'] ?>&tipo=2','810','250')" style="text-decoration:none;"><?php echo $CostoUnd= $row_costos['CostoUnd'];?></a>
  </div>
  <div style="width: 70px;" id="fondo_2">
    <?php 
       $TotalCosto=($saldo_final*$valor_insumo2); echo numeros_format($TotalCosto);
    ?>
  </div>
  <div style="width: 200px;" id="fondo_2">
         <?php if (!(strcmp("1", $tipo))) {echo "PRODUCTO TERMINADO";} ?>
         <?php if (!(strcmp("2", $tipo))) {echo "MATERIAS PRIMAS";} ?>
         <?php if (!(strcmp("3", $tipo))) {echo "PRODUCTO EN PROCESO";} ?>
         <?php if (!(strcmp("4", $tipo))) {echo "MATERIA PRIMA EN PROCESO";} ?>
  </div>
           
  <!-- <div style="width: 70px;" id="fondo_2"><?php echo $row_costos['Modifico'];?></div> -->
  <div style="width: 70px;" id="fondo_2"><?php echo $row_costos['fecha'];?></div>
  
   </div>
        <?php } ?>
    <?php }?>  
    </div>

 
<table id="tabla1">
  <tr>
    <td colspan="11" id="dato3"> 
        <!-- <input name="button2" class="botonFinalizar" id="button2" type="button" value="Guardar Inventario" onclick="return enviaForm('inserts.php?insert=<?php echo '0'; ?>');"/> -->
        <!--?fecha_ini=<?php echo $fecha1 ?>&fecha_fin=<?php echo $fecha2 ?>&tipo=<?php echo $tipo ?>--></td>
    </tr>
</table>
  </form>
 
<?php echo $conexion->header('footer'); ?>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($costos);

?>