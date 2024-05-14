<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
require_once('Connections/conexion1.php');
include('funciones/funciones_php.php');

if (!isset($_SESSION)) {
    session_start();
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$conexion = new ApptivaDB();
$fechaToday = fechaActual();
$fechaTomorrow = sumaDia($fechaToday);
$fechaWeekInit = restaDia($fechaToday, 8);
$fechaWeekFin = restaDia($fechaToday, 1);
$mesAnoActual = date('Y-m', strtotime($fechaToday));
$fechaMonth = "$mesAnoActual-01";
$fechaFinMonth = "$mesAnoActual-31";
/* $fechaToday = '2024-03-16';
$fechaTomorrow = '2024-04-10'; */

//$desperdicios = $conexion->llenaListas("tbl_reg_desperdicio as td", "INNER JOIN tblextruderrollo as te on (td.id_rollo = te.id_r) INNER JOIN empleado on (te.cod_empleado_r = empleado.codigo_empleado) WHERE id_proceso_rd = 1 AND fecha_rd BETWEEN '2024-03-14' AND '2024-03-15'" , "", "td.*, te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado");
$desperdicios = $conexion->llenaListas(
    "tbl_reg_desperdicio as td",
    "INNER JOIN tblextruderrollo AS te ON (td.op_rd = te.id_op_r) 
    INNER JOIN empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    WHERE td.id_proceso_rd = 1 AND DATE(te.fechaF_r) >= '$fechaToday' AND DATE(te.fechaF_r) <= '$fechaTomorrow'
    GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    "te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(td.valor_desp_rd),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina "
);
$produccion = $conexion->llenaListas(
    "tblextruderrollo AS te",
    "INNER JOIN empleado ON (te.cod_empleado_r = empleado.codigo_empleado)
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina) 
    WHERE DATE(te.fechaF_r) >= '$fechaToday' AND DATE(te.fechaF_r) <= '$fechaTomorrow'
    GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado ",
    "empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(te.kilos_r),1) AS total_kilos, maquina.id_maquina,maquina.nombre_maquina as maquina"
);

