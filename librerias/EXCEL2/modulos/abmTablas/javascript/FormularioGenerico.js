/**
 * @author 	Marcelo Castro
 * @link	w.marcelo.castro@gmail.com
 * @version	0.1.0 (29/08/2008)
 * @versio  0.2.0 (14/09/2009) Agregado Control de Formulario con teclado.
 * @version 0.3.0 (23/09/2009) Mejoras en la navegacion por teclado.
 * @since 	con JQuery 
 */
/**
 * Definicion de Expresiones regulares para Validacion.
 */	
var     exr_select_entero		= '^[0-9]';
var 	exr_decimal				= '^[0-9]{1,entero}(\.[0-9]{1,decimal})?$';
var		exr_select_alfanumerico	= '[^]'; //'^[/a-z\u0020\.A-Z0-9_\\-,@:áéíóúñçÁÉÍÓÚÑÇ\x28\x29]';
var 	exr_entero 				= '^[0-9]';												// Entero del 0 al 9
var 	exr_codigoPlan			= '^([0-9][0-9]\.)+([0-9][0-9])$'; 							
var 	exr_alfanumerico		= '[^]'//'^[/a-z\u0020\.A-Z0-9_\\-,:áéíóúñçÁÉÍÓÚÑÇ\x28\x29]';	// numeros letras y espacio
var 	exr_texto				= '[^]';//'^[/a-z\x20A-Z\._\\-áéí\xcdóúñçÁÉÍÓÚÑÇ\x28\x29]';
var 	exr_minusculas			= '^[/a-z\x20\.áéíóúñç\\-]';
var 	exr_mayusculas			= '^[/A-Z\x20\.ÁÉÍÓÚÑÇ\\-]';
var 	exr_mayusculasDigit		= '^[/A-Z\x20ÁÉÍÓÚÑÇ\\-0-9]'
var		exr_codigoMayus			= '^[/A-Z\u002F\x20]';
var		exr_minusculasDigit		= '^[/a-z\x20áéíóúñç\\-0-9]';
var 	exr_codigoMinus			= '^[/a-\x20záéíóúñç\\-]';
var 	exr_codigoMayus			= '^[/A-Z\x20ÁÉÍÓÚÑÇ\\-]'
var 	exr_correo				= '^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$';
var 	exr_ip					= '^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$';
var		exr_link				= '<a[^>]*href=\"[^\s\"]+\"[^>]*>[^<]*<\/a>';
var 	exr_url					= /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&amp;]*)?)?(#[a-z][a-z0-9_]*)?$/;
var 	exr_fecha				= /^(\d{4})-(0?[1-9]|1[012])-(3[01]|0?[1-9]|[12]\d)$/;

var 	teclasPermitidas		= "#[13][27][35][36][37][39][113][115][121]";
var 	editaInserta			= 0;
var		campoEnfocado			= '';
$(document).ready(registrandoEventos)

/**
 * funcion registrarEventos.
 * Carga los lanzadores de eventos.
 */
function	registrandoEventos()
{	$('#pizarra').hide();
	$(document).keydown(capturaTecla);
	$('#opfg_primero').click(function(){navegador('primero')});
	$('#opfg_anterior').click(function(){navegador('anterior')});
	$('#opfg_buscar').click(buscarRegistro);
	$('#opfg_reset').click(resetearCampos);
	$('#opfg_siguiente').click(function(){navegador('siguiente')});
	$('#opfg_ultimo').click(function(){navegador('ultimo')});
	$('#opfg_cancelar').click(cancelarRegistro);
	$('#opfg_editar').click(editarRegistro);
	$('#opfg_insertar').click(insertarRegistro);
	$('.opfg_class_romper_select').click(romperSelect);
	$('#consultas').hide();
	calendario	= $('#formGenerico input[validar=fecha]');
	fechas(calendario);
	// Cuando cambia el  Formulario cambiamos el valor de editarInsertar para saber 
	// si realizo cambios.
	$("#formGenerico input[type=text]").change(cambiosForm);
	$("#formGenerico select").change(cambiosForm);
	$("#formGenerico textarea").change(cambiosForm);
	// Saber que campo tiene el foco
	$("#formGenerico input[type=text]").focus(function(){ campoEnfocado = this.id; });
	$("#formGenerico input[type=text]").blur(function(){ campoEnfocado = ''; });
	    
	$("#formGenerico select").focus(function(){ campoEnfocado = this.id; });
	$("#formGenerico select").blur(function(){ campoEnfocado = ''; });
	
	$("#formGenerico textarea").focus(function(){ campoEnfocado = this.id; });
	$("#formGenerico textarea").blur(function(){ campoEnfocado = ''; });
	resetearCampos();
	insertUpdateBase()
}

function cambiosForm()
{	editaInserta	= 1;	}

function romperSelect()
{	campo 	= this.title;
	$('#opfg_romper_' + campo).remove();
	validar 	= $('#' + campo).attr('validar');
    validar     = validar.substring(7);
	clase		= $('#' + campo).attr('class');
	valor		= $('#' + campo).val();
	$('#' + campo).replaceWith("<input class='"+clase+"' type='text' id='"+campo+"' name='"+campo+"' value'' validar='"+validar+"' />");
	$('#' + campo).val(valor);
}
function insertUpdateBase()
{	iubase	= $('#opfg_iubase').val();
	if(!iubase)
	{	alert('La Tabla no pose campos indices ni unicos.\n Tenga precaucion al editar o eliminar datos.');
		$('#cancelar').attr('disabled', true);
		$('#editar').attr('disabled', true);
	}
}


function minimizarVentana()
{	$('#consultaInterna').toggle();
    accion  = $('#minimizeWindows').attr("src");
    if(accion=='imagenes/button-minimize-grey.png')
    {   $('#minimizeWindows').attr("src","imagenes/button-maximize-grey.png");   }
    else
    {   $('#minimizeWindows').attr("src","imagenes/button-minimize-grey.png");   }
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
{	$("#formGenerico").resetForm();
	editaInserta	= 0;
}

/**
 * Funcion rellenoBusqueda.
 * Se encarga de Rellenar los campos con los valores
 * obvtenidos luego de una busqueda.
 */
function rellenoBusqueda()
{	campoId		= this.id;
	if(campoId=='opfg_div_paginacion')
	{return;}

        campo		= campoId.split('_');
	campoId		= 'opfgsstmcampobuscar_' + campo[1];
	campoVal	= $('#'+campoId).val();
	procesando("Buscando Informacion ...");
	// Evaluar JSON
	json		= new Function('return ' + campoVal )();
	cantidad	= json.length;
	cadena 		= '';
	for(f=0;f<cantidad;f++)
	{	fila=json[f];
		$('#' + fila.campo).val(fila.valor);
		$('#' + fila.campo).css("background-color", "#EFF3FF");
		cadena 	= cadena + fila.campo + '=' + fila.valor + '&';
	}
	$('#consultaInterna').hide();
	// Envio Ajax para cargar los valores del formulario
	//alert(cadena)
	ajax_Session_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=cargarJson',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: function() {	resultados("");	}
	});
}

