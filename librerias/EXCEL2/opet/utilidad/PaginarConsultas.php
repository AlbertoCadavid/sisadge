<?php
/**
 * Pagina un Resultado de acuerdo a los parametros establecidos.
 * @author 		Marcelo Castro
 * @link 		w.marcelo.castro@gmail.com
 * @version 	1.0 	(16/06/2008) Extraida de la clase Buscador Generico 4.4.6	
 * @version 	1.0.1	(18/06/2008) Ajuste en Salto de Bloques.
 */
class PaginarConsultas
{
	/**
 	* Contiene las vistas a desplegar para la primera pagina, ultima,
 	* siguiente, anterior, bloque anterior y bloque siguiente. 
 	* @access 	private
 	* @var		array
 	*/
	private $titulos	= array();
	
	/**
	 * Guarda el resultado de la paginacion en un array, por si es
	 * requerido mas tarde.
	 * @access 	private
	 * @var 	array
	 */
	private $retorno;
	
	/**
	 * Son la cantidad de registros, filas de la tabla que se mostraran por
	 * cada pantalla.
	 * @access 	private
	 * @var		integer
	 */
	private $cantidadDeRegistrosPorPagina	= 10;
	
	/**
	 * Es la cantidad de enlaces del paginador sin contar los especiales como ser:
	 * primera, ultima, ... es decir los titulos.
	 * @access 	private
	 * @var		integer
	 */
	private $cantidadDeEnlacesPorPagina		= 10;
	
	/**
	 * Metodo constructor.
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{	$this->titulos["primer"]= "| Primero ...";
		$this->titulos["bAnter"]= "<<";
		$this->titulos["anteri"]= "<";
		$this->titulos["siguie"]= ">";
		$this->titulos["bSigui"]= ">>";
		$this->titulos["ultima"]= "... Ultimo |";
	}
	
	/**
	 * Configura la cantidad de enlaces por pagina.
	 * @access 	public
	 * @param 	integer		$cantidad
	 * @return 	void
	 */
	public function setCEPP($cantidad=10)
	{	$this->cantidadDeEnlacesPorPagina	= $cantidad;	}
	
	/**
	 * Configura la cantidad de registros por pagina.
	 * @access	public
	 * @param	integer		$cantidad
	 * @return 	void
	 */
	public function setCRPP($cantidad=10)
	{	$this->cantidadDeRegistrosPorPagina	= $cantidad;	}
	
