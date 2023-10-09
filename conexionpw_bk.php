
<?php 
date_default_timezone_set('America/Bogota');
function Conectarpw()
{
	$host = "localhost";
	$bd = "acycia_intranet_dev";
	$user ="acyciapw";
	$password = "acyciapw";
	$mysqli = new mysqli($host, $user, $password, $bd );
	if ($mysqli->connect_errno) 
	{
		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit;
	}
	else
	{
		$mysqli->character_set_name();
		$mysqli->set_charset("utf8");
		logs(utf8_encode("Iniciando Conexion.. AcyciaPw..."));
		return $mysqli;
	}
}

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
		logs("Iniciando.. Conexion...");
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
				MAX(CASE WHEN META_KEY = '_paid_date' THEN meta_value END) AS FECHA_SOLICITUD,
				MAX(CASE WHEN META_KEY = '_paid_date' THEN meta_value END) AS FECHA_COMPLETADA,
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
	
	logs("Consultando Ventas del dia");
	$resultado = $conexion->query($sql); 
	
	$ventas = getResultados($resultado);
	 
	if(count($ventas)==0 )
	{
		logs("No hay ventas disponibles del dia ".$fecha);
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
    //echo "<pre>";
	//print_r($exportacion);die;
	//inicia insert
	inserts($exportacion,$conexion);
	logs("Finalizando Proceso");
	//cerrar conexion a worpress
	$conexion->close();	
	logs("Cerrando conexion");
}

function inserts($exportacion,$conexion)
{  
	$conexionpw = Conectarpw();
	foreach ($exportacion as $key => $cliente) 
	{
		 $fecha=date('Y-m-d');
		 if($cliente['CEDULA']!='')
		 {
		 	$query_cliente = $conexionpw->query("SELECT id_c FROM cliente WHERE nit_c='".$cliente['CEDULA']."' ");
		 	 $result_cliente = $query_cliente->fetch_row();
             $idcliente=$result_cliente[0];

            if($result_cliente[0] == '' )
            {
             
            	//insert en la tabla de clientes
            	$insertSQL = "INSERT INTO cliente (nit_c,nombre_c,fecha_ingreso_c,telefono_c,direccion_c,telefono_contacto_c,celular_contacto_c,email_comercial_c,forma_pago_c,estado_c) VALUES ('".$cliente['CEDULA']."','".$cliente['NOMBRE'].' '.$cliente['APELLIDO']."','".$fecha."','".$cliente['TELEFONO']."','".$cliente['DIRECCION_1']."','".$cliente['TELEFONO']."','".$cliente['TELEFONO']."','".$cliente['EMAIL']."','".$cliente['METODO_PAGO']."','".$cliente['ESTADO']."');";   
            		$conexionpw->query($insertSQL);

            		//recupero id_c de clientes
            		$query_cliente = $conexionpw->query("SELECT MAX(id_c) FROM cliente WHERE nit_c='".$cliente['CEDULA']."' ");
            		 $result_cliente = $query_cliente->fetch_row(); 
            		 $idcliente=$result_cliente[0];

            }
                //insert en la tabla de orden de compra
                $insertSQL2 = "INSERT INTO tbl_orden_compra (str_numero_oc,id_c_oc,str_nit_oc,fecha_ingreso_oc,str_condicion_pago_oc,str_observacion_oc,int_total_oc,str_dir_entrega_oc,str_elaboro_oc,b_estado_oc,b_borrado_oc,vta_web_oc) VALUES ('".$cliente['ORDEN']."PW',".$idcliente.",'".$cliente['CEDULA']."','".$fecha."','".$cliente['METODO_PAGO']."','WEB:".$cliente['DIRECCION_1']."-TOTAL:".$cliente['TOTAL']."-IVA:".$cliente['IVA']."','".$cliente['TOTAL']."','".$cliente['DIRECCION_1']."','Angela Gutierrez','1','0','1')"; 
             	$conexionpw->query($insertSQL2);

             	       $query_pedido = $conexionpw->query("SELECT MAX(id_pedido) FROM tbl_orden_compra WHERE str_numero_oc= '".$cliente['ORDEN']."PW' ");
                    	 $result_pedido = $query_pedido->fetch_row(); 
                    	 $idpedido=$result_pedido[0];

	        if($cliente['ORDEN']!='')
	        {
	        	       //insert en la tabla de remisiones
	        	      /*$resultado5 = $conexionpw->query("SELECT MAX(int_remision+1) FROM tbl_remisiones  ");
	        	      $remision_id = $resultado5->fetch_row(); 

	        	      
	        	      $insertSQL4 = "INSERT INTO tbl_remisiones (ciudad_pais,int_remision,str_numero_oc_r,fecha_r,str_observacion_r) VALUES ('COLOMBIA', ".$remision_id[0].",'".$cliente['ORDEN']."PW','".$fecha."','VENDIDO DESDE PW')";    
	        	      $conexionpw->query($insertSQL4);*/


				 foreach ($cliente['detalle'] as $key => $itemsoc) 
				 {
				 	  $sku_ref = explode('-', $itemsoc['sku']);
				 	  $sku_ref = $sku_ref[0];
				 	  //insert en la tabla de items orden compra
                      $insertSQL3 = "INSERT INTO tbl_items_ordenc (id_pedido_io,str_numero_io,int_cod_ref_io,int_cantidad_io,int_cantidad_rest_io,str_unidad_io,fecha_entrega_io,int_precio_io,int_total_item_io,str_moneda_io, str_direccion_desp_io,b_estado_io) VALUES (".$idpedido.",'".$cliente['ORDEN']."PW','".$sku_ref."','".$itemsoc['cantidad']."','".$itemsoc['cantidad']."','PAQUETE','".$fecha."','".$itemsoc['valor_total']."', '".$itemsoc['valor_total']."','COL$','".$cliente['DIRECCION_1']."','0')";    
				 	  $conexionpw->query($insertSQL3);
				 	  
				 	  //insert en la tabla de remision detalle
                      /*$insertSQL6 = "INSERT INTO tbl_remision_detalle (int_remision_r_rd,str_numero_oc_rd,fecha_rd,int_ref_io_rd,estado_rd) VALUES (".$remision_id[0].",'".$cliente['ORDEN']."PW','".$fecha."','".$itemsoc['sku']."','1')";    
				 	  $conexionpw->query($insertSQL6);*/
				 	  
				 }         
	        }

		 }
	//insert tabla de control
	$insert = "INSERT INTO acycia_ventas (ORDER_ID, FECHA, FECHA_INSERT) VALUES('".$cliente['ORDEN']."', '".date('Y-m-d')."', '".date('Y-m-d H:i:s')."')";
	    $conexion->query($insert);

	    logs($cliente['CEDULA']);
	    //exit();

	}
	//cerrar conexion a intranet
	$conexionpw->close();
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

 ?>