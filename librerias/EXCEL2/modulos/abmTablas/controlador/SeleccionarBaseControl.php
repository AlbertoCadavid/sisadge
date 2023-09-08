<?php
class SeleccionarBaseControl extends GenericoControl
{	
	public function seleccionarBase()
	{	// Primero veo si esta conectado
		if(!isset($_SESSION['OP_CONECT']))
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
		}
		
		$base			= $this->modelo->escaparMysql( (isset($_POST['baseDeDatos']))? $_POST['baseDeDatos'] : null  );
		$tabla			= $this->modelo->escaparMysql( (isset($_POST['tabla']))? $_POST['tabla'] : null );
		if($base)
		{	$error		= $this->modelo->getMysqli()->select_db($base);
			if(!$error)
			{	$this->verForm('La Base seleccionada no existe.');
				return false;
			}	
			$tablas		= $this->modelo->getTablas($base);
			if(!in_array($tabla,$tablas))
			{	$this->verForm('La Tabla seleccionada no existe.');
				return false;
			}
			else
			{	$_SESSION['OP_BASE']	= $base;
				$_SESSION['OP_TABLA']	= $tabla;
				$fcont	= new FrenteControl();
				$fcont->main('abmTablas','Formulario','formGenerico');
				return true;
			}
		}
		$this->verForm();
		return true;
	}
	
	public function verForm($mensaje='')
	{	$this->vista->cargar(array('plantilla' => 'selectorBaseTabla.tpl'));
		$this->vista->AsignarVar('version', DM3P_VRSN);
		$this->vista->AsignarVar('errores', $mensaje);	
		$this->vista->mostrar('plantilla');
		$this->cargarJS( DIR_MDLAC, 'formBaseTabla.js');
	}
}
