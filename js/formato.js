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
			if (p<1 || p==(val.length-1)) errors+='- '+nm+' debe contener una direcci�n de correo electr�nico correcta.\n';
		} else if (test!='R') { num = parseFloat(val);
			if (isNaN(val)) errors+='- '+nm+' debe contener n�meros.\n';
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
		elim=confirm("�Quieres Eliminar?");
		if(elim)
		{
			window.location ="delete.php?"+ campo+"="+ id;
		}else
		//generadores
		if(campo=='id_genera')
		{
			elim=confirm("�Quieres Eliminar el generador?");
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
	 	elim=confirm("�Quieres Eliminar?");
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
//eliminar registro completamente
function eliminar1(id,campo,pagina=''){
	swal({   
		title: "ELIMINAR?",   
		text: "Esta seguro que Quiere Eliminar!",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Si, eliminar!",   
		cancelButtonText: "No, eliminar!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
		function(isConfirm){   
			if (isConfirm) {  
				swal("Eliminado!", "El registro se ha eliminado.", "success"); 
				window.location ="delete.php?"+id+"="+campo+"&pagina="+pagina; 
			} else {     
				swal("Cancelado", "has cancelado :)", "error");
				window.history.go();
			} 
		});      
}


function eliminar_cliente(id,campo,pagina){
	swal({   
		title: "ELIMINAR?",   
		text: "Esta seguro que Quiere Eliminar!",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Si, eliminar!",   
		cancelButtonText: "No, eliminar!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
		function(isConfirm){   
			if (isConfirm) {  
				swal("Eliminado!", "El registro se ha eliminado.", "success"); 
				window.location ="delete.php?"+id+"="+campo; 
			} else {     
				swal("Cancelado", "has cancelado :)", "error");
				window.history.go();
			} 
		});      
}
//eliminar registro completamente
function update1(id,campo,pagina){
	swal({   
		title: "CAMBIO DE ESTADO?",   
		text: "Esta seguro que Quiere cambiar estado!",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Si, cambiar!",   
		cancelButtonText: "No, cambiar!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
		function(isConfirm){   
			if (isConfirm) {  
				swal("Actualizado!", "El registro se ha actualizado.", "success"); 
				window.location ="delete.php?"+id+"="+campo; 
			} else {     
				swal("Cancelado", "has cancelado :)", "error");
				window.history.go();
			} 
		});      
}
 //cambio de estados
 function activar1(id,campo,activo,pagina){
 	if (activo==0)
 		{var ina='INACTIVAR'}else if (activo==1){var ina='ACTIVAR'}
 	swal({   
 		title: ina+"?",   
 		text: "Esta seguro que Quiere "+ina+"!",   
 		type: "warning",   
 		showCancelButton: true,   
 		confirmButtonColor: "#DD6B55",   
 		confirmButtonText: "Si, "+ina+"!",   
 		cancelButtonText: "No, "+ina+"!",   
 		closeOnConfirm: false,   
 		closeOnCancel: false }, 
 		function(isConfirm){   
 			if (isConfirm) {  
 				swal(+ina+"!", "El registro se ha "+ina+"!", "success"); 
 				window.location ="delete.php?"+id+"="+campo; 
 			} else {     
 				swal("Cancelado", "has cancelado :)", "error");
 				window.history.go();
 			} 
 		});      
 }
/*function eliminar1(id,campo,pagina)  
{
	elim=confirm("Quieres Eliminar?");
	if(elim) { window.location ="delete.php?"+id+"="+campo; }
	else { window.history.go(); }
}*/
//-->
//DELETE REGISTROS COMPLEJOS
function eliminar2(campo,id,pagina,foranea1,foranea2) 
{ 
	elim=confirm("�Quieres Eliminar?"); 
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
		elim=confirm("�Quieres Eliminar el Registro?");
		if(elim)
		{
			window.location ="delete.php?"+ n+"="+ v;
			}//sino no hace nada
		}
	     }	//fin
	     <!--update o.c reasignacion-->
	     function update(campo,id,pagina) 
	     {
	     	elim=confirm("�Seguro Quiere Reasignar el numero de O.C ?");
	     	if(elim) { window.location ="orden_compra_cl_reasig_oc.php?"+ campo+"="+ id; }
	     	else { window.history.go(); } 
	     }
//-->
//DELETE archivos adjuntos
function eliminar3(campo,id,pagina,archivo) 
{ 
	elim=confirm("�Quieres Eliminar definitivamente el archivo?"); 
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
		elim=confirm("�Quiere Consultar?");
		if(elim) { window.location ="consultar_ficha.php?"+ campo+"="+ id_mp_vta; }
		else { window.history.go(); } 
	}
	function eliminar4(campo,id_mp_vta)
	{
		ventana=confirm("�Quiere Eliminar?");
		if (ventana){ window.location ="delete2.php?"+campo+"="+ id_mp_vta; }
		else {window.history.go(); } 
	}
	function eliminar_b(id1,delete_bolsa,id2,delete_bolsa_ref,id3,id_refcliente,id4,tipo)
	{
		var id1="delete_bolsa";
		ventana=confirm("�Quiere Eliminar de la Cotizacion bolsa?");
		if (ventana){ window.location ="delete2.php?delete_bolsa="+ delete_bolsa+"&delete_bolsa_ref="+ delete_bolsa_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
		else {window.history.go(); } 
	}
	function eliminar_l(id1,delete_lamina,id2,delete_lamina_ref,id4,id_refcliente,id5,tipo)
	{
		var id1="delete_lamina";
		ventana=confirm("�Quiere Eliminar de la Cotizacion lamina?");
		if (ventana){ window.location ="delete2.php?delete_lamina="+ delete_lamina+"&delete_lamina_ref="+ delete_lamina_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
		else {window.history.go(); } 
	} 
	function eliminar_m(id1,delete_mp,id2,delete_mp_ref,id4,id_refcliente,id5,tipo)
	{
		var id1="delete_mp";
		ventana=confirm("�Quiere Eliminar de la Cotizacion materia prima?");
		if (ventana){ window.location ="delete2.php?delete_mp="+ delete_mp+"&delete_mp_ref="+ delete_mp_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
		else {window.history.go(); } 
	}
	function eliminar_p(id1,delete_pl,id2,delete_pl_ref,id4,id_refcliente,id5,tipo)
	{
		var id1="delete_pl";
		ventana=confirm("�Quiere Eliminar de la Cotizacion packing list?");
		if (ventana){ window.location ="delete2.php?delete_pl="+ delete_pl+"&delete_pl_ref="+ delete_pl_ref+"&id_refcliente="+ id_refcliente+"&tipo="+ tipo; }
		else {window.history.go(); } 
	}
	function eliminar_ref(campo,id,pagina) 
	{
		if(campo=='id_ref_b')
		{
			ventana=confirm("�Quiere Eliminar la Referencia?");
			if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
			else {window.history.go(); } 
		}
		else 
			if(campo=='id_ref_l')
			{
				ventana=confirm("�Quiere Eliminar la Referencia?");
				if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
				else {window.history.go(); } 
			}
			else 
				if(campo=='id_ref_m')
				{
					ventana=confirm("�Quiere Eliminar la Referencia?");
					if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
					else {window.history.go(); } 
				}
				else 
					if(campo=='id_ref_p')
					{
						ventana=confirm("�Quiere Eliminar la Referencia?");
						if (ventana){ window.location ="delete2.php?"+ campo+"="+ id; }
						else {window.history.go(); } 
					}		
				}
				/*----------------- SELLADO TIQUETE------------------*/
				function eliminar_sp(campo1,id_tn)
				{
					swal({
						title: "Estas seguro?",
						text: "Quiere Eliminar el Paquete y sus faltantes?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Si, Eliminarlos!',
						cancelButtonText: "No, cancelarlo!",
						closeOnConfirm: false,
                    // closeOnCancel: false
                   },
                   function(isConfirm) {
                   	if (isConfirm) {
                   		swal({
                   			title: 'Preseleccion!',
                   			text: 'Los archivos fueron eliminados correctamente!',
                   			type: 'success',
                   			timer: 5,
                   			showConfirmButton: false
                   		}, function() {
        						// form.submit();
        						window.location ="delete2.php?"+campo1+"="+id_tn;
        					});        

                   	} else {
                   		swal("Cancelado " , " Su archivo no se Eliminaros :)", "error");
                   	}
                   });

				}

				function eliminar_tiquetTotal(campo1,valor,campo2,valor2,vistas)
				{
					swal({
						title: "Estas seguro?",
						text: "Quiere Eliminar Todos los paquetes de la caja?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Si, Eliminarlos!',
						cancelButtonText: "No, cancelarlo!",
						closeOnConfirm: false,
		                  // closeOnCancel: false
		                 },
		                 function(isConfirm) {
		                 	if (isConfirm) {
		                 		swal({
		                 			title: 'Preseleccion!',
		                 			text: 'Los archivos fueron eliminados correctamente!',
		                 			type: 'success',
		                 			timer: 5,
		                 			showConfirmButton: false
		                 		}, function() {
		      						// form.submit();
		      						window.location ="delete2.php?"+campo1+"="+valor+'&'+campo2+"="+valor2+'&'+'vistas'+"="+vistas;
		      						var nuevacaja = parseFloat(valor2-1);
		      						//redirigir de nuevo
		      						 
		      						window.opener.document.location.reload();
		      						//window.opener.location.reload();
		      						//window.close();
		      					});        

                 	        } else {
		                 		swal("Cancelado " , " Su archivo no se Eliminaros :)", "error");
		                 	}
		             });

		        }


/*function eliminar_sppxc(campo1,id_tnpxc)
{
 
 
	swal({   
	title: "Esta seguro?",   
	text: "Quiere Eliminar el Paquete y sus faltantes?!",   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Si, eliminarlo!",   
	closeOnConfirm: false 
	}, 
	function(){
	  window.location ="delete2.php?"+campo1+"="+id_tn;   
	  swal("Eliminado!", "Sus archivos fueron eliminados.", "success"); 
	  });  
 
 
	}*/
	/*----------------- EXTRUSION------------------*/
//EDIT
function eliminar_rte(id1,valor)
{
/* ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor}
 else if (ventana == false){window.history.go(); } 
*/
swal({   
	title: "Esta seguro?",   
	text: "Quiere Eliminar el Registro?",   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Si, eliminarlo!",   
	closeOnConfirm: false 
}, 
function(){
	window.location ="delete2.php?"+id1+"="+valor  
	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
}); 

}

function eliminar_rte_parcial(id1,valor, parcial, id_rp)
{
/* ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor}
 else if (ventana == false){window.history.go(); } 
*/
swal({   
	title: "Esta seguro?",   
	text: "Quiere Eliminar el Registro?",   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Si, eliminarlo!",   
	closeOnConfirm: false 
}, 
function(){
	window.location ="delete2.php?"+id1+"="+valor+"&parcial="+parcial+"&id_rp_parcial="+id_rp 
	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
}); 

}

//ELIMINA ROLLO GENERAL
function eliminarTiemposDesp(idtiemprollo,columntabla,valorcolumna,idretorno,valoretorno,tabla,paginaext="")
{
 
swal({   
	title: "Esta seguro?",   
	text: "Quiere Eliminar el Registro?",   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Si, eliminarlo!",   
	closeOnConfirm: false 
}, 
function(){
	window.location ="delete2.php?"+idtiemprollo+"="+idtiemprollo+"&columntabla="+columntabla+"&valorcolumna="+valorcolumna+"&idretorno="+idretorno+"&valoretorno="+valoretorno+"&tabla="+tabla+"&paginaext="+paginaext;  
	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
}); 

}

function noEliminar(){

	swal({   
		title: "No se puede Eliminar",   
		text: "Lo puede eliminar con permisos de Super Usuario",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "ok",   
		closeOnConfirm: false 
	}, 
	function(){
		window.history.go(); 
	});  

}


/*-----------------IMPRESION Y SELLADO------------------*/
//EDIT PARCIAL Y TOTAL VARIAS VARIABLES
function eliminar_varias(id1,dato1,id2,dato2,pagina)
{
/* ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete.php?"+id1+"="+dato1+"&"+id2+"="+dato2}
 else if (ventana == false){window.history.go(); 
 } */
 swal({   
 	title: "Esta seguro?",   
 	text: "Quiere Eliminar el Registro?",   
 	type: "warning",   
 	showCancelButton: true,   
 	confirmButtonColor: "#DD6B55",   
 	confirmButtonText: "Si, eliminarlo!",   
 	closeOnConfirm: false 
 }, 
 function(){
 	window.location ="delete.php?"+id1+"="+dato1+"&"+id2+"="+dato2
 	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
 });  
 
}
function eliminar_rts(id1,dato1,id2,dato2)
{
/* ventana=confirm("Quiere Eliminar?");
 if (ventana == true){ window.location ="delete2.php?"+id1+"="+valor}
 	else if (ventana == false){window.history.go(); } */
 swal({   
 	title: "Esta seguro?",   
 	text: "Quiere Eliminar el Registro?",   
 	type: "warning",   
 	showCancelButton: true,   
 	confirmButtonColor: "#DD6B55",   
 	confirmButtonText: "Si, eliminarlo!",   
 	closeOnConfirm: false 
 }, 
 function(){
 	window.location ="delete2.php?"+id1+"="+dato1+"&"+id2+"="+dato2
 	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
 }); 

}



function eliminar_liq(id,campo)
{
	ventana=confirm("Quiere Eliminar Rollo Liquidado?");
	if (ventana == true){ window.location ="delete.php?"+id+"="+campo}
		else if (ventana == false){window.history.go(); } 
}
//PROCESO IMPRESION ELIMINAR Y APDATE DE UNIDADES
function update2() { //v1.0
	msg=confirm("Esta seguro que Quiere Actualizar?");
	if (msg == true){
		document.forms["form2"].submit(); 

		opener.window.location.href += "";
		opener.window.location.reload();  
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
	msg=confirm("Esta seguro que Quiere Eliminar la liquidacion?");
	if (msg == true){
		document.forms["seleccion"].submit(); 
		return true;
	}
	else if (msg == false){window.history.go(); 
		return false;
	} 
}
function eliminar_impresion() { //v1.0 
	msg=confirm("Esta seguro que Quiere Eliminar la liquidacion?");
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
	swal({   
		title: "Guardar Historial?",   
		text: "Esta seguro que Quiere Guardar el Costeo del Inventario!",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Si, guardar!",   
		cancelButtonText: "No, cancelar!",   
		closeOnConfirm: false,   
		closeOnCancel: false }, 
		function(isConfirm){   
			if (isConfirm) {     
				swal("Guardado!", "El archivo a sido guardado.", "success"); 
				document.forms["form2"].action= pag    
				document.forms["form2"].submit() 
			} else {     
				swal("Cancelado", "has cancelado :)", "error");   } });      
/*    msg=confirm("Esta seguro que Quiere Guardar el Costeo del Inventario?");
     if (msg == true){
		document.forms["form2"].action= pag  
		document.forms["form2"].submit()    
        return true;
    }else
    return false;*/
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

/* Delete Flags on Extruder */
function eliminarBandera(bandera,idbandera,columnaTabla, valorcolumna, tabla, id_rollo, vista)
{
 
swal({   
	title: "Esta seguro?",   
	text: "Quiere Eliminar la Bandera?",   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Si, eliminarlo!",   
	closeOnConfirm: false 
}, 
function(){
	window.location ="delete2.php?"+bandera+"="+idbandera+"&"+columnaTabla+"="+valorcolumna+"&tabla="+tabla+"&id_r="+id_rollo+"&vista="+vista;  
	swal("Eliminado!", "Sus registros fueron eliminados.", "success"); 
}); 

}

