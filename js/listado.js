// JavaScript Document
//Efecto del mouse en los listados y señalizacion de toda la fila
function uno(src,color_entrada) { 
    src.bgColor=color_entrada;src.style.cursor="hand"; 
} 
function dos(src,color_default) { 
    src.bgColor=color_default;src.style.cursor="default"; 
}
function seleccionar_todo(){ 
   for (i=0;i<document.seleccion.elements.length;i++) 
      if(document.seleccion.elements[i].type == "checkbox") 
         document.seleccion.elements[i].checked=1 
}
function deseleccionar_todo(){ 
   for (i=0;i<document.seleccion.elements.length;i++) 
      if(document.seleccion.elements[i].type == "checkbox") 
         document.seleccion.elements[i].checked=0 
}
function refrescar() 
{ 
window.location.reload(); 
} 
function redireccionar(campo,dato)
{ 
window.location=("proveedor_insumo.php?"+ campo+"="+ dato);
} 
 
function AutoRefresh (t) {
	setTimeout ("location.reload (true);", t);
} 
//ENTRADAS DE INVENTARIO
function eliminar_listados() { //v1.0
   msg=confirm("Esta seguro que Quiere Eliminar?");
   if (msg == true){
   document.forms["seleccion"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
function ListadoProduccion(pag,name,valor){
	window.location.href = pag+"?"+name+"="+ valor; 
/*    do { 
        obj=obj.parentNode; 
    } while(obj.tagName!="FORM"); //se obtiene el nombre del form
	var formu=obj.name; */
		   
	    // obtenemos e valor por el numero de elemento
        //var porElementos=document.forms["form1"].elements[0].value;
        // Obtenemos el valor por el id
        //var porId=document.getElementById("nombre").value;
        // Obtenemos el valor por el Nombre
        //var porNombre=document.getElementsByName("nombre")[0].value;
        // Obtenemos el valor por el tipo de tag
        //var porTagName=document.getElementsByTagName("input")[0].value;
        // Obtenemos el valor por el nombre de la clase
        //var porClassName=document.getElementsByClassName("formulario")[0].value;
}
/*----------------GGA, CIFF ETC---------------*/
function estado_gastos() 
{
 ventana=confirm("Quiere cambiar el estado?");
 if (ventana == true){ document.form1.submit();}//+"?"+name+"="+ valor; 
 else if (ventana == false){window.history.go(); } 
}