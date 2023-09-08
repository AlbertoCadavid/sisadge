<?php
/**
 * Clase Encargada de Subir Archivos al Servidor.
 * 
 * @copyright	2009 - ObjetivoPHP
 * @license 	Libre (Free)
 * @author 		Marcelo Castro (objetivoPHP)
 * @link 		objetivophp@gmail.com
 * @version 	1.3.0 (08/09/2009)
 */
class CargarArchivo
{	
	/**
	 * Nombre del campo de formulario tipo file, que tiene el archivo a subir.
	 * @var		String
	 */
	private $sstm_nombreCampo;
	
	/**
	 * Nombre del directorio destino. Es decir donde quedara el archivo en el servidor.
	 * @var 	String
	 */
	private $sstm_directorioDestino;
	
	/**
	 * Maximo tama�o permitido del archivo en Kb.
	 * @var 	Integer
	 */
	private $sstm_maximoPesoKb;
	
	/**
	 * Minimo tama�o permitido del archivo en Kb.
	 * @var 	Integer
	 */
	private $sstm_minimoPesoKb;
	
	/**
	 * Guarda el ultimo tipo de error.
	 * @var		String
	 */
	private $sstm_errores           = "";
	
	/**
	 * Nombre con el que quedara el archivo en el servidor
	 * @var		String
	 */
	private $sstm_nombreDestino;
	
	/**
	 * Contiene el tipo Mime del ultimo archivo subido al servidor.
	 * @var 	String
	 */
	private $sstm_tipoArchivo;
	
	/**
	 * Establece que accion se toma en el servidor en caso de que exista el mimo nombre de archivo en
	 * el destiono. Por defecto se renombra, pero se puede remplazar o Cancelar la subida.
	 * @var 	String
	 */
	private $sstm_accion			= "renombrar";

	/**
	 * Nos dice si el campo file puede ser nulo o no.
	 * Si puede ser nulo la clase no lo tomara como error.
	 * @var		Boolean
	 */
	private $sstm_nulo				= true;
	
	/**
	 * Guarda el directorio temporal donde se suben los archivos al servidor.
	 * @var		String
	 */
	private $nombreTemporal;
	
	/**
	 * Guarda el Peso del archivo que fue subido al servidor.
	 * @var		Integer
	 */
	private $pesoArchivo;
	
	/**
	 * Guarda los tipos de archivos que se permitiran subir al servidor.
	 * @var		Array
	 */
	private $tipoArchivo			= array();
	
	/**
	 * Guarda el nombre original del archivo subido.
	 * @var		String
	 */
	private $nombreOriginal;
	
	/**
	 * Contiene los mensajes de error para los codigos de errores correspondientes.
	 * @var		Array
	 */
	private $msjErroresCA			= array(
									"noArchivo"			=> "No hay archivo que subir.<br>Rutina Truncada",
									"archivoMayor"		=> "El archivo supera el tama�o Maximo Permitido.<br>Rutina Truncada",
									"archivoMenor"		=> "El archivo es menor a lo requerido.<br>Rutina Truncada",
									"noMime"			=> "Un tipo Mime es desconocido<br>No se ha tomado en cuenta.<br>Rutina Truncada",
									"tipoArchivoErroneo"=> "Tipo de Archivo no permitido para subir al Servidor",
									"cancelar"			=> "Cancelada carga de archivo por existir en servidor.",
									"noCampoFile"		=> "No se definio ningun campo FILE.<br>Rutina truncada",
									"noUpload"			=> "El Archivo no pudo moverse al directorio planillas.<br />Verifique los permisos del directorio."
									);


