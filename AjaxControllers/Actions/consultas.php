<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php

$conexion = new ApptivaDB();

if (isset($_POST['idinsumo']) && $_POST['idinsumo'] != '') {

  if ($resultado = $conexion->buscarList("insumo", "id_insumo", $_POST['idinsumo'])) {

    echo json_encode($resultado);
  }
  exit();
} else {
  echo '';
}

if (isset($_POST['remision_id']) && $_POST['tipo'] = 'prodTerminado' && $_POST['remision_id'] != '') {

  if ($resultado = $conexion->llenaListas("tbl_items_remision_interna tir ", "WHERE tir.remision_id=" . $_POST['remision_id'], "", "*")) {
    echo json_encode($resultado);
  }
  exit();
} else {
  echo '';
}

if (isset($_POST['remision_id']) && $_POST['remision_id'] != '') {

  if ($resultado = $conexion->llenaListas("tbl_items_remision_interna tir ", "WHERE tir.remision_id=" . $_POST['remision_id'], "", "tir.id,tir.remision_id,tir.insumo, tir.peso,tir.precio,tir.cantidad,tir.medida ")) {
    echo json_encode($resultado);
  }
  exit();
} else {
  echo '';
}


/*  if(isset($_POST['remision_id'])&& $_POST['remision_id'] !=''){
   
    if($resultado=$conexion->llenaListas("tbl_items_remision_interna tir,insumo ins","WHERE tir.insumo=ins.id_insumo and tir.remision_id=".$_POST['remision_id'],"","tir.id,tir.ref_ac,tir.tipo, tir.peso,tir.precio,tir.cantidad,tir.remision_id, ins.descripcion_insumo as insumo")){  
      echo json_encode( $resultado); 
    } 
    exit();
  }else{
      echo '';
  }*/


//CONSULTA ITEMS AL RECARGAR PAGINA PLANCHAS 
if (isset($_POST['refplanchas']) && $_POST['refplanchas'] != '') {

  if ($resultado = $conexion->llenaListas("tblreporteplanchas ", "WHERE ref=" . $_POST['refplanchas'], " ", " * ")) {

    echo json_encode($resultado);
  }
  exit();
} else {
  echo '';
}
/*  if(isset($_POST['ref_porcent'])&& $_POST['ref_porcent'] !=''){
    
    if($resultado=$conexion->llenarCampos("tbl_reg_desperdicio desp ","WHERE desp.id_proceso_rd='4' AND desp.cod_ref_rd =".$_POST['ref_porcent'],""," AVG(desp.valor_desp_rd) as totalporc " )){
     
      echo json_encode( $resultado); 
    } 
    exit();
  }else{
      echo '';
  }*/

