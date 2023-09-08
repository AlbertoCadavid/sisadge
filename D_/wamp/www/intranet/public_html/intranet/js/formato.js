// JavaScript Document
// validar formulario
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' debe contener una dirección de correo electrónico correcta.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' debe contener números.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' debe contener un numero entre '+min+' y '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es obligatorio.\n'; }
  } if (errors) alert('Corregir los siguientes campos:\n'+errors);
  document.MM_returnValue = (errors == '');
} 
//-->
/*Ver archivos adjuntos*/
function detener(){
return true
}
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
/**/
//DELETE REGISTROS SIMPLES
function eliminar(campo,id,pagina) 
{
	if(campo=='menu')
	{
		elim=confirm("Si elimina este MENU, automaticamente se eliminaran los SUBMENU'S respectivos");
	}
	else if(campo=='id_tipo')
	{
		elim=confirm("Si elimina este TIPO DE USUARIO, automaticamente se eliminaran los PERMISOS respectivos");
	}	
	if(campo=='n_cn')
	{
		elim=confirm("¿Quieres Eliminar?");
		if(elim)
		{
			window.location ="delete.php?"+ campo+"="+ id;
		}
		else
		{
			window.history.back();
		}
	}
	if(campo=='n_egl')
	{
		campo='egl';
		elim=confirm("Si elimina un EGL, tambien se eliminara los archivos adjuntos y los colores asignados. Desea eliminar?");
	}
	else
	{
		elim=confirm("¿Quieres Eliminar?");
	}
	/*SI ACEPTA, IRA A LA PAGINA OCULTA DE BORRADO*/
	if(elim)
	{
		window.location ="delete.php?"+ campo+"="+ id;
	}
	/*SINO, VOLVERA A LA PAGINA QUE LO LLAMO*/
	else
	{
		if(campo=='egl'){ campo='n_egl'; }
		if(campo=='menu'){ campo='id_menu'; }
		window.location = pagina+"?"+ campo+"="+ id;
	}	
}
//DELETE REGISTROS ESPECIFICOS
function eliminar1(campo,id,pagina) 
{
	elim=confirm("¿Quieres Eliminar?");
	if(elim) { window.location ="delete.php?"+ campo+"="+ id; }
	else { window.history.go(); } 
}

//-->
//DELETE REGISTROS COMPLEJOS
function eliminar2(campo,id,pagina,foranea1,foranea2) 
{ 
  elim=confirm("¿Quieres Eliminar?"); 
  if(elim){ window.location ="delete.php?"+ foranea1+"="+ foranea2+"&"+ campo+"="+ id;
	  //window.location ="delete.php?"+ campo+"="+ id+"&"+ foranea1+"="+ foranea2;
  }
  else 
  {
	  if(campo=='id_color')
	    {
			campo='color';
		}
	  if(campo=='id_archivo')
	    {
			campo='archivo';
		}
	  if(foranea1=='tipo')
		{
			foranea1='id_tipo';
		}
	window.location = pagina+"?"+ foranea1+"="+ foranea2+"&"+ campo+"="+ id;
  } 
}
//-->
//-->
//DELETE archivos adjuntos
function eliminar3(campo,id,pagina,archivo) 
{ 
  elim=confirm("¿Quieres Eliminar definitivamente el archivo?"); 
  if(elim) 
  {
	  window.location ="delete.php?"+campo+"="+ id+"&archivo="+ archivo;
  }
  else 
  {
	 if(campo=='egparchivo')
	 {
		 campo='n_egp';
	 }
	 history.go();
	 //window.location = pagina+"?"+ campo+"="+ id;
  } 
}
//-->
/*Ver archivos adjuntos*/
function detener(){
return true
}
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
//-->
/*pedido_bolsa_detalle*/
function evalGroup(id)
{
     var group = document.form1.id_ref_pedido;
     for (var i=0; i<group.length; i++) {
     if (group[i].checked) break; }     
     alert("Radio Button " + (i+1) + " is checked.");
}
function consult_ficha(id_mp_vta) 
{
	elim=confirm("¿Quieres Consultas?");
	if(elim) { window.location ="consultar_ficha.php?"+ id_mp_vta+"="+ id_mp_vta; }
	else { window.history.go(); } 
}