<?php
require_once(XAJAX_SERVER_PATH."city.server.php");

function printHTML(){
	global $demoHTML;
	global $excellentGrid;
	global $veryGoodGrid;
	global $goodGrid;
	global $noBadGrid;
	global $badGrid;
	global $veryBadGrid;
	global $repugnantGrid;
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
			<img src="'.IMAGE_PATH_URL.'edit.gif" alt="Edit" title="Edit" style="border:none;cursor:hand;" onclick="actualizeSeven(\'%s\');" />
		</div>';

$comboFormat =
		'<div align="center"><select id="peopleis_%s" class="select">{$options}</select></div>';

$nameFormat = 
		'%s';

$populationFormat =
		'<div align="right">%s</div>';

// BEGIN - excellentGrid
$excellentGrid = AjaxGrid::create(
	"excellentGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 1');
// END - excellentGrid

// BEGIN - veryGoodGrid
$veryGoodGrid = AjaxGrid::create(
	"veryGoodGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 2');
// END - veryGoodGrid

// BEGIN - goodGrid
$goodGrid = AjaxGrid::create(
	"goodGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 3');
// END - veryGoodGrid

// BEGIN - noBadGrid
$noBadGrid = AjaxGrid::create(
	"noBadGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 4');
// END - noBadGrid

// BEGIN - badGrid
$badGrid = AjaxGrid::create(
	"badGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 5');
// END - badGrid

// BEGIN - veryBadGrid
$veryBadGrid = AjaxGrid::create(
	"veryBadGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 6');
// END - veryBadGrid

// BEGIN - repugnantGrid
$repugnantGrid = AjaxGrid::create(
	"repugnantGrid",
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
				array("city.Name"), true),
		"Population" => new ColumnMapped($populationFormat,
				array("city.Population"), true)),
	false, 'city.PeopleIs = 7');
// END - repugnantGrid

?>