	/**
	 * Metodo Constructor encargado de inicializar las Variables.
	 * @param 	String			$nombreCampo	Campo de Formulario que contiene el archivo.
	 * @return 	cargarArchivo
	 */
	public function CargarArchivo($nombreCampo,$directorioDestino="/",$nombreDestino='')
	{   if($nombreCampo)
		{	$this->sstm_nombreCampo	= $nombreCampo; }
		else
		{	$this->sstm_errores	="noCampoFile";
			return false;
		}
		$this->nombreTemporal	= $_FILES[$this->sstm_nombreCampo]["tmp_name"];
		$this->sstm_tipoArchivo	= $_FILES[$this->sstm_nombreCampo]["type"];
		$this->nombreOriginal	= $_FILES[$this->sstm_nombreCampo]["name"];
		$this->pesoArchivo		= $_FILES[$this->sstm_nombreCampo]["size"]/1024;

		$this->sstm_directorioDestino	= $directorioDestino;

		if($nombreDestino)
		{	$this->sstm_nombreDestino	= $nombreDestino; }
		else
		{	$this->sstm_nombreDestino	= $this->nombreOriginal; }
		return true;
	}

	/**
	 * Configura si el campo puede ser nulo o no.
	 * Si puede ser nulo entonces entonces no se tomara como error(clave true).
	 * No puede ser nulo entonces dara error(clave false).
	 * @param boolean	$nulo true por si - false por no.
	 */
	function setNulo($nulo)
	{	switch ($nulo)
		{	case	true:
					$this->sstm_nulo	= true;
			break;
			case 	false:
					$this->sstm_nulo	= false;
			default:
			break;
		}
	}

	/**
	 * Verifica si se subio realmente un archivo o no.
	 * @param	String	$nombreCampo
	 * @return	boolean true si existe - false si no existe.
	 **/
	public function existeArchivoLocal()
	{	if($this->pesoArchivo)
		{	return true;	}	else {	return false;}
	}

	/**
	 * Configura el maximo peso de archivo permitido en kb.
	 * @param	Integer		$pesoMaximo
	 */
	public function setPesoMaximo($pesoMaximo)
	{	$this->sstm_maximoPesoKb	= $pesoMaximo;	}

	/**
	 * Configura el minimo peso de archivo permitido en kb.
	 * @param	Integer		$pesoMinimo
	 */
	public function setPesoMinimo($pesoMinimo)
	{	$this->sstm_minimoPesoKb	= $pesoMinimo;	}

	/**
	 * Configura el Directorio donde se guardara el Archivo.
	 * @param	String	$directorio
	 */
	public function setDirectorioDestino($directorio)
	{	$this->sstm_directorioDestino	= $directorio;	}

	/**
	 * Configura el Nombre del archivo en el servidor.
	 * @param 	String	$nombre
	 */
	public function setNombreDestino($nombre)
	{	if($nombre) {	$this->sstm_nombreDestino	= $nombre; }	}

	/**
	 * Retorna el nombre con el cual quedara el archivo en el Servidor.
	 * Util para usar con la accion renombrar.
	 * @return	String	Conteniendo el Nombre final del archivo en el servidor.
	 */
	public function getNombreDestino()
	{	return $this->sstm_nombreDestino;	}

	/**
	 * Configura la accion a tomar en caso de que el fichero exista en el servidor.
	 * Si no se configura esta variable la accion por defecto es renombrar.
	 * @param 	String $accion Toma solo 3 valores renombrar - cancelar - remplazar
	 */
	public function setAccion($accion)
	{	if($accion!="renombrar" && $accion!="cancelar" && $accion!="remplazar")
		{	return ; }
		$this->sstm_accion		= $accion;
	}
	
	/**
	 * Mueve un archivo del directorio temporal al destino, luego de chequear las restricciones.
	 * @return		Boolean
	 */
	public function subir()
	{	if(!$this->existeArchivoLocal())
		{	if($this->sstm_nulo)
			{ return true; }
			else
			{	$this->sstm_errores		= "noArchivo";
				return false;
			}
		}

		if(!$this->chequearRestricciones()) return false;
		//$existe	= $this->existeArchivo();

		if($this->siExiste())
		{	$error	= @move_uploaded_file($this->nombreTemporal,$this->sstm_directorioDestino.$this->sstm_nombreDestino);
			if(!$error)
			{	$this->sstm_errores		= 'noUpload';
				return false;
			}
		}
		else
		{	return false;	}
		return true;
	}

