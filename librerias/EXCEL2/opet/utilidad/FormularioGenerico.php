<?php
/**
 * Clase FormularioGenerico.
 * Se encarga de Generar un ABM a traves de Formularios de Control,
 * el metodo de envio es POST y aparte el id Formulario es formGenerico.
 * @author 		dypweb.net
 * @link 		info@dypweb.net
 * @version 	0.1 (27/08/2008) 	Firpue Sommll
 * @version 	0.2 (24/09/2008)	Error en nombre codigo solucionado
 * 									aparecio al cambiar los resultados de consulta para arriba.
 */
class FormularioGenerico  
{	/**
	 * Contiene una instancia de la clase vista MGTheme.
	 * @access 	private
	 * @var 	object
	 */		
	private	$obj_vista;

	/**
	 * Contiene una instancia del Modelo.
	 * @access 	private
	 * @var		object
	 */
	private $obj_modelo;

	/**
	 * Base de datos donde se encuentra la tabla.
	 * @access 	private
	 * @var 	string
	 */
	private $baseDeDatos;
	
	/**
	 * Tabla a la cual se le realizara el ABM.
	 * @access 	private
	 * @var		string
	 */
	private $tabla;
	
	
	private $ayuda;
	
	/**
	 * Es el campo de la tabla MySQL que identifica de manera unica a un 
	 * registro.
	 * @access 	private
	 * @var		string
	 */
	private $campoIndice;
	private $valorIndice;
	/**
	 *	Las siguientes son variables de propiedades de formulario.
	 * @access 	private
	 * @var		mixed
	 */
	private $action;
	private $encType;
	private $titulo;
	private $camposPropiedades	= array();
	private $estilosForm		= array();
	private $insertIndice;
	private	$disabledId;	
	
	private $calendarioGenerico	= false; 
	
	/**
	 * Constructor.
	 * @access 	public
	 * @param 	Vista $obj_vista	se pasa un objeto tipo MGTheme
	 * @return 	void
	 */
	public function __construct(Vista $obj_vista,GenericoModelo $obj_modelo)
	{	$this->obj_vista	= $obj_vista;
		$this->obj_modelo	= $obj_modelo;
		
		
	}
		
	#####################################################################
	# METODOS SET														#
	#####################################################################	
	
	public function setAction($action='')
	{	if($action)	{	$this->action	= $action;		}
		else 		{	$this->action	= "#";			}
	}
	
	public function setBaseTabla($base,$tabla)
	{	$this->baseDeDatos	= $base;
		$this->tabla		= $tabla;
		
	}
	
	public function setTitulos($titulo)
	{	$this->titulo	= $titulo;	}
	
	
	/**
	 * Metodo setPropiedadesCampos.
	 * @access 	public
	 * @param 	array	$datos	contiene datos de la tabla.
	 * 			array( 	array("campoMysql","etiqueta","tipoCampo","value","validacion","ayudaAJAX esc.","selectLevantarde","atrib.Fecha","atrEspec"),
	 * 					array(...............................));
	 */
	public function  setPropiedadesCampos($datos)
	{	if(is_array($datos))
		{	$this->camposPropiedades	= $datos;	}
		else
		{	echo "Debes enviar un arreglo de propiedades.";	}
	}
	
	public function setCampoIndice($campo,$disabled='disabled',$valor='',$instertIndice='0')
	{	$this->campoIndice	= $campo;
		$this->valorIndice	= $valor;
		$this->disabledId	= $disabled;
		$this->insertIndice	= $instertIndice;
	}
	
	/**
	 * Metodo Ayuda.
	 * Se encarga de setear que campos dara como resultado la consulta.
	 * @access 	public
	 * @param 	String	$ayuda del tipo "idCodigo,nombre,apellido" es lo que
	 * 					va antes del FROM
	 */
	public function setAyudas($ayuda)
	{	$this->ayuda	= $ayuda;	}
	
	
	/**
	 * array del tipo.
	 * array(	"claseBase" =>	"estilos.css",
	 * 			"etiquetas"	=>	"estilo_etiquetas",
	 * 			"textarea"	=>	"estilo_textArea",
	 * 			"select"	=>	"estilo_select",
	 * 			"input"		=>	"estilo_input",
	 * 			"button"	=>  "estilo_boton",
	 * 			"text"		=>	"estilo_text"
	 * 			"tituloForm"=>	"estilo_titulo");
	 *
	 * @param unknown_type $estilos
	 */
	public function setEstilos($estilos)
	{	if(is_array($estilos))
		{	$this->estilosForm		= $estilos;	}
		else
		{	echo "Debes enviar un arreglo de Estilos.";	}
	}
	
