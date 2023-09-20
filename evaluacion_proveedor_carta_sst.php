<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php
if (!isset($_SESSION)) {
	session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
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
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
	$MM_qsChar = "?";
	$MM_referrer = $_SERVER['PHP_SELF'];
	if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
		$MM_referrer .= "?" . $QUERY_STRING;
	$MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	header("Location: " . $MM_restrictGoTo);
	exit;
}
?>
<?php

$conexion = new ApptivaDB();

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
	$colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
$row_usuario = $conexion->buscar('usuario', 'usuario', $colname_usuario);





$colname_proveedor = "-1";
if (isset($_GET['id_p'])) {
	$colname_proveedor = (get_magic_quotes_gpc()) ? $_GET['id_p'] : addslashes($_GET['id_p']);
}
$row_proveedor = $conexion->buscar('proveedor', 'id_p', $colname_proveedor);


if ($_POST['guardar_imprimir'] == 'form') {
	$conexion->insertar('evaluacion_proveedor', "`id_ev`, `n_ev`, `id_p_ev`, `periodo_desde_ev`, `periodo_hasta_ev`, `total_oc_ev`, `total_verificacion_ev`, `total_oportunos_ev`, `total_no_oportunos_ev`, `porcentaje_oportunos_ev`, `total_cumple_ev`, `total_no_cumple_ev`, `porcentaje_cumple_ev`, `total_conforme_ev`, `total_no_conforme_ev`, `porcentaje_conforme_ev`, `total_atencion_ev`, `total_no_atencion_ev`, `porcentaje_atencion_ev`, `porcentaje_final_ev`, `calificacion_ev`, `calificacion_texto_ev`, `responsable_registro_ev`, `fecha_registro_ev`, `evaluacion`, `porcentaje_fpago_ev`, `porcentaje_trespuesta_ev`, `porcentaje_alegal_ev`, `porcentaje_entrega_ev`, `porcentaje_garantias_ev`, `porcentaje_respuesta_ev`", "'',$_POST[n_ev], $_POST[id_p_ev], '$_POST[periodoInicial]', '$_POST[periodoFinal]','','','','','','','','','','','','','','', $_POST[porcentaje_final], $_POST[calificacion_ev], '$_POST[calificacion_texto]', '$_POST[nombre_usuario]', '$_POST[fecha_registro]', '', $_POST[precioUsuario], $_POST[trayectoriaUsuario], $_POST[aspectoUsuario], $_POST[entregaUsuario], $_POST[garantiaUsuario], $_POST[respuestaUsuario]");
	header('Location: ' . "evaluacion_proveedor.php?id_p=512&evaluacion=SST&Submit=EVALUACION");
}

$ultimo_numero = $conexion->llenarCampos("evaluacion_proveedor", "WHERE id_p_ev =" . $_GET['id_p'], " ORDER BY n_ev DESC", "*");
/* ---------------- */


?>

<html>

<head>
	<title>SISADGE AC &amp; CIA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<!-- <link href="css/vista.css" rel="stylesheet" type="text/css" /> -->
	<script type="text/javascript" src="js/vista.js"></script>
	<link href="css/formato.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/formato.js"></script>
	<script type="text/javascript" src="js/listado.js"></script>

	<!-- desde aqui para listados nuevos -->

	<link rel="stylesheet" type="text/css" href="css/general.css" />

	<!-- sweetalert -->
	<script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

	<!-- select2 -->
	<link href="select2/css/select2.min.css" rel="stylesheet" />
	<script src="select2/js/select2.min.js"></script>

	<!-- css Bootstrap-->
	<link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



</head>

