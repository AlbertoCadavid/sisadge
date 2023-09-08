<?php 
$hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet";
$username_conexion1 = "acycia_root";
$password_conexion1 = "ac2006";
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
 ?>
<?php 


date_default_timezone_set('America/Bogota');

function Conectar()
{
	$host = "host101.latinoamericahosting.com";
	$bd = "acycia_wp261";
	$user ="acycia_wp261";
	$password = "8r2p(tS.5B";
	$mysqli = new mysqli($host, $bd, $password, $user);
	if ($mysqli->connect_errno) 
	{
		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit;
	}
	else
	{
		$mysqli->character_set_name();
		$mysqli->set_charset("utf8");
		logs("Iniciando Conexión...");
		return $mysqli;
	}
}

function getVentasbyDay()
{
	$ventas = array();
	$productos = array();
	$detalle = array();
	$exportacion = array();
	if(isset($_GET["fecha"]) && $_GET["fecha"])
	{
		$fecha = $_GET["fecha"];
	}
	else
	{
		$fecha = date("Y-m-d");
	}
	
	$conexion = Conectar();
	$sql = "SELECT * FROM (
				SELECT 
				POST_ID AS ORDEN,
				MAX(CASE WHEN META_KEY = '_billing_wooccm11' THEN meta_value END) AS CEDULA,
				MAX(CASE WHEN META_KEY = '_billing_first_name' THEN meta_value END) AS NOMBRE,
				MAX(CASE WHEN META_KEY = '_shipping_last_name' THEN meta_value END) AS APELLIDO,
				MAX(CASE WHEN META_KEY = '_billing_city' THEN meta_value END) AS CIUDAD,
				MAX(CASE WHEN META_KEY = '_completed_date' THEN meta_value END) AS FECHA_SOLICITUD,
				MAX(CASE WHEN META_KEY = '_completed_date' THEN meta_value END) AS FECHA_COMPLETADA,
				MAX(CASE WHEN META_KEY = '_billing_phone' THEN meta_value END) AS TELEFONO,
				MAX(CASE WHEN META_KEY = '_billing_address_1' THEN meta_value END) AS DIRECCION_1,
				MAX(CASE WHEN META_KEY = '_billing_address_2' THEN meta_value END) AS DIRECCION_2,
				MAX(CASE WHEN META_KEY = '_payment_method' THEN meta_value END) AS METODO_PAGO,
				MAX(CASE WHEN META_KEY = '_billing_email' THEN meta_value END) AS EMAIL,
				MAX(CASE WHEN META_KEY = '_order_tax' THEN meta_value END) AS IVA,
				MAX(CASE WHEN META_KEY = '_order_total' THEN meta_value END) AS TOTAL,
				MAX(CASE WHEN META_KEY = '_p2p_status' THEN meta_value END) AS ESTADO,
				MAX(CASE WHEN META_KEY = '_billing_company' THEN meta_value END) AS EMPRESA
				FROM  wp5s_postmeta  GROUP BY POST_ID) T 
				LEFT JOIN acycia_ventas V ON(T.ORDEN = V.ORDER_ID)
			WHERE T.FECHA_COMPLETADA LIKE  '%".$fecha."%' AND T.ESTADO = 'APPROVED'  AND V.ORDER_ID IS NULL";
	
	logs("Consultando Ventas del día");
	$resultado = $conexion->query($sql);
	
	if($resultado)
	{
		$ventas = getResultados($resultado);
	}
	else
	{
		logs("No hay ventas disponibles del día ".$fecha);
		exit;
	}
	
	$exportacion = $ventas;

	foreach($ventas as $key => $value)
	{
		$resultado1 = $conexion->query("select * from wp5s_woocommerce_order_items where  order_item_type  ='line_item' AND order_id =".$value["ORDEN"]);
		$productos = getResultados($resultado1);

		foreach($productos as $key1 => $value1)
		{
			$resultado2 = $conexion->query("select * from wp5s_woocommerce_order_itemmeta  where order_item_id=".$value1["order_item_id"]);
			$detalle = getResultados($resultado2);

			$resultado3 = $conexion->query("SELECT P.SKU 
									FROM wp5s_woocommerce_order_itemmeta O
									JOIN wp5s_wc_product_meta_lookup P ON(O.meta_value = P.product_id )
									WHERE O.ORDER_ITEM_ID = ".$value1["order_item_id"]." AND O.meta_key  ='_variation_id'");
			$sku = $resultado3->fetch_row();
			$exportacion[$key]["detalle"][] = array(
				"sku" => $sku[0],
				"descripcion" => $value1["order_item_name"],
				"cantidad" => $detalle[2]["meta_value"],
				"valor_total" => $detalle[4]["meta_value"],
				"size" => $detalle[9]["meta_value"],

			);

		}
	}
	echo "<pre>";
	//print_r($exportacion);
	inserts($exportacion);
	logs("Finalizando Proceso");
	$conexion->close();
	logs("Cerrando conexión");
}

