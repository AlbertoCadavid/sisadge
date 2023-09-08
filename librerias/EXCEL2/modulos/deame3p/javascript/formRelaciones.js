/**
 * @author Marcelo
 */
window.onload					= function()
{	elementos	= document.tabla.elements;
	cantElemen	= elementos.length;
	for(el=0;el<cantElemen;el++)
	{	tipo	= elementos[el].type;
		if(tipo=="select-one")
		{	cantOpc	= elementos[el].options.length;
			if(cantOpc==1)
			{	elementos[el].disabled = true;	}
		}
	}
}

