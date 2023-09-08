// J /* Abrimos etiqueta de código Javascript */
var num=0;
num++;
var posicionCampo=1;

function addremision(){

nuevaFila = document.getElementById("tablaremision").insertRow(-1);

nuevaFila.id=posicionCampo;

nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='text' value="+num+++" size='2' name='int_caja_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='text' size='10' name='int_numd_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='text' size='10' name='int_numh_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='text' size='10' name='int_cant_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='text' size='10' name='int_peso_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='hidden' size='10' name='int_pesoneto_rd["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td> <input type='hidden' size='10' name='agregar["+posicionCampo+"]' ></td>";
nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda=nuevaFila.insertCell(-1);

nuevaCelda.innerHTML="<td><input type='button' value='Eliminar' onclick='eliminarremision(this)'></td>";

posicionCampo++;

}

function eliminarremision(obj){

var oTr = obj;

while(oTr.nodeName.toLowerCase()!='tr'){

oTr=oTr.parentNode;

}

var root = oTr.parentNode;

root.removeChild(oTr);

}

/* Cerramos el código Javascript */
icremento =0;
function crear(obj) {
  icremento++;
  
  field = document.getElementById('field'); 
  contenedor = document.createElement('div'); 
  contenedor.id = 'div'+icremento; 
  field.appendChild(contenedor); 
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='30';
  boton.placeholder='NOMBRE';
  <!--boton.value='responsable';-->
  boton.name = 'responsable_dest'+'[]'; 
  contenedor.appendChild(boton); 
   
  boton = document.createElement('input'); 
  boton.type = 'text';
  boton.size='21';
  boton.placeholder='DIRECCION';
  boton.name = 'direccion_dest'+'[]'; 
  contenedor.appendChild(boton); 
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='7';
  boton.placeholder='INDICATIVO';
  boton.name = 'indicativo_dest'+'[]'; 
  contenedor.appendChild(boton); 
  
  boton = document.createElement('input'); 
  boton.type = 'text';
  boton.size='17';
  boton.placeholder='TELEFONO';
  boton.name = 'telefono_dest'+'[]'; 
  contenedor.appendChild(boton);
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='7';
  boton.placeholder='EXTENSION';
  boton.name = 'extension_dest'+'[]'; 
  contenedor.appendChild(boton);   
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='17';
  boton.placeholder='CIUDAD';
  boton.name = 'ciudad_dest'+'[]'; 
  contenedor.appendChild(boton);    
   
  boton = document.createElement('input'); 
  boton.type = 'button'; 
  boton.value = 'Borrar'; 
  boton.name = 'div'+icremento; 
  boton.onclick = function () {borrar(this.name)} 
  contenedor.appendChild(boton); 
}
function borrar(obj) {
  field = document.getElementById('field'); 
  field.removeChild(document.getElementById(obj)); 
}
/* CREAR CAMPOS EN ORDEN DE COMPRAt */
icremento =0;
function crearrem(obj) {
  icremento++;
  
  field = document.getElementById('field'); 
  contenedor = document.createElement('div');
  contenedor.id = 'div'+icremento; 
  field.appendChild(contenedor); 
  
  boton = document.createElement('input');
  boton.type = 'int'; 
  boton.size='1';
  boton.name = 'int_consecutivo_io'+'[]'; 
  contenedor.appendChild(boton); 
   
  boton = document.createElement('input'); 
  boton.type = 'text';
  boton.name = 'int_cod_ref_io'+'[]'; 
  contenedor.appendChild(boton); 
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.name = 'int_cod_cliente_io'+'[]'; 
  contenedor.appendChild(boton); 
  
  boton = document.createElement('input'); 
  boton.type = 'int';
  boton.size='3';
  boton.name = 'int_cantidad_io'+'[]'; 
  contenedor.appendChild(boton);
  
  boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='5';
  boton.name = 'str_unidad_io'+'[]'; 
  contenedor.appendChild(boton);   
  
  boton = document.createElement('input'); 
  boton.type = 'date';
  boton.size='7';
  boton.name = 'fecha_entrega_io'+'[]'; 
  contenedor.appendChild(boton);  
  
    boton = document.createElement('input'); 
  boton.type = 'int'; 
  boton.size='3';
  boton.name = 'int_precio_io'+'[]'; 
  contenedor.appendChild(boton); 
  
    boton = document.createElement('input'); 
  boton.type = 'int'; 
  boton.size='3';
  boton.name = 'int_total_item_io'+'[]'; 
  contenedor.appendChild(boton); 
  
    boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.name = 'str_moneda_io'+'[]'; 
  contenedor.appendChild(boton);
  
    boton = document.createElement('input'); 
  boton.type = 'text'; 
  boton.size='15';
  boton.name = 'str_direccion_desp_io'+'[]'; 
  contenedor.appendChild(boton); 
  
    boton = document.createElement('input'); 
  boton.type = 'int'; 
  boton.name = 'int_vendedor_io'+'[]'; 
  contenedor.appendChild(boton); 
  
    boton = document.createElement('input'); 
  boton.type = 'int'; 
  boton.size='1';
  boton.name = 'int_comision_io'+'[]'; 
  contenedor.appendChild(boton);    
   
  boton = document.createElement('input'); 
  boton.type = 'button'; 
  boton.value = 'Borrar'; 
  boton.name = 'div'+icremento; 
  boton.onclick = function () {borrar(this.name)} 
  contenedor.appendChild(boton); 
}
function borrar(obj) {
  field = document.getElementById('field'); 
  field.removeChild(document.getElementById(obj)); 
}


$(document).ready(function() {

    var MaxInputs       = 8; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón Agregar

    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;
    var FieldCount = x-1; //para el seguimiento de los campos

    $(AddButton).click(function (e) {
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++;
            //agregar campo
            $(contenedor).append('<div><input type="text" name="mitexto[]" id="campo_'+ FieldCount +'" placeholder="Texto '+ FieldCount +'"/><a href="#" class="eliminar">&times;</a></div>');
            x++; //text box increment
        }
        return false;
    });

    $("body").on("click",".eliminar", function(e){ //click en eliminar campo
        if( x > 1 ) {
            $(this).parent('div').remove(); //eliminar el campo
            x--;
        }
        return false;
    });
});
 