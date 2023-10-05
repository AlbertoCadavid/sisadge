
<?php 
//ACTUAL 16/09

date_default_timezone_set('America/Bogota');
function Conectarpw()
{
	$host = "localhost";
	$bd = "acycia_intranet";
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
	$host = "acycia.com";//"host101.latinoamericahosting.com";
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
	///columnas
	//_payment_method
	//_paid_date si es Transferencia bancaria directa puede q se visualice al dia siguiente
	///DIRECCION COMPLETA facturacion _billing_address_index
	//transportadorea viene en jaso _wc_shipment_tracking_item
	$conexion = Conectar();
	$sql = "SELECT * FROM (
	SELECT 
	POST_ID AS ORDEN,
	MAX(CASE WHEN META_KEY = '_billing_wooccm11' THEN meta_value END) AS CEDULA,
	MAX(CASE WHEN META_KEY = '_billing_first_name' THEN meta_value END) AS NOMBRE,
	MAX(CASE WHEN META_KEY = '_billing_last_name' THEN meta_value END) AS APELLIDO,
	MAX(CASE WHEN META_KEY = '_shipping_first_name' THEN meta_value END) AS NOMBRE_E,
	MAX(CASE WHEN META_KEY = '_shipping_last_name' THEN meta_value END) AS APELLIDO_E,
	MAX(CASE WHEN META_KEY = '_billing_city' THEN meta_value END) AS CIUDADF,
	MAX(CASE WHEN META_KEY = '_shipping_city' THEN meta_value END) AS CIUDAD,
	MAX(CASE WHEN META_KEY = '_shipping_state' THEN meta_value END) AS DEPARTAMENTO,
	MAX(CASE WHEN META_KEY = '_shipping_country' THEN meta_value END) AS PAIS,
	MAX(CASE WHEN META_KEY = '_shipping_postcode' THEN meta_value END) AS POSTAL,
	MAX(CASE WHEN META_KEY = '_paid_date' THEN meta_value END) AS FECHA_SOLICITUD,
	MAX(CASE WHEN META_KEY = '_paid_date' THEN meta_value END) AS FECHA_COMPLETADA,
	MAX(CASE WHEN META_KEY = '_billing_phone' THEN meta_value END) AS TELEFONO,
	MAX(CASE WHEN META_KEY = '_shipping_address_1' THEN meta_value END) AS DIRECCION_1,
	MAX(CASE WHEN META_KEY = '_shipping_address_2' THEN meta_value END) AS DIRECCION_2,
	MAX(CASE WHEN META_KEY = '_billing_address_1' THEN meta_value END) AS DIRECCION_1F,
	MAX(CASE WHEN META_KEY = '_billing_address_2' THEN meta_value END) AS DIRECCION_2F,
	MAX(CASE WHEN META_KEY = '_billing_email' THEN meta_value END) AS EMAIL,
	MAX(CASE WHEN META_KEY = '_payment_method_title' THEN meta_value END) AS METODO_PAGO,
	MAX(CASE WHEN META_KEY = '_order_tax' THEN meta_value END) AS IVA,
	MAX(CASE WHEN META_KEY = '_order_total' THEN meta_value END) AS TOTAL,
	MAX(CASE WHEN META_KEY = '_p2p_status' THEN meta_value END) AS ESTADO,
	MAX(CASE WHEN META_KEY = '_wc_shipment_tracking_item' THEN meta_value END) AS TRANSPORTADORA,
	MAX(CASE WHEN META_KEY = 'guide_servientrega' THEN meta_value END) AS GUIA,
	MAX(CASE WHEN META_KEY = '_billing_company' THEN meta_value END) AS EMPRESA
	FROM  wp5s_postmeta  GROUP BY POST_ID) T 
	LEFT JOIN acycia_ventas V ON(T.ORDEN = V.ORDER_ID)
	WHERE T.FECHA_COMPLETADA LIKE  '%".$fecha."%' AND (T.METODO_PAGO = 'Transferencia bancaria directa' or T.METODO_PAGO = 'PlacetoPay')  AND V.ORDER_ID IS NULL";
	
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
		

		//envio
		$resultadoenvio = $conexion->query("select * from wp5s_woocommerce_order_items where  order_item_type  ='shipping' AND order_id =".$value["ORDEN"]);
		$productosenvio = getResultados($resultadoenvio);
		foreach($productosenvio as $key1 => $valuenvio)
		{
			$resultado2 = $conexion->query("select * from wp5s_woocommerce_order_itemmeta  where order_item_id=".$valuenvio["order_item_id"]);
			$detalle = getResultados($resultado2);

			$esenvio = $valuenvio["order_item_name"];

			   /*$exportacion[$key]["detalle"][] = array(
			   	"envio" => $valuenvio["order_item_name"],
			   );*/

			}
		    //fin envio

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
					"envio" => $esenvio,
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
			$fechaCumplimiento = date("Y-m-d",strtotime($fecha."+ 3 days")); 

			$cedulanit = explode('-', $cliente['CEDULA']);
			$cedulanit = $cedulanit[0].$cedulanit[1];
			$cedulanit = str_replace(' ', '', $cedulanit);
			$cedulanit = str_replace('.', '', $cedulanit);
			$cedulanit = str_replace("'", '', $cedulanit);

			//variables para clientes
			$nombresF = mb_strtoupper($cliente['NOMBRE'].' '.$cliente['APELLIDO'], 'UTF-8');
			$nombresF = str_replace("'", '', $nombresF);
			$nombresF = str_replace(".", '', $nombresF);
			$nombresE = mb_strtoupper($cliente['NOMBRE_E'].' '.$cliente['APELLIDO_E'], 'UTF-8');
			$nombresE = str_replace("'", '', $nombresE);
			$nombresE = str_replace(".", '', $nombresE);
			$nombresEnvio = empty($nombresE) ? $nombresF : $nombresE;

			$telefono = str_replace(' ', '', $cliente['TELEFONO']);

			if($cedulanit!='')
			{
				$query_cliente=$conexionpw->query("SELECT id_c FROM cliente WHERE nit_c = '".$cedulanit."' ORDER BY id_c ASC"); 
				$result_cliente = $query_cliente->fetch_row();
				$idcliente=$result_cliente[0];


				$cliente['EMPRESA'] = str_replace("'", " ", $cliente['EMPRESA']);
				$cliente['EMPRESA'] = str_replace(".", " ", $cliente['EMPRESA']);  
				$razon_social = empty($cliente['EMPRESA']) ? $nombresEnvio : $cliente['EMPRESA'];

				$razon_social = mb_strtoupper($razon_social, 'UTF-8');
				$razon_social =  ($razon_social);


				$guia = empty($cliente['GUIA']) ? 'Sin Guia' : 'SERVIENTREGA: '.$cliente['GUIA'];

				$paises =  $cliente['PAIS'] ='CO' ? 'COLOMBIA' : $cliente['PAIS'];


				$dirFacturacion = ($cliente['DIRECCION_1F'].' '.$cliente['DIRECCION_2F'].' '.$cliente['CIUDADF']);
				$dirAdicional = ($cliente['DIRECCION_1'].' '.$cliente['DIRECCION_2'].' '.$cliente['CIUDAD']);
				$dirEnvio = empty($dirAdicional) ? $dirFacturacion : $dirAdicional ;

				$emaill = ($cliente['EMAIL']);
			    //fin clientes

				if($idcliente == '' )
				{


            	//insert en la tabla de clientes
					 
					$insertSQL = "INSERT INTO cliente (nit_c,nombre_c,tipo_c,fecha_ingreso_c,fecha_solicitud_c,rep_legal_c,telefono_c,pais_c,ciudad_c,direccion_c,contacto_c,telefono_contacto_c,celular_contacto_c,email_comercial_c,direccion_envio_factura_c,telefono_envio_factura_c,forma_pago_c,observ_inf_c,estado_c,registrado_c) VALUES ('".$cedulanit."','".$razon_social."','NACIONAL', '".$fecha."', '".$fecha."', '".$nombresEnvio."','/".$telefono."/','".$paises."','".$cliente['CIUDADF']."','".$cliente['DIRECCION_1'].' '.$cliente['DIRECCION_2']."', '".$nombresF."', '/".$telefono."/','".$telefono."','".$emaill."','".$cliente['DIRECCION_1F'].' '.$cliente['DIRECCION_2F']."','/".$telefono."/','".$cliente['METODO_PAGO']."','".$guia."','ACTIVO','PW');";   
					$conexionpw->query($insertSQL);

            		//recupero id_c de clientes
					$query_cliente = $conexionpw->query("SELECT MAX(id_c) FROM cliente WHERE nit_c = '".$cedulanit."' ");
					$result_cliente = $query_cliente->fetch_row(); 
					$idcliente=$result_cliente[0];

				}else{
					//ACTUALIZA EL CLIENTE
                     /*
					$dir = $cliente['DIRECCION_1'].' '.$cliente['DIRECCION_2'] ;
					$ciud = $cliente['CIUDADF']; 

					$sqlUpcliente ="UPDATE cliente SET ciudad_c = '$ciud', direccion_c = '$dir', telefono_contacto_c = '/$telefono/', celular_contacto_c = '/$telefono/',  observ_inf_c = '$guia', observ_doc_c = 'Modifico: Pagina web el $fecha', fecha_revision_c = '$fecha', revisado_c='Pagina web' WHERE id_c='".$idcliente."'; "; 
					$resultUpcliente =  $conexionpw->query($sqlUpcliente);  

					if($resultUpcliente){
						logs('Se actualiza: '.$cedulanit);
					}*/

				}
 

                //insert en la tabla de orden de compra

				$codigo_orden = $cliente['METODO_PAGO']=='Transferencia bancaria directa' ? 'TB' : 'PW';

                //if($guia!='Recogida local'){
				$obser_guia =  'NOMBRES: '.$nombresEnvio.', RAZON SOCIAL: '.$razon_social.', DIRECCION ENVIO: '.$dirEnvio.', DEPART: '. $cliente['DEPARTAMENTO'].', CORREO: '. $emaill.', TELEFONO: '.$telefono.', '.$cliente['GUIA'] ;
                /*}else{
                	$obser_guia=$guia;
                }*/

                
                /*$obser_guia = empty($guia) ? 'NOMBRE: '.$nombresEnvio.', RAZON SOCIAL: '.$razon_social.', DIRECCION FACTURA: '.$cliente['DIRECCION_1F'].' '.$cliente['DIRECCION_2F'].', CIUDAD FAC: '.$cliente['CIUDADF'].', DIRECCION ENVIO: '.$cliente['DIRECCION_1'].' '.$cliente['DIRECCION_2'].', CIUDAD ENVIO: '.$cliente['CIUDAD']. ', DEPART: '. $cliente['DEPARTAMENTO'].', CORREO: '. $emaill.', TELEFONO: '.$telefono : $guia;*/

                $obser_guia =  ($obser_guia);
                
                $insertSQL2 = "INSERT INTO tbl_orden_compra (str_numero_oc,id_c_oc,str_nit_oc,fecha_ingreso_oc,str_condicion_pago_oc,str_observacion_oc,int_total_oc,str_dir_entrega_oc, str_archivo_oc,  str_elaboro_oc,str_aprobo_oc,b_estado_oc,str_responsable_oc,b_borrado_oc,b_facturas_oc,vta_web_oc, entrega_fac, fecha_cierre_fac, comprobante_ent,pago_pendiente) VALUES ('".$cliente['ORDEN'].$codigo_orden."','".$idcliente."','".$cedulanit."','".$fecha."','".$cliente['METODO_PAGO']."','".$obser_guia."','".$cliente['TOTAL']."','".$dirFacturacion."', 'factura-".$cliente['ORDEN'].".pdf', 'PW','PW','1','PW', '0','1','1','SI','".$fecha."','NO','NO')"; 
                $conexionpw->query($insertSQL2);

                $query_pedido = $conexionpw->query("SELECT MAX(id_pedido) FROM tbl_orden_compra WHERE str_numero_oc= '".$cliente['ORDEN'].$codigo_orden."' ");
                $result_pedido = $query_pedido->fetch_row(); 
                $idpedido=$result_pedido[0];


                //INSERT ID COTIZ
                $cons_cotiz = $conexionpw->query("SELECT MAX(n_cotizacion+1) FROM Tbl_cotiza_bolsa  ");
                $cotiz_id = $cons_cotiz->fetch_row(); 



                if($cliente['ORDEN']!='')
                {
	        	       //insert en la tabla de remisiones
	        	      /*$resultado5 = $conexionpw->query("SELECT MAX(int_remision+1) FROM tbl_remisiones  ");
	        	      $remision_id = $resultado5->fetch_row(); 

	        	      
	        	      $insertSQL4 = "INSERT INTO tbl_remisiones (ciudad_pais,int_remision,str_numero_oc_r,fecha_r,str_observacion_r) VALUES ('COLOMBIA', ".$remision_id[0].",'".$cliente['ORDEN'].$codigo_orden."','".$fecha."','VENDIDO DESDE PW')";    
	        	      $conexionpw->query($insertSQL4);*/

                $contador = 0;//consecutivo de items en oc

                foreach ($cliente['detalle'] as $key => $itemsoc) 
                {
                	
                    $unidades = 100;
                    

                    $sku_ref = explode("-", $itemsoc['sku']);//quito version si es ref normal
                    $sku_ref = $sku_ref[0];
                    
                    switch ($sku_ref) {
                    	case '1130':
                    		$unidades = 50;
                    		break;
                    	case '735':
                    		$unidades = 3000;
                    		break;
                    	case 'PWC059':
                    		$unidades = 200;//producto combo
                    		break;
                    	case 'PWC688':
                    		$unidades = 200;//producto combo
                    		break;
                    	case 'PWC686':
                    		$unidades = 400;//producto combo
                    		break;
                    	case 'PWC685':
                    		$unidades = 500;//producto combo
                    		break;
                    	case 'PWCA02':
                    		$unidades = 2;//producto combo
                    		break;
                    	case 'PWCA06':
                    		$unidades = 6;//producto combo
                    		break;
                    	case 'PWST01':
                    		$unidades = 1;//producto combo
                    		break;
                    	case 'PWPB01':
                    		$unidades = 1;//producto combo
                    		break;
                    	
                    	default:
                    		$unidades = 100;
                    		break;
                    }

                    //$unidades = medidas($itemsoc['sku']);
             
                    $sku_ref = explode("-", $itemsoc['sku']);//quito version
                    
                    /*$sku_refPWC = str_split($itemsoc['sku'], 3);//si es pwc
                    $sku_ref = $sku_refPWC[0] == "PWC" ? $sku_refPWC[1] : $sku_ref[0];//ya q el # ref va en posicion 1*/
                    
                    $sku_ref = $sku_ref[0];

                	$cantidadItem = ($itemsoc['cantidad'] * $unidades);
                	$contador += 1;

                	$valorunidad = ($itemsoc['valor_total'] / $cantidadItem);


                	if($itemsoc['envio']=='Recogida local'){
                		$tipoenvio = $itemsoc['envio'];
                	}else{
                		$tipoenvio = $dirEnvio;
                	}

				 	  //insert en la tabla de items orden compra
                	$insertSQL3 = "INSERT INTO tbl_items_ordenc (id_pedido_io,str_numero_io,int_consecutivo_io,int_cod_ref_io,int_cantidad_io,int_cantidad_rest_io,str_unidad_io,fecha_entrega_io,fecha_modif_io,responsable_modif_io,int_precio_io,int_total_item_io,str_moneda_io, str_direccion_desp_io,int_vendedor_io,b_estado_io) VALUES (".$idpedido.",'".$cliente['ORDEN'].$codigo_orden."',".$contador.", '".$sku_ref."','".$cantidadItem."','".$cantidadItem."','UNIDAD','".$fechaCumplimiento."','".$fecha."', 'PW', '".$valorunidad."', '".$itemsoc['valor_total']."','COL$','".$tipoenvio."','10', '0')";    
                	$conexionpw->query($insertSQL3);

				 	  //insert en la tabla de remision detalle
                      /*$insertSQL6 = "INSERT INTO tbl_remision_detalle (int_remision_r_rd,str_numero_oc_rd,fecha_rd,int_ref_io_rd,estado_rd) VALUES (".$remision_id[0].",'".$cliente['ORDEN'].$codigo_orden."','".$fecha."','".$itemsoc['sku']."','1')";    
                      $conexionpw->query($insertSQL6);*/


                      //GUARDO COTIZACION
                      if($cotiz_id[0]){
                      	//INFO DE REF
                      	$query_ref = $conexionpw->query("SELECT ancho_ref,largo_ref,solapa_ref,n_fuelle,calibre_ref,bolsillo_guia_ref FROM Tbl_referencia WHERE cod_ref='".$sku_ref."' ");
                      	$result_ref = $query_ref->fetch_row();

                      	$insertCotizmaster = "INSERT INTO  tbl_cotizaciones(N_cotizacion, Str_nit, Str_tipo, fecha) VALUES('".$cotiz_id[0]."','".$cedulanit."','BOLSA', '".$fecha."' )";    
                      	$conexionpw->query($insertCotizmaster); 

                      	$insertCotizrel = "INSERT INTO tbl_cliente_referencia(N_referencia, N_cotizacion, Str_nit) VALUES('".$sku_ref."','".$cotiz_id[0]."','".$cedulanit."' )";    
                      	$conexionpw->query($insertCotizrel); 

                      	$insertCotiz = "INSERT INTO Tbl_cotiza_bolsa(N_cotizacion, N_referencia_c, Str_nit, Str_moneda, N_precio, Str_unidad_vta, N_cant_impresion, fecha_creacion, Str_usuario, B_estado,B_generica,N_ancho,N_alto,N_solapa,B_fuelle,N_calibre,N_tamano_bolsillo) VALUES (".$cotiz_id[0].",'".$sku_ref."', '".$cedulanit."', 'COL$', '".$valorunidad."','PRECIO UNITARIO','".$cantidadItem."','".$fecha."', '65', '1', '1','".$result_ref[0]."','".$result_ref[1]."','".$result_ref[2]."','".$result_ref[3]."','".$result_ref[4]."','".$result_ref[5]."')";    
                      	$conexionpw->query($insertCotiz); 




                      }



                  } 
              }
				  //exit($insertCotizrel);        

          }
	//insert tabla de control
          $fechaVenta =  $cliente['FECHA_COMPLETADA'] =='' ? date('Y-m-d H:i:s') : $cliente['FECHA_COMPLETADA'];
          $insert = "INSERT INTO acycia_ventas (ORDER_ID, FECHA, FECHA_INSERT) VALUES('".$cliente['ORDEN']."', '".date('Y-m-d')."', '".$fechaVenta."')";
          $conexion->query($insert);

          logs($cliente['ORDEN']);
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


  function medidas($ref){
 
   $sku_ref = explode("-", $ref);//quito version si es ref normal
   $sku_ref = $sku_ref[0];
   
   switch ($sku_ref) {
   	case '1130':
   		$unidades = 50;
   		break;
   	case '735':
   		$unidades = 3000;
   		break;
   	case 'PWC059':
   		$unidades = 200;//producto combo
   		break;
   	case 'PWC688':
   		$unidades = 200;//producto combo
   		break;
   	case 'PWC686':
   		$unidades = 400;//producto combo
   		break;
   	case 'PWC685':
   		$unidades = 500;//producto combo
   		break;
   	case 'PWCA02':
   		$unidades = 2;//producto combo
   		break;
   	case 'PWCA06':
   		$unidades = 6;//producto combo
   		break;
   	case 'PWST01':
   		$unidades = 1;//producto combo
   		break;
   	case 'PWPB01':
   		$unidades = 1;//producto combo
   		break;
   	
   	default:
   		$unidades = 100;
   		break;
   }
 
  	
   return $unidades;
  }

  function logs($msg)
  {
  	echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
  }

  
  getVentasbyDay();

  ?>