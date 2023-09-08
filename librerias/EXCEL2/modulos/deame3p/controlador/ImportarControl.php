<?php
/**
 * Se encarga de generar archivos excel a partir de una consulta MySQL.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		0.1.0 (08/09/2009)
 */
class ImportarControl extends GenericoControl
{	
	/**
	 * Guarda datos sobre los archivos excel 2007 y anteriores.
	 * @var	array
	 */	
	private $tipoXls	= array(
								'Excel2007' => array('ext' 	=> 'xlsx'	,'mime'	=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ),
						  		'Excel5'	=> array('ext'	=> 'xls'	,'mime'	=> 'application/vnd.ms-excel')
								);
	
	public function form()
	{	if(!$_SESSION['OP_CONECT'])
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
		}	
		
		$this->vista->cargar(array('plantilla' => 'formularioImportacion.tpl'));
		$this->vista->AsignarVar('version', DM3P_VRSN);
		// Verifico que este activada la extencion php_zip
		$zip		= extension_loaded('zip');
		if(!$zip)
		{	$this->vista->AsignarVar('php_zip' 	, 'La extencion	PHP php_zip debe estar instalada.');	}
		// Fin Carga de Variables
		$this->vista->mostrar('plantilla');
		// Cargo los Archivos JavaScript Necesarios
		$this->cargarJS(DIR_OPET, 'jquery-1.3.2.min.js');
		$this->cargarJS(DIR_MDLAC, 'formImportacion.js');	
	}
	
	public function generarExcel()
	{	// Levantamos los datos del formulario
		$base		= $this->modelo->escaparMysql($_POST['baseDeDatos']);
		$tabla		= $this->modelo->escaparMysql($_POST['tabla']);
		$tipo		= $this->modelo->escaparMysql($_POST['tipo']);
		$campos		= $_POST['campos'];
		// Configuro Variables del Servidor
		include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
		new configPhpIni();
		// Veo como son los campos elegidos
		include_once ( DIR_OPET . DIR_UTILI . 'InfoCampos.php');
		$conexion	= $this->modelo->getMysqli();
		$infoCampos	= new InfoCampos($conexion,$base,$tabla);
		$importarCampos				= array();
		$camposRespuesta			= '';
		foreach($campos	as $clave => $valor)
		{
            $valor					= $this->modelo->escaparMysql($valor);
			$importarCampos[$valor]['tipo']		= $infoCampos->getCampoInfo($valor,'tipo');
			$importarCampos[$valor]['cantidad']	= $infoCampos->getCampoInfo($valor,'largo');
            $camposRespuesta		.= "`" . $valor . "` , ";
		}
		$camposRespuesta    = substr($camposRespuesta,0, strlen($camposRespuesta) - 2  );
		$consulta           = "SELECT $camposRespuesta FROM " . $base . '.' .$tabla;

        include_once( DIR_OPET . DIR_UTILI . 'PHPExcel.php' );
		include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/IOFactory.php');
		//Creamos un objeto PHPExcel
		$objPHPExcel = new PHPExcel();
		// Leemos un archivo Excel 2007
		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		//$objPHPExcel = $objReader ->load('Archivo.xlsx');
		// Indicamos que se pare en la hoja uno del libro
		$objPHPExcel->getProperties()->setCreator('DEAME3P V.' . DM3P_VRSN);
		$objPHPExcel->getProperties()->setLastModifiedBy('DEAME3P V.' . DM3P_VRSN);
		$objPHPExcel->getProperties()->setTitle('Generando desde Mysql con DEAME3P');
		$objPHPExcel->getProperties()->setSubject('Generando desde Mysql con DEAME3P');
		$objPHPExcel->getProperties()->setDescription("Generado usando PHP classes.");
		$objPHPExcel->getProperties()->setKeywords("deame3p excel mysql importar exportar php");
		$objPHPExcel->getProperties()->setCategory('DEAME3P');
		$objPHPExcel->getActiveSheet()->setTitle($tabla);
		//$objWriter->setSheetIndex(0)->set;
		// Primero Cargo los Titulos
		//PHPExcel_Style_Font ->setUnderline()
		$columnaExcel	= 0;
		foreach ($importarCampos as $clave => $valor)
		{	$columnaLet = $this->getNumeroALetra($columnaExcel);
			$columna	=  $columnaLet. '1';
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaExcel, 1, $clave);
			// Letras en Negrita
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFont()->setBold(true);
			// Letras en color Blanco
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFont()->getColor()->setARGB('FFFFFFFF');
			// Ancho de columna automatica
			//$objPHPExcel->getActiveSheet()->getColumnDimension($columnaLet)->setWidth(strlen($clave)+4);
			// Alinear al Centro
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// Fondo en negro para titulos
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
			
			$columnaExcel++;	
		}
		// Cargo los datos de la consulta
		$resMysql	= $this->modelo->consultaSimple($consulta);
		$fila		= $resMysql->fetch_object();
		$filaExcel  	= 2;
		while($fila)
		{	$columnaExcel	= 0;
			foreach ($importarCampos as $clave => $valor)
			{	
                $imprimir	= utf8_encode($fila->$clave);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaExcel, $filaExcel, $imprimir);
				$columnaExcel++;
			}
			$filaExcel++;
			$fila		= $resMysql->fetch_object();
		}
		// Configuro las Columnas al mas Grande
		$cnt			= count($importarCampos);
		for($f=0;$f<$cnt;$f++)
		{	$columna	= $this->getNumeroALetra($f);
			$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
		}
		// lanzamos el exel para descargar
		$archivo	= $base . '_' .$tabla . '.' . $this->tipoXls[$tipo]['ext'] ;
		header('Content-Type: ' . $this->tipoXls[$tipo]['mime']);
		header('Content-Disposition: attachment;filename="' . $archivo . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $tipo);
		$objWriter->save('php://output');
                // prueba pdf-html-csv
                //$objWriter2 = new PHPExcel_Writer_HTML($objPHPExcel);
                //$objWriter2->save("05featuredemo.html");

                
                
		//si quisieramos guardarlo en el servidor usariamos las siguientes lineas
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$tipo);
		//$objWriter -> save('planillas/Archivo_salida.xlsx');
	}
	
	public function getCamposDeTabla()
	{	$base			= $this->modelo->escaparMysql($_POST['base']);
		$tabla			= $this->modelo->escaparMysql($_POST['tabla']);
		$consulta		= 'SHOW fields FROM ' . $base . '.' . $tabla;
		$resMysql		= $this->modelo->consultaSimple($consulta);
		
		$fila			= $resMysql->fetch_object();
		$json			= array();
		while($fila)
		{	$json[]		= array('valor'			=> $fila->Field,
								'comentario'	=> $fila->Field,
								'titulo'		=> $fila->Field);
			$fila		= $resMysql->fetch_object();
		}
		//sort($json);
		echo json_encode($json);
	}
	
	public function formExperto()
	{	if(!$_SESSION['OP_CONECT'])
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
		}	
		
		$this->vista->cargar(array('plantilla' => 'sqlTexto.tpl'));
		$this->vista->AsignarVar('version'		, DM3P_VRSN);
		$this->vista->AsignarVar('error'		, isset($_GET['error'])? $_GET['error'] : null);
		$this->vista->AsignarVar('consultaSQL'	, isset($_GET['sqlTexto'])? $_GET['sqlTexto'] : null);
		// Verifico que este activada la extencion php_zip
		$zip		= extension_loaded('zip');
		if(!$zip)
		{	$this->vista->AsignarVar('php_zip' 	, 'La extencion	PHP php_zip debe estar instalada.');	}
		// Fin Carga de Variables
		$this->vista->mostrar('plantilla');
		// Cargo los Archivos JavaScript Necesarios
		$this->cargarJS(DIR_OPET, 'jquery-1.3.2.min.js');
		$this->cargarJS(DIR_MDLAC, 'formExperto.js');
		
	}
	
	public function sqlTexto()
	{	$tipo			= $this->modelo->escaparMysql($_POST['tipo']);
		$consulta		= $_POST['sqlTexto'];
		$consulta		= trim($consulta);
		$consultas		= explode(';',$consulta);
		$consulta		= $consultas[0];
		$select			= strtoupper(substr($consulta,0,6));
		if(!$consulta || $select!='SELECT')
		{	$error	= 'No se reconocio su consulta.';
			$url	= 'index.php?mdl=deame3p&ctr=Importar&acc=formExperto&error=' . $error . '&sqlTexto=' . $consulta;
			header('Location: ' . $url);
			return false;
		}
		$this->importarConsultaAExcel($consulta,$tipo);
		return true;
	}
	
	private function importarConsultaAExcel($consulta,$tipo,$base='',$tabla='')
	{	include_once( DIR_OPET . DIR_UTILI . 'PHPExcel.php' );
		include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/IOFactory.php');
		// Configuro Variables del Servidor
		include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
		new configPhpIni();
		//Creamos un objeto PHPExcel
		$objPHPExcel = new PHPExcel();
		// Cargamos propiedades del Excel
		$objPHPExcel->getProperties()->setCreator('DEAME3P V.' . DM3P_VRSN);
		$objPHPExcel->getProperties()->setLastModifiedBy('DEAME3P V.' . DM3P_VRSN);
		$objPHPExcel->getProperties()->setTitle('Generando desde Mysql con DEAME3P');
		$objPHPExcel->getProperties()->setSubject('Generando desde Mysql con DEAME3P');
		$objPHPExcel->getProperties()->setDescription("Generado usando PHP classes.");
		$objPHPExcel->getProperties()->setKeywords("deame3p excel mysql importar exportar php");
		$objPHPExcel->getProperties()->setCategory('DEAME3P');
		$objPHPExcel->getActiveSheet()->setTitle('Consulta Experto');
		// Cargo los datos de la consulta
		$resMysql	= $this->modelo->consultaSimple($consulta);
		if(!$resMysql)
		{	$error	= $this->modelo->getMysqli()->error;
			$url	= 'index.php?mdl=deame3p&ctr=Importar&acc=formExperto&error=' . $error . '&sqlTexto=' . $consulta;;
			header('Location: ' . $url);
			return false;
		}
		$fila		= $resMysql->fetch_array(MYSQLI_ASSOC);
		$titulos	= $fila;
        // VER ESTE CODIGO PARA REEMPLAZAR
        if (!is_array($titulos)) {
			$titulo		= 'ERROR !!!';
			$mensaje 	= 'No se pudieron resolver los titulos.<br />El archivo excel no puede generarse.';
			include_once(DIR_OPET . DIR_CONTR . 'ErrorControl.php');
			$obj_controlador		= new ErrorControl( DIR_OPET , 'ErrorControl','errorGenerico');
			$obj_controlador->errorGenerico($titulo,$mensaje);
			return false;
        }
		// Primero Cargo los titulos
		$columnaExcel	= 0;
		foreach ($titulos as $clave => $valor)
		{	$columnaLet = $this->getNumeroALetra($columnaExcel);
			$columna	=  $columnaLet. '1';
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaExcel, 1, $clave);
			// Letras en Negrita
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFont()->setBold(true);
			// Letras en color Blanco
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFont()->getColor()->setARGB('FFFFFFFF');
			// Ancho de columna automatica
			//$objPHPExcel->getActiveSheet()->getColumnDimension($columnaLet)->setWidth(strlen($clave)+4);
			// Alinear al Centro
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// Fondo en negro para titulos
			$objPHPExcel->getActiveSheet()->getStyle($columna)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF000000');
			
			$columnaExcel++;	
		}
		$cnt		= count($fila);
		$filaExcel  	= 2;
		while($fila)
		{	$columnaExcel	= 0;
			foreach ($fila as $clave => $valor)
			{	$imprimir	= $valor;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaExcel, $filaExcel, $imprimir);
				$columnaExcel++;
			}
			$filaExcel++;
			$fila		= $resMysql->fetch_array(MYSQLI_ASSOC);
		}
		// Configuro las Columnas al mas Grande
		for($f=0;$f<$cnt;$f++)
		{	$columna	= $this->getNumeroALetra($f);
			$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
		}
		// lanzamos el exel para descargar
		$nombre		= $base . '_' .$tabla;
		if($nombre=='_')
		{	$nombre	= 'ConsultaExperto.';	}
		$archivo	= $nombre . $this->tipoXls[$tipo]['ext'] ;
		header('Content-Type: ' . $this->tipoXls[$tipo]['mime']);
		header('Content-Disposition: attachment;filename="' . $archivo . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $tipo);
		$objWriter->save('php://output');
	}
	
	
	private function getNumeroALetra($numero)
	{	
        $cadena = '';
        do {
           $entero 	= (int)( $numero / 26 );
           $resto	= ( $numero % 26 );
           $cadena  = chr(65 + $resto) . $cadena;
            
           $numero  = $entero - 1 ; 
        } while ($entero);
        
        return $cadena;
	}
}