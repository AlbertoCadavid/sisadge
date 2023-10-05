// J /* Abrimos etiqueta de código Javascript */
function AddItemCompra() {
  var tbody = null;
  var tablaf = document.getElementById("tablaf");
  var nodes = tablaf.childNodes;
  for (var x = 0; x<nodes.length;x++) {
    if (nodes[x].nodeName == 'TBODY') {
      tbody = nodes[x];
      break;
    }
  }
  if (tbody != null) {
    var tr = document.createElement('tr');
    tr.innerHTML = '<td><input type="text" name="int_desde_f[]" Totalizar(this);" value="" autofocus="autofocus" required="required"/></td><td><input type="text" name="int_hasta_f[]" Totalizar(this);"  value="" required="required"/></td><td><input type="text" size="2" name="int_total_f[]" readonly /></td><td><button type="button" value="Borrar" onclick="eliminaDinamicos(this);Totalizar(this);">Borrar</button></td>';
    tbody.appendChild(tr);
  }
}

//------------------FUNCION PARA RESTAR HASTA MENOS DESDE----//
function Totalizar(ele) {
  var num="",caden="",l="",b="",c="",d="",e="",g="",h="",desde="", sal="",sal2="",cadena="";
  var int_desde_f = 0, int_hasta_f = 0, int_total_f = 0;
  var tr = ele.parentNode.parentNode;
  var nodes = tr.childNodes; 
  for (var x = 0; x<nodes.length;x++) { 
       //------------------CADENA DEFINIDA DESDE-------------------// 
       if (nodes[x].firstChild.name == 'int_desde_f[]') {
        adesde = (nodes[x].firstChild.value);      
       }//FIN IF INPUT DESDE
       //------------------CADENA DEFINIDA HASTA-------------------// 
       if (nodes[x].firstChild.name == 'int_hasta_f[]') {
        ahasta = (nodes[x].firstChild.value);  
       }//FIN IF INPUT HASTA

    }//FIN FOR DE NODOS


}//FIN FUNCION Totalizar



//---FUNCION ELIMINA LINEA DE INPUT DE FALTANTES DINAMICOS-----//
function eliminaDinamicos(obj){
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
  boton.type = 'checkbox';  
  boton.placeholder='NOMBRE';
  boton.disabled ='disabled';
  boton.value='';
  boton.name = 'items'+'[]'; 
  contenedor.appendChild(boton); 

  boton = document.createElement('select'); 
  boton.type = 'text'; 
  boton.placeholder='Seleccione Proveedor';
  boton.value='proveedor';
  boton.style='200px';
  boton.name = 'proveedor'+'[]'; 
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
   
/*  boton = document.createElement('input'); 
  boton.type = 'button'; 
  boton.value = 'Borrar'; 
  boton.name = 'div'+icremento; 
  boton.onclick = function () {borrar(this.name)} 
  contenedor.appendChild(boton); */
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
            $(contenedor).append('<input type="text" name="mitexto[]" id="campo_'+ FieldCount +'" placeholder="Texto '+ FieldCount +'"/><a href="#" class="eliminar">&times;</a> ');
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
 