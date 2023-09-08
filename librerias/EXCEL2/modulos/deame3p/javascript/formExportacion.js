$(document).ready(iniciarFormExportacion);

function iniciarFormExportacion()
{   // Cargo acciones Necesarias
    $('#procesar').click(enviarForm);
    $('#baseDeDatos').change(cargarTablas);
    $('#previa').click(previa);
    $('#ayudaPatrones').click( function()
                               {
                                   posicion     = $('#patronExportacion').offset();
                                   ancho        = $('#patronExportacion').css('width');
                                   $('#ayudaSobrePatrones').css('width',  ancho);
                                   $('#ayudaSobrePatrones').css('top',  posicion.top + 20);
                                   $('#ayudaSobrePatrones').css('left', posicion.left);
                                   $('#ayudaSobrePatrones').css('display','block');
                               });
    $('#cerrarAyuda').click( function()
                             {
                                 $('#ayudaSobrePatrones').css('display','none');
                             });
    desabilitarCampos();
    procesarConexion();
    cargarArchivos();
    cargarFunciones();
    varTiempo();
    varMemoria();
    //$('#controlador').change(function(){cargarSelect('mdl=opet&ctr=Acciones&acc=selectAccionesRegistradas', 'modulo=' + $('#modulo').val() + '&controlador=' + $('#controlador').val() ,'accion','Seleccionar Accion ...','inputsText')});
}

function desabilitarCampos()
{$('#tabla').attr('disabled', true);
    $('#archivo').attr('disabled', true);
    $('#planServ').attr('disabled', true);
    $('#funcionesDeame3p').attr('disabled', true);
    $('#funciones').attr('disabled', true);
    $('#codificacion').attr('disabled', true);
    $('#patronExportacion').attr('disabled', true);
}

function habilitarCampos()
{$('#tabla').attr('disabled', false);
    $('#archivo').attr('disabled', false);
    $('#planServ').attr('disabled', false);
    $('#funcionesDeame3p').attr('disabled', false);
    $('#funciones').attr('disabled', false);
    $('#codificacion').attr('disabled', false);
    $('#patronExportacion').attr('disabled', false);
   
}

function procesarConexion()
{	// habilito el Select de base de datos
	$('#baseDeDatos').attr('disabled', false);
    verBarraProgreso(' ... Cargando Bases de Datos ... ');
    // Lanzo Ajax para cargar Select Base de Datos
	ajaxBases	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=bases',
  	type: 'POST',
  	async: true,
  	/*data: cadena,*/
	dataType: 'json',
  	success: function(json){cargarSelect(json,'baseDeDatos','Seleccione Base de Datos ...')}
	});
    return true;
}

function cargarTablas()
{base    = $('#baseDeDatos').val();
	$('#tabla').attr('disabled', false);
	if(!base)
	{desabilitarCampos();
		return;
	}
    verBarraProgreso(' ... Cargando Tablas ... ');
    // Lanzo Ajax para cargar Select Base de Datos
    cadena      = 'base=' + base;
	ajaxBases	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=tablas',
  	type: 'POST',
  	async: true,
  	data: cadena,
	dataType: 'json',
  	success: function(json){cargarSelect(json,'tabla','Seleccione una Tabla ...');}
	});
    habilitarCampos();
    return true;
}

function cargarArchivos()
{   // Lanzo Ajax para cargar Select Base de Datos
	ajaxArchivos	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=archivos',
  	type: 'POST',
  	async: true,
	dataType: 'json',
  	success: function(json){cargarSelect(json,'planServ','Seleccionar Archivos ...');}
	});
    
}

function cargarFunciones()
{
    // Lanzo Ajax para cargar Select Base de Datos
	ajaxArchivos	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=funcionesPhp',
  	type: 'POST',
  	async: true,
	dataType: 'json',
  	success: function(json){cargarSelect(json,'funciones','Seleccionar Clase ...');}
	});
    
}

function cargarSelect(json,select,comentario)
{cnt	        = json.length;
	// Vacio Selects
	$('#' + select).empty();
	// Pongo el Primer Comentario
	$('#' + select).append('<option value="" style="width:100%">' + comentario + '</option>');
	// Lleno los Selects	
	for(f=0;f<cnt;f++)
	{fila    = json[f];
		$('#' + select).append('<option value="'+fila.valor+'" title="'+fila.titulo+'">'+fila.comentario+'</option>');
	}
	$('#' + select).toggleClass('cajasTexto'); // Por IE xq rompe estilos
	$('#' + select).toggleClass('cajasTexto'); // Por IE xq rompe estilos
    ocultarBarraProgreso();
}

function varMemoria()
{   // Lanzo el Ajax de Conexion
	ajaxMemoria	    = $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=memoria',
  	type: 'POST',
  	async: true,
	dataType: 'json',
  	success: function(json) {$('#limiteMemoria').val(json.memoria);}
	}); 
}

function varTiempo()
{   // Lanzo el Ajax de Conexion
	ajaxiempo	    = $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=tiempo',
  	type: 'POST',
  	async: true,
	dataType: 'json',
  	success: function(json) {$('#tiempoLimiteScript').val(json.tiempo);}
	}); 
}

function verBarraProgreso(mensaje)
{$('#msjProgreso').html(mensaje);
    $('#progreso').css('display', 'block');
}

function ocultarBarraProgreso()
{$('#progreso').css('display', 'none');}

function enviarForm()
{sw 		= 1;
	mensaje	= "Advertencia :\n";	
	//Verifico Que haya elegido una Base de Datos.
	if($('#baseDeDatos').get(0).value ==0 || $('#baseDeDatos').get(0).value=="" )
	{mensaje+="- Debes Seleccionar una Base de Datos.\n";
		sw =0;
	}
	
	//Verifico Que haya elegido una Tabla.
	if($('#tabla').get(0).value ==0)
	{mensaje+="- Debes Seleccionar una Tabla de Datos.\n";
		sw =0;
	}
	
	//Verifico Que haya elegido un archivo ya sea del Servidor o para subir.
	if($('#archivo').get(0).value == 0 && $('#planServ').get(0).value == 0)
	{mensaje+="- Debes Seleccionar un archivo para exportar.\n";
		sw =0;
	}
		
	if(sw==1) {$('#deExcelAMysql').submit();}
	else
	{alert(mensaje);
		return false;
	}
}

function previa()
{tabla		= $('#tabla').val();
	if(tabla=='Tabla de Datos ...')
	{alert('Primero debes seleccionar una tabla.');
		return;
	}
	
	planilla	= $('#planServ').val();
	extension	= planilla.substring(planilla.lastIndexOf('.') + 1 );
	if(extension!='xlsx')
	{alert('Solo se realizan previas para archivos de Excel 2007.');
		return;
	}
	
	// Lanzo el Ajax
	url		= 'indexAjax.php?mdl=deame3p&ctr=PreviaExcel&acc=previa&excel=' +  $('#planServ').val();
	tarjet	= 'blank';
	window.open(url, tarjet, 'width=995,height=600,scrollbar=yes, location=no,toolbar=no, menubar=no');
}
