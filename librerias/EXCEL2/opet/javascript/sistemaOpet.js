/**
 * Sistema Opet es una libreria generica para ser usada por todas las demas funciones javascript.
 */

/**
 * Carga un formulario con los datos que vienen en un JSON, es decir solo carga los valores, 
 * con los pares de claves campo y valor.
 * Es decir campo: nombre de campo y valor el valor para el campo dado.
 * @param {Object}		json	Objeto de tipo JSON.
 */
function cargarValoresEnFormulario(json)
{	cantidad	= json.length;
	for ( i = 0 ; i < cantidad; i++)
	{	fila	= json[i];
		$('#' + fila.campo ).val( fila.valor );
	};
}

/**
 * Carga un campo select.
 * @param {String} 	url				tipo mdl=modulo&ctr=controlador&acc=accion			
 * @param {String} 	post			Datos que seran pasados por post con el mismo tipo de notacion que la anterior.
 * @param {String} 	campoSelect		Nombre del campo select a ser llenado.
 * @param {String}	primerComent	Comentario que sera visto en el select.
 * @param {String}	estilo			Estilo del campo select es para IE7 mas bien.
 */
function cargarSelect(url,post,campoSelect,primerComent,estilo)
{	$.ajax({
  			url		: 'indexAjax.php?' + url,
  			type	: 'POST',
  			async	: true,
			dataType: 'json',
  			data	: post,
			success	: function (json)	{	cnt		= json.length;
											$('#' + campoSelect).empty();
											if (primerComent)
											{	$('#' + campoSelect).append('<option value="" >' + primerComent + '</option>');	}
											for(f=0;f<cnt;f++)
											{	fila=json[f];
												$('#' + campoSelect).append('<option  value="'+fila.valor+'" title="'+fila.titulo+'">'+fila.comentario+'</option>');
											}
											$('#' + campoSelect).toggleClass( estilo ); // Por IE xq rompe estilos
											$('#' + campoSelect).toggleClass( estilo ); // Por IE xq rompe estilos
										}});
		
}


jQuery.fn.resetForm = function ()
{	$(this).each (function() { this.reset(); });	}
