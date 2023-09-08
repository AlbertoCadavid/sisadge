<?php
/**
 * Se encarga de realizar tareas de conexion y extracion de informacion de estructura de la base de
 * datos.
 * 
 * @author		objetivoPHP
 * @link		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version		1.0.0 (04/09/2009)
 */
class ConexionModelo extends GenericoModelo
{	
	/**
	 * Se encarga de ver si un juego de datos se conecta con un servidor MySQL.
	 * En caso de conectar guarda los datos en variables de session.
	 * @param	$servidor	String		Nombre del Servidor a Conectarse.
	 * @param 	$usuario	String		Nombre de Usuario que intenta acceder.
	 * @param 	$clave		String		Contrase�a para acceder al servidor MySQL.
	 * @return	Boolean					True si conecta, False en caso contrario.
	 */
	public function conectarMySQL($servidor, $usuario, $clave, $puerto)
	{	// Uso addslashes y no escaparMySQL porque todavia no tengo Conexion mysqli.
		$servidor		= addslashes($servidor);
		$usuario		= addslashes($usuario);
		$clave			= addslashes($clave);
		$puerto			= addslashes($puerto);
		$mysqli 		= @new mysqli($servidor, $usuario, $clave, '', $puerto);
		if (mysqli_connect_error())
		{	return false;	}
		else 
		{	$_SESSION['OP_SERVIDOR']	= $servidor;
			$_SESSION['OP_USUARIO']		= $usuario;
			$_SESSION['OP_CLAVE']		= $clave;
			$_SESSION['OP_PUERTO']		= $puerto;
			return true;
		}
	}
	
	/**
	 * Es responsable de Extraer las Bases de Datos para la conexion dada.
	 * @return	array		Retorna un arreglo con las bases del servidor, para el usuario conectado.
	 */
	public function getBases()
	{	$consulta		= "SHOW databases";
		$resultado    	= $this->dbMysqli->query($consulta);
		$datos			= array();
		$linea			= $resultado->fetch_object(); 
		while($linea)
		{	$base		= $linea->Database;
			$error		= @$this->dbMysqli->select_db($base);
			if($error)
			{
				$datosAux['valor']			= $base;		 	
				$datosAux['titulo']			= $base;
				$datosAux['comentario']		= $base;
				$datos[]					= $datosAux; 
			}
			$linea			= $resultado->fetch_object(); 
		}
		$resultado->free_result();
		return $datos;
	}
	
	/**
	 * Retorna las tablas que pertenecen a una base dada.
	 * @param 	$base		String	Nombre de la Base de datos a analizar.
	 * @return 	array		Conteniendo los datos de las tablas que pertenecen a la Base.
	 */
	public function getTablas($base)
	{	
        $base		= $this->escaparMysql($base);
        $datos		= array();
        try {
            $consulta 	= "SHOW tables FROM $base";
            $resultado	= $this->dbMysqli->query($consulta);
            if ($this->dbMysqli->error) {
                $msj    = $this->dbMysqli->errno . ' : ' . $this->dbMysqli->error
                        . ' Consulta: ' . $consulta;
                throw new Exception($msj);
            }
            $linea		= $resultado->fetch_object();
        } catch (Exception $e) {
            $datosAux['valor']			= '';		 	
			$datosAux['titulo']			= $e->getMessage();
			$datosAux['comentario']		= 'ERROR !!!!!!!';
            $datos[]                    = $datosAux;
            return $datos;
        }
        
		$campo		= 'Tables_in_' . $base;
		while($linea)
		{	$tabla						= $linea->$campo;
			$datosAux['valor']			= $tabla;		 	
			$datosAux['titulo']			= $tabla;
			$datosAux['comentario']		= $tabla;
			$datos[]					= $datosAux; 
			$linea						= $resultado->fetch_object(); 
		}
        
        if (!count($datos)) {
            $datosAux['valor']			= '';		 	
			$datosAux['titulo']			= 'No se encontraron tablas.';
			$datosAux['comentario']		= 'La base esta vacia.';
            $datos[]                    = $datosAux; 
        }
        
		$resultado->free_result();
		return $datos;
	}
	
	/**
	 * Retorna los archivos que pertenecen a un directorio que tengan como extencion xls o xlsx.
	 * @return		Array		Arreglo conteniendo los archivos.
	 */
	public function getArchivos()
	{	#abrimos el identificador de directorio
		$direccion		= 'planillas/';
		$f 				= opendir($direccion);
		#Establecemos los tipos de archivo permitidos
		$extenciones 	= array('xls' => 1,'xlsx'	=> 1, 'nxd' => 0);

		$datos			= array();
		//leemos todos los ficheros
		$fichero		= readdir($f);
		while($fichero)
		{	if($fichero=="." || $fichero =="..") {	$fichero="fichero.nxd";	}
			$punto		= strpos($fichero,".");
			if ($punto)
			{	$ext	= substr($fichero,$punto+1,strlen($fichero));
				$ext	= strtolower($ext);
			}
			
			if($extenciones[$ext]==1)
			{	//$visualizar = $fichero;
				$datosAux['valor']			= $fichero;		 	
				$datosAux['titulo']			= $fichero;
				$datosAux['comentario']		= $fichero;
				$datos[]					= $datosAux;		
			}
			$fichero	= readdir($f);
		}
		closedir($f);
		return $datos;
	}
    
    	/**
	 * Retorna los archivos que pertenecen a un directorio que tengan como extencion php.
	 * @return		Array		Arreglo conteniendo los archivos.
	 */
	public function getFunciones()
	{	#abrimos el identificador de directorio
		$direccion		= 'funciones/';
		$f 				= opendir($direccion);
		#Establecemos los tipos de archivo permitidos
		$extenciones 	= array('php' => 1,'nxd' => 0);

		$datos			= array();
		//leemos todos los ficheros
		$fichero		= readdir($f);
		while($fichero)
		{	if($fichero=="." || $fichero =="..") {	$fichero="fichero.nxd";	}
			$punto		= strpos($fichero,".");
			if ($punto)
			{	$ext	= substr($fichero,$punto+1,strlen($fichero));
				$ext	= strtolower($ext);
			}
			
			if($extenciones[$ext]==1)
			{	//$visualizar = $fichero;
				$datosAux['valor']			= $fichero;		 	
				$datosAux['titulo']			= $fichero;
				$datosAux['comentario']		= $fichero;
				$datos[]					= $datosAux;		
			}
			$fichero	= readdir($f);
		}
		closedir($f);
		return $datos;
	}
    
    
}