<?php
/**
 * Es responsable de realizar acciones con el Servidor, como conectar on mysql, Extraer Bases de datos,
 * extraer tablas de la base, ver archivos en un servidor, configurar memoria y tiempo en php.ini.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (04/09/2009)
 * @since		Usar conjuntamente con la clase ConexionModelo.php
 */
class ConexionControl extends GenericoControl
{
	/**
	 * Prueba si un juego de datos servidor, usuario, clave se puede conectar a una base de datos.
	 * Para ser utilizada mediante AJAX.
	 * @return		void	Salida HTML (si - no), conectado o no conectado respectivamente.
	 */
	public function probarConexion()
	{	$resultado		= $this->modelo->conectarMySQL($_POST['servidor'],$_POST['usuario'],$_POST['clave'],$_POST['puerto']);
		if($resultado)
		{	return true;	} else {	return false; }
	}
	
	
	public function formConexion()
	{	if(isset($_POST['servidor']))
		{	if($this->probarConexion())
			{	$this->vista->cargar(array('plantilla' => 'conectado.tpl'));
				$this->vista->mostrar('plantilla');
				$_SESSION['OP_SERVIDOR']	= $_POST['servidor'];
				$_SESSION['OP_USUARIO']		= $_POST['usuario'];
				$_SESSION['OP_CLAVE']		= $_POST['clave'];
				$_SESSION['OP_PUERTO']		= $_POST['puerto'];
				$_SESSION['OP_CONECT']		= true;
				return;				
			}
			else
			{	$this->msjError				= 'Error de Conexion.';		}
		}
		else
		{	$servidor	= isset($_SESSION['OP_SERVIDOR'])?    $_SESSION['OP_SERVIDOR']    : null;
			$usuario	= isset($_SESSION['OP_USUARIO'])?     $_SESSION['OP_USUARIO']     : null;
			$puerto		= isset($_SESSION['OP_PUERTO'])?      $_SESSION['OP_PUERTO']      : null;
		}
		$servidor		= ($servidor)? $servidor:'localhost';
		$usuario		= ($usuario)? $usuario:'acycia_root';
		$puerto			= ($puerto)? $puerto:3306;
		$clave          = (isset($_POST['clave']))? $_POST['clave']: '';
		
		$this->vista->setDirectorioVista('modulos/conectar/vista/');
		$this->vista->cargar(array('plantilla' => 'formConectar.tpl'));
		$this->vista->AsignarVar('servidor'		, $servidor);
		$this->vista->AsignarVar('usuario'		, $usuario);
		$this->vista->AsignarVar('clave'		, $clave);
		$this->vista->AsignarVar('puerto'		, $puerto);
		$this->vista->AsignarVar('mensajeError'	, $this->msjError);
		$this->vista->mostrar('plantilla');
	}
	
	
	public function desconectar()
	{	session_destroy();
		$this->vista->cargar(array('plantilla' => 'formConectar.tpl'));
		$this->vista->AsignarVar('servidor'		, 'localhost');
		$this->vista->AsignarVar('usuario'		, 'acycia_root');
		$this->vista->AsignarVar('clave'		, '');
		$this->vista->AsignarVar('puerto'		, 3306);
		$this->vista->AsignarVar('mensajeError'	, $this->msjError);
		$this->vista->mostrar('plantilla');
	}
	
	/**
	 * Extrae las bases de datos que se encuentran en el servidor.
	 * Para ser utilizada mediante AJAX.
	 * @return		void	Salida JSON		
	 */
	public function bases()
	{	$datos			= $this->modelo->getBases();
		$salidaJSON		= json_encode($datos);
		echo $salidaJSON;
	}
	
	/**
	 * Extrae las tablas que pertenecen a una base de datos.
	 * Para ser utilizada mediante AJAX.
	 * @return 		void	Salida JSON
	 */
	public function tablas()
	{	$datos			= $this->modelo->getTablas($_POST['base']);
		$salidaJSON		= json_encode($datos);
		echo $salidaJSON;	
	}
	
	/**
	 * Recorre un directorio y extrae los archivos que se encuentran.
	 * Para ser utilizada mediante AJAX.
	 * @return 		void	Salida JSON
	 */
	public function archivos()
	{	$datos			= $this->modelo->getArchivos();
		$salidaJSON		= json_encode($datos);
		echo $salidaJSON;
	}
    
    /**
	 * Recorre un directorio y extrae los archivos PHP que se encuentran.
	 * Para ser utilizada mediante AJAX.
	 * @return 		void	Salida JSON
	 */
    public function funcionesPhp()
    {
        $datos          = $this->modelo->getFunciones();
        $salidaJSON     = json_encode($datos);
        echo $salidaJSON;
    }

	/**
	 * Retorna si configuramos el la memoria maximo en php.ini o su valor por defecto.
	 * @return		void	JSON
	 */
	public function memoria()
	{	if($_SESSION["limiteMemoria"])
		{	$json['memoria']	= intval($_SESSION["limiteMemoria"]);	}
		else
		{	$memoria 			= ini_get('memory_limit');
			$json['memoria']	= intval($memoria);
		}
		echo 				json_encode($json);
	}
	
	/**
	 * Retorna si configuramos el tiempo limite en php.ini o su valor por defecto.
	 * @return		void	JSON
	 */
	public function tiempo()
	{	if($_SESSION["tiempoLimite"])
		{	$json['tiempo']	= intval($_SESSION["tiempoLimite"]);	}
		else
		{	if($_SESSION["tiempoLimite"]=='')
			{	$tiempo 			= ini_get('max_execution_time');
				$json['tiempo']		= intval($tiempo);
			}
			else
			{	$json['tiempo']	= 0;	}
		}
		echo	json_encode($json);
	}
}