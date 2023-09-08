<?php
/**
 * Aplica el patron singleton para conectar a una base de datos mysql con la libreria mysqli.
 * 
 * @author		objetivoPHP
 * @since		adaptado del ejemplo de http://www.jourmoly.com.ar/
 *
 */
class MysqliSingleton extends mysqli
{	/**
	 * Contiene una instancia de la clase.
	 * @var		object
	 */
	private static $instance = null;
 
	/**
	 * Metodo constructor.
	 * No se puede usar directamente y genera una conexion mysqli.
	 * @return 	object
	 */
	private  function __construct() 
	{	$config = Config::singleton();
		@parent::connect($config->get('dbhost'),$config->get('dbuser'),$config->get('dbpass'),$config->get('dbname'),$config->get('dbport'));
	}
 	
	/**
	 * Metodo singleton.
	 * Me da la instancia en uso de mysqli o la genera.
	 * @return	object
	 */
	static public function singleton() 
	{	if( self::$instance == null ) 
		{	self::$instance = new self();	}
		return self::$instance;
	}
}