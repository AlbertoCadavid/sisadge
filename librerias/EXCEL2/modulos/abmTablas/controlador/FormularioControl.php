<?php
class FormularioControl extends GenericoControl
{	
	private $obj_Form;
	
	private $obj_infoCampo;
	
	private $base;
	
	private $tabla;
	
	private $generar	= false;
	
	private $tipoMysql_tipoForm	= array('varchar'		=> array('text'		, 'alfanumerico'	, 65535),
										'tinyint'		=> array('text'		, 'entero'			, 255),
										'text'			=> array('textarea'	, 'texto'			, 65535),
										'date'			=> array('text'		, 'fecha'			, 10),
										'smallint'		=> array('text'		, 'entero'			, 65535),
										'mediumint'		=> array('text'		, 'entero'			, 8388607),
										'int'			=> array('text'		, 'entero'			, 4294967295),
										'bigint'		=> array('text'		, 'entero'			, 18446744073709551615),
										'float'			=> array('text'		, 'decimal'			, 24),	
										'double'		=> array('text'		, 'decimal'			, 54),
										'decimal'		=> array('text'		, 'decimal'			, 54),
										'datetime'		=> array('text'		, 'alfanumerico'	, 19),
										'timestamp'		=> array('text'		, 'alfanumerico'	, 19),
										'time'			=> array('text'		, 'alfanumerico'	, 8),
										'year'			=> array('text'		, 'entero'			, 4),
										'char'			=> array('text'		, 'alfanumerico'	, 255),
										'tinyblob'		=> array('textarea'	, 'texto'			, 255),
										'tinytext'		=> array('textarea'	, 'texto'			, 255),
										'blob'			=> array('textarea'	, 'texto'			, 65535),
										'mediumblob'	=> array('textarea'	, 'texto'			, 16777215),
										'mediumtext'	=> array('textarea'	, 'texto'			, 16777215),
										'longblob'		=> array('textarea'	, 'texto'			, 4294967295),
										'longtext'		=> array('textarea'	, 'texto'			, 4294967295),
										'enum'			=> array('select'	, 'alfanumerico'	, 255),
										'set'			=> array('select'	, 'alfanumerico'	, 255),
										'bool'			=> array('text'		, 'alfanumerico'	, 255),
										'binary'		=> array('text'		, 'alfanumerico'	, 65535),
										'varbinary'		=> array('text'		, 'alfanumerico'	, 65535)
										);
	
	private $codificacion		= array('armacii8'		=> 'ARMSCII-8',
										'ascii'			=> 'ASCII',
										'big5'			=> 'BIG5',
										'binary'		=> 'ASCII',			// Puse algo
										'cp1250'		=> 'CP1250',
										'cp1251'		=> 'CP1251',
										'cp1256'		=> 'CP1256',
										'cp1257'		=> 'CP1257',
										'cp850'			=> 'CP850',
										'cp852'			=> 'CP850',			// Aproximado
										'cp866'			=> 'CP866',
										'cp932'			=> 'CP932',
										'dec8'			=> '',
										'eucjpms'		=> 'EUC-JP',
										'euckr'			=> 'EUC-KR',
										'gb2312'		=> 'ISO-2022-CN',		// puse algo
										'gbk'			=> 'GBK',
										'geostd8'		=> 'Georgian-Academy',//puse algo
										'greek'			=> 'ISO-8859-7',		// Aproximado
										'hebrew'		=> 'ISO-8859-7', 	// Aproximado
										'hp8'			=> 'HP-ROMAN8',
										'keybcs2'		=> '',
										'koi8r'			=> 'KOI8-R',
										'koi8u'			=> 'KOI8-U',
										'latin1'		=> 'CP1252',
										'latin2'		=> 'ISO-8859-2',
										'latin5'		=> 'ISO-8859-9',
										'latin7'		=> 'ISO-8859-13',
										'macce'			=> 'MacCentralEurope',
										'macroman'		=> 'MacRoman',
										'sjis'			=> 'SHIFT_JIS',
										'swe7'			=> '',
										'tis620'		=> 'TIS-620',
										'ucs2'			=> 'UCS-2',
										'ujis'			=> 'EUC-JP',
										'utf8'			=> 'UTF-8');
																				
