<?php
include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/Reader/IReadFilter.php');

class FilasExcel implements PHPExcel_Reader_IReadFilter
{	
	private		$columnas;
	private		$filas;
	
	public function __construct($columnas)
	{	$this->columnas		= $columnas;	}
	
	public function readCell($column, $row, $worksheetName = '')
	{	if ($column<=$this->columnas)
		{	return true;	}
		return false;
	}
}