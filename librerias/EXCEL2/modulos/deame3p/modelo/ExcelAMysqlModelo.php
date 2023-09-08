<?php
/**
 * Responsable de formar las consultas mysql y ejecutarlas para realizar la exportacion.
 *  
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (05/09/2009)
 */
class ExcelAMysqlModelo extends GenericoModelo
{	/**
	 * Contiene una instancia de la clase exportar.
	 * @var		object
	 */
	private	$exportar;
	
	/**
	 * Contiene una instancia del objeto worksheet.
	 * @var 	object
	 */
	private	$workSheet;
	
	/**
	 * Modo de insercion.
	 * I = Solo INSERT
	 * U = Si clave duplicada UPDATE
	 * @var 	char
	 */
	private $modo;
	
	/**
	 * Contiene la cantidad de filas a exportar.
	 * @var 	integer
	 */
	private $cantFilas;

	/**
	 * Contiene la cantidad de columnas de la planilla excel.
	 * @var 	integer
	 */
	private $cantColum;
	
	/**
	 * Contiene el prearmado de la consulta INSERT.
	 * @var 	String
	 */	
	private $preConsulta		= "INSERT INTO ";
	
	/**
	 * Contiene el final de la consulta INSERT cuando el modo es U.
	 * @var 	String
	 * @deprecated
	 */
	private $duplicateKey		= " ON DUPLICATE KEY UPDATE ";
	
	/**
	 * Recupera los errores por tipo. el 0 es correcto.
	 * y despues cada error corresponde a un tipo.
	 * @var 	array
	 */
	private $errores			= array(0   => 0);
	
	/**
	 * Contador de las consultas que se van realizando.
	 * @var		Integer
	 */
	private $cntConsultas		= 0;
	
	/**
	 * Nombre de la tabla a la cual se exportaran los datos.
	 * @var		String
	 */
	private $tabla;
	
	/**
	 * Contiene el modo de visualizacion de Deame3p.
	 * @var		Integer
	 */
	private $modoDeame3p;
	
	/**
	 * Contiene la salida para el textarea en caso de ser necesaria.
	 * @var		String
	 */
	private $textArea			= "";
	
    
    /**
     * Especifica si se usaran funciones de usuario o no.
     * @var     Boolean 
     */
    private $usaFunciones = false;
    
    /**
     * Arreglo conteniendo como clave los nombre de los campos que tienen que exportarse
     * usando alguna Funcion.
     * @var     array 
     */
    private $funciones = array();
    
    /**
     * Contiene un objeto de la clase de usuario.
     * @var     Object 
     */
    private $objClaseFunciones;
    
    /**
     * Contiene el tiempo que duro la exportacion, en microsegundos.
     * @var integer 
     */
    private $tiempoScript;
    
    
	/**
	 * Comprueba y carga las variables necesarias para llevar adelante la exportacion.
	 *
	 * @param	object		$obj_Exportar	Es la instancia a la clase exportar. 
	 * @param 	object		$obj_Worksheet	Es la instancia a la clase excel.
	 * @param 	String		$tabla			nombre de la Tabla MySQL que recibira los datos.
	 * @param 	Integer		$modoDeame3p	Modo de visualizacion
	 * @param 	char		$modo			Es el modo de insercion.
	 */
	function comprobarSistema(Exportar $obj_Exportar, $obj_Worksheet,$tabla,$modoDeame3p,$modo='I')
	{	$this->dbMysqli->select_db($_SESSION['baseDeDatos']);
        $this->exportar				= $obj_Exportar;
		$this->workSheet			= $obj_Worksheet;
		$this->modoDeame3p			= $modoDeame3p;
		$this->tabla				= $tabla;
		$this->modo					= $modo;
		$this->cantFilas			= $obj_Worksheet->getHighestRow();
		$this->cantColum			= PHPExcel_Cell::columnIndexFromString($obj_Worksheet->getHighestColumn());
		// No utilizo Vista para que Tire los resultados antes
		echo '<br /><b> Se cargo el Modulo Insertar Correctamente.-';
		echo '<br /> Se Exportaran ' . ($this->cantFilas-1) . ' filas.-';
		echo '<br /> Cantidad maxima de columnas por fila ' . $this->cantColum . '.-</b><br />';
		echo '<br />';
		$this->preConsultaInsertar();
		$this->exportar();
	}
	
	/**
	 * Genera la parte Estatica de la consulta INSERT.
	 * INSERT INTO table ( campo1, ...., campoN) VALUES (
	 * @return 		String	Conteniendo la Cadena Inicial de INSERT.
	 */
	private function preConsultaInsertar()
	{
            $this->preConsulta.=" $this->tabla ( ";
            foreach ($this->exportar->getDatosPost() as $clave => $valor) {
                $this->preConsulta.="`$valor[2]`, ";
            }
            $this->preConsulta	= substr($this->preConsulta,0,strlen($this->preConsulta)-2);
            $this->preConsulta	= $this->preConsulta." ) VALUES (";
            
		return $this->preConsulta;	
	}
	