<body>
	<form action="" method="post" name="form" id="form">
		<input type="hidden" id="id_p_ev" name="id_p_ev" value="<?php echo $_GET['id_p'] ?>">
		<br>
		<div align="center">

			<table align="center" id="tabla" class="tabla_bordes" style="width:90%">
				<tr align="center">
					<td>

						<table align="center" id="tabla">
							<tr align="center">
								<td rowspan="8" id="dato2"><img src="images/logoacyc.jpg"></td>
								<td style="text-align: center;">
									<h3> EVALUACIÓN DE DESEMPEÑO DEL PROVEEDOR </h3>
									<div id="fondo">
										NIT: 890915756-6<br>
										PBX: (60-4) 311 21 44 ∙ www.acycia.com<br>
										Carrera 45 # 14-15 Sector Barrio Colombia<br>
										Medellín – Colombia
									</div>
								</td>
								<td nowrap="nowrap" style="text-align:left; ">
									<h4> N. <input readonly style="border:0; width:30px" type="text" id="n_ev" name="n_ev" value="<?php if ($_GET['numero'] != '') {
																																		echo $_GET['numero'];
																																	} else {
																																		$numero = $ultimo_numero['n_ev'] + 1;
																																		echo $numero;
																																	} ?>">
									</h4>

								</td>
							</tr>
						</table>

						<br>
						<table style="width:80%">
							<tr>
								<td id="justificar">
									Medellin,
									<input type="hidden" name="fecha_registro" id="fecha_registro" value="<?php echo date('Y-m-d') ?>">
									<?php $fecha1 = date("Y-m-d"); //$row_evaluacion_proveedor['fecha_registro_ev'];
									$dia1 = substr($fecha1, 8, 2);
									$mes1 = substr($fecha1, 5, 2);
									$ano1 = substr($fecha1, 0, 4);
									if ($mes1 == '01') {
										echo "Enero" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '02') {
										echo "Febrero" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '03') {
										echo "Marzo" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '04') {
										echo "Abril" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '05') {
										echo "Mayo" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '06') {
										echo "Junio" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '07') {
										echo "Julio" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '08') {
										echo "Agosto" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '09') {
										echo "Septiembre" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '10') {
										echo "Octubre" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '11') {
										echo "Noviembre" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									if ($mes1 == '12') {
										echo "Diciembre" . "  " . $dia1 . "  " . "de" . "  " . $ano1;
									}
									?><br><br>
									SEÑOR (A):<br>
									<?php echo $row_proveedor['contacto_p'];  ?><br>
									<strong><?php echo $row_proveedor['proveedor_p']; ?></strong><br>
									<?php echo $row_proveedor['ciudad_p']; ?> -
									<?php echo $row_proveedor['pais_p']; ?><br><br>
									Cordial Saludo.<br>
									<p>
										Como requisito fundamental de nuestro Sistema de Gestión de Calidad, nuestro Sistema de Seguridad y Salud en el Trabajo y en búsqueda del mejoramiento continuo de nuestras relaciones comerciales con clientes y proveedores, nos permitimos participarle el resultado obtenido de la evaluación de proveedores efectuada a la empresa por los productos y/o servicios suministrados durante el periodo <strong> <input style="width:110px" class="dato" type="date" name="periodoInicial" id="periodoInicial" value="<?php echo date('Y') ?>-01-01"> </strong> hasta <strong> <input class="dato" style="width:110px" type="date" name="periodoFinal" id="periodoFinal" value="<?php echo date("Y-m-d") ?>"> </strong>.<br>
										<br>
										La evaluación se lleva a cabo de acuerdo a los siguientes criterios:<br><br>
									</p>

								</td>
							<tr>
						</table>


						<table class="table table-bordered" style="width:80%">
							<thead>
								<tr class="table-active">
									<th id="subtitulo2" scope="col">REQUISITO A EVALUAR</th>
									<th id="subtitulo2" scope="col">% ESTABLECIDO / REQUISITO</th>
									<th id="subtitulo2" scope="col">CALIFICACION OBTENIDA</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><strong>PRECIO/FORMA DE PAGO</strong> <br>
										De acuerdo al promedio del mercado </td>
									<td id="dato2">10%</td>
									<td id="dato2"><input class="dato" style="width:25px; text-align:center" type="text" name="precioUsuario" id="precioUsuario" value=""> % </td>
								</tr>
								<tr>
									<td><strong>TRAYECTORIO EN EL MERCADO Y TIEMPO DE </strong><br>
										<strong>RESPUESTA DE COTIZACIÓN. </strong><br>
										Reconocimiento y competencia
									</td>
									<td id="dato2"> 10%</td>
									<td id="dato2" style="vertical-align: middle"><input class="dato" style="width:25px; text-align:center" type="text" name="trayectoriaUsuario" id="trayectoriaUsuario" value=""> % </td>
								</tr>
								<tr>
									<td><strong>ASPECTO LEGAL</strong> <br>
										Cumplimiento en los requisitos legales
									</td>
									<td id="dato2">20%</td>
									<td id="dato2"><input class="dato" style="width:25px; text-align:center" type="text" name="aspectoUsuario" id="aspectoUsuario" value=""> % </td>
								</tr>

								<tr>
									<td><strong>ENTREGA/CUMPLIMIENTO</strong> <br>
										(<=0 dias) </td>
									<td id="dato2">20%</td>
									<td id="dato2"><input class="dato" style="width:25px; text-align:center" type="text" name="entregaUsuario" id="entregaUsuario" value=""> % </td>
								</tr>

								<tr>
									<td><strong>GARANTIA/CALIDAD DEL BIEN Y/O SERVICIO</strong></td>
									<td id="dato2">20%</td>
									<td id="dato2"><input class="dato" style="width:25px; text-align:center" type="text" name="garantiaUsuario" id="garantiaUsuario" value=""> % </td>
								</tr>

								<tr>
									<td><strong>OPORTUNIDAD EN LA RESPUESTA A LOS</strong> <br>
										<strong>REQUERIMIENTOS DE LA ORGANIZACIÓN </strong>
									</td>
									<td id="dato2">20%</td>
									<td id="dato2"><input class="dato" style="width:25px; text-align:center" type="text" name="respuestaUsuario" id="respuestaUsuario" value=""> % </td>
								</tr>


								<tr class="table-active">
									<td id="dato1"><strong>TOTAL</strong></td>
									<td id="dato2"><strong>100%</strong></td>
									<td id="dato2"><strong><span class="total"></span> % </strong></td>
									<input type="hidden" name="porcentaje_final" id="porcentaje_final" value="">
									<input type="hidden" name="calificacion_ev" id="calificacion_ev" value="">
									<input type="hidden" name="calificacion_texto" id="calificacion_texto" value="">
								</tr>

							</tbody>
						</table>

						<table style="width:80%">
							<tr>
								<td id="justificar">
									<!-- Total pedidos efectuados en el periodo: <?php echo $row_evaluacion_proveedor['total_oc_ev']; ?> <br>
								Total de entregas efectuadas en el periodo: <?php echo $row_evaluacion_proveedor['total_verificacion_ev']; ?><br>
 -->
									Según la siguiente tabla, los resultados obtenidos lo catalogan como un proveedor <strong class="calificacion"></strong>
									De antemano les agradecemos los servicios que nos han prestado y esperamos que esta evaluación sea de gran utilidad para retroalimentar su proceso y afianzar nuestras relaciones cliente/proveedor.<br>
									<br>
								</td>
							</tr>
							<tr align="center">
								<td>
									<table class="table table-bordered" style="width:50%">
										<thead>
											<tr class="table-active">
												<th id="subtitulo2" scope="col">CLASIFIACIÓN</th>
												<th id="subtitulo2" scope="col">CALIFICACIÓN</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td id="dato2">Excelente
												</td>
												<td>95% y 100%</td>
											</tr>
											<tr>
												<td id="dato2">Bueno
												</td>
												<td>80% y 94%</td>
											</tr>
											<tr>
												<td id="dato2">Regular
												</td>
												<td>70% y 79%</td>
											</tr>
											<tr>
												<td id="dato2">Malo
												</td>
												<td>Menor a 70%</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>

							<tr>
								<td>

									<table>
										<tr>
											<td>

												Atentamente,<br><br>
												<input type="hidden" name="nombre_usuario" id="nombre_usuario" value="<?php echo $row_usuario['nombre_usuario']; ?>">
												<?php echo $row_usuario['nombre_usuario']; ?><br>
												Líder de Seguridad y Salud en el Trabajo.
												<br><br>
											</td>
										<tr>
									</table>

								</td>
							</tr>


					</td>
				</tr>
			</table>
			<div class="divImprimir">
				<img id="imprimir" style="width:30px" src="./images/impresor.gif" alt="Imprimir" type="submit">
			</div>
		</div>
		<input type="hidden" name="guardar_imprimir" value="form">
	</form>
</body>

</html>
<?php
mysqli_free_result($usuario);

mysqli_free_result($evaluacion_proveedor);
?>

<script>
	let imprimir = document.querySelector("#imprimir");
	let precio = document.querySelector("#precioUsuario");
	let trayectoria = document.querySelector("#trayectoriaUsuario");
	let aspecto = document.querySelector("#aspectoUsuario");
	let entrega = document.querySelector("#entregaUsuario");
	let garantia = document.querySelector("#garantiaUsuario");
	let respuesta = document.querySelector("#respuestaUsuario");
	let total = document.querySelector(".total");
	let calificacion = document.querySelector(".calificacion");
	let porcentajeFinal = document.querySelector("#porcentaje_final");
	let calificacion_ev = document.querySelector("#calificacion_ev");
	let calificacion_texto = document.querySelector("#calificacion_texto");


	imprimir.addEventListener("click", function() {
		if (precio.value == "" || trayectoria.value == "" || entrega.value == "" || garantia.value == "" || respuesta.value == "") {
			swal("ERROR", "Debe llenar todos los campos de Calificacion");
		} else {
			document.form.submit();

			imprimir.style.display = "none";
			var items = document.querySelectorAll(".dato");
			items.forEach(function(item) {
				item.style.border = 0
			})

			window.print();
		}
	})

	precio.addEventListener("change", function(e) {
		suma(e.target.value, 0);
	})
	trayectoria.addEventListener("change", function(e) {
		suma(e.target.value, 1);
	})
	aspecto.addEventListener("change", function(e) {
		suma(e.target.value, 2);
	})
	entrega.addEventListener("change", function(e) {
		suma(e.target.value, 3);
	})
	garantia.addEventListener("change", function(e) {
		suma(e.target.value, 4);
	})
	respuesta.addEventListener("change", function(e) {
		suma(e.target.value, 5);
	})

	var valores = [];

	function suma(num, i) {
		acu = 0;
		valores[i] = (num) == "" ? 0 : parseInt(num);
		valores.forEach(element => {
			acu = acu + element;
		});
		total.innerHTML = acu;
		porcentajeFinal.value = acu;
		calificacion_ev.value = numeroCalificacion(acu)[0];
		calificacion_texto.value = numeroCalificacion(acu)[1];
		mostrarCalificacion(acu);

	}

	function mostrarCalificacion(valor) {
		texto = "";
		if (valor > 94 && valor < 101) {
			texto = "Excelente,";
		} else if (valor > 79 && valor < 95) {
			texto = "Bueno,";
		} else if (valor > 69 && valor < 80) {
			texto = "Regular y por ello se debe establecer un plan de acción.";
		} else if (valor < 71) {
			texto = "Malo y por ello se debe establecer un plan de acción.";
		} else {
			texto = ""
		}
		calificacion.innerHTML = texto;
	}

	function numeroCalificacion(num) {
		if (num >= '0' && num <= '50') {
			return [1, "Esta entre 0%-50%: El proveedor no debe continuar a menos que sea el �nico o se defina un plan riguroso."];
		}
		if (num >= '51' && num <= '80') {
			return [2, "Esta entre 51% - 80%: Se debe establecer un plan de acci�n."];
		}
		if (num >= '81' && num <= '100') {
			return [3, "Esta entre 81% - 100%: Se considera que cumple para la organizacion."];
		}
	}
</script>