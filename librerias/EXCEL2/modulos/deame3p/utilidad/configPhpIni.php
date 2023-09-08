<?php
/**
 * Se encarga de configurar las variables php.ini maxima memoria y tiempo limite de ejecucion.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (05/09/2009)
 */
class configPhpIni
{	
	/**
	 * Contiene los parametros permitidos para configuracion.
	 * @var		String
	 */
	private		$parametrosPermitidos	= array('max_execution_time' 	=> '',
												'memory_limit'			=> 'M');
	/**
	* Configuracion Basica inicial del sistema.
	* return void
	*/
	public function __construct()
	{	// Configurar Tiempo Limite
		if(isset($_SESSION["tiempoLimite"]))
		{	$this->setConfiguracion('max_execution_time'	, $_SESSION["tiempoLimite"] );		}
		else
		{	$this->setConfiguracion('max_execution_time'	, ini_get('max_execution_time'));	}
		// Configurar Memoria Maxima
		if(isset($_SESSION["limiteMemoria"]))
		{	$this->setConfiguracion('memory_limit'	, $_SESSION["limiteMemoria"] );		}
		else
		{	$this->setConfiguracion('memory_limit'	, ini_get('memory_limit'));	}	
	}
	
    /**
    * Configura algunos parametros del php.ini siempre que el servidor lo permita.
    * @param	String	$parametro		Es el nombre del parametro a configurar.
    * @param	mixed	$valor			Valor para configurar el parametro.
    * @return 	Boolean
    */
    public function setConfiguracion($parametro, $valor)
    {  	$param			= array_key_exists($parametro, $this->parametrosPermitidos);
    	if(!$param)
    	{	echo "El parametro $parametro no se puede configurar.<br />";
    		return	false;
    	}
    	if($valor!=='')
    	{	$valor		= (int)(abs($valor));
    		$dato		= $valor;
    		$valor		= $valor . $this->parametrosPermitidos[$parametro];
    		$error		= @ini_set($parametro,$valor);
    		if(!$error)
    		{	echo 	"El servidor no permite configurar el parametro $parametro.<br />
    					El script se ejecutara con los valores por defecto";
    			return false;
    		}
    		
    	}
    	return true;
    }
}