    /**
     * Carga en el Sistema las Funciones de usuario en caso de que sean usadas.
     * @return boolean 
     */
    private function loadFuncionesDeUsuario()
    {
        if ( strtolower(substr($_SESSION['funcionUsuario'], strlen($_SESSION['funcionUsuario'])-4)) == '.php')
        {
            $clase = substr($_SESSION['funcionUsuario'],0, strlen($_SESSION['funcionUsuario'])-4);
            
            if (file_exists('funciones/' . $clase . '.php') == false) {
                return false;
            }
            
            $this->usaFunciones = true;
            
            // Incluyo la Clase y la Instancio.
            require_once 'funciones/' . $clase . '.php';
            $this->objClaseFunciones = new $clase();
            
            $metodos = get_class_methods($clase);
            foreach ($metodos as $valor) {
                $this->funciones[$valor] = true;
            }      
        }
    }
    
	
	private function exportar()
	{
        $start = microtime(true);
        $this->loadFuncionesDeUsuario();
        if ($this->usaFunciones) {
            $this->exportarConFunciones();
        } else {
            $this->exportarSinFunciones();
        }
        
        if($this->modoDeame3p==4) {
            $this->textArea	= "<textarea  style='width:95%; font-family:'Trebuchet MS, Verdana' rows='15'  >".$this->textArea."</textarea>";
			echo $this->textArea;
		}
        
        $this->tiempoScript  = microtime(true)-$start;
	}
    
    public function getTiempoScript()
    {
        return $this->tiempoScript;
    }
    
    private function exportarSinFunciones()
    {
        $datosExport        = $_SESSION['patronExportacion'];
        $datosExport[0][0]  = $datosExport[0][0]+1; // Pues el titulo ya esta cargado
        foreach ($datosExport as $filas) {
            $ini    = $filas[0];
            $fin    = ($filas[1] > $this->cantFilas)? $this->cantFilas : $filas[1];
            
            for($fila=$ini; $fila <= $fin;$fila++) {
                // Preparo Variables de Generacion de Consultas
                $cargoDatos		= array();
                $consultaFin	= "";	
                $consultaUPDT	= "";
			    
                $filaDatos = array();
                foreach ($this->exportar->getDatosPost() as $clave => $datos) {
                    
                    $columna	= $datos[0]-1;
                    // Por defecto asumo que siempre se quiere exportar el valor crudo de excel
                    // Si es formula que se envia la formula. Esto lo hago por ser mucho mas ligero.
                    $valor      = $this->workSheet->getCellByColumnAndRow($columna, $fila)->getValue();

                    //$value = $objPHPExcel->getActiveSheet()->getCell('B8')->getCalculatedValue();
                    if ($_SESSION['formulaValor']) {
                        $valor  = $this->workSheet->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
                    }
                
                    $valor		= $this->exportar->formatearCampo($clave,$valor);
                    $filaDatos[$clave] = $valor;
                    $cargoDatos[]= array($datos[2],$valor);
                }
                
            	$cant			= count($cargoDatos);
                for($f=0;$f<$cant;$f++) {
                    $clave			= $cargoDatos[$f][0];
                    $valor			= $cargoDatos[$f][1];
                    $consultaFin	= $consultaFin." '".$valor."',";
                    $consultaUPDT	= $consultaUPDT." $clave = '".$valor."',";
                }
                
                $consultaFin	= substr($consultaFin,0,strlen($consultaFin)-1).")";
                if($this->modo=="U") {
                    $consultaUPDT	= substr($consultaUPDT,0,strlen($consultaUPDT)-1);
                    $consultaFin	= $consultaFin.$this->duplicateKey.$consultaUPDT;
                }
			
                $consultaFin	= $this->preConsulta.$consultaFin;
                $this->ejecutarConsulta($consultaFin);
            }
        } // export filtro
    }
    
