<?php
require_once(XAJAX_SERVER_PATH."city.server.php");

function printHTML(){
	global $demoHTML;
	global $ucGrid;
	ob_start();
	require($demoHTML);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

function printJS(){
	city_printJS();
}

$actionsFormat =
		'<div align="center">
			<img src="'.IMAGE_PATH_URL.'edit.gif" alt="Edit" title="Edit" style="border:none;cursor:hand;" onclick="editCity(\'%s\');" />
			<img src="'.IMAGE_PATH_URL.'delete.gif" alt="Delete" title="Delete" style="border:none;cursor:hand;" onclick="deleteCity(\'%s\',\'ucGrid\');" />
		</div>';

$comboFormat =
		'<div align="center"><select id="peopleis_%s" class="select">{$options}</select></div>';

$nameFormat = 
		'<div align="center"><input id="name_%s" type="text" value="%s" maxlength="35" class="textField" /></div>';

$populationFormat =
		'<div align="right">%s</div>';

$ucGrid = AjaxGrid::create(
	"ucGrid",
	array(
		new DBQueryDescriptor("city",
			array("ID","Name", "Population","PeopleIs")),
		new DBQueryDescriptor("peopleis",
			array("ID","Description"),
			DBQueryDescriptor::$INNER_JOIN,
			'peopleis.ID = city.PeopleIs')),
	array(
		"Actions" => new ColumnMapped($actionsFormat,
				array("city.ID","city.ID"),false,'5%'),
		"Pople Is" => new ColumnComboMapped($comboFormat,
				"peopleis","peopleis.ID","peopleis.Description",
				"peopleis.ID",array("city.ID"),
				"peopleis.Description"),
		"Name" => new ColumnMapped($nameFormat,
				array("city.ID", "city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)));
?>