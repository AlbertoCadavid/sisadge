/**
 * @author 	Marcelo Castro
 * @link	w.marcelo.castro@gmail.com
 * @version	0.1 (29/08/2008)
 * @since 	100% JQuery 
 */
/**
 * Definicion de Expresiones regulares para Validacion.
 */
var 	exr_entero 			= '^[0-9]';										// Entero del 0 al 9
var 	exr_codigoPlan		= '^([0-9][0-9]\.)+([0-9][0-9])$'; 							
var 	exr_alfanumerico	= '^[/a-z\u0020\.A-Z0-9_\\-,:áéíóúñçÁÉÍÓÚÑÇ\x28\x29]';	// numeros letras y espacio
var 	exr_texto			= '^[/a-z\x20A-Z\._\\-áé\xcdóúñçÁÉÍÓÚÑÇ\x28\x29]';
var 	exr_minusculas		= '^[/a-z\x20\.áéíóúñç\\-]';
var 	exr_mayusculas		= '^[/A-Z\x20\.ÁÉÍÓÚÑÇ\\-]';
var 	exr_mayusculasDigit	= '^[/A-Z\x20ÁÉÍÓÚÑÇ\\-0-9]'
var		exr_codigoMayus		= '^[/A-Z\u002F\x20]';
var		exr_minusculasDigit	= '^[/a-z\x20áéíóúñç\\-0-9]';
var 	exr_codigoMinus		= '^[/a-\x20záéíóúñç\\-]';
var 	exr_codigoMayus		= '^[/A-Z\x20ÁÉÍÓÚÑÇ\\-]'
var 	exr_correo			= '^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$';
var 	exr_ip				= '^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$';
var		exr_link			= '<a[^>]*href=\"[^\s\"]+\"[^>]*>[^<]*<\/a>';
var 	exr_url				= /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-z][a-z0-9_]*)?$/;
var 	exr_fecha			= /^(\d{4})-(0?[1-9]|1[012])-(3[01]|0?[1-9]|[12]\d)$/;

$(document).ready(registrandoEventos)

/**
 * funcion registrarEventos.
 * Carga los lanzadores de eventos.
 */
function	registrandoEventos()
{	$('#pizarra').hide();
	$('#primero').click(function(){navegador('primero')});
	$('#anterior').click(function(){navegador('anterior')});
	$('#buscar').click(buscarRegistro);
	$('#reset').click(resetearCampos);
	$('#siguiente').click(function(){navegador('siguiente')});
	$('#ultimo').click(function(){navegador('ultimo')});
	$('#cancelar').click(cancelarRegistro);
	$('#editar').click(editarRegistro);
	$('#insertar').click(insertarRegistro);
	$('#consultas').hide();
	calendario	= $('#formGenerico input[@validar=fecha]');
	fechas(calendario);
}

function minimizarVentana()
{	$('#consultaInterna').toggle();
    accion  = $('#minimizeWindows').attr("src");
    if(accion=='iconos/button-minimize-grey.png')
    {   $('#minimizeWindows').attr("src","iconos/button-maximize-grey.png");   }
    else
    {   $('#minimizeWindows').attr("src","iconos/button-minimize-grey.png");   }
     $('#minimizeWindows').toggleClass("uno","otro");
//button-maximize-grey.png
      //minimizeWindows
}

function cerrarVentana()
{	$('#consultas').hide();	}

function fechas(campos)
{	$.each	( campos, function(clave, valor)
				{	id		= valor.id;
					botonId	= "lanzador_"+id;
						new Calendar.setup({
   					 	inputField     :    id,  
    					ifFormat       :    "%Y-%m-%d",   
    					button         :    botonId}); 
				}
			);
}

/**
 * Funcion resetearCampos.
 * Pone a blanco los campos del Formulario.
 */
function resetearCampos()
{	$("#formGenerico input[@type=text]").attr("value","");
	$("#formGenerico select").attr("value","");
	$("#formGenerico textarea").attr("value","");
}

/**
 * Funcion rellenoBusqueda.
 * Se encarga de Rellenar los campos con los valores
 * obvtenidos luego de una busqueda.
 */
function rellenoBusqueda()
{	campoId		= this.id;
	campoId		= $('#'+campoId).attr('campo');
	campoVal 	= this.title;
	procesando("Buscando Informacions ...");
	tabla	= $("#tabla").attr('value');
	cadena	= "sstm__tabla="+tabla+"&campoId="+campoId+"&campoVal="+campoVal;
	// Lanzo el Ajax para Insertar Registro
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc=getId',
  	type: 'POST',
  	async: true,
  	data: cadena,
	success: cargarConsulta
	}); // dataType: 'json',
}

/**
 * Funcion buscarRegistro.
 * Busca los campos para una busqueda determinada.
 */
function 	buscarRegistro()
{	procesando("Buscando ......");
	cadena	= levantarDatos(0);
	operador= $('#operador').attr("value");
	cadena	= cadena+"&sstm__ayudas="+$('#valorAyudas').attr('value')+"&sstm__operador="+operador;
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc=buscar',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: llenarDiv
	}); // dataType: 'json',
}


function llenarDiv(datos)
{	$('#consultas').show();
	$('#consultas').html(datos);
	$('#consultas div').click(rellenoBusqueda);
	$('#minimizeWindows').click(minimizarVentana);
	$('#closeWindows').click(cerrarVentana);
	resultados("");
}