if (isset($_POST['ref_porcent']) && $_POST['ref_porcent'] != '') {

  //desperdicio


  $refD = $_POST['ref_porcent'] == 0 ? "" : " cod_ref_rd = '" . $_POST['ref_porcent'] . "' AND ";

  $suma_desp = $conexion->llenarCampos('tbl_reg_desperdicio', " WHERE $refD id_proceso_rd='4'  AND DATE_SUB(NOW(),INTERVAL 1 YEAR)", " ORDER BY fecha_rd DESC ", " SUM(valor_desp_rd) AS kilosdesp");



  $row_porcentajeDespExtr = $conexion->llenarCampos('tbl_reg_produccion', " WHERE int_cod_ref_rp='" . $_POST['ref_porcent'] . "' AND id_proceso_rp='1' AND DATE_SUB(NOW(),INTERVAL 1 YEAR)", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, SUM(int_kilos_desp_rp) as kilosdesp,   ROUND((sum(int_kilos_desp_rp) * 100 / SUM(int_kilos_prod_rp)),2) as result");

  //Consulto porcentaje desperdicio Impresion
  $row_porcentajeDespImp = $conexion->llenarCampos('tbl_reg_produccion', " WHERE int_cod_ref_rp='" . $_POST['ref_porcent'] . "' AND id_proceso_rp='2' AND DATE_SUB(NOW(),INTERVAL 1 YEAR)", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, SUM(int_kilos_desp_rp) as kilosdesp,   ROUND((sum(int_kilos_desp_rp) * 100 / SUM(int_kilos_prod_rp)),2) as result");

  //Consulto porcentaje desperdicio Sellado
  $row_porcentajeDespSell = $conexion->llenarCampos('tbl_reg_produccion', " WHERE int_cod_ref_rp='" . $_POST['ref_porcent'] . "' AND id_proceso_rp='4' AND DATE_SUB(NOW(),INTERVAL 1 YEAR)", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, ('" . $suma_desp['kilosdesp'] . "') as kilosdesp, ROUND((('" . $suma_desp['kilosdesp'] . "'+ sum(kiloFaltante_rp) ) * 100 / SUM(int_kilos_prod_rp)),2) as result");

  $extruder = $row_porcentajeDespExtr['result'] == '' ? 0 : $row_porcentajeDespExtr['result'];
  $impresion = $row_porcentajeDespImp['result'] == '' ? 0 : $row_porcentajeDespImp['result'];
  $sellado = $row_porcentajeDespSell['result'] == '' ? 0 : $row_porcentajeDespSell['result'];

  $total = (($extruder + $impresion + $sellado));
  $array = array(
    "total" => $total,
    "extruder" => $extruder,
    "impresion" => $impresion,
    "sellado" => $sellado
  );
  if ($array != '') {

    echo json_encode($array);
  }
  exit();
} else {
  echo '';
}




if ((isset($_POST['meslis']) && $_POST['meslis'] != '0') || isset($_POST['anyolis'])  || (isset($_POST['ref']) && $_POST['ref'] != '0') || (isset($_POST['ops']) && $_POST['ops'] != '0') || (isset($_POST['cliente']) && $_POST['cliente'] != '0')) {

  $ops = $_POST['ops'] == 0 ? "" : " id_op_rp='" . $_POST['ops'] . "' AND ";

  $ref = $_POST['ref'] == 0 ? "" : " int_cod_ref_rp = '" . $_POST['ref'] . "' AND ";

  $anyo = $_POST['anyolis'] == 0 ? "" : " YEAR(fecha_ini_rp)='" . $_POST['anyolis'] . "' AND ";

  $mes = $_POST['meslis'] == 0 ? "" : " MONTH(fecha_ini_rp)='" . $_POST['meslis'] . "' AND ";

  $cliente = $_POST['cliente'] == 0 ? "0" : " tbl_orden_produccion.int_cliente_op='" . $_POST['cliente'] . "' AND tbl_orden_produccion.id_op=tbl_reg_produccion.id_op_rp AND ";

  //desperdicio
  $opsD = $_POST['ops'] == 0 ? "" : " op_rd='" . $_POST['ops'] . "' AND ";

  $refD = $_POST['ref'] == 0 ? "" : " cod_ref_rd = '" . $_POST['ref'] . "' AND ";

  $anyoD = $_POST['anyolis'] == 0 ? "" : " YEAR(fecha_rd)='" . $_POST['anyolis'] . "' AND ";

  $mesD = $_POST['meslis'] == 0 ? "" : " MONTH(fecha_rd)='" . $_POST['meslis'] . "' AND ";

  $clienteD = $_POST['cliente'] == 0 ? "0" : " tbl_orden_produccion.int_cliente_op='" . $_POST['cliente'] . "' AND tbl_orden_produccion.int_cod_ref_op=tbl_reg_desperdicio.cod_ref_rd AND ";
  $bandera = 0;
  if ($clienteD) {

    $suma_desp = $conexion->llenarCampos('tbl_reg_desperdicio,tbl_orden_produccion', " WHERE $clienteD id_proceso_rd='4' ", " ORDER BY fecha_rd DESC ", " SUM(valor_desp_rd) AS kilosdesp");
    $bandera = 1;
  } else {


    $suma_desp = $conexion->llenarCampos('tbl_reg_desperdicio', " WHERE $opsD $refD $anyoD $mesD id_proceso_rd='4' ", " ORDER BY fecha_rd DESC ", " SUM(valor_desp_rd) AS kilosdesp");
  }




  if ($cliente != "0" && $bandera == 0) {

    $row_porcentajeDespExtr = $conexion->llenarCampos('tbl_reg_produccion,tbl_orden_produccion', " WHERE $cliente $ops $anyo $ref $mes tbl_reg_produccion.id_proceso_rp='1' ", " GROUP BY tbl_reg_produccion.id_op_rp ORDER BY tbl_reg_produccion.fecha_ini_rp DESC  ", " tbl_reg_produccion.id_op_rp,tbl_reg_produccion.id_proceso_rp,tbl_reg_produccion.int_cod_ref_rp,tbl_reg_produccion.rollo_rp, tbl_reg_produccion.fecha_ini_rp, sum(tbl_reg_produccion.int_kilos_prod_rp) as kiloint, SUM(tbl_reg_produccion.int_kilos_desp_rp) as kilosdesp, ROUND((sum(tbl_reg_produccion.int_kilos_desp_rp) * 100 / SUM(tbl_reg_produccion.int_kilos_prod_rp)),2) as result");

    //Consulto porcentaje desperdicio Impresion
    $row_porcentajeDespImp = $conexion->llenarCampos('tbl_reg_produccion,tbl_orden_produccion', " WHERE $cliente $ops $anyo $ref $mes id_proceso_rp='2' ", " GROUP BY tbl_reg_produccion.id_op_rp ORDER BY fecha_ini_rp DESC ", " tbl_reg_produccion.id_op_rp,tbl_reg_produccion.id_proceso_rp,tbl_reg_produccion.int_cod_ref_rp,tbl_reg_produccion.rollo_rp, tbl_reg_produccion.fecha_ini_rp, sum(tbl_reg_produccion.int_kilos_prod_rp) as kiloint, SUM(tbl_reg_produccion.int_kilos_desp_rp) as kilosdesp, ROUND((sum(tbl_reg_produccion.int_kilos_desp_rp) * 100 / SUM(tbl_reg_produccion.int_kilos_prod_rp)),2) as result");

    //Consulto porcentaje desperdicio Sellado
    $row_porcentajeDespSell = $conexion->llenarCampos('tbl_reg_produccion,tbl_orden_produccion', " WHERE $cliente $ops $anyo $ref $mes tbl_reg_produccion.id_proceso_rp='4' ", " GROUP BY tbl_reg_produccion.id_op_rp ORDER BY tbl_reg_produccion.fecha_ini_rp DESC ", " tbl_reg_produccion.id_op_rp,tbl_reg_produccion.id_proceso_rp,tbl_reg_produccion.int_cod_ref_rp,tbl_reg_produccion.rollo_rp, tbl_reg_produccion.fecha_ini_rp, sum(tbl_reg_produccion.int_kilos_prod_rp) as kiloint, ('" . $suma_desp['kilosdesp'] . "' ) as kilosdesp, ROUND((('" . $suma_desp['kilosdesp'] . "' + sum(kiloFaltante_rp) )* 100 / SUM(tbl_reg_produccion.int_kilos_prod_rp)),2) as result");
  } else {

    $row_porcentajeDespExtr = $conexion->llenarCampos('tbl_reg_produccion', " WHERE $ops $anyo $ref $mes id_proceso_rp='1' ", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, SUM(int_kilos_desp_rp) as kilosdesp, ROUND((sum(int_kilos_desp_rp) * 100 / SUM(int_kilos_prod_rp)),2) as result");

    //Consulto porcentaje desperdicio Impresion
    $row_porcentajeDespImp = $conexion->llenarCampos('tbl_reg_produccion', " WHERE $ops $anyo $ref $mes id_proceso_rp='2' ", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, SUM(int_kilos_desp_rp) as kilosdesp, ROUND((sum(int_kilos_desp_rp) * 100 / SUM(int_kilos_prod_rp)),2) as result");

    //Consulto porcentaje desperdicio Sellado 
    $row_porcentajeDespSell = $conexion->llenarCampos('tbl_reg_produccion', " WHERE $ops $anyo $ref $mes id_proceso_rp='4' ", " ORDER BY fecha_ini_rp DESC ", " `id_op_rp`,`id_proceso_rp`,`int_cod_ref_rp`,`rollo_rp`, `fecha_ini_rp`, sum(int_kilos_prod_rp) as kiloint, ('" . $suma_desp['kilosdesp'] . "' ) as kilosdesp, ROUND((('" . $suma_desp['kilosdesp'] . "' + sum(kiloFaltante_rp) ) * 100 / SUM(int_kilos_prod_rp)),2) as result");
  }

  $extruder = $row_porcentajeDespExtr['result'] == '' ? 0 : $row_porcentajeDespExtr['result'];
  $impresion = $row_porcentajeDespImp['result'] == '' ? 0 : $row_porcentajeDespImp['result'];
  $sellado = $row_porcentajeDespSell['result'] == '' ? 0 : $row_porcentajeDespSell['result'];

  $total = (($extruder + $impresion + $sellado));
  $array = array(
    "extruder" => $extruder,
    "impresion" => $impresion,
    "sellado" => $sellado,
    "total" => $total
  );
  if ($array != '') {

    echo json_encode($array);
  }
  exit();
} else {
  echo '';
}


if (isset($_POST['historico']) && $_POST['historico'] != '') {

  if ($sqlogs = $conexion->llenaListas('tbl_logs', "WHERE codigo_id = " . $_POST['historico'], "ORDER BY fecha ASC", "*")) {
    echo json_encode($sqlogs);
  }
  exit();
} else {
  echo '';
}


if (isset($_GET['prefijo']) && $_GET['prefijo'] != '') {
  $resp = array();
  if ($sqlogs = $conexion->llenarCampos("tbl_orden_consecutivo", "", "ORDER BY CONVERT(str_numero_oc, SIGNED INTEGER)   DESC", "str_numero_oc")) {
    $pieza = $sqlogs['str_numero_oc'];
    $str_numero_oc = ($pieza + 1);
    $resulrt = $conexion->insertar("tbl_orden_consecutivo", "str_numero_oc", " '" . $str_numero_oc . "' ");
    $array = array(
      "pref" => $_GET['prefijo'],
      "valor" => $str_numero_oc,
    );
    echo  json_encode($array);
  }
  //exit();
}



if (isset($_GET['num_orden_compra']) && $_GET['num_orden_compra'] != '') {
  $resp = array();

  if (!(ereg("^[a-zA-Z0-9\-]{1,100}$", $_GET['num_orden_compra']))) {
    $array = array(
      "mns" => "Caracteres no permitidos, verifique!",
      "valor" => 1,
    );
  } else
    if ($sqlogs = $conexion->llenarCampos("tbl_orden_compra", "WHERE str_numero_oc='" . $_GET["num_orden_compra"] . "' ", "", "str_numero_oc")) {
    $existe = $sqlogs['str_numero_oc'];
    if ($existe) {

      $array = array(
        "mns" => "La orden de compra ya existe, revise.",
        "valor" => 1,
      );
    }
  } else {
    $array = array(
      "mns" => "ORDEN DE COMPRA VALIDADA",
      "valor" => 2,
    );
  }
  echo  json_encode($array);
}




if (isset($_GET['idcliente']) && $_GET['idcliente'] != '') {

  if ($sqlogs = $conexion->llenarCampos("tbl_orden_compra", " WHERE factura_oc <> '' AND valor_cartera <> '' AND id_c_oc=" . $_GET['idcliente'], "GROUP BY factura_oc ORDER BY factura_oc DESC ", "str_numero_oc,factura_oc")) {
    $pieza = $sqlogs;
    echo  json_encode($pieza);
  }
  exit();
}


if (isset($_POST['bodegas_id']) && $_POST['bodegas_id'] != '') {

  if ($resultado = $conexion->llenaListas("tbl_destinatarios tir ", "WHERE tir.id_d=" . $_POST['bodegas_id'], "", " * ")) {

    echo json_encode($resultado);
  }
  exit();
} else {
  echo '';
}


if (isset($_POST['int_op_tn']) && $_POST['int_op_tn'] != '') {

  if ($resultado = $conexion->llenarCampos("tbl_orden_produccion", "WHERE  id_op = '" . $_POST['int_op_tn'] . "'  ", "ORDER BY id_op DESC ", "numInicio_op")) {

    echo json_encode($resultado);
    exit();
  } else {
    echo '';
  }
}

if ($_POST['comprobarProveedor']) {

  if ($existe = $conexion->llenaListas('proveedor', "WHERE proveedor_p LIKE '%$_POST[campo]%'", "", '*')) {
    
    echo json_encode($existe);
    
    exit();
  } else {
    echo "No existe";
    
  }
}
if ($_POST['comprobarCliente']) {

  if ($existe = $conexion->llenaListas('cliente', "WHERE nombre_c LIKE '%$_POST[campo]%'", "", '*')) {
    
    echo json_encode($existe);
    
    exit();
  } else {
    echo 0;//cliente no existe
    exit();
  }
}



?>