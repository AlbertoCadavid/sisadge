<?php
/**
 * Clase FormularioAccionesControl.
 * Contiene las funcionalidades del Formulario pues Generico Formulario
 * Solo se usa para armar el mismo y luego carece de utilidad.
 * @access	public
 * @author 	dypweb.net
 * @link 	info@dypweb.net
 * @package formulario Generico 
 */
class FormularioAccionesControl extends GenericoControl 
{	
	//private 	$obj_Modelo;
	/**
	 * Metodo Constructor.
	 * @param 	String	$acc	Nombre de la Accion
	 */
	public function __construct($mdl,$ctr,$acc)
	{	parent::__construct($mdl,$ctr,$acc);
		$this->modelo->getMysqli()->select_db($_SESSION['OP_BASE']);
	}
	
	public function insert()
	{	$tabla			= $_SESSION['OP_TABLA'];
		// Veo si dejo que el sistema ponga el autoincrement o no
		if($_SESSION['OPFG']['FORMULARIOS']['AUTOINCREMENT']=='auto_increment')
		{	$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];	}
		else
		{	$campoId	= '';	}
		
		// Genero un arreglo con las opciones de validacion y valores de campos
		$insert			= array();
		$validar		= array();
		$campos			= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];
		$datosJson		= array();
		$indice			= 0;
		foreach ($campos as $valor)
		{	$validar[]				= $valor[4];
			$nombreCampo			= $valor[0];
			$charSetIn				= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];
			$mostrar				= $_POST[$nombreCampo];

            if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv('UTF-8', $charSetIn . '//IGNORE//TRANSLIT', $valor);
            }
            //$mostrar				= @iconv('UTF-8',$charSetIn . '//IGNORE//TRANSLIT',$mostrar);

            $insert[$nombreCampo]	= $mostrar;
			$datosJson[]			= array('campo'	=> $nombreCampo,
											'valor'	=> $mostrar);	
			$indice++;		
		}
		// Envio a Realizar la insercion de Datos
		$resultado	= $this->modelo->insertarArray($tabla,$insert,$campoId,$validar);
		if($resultado===false)
		{	echo "No se validaron Correctamente todos los campos<br />En el Servidor";	}
		elseif (!$resultado)
		{	echo "El ingreso se realizo de forma satisfactoria.";
			$this->enviarJson($datosJson,FALSE);
		}
		else
		{	echo $resultado;	}
		echo $resultado;
	}
	
	public function delete()
	{	$tabla			= $_SESSION['OP_TABLA'];
		$where			= ' ';
		$campos			= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];

		foreach ($campos as $valor)
		{	$nombre		= $valor[0];
			$valor		= addslashes($_POST[$nombre]);
			if($valor) {	$where		.=$nombre . "='" .  $valor ."' && ";	}
		}
		$where			= substr($where,0,strlen($where)-3);
		$consulta		= "DELETE FROM ".$tabla." WHERE ".$where;
		echo (ABM_DEBUG)? $consulta : '';
		$resultado	= $this->modelo->consultaSimple($consulta);
		if($resultado)
		{	echo "Se borro exitosamente el Registro";	}
		else
		{	echo "No se pudo borrar el Registro."; }
	}
	
	public function edit()
	{	$consultaSet	= 'UPDATE ' . $_SESSION['OP_TABLA'] . ' SET ';
		$consultaWhere	= ' WHERE ';
		$campos			= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];
		//echo '<pre>'.var_dump($campos).'</pre>';
		$validaciones	= true;
		$datosJson		= array();
		$indice			= 0;
		foreach ($campos as $valor)
		{	$nombre		= $valor[0];
			$valor		= (isset($_POST[$nombre]))? addslashes($_POST[$nombre]) : '';

            $charSetIn	= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];

            $mostrar    = $valor;
            if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv('UTF-8', $charSetIn . '//IGNORE//TRANSLIT', $valor);
            }
			//$mostrar	= @iconv('UTF-8',$charSetIn . '//IGNORE//TRANSLIT',$valor);
			//////
			$decimal    = explode('-',$_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][4]);
			if($decimal[0]=='entero' || $decimal[0]=='decimal')
			{	$decimal	=	true;
					
			} else {
                $decimal = false;
			}
			//////
			$datosJson[]= array('campo'		=> $nombre,
								'valor'		=> $mostrar);
            $validar    = (isset($valor[4]))? $valor[4] : null;
			if(!$this->modelo->validar($validar,$mostrar))
			{	$validaciones	= false;
				break;
			}
			$consultaSet	.= "`" . $nombre . "`='" . $mostrar ."' , ";
			$indice++;
		}
		if(!$validaciones)
		{	echo "No se pudieron Validar los datos.";
			return false;
		}
		
		$datosAnt		= $_SESSION['OPFG']['FORMULARIOS']['DATOS'];
		foreach($datosAnt as $valor)
		{	//echo $valor['decimal'];
			$consultaWhere	.= "`" . $valor['campo'] . "`='" . $valor['valor'] . "' && ";	}

		$consultaSet	= substr($consultaSet,0,strlen($consultaSet)-2);
		$consultaWhere	= substr($consultaWhere,0,strlen($consultaWhere)-3);
		// DEBUGER
        echo (ABM_DEBUG)? $consultaSet . $consultaWhere : null;
        // FIN DEBUGGER
		$resultado		= $this->modelo->consultaSimple($consultaSet . $consultaWhere);
		if ($resultado)
		{	echo "La actualizacion se realizo de forma satisfactoria.";	}
		else
		{	echo "No se puedo Actualizar el registro.<br />";	}
		return true;
	}
	
	public function siguiente()
	{	$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$valorId	= $_POST[$campoId];
		$tabla		= $_SESSION['OP_TABLA'];
		$consulta	= "SELECT * FROM ".$tabla." WHERE `".$campoId."`>'".$valorId."' LIMIT 0,1";   
		$resultado	= $this->modelo->consultaSimple($consulta);
		// Convierto el resultado MySqli a Array para darselo a JSON
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		if($datos)
		{	$datosJson			= array();
			$indice				= 0;
			foreach ($datos as $clave => $valor)
			{	$charSetIn		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];
				$mostrar        = $valor;
                if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv($charSetIn,'UTF-8//IGNORE//TRANSLIT', $valor);
                }
                $datosJson[]	= array('campo'		=> $clave,
										'valor'		=> $mostrar);
			}
			$this->enviarJson($datosJson);
		}
		else {	$this->primero();	}
	}
	
	public function anterior()
	{	$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$valorId	= $_POST[$campoId];
		$tabla		= $_SESSION['OP_TABLA'];
		$consulta	= "SELECT * FROM ".$tabla." WHERE `".$campoId."`<'".$valorId."'ORDER BY ".$campoId." DESC LIMIT 0,1";    
		$resultado	= $this->modelo->consultaSimple($consulta);
		// Convierto el resultado MySqli a Array para darselo a JSON
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		if($datos)
		{	$datosJson			= array();
			$indice				= 0;
			foreach ($datos as $clave => $valor)
			{	$charSetIn		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];
				$mostrar        = $valor;
                if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv($charSetIn,'UTF-8//IGNORE//TRANSLIT', $valor);
                }
                $datosJson[]	= array('campo'	=> $clave,
										'valor'	=> $mostrar);
			}
			$this->enviarJson($datosJson);
		}
		else {	$this->ultimo();	}
	}
	
	
	
	public function primero()
	{	$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$tabla		= $_SESSION['OP_TABLA'];
		$consulta	= "SELECT * FROM ".$tabla." ORDER BY `".$campoId."` ASC LIMIT 0,1";    
		$resultado	= $this->modelo->consultaSimple($consulta);
		// Convierto el resultado MySqli a Array para darselo a JSON
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		if($datos)
		{	$datosJson			= array();
			$indice				= 0;
			foreach ($datos as $clave => $valor)
			{	$charSetIn		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];
                $mostrar        = $valor;
                if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv($charSetIn,'UTF-8//IGNORE//TRANSLIT', $valor);
                }
                $datosJson[]	= array('campo'	=> $clave,
										'valor'	=> $mostrar);
			}
		  	$this->enviarJson($datosJson);
		}
		else {	echo "Vacio";	}
	}
	
	public function ultimo()
	{	$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$tabla		= $_SESSION['OP_TABLA'];
		$consulta	= "SELECT * FROM ".$tabla." ORDER BY `".$campoId."` DESC LIMIT 0,1";    
		$resultado	= $this->modelo->consultaSimple($consulta);
		// Convierto el resultado MySqli a Array para darselo a JSON
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		if($datos)
		{	$datosJson			= array();
			$indice				= 0;
			foreach ($datos as $clave => $valor)
			{	$charSetIn		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];
				$mostrar        = $valor;
                if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv($charSetIn,'UTF-8//IGNORE//TRANSLIT', $valor);
                }
                $datosJson[]	= array('campo'	=> $clave,
										'valor'	=> $mostrar);
			}
			$this->enviarJson($datosJson);
		}
		else {	echo "Vacio";	}
	}
	
	public function buscar()
	{	// Arranco el paginador
        $indiceAbsoluto = 0;
        $indice         = 0;
		$config 		= Config::singleton();
		include_once( DIR_OPET .  DIR_UTILI . 'PaginarConsultas.php');
		$obj_paginar	= new PaginarConsultas();
		$obj_paginar	->setCEPP($config->get('cantidadDeEnlacesPorPagina'));
		$obj_paginar	->setCRPP($config->get('cantidadDeRegistrosPorPagina'));
		
		if(!$obj_paginar->generoConsulta())
		{	$obj_paginar->guardarConsulta($this->generarConsulta());	}
		// Esto lo armo en la clase que tiene conexion
		$consulta		= $obj_paginar->consultaFinal();
		$resultado		= $this->modelo->consultaSimple($consulta);
		$cantidad		= "SELECT FOUND_ROWS()";
		$cantidad		= $this->modelo->consultaSimple($cantidad);
		$cantResu		= $cantidad->fetch_row();
		$cntEnlace		= $cantResu[0];
		##############################################################################################
		// Aca va la vista o el HTML para los resultados
		// Cambiar para una plantilla tpl MGTheme
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
  		echo '<tr><td width="98%" class="titulos">Resultados de su Consulta</td>';
   		echo '<td width="1%"><img id="minimizeWindows" src="imagenes/button-minimize-grey.png" border=0></td>';
  		echo '<td width="1%"><img id="closeWindows" src="imagenes/button-close-grey.png" border=0></td></tr></table>';		
		
  		echo "<table id='consultaInterna' name='consultaInterna' border='0' cellpading='4px' width='100%'>\n";
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		
		while($datos)
		{
            $indice		= 0;
            $indiceAbsoluto++;
			echo "<tr>\n";
			$datosJson	= array();

			foreach ($datos as $clave => $valor)
			{
                echo "<td style='word-wrap: break-word;border-bottom:dashed;border-bottom-width:1px;'>";
				$charSetIn		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'][$indice][9];

                $mostrar    = $valor;
                if ($charSetIn != 'UTF-8' && $charSetIn) {
                    $mostrar    = @iconv($charSetIn, 'UTF-8//IGNORE//TRANSLIT', $valor);
                }
                //$mostrar        = @iconv($charSetIn,'UTF-8//IGNORE//TRANSLIT', utf8_encode($valor));
				//$mostrar		= mb_convert_encoding($valor,'UTF-8');
				$datosJson[]	= array('campo'	=> $clave,
										'valor'	=> $mostrar);
				echo "<div id='opfgsstmbuscar_".$indiceAbsoluto."'  title='".$mostrar."'><a href='#'>" . $mostrar . "</a></div>\n";
				echo "</td>";
                $indice++;
			}
			$campo			= json_encode($datosJson);
			$datos			= $resultado->fetch_array(MYSQLI_ASSOC);
			echo "<input name='opfgsstmcampobuscar_" . $indiceAbsoluto . "' id='opfgsstmcampobuscar_". $indiceAbsoluto ."' type='hidden' value='" . $campo . "' />";
			echo "</tr>\n";
		}
		if($indice==0) {	echo "<tr><td>No se Encontraron Coincidencias.</td></tr>";}
		else
		{	echo '<tr><td colspan="' . $indice . '">';
			$enlaces		= (isset($_GET['pgncn']))?
                              $obj_paginar->paginar($_GET['pgncn'],$cntEnlace) :
                              $obj_paginar->paginar(0,$cntEnlace);
			if(is_array($enlaces))
			{	echo '<center>';
				echo '<div id="opfg_div_paginacion" align="center" class="bordeTablas" style="width:665px; padding:5px; background-color:#76A0BB">';
				foreach ($enlaces as $clave => $valor)
				{	echo '<a href="javascript:pasarPagina(\'' . $valor['numero'] . '\');" class="paginador">' . $valor['vista'] . '</a>';	}
				echo '</div></center>';
				echo '</td></tr>';
			}
		}
		echo "</table>\n";
		// Fin vista o HTML
		##############################################################################################

	}
	
	private function generarConsulta()
	{	$tabla		= $_SESSION['OP_TABLA'];
		$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$ayuda		= (isset($_SESSION['OPFG']['FORMULARIOS']['AYUDAS']))?
                      $this->modelo->escaparMysql($_SESSION['OPFG']['FORMULARIOS']['AYUDAS']) :
                      null;
		if(!$ayuda)
		{	$ayuda = " * ";	}
		else
		{	$ayuda	= $this->modelo->escaparMysql($campoId).", ".$ayuda;	}
		$consulta	= "SELECT SQL_CALC_FOUND_ROWS ".$ayuda." FROM `" . $tabla . "` WHERE";
		$operador	= $this->modelo->escaparMysql($_POST["sstm__operador"]);
		if($operador=="OR")	{	$operador	= "||"; }else{	$operador	= "&&"; }
		
		$campos		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];

		foreach ($campos as $valor)
		{
            $nombreReal = $valor[0];
            $valor      = $_POST[$nombreReal];

			if($valor)
			{	$consulta	.=" `" . $nombreReal ."` like '%".$this->modelo->escaparMysql($valor)."%' ".$operador." ";	}
		}

		$largo		= strlen($consulta);
		$finConsulta= substr($consulta,$largo-5);
		if($finConsulta=="WHERE")
		{	$consulta	= substr($consulta,0,$largo-5);	}
		else
		{	$consulta	= substr($consulta,0,$largo-3);	}
		return $consulta;		
	}
	
	
	function getId()
	{	$tabla		= $_SESSION['OP_TABLA'];
		$campoId	= $_SESSION['OPFG']['FORMULARIOS']['INDICE'];
		$campoVal	= $this->modelo->escaparMysql($_POST['campoVal']);
		echo $consulta	= "SELECT * FROM ".$tabla." WHERE ".$campoId."='".$campoVal."'";
		$resultado	= $this->modelo->consultaSimple($consulta);
		// Convierto el resultado MySqli a Array para darselo a JSON
		$datos		= $resultado->fetch_array(MYSQLI_ASSOC);
		if($datos)
		{	$datosJson			= array();
			foreach ($datos as $clave => $valor)
			{	$datosJson[]	= array('campo'	=> $clave,
										'valor'	=> $valor);
			}
			$this->enviarJson($datosJson);
		}
		else {	echo "Vacio";	}
	}
	
	function rellenarCampos()
	{	
		
		
		
		
	}
	
	
	
	private function generarConsultaWhere($operador,$orden,$andOr='||')
	{	$campos		= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];
		$where		= '';
		$orderBy	= '';
		foreach ($campos as $valor)
		{	$nombre	= $valor[0];
			$valor	= addslashes($_POST[$nombre]);
			$where	.=$nombre . $operador . "'" . $valor . "' " . $andOr . ' ';
			$orderBy.=$nombre . ' ,';
		}
		$where 		= substr($where,0,strlen($where)-3);
		if($orden)
		{	$orderBy= substr($orderBy,0,strlen($orderBy)-1); 
			$orderBy= 'ORDER BY ' . $orderBy . $orden . ' ';
		}
		return 		$where.$orderBy;
	}
	
	private function enviarJson($arreglo,$mostrar=TRUE)
	{	// Cargar Datos Viejos
		$_SESSION['OPFG']['FORMULARIOS']['DATOS']	= $arreglo;
		if($mostrar) {	echo json_encode($arreglo);	}
	}
	
	public function cargarJson()
	{	$json			= array();
		$campos			= $_SESSION['OPFG']['FORMULARIOS']['CAMPOS'];
		foreach ($campos as $valor)
		{	$nombre		= $valor[0];
			$valor		= addslashes($_POST[$nombre]);
			$json[]		= array('campo'		=> $nombre,
								'valor'		=> $valor);
		}
		$_SESSION['OPFG']['FORMULARIOS']['DATOS']	= $json;
	}
}