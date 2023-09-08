$(document).ready(iniciarFormExportacion);

function iniciarFormExportacion()
{   // Cargo acciones Necesarias
    $('#baseDeDatos').change(cargarTablas);
	$('#tabla').change(cargarCampos);
    desabilitarCampos();
	procesarConexion();
}

function desabilitarCampos()
{   $('#tabla').attr('disabled', true);
    $('#campos').attr('disabled', true);}

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
{   base    = $('#baseDeDatos').val();
	$('#tabla').attr('disabled', false);
	$('#campos').empty();
	$('#campos').attr('disabled', true);
	if(!base)
	{	desabilitarCampos();
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
}

function cargarCampos()
{	base    = $('#baseDeDatos').val();
	tabla	= $('#tabla').val();
	if(!tabla)
	{	return;		}
	opciones	= 'selected';
	$('#campos').attr('disabled', false);
	cadena      = 'base=' + base + '&tabla=' + tabla;
	ajaxBases	= $.ajax({
  	url: 'indexAjax.php?mdl=deame3p&ctr=Importar&acc=getCamposDeTabla',
  	type: 'POST',
  	async: true,
  	data: cadena,
	dataType: 'json',
  	success: function(json){cargarSelect(json,'campos',null, null);}
	});
}

function cargarSelect(json,select,comentario,opcion)
{   cnt	        = json.length;
	// Vacio Selects
	$('#' + select).empty();
	// Pongo el Primer Comentario
	if(comentario)
	{	$('#' + select).append('<option value="" style="width:100%">' + comentario + '</option>');	}
	// Lleno los Selects	
	for(f=0;f<cnt;f++)
	{	fila    = json[f];
		$('#' + select).append('<option value="'+fila.valor+'" title="'+fila.titulo+'" '+ opcion +'>'+fila.comentario+'</option>');
	}
	$('#' + select).toggleClass('cajasTexto'); // Por IE xq rompe estilos
	$('#' + select).toggleClass('cajasTexto'); // Por IE xq rompe estilos
    ocultarBarraProgreso();
}

function verBarraProgreso(mensaje)
{   $('#msjProgreso').html(mensaje);
    $('#progreso').css('display', 'block');
}

function ocultarBarraProgreso()
{   $('#progreso').css('display', 'none');  }