<?php
/**
* Guarda variables de entorno y nos da acceso al metodo singleton.
*
* @copyright	2007 http://www.jourmoly.com.ar/
* @license 		Free
* @link 		http://www.jourmoly.com.ar/introduccion-a-mvc-con-php-primera-parte/
*/
class Config
{	/**
 	 * Contiene el par nombre valor para cada variable de entorno.
 	 * @var		array
 	 */
    private static 	$vars;
    
    /**
     * Contiene una instancia de la clase Config.
     * @var		object
     */
    private static 	$instance;
 
    /**
     * Metodo contructor.
     * Define a vars como array.
     */
    private function __construct()
    {	self::$vars = array();
    }
 
    /**
     * Metodo set.
     * Con este metodo vamos guardando las variables.
     * @param 	string	$name	nombre de la variable.
     * @param	string	$value	valor de la variables.
     * @return	void
     */
    public function set($name, $value)
    {   if(!isset(self::$vars[$name]))
        {	self::$vars[$name] = $value;	}
    }
 
	/**
     * Metodo get.
     * Nos retorna el valor que tiene la variable que le pasamos como parametro.
     * @param	string	$name	nombre de varibles.
     * @return	string	conteniendo el valor de la variable.
     */
    public function get($name)
    {   if(isset(self::$vars[$name]))
        {	return self::$vars[$name];	}
        return false; ## Agregado 23/08/2008
        
    }

    /**
     * Metodo singleton.
     * Retorna la instancia en uso si ya fue creada o crea una nueva.
     * @return	object
     */
    public static function singleton()
    {	if (!isset(self::$instance))
    	{	$c = __CLASS__;
            self::$instance = new $c;
        }
         return self::$instance;
    }
}