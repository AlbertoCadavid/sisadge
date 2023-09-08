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
	"cityGrid",
	array(
		new DBQueryDescriptor("city",
			array("ID","Name", "CountryCode", "District", "Population"))
		),
	array(
		"ID" => new ColumnMapped("%s", array("city.ID"),true,'5%'),
		"Name" => new ColumnMapped("%s", array("city.Name"), true),
		"Country Code" => new ColumnMapped("%s", array("city.CountryCode"), true),
		"District" => new ColumnMapped("%s", array("city.District"), true),
		"Population" => new ColumnMapped("%s", array("city.Population"), true)
		)
	);
	
?>