<?php
/**
 * Responsable de ejecutar los comandos necesarios para ejecutar la exportacion de los archivos
 * excel a mysql.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (05/09/2009)
 * @since		Usar conjuntamente con la clase ExcelMysqlModelo.php
 */
class ExcelAMysqlControl extends GenericoControl
{	
	private $msjErrorMysql	= array();
	
	/**
	 * Manda a realizar las tareas necesarias a ExcelMysqlControl para llevar a delante
	 * la exportacion de la planilla excel a mysql.
	 * @return 		void
	 */
	public function exportar()
	{	// Verifico los datos
        $_SESSION['formulaValor']   = isset($_POST['formulaValor'])?        $_POST['formulaValor'] : 0;
		$urlTestigo					= DIR_BASE . '/index.php?mdl=deame3p&ctr=Exportar&acc=relaciones';
		$urlAnterior				= isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : null;
		$posicion					= strripos($urlAnterior, $urlTestigo);

		if(!$posicion)
		{
            $this->vista->cargar(array('plantilla' => 'errorSistema.tpl'));
			$this->vista->AsignarVar('encabezado'	, 'ERROR !!!');
			$this->vista->AsignarVar('mensaje'		, 'Faltan datos para llevar adelante la tarea.');
			$this->vista->mostrar('plantilla');
			return false;
		}
		
		// Verifico que el archivo se encuentre en el servidor
		if(!file_exists('planillas/' . $_SESSION['archivoExcel']))
		{	$this->vista->cargar(array('plantilla' => 'error.tpl'));
			$this->vista->AsignarVar('encabezado'	, 'ERROR !!!');
			$this->vista->AsignarVar('mensaje'		, 'El archivo <strong>' . $_SESSION['archivoExcel'] . '</strong> no se encuentra en el servidor.
			<br />Verifique que el archivo haya subido con exito.');
			$this->vista->mostrar('plantilla');
			return false;
		}
		// Configuro Variables del Servidor
		include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
		new configPhpIni();
        // Levanto las propiedades de los campos a Exportar.
        include_once(DIR_MDLAC . DIR_UTILI . 'Exportar.php');
		$obj_Exportar	= new Exportar();
		$obj_Exportar   ->setCamposExportar($_POST,$_SESSION["codificacion"]);
		$obj_Exportar	->setConexionMysqli($this->modelo->getMysqli());
		//$obj_Exportar	->getPropiedadesCampos();

		// Levanto el archivo Excel a Utilizar y lo dejo preparado.
		include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel.php');		
		include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel/IOFactory.php');
		include_once( DIR_MDLAC . DIR_UTILI . 'FilasExcel.php');
		
		$obj_Reader 	= PHPExcel_IOFactory::createReader($_SESSION['tipoExcel']);
		$obj_Reader		->setReadFilter( new FilasExcel($_SESSION['columnas']));
		$obj_Reader		->setReadDataOnly(true);
		$obj_PHPExcel 	= $obj_Reader->load('planillas/' . $_SESSION['archivoExcel']);

        $libro          = isset($_POST['exportarTodasLasHojas'])? $_POST['exportarTodasLasHojas'] : 0;
        $hojasExport    = array();
        if ($libro) {
            // Todo el arreglo
            $hojasExport    = $obj_PHPExcel->getSheetNames();
        } else {
            // solo la hoja
            $hojasExport[$_SESSION['hojaExcel']]    = 'Hoja Seleccionada';
        }

        foreach($hojasExport as $index => $nombre) {

            $obj_PHPExcel   ->setActiveSheetIndex($index);
            $obj_Worksheet 	= $obj_PHPExcel->getActiveSheet();
            // Comienzo a generar las consultas de inserccion
            switch ($_SESSION["funcionesDeame3p"])
            {	case 1:	// INSERTO SOLAMENTE
					$this->modelo->comprobarSistema($obj_Exportar, $obj_Worksheet, $_SESSION['tabla'], $_SESSION["modoDeame3p"],'I');
					break;
                case 4:	// INSERTO Y SI SE REPITE LA CLAVE ACTUALIZO
					$this->modelo->comprobarSistema($obj_Exportar, $obj_Worksheet, $_SESSION['tabla'], $_SESSION["modoDeame3p"],'U');
					break;
            }

            ($_SESSION['modoDeame3p'] != 4)? $this->estadisticas($this->modelo->getErrores(), $nombre) : null;
            $obj_Exportar	->borrarArchivo($_SESSION["borrarArchivo"],$_SESSION['archivoExcel']);
            $this->modelo->reset();
        }
	}
	
	/**
	 * Genera el recuadro de estadisticas de exportacion.
	 * @param 	Array	$datos		Contiene datos de las estadisticas.
	 * @return 	void				Salida HTML
	 */
	public function estadisticas($datos, $nombre = '')
	{
        $this->vista->resetearVista();
        $this->vista->cargar(array('plantilla' => 'estadisticas.tpl'));
		$totales	= array_sum($datos);
        $this->vista->AsignarVar('hojaDeCalculo', $nombre);
		foreach ($datos as $index => $valor)
		{	$porcentaje	= (($valor/$totales)*100)."%";
			if($index==0)
			{	$index 	= 'CORRECTO';	}
			else
			{	$index	= 'ERROR MySQL ' . $index;	}
			$vista		= array('numero'	=> $index,
								'cantidad'	=> $valor,
								'porcentaje'=> $porcentaje);
			$this->vista->AsignarBlocke('errores',$vista);
		}

        $this->vista->AsignarVar('tiempoExportacion', $this->modelo->getTiempoScript() . ' seg.');
		$this->vista->mostrar('plantilla');
	}
}