	/**
	 * Devuelve el Error que se pudo haber cometido.
	 * @return	String	Contiene el codifo de Error.
	 */
	public function getErrores()
	{
        if (isset($this->sstm_errores) && $this->sstm_errores) {
            return $this->msjErroresCA[$this->sstm_errores];
        } else {
            return null;
        }
    }


	/**
	 * Se encarga de Chequear que se cumplan las restricciones del usuario.
	 * Tanto en tama�o como en tipo de archivo.
	 * @return 	boolean true si se cumplieron - false en caso contrario.
	 */
	public function chequearRestricciones()
	{	// Chequeo Tama�o Maximo
		if($this->sstm_maximoPesoKb &&  ($this->pesoArchivo>$this->sstm_maximoPesoKb))
		{	$this->sstm_errores	="archivoMayor";
			return false;
		}
		// Chequeo Tama�o Minimo
		if($this->sstm_minimoPesoKb && $this->pesoArchivo<$this->sstm_minimoPesoKb)
		{	$this->sstm_errores	="archivoMenor";
			return false;
		}
		// Chequear Mime
		if(!count($this->tipoArchivo))	return true;

		if(!in_array($this->sstm_tipoArchivo,$this->tipoArchivo))
		{	$this->sstm_errores	= "tipoArchivoErroneo";
			return false;
		}
		return true;
	}

	/**
	 * Verifica si un archivo existe o no en el directorio actual.
	 * @param 	String	$nombreArchivo
	 * @return	boolean	true si existe - false si no existe en el directorio.
	 */
	public function existeArchivo($nombreArchivo='')
	{	if(!$nombreArchivo)	{	$nombreArchivo	= $this->sstm_nombreDestino;}
		if(file_exists($this->sstm_directorioDestino.$nombreArchivo))
		{	return true;	}
		return false;
	}

	/**
	 * Al momento de realizar la copia en destino del archivo verifica la
	 * existencia del mismo y toma la accion elegida.
	 * remplazar	: Remplaza el archivo.
	 * cancelar		: cancela la subida del archivo.
	 * renombrar	: renombra automaticamente el archivo.
	 * @param	String	Accion a tomar.
	 */
	private function siExiste($accion='')
	{	$this->setAccion($accion);
		switch ($this->sstm_accion)
		{	case "remplazar":
					$accion = true;
				break;
			case "cancelar":
				$this->sstm_errores	="cancelar";
				$accion	= false;
				break;
			case "renombrar":
				$ind		= 0;
				$archivo	= explode(".",$this->sstm_nombreDestino);
				while($this->existeArchivo())
				{	$this->sstm_nombreDestino =	$archivo[0]."_".$ind.".".$archivo[1];
					$ind++;
				}
				$accion	= true;
				break;
		}
	return $accion;
	}
	
	/**
	 * Retorna el tipo Mime del ultimo archivo Subido al servidor.
	 * @return	String		Conteniendo el tipo Mime del archivo subido.
	 */
	public function getTipoArchivo()
	{	return $this->sstm_tipoArchivo;	}
	
	/**
	 * Agrega los Archivos que se pueden subir si se omite permite cualquier tipo.
	 * Se debe especificar en formato MIME al final se incluye listado.
	 * @param	String	$tipoMIME
	 */
	public function agregarTiposArchivos($tipoMIME)
	{	if(!$tipoMIME) { return true; }
		if(!$this->verificarMime($tipoMIME))
		{	$this->sstm_errores	= "noMime"; return false; }
		$this->tipoArchivo[]	= $tipoMIME;
		return true;
	}

	/**
	 * Agrega un grupo de Archivos que se podran subir.
	 * Por ejemplo para subir imagenes no ingresamos por tipos si no
	 * que usaremos esta funcion con el parametro "image".
	 * @param	String	$grupoMime	Corresponde a un grupo de Archivos mime.
	 */
	public function agregarGrupoArchivos($grupoMime)
	{	$grupoMime	= strtolower($grupoMime)."/";
		foreach ($this->matrizMime as $valor)
		{	$mime	= explode("/",$valor);

			if($grupoMime==$mime[0]."/")
			{	$this->tipoArchivo[]	= $valor;}
		}
	}

