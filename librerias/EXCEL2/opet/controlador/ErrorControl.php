<?php
/**
 * Se encarga de mostrar los distintos errores del sistema.
 * Cuenta tambien con un error generico.
 * 
 * @copyright	2009 - ObjetivoPHP
 * @license 	Libre (Free) 
 * @author		Marcelo Castro (objetivoPHP)
 * @link		objetivophp@gmail.com
 * @version 	0.1.0 (19/10/2009)
 */
class ErrorControl extends GenericoControl
{	
	/**
	 * Muestra un mensaje por pantalla.
	 * 
	 * @param	string		$titulo		Titulo del mensaje.
	 * @param 	string		$mensaje	Mensaje del Error.
	 * @return	void					Salida por pantalla
	 */
	public function errorGenerico($titulo,$mensaje)
	{	$this->vista->cargar(array('plantilla' => 'errorSistema.tpl'));
		$this->vista->AsignarVar('encabezado'	, $titulo);
		$this->vista->AsignarVar('mensaje'		, $mensaje);
		$this->vista->setSalidaUTF8(true);
		$this->vista->mostrar('plantilla');
		return false;
	}
}