/**
 * Funcion buscarRegistro.
 * Busca los campos para una busqueda determinada.
 */
function 	buscarRegistro()
{	procesando("Buscando informacion ...");
	cadena	= levantarDatos();
	operador= $('#opfg_operador').attr("value");
	cadena	= cadena+"&sstm__ayudas="+$('#opfg_valorAyudas').attr('value')+"&sstm__operador="+operador;
	ajaxopfg_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=buscar',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: llenarDiv
	}); // dataType: 'json',
}

function pasarPagina(pagina)
{	cadena	= 'pgncn=' + pagina; 
	procesando("Buscando informacion ...");
	ajaxopfg_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=buscar',
  	type: 'GET',
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
{	campoId		= $("#opfg_indiceMySQL").attr('value');
	idActual	= $('#'+campoId).attr('value');
	/*
	opfg_base	= $("#opfg_base").attr('value');
	opfg_tabla	= $("#opfg_tabla").attr('value');*/
	if(!confirm("Realmente desea borrar el registro "+idActual))
	{	return;	}
	procesando("Procesando Consulta ....");
	cadena		= levantarDatos() + "ms="+new Date().getTime();
	ajaxopfg_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=delete',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function 	navegador(accion)
{	if(editaInserta==1)
	{	error	= confirm('Los cambios no fueron guardados.\nDesea Continuar:');
		if(error!=true)
		{ return;}
	}
	editaInserta	= 0;
	procesando("Buscando Informacion ...");
	cadena	= levantarDatos();
	// Lanzo el Ajax para Insertar Registro
	ajaxopfg_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc='+accion,
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
	procesando("Procesando Consulta ...");
	cadena	= levantarDatos();
	// Lanzo el Ajax para Insertar Registro
	ajaxopfg_tablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=edit',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function insertarRegistro()
{	if(!validarDatos())
	{	alert("Verifique los datos");
		return;
	}
	if(!confirm("Realmente desea Insertar los datos"))
	{	return;	}
	procesando("Procesando Consulta ...");
	cadena	= levantarDatos();
	// Lanzo el Ajax para Insertar Registro
	ajaxtablas	= $.ajax({
  	url: 'indexAjax.php?mdl=abmTablas&ctr=FormularioAcciones&acc=insert',
  	type: 'POST',
  	async: true,
  	data: cadena,
  	success: resultados
	}); // dataType: 'json',
}

function resultados(respuesta)
{	$('#pizarra').html(respuesta);
	$('div#pizarra').show();
	editaInserta	= 0;
}

function validarDatos()
{	errMsj 	= 'Se produjeron errores en los siguientes campos:\n\n';
	cadena	= levantarDatos();
	campos = cadena.split("&");
	errores= 0;
	cantid = campos.length;
	for(f=0;f<cantid;f++)
	{	campoVD		= campos[f].split("="); 
		campo		= campoVD[0];					//Campo a Validar

		valor		= campoVD[1];					//Valor a Examinar
		tipoValid	= '';
		if(campo)
		{	validacion	= $('#'+campo).attr("validar");
			tipoVD		= validacion.split("-");
			tipoValid	= tipoVD[0];					//Tipo de Validacion
		}
		if (tipoValid)
		{	if (tipoValid != "correo" && tipoValid != "ip" && tipoValid != "link" && tipoValid != "url" && tipoValid != "fecha" && tipoValid!="codigoPlan" && tipoValid!='decimal')
			{	extencion = tipoVD[1].split(",");
				minimo = extencion[0]; // Minima cantidad de datos
				maximo = extencion[1]; // Maxima cantidad de datos
				patron = eval("exr_" + tipoValid) + '{' + minimo + ',' + maximo + '}$';
			}
			else
			{	patron = eval("exr_" + tipoValid);	}
			
			if(tipoValid=='decimal')
			{	numeros	= tipoVD[1].split(',');
				numeros	= numeros[1].split('.');
				patron = patron.replace('entero',numeros[0]);
				patron = patron.replace('decimal',numeros[1]);
			}
			if(tipoValid.indexOf('select_')!=-1)
			{	if(valor==0)
				{	valor='';}
			}

			if (!valor.match(patron))
			{	$('#' + campo).css("background-color", "#FFEBDE")
				errores++;
				errMsj	= errMsj + campo + '\n';
			}
			else {	$('#' + campo).css("background-color", "#EFF3FF")	}
		}
	}
	if(errores>0)
	{	alert(errMsj);
		return false;
	}
	return true;
}

/**
 * funcion levantarDatos.
 */
function levantarDatos()
{	//Cambiado a Basico por dramas en codificacion de tildes con JQuery//
	formulario	= document.getElementById('formGenerico');
	cantElemnt	= formulario.elements.length;
	cadena		= "";
	sstm_validar= "";
	for(f=0;f<cantElemnt;f++)
	{	idFormulario	= formulario.elements[f].id;
		if (formulario.elements[f].type!= "button" && formulario.elements[f].type!="")
		{	valorFormul = $('#' + idFormulario).attr('value')
			valorValida	= $('#' + idFormulario).attr('validar');
			sstm_validar= sstm_validar+valorValida+"|";
			//alert(valorFormul+" : "+sstm_validar);
			cadena = cadena + idFormulario + "=" + valorFormul + "&";
		}
	}
	// Fin Cambio a Basico por dramas en codificacion de tildes con JQuery//
	cadena.substring(0,cadena.length);
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
		// Ahora Cargo el Resto traido de la opfg_base de Datos
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
	// Ahora Cargo el Resto traido de la opfg_base de Datos
	for (f = 0; f < cntFilas; f++)
	{	fila = datos[f];
		nomCampo	= fila.campo.split("|");
		$('#'+nomCampo[0]).attr("value", fila.valor);
		$('#' + nomCampo[0]).css("background-color", "#EFF3FF")
	}
	resultados("");
}

function procesando(msj)
{	resultados("<img border='0' src='imagenes/spinner.gif'> "+msj);	}

function isArray(testObject)
{   return testObject && !(testObject.propertyIsEnumerable('length')) && typeof testObject === 'object' && typeof testObject.length === 'number';
}

function capturaTecla(evento)
{	tecla = (evento.which) ? evento.which : evento.keyCode;
	if(tecla==13 && campoEnfocado)
	{	$('#opfg_operador').focus();
		campoEnfocado	= '';
		return;
	}
	//alert(campoEnfocado)
	if(campoEnfocado)
	{	return; }
	if (tecla==8)
	{		valor = document.activeElement.value;
			if (valor==undefined) { return false; } //Evita Back en pÃ¡gina. 
			else 
			{	if (document.activeElement.getAttribute('type')=='select-one') 
				{ return false; } //Evita Back en select.
				if (document.activeElement.getAttribute('type')=='button') 
				{ return false; } //Evita Back en button. 
				if (document.activeElement.getAttribute('type')=='radio') 
				{ return false; } //Evita Back en radio. 
				if (document.activeElement.getAttribute('type')=='checkbox') 
				{ return false; } //Evita Back en checkbox. 
				if (document.activeElement.getAttribute('type')=='file') 
				{ return false; } //Evita Back en file. 
				if (document.activeElement.getAttribute('type')=='reset') 
				{ return false; } //Evita Back en reset. 
				if (document.activeElement.getAttribute('type')=='submit') 
				{ return false; } //Evita Back en submit. 
				else //Text, textarea o password 
				{	if (document.activeElement.value.length==0) 
					{ return false; } //No realiza el backspace(largo igual a 0). 
					else 
					{	document.activeElement.value.keyCode = 8; } //Realiza el backspace. 
				} 
			} 
	}

	if(!teclasPermitidas.indexOf('['+tecla+']'))
	{	return;	}

	switch (tecla)
	{	case 39: // Boton ->
			navegador('siguiente');
			break;
		case 37: // Boton <-
			navegador('anterior');
			break;
		case 36: // Boton Flecha Arriba
			navegador('primero');
			break;
		case 35: // Boton Flecha Abajo
			navegador('ultimo');
			break;
		case 121: // Boton F10
			cancelarRegistro();
			break;
		case 13: // Boton Fin
			insertarRegistro();
			break;
		case 113: // Boton F2
			editarRegistro();
			break;
		case 27: // Boton Esc
			resetearCampos();
			break;
		case 115: // Boton F4
			buscarRegistro();
			break;
	}
}