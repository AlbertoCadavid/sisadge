<?php
/*
+----------------------------------------------------------------------
|		   Class MGTheme
|   ========================================
|   @developer  Marioly Garza
|   @copyright (C) 2005  MariolyGroup
|   @license GNU/GPL
|
|   ========================================
|   @Web hackyashira.com
|   @Email marioly@marioly.com
+-----------------------------------------------------------------------
|
|   > Clase para manejo de archivos template
|   + Manejo de variables
|   + Blockes
|   + Sub-Blockes
|   + Archivos anidados
|
+----------------------------------------------------------------------
*/

class Vista
{	// Directorio de templates
	private	$home 			= '';
   	// Archivos template
   	private	$archivos 		= array();
   	// Vars tpl
   	private	$datos_var 		= array();
   	// Vars tpl de blocke
   	private	$datos_blk 		= array();
   	// Archivos Asignados a parse
   	private	$datos_arc 		= array();
    // Configuro si sale utf8 u otro tipo de codificacion
    private $codificacion	= false;
    
	/**
	* Class Constructor
	* Define el directorio principal de templates
	*
	* @param string $home directorio de templates
	*/
	public function __construct($home='')
	{	if(!is_dir($home))
	   	{	trigger_error("MGTheme: Directorio Invalido (" . $home . ")", E_USER_ERROR);	}
	   
	   	$home = (substr($home, -1) != '/') ? $home . "/" : $home;
	   $this->home = $home;
	}
	
   /**
	* Asigna archivos template
	* 
	* @param array $archivos array asociativo de archivos
	*/
	public function Cargar($archivos)
	{	if (!is_array($archivos))
		{	return false;	}

		reset($archivos);
		foreach($archivos as $nombre => $archivo)
		{	$this->archivos[$nombre] = $this->home . $archivo;
			if(!file_exists($this->archivos[$nombre]))
			{	trigger_error("MGTheme->Cargar(): Archivo no Encontrado (" . $this->archivos[$nombre] . ")", E_USER_ERROR);	}
		}
		return true;	   
	}
	
	/**
	* Imprime resultado final
	* 
	* @param string $archivo archivo a imprimir
	*/
	public function Mostrar($archivo)
	{	if (!$this->archivos[$archivo])
		{	trigger_error("MGTheme->mostrar(): No existe archivo asignado a " . $archivo , E_USER_ERROR);	}
		//Verificar archivos asignados a parse
		$this->CheckAsignArc();
		//Mostrar resultado final
		print $this->Compilar($this->archivos[$archivo]);
	}
	
	/**
	* Asigna variable de archivo anidado.
	* 
	* @param string $var nombre variable
	* @param $archivo referencia de archivo
	*/
	public function AsignarVarArc($var, $archivo)
	{	if (!$this->archivos[$archivo])
		{	trigger_error("MGTheme->AsignarVarArc(): No existe archivo asignado a " . $archivo , E_USER_ERROR);	}
		$this->datos_arc[$var] = $archivo;
		return true;
	}
	
	/**
	* Asigna valor a variables tpl de blocke
	*
	* @param string $blocke nombre blocke
	* @param array $valores array asociativo de valores
	*/
	public function AsignarBlocke($blocke, $valores)
	{	$lastiteration		= '';
		if (strstr($blocke, '.'))
		{	// Sub-Blocke
			$blockes 		= explode('.', $blocke);
			$blockcount 	= sizeof($blockes) - 1;
			$str = '$this->datos_blk';
			for ($i = 0; $i < $blockcount; $i++)
			{	$str .= '[\'' . $blockes[$i] . '\']';
				eval('$lastiteration = sizeof(' . $str . ') - 1;');
				$str .= '[' . $lastiteration . ']';
			}
			$str .= '[\'' . $blockes[$blockcount] . '\'][] = $valores;';
			eval($str);
		}
		else
		{	//Blocke Normal
			$this->datos_blk[$blocke][] = $valores;
		}
		return true;
	}
 
	/*
	* Asigna valor a variables tpl 
	*
	* @param array $valores array asociativo de valores
	*/
	public function AsignarVars($valores)
	{	reset($valores);
		 foreach($valores as $var => $valor)
		 {	$this->datos_var[$var] = $valor;	}
		  return true;
	}	

	/**
	* Asigna valor a solo una variable tpl
	*
	* @param string $var nombre var
	* @param string $valor valor var
	*/
	public function AsignarVar($var, $valor)
	{	$this->datos_var[$var] = $valor;
		return true;
	}
	
	/**
	* Verifica archivos asignados a parse
	*
	*/
	public function CheckAsignArc()
	{	if(!empty($this->datos_arc))
	   	{	foreach($this->datos_arc as $var => $archivo)
		   	{	$data = '';
			  	//Obtener contenido parseado del archivo
			  	$data = $this->Compilar($this->archivos[$archivo]);
			  	//Asignar el contenido a la variable especificada
			  	$this->AsignarVar($var, $data);
		   	}
	   	}
	   	return true;
	}