	/**
	 * Lista los tipos de Archivo MIME posibles de ser cargados.
	 * @return 	Visualiza en pantalla.
	 */
	public function getMime()
	{	if(!count($this->tipoArchivo)) {	return;	}
		echo "<pre>";
		echo "   ### TIPOS ARCHIVOS SOPORTADOS ###<br />";
		echo "   =================================<br />";
		foreach ($this->tipoArchivo as $valor)
		{	echo "   ".$valor."<br />";			}
		echo "   =================================<br />";
		echo "</pre>";
	}

	/**
	 * Verifica si un tipo de archivo pertenece a la lista de archivos mime
	 * que se permiten subir.
	 * @param	String	contiene el tipo Mime
	 * @return	boolean true por correcto, false por incorrecto.
	 */
	public function verificarMime($tipoMime)
	{	if(in_array($tipoMime,$this->matrizMime))
		{	return true;}
		else {	return false;}
	}

	/**
	 * Proxima Version
	 *
	 * @param unknown_type $tipoMime
	 *
	function eliminarTipoMime($tipoMime)
	{}
	*/

	/**
	 * Proxima Version
	 *
	 * @param unknown_type $grupoMime
	function eliminarGrupoMime($grupoMime)
	{}
	*/

	/**
	 * Proxima Version
	 *
	 */
	function borrarMimes()
	{

	}

/**
 * Contiene los tipos Mime Maximos Permitidos.
 * @var 	array
 */
private $matrizMime 	= array(
"text/plain",
"text/html",
"text/rtf",
"text/enriched",
"text/x-sgml",
"text/x-vcard",
"application/excel",
"application/vnd.ms-excel",
"application/msword",
"application/rtf",
"application/zip",
"application/x-gtar",
"application/x-gzip",
"application/x-sh",
"application/x-shar",
"application/ms-tnef",
"application/activemessage",
"application/andrew-inset",
"application/applefile",
"application/atomicmail",
"application/dca-rft",
"application/dec-dx",
"application/mac-binhex40",
"application/mac-compactpro",
"application/macwriteii",
"application/news-message-id",
"application/news-transmission",
"application/octet-stream",
"application/oda",
"application/pdf",
"application/postscript",
"application/powerpoint",
"application/remote-printing",
"application/slate",
"application/wita",
"application/wordperfect5.1",
"application/x-bcpio",
"application/x-cdlink",
"application/x-compress",
"application/x-cpio",
"application/x-csh",
"application/x-director",
"application/x-dvi",
"application/x-hdf",
"application/x-httpd-cgi",
"application/x-koan",
"application/x-latex",
"application/x-mif",
"application/x-netcdf",
"application/x-stuffit",
"application/x-sv4cpio",
"application/x-sv4crc",
"application/x-tar",
"application/x-tcl",
"application/x-tex",
"application/x-texinfo",
"application/x-troff",
"application/x-troff-man",
"application/x-troff-me",
"application/x-troff-ms",
"application/x-ustar",
"application/x-wais-source",
"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
"audio/basic",
"audio/mpeg",
"audio/x-aiff",
"audio/x-pn-realaudio",
"audio/x-pn-realaudio",
"audio/x-pn-realaudio-plugin",
"audio/x-realaudio",
"audio/x-wav",
"image/bmp",
"image/gif",
"image/ief",
"image/jpeg",
"image/pjpeg",
"image/png",
"image/tiff",
"image/x-cmu-raster",
"image/x-portable-anymap",
"image/x-portable-bitmap",
"image/x-portable-graymap",
"image/x-portable-pixmap",
"image/x-rgb",
"image/x-xbitmap",
"image/x-xpixmap",
"image/x-xwindowdump",
"video/mpeg",
"video/quicktime",
"video/x-msvideo",
"video/x-sgi-movie",
"x-conference/x-cooltalk",
"x-world/x-vrml");
}