$tmuertos = $conexion->llenaListas(
    "tbl_reg_tiempo as tt",
    "INNER JOIN tblextruderrollo AS te ON (tt.op_rt = te.id_op_r) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    INNER JOIN empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    WHERE tt.id_proceso_rt = 1 AND DATE(te.fechaF_r) >= '$fechaToday' AND DATE(te.fechaF_r) <= '$fechaTomorrow'
    GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    "te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(tt.valor_tiem_rt),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$desperdiciosWeek = $conexion->llenaListas(
    "tbl_reg_desperdicio as td",
    "INNER JOIN tblextruderrollo AS te ON (td.op_rd = te.id_op_r) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    INNER JOIN 
    empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    WHERE 
    td.id_proceso_rd = 1 
    AND DATE(te.fechaF_r) >= '$fechaWeekInit' AND DATE(te.fechaF_r) <= '$fechaWeekFin'
    GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    "te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(td.valor_desp_rd),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$produccionWeek = $conexion->llenaListas(
    "tblextruderrollo AS te",
    "INNER JOIN empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    WHERE DATE(te.fechaF_r) >= '$fechaWeekInit' AND DATE(te.fechaF_r) <= '$fechaWeekFin'
    GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado ",
    "empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(te.kilos_r),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$tmuertosWeek = $conexion->llenaListas(
    "tbl_reg_tiempo as tt",
    "INNER JOIN 
    tblextruderrollo AS te ON (tt.op_rt = te.id_op_r) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    INNER JOIN 
    empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    WHERE 
    tt.id_proceso_rt = 1 
    AND DATE(te.fechaF_r) >= '$fechaWeekInit' AND DATE(te.fechaF_r) <= '$fechaWeekFin'
    GROUP BY 
    maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    " te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(tt.valor_tiem_rt),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$produccionMonth = $conexion->llenaListas(
    "tblextruderrollo AS te",
    "INNER JOIN 
    empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
    INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
    WHERE 
    DATE(te.fechaF_r) >= '$fechaMonth' AND DATE(te.fechaF_r) <= '$fechaFinMonth'
    GROUP BY 
    maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado ",
    "empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(te.kilos_r),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$desperdiciosMonth = $conexion->llenaListas(
    "tbl_reg_desperdicio as td",
    "INNER JOIN tblextruderrollo AS te ON (td.op_rd = te.id_op_r) 
        INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
        INNER JOIN empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
        WHERE td.id_proceso_rd = 1 
        AND DATE(te.fechaF_r) >= '$fechaMonth' AND DATE(te.fechaF_r) <= '$fechaFinMonth'
        GROUP BY maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    "te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, ROUND(SUM(td.valor_desp_rd),1) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

$tmuertosMonth = $conexion->llenaListas(
    "tbl_reg_tiempo as tt",
    "INNER JOIN 
        tblextruderrollo AS te ON (tt.op_rt = te.id_op_r) 
        INNER JOIN maquina ON (te.str_maquina_ext = maquina.id_maquina)
        INNER JOIN 
        empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
        WHERE 
        tt.id_proceso_rt = 1 
        AND DATE(te.fechaF_r) >= '$fechaMonth' AND DATE(te.fechaF_r) <= '$fechaFinMonth'
        GROUP BY 
        maquina.id_maquina, empleado.nombre_empleado",
    "ORDER BY empleado.nombre_empleado",
    " te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado, SUM(tt.valor_tiem_rt) AS total_kilos, maquina.id_maquina, maquina.nombre_maquina as maquina"
);

/* 
SELECT td.*, te.cod_empleado_r, empleado.nombre_empleado, empleado.apellido_empleado  FROM tbl_reg_desperdicio as td 
INNER JOIN tblextruderrollo as te 
on (td.id_rollo = te.id_r)
INNER JOIN empleado on (te.cod_empleado_r = empleado.codigo_empleado)
WHERE id_proceso_rd = 1 AND fecha_rd BETWEEN '2024-03-14' AND '2024-03-15'
*/
/* 
SELECT 
    empleado.nombre_empleado,
    empleado.apellido_empleado,
    SUM(te.kilos_r) AS total_kilos
FROM 
    tblextruderrollo AS te 
INNER JOIN 
    empleado ON (te.cod_empleado_r = empleado.codigo_empleado) 
WHERE 
    te.fechaI_r BETWEEN '2024-03-14' AND '2024-03-15'
GROUP BY 
    empleado.nombre_empleado, empleado.apellido_empleado
*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/formato.css" />

    <script type="text/javascript" src="js/listado.js"></script>

    <!-- css Bootstrap hace mas grande el formato-->
    <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- chart graficos -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>

    <title>Dashboard Extrusion</title>

</head>

<body onload="JavaScript: AutoRefresh (100000);">
    <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
        <div align="center">
            <table style="width: 100%"><!-- id="tabla1" -->
                <tr>
                    <td align="center">
                        <div class="row-fluid">
                            <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                                <div class="panel panel-primary size">
                                    <div class="panel-heading" align="left"></div><!--color azul-->
                                    <div class="row">
                                        <div class="span12">&nbsp;&nbsp;&nbsp; <img src="images/cabecera.jpg"></div>
                                    </div>
                                    <div class="panel-heading" align="left"></div><!--color azul-->
                                    <div id="cabezamenu" style="display: flex; flex-direction: row-reverse;">
                                        <ul id="menuhorizontal">
                                            <li><a class="permitido" href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                                            <li><a class="permitido" href="menu.php">MENU PRINCIPAL</a></li>
                                            <li><a href="produccion_registro_extrusion_listado.php">EXTRUSION</a></li>
                                        </ul>
                                    </div>

                                    <div class="panel-heading">
                                        <h1>GRAFICA DE EXTRUSION </h1>
                                    </div>

                                    <div id="containerGraphics">
                                        <div>
                                            <h4><?php echo date('d M Y', strtotime($fechaToday)) ?></h4>
                                        </div>
                                        <div id="graphics">
                                            <div class="bar-chart">
                                                <canvas id="graphProdDaily"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphDespDaily"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphTmuertDaily"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="containerGraphics">
                                        <div>
                                            <h4><?php echo date('d M Y', strtotime($fechaWeekInit)) . " a " . date('d M Y', strtotime($fechaWeekFin)) ?></h4>
                                        </div>
                                        <div id="graphics">
                                            <div class="bar-chart">
                                                <canvas id="graphProdWeek"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphDespWeek"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphTmuertWeek"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="containerGraphics">
                                        <div>
                                            <h4><?php echo date('M', strtotime($fechaMonth))  ?></h4>
                                        </div>
                                        <div id="graphics">
                                            <div class="bar-chart">
                                                <canvas id="graphProdMonth"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphDespMonth"></canvas>
                                            </div>
                                            <div class="bar-chart">
                                                <canvas id="graphTmuertMonth"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
    </td>
    </tr>
    </table>
    </div>
    </div>
</body>

</html>

<script>
    /* variables donde van los graficos */
    const graphProdDaily = document.querySelector("#graphProdDaily");
    const graphDespDaily = document.querySelector("#graphDespDaily");
    const graphTmuertDaily = document.querySelector("#graphTmuertDaily");
    const graphProdWeek = document.querySelector("#graphProdWeek");
    const graphDespWeek = document.querySelector("#graphDespWeek");
    const graphTmuertWeek = document.querySelector("#graphTmuertWeek");
    const graphProdMonth = document.querySelector("#graphProdMonth");
    const graphDespMonth = document.querySelector("#graphDespMonth");
    const graphTmuertMonth = document.querySelector("#graphTmuertMonth");

    /* nombre de las 2 maquinas para los labels */
    const labels = {
        maquina1: "Extrusora 1",
        maquina2: "Extrusora 2"
    };

    /* colores de las barras */
    const colors = ['rgb(99,180,122)', 'rgb(69,150,223)']

    /* configuracion de la vista general de los graficos */
    Chart.register(ChartDataLabels);
    Chart.defaults.set('plugins.datalabels', {
        color: '#17202A'
    });
    Chart.defaults.backgroundColor = '#BFC9CA';
    Chart.defaults.borderColor = '#17202A';
    Chart.defaults.color = '#17202A';

    /* informacion de la base de datos para cada grafica */
    let rowDesperdicos = <?php echo json_encode($desperdicios) ?>;
    let rowProd = <?php echo json_encode($produccion) ?>;
    let rowTmuertos = <?php echo json_encode($tmuertos) ?>;
    let rowDesperdicosWeek = <?php echo json_encode($desperdiciosWeek) ?>;
    let rowProdWeek = <?php echo json_encode($produccionWeek) ?>;
    let rowTmuertosWeek = <?php echo json_encode($tmuertosWeek) ?>;
    let rowProdMonth = <?php echo json_encode($produccionMonth) ?>;
    let rowDesperdicosMonth = <?php echo json_encode($desperdiciosMonth) ?>;
    let rowTmuertosMonth = <?php echo json_encode($tmuertosMonth) ?>;
console.log("prod diaria");
console.log(rowProd);
console.log("prod semanal");
console.log(rowProdWeek);
console.log("prod mensual");
console.log(rowProdMonth);
    /*se convierte la informacion de la base de datos a un objeto para poderlo iterar y evitar info repetida */
    const objProd = createObjects(rowProd)
    const objDesp = createObjects(rowDesperdicos)
    const objTmuertos = createObjects(rowTmuertos)
    const objDespWeek = createObjects(rowDesperdicosWeek)
    const objProdWeek = createObjects(rowProdWeek)
    const objTmuertosWeek = createObjects(rowTmuertosWeek)
    const objDespMonth = createObjects(rowDesperdicosMonth)
    const objProdMonth = createObjects(rowProdMonth)
    const objTmuertosMonth = createObjects(rowTmuertosMonth)

    /* se crea la estructura de datos para las maquinas */
    const dataProd = data(labels, colors);
    const dataDesp = data(labels, colors);
    const dataTmuertos = data(labels, colors);
    const dataProdWeek = data(labels, colors);
    const dataDespWeek = data(labels, colors);
    const dataTmuertosWeek = data(labels, colors);
    const dataProdMonth = data(labels, colors);
    const dataDespMonth = data(labels, colors);
    const dataTmuertosMonth = data(labels, colors);

    /* configuracion del formato y datos a mostrar en la grafica  */
    const configProd = config('bar', dataProd, "Kilos", "PRODUCCION  DIARIOS");
    const configDesp = config('bar', dataDesp, "Kilos", "DESPERDICIO DIARIOS");
    const configTmuert = config('bar', dataTmuertos, "Horas", "TIEMPOS MUERTOS DIARIOS");
    const configDespWeek = config('bar', dataDespWeek, "Kilos", "DESPERDICIO SEMANAL");
    const configProdWeek = config('bar', dataProdWeek, "Kilos", "PRODUCCION SEMANAL");
    const configTmuertWeek = config('bar', dataTmuertosWeek, "Horas", "TIEMPOS MUERTOS SEMANAL");
    const configDespMonth = config('bar', dataDespMonth, "Kilos", "DESPERDICIO MENSUAL");
    const configProdMonth = config('bar', dataProdMonth, "Kilos", "PRODUCCION MENSUAL");
    const configTmuertMonth = config('bar', dataTmuertosMonth, "Horas", "TIEMPOS MUERTOS MENSUAL");

    /* creacion de nuevas instancias de la clase Chart */
    const myChartProd = new Chart(graphProdDaily, configProd);
    const myChartDesp = new Chart(graphDespDaily, configDesp);
    const myChartTmuerto = new Chart(graphTmuertDaily, configTmuert);
    const myChartProdWeek = new Chart(graphProdWeek, configProdWeek);
    const myChartDespWeek = new Chart(graphDespWeek, configDespWeek);
    const myChartTmuertoWeek = new Chart(graphTmuertWeek, configTmuertWeek);
    const myChartProdMonth = new Chart(graphProdMonth, configProdMonth);
    const myChartDespMonth = new Chart(graphDespMonth, configDespMonth);
    const myChartTmuertoMonth = new Chart(graphTmuertMonth, configTmuertMonth);

    /* creamos un nuevo array organizado que sera el que vamos a mostrar */
    /* usamos uns funcion armar_arrays el cual le pasamos un objeto y nos devulve  arrays */
    var nombresProd = armar_arrays(objProd)[0],
        ext1Prod = armar_arrays(objProd)[1],
        ext2Prod = armar_arrays(objProd)[2];
    var nombresDesp = armar_arrays(objDesp)[0],
        ext1Desp = armar_arrays(objDesp)[1],
        ext2Desp = armar_arrays(objDesp)[2];
    var nombresTmuertos = armar_arrays(objTmuertos)[0],
        ext1Tmuerto = armar_arrays(objTmuertos)[1],
        ext2Tmuerto = armar_arrays(objTmuertos)[2];
    var nombresProdWeek = armar_arrays(objProdWeek)[0],
        ext1ProdWeek = armar_arrays(objProdWeek)[1],
        ext2ProdWeek = armar_arrays(objProdWeek)[2];
    var nombresDespWeek = armar_arrays(objDespWeek)[0],
        ext1DespWeek = armar_arrays(objDespWeek)[1],
        ext2DespWeek = armar_arrays(objDespWeek)[2];
    var nombresTmuertoWeek = armar_arrays(objTmuertosWeek)[0],
        ext1TmuertoWeek = armar_arrays(objTmuertosWeek)[1],
        ext2TmuertoWeek = armar_arrays(objTmuertosWeek)[2];
    var nombresProdMonth = armar_arrays(objProdMonth)[0],
        ext1ProdMonth = armar_arrays(objProdMonth)[1],
        ext2ProdMonth = armar_arrays(objProdMonth)[2];
    var nombresDespMonth = armar_arrays(objDespMonth)[0],
        ext1DespMonth = armar_arrays(objDespMonth)[1],
        ext2DespMonth = armar_arrays(objDespMonth)[2];
    var nombresTmuertoMonth = armar_arrays(objTmuertosMonth)[0],
        ext1TmuertoMonth = armar_arrays(objTmuertosMonth)[1],
        ext2TmuertoMonth = armar_arrays(objTmuertosMonth)[2];

    /* insertamos los valores de los nombres y los valores a la grafica */
    myChartProd.data['labels'] = nombresProd;
    myChartProd.data['datasets'][0].data = ext1Prod;
    myChartProd.data['datasets'][1].data = ext2Prod;
    myChartDesp.data['labels'] = nombresDesp;
    myChartDesp.data['datasets'][0].data = ext1Desp;
    myChartDesp.data['datasets'][1].data = ext2Desp;
    myChartTmuerto.data['labels'] = nombresTmuertos;
    myChartTmuerto.data['datasets'][0].data = ext1Tmuerto;
    myChartTmuerto.data['datasets'][1].data = ext2Tmuerto;
    myChartProdWeek.data['labels'] = nombresProdWeek;
    myChartProdWeek.data['datasets'][0].data = ext1ProdWeek;
    myChartProdWeek.data['datasets'][1].data = ext2ProdWeek;
    myChartDespWeek.data['labels'] = nombresDespWeek;
    myChartDespWeek.data['datasets'][0].data = ext1DespWeek;
    myChartDespWeek.data['datasets'][1].data = ext2DespWeek;
    myChartTmuertoWeek.data['labels'] = nombresTmuertoWeek;
    myChartTmuertoWeek.data['datasets'][0].data = ext1TmuertoWeek;
    myChartTmuertoWeek.data['datasets'][1].data = ext2TmuertoWeek;
    myChartProdMonth.data['labels'] = nombresProdMonth;
    myChartProdMonth.data['datasets'][0].data = ext1ProdMonth;
    myChartProdMonth.data['datasets'][1].data = ext2ProdMonth;
    myChartDespMonth.data['labels'] = nombresDespMonth;
    myChartDespMonth.data['datasets'][0].data = ext1DespMonth;
    myChartDespMonth.data['datasets'][1].data = ext2DespMonth;
    myChartTmuertoMonth.data['labels'] = nombresTmuertoMonth;
    myChartTmuertoMonth.data['datasets'][0].data = ext1TmuertoMonth;
    myChartTmuertoMonth.data['datasets'][1].data = ext2TmuertoMonth;


    function armar_arrays(objeto) {
        let nombres = [],
            maq1 = [],
            maq2 = [];
        for (let i = 0; i < objeto.length; i++) {
            nombres.push(objeto[i].nombre_empleado);
            for (let j = 0; j < objeto[i].maquinas.length; j++) {
                if (objeto[i].maquinas[j].id_maquina === "10") {
                    maq1[i] = objeto[i].maquinas[j].total_kilos;
                    break
                } else maq1[i] = "";
            }
            for (let j = 0; j < objeto[i].maquinas.length; j++) {
                if (objeto[i].maquinas[j].id_maquina === "21") {
                    maq2[i] = objeto[i].maquinas[j].total_kilos;
                    break
                } else maq2[i] = "";
            }
        }
        return [nombres, maq1, maq2]
    }

    function createObjects(data) {
        return Object.values(data.reduce((acumulador, actual) => {
            if (!acumulador[actual.nombre_empleado]) {
                acumulador[actual.nombre_empleado] = {
                    nombre_empleado: actual.nombre_empleado,
                    apellido_empleado: actual.apellido_empleado,
                    maquinas: []
                };
            }
            acumulador[actual.nombre_empleado].maquinas.push({
                total_kilos: actual.total_kilos,
                id_maquina: actual.id_maquina,
                maquina: actual.maquina
            });
            return acumulador;
        }, {}));
    }

    function config(type, data, txtBar, titulo) {
        let txt2 = txtBar
        return {
            type: type,
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: titulo
                    },
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: function(value, context) {
                            value === "" ? txtBar = "" : txtBar = txt2
                            return value + ' ' + txtBar; // Muestra el valor de la barra
                        }
                    }
                }
            }
        };
    }

    function data(txtlabel, colors) {
        return {
            datasets: [{
                label: txtlabel['maquina1'],
                backgroundColor: colors[0]
            }, {
                label: txtlabel['maquina2'],
                backgroundColor: colors[1]
            }]
        };
    }
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        /* background-color: #f4f4f4; */
        text-align: center;
        /* display: flex;
        flex-direction: column;
        align-items: center; */
        margin: 30px;
        background: #2f2f2f;
        color: #17202A;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        /* padding: 20px; */
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2rem;
    }

    #span {
        font-size: 20px;
    }

    .bar-chart {
        width: 30vw;
        height: 40vh;
        margin: 0 auto;
    }

    canvas {
        margin-top: 30px;
    }

    #graphics {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    #containerGraphics {
        display: flex;
        flex-direction: column;
    }

    .size {
        width: 100%;
        height: auto"

    }

    @media (max-width: 600px) {
        .bar-chart {
            width: 90vw;
            height: 50vh;
            margin: 0 auto;
        }
    }
</style>