	public function __construct($mdl,$ctr,$acc)
	{	parent::__construct($mdl,$ctr,$acc);
		// Veo que este conectado con el servidor
		if(!$_SESSION['OP_CONECT'])
		{	include_once ( 'modulos/conectar/' . DIR_CONTR . 'ConexionControl.php');
			$obj	= new ConexionControl('conectar','Conexion','formConexion');
			$obj->formConexion();
			return;
			exit();
		}
		// Me fijo que tenga elegida una base y una tabla
		if(empty($_SESSION['OP_BASE']) || empty($_SESSION['OP_TABLA']))
		{	$fcont	= new FrenteControl();
			$fcont->main('abmTablas','SeleccionarBase','seleccionarBase');
			return;
		}
		else
		{	// Si todo esta bien comienzo a generar el formulario
			include_once ( DIR_MDLAC . DIR_UTILI . 'FormularioGenerico.php');
			$this->obj_Form			= new FormularioGenerico($this->vista,$this->modelo);
			include_once ( DIR_OPET . DIR_UTILI . 'InfoCampos.php');
			$conexion				= $this->modelo->getMysqli();
			// Cargo Bases y Tablas en el sistema
			if(isset($_POST['opfg_elegir_base']))
			{	$_SESSION['OP_BASE']		= addslashes($_POST['opfg_elegir_base']);	}
			if(isset($_POST['opfg_elegir_tabla']))
			{	$_SESSION['OP_TABLA']		= addslashes($_POST['opfg_elegir_tabla']);	}
			$this->base				= $_SESSION['OP_BASE'];
			$this->tabla			= $_SESSION['OP_TABLA'];
			$this->obj_infoCampo	= new InfoCampos($conexion,$this->base,$this->tabla);
			$this->generar			= true;
		}
		
	}

	public function formGenerico()
	{	if(!$this->generar) {	return;	}
		$campos		= $this->obj_infoCampo->getArrayCampos();

		if(!$campos)
		{	$mensaje	= 'No se encontraron datos en la base de datos ' . $this->baseDeDatos;
			$mensaje	= $mensaje . '<br />Por lo cual No se puede diseñar un formulario. Por favor seleccione una nueva base y tabla.';
			include_once(DIR_OPET . DIR_CONTR . 'ErrorControl.php');
			//define('DIR_MDLAC', DIR_OPET );
			$obj_controlador		= new ErrorControl( DIR_OPET , 'ErrorControl','errorGenerico');
			$obj_controlador->errorGenerico('ERROR !!!',$mensaje);
			return false;			
		}
		
		$datos		= array();
		//array("campoMysql","etiqueta","tipoCampo","value","validacion","ayudaAJAX esc.","selectLevantarde","atrib.Fecha","atrEspec")
		$clavePrimaria	= '';
		$autoIncrement	= '';
		$tipoPrimaria	= ''; // PRI , UNI, MUL en caso de haber dos prima PRI
		$auxClave		= '';

		foreach ($campos as $clave => $valor)
		{

            if (strpos($clave, ' ')) {
                $mensaje	= 'Existen campos con nombres conteniendo espacios en la tabla ' . $this->tabla . '.-';
                $mensaje	= $mensaje . '<br />La rutina no funciona bien con este tipo de definiciones.<br /><br />Para prevenir errores y posible perdida de informacion la rutina se cancelo.';
                include_once(DIR_OPET . DIR_CONTR . 'ErrorControl.php');
                //define('DIR_MDLAC', DIR_OPET );
                $obj_controlador		= new ErrorControl( DIR_OPET , 'ErrorControl','errorGenerico');
                $obj_controlador->errorGenerico('ERROR !!!',$mensaje);
                return false;
                exit(0);
            }
            $campoMysql		= $clave;
			$etiqueta		= $valor['nombre'];
			$tipoMinuscula	= strtolower($valor['tipo']); // Se puede sacar strtolower
			$tipoCampo		= $this->tipoMysql_tipoForm[$tipoMinuscula][0]; // es el tipo de campo para el formulario
			$value			= $valor['defecto'];
			$charset		= explode('_',$valor['collation']);
			$codificacion	= (isset($this->codificacion[$charset[0]]))? $this->codificacion[$charset[0]] : null;
			$validacion		= $this->tipoMysql_tipoForm[$valor['tipo']][1];
			$valid_opc		= $this->validacion($validacion,$valor, $tipoCampo);
			$ayudaAjax		= '';
			$fecha			= '';
			$atrEspec		= '';
			//echo $clave . ' : ' . $codificacion.'<br />';
			
			switch($valor['clave'])
			{	case 'PRI':	$clavePrimaria		= $campoMysql;
							$autoIncrement		= $valor['extra'];
							$tipoPrimaria		= $valor['clave'];
							break;
				case 'UNI':	if($tipoPrimaria!='PRI')
							{	$clavePrimaria		= $campoMysql;
								$autoIncrement		= $valor['extra'];
								$tipoPrimaria		= $valor['clave'];
							}
							break;
				case 'MUL': if($tipoPrimaria!='PRI' && $tipoPrimaria!='UNI')
							{	$clavePrimaria		= $campoMysql;
								$autoIncrement		= $valor['extra'];
								$tipoPrimaria		= $valor['clave'];	
							}
							break;
				default:
			}
			
			if(!$clavePrimaria && !$auxClave && $valor['nulo']=='NO')
			{	$auxClave	= $campoMysql;	}
			//$retorno,$campo,$campoProp,$rompeSelect
			$datos[]		= array($campoMysql,$etiqueta . ' :',$valid_opc[1],$value,$valid_opc[0],$ayudaAjax,$valid_opc[2],$fecha,$atrEspec,$codificacion,$valid_opc[3]);
		}						
						
	 	$estilos	=	array(	"claseBase" =>	"formGenerico.css",
	 				 			"etiquetas"	=>	"etiquetasForm",
	 				 			"textarea"	=>	"inputTextForm",
	 				 			"select"	=>	"inputTextForm",
	 				 			"input"		=>	"inputTextForm",
	 				 			"button"	=>  "inputTextForm",
	 				 			"text"		=>	"inputTextForm",
	 							"tituloForm"=>	"titulosForm"
	 							);			
		$this->obj_Form->setAction("#");
		$this->obj_Form->setBaseTabla($this->base,$this->tabla);
		$iubase				= true;
		if(!$clavePrimaria)
		{	$clavePrimaria	= $auxClave;
			$iubase			= false;
		}
		if(!$clavePrimaria)
		{	$clavePrimaria	= $campoMysql;
			$iubase			= false;
		}		
		
		if($autoIncrement=='auto_increment')
		{	$this->obj_Form->setCampoIndice($clavePrimaria);	}
		else
		{	$this->obj_Form->setCampoIndice($clavePrimaria,null,null,1);	}
		$this->obj_Form->setAutoIncrement($autoIncrement);
		
		$this->obj_Form->setTitulos('ABM ' . $this->base . ' > ' . $this->tabla);
		$this->obj_Form->setEstilos($estilos);
		$this->obj_Form->setPropiedadesCampos($datos);
		$this->obj_Form->setIubase($iubase);
		$this->obj_Form->cuerpoFormulario();
		// Cargamos Los javascript necesarios va siempre
		$this->cargarJS( DIR_MDLAC, 'FormularioGenerico.js');
		$this->cargarJS( DIR_MDLAC, 'formBaseTabla_formGenerico.js');
	}
	
