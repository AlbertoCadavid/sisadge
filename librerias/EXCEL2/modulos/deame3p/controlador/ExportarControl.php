<?php
/**
 * Se encarga de generar los formularios y obtener los cabezales correspondientes.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (05/09/2009)
 * @version		1.1.0 (08/09/2009) funcion titulosExcel2().
 */
class ExportarControl extends GenericoControl
{
    /**
     * Contiene los intervalos de exportacion.
     * @var array
     */
    private $_intervalo = array();

    private $_hojas     = array();


	/**
	 * Genera el formulario de Opciones de Exportacion.
	 * @return 	void		Salida HTML
	 */
	public function form()
	{	if(!isset($_SESSION['OP_CONECT']))
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
		}
		unset($_SESSION['columnas']);
		$this->vista->cargar(array('plantilla' => 'formularioExportacion.tpl'));
		$this->vista->AsignarVar('version', DM3P_VRSN);
		// Verifico que este activada la extencion php_zip
		$zip		= extension_loaded('zip');
		if(!$zip)
		{	$this->vista->AsignarVar('php_zip' 	, 'La extencion	PHP php_zip debe estar instalada.');	}
		$this->vista->mostrar('plantilla');
		// Cargo los Archivos JavaScript Necesarios
		$this->cargarJS(DIR_OPET, 'jquery-1.3.2.min.js');
		$this->cargarJS(DIR_MDLAC, 'formExportacion.js');
	}
	
	public function phpini()
	{	// Variables de Configuracion php.ini
		$this->vista->cargar(array('plantilla' => 'phpini.tpl'));
		if(isset($_SESSION['OP_CONECT']) && $_SESSION['OP_CONECT'])
		{	// Configuro Variables del Servidor
			$phpiniForm						= isset($_POST['phpiniConfig'])? $_POST['phpiniConfig'] : null ;

            if($phpiniForm)
			{	$_SESSION["tiempoLimite"]	= $_POST['tiempoLimiteScript'];
				$_SESSION["limiteMemoria"]	= $_POST['limiteMemoria'];
 
                    $suma       = 0;
                    $errores    = isset($_POST['E_ERROR'])? $_POST['E_ERROR'] : array();
                    foreach ($errores as $valor) {
                        $suma += $valor;
                    }
                    $_SESSION['mostrarErrores'] = $suma;
			}
            // Prendo los checkbox seleccionados
            $byte       = decbin ( isset($_SESSION['mostrarErrores'])? $_SESSION['mostrarErrores'] : 0 );
            $cadena     = strrev( (string)$byte);
            $largo      = strlen($cadena);
            for ($error = 0; $error<$largo; $error++) {
                $nombre = 'chequed_' . ($error + 1);
                $numero = (int) substr($cadena, $error,1);
                if ($numero) {
                    $this->vista->AsignarVar($nombre , 'checked');
                }

            }
			include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
			new configPhpIni();
			$datos		= array();
			$this->vista->AsignarBlocke('conexion', array());
            $this->vista->AsignarVar('e1'       , (defined('E_ERROR'))?             E_ERROR             : 'N/D');
            $this->vista->AsignarVar('e2'       , (defined('E_WARNING'))?           E_WARNING           : 'N/D');
            $this->vista->AsignarVar('e3'       , (defined('E_PARSE'))?             E_PARSE             : 'N/D');
            $this->vista->AsignarVar('e4'       , (defined('E_NOTICE'))?            E_NOTICE            : 'N/D');
            $this->vista->AsignarVar('e5'       , (defined('E_CORE_ERROR'))?        E_CORE_ERROR        : 'N/D');
            $this->vista->AsignarVar('e6'       , (defined('E_CORE_WARNING'))?      E_CORE_WARNING      : 'N/D');
            $this->vista->AsignarVar('e7'       , (defined('E_COMPILE_ERROR'))?     E_COMPILE_ERROR     : 'N/D');
            $this->vista->AsignarVar('e8'       , (defined('E_COMPILE_WARNING'))?   E_COMPILE_WARNING   : 'N/D');
            $this->vista->AsignarVar('e9'       , (defined('E_USER_ERROR'))?        E_USER_ERROR        : 'N/D');
            $this->vista->AsignarVar('e10'      , (defined('E_USER_WARNING'))?      E_USER_WARNING      : 'N/D');
            $this->vista->AsignarVar('e11'      , (defined('E_USER_NOTICE'))?       E_USER_NOTICE       : 'N/D');
            $this->vista->AsignarVar('e12'      , (defined('E_STRICT'))?            E_STRICT            : 'N/D');
            $this->vista->AsignarVar('e13'      , (defined('E_RECOVERABLE_ERROR'))? E_RECOVERABLE_ERROR : 'N/D' );
            $this->vista->AsignarVar('e14'      , (defined('E_DEPRECATED'))?        E_DEPRECATED        : 'N/D' );
            $this->vista->AsignarVar('e15'      , (defined('E_USER_DEPRECATED'))?   E_USER_DEPRECATED   : 'N/D' );
            //$this->vista->AsignarVar('e16'      , (int)E_ALL);
		}
		else
		{	$mensaje	= 	'Si quieres configurar las variables de servidor, tienes que conectarte.<br />
							Para ello en el menu en la opcion Servidor elige conectar.<br />
							Gracias.';
			$this->vista->AsignarVar('mensajeconfiguracion',$mensaje);
		}

		$tiempo		= (ini_get('max_execution_time')==0)?'ilimitados ':ini_get('max_execution_time');
		$this->vista->AsignarVar('tiempo' 		, $tiempo );	
		$this->vista->AsignarVar('memoria' 		, intval(ini_get('memory_limit')));
		$this->vista->AsignarVar('formulario'	, intval(ini_get('post_max_size')));
		$this->vista->AsignarVar('archivo'		, intval(ini_get('upload_max_filesize')));
		// Fin Carga de Variables
		$this->vista->mostrar('plantilla');
        // Cargo los Archivos JavaScript Necesarios
		$this->cargarJS(DIR_OPET, 'jquery-1.3.2.min.js');
        $this->cargarJS(DIR_OPET, 'jquery.checkbox.js');
		$this->cargarJS(DIR_MDLAC, 'phpini.js');
	}
	
	/**
	 * Genera el formulario de Relacionar campos.
	 * @return		void		Salida HTML
	 */
	public function relaciones()
	{
        $urlTestigo     = DIR_BASE . '/index.php?mdl=deame3p&ctr=Exportar&acc=form';
		$urlThis        = $_SERVER['REQUEST_URI'];
        $urlAnterior     = $_SERVER['HTTP_REFERER'];
		$posicion		= strripos($urlAnterior, $urlTestigo);
		if(strripos($urlAnterior, $urlTestigo) === false && strripos($urlAnterior, $urlThis) === false) {
            $this->vista->cargar(array('plantilla' => 'errorSistema.tpl'));
			$this->vista->AsignarVar('encabezado'	, 'ERROR !!!');
			$this->vista->AsignarVar('mensaje'		, 'Faltan datos para llevar adelante la tarea.');
			$this->vista->mostrar('plantilla');
			return false;
		}
		
		// Levanto Variables del Formulario.
		$baseDeDatos				= isset($_POST['baseDeDatos'])?         $_POST['baseDeDatos']       : null;
		$tabla						= isset($_POST['tabla'])?               $_POST['tabla']             : null;
		$_SESSION['baseDeDatos']	= $baseDeDatos;
		$_SESSION['tabla']			= $tabla;
		$_SESSION['borrarArchivo']	= isset($_POST['borrarArchivo'])?       $_POST['borrarArchivo']     : null;
		$_SESSION['modoDeame3p']	= isset($_POST['modoDeame3p'])?         $_POST['modoDeame3p']       : null;
		$_SESSION['funcionesDeame3p']= isset($_POST['funcionesDeame3p'])?   $_POST['funcionesDeame3p']  : null;
		$_SESSION['funcionUsuario']	= isset($_POST['funciones'])?           $_POST['funciones']         : null;
		$_SESSION['codificacion']	= isset($_POST['codificacion'])?        $_POST['codificacion']      : null;
		$_SESSION['tiempoLimite']	= isset($_POST['tiempoLimiteScript'])?  $_POST['tiempoLimiteScript']: null;
		$_SESSION['limiteMemoria']	= isset($_POST['limiteMemoria'])?       $_POST['limiteMemoria']     : null;
		$archivo					= isset($_POST['planServ'])?            $_POST['planServ']          : null;
        $patronExportacion          = isset($_POST['patronExportacion'])?   $_POST['patronExportacion'] : null;

        $this->vista->AsignarVar('baseDeDatos'          , $_SESSION['baseDeDatos']);
        $this->vista->AsignarVar('tabla'                , $_SESSION['tabla']);
        $this->vista->AsignarVar('borrarArchivo'        , $_SESSION['borrarArchivo']);
        $this->vista->AsignarVar('modoDeame3p'          , $_SESSION['modoDeame3p']);
        $this->vista->AsignarVar('funcionesDeame3p'     , $_SESSION['funcionesDeame3p']);
        $this->vista->AsignarVar('funciones'            , $_SESSION['funcionUsuario']);
        $this->vista->AsignarVar('codificacion'         , $_SESSION['codificacion']);
        $this->vista->AsignarVar('tiempoLimite'         , $_SESSION['tiempoLimite']);
        $this->vista->AsignarVar('limiteMemoria'        , $_SESSION['limiteMemoria']);
        $this->vista->AsignarVar('planServ'             , $archivo);
        $this->vista->AsignarVar('patronExportacion'    , $patronExportacion);
        $hojaIndex                  = isset($_POST['hojasExcel'])? $_POST['hojasExcel'] : 0;
        $_SESSION['hojaExcel']      = $hojaIndex;

		// Configuro Variables del Servidor
		include( DIR_MDLAC . DIR_UTILI . 'configPhpIni.php');
		new configPhpIni();
		// Veo si Cargo el Archivo o uso uno que este en el servidor.
		if(!$archivo)
		{	include_once( DIR_SITIO . DIR_OPET . DIR_UTILI . 'CargarArchivo.php');	
    		$obj_CargarArch    = new CargarArchivo("archivo","planillas/");    
    		$obj_CargarArch    ->agregarTiposArchivos("application/excel");
    		$obj_CargarArch    ->agregarTiposArchivos("application/vnd.ms-excel");
    		$obj_CargarArch	   ->agregarTiposArchivos("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
   	 		$obj_CargarArch    ->setNulo(true);
    		$obj_CargarArch    ->setAccion("remplazar");
    		$obj_CargarArch    ->subir();
    		//$obj_CargarArch    ->getErrores();
    
    		if($obj_CargarArch->getErrores())
    		{	$this->vista->cargar(array('plantilla' => 'errorSistema.tpl'));
				$this->vista->AsignarVar('encabezado', 'ERROR !!!');
    			$mensaje    = $obj_CargarArch->getErrores().'<br /><br />';
    			$this->vista->AsignarVar('mensaje', $mensaje);
				$this->vista->mostrar('plantilla');
         		return false;
    		}
    		$filename          	= $obj_CargarArch    ->getNombreDestino();
    		$tipo				= $this->getTipoDeMime($obj_CargarArch->getTipoArchivo());
		}
		else
		{	$filename			= $_POST["planServ"];
			$tipo				= $this->getTipoDeExtencion($filename);
		}
			
		if(!file_exists('planillas/' . $filename))
		{	$titulo		= 'ERROR !!!';
			$mensaje 	= 'No se pudo subir el archivo en el servidor';	
			include_once(DIR_OPET . DIR_CONTR . 'ErrorControl.php');
			$obj_controlador		= new ErrorControl( DIR_OPET , 'ErrorControl','errorGenerico');
			$obj_controlador->errorGenerico($titulo,$mensaje);
			return false;
		}
        // Por las dudas verifico que sea de mime type correcto
        // Veo que funcion puedo utilizar pues depende del phps
        /*$mimeContent    = null;
        if (function_exists('finfo_file')) {
            echo 'Utilizo finfo_file';
        } else {
            $mimeContent = mime_content_type('planillas/' . $filename);
        }

        echo $mimeContent;*/

        $this->vista->AsignarVar('archivo'      , $archivo);

		$_SESSION['archivoExcel']	= $filename;
		$_SESSION['tipoExcel']		= $tipo;
        ############################################
        // Veo si envio algun patron de exportacion
        $_SESSION['patronExportacion']  = $this->_analizarPatron($patronExportacion);

        if ($_SESSION['patronExportacion'][0][0] != 1) {
            // Este metodo funciona para los dos
            $titulosExcel			= $this->titulosExcelPatron($tipo, $filename, $_SESSION['patronExportacion'][0][0], $hojaIndex);
        } elseif ($tipo == 'Excel2007') {
            $titulosExcel			= $this->titulosExcel2($tipo, $filename , $hojaIndex);
        } else {
            $titulosExcel			= $this->titulosExcel($tipo, $filename , $hojaIndex);
        }
        
        // Cargo los nombres de las hojas de calculo.
        foreach ($this->_hojas as $index => $hoja) {
            $seleccionado   = '';
            if ($index == $hojaIndex) {
                $hojaSeleccionada   = $hoja;
                $seleccionado       = 'selected="selected"';
            }

            $linea  = array('nombre'        => $hoja,
                            'valor'         => $index,
                            'seleccionado'  => $seleccionado);
            
            $this->vista->AsignarBlocke('hojasExcel',    $linea);
        }
        //$hojaSeleccionada = isset($_POST['hojasExcel'])? $_POST['hojasExcel'] : $this->_hojas[0];

        // Fin carga de nombres de hoja de calculo.

		$camposMySQL 				= $this->infoMysql($baseDeDatos, $tabla);
		$cantidadExcel				= count($titulosExcel)+1;

		$this->vista->cargar(array('plantilla' => 'formularioRelaciones.tpl'));
		$this->vista->AsignarVar('version'          , DM3P_VRSN);
		$this->vista->AsignarVar('planServ'          , $_SESSION['archivoExcel']);
        $this->vista->AsignarVar('hojaExcel'        , $hojaSeleccionada);
		$this->vista->AsignarVar('base'             , $baseDeDatos);
		$this->vista->AsignarVar('tabla'            , $tabla);
		$this->vista->AsignarVar('cantidad'         , count($camposMySQL));
        $this->vista->AsignarVar('patronSugerido'   , $patronExportacion);
        $this->vista->AsignarVar('patron'           , json_encode($_SESSION['patronExportacion']));

		foreach ($camposMySQL as $nombre => $MySQLPropiedades)
		{	$linea          = array('nombreMySQL'		    => $nombre);
    		$this->vista->AsignarBlocke('formulario',$linea);
    		$indice         = 2;
    		foreach($camposMySQL[$nombre] as $propiedad => $valor)
    		{	$linea       = array(	"valor"      => $valor,
    	 								"indice"	  => $indice); 
         		$this->vista->AsignarBlocke('formulario.propiedades',$linea);
         		$indice++;
    		}
    		$cargoSelect    = array();
			for($f=1;$f<$cantidadExcel;$f++)
			{	$seleccion      = "";
	    		if(strtolower($nombre)==strtolower($titulosExcel[$f-1]))
	    		{	$seleccion    	= "selected"; }
					$cargoSelect	= array("nroColumnaExcel"	    => $f,
											"nombreColumnaExcel"	=> $titulosExcel[$f-1],
											"selected"				=> $seleccion);
	    		$this->vista->AsignarBlocke("formulario.select",$cargoSelect);
			}
			#### Veo el Select de Opciones ####
			// Codigo para Clave Primaria
			$activo        = "disabled";
			$sw_select     = 0;
    		if($MySQLPropiedades["clave"]=="PRI" && $MySQLPropiedades["extra"]=="auto_increment")	
    		{	$cargoSelectOp  = array("valor"=>"1","texto"=>"Llenado Automatico");
         		$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelectOp);
         		$cargoSelectOp  = array("valor"=>"2","texto"=>"Insertar de Excel");
         		$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelectOp);
        		$activo          = "";
        		$sw_select       = 1;
    		}
			// Codigo para Clave de Tabla
			if($MySQLPropiedades["clave"]=="UNI")
			{	$cargoSelectOp  = array("valor"=>"0","texto"=>"Clave de Tabla");
         		$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelectOp);    
	     		$sw_select      =1;
			}
			// Codigo para Claves Foraneas
			if($MySQLPropiedades["claveForanea"])
			{   $campoClaveFor	= $MySQLPropiedades["nombre"];
				$tablaCF		= $MySQLPropiedades["claveForanea"]; 
	    		$consulta    	= "SHOW fields FROM ".$tablaCF." FROM ".$baseDeDatos;
	    		$resultado   	= $this->modelo->consultaSimple($consulta);
	    		$cargoSelect 	= array();
	    		$cargoSelect	= array("valor"	    => 0,
										"texto"		=> "Cargar desde Excel");
	    		$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelect);
	    		$linea			= $resultado->fetch_array();
	    		while($linea)
	    		{	$campoT    		= $linea['Field'];
	    			if($campoT!=$campoClaveFor)
	    			{	$cargoSelect	= array("valor"	    => $campoT.".".$tablaCF,
												"texto"		=> $campoT);
	        			$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelect);
	    			}
	        		$linea			= $resultado->fetch_array();
	    		}
	    		$sw_select        =1;
			}
			// Codigo si no hay nada para optar
			if(!$sw_select)
			{	$cargoSelectOp  = array("valor"=>"0","texto"=>"Sin Opciones");
         		$this->vista->AsignarBlocke("formulario.selectOpciones",$cargoSelectOp);    
			}
			#### Fin Cargo Opciones Select ####	
		}
		$this->vista->mostrar('plantilla');
		$this->cargarJS(DIR_MDLAC, 'formRelaciones.js');
	}
	
	/**
	 * Nos retorna los titulos de una planilla Excel.
	 * @param 	$tipo			String		puede ser Excel2007 o Excel5.
	 * @param 	$archivoExcel 	String		Nombre del archivo a examinar.
	 * @return 					array		Contiene los titulos de la planilla Excel.
	 * @deprecated				Sustituida por titulosExcel2() el 08/09/2009.
	 * 							Mejora performance de carga de titulos. Ej. hoja con 150463 lineas
	 * 							Pasa a Cargarse de 2.01 minutos a 8 segundos
	 * 							Usada en linea 108.-
	 */
	private function titulosExcel($tipo,$archivoExcel, $hoja = 0)
	{	include_once( DIR_OPET . DIR_UTILI . 'PHPExcel.php');
		include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/IOFactory.php');
		$objReader 		= PHPExcel_IOFactory::createReader($tipo);
		$objReader		->setReadDataOnly(true);
		$objPHPExcel 	= $objReader->load('planillas/' . $archivoExcel);
		$objPHPExcel    ->setActiveSheetIndex($hoja);
        $objWorksheet   = $objPHPExcel->getActiveSheet();
		$_SESSION['columnas']	= PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());

		$titulosExcel	= array();
		foreach ($objWorksheet->getRowIterator() as $row)
		{	$cellIterator = $row->getCellIterator();
  			$cellIterator->setIterateOnlyExistingCells(false);
  			foreach ($cellIterator as $cell)
  			{	$titulosExcel[]	=  $cell->getValue();	}
  			break;
		}
        
        $this->_getHojas($objPHPExcel);
		return $titulosExcel;
	}
	
	private function titulosExcel2($tipo,$archivoExcel, $hoja = 0)
	{	include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel.php');
		include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel/IOFactory.php');
		include_once( DIR_MDLAC . DIR_UTILI . 'TitulosExcel.php');

		$objReader 				= PHPExcel_IOFactory::createReader($tipo);
		$objReader				->setReadFilter( new TitulosExcel() );
		$objPHPExcel 			= $objReader->load('planillas/' . $archivoExcel	);
        $objPHPExcel            ->setActiveSheetIndex($hoja);
		$objWorksheet 			= $objPHPExcel->getActiveSheet();
		$_SESSION['columnas']	= PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
        
		$titulosExcel	= array();
		foreach ($objWorksheet->getRowIterator() as $row)
		{	$cellIterator = $row->getCellIterator();
  			$cellIterator->setIterateOnlyExistingCells(false);
  			foreach ($cellIterator as $cell)
  			{	$titulosExcel[]	=  $cell->getValue();	}
		}
        $this->_getHojas($objPHPExcel);
		return $titulosExcel;
	}

    private function titulosExcelPatron($tipo, $archivoExcel, $filaTitulo, $hoja = 0)
    {
        include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel.php');
		include_once( DIR_OPET  . DIR_UTILI . 'PHPExcel/IOFactory.php');

		$objReader 				= PHPExcel_IOFactory::createReader($tipo);
        $objPHPExcel 			= $objReader->load('planillas/' . $archivoExcel	);
        $objPHPExcel            ->setActiveSheetIndex($hoja);
        $objWorksheet 			= $objPHPExcel->getActiveSheet();
        $_SESSION['columnas']	= PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());

		$titulosExcel	= array();
        for ($col = 0; $col < $_SESSION['columnas']; ++$col) {
            $titulosExcel[]     = $objWorksheet->getCellByColumnAndRow($col, $filaTitulo)->getValue();
        }

        $this->_getHojas($objPHPExcel);
		return $titulosExcel;
    }

    private function _getHojas($objPHPExcel)
    {
        $this->_hojas = $objPHPExcel->getSheetNames();
        return $this->_hojas;
    }
	
	/**
	 * Conecta con la clase InfoCampos para obtener informacion, de los campos de una tabla mysql.
	 * @param 	String		$base	Contiene el nombre de la base de datos.
	 * @param 	String		$tabla	Contiene el nombre de la tabla de datos.
	 * @return 	Object 		InfoCampo
	 */
	private function infoMysql($base,$tabla)
	{	$conexion				= $this->modelo->getMysqli();
		include_once( DIR_OPET . DIR_UTILI . 'InfoCampos.php');
		$obj_infoCampo    		= new InfoCampos($conexion,$base,$tabla);
		return	$obj_infoCampo   ->getArrayCampos();
	}
	
	/**
	 * Es responsable de Decirnos si es un excel 2007 o anterior a partir del mimetype del archivo.
	 * @param 	$mimeType		String
	 * @return	String			Retorna Excel2007,Excel5, o vacio.
	 */
	private function getTipoDeMime($mimeType)
	{	switch ($mimeType)
		{	case 'application/excel':
			case 'application/vnd.ms-excel':
				$tipo		= "Excel5";
				break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				$tipo		= "Excel2007";
				break;
			default:
				break;
		}
		return $tipo;
	}
	
	/**
	 * Es responsable de Decirnos si es un excel 2007 o anterior a partir de la extencion del archivo.
	 * @param 	$archivo		String	Contiene el nombre del archivo.
	 * @return	String			Retorna Excel2007,Excel5, o vacio.
	 */
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

    /**
     * Metodo _analizarPatron.
     * Comienza la preparacion para el analisis, no lo efectua delega el analisis
     * pero prepara los datos.
     * @param   string  $patron     patron tipo: 1-150,3000-5000,9000-*
     *                              * representa hasta el final
     * @return  array
     */
    private function _analizarPatron($patron)
    {
        if (!$patron) {
            $this->_intervalo[]   = array(1, MAXIMAS_FILAS_EXCEL);
            return $this->_intervalo;
        }
        $patron         = str_replace(' ', '', $patron);
        $salida         = array();
        $patrones       = explode(',', $patron);
        foreach ($patrones as $limites) {
            if ( preg_match('/^([0-9]+)(\-\*|(\-[0-9]+))?$/', $limites)) {
                $limite     = explode('-', $limites);
                $limiteIni  = ( is_numeric($limite[0]))?  $limite[0] : 1;
                
                if (!isset($limite[1])) {
                    $limiteFin = $limiteIni;
                } elseif (is_numeric($limite[1])) {
                    $limiteFin = $limite[1];
                } else {
                    $limiteFin = MAXIMAS_FILAS_EXCEL;
                }
                $limiteFin  = ($limiteFin < $limiteIni)? $limiteIni : $limiteFin;
                $salida[]   = array((int)$limiteIni , (int) $limiteFin);
            }
        }

        if (!count($salida)) {
            $this->_intervalo[]   = array(1, MAXIMAS_FILAS_EXCEL);
            return $this->_intervalo;
        }

        // Ordeno por clave minimo o sea [0]
        foreach ($salida as $ordenado) {
            $tmpArray[] = $ordenado[0];
        }
        array_multisort($tmpArray, SORT_ASC, SORT_NUMERIC, $salida);

        $this->_patron($salida);
        return $this->_intervalo;
    }

    /**
     * Metodo _patron.
     * Realiza el arreglo final una vez analizado el patron.
     * @param   array   $patron     arreglo ordenado por pares.
     * @return  void
     */
    private function _patron($patron)
    {
        $salida         = $patron;
        $intervalos     = count($salida);
        $salidaFinal    = array();
        for ($i = 0; $i < $intervalos ; $i++) {
            $f      = $i+1;
            $min    = $salida[$i][0];
            $max    = $salida[$i][1];

            if ($f == $intervalos) {
                $salidaFinal[]  = array($min, $max);
                continue;
            }

            /* Si se cumple quiere decir que el intervalo menor encierra al
             * intervalo mayor, por lo cual solo necesito el primero.
             */
            if ($max >= $salida[$f][1]) {
                $salidaFinal[]  = array($min, $max);
                $salida[$f]     = array($min, $max);
                $i++;
                continue;
            } elseif ($max >= $salida[$f][0]) {
                /* Veo que el max del intervalo menor no sobrepase el minimo del
                 * mayor
                 */
                $salidaFinal[]  = array($min, $salida[$f][1]);
                $salida[$f]     = array($min, $max);
                $i++;
                continue;
            } else {
                $salidaFinal[]  = array($min, $max);
            }
        }

        $cantidad   = count($salidaFinal);
        if ($cantidad < $intervalos) {
            $this->_patron($salidaFinal);
        } else {
            $this->_intervalo = $salidaFinal;
            return;
        }
    }
}