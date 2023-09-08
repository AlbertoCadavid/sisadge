<?php
//session_start();
//session_destroy();
include_once('config/config.php');


if(!isset($_GET["go"])) $_GET["go"] = "default";

switch($_GET["go"]){
	case 'demo_ps': $proyect_section_title="PHP Ajax Grid - Demo: Pagging + Sorting";
	include_once(ROOT.'paggingSorting/ps.php');
	$demoHTML = ROOT.'paggingSorting/ps.html.php';
	$proyect_text=printHTML();
	break;
		
	case 'demo_uc': $proyect_section_title="PHP Ajax Grid - Demo: Update + Combos";
	include_once(ROOT.'updateCombos/uc.php');
	$demoHTML = ROOT.'updateCombos/uc.html.php';
	$proyect_text=printHTML();
	break;
		
	case 'demo_seven': $proyect_section_title="PHP Ajax Grid - Demo: Seven Tables";
	include_once(ROOT.'seven/seven.php');
	$demoHTML = ROOT.'seven/seven.html.php';
	$proyect_text=printHTML();
	break;

	case 'demo_filter': $proyect_section_title="PHP Ajax Grid - Demo: Filters + Change values";
	include_once(ROOT.'filter/filter.php');
	$demoHTML = ROOT.'filter/filter.html.php';
	$proyect_text=printHTML();
	break;
	
	case 'demo_disctinct': $proyect_section_title="PHP Ajax Grid - Demo: Distinct";
	include_once(ROOT.'distinct/distinct.php');
	$demoHTML = ROOT.'distinct/distinct.html.php';
	$proyect_text=printHTML();
	break;

	default: $proyect_section_title="PHP Ajax Grid - (Pagina del proyecto en construccion)";
	$proyect_text="PHP Ajax Grid es un componente para crear facilmente grillas para listar el contenido de las tablas de la base de datos, paginarlas, ordenarlas y realizar acciones sobre la mismas con AJAX. Vea las demostraciones para ver las posibilidades de uso.";
	include_once(ROOT.'paggingSorting/ps.php');
	break;
}

//include_once($demo);

if(!isset($_SESSION['style'])){
	$_SESSION['style'] = 'blue';
}
if(isset($_GET['changecss']) && $_GET['changecss'] == 't'){
	if($_SESSION['style'] == 'blue'){
		$_SESSION['style'] = 'dark';
	}
	else{
		$_SESSION['style'] = 'blue';
	}
}
if($_SESSION['style'] == 'blue'){
	$actualStyle = 'AjaxGridBlue.css';
}
else{
	$actualStyle = 'AjaxGridDark.css';
}

$proyect_title="PHP Ajax Grid";

$proyect_menu=array();
$proyect_menu["PHP Ajax Grid"]=array("Introduccion" => "index.php?go=intro");
$proyect_menu["Demos"] = array(
	"Pagging + Sorting " => "index.php?go=demo_ps",
	"Update + Combos" => "index.php?go=demo_uc",
	"Seven Tables" => "index.php?go=demo_seven",
	"Filters" => "index.php?go=demo_filter",
	"Distinct + Change" => "index.php?go=demo_disctinct"
);


$proyect_html_head='<link rel="stylesheet" type="text/css" href="style/estilos.css"/>
                                  <link rel="stylesheet" type="text/css" href="style/'.$actualStyle.'"/>
                                  <script language="javascript" src="js/utils.js"></script>
                                    '.printJS();

include("../templates/proyect.php");
?>