	public function cuerpoFormulario()
	{	$this->obj_vista->cargar(array('formulario' => 'formGenerico.tpl'));
	//	asignamos datos Basicos de Formulario	
		$this->obj_vista->AsignarVars(
			array(	"action"			=> $this->action,
					"titulo"			=> $this->titulo,
					"base"				=> $this->baseDeDatos,
					"tabla"				=> $this->tabla,
					"claseForm"			=> $this->estilosForm["tituloForm"],
					"indiceMySQL"		=> $this->campoIndice,
					"insertIndice"		=> $this->insertIndice,
					"valorIndiceMySQL"	=> $this->valorIndice,
					"valorAyudas"		=> $this->ayuda,
					"controlador"		=> $_GET["ctr"],
					"claseBase"			=> $this->estilosForm["claseBase"]
				));	
	
	// Asignamos Datos de campos
		$cantCampos		= count($this->camposPropiedades);
		for($f=0;$f<$cantCampos;$f++)
		{	$elementos	= "Campo no definido";
			// Vemos la plantilla para tipo de campo
			if($this->camposPropiedades[$f][0]!=$this->campoIndice)
			{	$disabled	=	"";}	else {	$disabled	= ""; /*$this->disabledId;*/	}
			switch ($this->camposPropiedades[$f][2])
			{	case	"text":
						$elementos	="<input validar='".$this->camposPropiedades[$f][4]."' value='".$this->camposPropiedades[$f][3]."' class='".$this->estilosForm["text"]."' type='text' name='".$this->camposPropiedades[$f][0]."' id='".$this->camposPropiedades[$f][0]."' ".$disabled." />\n";
						break;
				case	"select":
						$elementos	= "<select validar='".$this->camposPropiedades[$f][4]."' class='".$this->estilosForm["select"]."' name='".$this->camposPropiedades[$f][0]."' id='".$this->camposPropiedades[$f][0]."'>\n";
  						$elementos	= $elementos.$this->getDatosSelect($this->camposPropiedades[$f][6]);
						$elementos	= $elementos."</select>\n"; 
						break;
				case 	"textarea":
						$elementos	="<textarea validar='".$this->camposPropiedades[$f][4]."' class='".$this->estilosForm["select"]."' name='".$this->camposPropiedades[$f][0]."' id='".$this->camposPropiedades[$f][0]."' cols='25' rows='5'>".$this->camposPropiedades[$f][3]."</textarea>\n";
						break;
			}
			$botonEspecial	= "";
			if($this->camposPropiedades[$f][4]=="fecha")
			{	$botonEspecial = "<img src='iconos/calendar_view_week.png'  id='lanzador_".$this->camposPropiedades[$f][0]."' name='lanzador_".$this->camposPropiedades[$f][0]."' alt='Mostrar el Calendario.' title='Mostrar el Calendario.' />\n";
				if(!$this->calendarioGenerico)
				{	$scriptsJS	 = "<script type='text/javascript' src='JavaScript/aplicacion/calendar.js'></script>\n";
					$scriptsJS	.= "<script type='text/javascript' src='JavaScript/aplicacion/calendar-es.js'></script>\n";
					$scriptsJS	.= "<script type='text/javascript' src='JavaScript/aplicacion/calendar-setup.js'></script>\n";
					$scriptsJS	.= "<link type='text/css' href='estilos/win2k_4.css' rel='stylesheet'>\n";	
					$this->calendarioGenerico	= true;
					$this->obj_vista->AsignarVar("calendarioGenerico",$scriptsJS);
				}	
			}
			$datos	= array(
					"etiqueta"			=> $this->camposPropiedades[$f][1],
					"elementos"			=> $elementos,
					"class"				=> $this->estilosForm["etiquetas"],
					"btn"				=> $botonEspecial 
			);
			$this->obj_vista->AsignarBlocke('campos',$datos);
		}
	// Mostramos Plantilla
	$this->obj_vista->mostrar('formulario');		
	}
	
	public function getInsertIndice()
	{	return $this->insertIndice;  }

	public function getDatosSelect($datos)
	{	$consulta		= "";
		$tipo			= explode(":",$datos);
		$tipoLevante	= $tipo[0];
		$opciones		= $tipo[1];
		switch ($tipoLevante)
		{	case "base":
				$campos		= explode(",",$opciones);
				$consulta	= "SELECT ".$campos[1]." , ".$campos[2]." FROM ".$campos[0];
				$resultado	= $this->obj_modelo->consultaSimple($consulta);
				$retorno	= "";
				$linea		= $resultado->fetch_array();
				if($campos[3])
				{	$retorno	.= "<option value=''>";
					$retorno	.= $campos[3]."</option>\n";
				}
				while($linea)
				{	$retorno	.="<option value='".$linea[0]."'>";
					$retorno	.=$linea[1]."</option>\n";
					$linea		 = $resultado->fetch_array();
				}
				return $retorno;
				break;
			case "datos":
				return $retorno;
				break;
			case "set":
				$campos		= explode(",",$opciones);
				$consulta	= "SHOW fields FROM ".$campos[0]." WHERE field='".$campos[1]."'";
				$resultado	= $this->obj_modelo->consultaSimple($consulta);
				$linea		= $resultado->fetch_object();
				$selects	= $linea->Type;
				$selects	= substr($selects,4);
				$selects	= substr($selects,0,strlen($selects)-1);
				preg_match_all("/[a-zA-Z0-9·ÈÌÛ˙¡…Õ”⁄]+/",$selects,$opciones,PREG_PATTERN_ORDER);
				$cantOpcion = count($opciones[0]);
				$retorno	= "";
				if($campos[2])
				{	$retorno	.="<option value=''>".$campos[2]."</option>\n";	}
				for($f=0;$f<$cantOpcion;$f++)
				{	$retorno	.="<option value='".$opciones[0][$f]."'>";
					$retorno	.=$opciones[0][$f]."</option>\n";	
				}
				return $retorno;			
				break;	
		}
		return false ; #################
	}
}
?>
