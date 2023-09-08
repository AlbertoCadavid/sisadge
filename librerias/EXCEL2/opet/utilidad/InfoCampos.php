<?php
/**
 * Clase encargada de extraer informacion de los campos de una tabla.
 * Realizada en forma generica para DEAME3P Version 3.0.0.-
 * @author		objetivoPHP
 * @link 		objetivophp@gmail.com
 * @version 	1.0	08/08/2007.
 * @version 	1.1 04/04/2008 Se agrega getClaveForanea().
 * @version 	1.2 04/09/2009 Modificado para ser Utilizado sobre OPET.
 * @version		1.2.1 13/12/2009 Arreglado error en clave foranea cuando estaba en mas de una tabla un campo.
 * @version		1.3.0 30/12/2009 Propiedad para saber si un campo es numerico.
 */
class InfoCampos
{	
	/**
	 * Arreglo que contiene todas las propiedades de cada campo.
	 * Las Propiedades se llaman tipo, sinSigno, zeroFill, largo, nulo, clave,
	 * defecto, extra.
	 * @var		array()
	 */
	private $campoInfo		= array();
	
	/**
	 * Nombre de la Base de Datos a ser Analizada.
	 * @var		String
	 */
	private $baseDeDatos;
	
	/**
	 * Nombre de la tabla a analizar.
	 * @var		String
	 */
	private $tabla;

	/**
	 * Contiene la cantidad de campos de la tabla.
	 * @var		Integer
	 */
	private $cantCampos;

	/**
	 * Guarda las claves foraneas.
	 * @var 	array
	 */
	private	$clavesForaneas		= array();
	
	/**
	 * Contiene una conexion mysqli.
	 * @var		Object Mysqli
	 */
	private $conexion;
	
	/**
	 * Contiene los tipos de campos Numericos.
	 * @var 	array
	 */
	private $tipoNumericos		= array('TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL');
	
	/**
	 * Inicia la clase y extrae las propiedades guardandolos en el array.
	 * @param 	Object 	$conexion 		Conexion mysqli
	 * @param	String	$baseDeDatos	Nombre de la base de datos a analizar.
	 * @param 	String	$tabla			Nombre de la tabla a analizar.
	 * @return	void
	 */
	public function __construct(MysqliSingleton $conexion,$baseDeDatos,$tabla)
	{	$this->conexion		= $conexion;
		if ($baseDeDatos) 	{$this->baseDeDatos	= $baseDeDatos;	}
		if ($tabla)			{$this->tabla		= $tabla;		}
		$this->conexion->select_db($this->baseDeDatos);
		$this->extraerPropiedades($this->tabla);
	}

	/**
	 * Extrae las propiedades de la tabla y las guarda en el arrat infoCampos.
	 * @access	public
	 * @param	String	$tabla
	 */
	public function extraerPropiedades($tabla)
	{	if($tabla) {$this->tabla = $tabla;}
		$consulta		= "SHOW FULL COLUMNS FROM ".$this->baseDeDatos.".".$this->tabla;
		$camposT		= $this->conexion->query($consulta);
		if(!$camposT->num_rows)
		{	return false;	}
		$ind			= 0;
		$this->getClaveForanea();
		$linea			= $camposT->fetch_array();
		while ($linea) {
            $nombre			= $linea['Field'];
			$sinSigno		= $this->esUnsigned($linea['Type']);
			$zeroFill		= $this->esZeroFill($linea['Type']);
			$tipoCampo		= $this->getTipoCampo($linea['Type']);
			$largo			= $this->getLargoCampo($linea['Type']);

            if (!empty ($this->clavesForaneas[$nombre]['tabla'])) {
                $claveForanea 	= $this->clavesForaneas[$nombre]['tabla'];
                $ayudas         = $this->camposParaSelect($claveForanea,$nombre);
            } else {
                $claveForanea   = $ayudas = null;
            }
            $this->campoInfo[$nombre]	= array('nombre'        => $nombre,
                                                'tipo'          => $tipoCampo,
                                                'sinSigno'      => $sinSigno,
                                                'zeroFill'      => $zeroFill,
                                                'largo'         => $largo,
                                                'nulo'          => $linea['Null'],
                                                'clave'         => $linea['Key'],
                                                'defecto'       => $linea['Default'],
                                                'extra'         => $linea['Extra'],
                                                'collation'     => $linea['Collation'],
                                                'claveForanea'  => $claveForanea,
                                                'ayudas'		=> $ayudas,
                                                'numerico'		=> $this->esNumerico($tipoCampo));
            $ind++;
            $linea			= $camposT->fetch_array();
		}
		$this->cantCampos			= $ind;
	}
	
	/**
	 * Retorna el valor para la propiedad y campo elegido.
	 * @param 	String	$nombre		Nombre del Campo que se quiere la propiedad.
	 * @param	String	$propiedad	Propiedad que se desea conocer el valor.
	 * @return	String	Contiene el Valor de la propiedad seleccionada.
	 */
	public function getCampoInfo($nombre,$propiedad)
	{	return $this->campoInfo[$nombre][$propiedad];}
	