	/**
	 * Realiza todos los calculos del paginado y guarda los enlaces en un array.
	 *
	 * @param	integer		$pgn Contiene que pagina se desplegara.
	 * @param	integer		$cantidadDeEnlaces	total de resultados de la consulta SELECT.
	 * @return	array		conteniendo pares para vista y numero
	 */
	public function paginar($pgn,$cantidadDeEnlaces)
	{	$cantidadDeRegistrosPorPagina	= $this->cantidadDeRegistrosPorPagina;
		$cantidadDeEnlacesPorPagina		= $this->cantidadDeEnlacesPorPagina;
		$ind=0;
		$filaPag = array();
		$total_paginas	= ceil($cantidadDeEnlaces / $cantidadDeRegistrosPorPagina);
		if ($total_paginas<2) {return false;}
	
	   	if ($total_paginas <= $cantidadDeEnlacesPorPagina)  
		{	$a		= 1;
			$b		= $total_paginas;
		}
		else
		{	$pa 	= floor($this->cantidadDeEnlacesPorPagina / 2);
			$a		= ($pgn+1) - $pa;
			$b		= $a + $this->cantidadDeEnlacesPorPagina -1;

			if ($b > $total_paginas)
			{	$b		= $total_paginas;
				$a		= $b - ($this->cantidadDeEnlacesPorPagina -1);
			}
		
			if ($a < 1)
			{	$a		= 1;
				$b		= $cantidadDeEnlacesPorPagina;
			}
		}
		$ajuste				= floor($cantidadDeEnlacesPorPagina/2);
		$ajuste2			= 1-($cantidadDeEnlacesPorPagina%2);
		$blockInicio		= $a - $cantidadDeEnlacesPorPagina + $ajuste  - 1;
		$blockFinal			= $b + $cantidadDeEnlacesPorPagina - $ajuste  + $ajuste2;
	
		$a		= $a-1;
		$b		= $b-1;
		if ($total_paginas>1)
		{
		if ($a != 0)
		{	$filaPag[$ind] = array("numero"=> 0,"vista"=>$this->titulos["primer"]);
			$ind++;
		}
		/* Configurar Block de Inicio */
		if($blockInicio>$ajuste)
		{	$filaPag[$ind] = array("numero"=>$blockInicio,"vista"=>$this->titulos["bAnter"]);
			$ind++;}
		/* Fin block Inicial */
		/* Configurar anterior */
		if($pgn>0)
		{	$filaPag[$ind] = array("numero"=>($pgn-1),"vista"=>$this->titulos["anteri"]);
			$ind++;}
		/* Fin block anterior */
		/* Inicio Block Central */
		for ( $f = $a; $f <= $b; $f++)
		{	if ($f != $pgn)
			{	$filaPag[$ind] = array("numero"=> $f,"vista"=>($f+1));
				$ind++;
			}
			else
			{	$filaPag[$ind] = array("numero"=> $f,"vista"=>"<b>|".($f+1)."|</b>");
				$ind++;
			}
		}
		/* Fin block Central */
		/* Configurar siguiente */
		if($pgn<($total_paginas-1))
		{	$filaPag[$ind] = array("numero"=>($pgn+1),"vista"=>$this->titulos["siguie"]);
			$ind++;}
		/* Fin block siguiente */
		/* Configurar Block de Final */
		if($b<($total_paginas-$cantidadDeEnlacesPorPagina-1))
		{	$filaPag[$ind] = array("numero"=>$blockFinal-1,"vista"=>$this->titulos["bSigui"]);
			$ind++;}
		/* Fin block Final */	
		
		if ( $b != ($total_paginas-1))	
		{	$filaPag[$ind] = array("numero"=> ($total_paginas-1),"vista"=>$this->titulos["ultima"]);
			$ind++;
		}
		}
		$this->retorno = $filaPag;
		return $filaPag;
	}
	
	/**
	 * Configura los titulos.
	 * @deprecated 		Proximamente sera cambiada.
	 * @access 	public
	 * @param 	string	$primera
	 * @param 	string	$bloqueAnterior
	 * @param 	string	$anterior
	 * @param 	string	$siguiente
	 * @param 	string	$bloqueSiguiente
	 * @param 	string	$ultima
	 */
	public function agregarComentarios($primera,$bloqueAnterior,$anterior,$siguiente,$bloqueSiguiente,$ultima)
	{	if($primera) 		{	$this->titulos["primer"] = $primera; }
		if($bloqueAnterior) {	$this->titulos["bAnter"] = $bloqueAnterior; }
		if($anterior) 		{	$this->titulos["anteri"] = $anterior; }
		if($siguiente) 		{	$this->titulos["siguie"] = $siguiente; }
		if($bloqueSiguiente){	$this->titulos["bSigui"] = $bloqueSiguiente; }
		if($ultima) 		{	$this->titulos["ultima"] = $ultima; }
	}
	
	
	public function generoConsulta()
	{	if(isset($_GET['pgncn']))
		{	return true;	}
		return false;
	}
	
	public function guardarConsulta($consulta)
	{	$_SESSION['OP_PAGINADOR_CONSULTA']	= $consulta;	}
	
	public function consultaFinal()
	{	$inicioConsulta	= (isset($_GET['pgncn']))?
                          ($_GET['pgncn']*$this->cantidadDeRegistrosPorPagina) :
                           0;
		$consulta		= $_SESSION['OP_PAGINADOR_CONSULTA'] . " LIMIT $inicioConsulta, " . $this->cantidadDeRegistrosPorPagina;
		return $consulta;
	}
}
