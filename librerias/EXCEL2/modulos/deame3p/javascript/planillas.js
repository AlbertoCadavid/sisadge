$(document).ready(inicioPlanillas);

function inicioPlanillas()
{   $('#invertir').click(invertirCheckBox );
    $('#ninguno').click(ningunCheckBox);
    $('#todos').click(todosCheckBox);
    $('.opfg_mostrar_previa_xlsx').click(previa);
}

invertirCheckBox         = function()
{   $("#planillas").toggleCheckboxes();   }

ningunCheckBox          = function()
{   $("#planillas").unCheckCheckboxes();  }

todosCheckBox           = function()
{   $("#planillas").checkCheckboxes();    }

function previa()
{   valor       = this.id;
    planilla    = $('#' + valor ).attr('title');
	extension	= planilla.substring(planilla.lastIndexOf('.') + 1 );
	if(extension!='xlsx')
	{	alert('Solo se realizan previas para archivos de Excel 2007.');
		return;
	}
	
	// Lanzo el Ajax
	url		= 'indexAjax.php?mdl=deame3p&ctr=PreviaExcel&acc=previa&excel=' +  planilla;
	tarjet	= 'blank';
	window.open(url, tarjet, 'width=995,height=600,scrollbar=yes, location=no,toolbar=no, menubar=no');
}