	/**
	* Procesa el contenido del archivo cambiando variables tpl
	* por el valor programado y retorna resultado final
	*
	* @param string $archivo archivo a procesar
	*/
	private function Compilar($archivo)
	{	$cont 		= implode("", @file($archivo));
		if (empty($cont))
		{	trigger_error("MGTheme->Compilar(): El archivo esta vacio." , E_USER_ERROR);	}	
		
		if(!empty($this->datos_var))
		{	reset($this->datos_var);
		  	foreach($this->datos_var as $var => $valor)
		  	{	// Remplazar variables
			 	$cont = str_replace("{" . $var . "}", preg_replace(array('/{/', '/}/'), array('&mgv;', '&mlv;'), $valor), $cont);
		  	} 
		}
		$final_blocke = array();
		
		if(!empty($this->datos_blk))
		{	reset($this->datos_blk);
			// Blockes			
			list($block) = each($this->datos_blk);
			while($block)
			{	$final_blocke[$block] = $this->Blk($cont, $this->datos_blk, $block, '', false);
				$cont = preg_replace("@<!--\s+BEGIN\s+" . $block . "\s+-->(.*?)<!--\s+END\s+" . $block . "\s+-->@sm", $final_blocke[$block], $cont);				  
				list($block) = each($this->datos_blk);
			}
		} 
		//Anular blockes no usados
		$cont = preg_replace('@<!--\s+BEGIN\s+([0-9A-Za-z_-]+)\s+-->(.*)<!--\s+END\s+\1\s+-->@sU', '', $cont);

		//Anular variables no usadas
		$cont = preg_replace('/{(.*?)}/', '', $cont);
		$cont = preg_replace(array('/&mgv;/i', '/&mlv;/i'), array('{', '}'), $cont);
		if($this->codificacion)
		{	$cont	= utf8_encode( $cont );	}
		return  $cont ;		
	}

	/**
	* Metodo recursivo para blockes y sub-blockes 
	* lo que hace posible procesar arreglos tipo:
	* $this->datos_blk['parent'][]['$child'][]['$child2'][]...['$childN']
	*
	* @param string $texto texto a procesar
	* @param object $objeto objeto a desglosar
	* @param string $blocke nombre blocke
	* @param string $orig_blocke blocke padre (si existe)
	* @param bool $sub indicativo de sub-blocke
	*/
	private function Blk($texto, $objeto, $blocke, $orig_blocke = '', $sub = false)
	{	if(empty($blocke))
		{	return $texto;	}
	   
		$texto_blk 		= '';
		
		// Contenido original de blocke
		if(preg_match("/<!-- BEGIN " . $blocke . " -->(.*?)<!-- END " . $blocke . " -->/sU", $texto, $text))
		{	$texto_blk 	= $text[1];	}
					   
		$orig_blocke 	= ($sub == true) ? $orig_blocke . "." : "";
		$final_blocke 	= array();
		$contar 		= sizeof($objeto[$blocke]) - 1;
		
		// Definir remplazos
		for($i = 0; $i <= $contar; $i++)
		{	$orig_blk = $repl_blk = $sublock = array();
			foreach($objeto[$blocke][$i] as $var => $valor)
			{	if(is_array($valor) && !in_array($var, $sublock) && !empty($var))
				 {	$sublock[] = $var;	}
				 else
				 {	$orig_blk[] = "/{" . $orig_blocke . $blocke . "." . $var . "}/";
				   	$repl_blk[] = preg_replace(array('/{/', '/}/'), array('&mgv;', '&mlv;'), $valor);
				 }
			}
			
			$texto_proc = $texto_blk;
			
			// Rutina de Sub-blockes (sino existe solo retornamos texto)
			$contar2 = sizeof($sublock) - 1;
			for($m = 0; $m <= $contar2; $m++)
			{	$texto_proc = $this->Blk($texto_proc, $objeto[$blocke][$i], $sublock[$m], $blocke, true);	}
			
			// blocke final (vector) // Modificado para que no largue notice el original es solo el marcado con *
            if (!isset($final_blocke[$blocke])) {
                $final_blocke[$blocke] = null;
            }
            $final_blocke[$blocke] .= preg_replace($orig_blk, $repl_blk, ' ' . $texto_proc . ' ');
		}   
		// Si es Sub-blocke remplazamos contenido, sino solo devolvemos texto
		$texto = ($sub == true) ? preg_replace("@<!--\s+BEGIN\s+" . $blocke . "\s+-->(.*?)<!--\s+END\s+" . $blocke . "\s+-->@sU", $final_blocke[$blocke], $texto) : $final_blocke[$blocke];			  
		return $texto;
   }
   
   	/**
   	 * Resetea la vista dejandola limpia para generar otra.
   	 * Sirve para generar una vista capturandola con funciones ob_xxxxx, y luego limpiamos y volvemos
   	 * a generar otra vista.
   	 * @return	void
   	 */
	public function resetearVista()
   	{	unset($this->archivos);
   		unset($this->datos_arc);
   		unset($this->datos_blk);
   		unset($this->datos_var);
	}
	
	public function setDirectorioVista($home='')
	{	if(!is_dir($home))
	   	{	trigger_error("MGTheme: Directorio Invalido (" . $home . ")", E_USER_ERROR);	}
	   
	   	$home = (substr($home, -1) != '/') ? $home . "/" : $home;
	   $this->home = $home;
	}
	
	public function setSalidaUTF8($boolean)
	{	$this->codificacion	= $boolean;	}	
}