    private function exportarConFunciones()
    {
        // Veo si tiene configuracion de inicio de Exportacion
        ($this->funciones['deame3p_inicio'])? $this->objClaseFunciones->deame3p_inicio() : null;
        
        $datosExport        = $_SESSION['patronExportacion'];
        $datosExport[0][0]  = $datosExport[0][0]+1; // Pues el titulo ya esta cargado
        foreach ($datosExport as $filas) {
            $ini    = $filas[0];
            $fin    = ($filas[1] > $this->cantFilas)? $this->cantFilas : $filas[1];
            
            for($fila=$ini; $fila <= $fin;$fila++) {
                // Preparo Variables de Generacion de Consultas
                $cargoDatos		= array();
                $consultaFin	= "";	
                $consultaUPDT	= "";
			    
                $filaDatos = array();
                foreach ($this->exportar->getDatosPost() as $clave => $datos) {
                    
                    $columna	= $datos[0]-1;
                    // Por defecto asumo que siempre se quiere exportar el valor crudo de excel
                    // Si es formula que se envia la formula. Esto lo hago por ser mucho mas ligero.
                    $valor      = $this->workSheet->getCellByColumnAndRow($columna, $fila)->getValue();

                    //$value = $objPHPExcel->getActiveSheet()->getCell('B8')->getCalculatedValue();
                    if ($_SESSION['formulaValor']) {
                        $valor  = $this->workSheet->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
                    }
                
                    if ($this->usaFunciones && isset($this->funciones[$clave])) {
                        $valor		= $this->objClaseFunciones->$clave($valor);
                    } else {
                        $valor		= $this->exportar->formatearCampo($clave,$valor);
                    }
                    $filaDatos[$clave] = $valor;
                    $cargoDatos[]= array($datos[2],$valor);
                }
                
            	$cant			= count($cargoDatos);
                for($f=0;$f<$cant;$f++) {
                    $clave			= $cargoDatos[$f][0];
                    $valor			= $cargoDatos[$f][1];
                    $consultaFin	= $consultaFin." '".$valor."',";
                    $consultaUPDT	= $consultaUPDT." $clave = '".$valor."',";
                }
                
                $consultaFin	= substr($consultaFin,0,strlen($consultaFin)-1).")";
                if($this->modo=="U") {
                    $consultaUPDT	= substr($consultaUPDT,0,strlen($consultaUPDT)-1);
                    $consultaFin	= $consultaFin.$this->duplicateKey.$consultaUPDT;
                }
			
                $consultaFin	= $this->preConsulta.$consultaFin;
                $estado         = $this->ejecutarConsulta($consultaFin);
                ($this->funciones['deame3p_fila'])? $this->objClaseFunciones->deame3p_fila($filaDatos, $estado) : null;
            }
        } // export filtro
        
        // Veo si tiene configuracion de Finalizacion de Exportacion
        ($this->funciones['deame3p_final'])? $this->objClaseFunciones->deame3p_final() : null;
    }
    
	/**
	 * Ejecuta una consulta Mysql, y verifica si salio bien o da error para pasarsela a las
	 * estadisticas.
	 * 
	 * @param 	String		$consulta	Consulta Mysql
	 * @return 	boolean
	 */
	private function ejecutarConsulta($consulta)
	{	if($this->modoDeame3p==4)
		{	$this->textArea.=$consulta."\n";
			return true;
		}
		$this->cntConsultas++;
		$sw_muestra			= false;
		$salidaPantalla		= "<table align='center' class='bordeTablaRedondeado' width='700' ><tr><td><samp class='bodytext'>";
		$salidaPantalla		= $salidaPantalla . '<b>Consulta N.:' . $this->cntConsultas . '</b><br />' . $consulta."<br />";
		$resultado			= $this->dbMysqli->query($consulta);
		if($resultado)
		{	$this->errores[0]++;
			$salidaPantalla	= $salidaPantalla."<b>Correcto</b>";
			$sw_muestra		= true;
		}
		else
		{	@$this->errores[$this->dbMysqli->errno]++;
			$salidaPantalla	= $salidaPantalla."<b>Error: </b>" . $this->dbMysqli->error;
		}
		$salidaPantalla		= $salidaPantalla."</samp></td></tr></table><br />";
			
		ob_start('mostrarPantalla', 12);
		switch ($this->modoDeame3p)
		{	case 1:	if($sw_muestra)		{	echo $salidaPantalla;	}
					break;
			case 2: if(!$sw_muestra) 	{	echo $salidaPantalla;	} 
					break;
			case 3: echo $salidaPantalla;
					break;
			case 4: $this->textArea.=$consulta."\n";
		}
		@ob_end_flush();
        return $sw_muestra;
	}
	
	/**
	 * Muestra por Pantalla lo almacenda en el bufer mediante la funcion ob_start().
	 * @param		String		$bufer	Contenido de salida HTML capturado.
	 * @return 		void		volcado a pantalla del HTML capturado.
	 */
	private function mostrarPantalla($bufer)
	{	echo $bufer;	}

	/**
	 * Retorna un arreglo con los errores o exitos producidos y su codigo de error.
	 * El 0 (cero) es correcto.
	 * 
	 * @return		Array	Arreglo con los errores.
	 */
	public function getErrores()
	{	return $this->errores;	}


    public function reset()
    {
       $this->exportar          = null;
       $this->workSheet         = null;
       $this->cantFilas         = null;
       $this->cantColum         = null;
       $this->preConsulta		= "INSERT INTO ";
       $this->duplicateKey		= " ON DUPLICATE KEY UPDATE ";
       unset($this->errores);
       $this->errores			= array(0   => 0);
       $this->cntConsultas		= 0;
       $this->textArea			= "";
       return;
    }
}