function getResultados($arreglo)
{
	$rows = array();
	while($row = $arreglo->fetch_array(MYSQLI_ASSOC))
	{
		$rows[] = $row;
	}
	return $rows;
}

function logs($msg)
{
	echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
}

getVentasbyDay();

function inserts($exportacion){
	foreach ($exportacion as $key => $cliente) {
		 $fecha=date('d/m/yy');
		 if($cliente['CEDULA']!=''){
			$insertSQL = "INSERT INTO cliente (nit_c,nombre_c,fecha_ingreso_c,telefono_c,direccion_c,telefono_contacto_c,celular_contacto_c,email_comercial_c,forma_pago_c,estado_c) VALUES ('".$cliente['CEDULA']."','".$cliente['NOMBRE']."','".$fecha."','".$cliente['TELEFONO']."','".$cliente['DIRECCION_1']."','".$cliente['TELEFONO']."','".$cliente['TELEFONO']."','".$cliente['EMAIL']."','".$cliente['METODO_PAGO']."','".$cliente['ESTADO']."')";    
				mysql_select_db($database_conexion1, $conexion1);
				$Result = mysql_query($insertSQL, $conexion1) or die(mysql_error());
				
         $insertSQL2 = "INSERT INTO tbl_orden_compra (str_numero_oc,id_c_oc,str_nit_oc,fecha_ingreso_oc,str_condicion_pago_oc,str_observacion_oc,int_total_oc,b_estado_oc) VALUES ('PW".$cliente['ORDEN']."','".$cliente['CEDULA']."','".$cliente['CEDULA']."','".$fecha."','".$cliente['METODO_PAGO']."','WEB','".$cliente['TOTAL']."','1')";    
         	/*mysql_select_db($database_conexion1, $conexion1);
         	$Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error());*/	

	      if($cliente['ORDEN']!=''){
				 foreach ($cliente['detalle'] as $key => $itemsoc) {
                      $insertSQL3 = "INSERT INTO tbl_items_ordenc (str_numero_io,int_cod_ref_io,int_cantidad_io,str_unidad_io,int_total_item_io,str_direccion_desp_io,b_estado_io) VALUES ('PW".$cliente['ORDEN']."','".$itemsoc['sku']."','".$itemsoc['cantidad']."','UNIDAD','".$cliente['valor_total']."','WEB','".$cliente['DIRECCION_1']."','1')";    
				 	  	   /*mysql_select_db($database_conexion1, $conexion1);
				 	    	$Result3 = mysql_query($insertSQL3, $conexion1) or die(mysql_error());*/
				 	    
				 	  $insertSQL4 = "INSERT INTO tbl_remisiones (str_numero_oc_r,fecha_r,str_observacion_r) VALUES ('PW".$cliente['ORDEN']."','".$fecha."','VENDIDO DESDE PW')";    
				 	  	/*mysql_select_db($database_conexion1, $conexion1);
				 	  	$Result4 = mysql_query($insertSQL4, $conexion1) or die(mysql_error());*/

                      $insertSQL5 = "INSERT INTO tbl_remision_detalle (str_numero_oc_rd,fecha_rd,int_ref_io_rd,estado_rd) VALUES ('PW".$cliente['ORDEN']."','".$fecha."','".$itemsoc['sku']."','1')";    
				 	  	/*mysql_select_db($database_conexion1, $conexion1);
				 	  	$Result5 = mysql_query($insertSQL5, $conexion1) or die(mysql_error());*/


	                 echo "<pre>";
	                 print_r($insertSQL5);
				 	   
				 }
	      }


		 }
		
	
	}
	exit();
	
}

 ?>