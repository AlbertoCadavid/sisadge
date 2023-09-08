<?php
require_once(AJAX_GRID_PATH."AjaxGrid.inc.php");

function printHTML(){
	global $demoHTML;
	global $filteredGrid;
	ob_start();
	require($demoHTML);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

function printJS(){
	AjaxGrid_printJS();
}

/**
 * 
 * The last parameter is dependencies of filters. This is an array where:
 *   - Keys are strings that represents column names.
 *   - Values are arrays of strings that represents column names.
 * If "A" => array("B","C") is an alement of dependencies this means that:
 *   - If filter for column A change, then the filters for columns B and C are reseted.
 *   - If filter for column A is active, then the items for filters of columns B and C
 *     are filtered too.
 * 
 */

	$filteredGrid = AjaxGrid::create(
		"filteredGrid",
		array(
			new DBQueryDescriptor("city",
				array("ID","Name", "CountryCode", "District"))
			),
		array(
			"ID" => new ColumnMapped("%s", array("city.ID"),true,'5%'),
			"Name" => new ColumnMapped("%s", array("city.Name"), true),
			"Country Code" => new ColumnMapped("%s", array("city.CountryCode"), true, NULL, true),
			"District" => new ColumnMapped("%s", array("city.District"), true, NULL, true)
			), false, '1', 
		array(
			"Country Code" => array("District"))
		);
	
?>