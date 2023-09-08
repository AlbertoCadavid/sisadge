<?php
include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/Reader/IReadFilter.php');

class TitulosExcel implements PHPExcel_Reader_IReadFilter
{	
	public function readCell($column, $row, $worksheetName = '')
	{	// Lee solamente la primera columna que es la de titulos
		if ($row == 1)
		{	return true;	}
		return false;
	}
}