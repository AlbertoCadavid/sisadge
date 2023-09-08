<?php
class PreviaExcelControl extends GenericoControl
{
	
	public function previa()
	{	// Configuro Variables del Servidor
		include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
		new configPhpIni();
		include_once( DIR_OPET . DIR_UTILI . 'PHPExcel.php');
		include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel/IOFactory.php');
		include_once( DIR_MDLAC . DIR_UTILI . 'PreviaExcel.php');
		$archivoExcel			= $_GET['excel'];
		if(!$this->archivoApto($archivoExcel))
		{	include_once ( DIR_OPET . DIR_CONTR . 'ErrorControl.php');
		echo $this->msjError;
			/*$error				= new ErrorControl();
			$error				->errorGenerico('Error !!!', $this->msjError);*/
			return;
		}
		
		$tipo					= $this->getTipoDeExtencion('planillas/' . $archivoExcel);
	
		if($tipo!='Excel2007')
		{	include_once ( DIR_OPET . DIR_CONTR . 'ErrorControl.php');
			$error				= new ErrorControl(null, null, null);
			$error				->errorGenerico('Error !!!', 'Solo se permite Vista previa para archivos Excel 2007 (xlsx).');
			return;
		}
	
		$objReader 				= PHPExcel_IOFactory::createReader($tipo);
		$objReader				->setReadFilter( new PreviaExcel() );
		$objPHPExcel 			= $objReader->load('planillas/' . $archivoExcel	);
		$objWorksheet 			= $objPHPExcel->getActiveSheet();
		$_SESSION['columnas']	= PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
		
		$this->vista->cargar(array('plantilla' => 'previaExcel.tpl'));
		$fila					= 1;
		$columna				= 0;
		foreach ($objWorksheet->getRowIterator() as $row)
		{	$cellIterator = $row->getCellIterator();
  			$cellIterator->setIterateOnlyExistingCells(false);
			if($fila!=1)
  			{	$datos				= array('');
  				$datosEncabezados	= array('letra'	=> $this->getNumeroALetra($columna));
  				$columna++;
  				//$this->vista->AsignarBlocke('fila',$datos);
   				$this->vista->AsignarBlocke('fila',array('numero'=>$fila));
  				$this->vista->AsignarBlocke('columnas',$datosEncabezados);
  			}  			
  			foreach ($cellIterator as $cell)
  			{	if($fila==1)
  				{	$datos				= array('nombre' => $cell->getValue());
  					$this->vista->AsignarBlocke('titulos',$datos);
  				}
  				else
  				{	$datos				= array('nombre' => $cell->getValue());
  					$this->vista->AsignarBlocke('fila.datos',$datos);
  				}
  			}
  			$fila++;
		}
		$this->vista->mostrar('plantilla');
	}
	
	private function archivoApto($archivo)
	{	if(stripos('/',$archivo) || stripos('\\',$archivo) )
		{	$this->msjError	= 'Nombre de Archivo no compatible.';
			return false;
		}
		
		$archivo			= 'planillas/' . $archivo;
		if(!is_file($archivo))	
		{	$this->msjError	= 'El archivo no existe.';
			return false;
		}
		
		if(!is_readable($archivo))
		{	$this->msjError	= 'El archivo no se puede leer.<br />Verifique los permisos.';
			return false;
		}
		return true;
	}
	
	private function getTipoDeExtencion($archivo)
	{	$puntero	= strripos($archivo,".");
		$extencion	= strtolower(substr($archivo,$puntero+1));
		switch ($extencion)
		{	case 'xls':
				$tipo		= "Excel5";
				break;
			case 'xlsx':
				$tipo		= "Excel2007";
				break;
			default:
				break;
		}
		return $tipo;
	}
	
	private function getNumeroALetra($numero)
	{	$numero++;
		$cadena		= '';
		do
		{	$entero 	= intval( $numero / 26 );
			$resto		= ( $numero % 26 );
			$cadena		= chr( 64 + $resto) . $cadena;
			if(!$entero) break;
			if($entero<26)
			{	$cadena	= chr( 64 + $entero) . $cadena;
				break;
			}
			$numero		= $entero;
		}
		while(true);
		return $cadena;
	}
}