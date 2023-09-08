<?php
require_once(AJAX_GRID_PATH."AjaxGrid.inc.php");

function printHTML(){
	global $demoHTML;
	global $cityGrid;
	ob_start();
	require($demoHTML);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

function printJS(){
	AjaxGrid_printJS();
}

$cityGrid = AjaxGrid::create(
	"countryCode",
	array(
		new DBQueryDescriptor("city",
			array("CountryCode"),
			"MAIN TABLE", NULL, true)
		),
	array(
		"Country Code" => new ColumnMapped("%s", array("city.CountryCode"), true),
		"Changed" => new ColumnMapped("%s", array("city.CountryCode"), false,
			NULL, false,
			array('ARG' => 'Argentina', 'BRA' => 'Brazil', 'USA' => 'United States',))
		)
	);
	
?>