	private function validacion($tipo, $propiedades, $campo)
	{	$expresion	= $tipo;
		if($propiedades['nulo']=='YES' || $propiedades['extra']=='auto_increment')
		{	$minimo = '0';	}	else	{	$minimo	= '1';	}
		$maximo	= $propiedades['largo'];
		
		// Select 
		if($propiedades['tipo']=='set' || $propiedades['tipo']=='enum')
		{	$expresion	= 'select_alfanumerico_set';		}
		// Select Combinado con Base
		if($propiedades['claveForanea'] && $propiedades['clave']!='PRI' && $propiedades['clave']!='UNI')
		{	$expresion	= 'select_base';	}
		$rompeSelect	= '';
		$campoProp		= '';
		switch ($expresion)
		{	case 'select_entero':
					
					break;
			case 'decimal':
					$maximo		= str_replace(',','.',$propiedades['largo']);
					if(!$maximo)
					{	$tipoMySQL		= $propiedades['tipo'];
						$maximo			= $this->tipoMysql_tipoForm[$tipoMySQL][2];
						$mitad			= ceil($maximo/2);
						$maximo			= $mitad . '.' . $mitad;
					}
					$retorno	= $tipo . '-' . $minimo . ',' . $maximo; 				
					break;
			case 'select_alfanumerico_set':
					$retorno	= 'select_alfanumerico-' . $minimo . ',255';
					$campoProp	= 'set:' . $this->tabla . ',' . $propiedades['nombre'] . ',Seleccionar ...';
					$campo		= 'select';
					break;
			case 'select_base':
					$campoProp	= 'base:' . $propiedades['claveForanea'] . ',' . $propiedades['nombre'] . ',' . $propiedades['ayudas'] .', Seleccionar ...';
					$retorno	= 'select_' . $this->tipoMysql_tipoForm[$propiedades['tipo']][1] . '-' .$minimo . ',' . $maximo;
					$campo		= 'select';
					$rompeSelect= $propiedades['nombre'];
					break;
			case 'entero':
					$retorno	= $tipo . '-' . $minimo . ',' . $maximo;
					break;
			case 'codigoPlan':
					break;
			case 'alfanumerico':
					$retorno	= $tipo . '-' . $minimo . ',' . $maximo;
					break;
			case 'texto':
					$retorno	= $tipo . '-' . $minimo . ',' . $this->tipoMysql_tipoForm[$propiedades['tipo']][2];
					break;
			case 'minusculas':
					break;
			case 'mayusculas':
					break;
			case 'mayusculasDigit':
					break;
			case 'codigoMayus':
					break;
			case 'minusculasDigit':
					break;
			case 'codigoMinus':
					break;
			case 'codigoMayus':
					break;
			case 'correo':
					break;
			case 'ip':
					break;
			case 'link':
					break;
			case 'url':
					break;
			case 'fecha':
					$retorno	= $tipo;
					break;
			default:						
		}
		$return	= array($retorno,$campo,$campoProp,$rompeSelect); // Tipo Validacion , tipo campo de Formulario , Propiedades de llenado de campos select
		return $return;
	}
}