	/**
	 * Devuelve el Total de campos de la tabla.
	 * @return	Integer
	 */
	public function getCantCampos()
	{	return  $this->cantCampos;}
	
	/**
	 * Retorna un arreglo con todos los datos de una tabla.
	 * @return 	array
	 */
	public function getArrayCampos()
	{    return  $this->campoInfo;    }
	
	/**
	 * Examina si un campo es unsigned o no.
	 * @access 	private
	 * @param	String	Cadena contenida en el campo Type BLOB de MySQL.
	 * @return	Boolen	0 si no es - 1 si lo es.
	 */
	public function esUnsigned($stringTipo)
	{	if(stristr($stringTipo,"unsigned"))
		{	return 1;	}
		else
		{	return 0;	}
	}
	
	/**
	 * Examina si un campo es zerofill o no.
	 * @access 	private
	 * @param	String	Cadena contenida en el campo Type BLOB de MySQL.
	 * @return	Boolen	0 si no es - 1 si lo es.
	 */	
	public function esZeroFill($stringTipo)
	{	if(stristr($stringTipo,"zerofill"))
		{	return 1;	}
		else
		{	return 0;	}
	}
	
	/**
	 * Nos retorna el tipo de campo Mysql que es, solo el nombre.
	 * @param	String	Cadena contenida en el campo Type BLOB de MySQL.
	 * @return	String	Contiene el tipo de campo que es por ej. BIGINT
	 */
	public function getTipoCampo($stringTipo)
	{	$auxiliar	=explode("(",$stringTipo);
		return $auxiliar[0];
	}
	
	/**
	 * Nos da la cantidad de caracteres que tiene el campo.
	 * @param	String	Cadena contenida en el campo Type BLOB de MySQL.
	 * @return	Integer
	 */
	public function getLargoCampo($stringTipo)
	{
        // Cambiar a expresiones regulares
        $largo      = 0;
        $auxiliar	= explode("(",$stringTipo);
        if (count($auxiliar) > 1) {
            $auxiliar2	= explode(")",$auxiliar[1]);
            $largo      = $auxiliar2[0];
        }
		return $largo;
	}
	
	/**
	 * Lista las propiedades de todos los campos en Pantalla.
	 */
	public function getPropiedades()
	{	foreach ($this->campoInfo as $clave => $valor)
		{	echo "<br><pre><b>".$clave."</b>";
			foreach ($this->campoInfo[$clave] as $clave => $valor)
			{	echo "<br>     ".$clave." = ".$valor;	}
		}
		echo "</pre>";
	}

	/**
	 * Guarda las claves foraneas encontradas en las tablas.
	 * @return	void
	 */
	private function getClaveForanea()
	{	$tablas			= "SHOW tables FROM `" . $this->baseDeDatos . "`";
		$resultado		= $this->conexion->query($tablas);
		if(!$resultado->num_rows)
		{	return false;	}
		$tablas			= $resultado->fetch_array();
		while ($tablas)
		{	
            $tabla = "SHOW INDEX FROM `" . $this->baseDeDatos . '`.`' . $tablas[0]."` FROM `".$this->baseDeDatos .'`';
            $indices	= $this->conexion->query($tabla);
            $indice	= $indices->fetch_array();
            while ($indice)
            {	// Campo no Puede Contener Repetidos//
                if($indice["Non_unique"]==0)
		{   $campo	= $indice["Column_name"];
                    $tablaI	= $indice["Table"];
                    if($tablaI!=$this->tabla)
                    {	$this->clavesForaneas[$campo]	= array("campo"		=> $campo,
					 			"tabla"		=> $tablaI);
                    }
                }
		$indice	= $indices->fetch_array();
            }
            $tablas			= $resultado->fetch_array();
		}
	}
	
	/**
	 * Nos da 4 campos para el select cuando es clave foranea.
	 * 
	 * @param 	string		$tabla	nombre de tabla.
	 * @param 	string		$indice	nombre del campo indice.
	 * @return 	string		4 campos separados por | que seran usados como ayudas.
	 */
	private function camposParaSelect($tabla, $indice)
	{	$consulta	= "SHOW COLUMNS FROM " . $tabla . " WHERE Type not like '%int%' && Type not like '%text%' &&  Type not like '%blob%' && Field!='" . $indice . "'";
		$resultado	= $this->conexion->query($consulta);
		$ayudas		= $indice . '|';
		$campos		= $resultado->fetch_array();
		$indice		= 0;
		while($campos)
		{	if($indice>3) {	break;	}
			$indice++;
			$ayudas	= $ayudas . $campos['Field'] . '|';
			$campos	= $resultado->fetch_array();
		}
		$ayudas		= substr($ayudas,0,strlen($ayudas)-1);
		return $ayudas;		
	}
	
	/**
	 * Retorna si un campo es numerico.
	 * @param	string 		$tipoMySql	tipo de campo mysql ej. BIGINT.
	 * @return	boolean		true si es numerico / false si no es numerico.
	 */
	private function esNumerico($tipoMySql)
	{	$tipoMySql	= strtoupper($tipoMySql);
		return in_array($tipoMySql, $this->tipoNumericos);
	}
}