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
class infoControl extends GenericoControl
{	
	/**
	 * Presenta por pantalla la pagina Acerca De (Deame3p).
	 * @return		void		Salida HTML
	 */
	public function acercaDe()
	{	$this->vista->cargar(array('plantilla' => 'acercaDe.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	public function quienes()
	{	$this->vista->cargar(array('plantilla' => 'quienes.tpl'));
		// Acerca de Deame3p
		$this->vista->AsignarVar('version'	, DM3P_VRSN);
		$this->vista->AsignarVar('autor'	, DM3P_ATR);
		$this->vista->AsignarVar('correo'	, DM3P_CRR);
		$this->vista->AsignarVar('fecha'	, DM3P_FCH);
		$this->vista->mostrar('plantilla');
	}
	
	public function rutinas()
	{	$this->vista->cargar(array('plantilla' => 'rutinas.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	/**
	 * Presenta por pantalla la pagina Ayuda.
	 * @return 		void		Salida HTML
	 */
	public function ayuda()
	{	$this->vista->cargar(array('plantilla' => 'ayuda.tpl'));
		$this->vista->AsignarVar('correo'	, DM3P_CRR);
		$this->vista->mostrar('plantilla');
	}
	
	public function ayuda_1()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_1.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	public function ayuda_2()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_2.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	public function ayuda_3()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_3.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	public function ayuda_4()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_4.tpl'));
		$this->vista->mostrar('plantilla');
	}
	
	public function ayuda_5()
	{	$this->vista->cargar(array('plantilla' => 'ayuda_5.tpl'));
		$this->vista->mostrar('plantilla');
	}
}