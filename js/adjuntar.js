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
/*------------------------------------------------------------------------*/
/*----------------------ADJUNTAR ARCHIVOS---------------------------------*/
function ArchivoAdjunto(primero) {
crearObjeto();
if (objeto.readyState != 0) 
{ alert('Error al crear el objeto XML. El Navegador no soporta AJAX'); } 
else {
	objeto.onreadystatechange = ArchivoAdjuntado;
	objeto.open("GET", "consulta_archivo_adjunto.php?"+ numero+"="+ primero, true);
	objeto.send(null);
	}
}
function ArchivoAdjuntado() { 
if (objeto.readyState == 1) {
document.getElementById('adjuntado').innerHTML = "Cargando..."; }
if (objeto.readyState == 4) {
document.getElementById('adjuntado').innerHTML = objeto.responseText; } 
}
/*------------------------------------------------------------------------*/
