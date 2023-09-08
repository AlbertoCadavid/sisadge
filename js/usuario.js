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
// ------------------------------Datos del Usuario-----------
function DatosUsuario(usuario) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoUsuario;
// Enviar la consulta
objeto.open("GET", "usuario_consulta1.php?usuario=" + usuario, true);
objeto.send(null);
}
}
function ResultadoUsuario() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
document.getElementById('existe').innerHTML = "Cargando...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('existe').innerHTML = objeto.responseText;
}
}
// ----------------------------------------------------------
// ------------------------------Definicion Usuario-----------
function DefinicionUsuario(tipo,iduser) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoDefinicion;
// Enviar la consulta
objeto.open("GET", "usuario_consulta2.php?tipo_usuario=" + tipo + '&iduser='+iduser, true);
objeto.send(null);
}
}
// --------------------------

function ResultadoDefinicion() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
document.getElementById('definicion').innerHTML = "Cargando...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion').innerHTML = objeto.responseText;
}
}