<?php
require_once('../../envio_correo/envio_correos.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);

?> 
<?php
//mysql_select_db($database_conexion1, $conexion1);

$conexion = new ApptivaDB();

//guardado de remision interna Maestro
//,$_POST['cliente'],$_POST['entrada'],$_POST['documento'],$_POST['contacto'],$_POST['direccion'],$_POST['elabora'],$_POST['recibe'],$_POST['observacion']) && $_POST['id_remision']!=''&& $_POST['entrada']!=''&& $_POST['cliente']!=''&& $_POST['fecha']!=''&& $_POST['telefono']!=''&& $_POST['direccion']!=''

if (isset($_POST['id_remision'], $_POST['cliente'], $_POST['entrada'], $_POST['documento'], $_POST['contacto']) && $_POST['id_remision'] != '' && $_POST['cliente'] != '' && $_POST['entrada'] != '' && $_POST['documento'] != '' && $_POST['contacto'] != '') {

   $existe = $conexion->buscarTres('tbl_remision_interna', "id_remision", "  WHERE id_remision= '" . $_POST['id_remision'] . "' ", "");
   
   if ($existe['id_remision'] == '') {

      if (isset($_POST['correo'])) { //guardado de remision interna Maestro de producto terminado
         $resulrt = $conexion->insertar("tbl_remision_interna", "id_remision, entrada, cliente, fecha, telefono, direccion, elabora, recibe,celular,fecha_salida,contacto,documento,pais,observacion, correo", " '" . $_POST['id_remision'] . "','" . $_POST['entrada'] . "','" . $_POST['cliente'] . "','" . $_POST['fecha'] . "','" . $_POST['telefono'] . "','" . $_POST['direccion'] . "','" . $_POST['elabora'] . "','" . $_POST['recibe'] . "','" . $_POST['celular'] . "','" . $_POST['fecha_salida'] . "','" . $_POST['contacto'] . "','" . $_POST['documento'] . "','" . $_POST['pais'] . "','" . $_POST['observacion'] .  "','" . $_POST['correo'] . "' ");
         if ($resulrt) { //guardado de los ITEMS remision interna Maestro de producto terminado
            $result = guardarItemsProductoTerminado($conexion);
            echo $result;
            if($result == '1'){
               enviarEmail();
            }
         }
      } else {

         $resulrt = $conexion->insertar("tbl_remision_interna", "id_remision, entrada, cliente, fecha, telefono, direccion, elabora, recibe,celular,fecha_salida,contacto,documento,pais,observacion", " '" . $_POST['id_remision'] . "','" . $_POST['entrada'] . "','" . $_POST['cliente'] . "','" . $_POST['fecha'] . "','" . $_POST['telefono'] . "','" . $_POST['direccion'] . "','" . $_POST['elabora'] . "','" . $_POST['recibe'] . "','" . $_POST['celular'] . "','" . $_POST['fecha_salida'] . "','" . $_POST['contacto'] . "','" . $_POST['documento'] . "','" . $_POST['pais'] . "','" . $_POST['observacion'] . "' ");
      }
   } else {

      if (isset($_POST['correo'])) {
         $resulUP = $conexion->actualizar("tbl_remision_interna", " entrada = '" . $_POST['entrada'] . "', cliente = '" . $_POST['cliente'] . "',fecha = '" . $_POST['fecha'] . "',telefono = '" . $_POST['telefono'] . "',direccion = '" . $_POST['direccion'] . "',elabora = '" . $_POST['elabora'] . "',recibe = '" . $_POST['recibe'] . "',celular = '" . $_POST['celular'] . "',contacto = '" . $_POST['contacto'] . "',documento = '" . $_POST['documento'] . "',pais = '" . $_POST['pais'] . "', observacion='" . $_POST['observacion'] . "' , correo= '" . $_POST['correo'] . "'", " id_remision=" . $_POST['id_remision']);
         echo guardarItemsProductoTerminado($conexion);
      } else {
         echo $resulUP = $conexion->actualizar("tbl_remision_interna", " entrada = '" . $_POST['entrada'] . "', cliente = '" . $_POST['cliente'] . "',fecha = '" . $_POST['fecha'] . "',telefono = '" . $_POST['telefono'] . "',direccion = '" . $_POST['direccion'] . "',elabora = '" . $_POST['elabora'] . "',recibe = '" . $_POST['recibe'] . "',celular = '" . $_POST['celular'] . "',fecha_salida = '" . $_POST['fecha_salida'] . "',contacto = '" . $_POST['contacto'] . "',documento = '" . $_POST['documento'] . "',pais = '" . $_POST['pais'] . "', observacion='" . $_POST['observacion'] . "' ", " id_remision=" . $_POST['id_remision'] . " ");
      }
   }
}

function guardarItemsProductoTerminado($conexionDB)
{
   $referencia = $_POST['referencia'];
   $cantidad = $_POST['cantidad'];
   $numInicio = $_POST['numInicio'];
   $numFinal = $_POST['numFinal'];
   $caja = $_POST['caja'];
   $oc = $_POST['oc'];
   for ($i = 0; $i < sizeof($referencia); $i++) {
      if ($referencia[$i] != '') { //Filtro para no guardar las filas vacias
         $resultItems = $conexionDB->insertar("tbl_items_remision_interna", "remision_id, ref_ac, cantidad,  numInicio, numFinal, caja, oc", " '" . $_POST['remision_id'] . "','" . $referencia[$i] . "','" . $cantidad[$i] . "','" . $numInicio[$i] . "','" . $numFinal[$i] . "', '" . $caja[$i] . "', '" . $oc[$i] . "' ");
      }
   }
   return $resultItems;
}
//fin


//guardado de remision interna Item

if (isset($_POST['remision_id']) && $_POST['remision_id'] != '') {

   if (isset($_POST['referencia']) && $_POST['referencia'] != '') {
      $referencia = $_POST['referencia'];
      $cantidad = $_POST['cantidad'];
      $numInicio = $_POST['numInicio'];
      $numFinal = $_POST['numFinal'];
      $caja = $_POST['caja'];
      $oc = $_POST['oc'];
   } else {
      $insumo = $_POST['insumo'];
      $cantidad = $_POST['cantidad'] == '' ? 0 : $_POST['cantidad'];
      $peso = $_POST['peso'] == '' ? 0 : $_POST['peso'];
      $precio = $_POST['precio'] == '' ? 0 : $_POST['precio'];
      $medida = $_POST['medida'] == '' ? 0 : $_POST['medida'];

      for ($a = 0, $b = 0, $c = 0, $d = 0, $e = 0; $a < count($insumo); $a++, $b++, $c++, $d++, $e++) {
         if ((isset($insumo[$a])) && (!(empty($insumo[$a])))) //items bodegas vacias
         {
            $resulrt = $conexion->insertar("tbl_items_remision_interna", "remision_id, insumo, peso, precio, cantidad, medida", " '" . $_POST['remision_id'] . "','" . $insumo[$a] . "','" . $peso[$b] . "','" . $precio[$c] . "','" . $cantidad[$d] . "', '" . $medida[$e] . "' ");
         }
      }

      //Muestra grid Items
      $Item = $conexion->buscarList("tbl_items_remision_interna", "remision_id", $_POST['remision_id']);
      //$Item esto es Array
      if ($Item) {
         echo json_encode($Item);
         exit();
      } else {
         echo 0;
         exit();
      }
   }
}
//fin guardado de remision interna
//
//
//
//GUARDA TODOS LOS PAQUETES X CAJA
if (isset($_POST['int_paquete_tn'], $_POST['int_caja_tn'], $_POST['fecha_ingreso_tn'], $_POST['int_op_tn'], $_POST['int_bolsas_tn'], $_POST['int_undxcaja_tn'], $_POST['int_undxpaq_tn'], $_POST['int_desde_tn'], $_POST['int_hasta_tn']) && $_POST['int_paquete_tn'] != '' && $_POST['int_caja_tn'] != '' && $_POST['fecha_ingreso_tn'] != '' && $_POST['int_op_tn'] != '' && $_POST['int_bolsas_tn'] != '' && $_POST['int_undxcaja_tn'] != '' && $_POST['int_undxpaq_tn'] != '' && $_POST['int_desde_tn'] != '' && $_POST['int_hasta_tn'] != '') {

   $row_control_paquete = $conexion->buscarTres('tbl_tiquete_numeracion', "id_tn", "  WHERE int_op_tn= '" . $_POST['int_op_tn'] . "'  AND int_caja_tn='" . $_POST['int_caja_tn'] . "' AND  int_paquete_tn= '" . $_POST['int_paquete_tn'] . "'", "");

   if ($row_control_paquete['id_tn'] == '') {

      $resulrt = $conexion->insertar("tbl_tiquete_numeracion", "int_op_tn, fecha_ingreso_tn, hora_tn, int_bolsas_tn, int_undxpaq_tn, int_undxcaja_tn,  int_desde_tn, int_hasta_tn, int_cod_empleado_tn, int_cod_rev_tn, contador_tn, int_paquete_tn, int_caja_tn, pesot, ref_tn, imprime ", " '" . $_POST['int_op_tn'] . "','" . $_POST['fecha_ingreso_tn'] . "','" . $_POST['hora_tn'] . "','" . $_POST['int_bolsas_tn'] . "','" . $_POST['int_undxpaq_tn'] . "','" . $_POST['int_undxcaja_tn'] . "','" . $_POST['int_desde_tn'] . "','" . $_POST['int_hasta_tn'] . "','" . $_POST['int_cod_empleado_tn'] . "','" . $_POST['int_cod_rev_tn'] . "','" . $_POST['contador_tn'] . "','" . $_POST['int_paquete_tn'] . "','" . $_POST['int_caja_tn'] . "','" . $_POST['pesot'] . "','" . $_POST['cod_ref_n'] . "','1' ");
   }
   /*else{
     $Updateresult= $conexion->actualizar("tbl_tiquete_numeracion", " int_op_tn='".$_POST['int_op_tn']."',fecha_ingreso_tn='".$_POST['fecha_ingreso_tn']."',hora_tn='".$_POST['hora_tn']."',int_bolsas_tn='".$_POST['int_bolsas_tn']."',int_undxpaq_tn='".$_POST['int_undxpaq_tn']."',int_undxcaja_tn='".$_POST['int_undxcaja_tn']."',int_desde_tn='".$_POST['int_desde_tn']."',int_hasta_tn='".$_POST['int_hasta_tn']."',int_cod_empleado_tn='".$_POST['int_cod_empleado_tn']."',int_cod_rev_tn='".$_POST['int_cod_rev_tn']."',contador_tn='".$_POST['contador_tn']."',int_paquete_tn='".$_POST['int_paquete_tn']."',int_caja_tn='".$_POST['int_caja_tn']."',pesot='".$_POST['pesot']."',ref_tn='".$_POST['cod_ref_n']."' ", " id_tn=".$row_control_paquete['id_tn']." " );
  }*/


   $resulUP = $conexion->actualizar("tbl_numeracion", " cod_ref_n = '" . $_POST['cod_ref_n'] . "', int_bolsas_n = '" . $_POST['int_bolsas_tn'] . "',int_undxpaq_n = '" . $_POST['int_undxpaq_tn'] . "',int_undxcaja_n = '" . $_POST['int_undxcaja_tn'] . "',int_desde_n = '" . $_POST['int_desde_tn'] . "',int_hasta_n = '" . $_POST['int_hasta_tn'] . "',int_cod_empleado_n = '" . $_POST['int_cod_empleado_tn'] . "',int_cod_rev_n = '" . $_POST['int_cod_rev_tn'] . "',int_paquete_n = '" . $_POST['int_paquete_tn'] . "',int_caja_n = '" . $_POST['int_caja_tn'] . "' ", " int_op_n=" . $_POST['int_op_tn'] . " ");


   if ($resulrt) {
      echo $resulrt;
   } else {
      echo 0;
   }
}



//guardado bodegas de Clientes

if (isset($_POST['id_d'], $_POST['nit'], $_POST['nombre_responsable'], $_POST['direccion'], $_POST['indicativo'], $_POST['telefono'], $_POST['extension']) && $_POST['id_d'] != '' && $_POST['nit'] != '' && $_POST['nombre_responsable'] != '' && $_POST['direccion'] != '' && $_POST['indicativo'] != '' && $_POST['telefono'] != '' && $_POST['extension'] != '' && $_POST['ciudad'] != '') {

   $resulrt = $conexion->insertar("tbl_destinatarios", "id_d, nit, nombre_responsable, direccion, indicativo, telefono, extension, ciudad ", " '" . $_POST['id_d'] . "','" . $_POST['nit'] . "','" . $_POST['nombre_responsable'] . "','" . $_POST['direccion'] . "','" . $_POST['indicativo'] . "','" . $_POST['telefono'] . "','" . $_POST['extension'] . "','" . $_POST['ciudad'] . "' ");

   //Muestra grid Items
   $Item = $conexion->buscarList("tbl_destinatarios", "id_d", $_POST['id_d']);
   //$Item esto es Array
   if ($Item) {
      echo json_encode($Item);
      exit();
   } else {
      echo 0;
      exit();
   }
}



//guardado de items de cireles

if (isset($_POST['verificacion']) && $_POST['verificacion'] == 'verificacion') {
   $directorio = "pdfcyreles/";
   $tieneadjunto = adjuntarArchivoG('', $directorio, $_FILES['adjunto']['name'], $_FILES['adjunto']['tmp_name'], 'NUEVOS');
   $resulrt = $conexion->insertar("tblreporteplanchas", "id_verif,ref,cliente,color1,motivo,color2,motivo2,color3,motivo3,color4,motivo4,fecha_reporte,se_hizo_repo,fecha_repo,responsable,adjunto,obs", " '" . $_POST['id_verif_p'] . "', '" . $_POST['ref'] . "','" . $_POST['cliente'] . "','" . $_POST['color1'] . "','" . $_POST['motivo'] . "','" . $_POST['color2'] . "','" . $_POST['motivo2'] . "','" . $_POST['color3'] . "','" . $_POST['motivo3'] . "','" . $_POST['color4'] . "','" . $_POST['motivo4'] . "','" . $_POST['fecha_reporte'] . "','" . $_POST['se_hizo_repo'] . "','" . $_POST['fecha_repo'] . "','" . $_POST['responsable'] . "','" . $tieneadjunto . "','" . $_POST['obs'] . "'  ");

   //Muestra grid Items
   $Item = $conexion->buscarList("tblreporteplanchas", "ref", $_POST['ref']);
   //$Item esto es Array
   if ($Item) {
      echo json_encode($Item);
      exit();
   } else {
      echo 0;
      exit();
   }
}




//guardado de Remision al darle Imprimir
if (isset($_POST['remisionar']) && $_POST['remisionar'] == 'remisionar') {

   $resulrt = $conexion->insertar("Tbl_remisiones", "int_remision,str_numero_oc_r,fecha_r,str_encargado_r,str_transportador_r,str_guia_r,str_elaboro_r,str_aprobo_r,str_observacion_r,factura_r,b_borrado_r,ciudad_pais ", " '" . $_POST['int_remision'] . "', '" . $_POST['str_numero_oc_r'] . "','" . $_POST['fecha_r'] . "','" . $_POST['str_encargado_r'] . "','" . $_POST['str_transportador_r'] . "','" . $_POST['str_guia_r'] . "','" . $_POST['str_elaboro_r'] . "','" . $_POST['str_aprobo_r'] . "','" . $_POST['str_observacion_r'] . "','" . $_POST['factura_r'] . "','" . $_POST['b_borrado_r'] . "', '" . $_POST['ciudad_pais'] . "'  ");
   $fecha = date("Y-m-d h:m:s");
   $resulrthist = $conexion->insertar("tbl_remisiones_historico", "int_remision,str_numero_oc_r,fecha_r,str_encargado_r,str_transportador_r,str_guia_r,str_elaboro_r,str_aprobo_r,str_observacion_r,factura_r,b_borrado_r,ciudad_pais,modifico ", " '" . $_POST['int_remision'] . "', '" . $_POST['str_numero_oc_r'] . "','" . $_POST['fecha_r'] . "','" . $_POST['str_encargado_r'] . "','" . $_POST['str_transportador_r'] . "','" . $_POST['str_guia_r'] . "','" . $_POST['str_elaboro_r'] . "','" . $_POST['str_aprobo_r'] . "','" . $_POST['str_observacion_r'] . "','" . $_POST['factura_r'] . "','" . $_POST['b_borrado_r'] . "', '" . $_POST['ciudad_pais'] . "', '" . $_SESSION['Usuario'] . $fecha . "'  ");


   echo 1;
   exit();
}





//guardado de orden compra 



/*  if(isset($_POST['ordencompra']) && $_POST['ordencompra']=='ordencompra') { 


     $directorio = "pdfacturasoc/";
     $tieneadjunto1 = adjuntarArchivoG('', $directorio, $_FILES['str_archivo_oc']['name'],$_FILES['str_archivo_oc']['tmp_name'],'NUEVOS');
     $tieneadjunto2 = adjuntarArchivoG('', $directorio, $_FILES['adjunto2']['name'],$_FILES['adjunto2']['tmp_name'],'NUEVOS');
     $tieneadjunto3 = adjuntarArchivoG('', $directorio, $_FILES['adjunto3']['name'],$_FILES['adjunto3']['tmp_name'],'NUEVOS'); 


     $b_oc_interno=$_POST['b_oc_interno'];
     $cobra_flete=$_POST['cobra_flete'];

     $resulrt = $conexion->insertar("tbl_orden_compra","str_numero_oc, id_c_oc, str_nit_oc, fecha_ingreso_oc,fecha_entrega_oc, str_condicion_pago_oc, str_observacion_oc, int_total_oc, b_facturas_oc, b_num_remision_oc, b_factura_cirel_oc, str_dir_entrega_oc, str_archivo_oc, adjunto2, adjunto3, str_elaboro_oc, str_aprobo_oc, b_estado_oc, str_responsable_oc, b_borrado_oc, salida_oc, b_oc_interno,vta_web_oc,expo_oc,autorizado, entrega_fac, fecha_cierre_fac, comprobante_ent,pago_pendiente,cobra_flete,precio_flete,tipo_despacho "," '".$_POST['str_numero_oc']."', '".$_POST['id_c_oc']."','".$_POST['nit_c']."','".$_POST['fecha_ingreso_oc']."','".$_POST['fecha_entrega_oc']."','".$_POST['str_condicion_pago_oc']."','".$_POST['str_observacion_oc']."','".$_POST['int_total_oc']."','".$_POST['b_facturas_oc']."','".$_POST['b_num_remision_oc']."','".$_POST['b_factura_cirel_oc']."', '".$_POST['str_dir_entrega_oc']."','$tieneadjunto1','$tieneadjunto2','$tieneadjunto3','".$_POST['str_elaboro_oc']."','".$_POST['str_aprobo_oc']."','".$_POST['b_estado_oc']."','".$_POST['str_responsable_oc']."','".$_POST['b_borrado_oc']."','".$_POST['salida_oc']."','$b_oc_interno','".$_POST['vta_web_oc']."','".$_POST['expo_oc']."','".$_POST['autorizado']."','".$_POST['entrega_fac']."','".$_POST['fecha_cierre_fac']."','".$_POST['comprobante_ent']."','".$_POST['pago_pendiente']."','$cobra_flete','".$_POST['precio_flete']."','".$_POST['tipo_despacho']."'  "); 



     $fecha = date("Y-m-d h:m:s");
     $resulrthist = $conexion->insertar("tbl_orden_compra_historico","id_pedido,str_numero_oc,id_c_oc,str_nit_oc,fecha_ingreso_oc,fecha_entrega_oc,str_condicion_pago_oc,str_observacion_oc,int_total_oc,b_facturas_oc,b_num_remision_oc,b_factura_cirel_oc,str_dir_entrega_oc,str_archivo_oc,adjunto2,adjunto3,str_elaboro_oc,str_aprobo_oc,b_estado_oc,str_responsable_oc,b_borrado_oc,salida_oc,b_oc_interno,vta_web_oc,expo_oc,autorizado,tb_pago,factura_oc,entrega_fac,fecha_cierre_fac,comprobante_ent,estado_cartera,tipo_pago_cartera,valor_cartera,modifico "," '".$_POST['id_pedido']."', '".$_POST['str_numero_oc']."', '".$_POST['id_c_oc']."', '".$_POST['str_nit_oc']."', '".$_POST['fecha_ingreso_oc']."', '".$_POST['fecha_entrega_oc']."', '".$_POST['str_condicion_pago_oc']."', '".$_POST['str_observacion_oc']."', '".$_POST['int_total_oc']."', '".$_POST['b_facturas_oc']."', '".$_POST['b_num_remision_oc']."', '".$_POST['b_factura_cirel_oc']."', '".$_POST['str_dir_entrega_oc']."', '".$_POST['str_archivo_oc']."', '".$_POST['adjunto2']."', '".$_POST['adjunto3']."', '".$_POST['str_elaboro_oc']."', '".$_POST['str_aprobo_oc']."', '".$_POST['b_estado_oc']."', '".$_POST['str_responsable_oc']."', '".$_POST['b_borrado_oc']."', '".$_POST['salida_oc']."', '".$_POST['b_oc_interno']."', '".$_POST['vta_web_oc']."', '".$_POST['expo_oc']."', '".$_POST['autorizado']."', '".$_POST['tb_pago']."', '".$_POST['factura_oc']."', '".$_POST['entrega_fac']."', '".$_POST['fecha_cierre_fac']."', '".$_POST['comprobante_ent']."', '".$_POST['estado_cartera']."', '".$_POST['tipo_pago_cartera']."', '".$_POST['valor_cartera']."', '".$_SESSION['Usuario'].$fecha."'  ");
     echo 1;
     exit();


  }*/






function adjuntarArchivoG($tieneadjunto = '', $directorio, $nuevoadjunto, $tmp_name, $tipoejecutar)
{

   /*$tamano_archivo = $_FILES[$nuevoadjunto]['size'];//1048576 es una mega 
   $tipo_archivo = $_FILES[$nuevoadjunto]['type'];*/
   //if (!((strpos($tipo_archivo, "pdf")) && ($tamano_archivo < 10485770))) 


   if ($nuevoadjunto != "") {
      if ($tipoejecutar == 'UPDATES' || $tipoejecutar == 'NUEVOS') {

         //UPDATE DEL ARCHIVO ELN EL SERVIDOR 
         if ($tieneadjunto != "") {
            if (file_exists($directorio . $tieneadjunto)) {
               unlink($directorio . $tieneadjunto);
            }
         }

         $tieneadjunto2 = str_replace(' ', '', $nuevoadjunto);
         $archivo_temporal = $tmp_name;

         if (!copy($archivo_temporal, $directorio . $tieneadjunto2)) {
            $error = "Error al enviar el Archivo";
         } else {
            $tieneadjunto = $tieneadjunto2;
         }

         return $tieneadjunto;
      }
   } else {
      return $tieneadjunto;
   }
}

function enviarEmail() { 
   $referencia = $_POST['referencia'];
   $cantidad = $_POST['cantidad'];
   $numInicio = $_POST['numInicio'];
   $numFinal = $_POST['numFinal'];
   $caja = $_POST['caja'];
   $oc = $_POST['oc'];
    /* $num = self::elementosArray($insumos); */
    $envioCorreo = new EnvioEmails();
    //$to = $this->correo;
    $to = "lidersistemas@acycia.com";
    $to2 = 'andres85684@outlook.com';
    //$to2 = 'compras@acycia.com';
    //$from = ;
    $asunto = 'Informacion '.$_POST['entrada']." ".$_POST['cliente'];
    $body = $_POST['entrada']." N: ".$_POST['id_remision']."<br>"."la siguiente es la lista de los items que recibio " . $_POST['recibe'] . ":" . "<br>";
    for ($i = 0; $i < sizeof($referencia); $i++) {
        $body = $body . "Referencia: " . $referencia[$i] . ", Cantidad: " . $cantidad[$i] . ", Numeracion Inicio: ".$numInicio[$i]. ",Numeracion Final: ". $numFinal[$i] . ",Numero de caja: ". $caja[$i] . ", Orden de compra: ". $oc[$i]."<br>";
    };
    $body = $body . "<br>" . "OBSERVACIONES:" . "<br>" . $_POST['observacion'];


    $envioCorreo->enviar($to, $to2, '', '', $asunto, $body, '');
}
?>