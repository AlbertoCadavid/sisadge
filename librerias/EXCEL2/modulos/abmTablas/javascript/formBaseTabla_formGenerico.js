$(document).ready(iniciarFormExportacion);

function iniciarFormExportacion()
{   // Cargo acciones Necesarias
    $('#opfg_cambiar_base_tabla').click(enviarForm);
    $('#opfg_elegir_base').change(cargarTablas);

    desabilitarCampos();
	procesarConexion();
}

function desabilitarCampos()
{   $('#opfg_elegir_tabla').attr('disabled', true);	}

function procesarConexion()
{	// habilito el Select de base de datos
	$('#opfg_elegir_base').attr('disabled', false);
    // Lanzo Ajax para cargar Select Base de Datos
	procesando('Cargando Base de datos ...'); // Esta funcion pertenece a FormularioGenerico.js
	ajaxBases	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=bases',
  	type: 'POST',
  	async: true,
  	/*data: cadena,*/
	dataType: 'json',
  	success: function(json)	{	cargarSelect(json,'opfg_elegir_base','Seleccione Base de Datos ...');
								$('#opfg_elegir_base').val(campo_opfg_elegir_base);
								$('#opfg_elegir_tabla').attr('disabled',false);
								cargarTablas();
							}
	});
    return true;
}

function cargarTablas()
{   base    = $('#opfg_elegir_base').val();
	$('#opfg_elegir_tabla').attr('disabled', false);
	if(!base)
	{	desabilitarCampos();
		return;
	}
    // Lanzo Ajax para cargar Select Base de Datos
	procesando('Cargando Tabla de datos ...'); // Esta funcion pertenece a FormularioGenerico.js
    cadena      = 'base=' + base;
	ajaxBases	= $.ajax({
  	url: 'indexAjax.php?mdl=conectar&ctr=Conexion&acc=tablas',
  	type: 'POST',
  	async: true,
  	data: cadena,
	dataType: 'json',
  	success: function(json){	cargarSelect(json,'opfg_elegir_tabla','Seleccione una Tabla ...');
								$('#opfg_elegir_tabla').val(campo_opfg_elegir_tabla);
							}
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
	resultados("");

}

function enviarForm()
{	sw 		= 1;
	mensaje	= "Advertencia :\n";	
	//Verifico Que haya elegido una Base de Datos.
	if($('#opfg_elegir_base').val()==0 || $('#opfg_elegir_base').val()=="" )
	{	mensaje+="- Debes Seleccionar una Base de Datos.\n";
		sw =0;
	}
	
	//Verifico Que haya elegido una Tabla.
	if($('#opfg_elegir_tabla').val() ==0 || $('#opfg_elegir_tabla').val() =='')
	{	mensaje+="- Debes Seleccionar una Tabla de Datos.\n";
		sw =0;
	}
		
	if(sw==1) {	$('#opfg_form_cambiar_base_tabla').submit();  }
	else
	{	alert(mensaje);
		return false;
	}
}