<?php
include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/Reader/IReadFilter.php');

class PreviaExcel implements PHPExcel_Reader_IReadFilter
{	
	private $cantFilas		= 25;
	
	
	
	public function readCell($column, $row, $worksheetName = '')
	{	// Lee hasta la cantidad de filas indicadas por defecto 25.
		if ($row <= $this->cantFilas)
		{	return true;	}
		return false;
	}
	
	public function setCantidadFilas($filas)
	{	$this->cantFilas	= intval($filas);	}
	
	public function verExcel()
	{	$this->readCell(25, $this->cantFilas);
		
	}
	
}