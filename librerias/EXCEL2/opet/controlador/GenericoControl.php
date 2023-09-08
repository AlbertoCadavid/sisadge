<?php
/**
 * Es el controlador generico y todos  heredan de el por lo cual solo se le agregaran
 * metodos comunes a todos los controladores.
 * 
 * @copyright	2009 - ObjetivoPHP
 * @license 	Libre (Free)
 * @author 		Marcelo Castro (objetivoPHP)
 * @link 		objetivophp@gmail.com
 * @version		0.3 (04/09/2009) Inclusion de soporte para modulos.
 * @since 		basado de los ejemplos de http://www.jourmoly.com.ar/
 */
abstract class GenericoControl
{	/**
 	* Instancia de la clase vista.	
	* @var 		object
	*/
	protected 	$vista;
	
	/**
	 * Instancia de la clase modelo correspondiente a la accion a ejecutar.
	 * @var		object
	 */
	protected 	$modelo;
	
	/**
	 * Contiene el nombre de la accion que se ejecutara.
	 * @var 	string
	 */
	private		$accion;
	
	/**
	 * Nos guarda el ultimo mensaje de error de la clase.
	 * @var		string
	 */
	protected 	$msjError;
	
	/**
	 * Metodo Constructor.
	 * Se encarga de instanciar a la clase vista y al modelo necesario.
	 * @param	string	$controlador
	 * @param	string	$accion
	 */
	public function __construct($modulo , $controlador , $accion)
	{	$this->vista	= new Vista( DIR_MDLAC . DIR_VISTA );
		// Levanto Variables del Modulo
		include_once(DIR_MDLAC . DIR_CONFI . 'configVariables.php');
		// Veemos que modelo necesitamos instanciar
		$modelo			= substr($controlador,0,strlen($controlador)-7)."Modelo";
		$modeloArchivo  = DIR_MDLAC . DIR_MODEL . $modelo . ".php";
		if(file_exists($modeloArchivo))
		{	include_once($modeloArchivo);	}
		else
		{	include_once(DIR_OPET . DIR_MODEL . 'IndexModelo.php');
			$modelo		= 'IndexModelo';
		}

		$this->modelo	= new $modelo();
		$permiso		= $this->modelo->getAcceso($modulo,$controlador,$accion);
		if($permiso)
		{	$permiso	= $accion;	}
		else
		{	$permiso	= "accesoDenegado";}
		$this->accion	= $permiso;
	}
	
	/**
	 * Retorna la accion a ejecutar para el controlador instanciado.
	 * @return	string
	 */
	public function getAccion()
	{	return $this->accion;	}
	
	/**
	 * Configura una accion en tiempo de ejecucion.
	 * @param 	String	$parametro	Nombre de la accion.
	 * @return 	void
	 */
	public function setAccion($parametro)
	{	$this->accion	= $parametro;	}
	
	/**
	 * Metodo listarPermisos.
	 * Vuelca el array de session de permisos.
	 * @ignore
	 * @return 	void	(vuelca directamente a pantalla)
	 */
	public function listarPermisos()
	{	var_dump($_SESSION["mdl_prmss"]);		}
	
	/**
	 * Metodo accesoDenegado.
	 * Lanza la pantalla de informacion de denegacion de acceso.
	 */
	public function accesoDenegado()
	{	include_once (DIR_CONTR . 'IndexControl.php');
		$modelo		= new IndexModelo();
		$modelo->accesoDenegado();
	}
	
	/**
	 * Carga un archivo JavaScript en una Pagina.
	 * @param $dir		String		Directorio principal o de modulo.
	 * @param $src		String		Nombre del Arcchivo JavaScript
	 * @param $lenguaje	String		Version de JavaScript
	 * @return void					Carga el archivo mediante escritura HTML.
	 */
	public function cargarJS($dir, $src, $lenguaje='javascript')
	{	$dirJS	= $dir . DIR_JSCRI . $src;
		echo "<script type='text/javascript' language='". $lenguaje ."' src='". $dirJS ."'></script>\n";
	}
}