function	cancelarRegistro()
{	campoId	= $("#indiceMySQL").attr('value');
	idActual= $('#'+campoId).attr('value');
	base	= $("#base").attr('value');
	tabla	= $("#tabla").attr('value');
	if(!confirm("Realmente desea borrar el registro "+idActual))
	{	return;	}
	procesando("Procesando Consulta ....");
	cadena		= "sstm__tabla="+tabla+"&idCampo="+campoId+"&idDelete="+idActual+"&ms="+new Date().getTime();
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc=delete',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function navegador(accion)
{	procesando("Buscando Informacion ...");
	cadena	= levantarDatos(0);
	// Lanzo el Ajax para Insertar Registro
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc='+accion,
  	type: 'POST',
  	async: true,
  	data: cadena,
	success: cargarCampos
	}); // dataType: 'json',
}

function	editarRegistro()
{	if(!validarDatos())
	{	alert("Verifique los datos");
		return;
	}
	if(!confirm("Realmente desea Editar los datos"))
	{	return;	}
	procesando("query processing ...");
	cadena	= levantarDatos(0);
	// Lanzo el Ajax para Insertar Registro
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc=edit',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function 	insertarRegistro()
{	if(!validarDatos())
	{	alert("Verifique los datos");
		return;
	}
	if(!confirm("Realmente desea Insertar los datos"))
	{	return;	}
	procesando("query processing ...");
	cadena	= levantarDatos(0);
	// Lanzo el Ajax para Insertar Registro
	ajaxTablas	= $.ajax({
  	url: 'index.php?ctr=FormularioAcciones&acc=insert',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function resultados(respuesta)
{	$('#pizarra').html(respuesta);
	$('div#pizarra').show();
}

function validarDatos()
{	cadena	= levantarDatos(1);
	campos = cadena.split("&");
	errores= 0;
	cantid = campos.length;
	for(f=0;f<cantid;f++)
	{	campoVD		= campos[f].split("="); 
		campo		= campoVD[0];					//Campo a Validar
		valor		= campoVD[1];					//Valor a Examinar
		validacion	= $('#'+campo).attr("validar");
		tipoVD		= validacion.split("-");
		tipoValid	= tipoVD[0];					//Tipo de Validacion
		if (tipoValid)
		{	if (tipoValid != "correo" && tipoValid != "ip" && tipoValid != "link" && tipoValid != "url" && tipoValid != "fecha" && tipoValid!="codigoPlan")
			{	extencion = tipoVD[1].split(",");
				minimo = extencion[0]; // Minima cantidad de datos
				maximo = extencion[1]; // Maxima cantidad de datos
				patron = eval("exr_" + tipoValid) + '{' + minimo + ',' + maximo + '}$';
			}
			else
			{	patron = eval("exr_" + tipoValid);	}
			if (!valor.match(patron))
			{	$('#' + campo).css("background-color", "#FFEBDE")
				errores++;
			}
			else {	$('#' + campo).css("background-color", "#EFF3FF")	}
		}
	}
	if(errores>0)
	{	return false;}
	return true;
}

/**
 * funcion levantarDatos.
 * @param {Boolean}		todo 1: Solo levantar campos del Formulario
 * 							 0: Levantar todos los campos.
 */
function levantarDatos(todo)
{	//#### Cambiado a Basico por dramas en codificacion de tildes con JQuery ###//
	formulario	= document.getElementById('formGenerico');
	cantElemnt	= formulario.elements.length;
	cadena		= "";
	sstm_validar= "";
	for(f=0;f<cantElemnt;f++)
	{	idFormulario	= formulario.elements[f].id;
		if (formulario.elements[f].type!= "button")
		{	valorFormul = $('#' + idFormulario).attr('value')
			valorValida	= $('#' + idFormulario).attr('validar');
			sstm_validar= sstm_validar+valorValida+"|";
			cadena = cadena + idFormulario + "=" + valorFormul + "&";
		}
	}
	//#### Fin Cambio a Basico por dramas en codificacion de tildes con JQuery ###//
	if (todo == 0)
	{	campoId = $("#indiceMySQL").attr('value');
		idInsert = $("#insertIndice").attr('value');
		idActual = $('#' + campoId).attr('value');
		base = $("#base").attr('value');
		tabla = $("#tabla").attr('value');
		cadena = cadena + "sstm__validar="+sstm_validar+"&sstm__ins=" + idInsert + "&sstm__base=" + base + "&sstm__tabla=" + tabla + "&sstm__id=" + campoId + "&sstm__idIns=" + idActual + "&sstm__ms=" + new Date().getTime();
	}
	else
	{	cadena = cadena.substring(0,cadena.length-1);	}
	return cadena;
}

function cargarCampos(datos)
{		if(datos.indexOf("[{")=="-1")
		{	resultados(datos);
			return;
		}
		datos = eval('(' + datos + ')');
		// Largo del Arreglo JSON
		cntFilas = datos.length;
		// Ahora Cargo el Resto traido de la Base de Datos
		for (f = 0; f < cntFilas; f++)
		{	fila = datos[f];
			$('#'+fila.campo).attr("value", fila.valor);
			$('#' + fila.campo).css("background-color", "#EFF3FF")
		}
		resultados("");
}

function cargarConsulta(datos)
{	minimizarVentana();
	if(datos.indexOf("[{")=="-1")
	{	resultados(datos);
		return;
	}
	datos = eval('(' + datos + ')');
	// Largo del Arreglo JSON
	cntFilas = datos.length;
	// Ahora Cargo el Resto traido de la Base de Datos
	for (f = 0; f < cntFilas; f++)
	{	fila = datos[f];
		nomCampo	= fila.campo.split("|");
		$('#'+nomCampo[0]).attr("value", fila.valor);
		$('#' + nomCampo[0]).css("background-color", "#EFF3FF")
	}
	resultados("");
}

function procesando(msj)
{	resultados("<img border='0' src='iconos/spinner.gif'> "+msj);	}

function isArray(testObject)
{   return testObject && !(testObject.propertyIsEnumerable('length')) && typeof testObject === 'object' && typeof testObject.length === 'number';
}

