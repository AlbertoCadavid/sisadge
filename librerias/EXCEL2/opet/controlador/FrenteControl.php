<?php
/**
 * Controlador de ingreso al sitio.
 * Por aca pasan todas las peticiones y el se encarga de distribuirla
 * al modulo, controlador y accion correspondiente.
 * 
 * @copyright	2010 - ObjetivoPHP
 * @license 	Libre (Free)
 * @author 		Marcelo Castro (objetivoPHP)
 * @link 		objetivophp@gmail.com
 * @version		0.5.3 (11/03/2010) Se arreglan problemas cuando error_reporting esta configurado con E_STRICT
 */
class FrenteControl
{ 	
	/**
	 * Contiene los metodos que no pueden ser llamados.
	 * @var		array
	 */
	public 	$metodosNoPermitidos	= array('__construct' , '__destruct');

	/**
 	* Metodo main.
 	* Metodo de carga del sistema, Llama al controlador y la accion pasadas por
 	* parametros o en su defecto a las enviadas por GET.
 	* @param	string	$modulo			nombre del modulo a cargar.
 	* @param 	String	$controlador	nombre del controlador o nada si viene por GET.
 	* @param 	String 	$accion			nombre de la accion o nada si viene por GET.
 	* @return 	void
 	*/
	public function main($modulo ='', $controlador='',$accion='')
	{	// Incluyo Clases de arranque del sistema, de configuracion y genericas.
		include_once(DIR_OPET . DIR_CONFI . 'Config.php');
		include_once(DIR_OPET . DIR_CONFI . 'MysqliSingleton.php');
		include_once(DIR_OPET . DIR_VISTA . 'Vista.php');
		include_once(DIR_OPET . DIR_CONTR . 'GenericoControl.php');
		include_once(DIR_OPET . DIR_MODEL . 'GenericoModelo.php');
        
		$config   = Config::singleton();
		
		// Vemos si existe el modulo que intenta levantar
		if($modulo)
		{	$moduloNombre 			= $modulo;}
		else
		{	if(!empty($_GET['mdl']))
			{	$moduloNombre 		= $_GET['mdl'];	}
			else
			{	$moduloNombre 		= 'index';			}
		}
		// Defino el Modulo en uso Actualmente
		if( DIR_OPET == $moduloNombre . '/' )
		{	define('DIR_MDLAC', $moduloNombre . '/');	} 
		else
		{	// Veo que Exista el modulo a cargar
			if(!is_dir( DIR_MODUL . $moduloNombre . '/' ))
			{	$this->mostrarError('ERROR !!!', 'No se pudo cargar el modulo solicitado.');
				return false;
			}
            if (!defined('DIR_MDLAC')) {
                define('DIR_MDLAC', DIR_MODUL . $moduloNombre . '/');
            }
		}
		//Formamos el nombre del Controlador o en su defecto tomamos IndexControl
		if($controlador)
		{	$controladorNombre 	= $controlador . 'Control';}
		else
		{	if(!empty($_GET['ctr']))
			{	$controladorNombre 	= $_GET['ctr'] . 'Control';	}
			else
			{	$controladorNombre 	= 'IndexControl';			}
		}
		//Lo mismo sucede con las acciones, si no hay accion, tomamos inicio como accion
		if($accion && !in_array($accion,$this->metodosNoPermitidos))
		{	$accionNombre 			= $accion; }
		else
		{	if(!empty($_GET['acc']) && !in_array($_GET['acc'],$this->metodosNoPermitidos))
			{	$accionNombre 		= $_GET['acc'];	}
			else
			{	$accionNombre 		= 'index';	}
		}

		$dirControlador = DIR_MDLAC . DIR_CONTR . $controladorNombre.'.php';
		//Incluimos el fichero que contiene nuestra clase controladora solicitada	
		if(is_file($dirControlador))
		{	
			include_once( $dirControlador );
			// Vemos si se puede ejecutar la accion
			//Ojo Con la Funcion is_callable:
			//Metodos estaticos: is_callable(array('clase', 'metodo'));
			//Metodos dinamicos: is_callable(array($objeto, 'metodo'));
            
            $obj_controlador           = new $controladorNombre($moduloNombre, $controladorNombre,$accionNombre);
			if(class_exists($controladorNombre))
			{
				if (is_callable(array($obj_controlador, $accionNombre)) == false)
				{	$this->mostrarError('ERROR !!!', 'No se pudo ejecutar la accion correspondiente.');
					return false;
				}
			}
			else
			{	$this->mostrarError('ERROR !!!', 'No se pudo cargar el controlador correspondiente.');
				return false;
			}
		}
		else
		{	$this->mostrarError('ERROR !!!', 'No se pudo encontrar el Archivo correspondiente.');
			return false;
		}
 	
		// Vemos si el usuario tiene permisos para ejecutar no en este caso
		//Y Si todo esta bien, creamos una instancia del controlador y llamamos a la accion
		//$obj_controlador		 	= new $controladorNombre($moduloNombre, $controladorNombre,$accionNombre);
		if(DIR_ACCES)
		{	$obj_controlador->getAccion();	}
		return $obj_controlador->$accionNombre();
	}
	
	/**
	 * Se encarga de enrutar hacia la funcion que muestra los mensajes para el usuario.
	 * @param	string		$titulo 	Encabezado del error.
	 * @param 	string		$mensaje	Cuerpo del Mensaje.
	 * @return	void					Muestra por pantalla un mensaje.
	 */
	private function mostrarError($titulo,$mensaje)
	{	include_once(DIR_OPET . DIR_CONTR . 'ErrorControl.php');
		define('DIR_MDLAC', DIR_OPET );
		$obj_controlador		= new ErrorControl( DIR_OPET , 'ErrorControl','errorGenerico');
		$obj_controlador->errorGenerico($titulo,$mensaje);
	}
}