<?php
/**
 * Todas las clases modelos extienden de esta para tomar su funcionalidad basica.
 *
 * @copyright	2009 - ObjetivoPHP
 * @license 	Libre (Free)
 * @author 		Marcelo Castro (objetivoPHP)
 * @link 		objetivophp@gmail.com
 * @version		0.4.0 (04/09/2009)
 */
abstract class GenericoModelo
{	
	/**
	 * Mantiene una conexion con la base de datos.
	 * @var		object		contiene una conexion mysqli.
	 */
	protected 	$dbMysqli;
 	
	/**
	 * Guarda el ultimo error que se produjo en la clase.
	 * @var		String
	 */
	public 		$msjErrorValid;
	
	/**
	 * Metodo Constructor.
	 * Se encarga de recuperar la conexion MySQLI, pues se utiliza una sola
	 * por cada usuario.
	 */
	public function __construct()
	{	$this->dbMysqli	= MysqliSingleton::singleton();	}
	
	/**
	 * Metodo getAcceso.
	 * Esta funcion verifica si un usuario previamente registrado tiene acceso o no 
	 * a una determinado metodo.
	 * Por ahora usaremos metodo base de datos pudiendo implementar un metodo rapido.
	 * @access 	public
	 * @param 	String		$control	Nombre del controlador a instanciar.
	 * @param 	String		$accion		Nombre de la accion a realizar.
	 * @return	boolean		true para permitir acceso, false para denegar.
	 */
	public function getAcceso($modulo,$control,$accion)
	{	include_once(DIR_MDLAC . DIR_CONFI . 'configVariables.php');
		$config 		= Config::singleton();			// Puede no existir esta linea
		$accesoLibre	= $config->get('ACCESO_LIBRE');
		if($accesoLibre)
		{	return true;	}
		// Si No es libre controlo los accesos a los modulos, controladores y acciones.
		// Cambiar todo este metodo
		$modulo		= $this->escaparMysql($modulo);
		$control	= $this->escaparMysql($control);
		$accion		= $this->escaparMysql($accion);
		$consulta	=	"SELECT dyp_acciones.accesoMin 
						FROM dyp_acciones, dyp_controladores 
						WHERE dyp_controladores.idControlador=dyp_acciones.idControlador 
						&& dyp_controladores.controlador='".$control."' 
						&& dyp_acciones.accion='".$accion."'";
						
		$resultado					= $this->dbMysqli->query($consulta);
		if($this->dbMysqli->affected_rows>=0)
		{	$linea					= $resultado->fetch_object();
			while($linea)
			{	$valorAcceso		= $linea->accesoMin;
				$linea				= $resultado->fetch_object();
			}
		}
		
		$acceso					= false;
		if(intval($_SESSION["mdl_prmss"][$control][$accion])>=$valorAcceso)
		{	$acceso				= true;	}
		return $acceso;
		
	}
	
	/**
	 * Metodo escaparMysql.
	 * Se encarga de asegurar que no se inyecte codigo malicioso en las consultas.
	 * @access 	public
	 * @param	string	$cadena
	 * @return	string	Conteniendo una cadena escapada.
	 */
	public function escaparMysql($cadena='',$mayuscula=0)
	{	if($mayuscula)
		{	$cadena	= strtoupper($cadena);	}
		if($cadena)
		{	return @$this->dbMysqli->real_escape_string(trim($cadena));	}
		else {	return false;	}
		
	}
	
	/**
	 * Metodo insertarArray.
	 * Realiza un insert a una tabla MySQL de acuerdo al arreglo enviado.
	 * El arreglo debe contener como clave el nombre del campo MySQL y como 
	 * valor el valor a ingresar.
	 * @access 	public
	 * @param 	string	$tabla	nombre de la tabla en donde se insertan los datos.
	 * @param	array	$datos	arreglo con los datos
	 * @param	string	$noIngresar	campos que no se quieren ingresar separados por |(alt 124).
	 * @return	return 	mensaje de error o nada si todo salio bien.
	 */
	public function insertarArray($tabla,$datos,$noIngresar='',$validar='')
	{	$noIngresar			= explode("|",$noIngresar);
		$consInsert			= "INSERT INTO ".$this->escaparMysql($tabla)." ( ";
		$consValue			= "";
		$indice				= 0;
		foreach($datos as $clave => $valor)
		{	if(!in_array($clave,$noIngresar))
			{	$clave	= $this->escaparMysql($clave);
				$consInsert		.= "`" . $this->escaparMysql($clave)."`, ";
				if($valor)
				{	$valorValidado	 = $this->validar($validar[$indice],$valor); }
				else
				{	$valorValidado	 = $this->validar($validar[$indice]);}
				
				if($valorValidado===false)
				{	return false;	}
				$consValue		.= 	"'".$this->escaparMysql($valor)."', ";
			}
			$indice++;
		}
		$consInsert			= substr($consInsert,0,strlen($consInsert)-2)." )";
		$consValue			= substr($consValue,0,strlen($consValue)-2);
		$consulta			= $consInsert." VALUES ( ".$consValue." )";
		//echo $consulta . '<br />';
		$this->dbMysqli->  prepare($consulta);
		$this->dbMysqli->  query($consulta);
		return $this->dbMysqli->error;
	}
	
