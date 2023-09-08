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
// ------------------------------ADMINISTRADOR consulta.php  -----------
function DatosConsulta(campo,dato) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoConsulta;
// Enviar la consulta
if(dato=='')
{
	dato=0;
}
objeto.open("GET", "consulta.php?"+ campo+"="+ dato, true);
objeto.send(null);
}
}
function ResultadoConsulta() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
document.getElementById('resultado').innerHTML = "Cargando...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('resultado').innerHTML = objeto.responseText;
}
}
// ------------------------------GESTIONES ------------------------------
function DatosCiudad(gestion,campo,dato) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else { objeto.onreadystatechange = ResultadoGestiones; 
if(gestion==1)
{ objeto.open("GET", "consulta_ciudad.php?"+ campo+"="+ dato, true); }
if(gestion==3)
{ objeto.open("GET", "consulta_compras.php?"+ campo+"="+ dato, true); }
if(gestion==4)
{ objeto.open("GET", "consulta_produccion.php?"+ campo+"="+ dato, true); }
if(gestion==41)
{ objeto.onreadystatechange = ResultadoGestiones1;
  objeto.open("GET", "consulta_produccion.php?"+ campo+"="+ dato, true); }
objeto.send(null); } }
function ResultadoGestiones() {
if (objeto.readyState == 1) { document.getElementById('resultado').innerHTML = "Cargando..."; }
if (objeto.readyState == 4) { document.getElementById('resultado').innerHTML = objeto.responseText; }
}
function ResultadoGestiones1() {
if (objeto.readyState == 1) { document.getElementById('resultado1').innerHTML = "Cargando..."; }
if (objeto.readyState == 4) { document.getElementById('resultado1').innerHTML = objeto.responseText; }
}
