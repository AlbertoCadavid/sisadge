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
//Uncomment if you are using Freelancesoft's Logger
//require_once(CLASSES_PATH."Exceptions.php");
//require_once(MESAGE_MANAGER_PATH."MessageManager.php");
require_once(AJAX_GRID_PATH."GridConfig.php");
require_once(AJAX_GRID_PATH."DBQueryDescriptor.php");
require_once(AJAX_GRID_PATH."FilteredColumn.php");
require_once(AJAX_GRID_PATH."ColumnMapped.php");
require_once(AJAX_GRID_PATH."ColumnComboMapped.php");
require_once(AJAX_GRID_PATH."AjaxGrid.php");
require_once(XAJAX_PATH."xajax.inc.php");
if(!isset($_SESSION)) session_start();


/**
 * Filtra por un valor en una columna de la grilla.
 *
 * @param String $gridName
 * @param Integer $colNumber
 * @param string $filteredString
 * @return ObjectResponse
 */
function AjaxGrid_filter($gridName, $colNumber, $filterString){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->filter($colNumber, $filterString);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Filtra por un valor en una columna de la grilla, lo hace con un LIKE '{$filterString}%'.
 *
 * @param String $gridName
 * @param Integer $colNumber
 * @param string $filteredString
 * @return ObjectResponse
 */
function AjaxGrid_Customfilter($gridName, $colNumber, $filterString){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->customFilter($colNumber, $filterString);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Quita el filtro de una columna específica.
 *
 * @param String $gridName
 * @param Integer $colNumber
 * @return ObjectResponse
 */
function AjaxGrid_removeFilter($gridName, $colNumber){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->removeFilter($colNumber);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Salta a una fila específica de una tabla, el resultado con xajax.
 *
 * @param String $gridName
 * @param Integer $rowNumber
 * @return ObjectResponse
 */
function AjaxGrid_goToRow($gridName,$rowNumber){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->goToRow($rowNumber);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Salta a una fila específica de una tabla, el resultado con xajax.
 *
 * @param String $gridName
 * @param Integer $rowNumber
 * @return ObjectResponse
 */
function AjaxGrid_sort($gridName,$colNumber){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->sort($colNumber);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Refresca la grilla
 *
 * @param string $gridName
 * @return ObjectResponse
 */
function AjaxGrid_refresh($gridName){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->actualizeData();
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Actualiza la cantidad de filas por página.
 *
 * @param String $gridName
 * @param Integer $rowPerPage
 * @return ObjectResponse
 */
function AjaxGrid_changeRowsPerPage($gridName,$rowPerPage){
	$grid = $_SESSION[$gridName];
	$objResponse = new xajaxResponse();
	try{
		$grid->setMaxRows($rowPerPage);
		$objResponse = createResponse($grid,$gridName);
	}
	catch (Exception $ex){
		//Uncomment if you are using Freelancesoft's Logger
		//MessageManager::handleException($ex);
		//if(IS_DEBUG){
			$objResponse->addAlert("Error: {$ex->getMessage()}");
		//}
	}
	return $objResponse;
}

/**
 * Imprime el Javascript necesario para hacer requerimientos xajax.
 */
function AjaxGrid_printJS(){
	echo AjaxGrid_getJS();
}

/**
 * Obtiene el Javascript necesario para hacer requerimientos xajax.
 * 
 * @return string
 */
function AjaxGrid_getJS(){
	global $xajax;
	global $_AJAX_GRID_PATH;
	return
		$xajax->getJavascript(XAJAX_PATH_URL).
		'<script language="javascript" src="'.JS_PATH_URL."ajaxGrid.js".'">
			</script>';
}

function createResponse($grid,$gridName){
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("{$gridName}_navigation_bar1_btn_first",'innerHTML',$grid->getFirstButton());
	$objResponse->addAssign("{$gridName}_navigation_bar1_btn_previous",'innerHTML',$grid->getPreviousButton());
	$objResponse->addAssign("{$gridName}_navigation_bar1_page_links",'innerHTML',$grid->getPageLinks());
	$objResponse->addAssign("{$gridName}_navigation_bar1_btn_next",'innerHTML',$grid->getNextButton());
	$objResponse->addAssign("{$gridName}_navigation_bar1_btn_last",'innerHTML',$grid->getLastButton());
	$objResponse->addAssign("{$gridName}_rows_info",'innerHTML',$grid->getRowsInfo());
	$objResponse->addAssign("{$gridName}_complete_table_id",'innerHTML',$grid->getTable());
	$objResponse->addAssign("{$gridName}_navigation_bar2_btn_first",'innerHTML',$grid->getFirstButton());
	$objResponse->addAssign("{$gridName}_navigation_bar2_btn_previous",'innerHTML',$grid->getPreviousButton());
	$objResponse->addAssign("{$gridName}_navigation_bar2_page_links",'innerHTML',$grid->getPageLinks());
	$objResponse->addAssign("{$gridName}_navigation_bar2_btn_next",'innerHTML',$grid->getNextButton());
	$objResponse->addAssign("{$gridName}_navigation_bar2_btn_last",'innerHTML',$grid->getLastButton());
	$objResponse->addAssign("{$gridName}_change_rows_per_page",'innerHTML',$grid->getChangeRowsPerPage());
	$objResponse->addAssign("{$gridName}_id_loading",'style.display','none');
	$objResponse->addAssign("{$gridName}_id_loading",'style.visibility','hidden');
	return $objResponse;
}

if(!isset($xajax) || !($xajax instanceof xajax)){
	$xajax = new xajax(AJAX_GRID_PATH_URL."AjaxGrid.server.php");
}
$xajax->registerFunction("AjaxGrid_goToRow");
$xajax->registerFunction("AjaxGrid_sort");
$xajax->registerFunction("AjaxGrid_changeRowsPerPage");
$xajax->registerFunction("AjaxGrid_refresh");
$xajax->registerFunction("AjaxGrid_filter");
$xajax->registerFunction("AjaxGrid_removeFilter");
$xajax->registerFunction("AjaxGrid_customFilter");
if($xajax->sRequestURI == AJAX_GRID_PATH_URL."AjaxGrid.server.php"){
	$xajax->processRequests();
}

?>