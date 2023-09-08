<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *    Server side functions.
 *    
 */

$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
if($folder_depth == false)
$folder_depth = 1;
$configPath = str_repeat("../", $folder_depth - 1) . 'phpajaxgrid/examples/config/';

require_once($configPath.'config.php');
require_once(XAJAX_PATH."xajax.inc.php");

if(!isset($xajax) || !($xajax instanceof xajax)){
	$xajax = new xajax(XAJAX_SERVER_PATH_URL.'city.server.php');
}

$xajax->registerFunction("city_edit");
$xajax->registerFunction("city_delete");
$xajax->registerFunction("city_actualizeSeven");

require_once(AJAX_GRID_PATH."AjaxGrid.inc.php");

/**
 * Render the Javascript for xajax's requests.
 */
function city_printJS(){
	AjaxGrid_printJS();
	echo
	'<script language="javascript" src="'.JS_PATH_URL."city.js".'">
	</script>';
}

/**
 * Edit a city
 */
function city_edit($id,$peopleIsId,$name){
	$objResponse = new xajaxResponse();	
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
	if (mysqli_connect_errno()) {
		$objResponse->addAlert('An error happened');
	}
	else{
		$query = sprintf(
			"UPDATE city SET
				city.PeopleIs = %d,
				city.Name = '%s'
			WHERE
				city.ID = %d;",
			$peopleIsId,
			mysqli_real_escape_string($link,$name),
			$id);
		if(!mysqli_query($link, $query)){
			$objResponse->addAlert('An error happened');
		}
		else{
			$objResponse->addAlert('The city was edited succefully');
		}
	}	
	mysqli_close($link);
	return $objResponse;
}

/**
 * Delete a city
 */
function city_delete($id,$gridName){
	$objResponse = new xajaxResponse();
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
	if (mysqli_connect_errno()) {
		$objResponse->addAlert('An error happened');
	}
	else{
		$query = sprintf(
			"DELETE FROM
				city
			WHERE
				city.ID = %d;",
			$id);
		if(!mysqli_query($link, $query)){
			$objResponse->addAlert('An error happened');
		}
		else{
			$objResponse->addScriptCall("AjaxGrid_refresh('$gridName')");
		}
	}
	return $objResponse;
}

/**
 * Actualize people character
 */
function city_actualizeSeven($id,$peopleIsId){
	$objResponse = new xajaxResponse();	
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
	if (mysqli_connect_errno()) {
		$objResponse->addAlert('An error happened');
	}
	else{
		$query = sprintf(
			"UPDATE city SET
				city.PeopleIs = %d
			WHERE
				city.ID = %d;",
			$peopleIsId,
			$id);
		if(!mysqli_query($link, $query)){
			$objResponse->addAlert('An error happened');
		}
		else{
			$objResponse->addScriptCall("AjaxGrid_refresh('excellentGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('veryGoodGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('goodGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('noBadGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('badGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('veryBadGrid')");
			$objResponse->addScriptCall("AjaxGrid_refresh('repugnantGrid')");
		}
	}	
	mysqli_close($link);
	return $objResponse;
}

if($xajax->sRequestURI == XAJAX_SERVER_PATH_URL.'city.server.php'){
	$xajax->processRequests();
}

?>