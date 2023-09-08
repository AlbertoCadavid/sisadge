function onbeforeprint()//window.
{ noprint.style.visibility = 'hidden'; noprint.style.position = 'absolute'; }
function onafterprint()//window.
{ noprint.style.visibility = 'visible'; noprint.style.position = 'relative'; }
/*Ver archivos adjuntos*/
function detener()
{ return true }
window.onerror=detener

function verFoto(img, ancho, alto){
  derecha=(screen.width-ancho)/2;
  arriba=(550-alto)/2;
  string="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
  fin=window.open(img,"",string);
}
function popUp(URL, ancho, alto) {
day = new Date();
id = day.getTime();
derecha=(screen.width-ancho)/2;
arriba=(screen.height-alto)/2;
ventana="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
eval("page" + id + " = window.open(URL, '" + id + "', '" + ventana + "');");
}