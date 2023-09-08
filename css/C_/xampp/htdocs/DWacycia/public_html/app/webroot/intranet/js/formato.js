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

/*function verFoto(img, ancho, alto){
  derecha=(screen.width-ancho)/2;
  arriba=(550-alto)/2;
  string="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
  fin=window.open(img,"",string);
}*/

function popUp(URL, ancho, alto) {
day = new Date();
id = day.getTime();
derecha=(screen.width-ancho)/2;
arriba=(screen.height-alto)/2;
ventana="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
eval("page" + id + " = window.open(URL, '" + id + "', '" + ventana + "');");
}

function agregueImagen(pref){ 
   	opener.document.form1.N_embobinado.value = pref 
   	window.close() 
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
		}else
		//generadores
		if(campo=='id_genera')
		  {
			elim=confirm("¿Quieres Eliminar el generador?");
			if(elim)
			{
				window.location ="delete.php?"+ campo+"="+ id;
			}
	     }	//fin				
		
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

function eliminar1(id,campo,pagina) 
{
	elim=confirm("Quieres Eliminar?");
	if(elim) { window.location ="delete.php?"+id+"="+campo; }
	else { window.history.go(); }
}
function eliminarcliente(campo,id,pagina) 
{
	elim=confirm("Quieres Eliminar?");
	if(elim) { window.location ="delete.php?"+campo+"="+id; }
	else { window.history.go(); } 
}
//-->
//DELETE REGISTROS COMPLEJOS
function eliminar2(campo,id,pagina,foranea1,foranea2) 
{ 
  elim=confirm("¿Quieres Eliminar?"); 
  if(elim){ window.location ="delete.php?"+foranea1+"="+foranea2+"&"+campo+"="+id;
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
function elimina_complejos(n,v,n2,v2,n3,v3,pagina) {
	//generadores valor
		if(n=='id_genera_gv')
		  {
			elim=confirm("¿Quieres Eliminar el Registro?");
			if(elim)
			{
				window.location ="delete.php?"+ n+"="+ v;
			}//sino no hace nada
		  }
	     }	//fin
<!--update o.c reasignacion-->
function update(campo,id,pagina) 
{
	elim=confirm("¿Seguro Quiere Reasignar el numero de O.C ?");
	if(elim) { window.location ="orden_compra_cl_reasig_oc.php?"+ campo+"="+ id; }
	else { window.history.go(); } 
}
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
function verPopUp(img, ancho, alto){
 

  document.form1.submit();
	
  derecha=(screen.width-ancho)/2;
  arriba=(550-alto)/2;
  string="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
  fin=window.open(img,"",string);

 }
 function verPopUp2(img, ancho, alto){
  document.form1.submit(); 
   
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
function consult_ficha(campo,id_mp_vta) 
{
	elim=confirm("¿Quiere Consultar?");
	if(elim) { window.location ="consultar_ficha.php?"+ campo+"="+ id_mp_vta; }
	else { window.history.go(); } 
}
function eliminar4(campo,id_mp_vta)
{
 ventana=confirm("¿Quiere Eliminar?");
 if (ventana){ window.location ="delete2.php?"+campo+"="+ id_mp_vta; }
 else {window.history.go(); } 
}
function eliminar_b(id1,delete_bolsa,id2,delete_bolsa_ref,id3,id_refcliente,id4,tipo)
{
  var id1="delete_bolsa";
 ventana=confirm("¿Quiere Eliminar de la Cotizacion bolsa?");
 if (ventana){ window.location ="delete2.php?delete_bolsa="+ delete_bolsa+"&delete_bolsa_ref="+ delete_bolsa_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
 else {window.history.go(); } 
}
function eliminar_l(id1,delete_lamina,id2,delete_lamina_ref,id4,id_refcliente,id5,tipo)
{
  var id1="delete_lamina";
 ventana=confirm("¿Quiere Eliminar de la Cotizacion lamina?");
 if (ventana){ window.location ="delete2.php?delete_lamina="+ delete_lamina+"&delete_lamina_ref="+ delete_lamina_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
 else {window.history.go(); } 
} 
function eliminar_m(id1,delete_mp,id2,delete_mp_ref,id4,id_refcliente,id5,tipo)
{
  var id1="delete_mp";
 ventana=confirm("¿Quiere Eliminar de la Cotizacion materia prima?");
 if (ventana){ window.location ="delete2.php?delete_mp="+ delete_mp+"&delete_mp_ref="+ delete_mp_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
 else {window.history.go(); } 
}
function eliminar_p(id1,delete_pl,id2,delete_pl_ref,id4,id_refcliente,id5,tipo)
{
  var id1="delete_pl";
 ventana=confirm("¿Quiere Eliminar de la Cotizacion packing list?");
 if (ventana){ window.location ="delete2.php?delete_pl="+ delete_pl+"&delete_pl_ref="+ delete_pl_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
 else {window.history.go(); } 
}
function eliminar_ref(campo,id,pagina) 
{
  if(campo=='id_ref_b')
	{
 ventana=confirm("¿Quiere Eliminar la Referencia?");
 if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
 else {window.history.go(); } 
	}
	else 
	if(campo=='id_ref_l')
	{
	 ventana=confirm("¿Quiere Eliminar la Referencia?");
 if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
 else {window.history.go(); } 
	}
	else 
	if(campo=='id_ref_m')
	{
	 ventana=confirm("¿Quiere Eliminar la Referencia?");
 if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
 else {window.history.go(); } 
	}
	else 
	if(campo=='id_ref_p')
	{
	 ventana=confirm("¿Quiere Eliminar la Referencia?");
 if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
 else {window.history.go(); } 
	}		
}
/*----------------- SELLADO TIQUETE------------------*/
function eliminar_sp(campo1,id_tn)
{
 ventana=confirm("Quiere Eliminar el Paquete y sus faltantes?");
 if (ventana == true)
 { 
   window.location ="delete2.php?"+campo1+"="+id_tn;
 } 
 else if (ventana == false)
 {window.history.go(); } 
}
function eliminar_sppxc(campo1,id_tnpxc)
{
 ventana=confirm("Quiere Eliminar el Paquete y sus faltantes?");
 if (ventana == true)
 { 
   window.location ="delete2.php?"+campo1+"="+id_tnpxc;
 } 
 else if (ventana == false)
 {window.history.go(); } 
}
/*----------------- EXTRUSION------------------*/
//EDIT
function eliminar_rte(id1,valor)
{
 ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor}
 else if (ventana == false){window.history.go(); } 
}
/*function eliminar_rt(id1,id_rt)
{
 ventana=confirm("Quiere Eliminar el Tiempo Muerto?");
 if (ventana == true){ window.location ="delete2.php?id_rt="+id_rt }
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rp(id1,id_rp)
{
 ventana=confirm("Quiere Eliminar el Tiempo Preparacion?");
 if (ventana == true){ window.location ="delete2.php?id_rp="+id_rp }
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rd(id1,id_rd)
{
 ventana=confirm("Quiere Eliminar el Kilo Desperdicio?");
 if (ventana == true){ window.location ="delete2.php?id_rd="+id_rd}
 else if (ventana == false){window.history.go(); } 
} 
function eliminar_ip(id1,id_ip)
{
 ventana=confirm("Quiere Eliminar el Kilo Producido?");
 if (ventana == true){ window.location ="delete2.php?id_ip="+id_ip}
 else if (ventana == false){window.history.go(); } 
}*/

/*function eliminar_rpe(id1,id_rpe)
{
 ventana=confirm("Quiere Eliminar el Tiempo Preparacion?");
 if (ventana == true){ window.location ="delete2.php?id_rpe="+id_rpe}
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rde(id1,id_rde)
{
 ventana=confirm("Quiere Eliminar el Kilo Desperdicio?");
 if (ventana == true){ window.location ="delete2.php?id_rde="+id_rde}
 else if (ventana == false){window.history.go(); } 
}
function eliminar_ipe(id1,id_ipe)
{
 ventana=confirm("Quiere Eliminar Los Kilo Producido?");
 if (ventana == true){ window.location ="delete2.php?id_ipe="+id_ipe}
 else if (ventana == false){window.history.go(); } 
}*/
/*----------------- IMPRESION------------------*/
//IMPRESION EDIT
function eliminar_rtei(id1,valor)
{
 ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor} 
 else if (ventana == false){window.history.go(); } 
}
/*function eliminar_rti(id1,id_rti)
{
 ventana=confirm("Quiere Eliminar el Tiempo Muerto?");
 if (ventana == true){ window.location ="delete2.php?id_rti="+id_rti }
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rpi(id1,id_rpi)
{
 ventana=confirm("Quiere Eliminar el Tiempo Preparacion?");
 if (ventana == true){ window.location ="delete2.php?id_rpi="+id_rpi}
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rdi(id1,id_rdi)
{
 ventana=confirm("Quiere Eliminar el Kilo Desperdicio?");
 if (ventana == true){ window.location ="delete2.php?id_rdi="+id_rdi}
 else if (ventana == false){window.history.go(); } 
}
function eliminar_ipi(id1,id_rkp)
{
 ventana=confirm("Quiere Eliminar el Kilo Producido?");
 if (ventana == true){ window.location ="delete2.php?id_ipi="+id_rkp}
 else if (ventana == false){window.history.go(); } 
}*/

/*-----------------SELLADO------------------*/
function eliminar_rts(id1,valor)
{
 ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor}
 else if (ventana == false){window.history.go(); } 
}
  
/*function eliminar_rps(id1,id_rps)
{
 ventana=confirm("Quiere Eliminar el Tiempo Preparacion?");
 if (ventana == true){ window.location ="delete2.php?id_rps="+id_rps }
 else if (ventana == false){window.history.go(); } 
}
function eliminar_rds(id1,id_rds)
{
 ventana=confirm("Quiere Eliminar el Kilo Desperdicio?");
 if (ventana == true){ window.location ="delete2.php?id_rds="+id_rds}
 else if (ventana == false){window.history.go(); } 
}
function eliminar_ips(id1,id_ips)
{
 ventana=confirm("Quiere Eliminar Materia Prima?");
 if (ventana == true){ window.location ="delete2.php?id_ips="+id_ips}
 else if (ventana == false){window.history.go(); } 
}*/




function eliminar_liq(id,campo)
{
 ventana=confirm("Quiere Eliminar Rollo Liquidado?");
 if (ventana == true){ window.location ="delete.php?"+id+"="+campo}
 else if (ventana == false){window.history.go(); } 
}
//PROCESO IMPRESION ELIMINAR Y APDATE DE UNIDADES
function update() { //v1.0
   msg=confirm("Esta seguro que Quiere Actualizar?");
   if (msg == true){
   document.forms["form2"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
function eliminar_u_i() { //v1.0
   msg=confirm("Esta seguro que Quiere Eliminar?");
   if (msg == true){
   document.forms["form3"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
function eliminar_extrusion() { //v1.0
   msg=confirm("Esta seguro que Quiere Eliminar  el Rollo?");
   if (msg == true){
   document.forms["seleccion"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
function eliminar_impresion() { //v1.0
   msg=confirm("Esta seguro que Quiere Eliminar el Rollo? ");
   if (msg == true){
   document.forms["seleccion"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
function eliminar_refilado() { //v1.0
   msg=confirm("Esta seguro que Quiere Eliminar el Rollo?");
   if (msg == true){
   document.forms["seleccion"].submit();
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
}
//COSTOS
function eliminar_costeo() { //v1.0
   msg=confirm("Quiere Eliminar El costeo de este mes?");
   if (msg == true){
   document.forms["form2"].submit();
   return true;
   }
   else if (msg == false){
	   window.history.go(); 
   return false;
   } 
}

//Envia el form dependendiendo del button
function enviaForm(pag){
      
    msg=confirm("Esta seguro que Quiere Ajustar el Inventario del Sisadge con el Fisico?");
     if (msg == true){
		document.forms["form2"].action= pag  
		document.forms["form2"].submit() 
        return true;
    }else
       return false;
} 
function enviaForm2(pag){
      
    msg=confirm("Esta seguro que Quiere Guardar el Costeo del Inventario?");
     if (msg == true){
		document.forms["form2"].action= pag  
		document.forms["form2"].submit() 
        return true;
    }else
       return false;
} 
//CERTIFICACIONES
function limpiar(cual, accion){
// Action: 0=Deseleccionar todos 1=Seleccionar todos -1=Invertir seleccion
	var f = document.form1
	for (var i=0; i<f.elements.length; i++){
		var obj = f.elements[i] 
		var name = obj.name
		if (name==cual){
			obj.checked = ((accion==1)? true : ((accion==0)? false : !obj.checked) );
		}
	}
}
function enviar_formularios()
{
//Enviamos los dos primeros formularios estaticos de la web
 document.form1.submit();
 document.form2.submit();
 return true;
}
 function envio_form(name){
  name.disabled=true;//name es el name de cualquier boton 
  document.form1.submit(); 
 return true;
}
function mayusculaPrimeras(oracion){ 
oracion.value = oracion.value.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1){
return $1.toUpperCase(); 
});
}
 