	/**
	 * Realiza la edicion en una tabla mysql. Es para UPDATE simples.
	 * 
	 * @param 	String	$tabla		Nombre de la tabla sobre la cual se editara.
	 * @param 	Array	$datos		Arreglo conteniendo el par campo, valor para ser actualizado.
	 * @param 	String	$noIngresar	Cadena de la forma campo|campo|.... estos seran ignorados.
	 * @param 	Array	$validar	Tipo de validacion para el campo.
	 * @param 	String	$campoId	Nombre del campo que es clave en la tabla.
	 * @return 	Boolean				true,false
	 */
	public function editArray($tabla,$datos,$noIngresar='',$validar='',$campoId)
	{	$noIngresar	= explode("|",$noIngresar);
		$where		= "";
		$consInsert	= "UPDATE ".$this->escaparMysql($tabla)." SET ";
		$indice		= 0;
		foreach ($datos as $clave => $valor)
		{	$clave	= $this->escaparMysql($clave);
			if(!in_array($clave,$noIngresar))
			{	if($valor)
				{	$valorValidado	 = $this->validar($validar[$indice],$valor); }
				else
				{	$valorValidado	 = $this->validar($validar[$indice]);	}
				
				if($valorValidado===false)
				{	return false;	}
				
				$consInsert		.=	"`" .  $this->escaparMysql($clave)."`='";
				$consInsert		.= 	$this->escaparMysql($valor)."', ";
				if($clave==$campoId)
				{	$where	=" WHERE `".$this->escaparMysql($clave)."`='".$this->escaparMysql($valor)."'";	}
			}
			else
			{	if($clave==$campoId)
				{	$where	=" WHERE ".$this->escaparMysql($clave)."='".$this->escaparMysql($valor)."'";	}
			}
			$indice++;
		}
		$consulta			= substr($consInsert,0,strlen($consInsert)-2).$where;
		//echo $consulta;
		$this->dbMysqli->  prepare($consulta);
		$this->dbMysqli->  query($consulta);
		return $this->dbMysqli->error;
	}
	
	
	/**
	 * Metodo getDatosTabla.
	 * Extrae datos de una tabla de acuerdo a los parametros pasados.
	 * @access 	public
	 * @param	string	$tabla	nombre de tabla donde se encuentran los datos.
	 * @param	string	$where	condicion o null en caso de no tener.
	 * @param 	string 	$ordenCampo	nombre del campo por el cual se va a ordenar.
	 * @param	string	$orden	ASC o DESC por defecto ASC.
	 * @return	string	mensaje de error o nada si todo salio bien.
	 */
	public function getDatosTabla($tabla,$where='',$ordenCampo='',$orden='ASC')
	{	$consulta	= "SELECT * FROM ".$tabla;
		if($where)		{	$consulta	.=" WHERE ".$where;			}
		if($ordenCampo)	{	$consulta	.=" ORDER BY ".$ordenCampo." ".$orden; }
		
		$this->dbMysqli->  prepare($consulta);
		$resultado		= $this->dbMysqli->  query($consulta);
		return $resultado;
	}
	
	/**
	 * Nos permite realizar desde el controlador una consulta simple.
	 * Es Mejor evitar.
	 * 
	 * @param 	String	$consulta	Consulta Mysl a ser ejecutada.
	 * @return 	Boolean
	 */
	public function consultaSimple($consulta)
	{	return	$this->dbMysqli->query($consulta);
	}
	
	/**
	 * Retorna el numero de campos que genero la ultima consulta.
	 * @return 	Integer
	 */
	public function numeroCampos()
	{	return $this->dbMysqli->field_count;	}
	
	/**
	 * Retorna la cantidad de lineas de la ultima consulta.
	 * @return 	Integer
	 */
	public function cantidadLineas()
	{	return $this->dbMysqli->num_rows; }
	
	public function registrosSelect($ResMysql)
	{	return $ResMysql->num_rows;
	}
	
	
	/**
	 * Realiza una validacion simple de un campo.
	 * Elimina la inyeccion MySQL.
	 * @param 	String		$tipo	Tipo del campo a validar.
	 * @param 	String		$valor	Valor a ser validado.
	 * @return	String
	 */
	public function validar($tipo,$valor='')
	{	$valor	= $this->escaparMysql($valor);
		switch ($tipo)
		{	case	"fecha":
					$fecha	= explode("-",$valor);
					if(!checkdate($fecha[1],$fecha[2],$fecha[0]))
					{	$this->msjErrorValid	= "La Fecha no es correcta.";
						return false;	
					}	
					break;
		}
		return true;
	}
	
	/**
	 * Retorna una conexion MySQL para poder ser usada en las utilidades.
	 * @return	Object		Contiene una conexion Mysqli.
	 */
	public function getMysqli()
	{	return $this->dbMysqli;}
	
	/**
	 * Retorna las tablas que pertenecen a una base dada.
	 * @param 	$base		String	Nombre de la Base de datos a analizar.
	 * @return 	array		Conteniendo los datos de las tablas que pertenecen a la Base.
	 */
	public function getTablas($base)
	{	$base		= $this->escaparMysql($base);
		$consulta 	= "SHOW tables FROM $base";
		$resultado	= $this->dbMysqli->query($consulta);
		$datos		= array();
		$linea		= $resultado->fetch_object(); 
		$campo		= 'Tables_in_' . $base;
		while($linea)
		{	$datos[]= $linea->$campo; 
			$linea	= $resultado->fetch_object(); 
		}
		$resultado->free_result();
		return $datos;
	}	
}