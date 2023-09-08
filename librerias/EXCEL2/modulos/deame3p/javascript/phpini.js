$(document).ready(iniciarPhpIni);

function iniciarPhpIni()
{
    varTiempo();
    varMemoria();
    $('#todos').click(function() { $("#phpini").checkCheckboxes()});
    $('#invertir').click(function() { $("#phpini").toggleCheckboxes()});
    $('#ninguno').click(function() { $("#phpini").unCheckCheckboxes()});
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