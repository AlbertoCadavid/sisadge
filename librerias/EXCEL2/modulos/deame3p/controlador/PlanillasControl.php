<?php
/**
 * Se encarga de administrar las planillas del sistema.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		0.1.0 (09/10/2009) funcion titulosExcel2().
 */
class PlanillasControl extends GenericoControl
{
	/**
	 * Contiene el directorio donde se guardaan las planillas
	 * @var	String		Contiene el directorio donde se alojan las planillas.
	 */
	private	$directorio		= 'planillas/';
	
	/**
	 * Contiene los posibles errores que se pueden dar al borrar el archivo.
	 * @var String
	 */
	private $errores		= '';

	public function admArchivos()
	{	
        if(!isset($_SESSION['OP_CONECT']))
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
		}
        
        //// Eliminamos todos los que vengan chequeados
		$archivo	= isset($_POST['planillaEliminar'])? $_POST['planillaEliminar'] : null ;
		if(is_array($archivo))
		{	foreach($archivo as $clave => $valor)
			{	$this->borrarAchivo($this->directorio,$valor);	}	
		}
	
		$this->vista->cargar(array('plantilla' => 'planillas.tpl'));
		$this->vista->AsignarVar('version', DM3P_VRSN);
		$this->vista->AsignarVar('errores', $this->errores);

        // Levanto los archivos
        include_once DIR_OPET . DIRECTORY_SEPARATOR .  DIR_UTILI . DIRECTORY_SEPARATOR . 'Directorio.php';
		$objDirectorio  	= new Directorio('planillas/');
        $objDirectorio->setProfundidadEscaneo(0);
        // Tipos de extenciones a mostrar
        $objDirectorio->addTiposArchivosListar('xls');
        $objDirectorio->addTiposArchivosListar('xlsx');
        // Configuramos solo para ver archivos
        $objDirectorio->setListarDirectorios(2);
        // recorremos el directorio
        $objDirectorio->listar();
        $archivos           = $objDirectorio->ordenar('nameSort', true);

        if (!is_array($archivos)) {

            $this->vista->cargar(array('plantilla' => 'errorSistema.tpl'));
			$this->vista->AsignarVar('encabezado'	, 'ERROR !!!');
			$this->vista->AsignarVar('mensaje'		, 'El sistema no encontro archivos tipo excel u ocurrio algun error desconocido.');
			$this->vista->mostrar('plantilla');
			return false;
		}

		foreach($archivos as $archivo)
		{	
			$extencion	= strtolower($archivo['extencion']);
			$attr		= '';
			if($extencion!='xlsx')
			{	$attr	= 'disabled="disabled"';	}

            $size         = Directorio::formatearSize($archivo['size'], 2, true);
			$nombre		= str_replace('.', '_', $archivo['name']);
			$datos		= array('nombre'	=> $archivo['name'],
								'attr'		=> $attr,
								'previa'	=> $nombre,
                                'update'    => $archivo['dateUpdate'],
                                'size'      => $size);
			$this->vista->AsignarBlocke('archivos', $datos);
			
		}
				
		$this->vista->mostrar('plantilla');
		// Cargo los Archivos JavaScript Necesarios
		$this->cargarJS(DIR_OPET, 'jquery-1.3.2.min.js');
		$this->cargarJS(DIR_MDLAC, 'jquery.checkbox.js');
		$this->cargarJS(DIR_MDLAC, 'planillas.js');
	}
	
	private function borrarAchivo($directorio, $archivo)
	{	$borrar		= $directorio . $archivo;
		if(!file_exists ($borrar))
		{	$this->errores	.='El archivo ' . $archivo . ' no se pudo borrar pues el sistema no lo reconoce como tal.<br />';
			return false;
		}
		if(!is_writable ($borrar))
		{	$this->errores	.='No se tiene permisos para borrar el archivo ' . $archivo .'<br />';
			return false;
		}
		if(!@unlink($borrar))
		{	$this->errores	.='No se pudo borrar el archivo ' . $archivo . '<br />';	
			return false;
		}
		return true;
	}
}