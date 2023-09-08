<?php
/**
 * Responsable de Mostrar las paginas estaticas de informacion de la rutina.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (04/09/2009)
 */
class AyudasControl extends GenericoControl
{	
	/**
	 * Presenta por pantalla la pagina Ayuda.
	 * @return 		void		Salida HTML
	 */
	public function ayuda()
	{	$this->vista->cargar(array('plantilla' => 'ayuda.tpl'));
		$this->vista->AsignarVar('correo'	, DM3P_CRR);
		$this->vista->mostrar('plantilla');
	}
	
	
	public function ayuda_4()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_4.tpl'));
		$this->vista->mostrar('plantilla');
	}
}