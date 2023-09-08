// JavaScript Document
 
// Función para recoger los datos de PHP según el navegador, se usa siempre.
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
 
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}
 
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	  xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
 
//Función para recoger los datos del formulario y enviarlos por post  
function enviarDatosEmpleado(){
 
  //div donde se mostrará lo resultados
  divResultado = document.getElementById('resultado_extrusion');
  //recogemos los valores de los inputs
  nom=document.nuevo_empleado.nombre.value;
  ape=document.nuevo_empleado.apellido.value;
  web=document.nuevo_empleado.web.value;
 
  //instanciamos el objetoAjax
  ajax=objetoAjax();
 
  //uso del medotod POST
  //archivo que realizará la operacion
  //registro.php
  ajax.open("POST", "registro.php",true);
  //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
  ajax.onreadystatechange=function() {
	  //la función responseText tiene todos los datos pedidos al servidor
  	if (ajax.readyState==4) {
  		//mostrar resultados en esta capa
		divResultado.innerHTML = ajax.responseText
  		//llamar a funcion para limpiar los inputs
		LimpiarCampos();
	}
 }
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores a registro.php para que inserte los datos
	ajax.send("nombre="+nom+"&apellido="+ape+"&web="+web)
}
 
//función para limpiar los campos
function LimpiarCampos(){
  document.nuevo_empleado.nombre.value="";
  document.nuevo_empleado.apellido.value="";
  document.nuevo_empleado.web.value="";
  document.nuevo_empleado.nombre.focus();
}
//AL DAR CLICK
// JavaScript Document
//------------------------------------Consulta BD--------------------------------
var objeto = false;
function crearObjeto() {	
// --- Crear el Objeto dependiendo los diferentes Navegadores y versiones ---
try { objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
catch (e) {
try { objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
catch (E) {
objeto = false; }
}
// --- Si no se pudo crear... intentar este ultimo metodo ---
if (!objeto && typeof XMLHttpRequest!='undefined') {
objeto = new XMLHttpRequest();
}
} 
//consulta input
function inputs(gestion,campo,dato) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else { objeto.onreadystatechange = ResultadoGestiones; 
if(gestion==1)
{ objeto.open("GET", "input.php?"+ campo+"="+ dato, true); }

objeto.send(null); } }
function ResultadoGestiones() {
if (objeto.readyState == 1) { document.getElementById('resultado2').innerHTML = "Cargando..."; }
if (objeto.readyState == 4) { document.getElementById('resultado2').innerHTML = objeto.responseText; }
}