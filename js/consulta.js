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
function DatosGestiones(gestion,campo,dato) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else { objeto.onreadystatechange = ResultadoGestiones; 
		if(gestion==1)
			{ objeto.open("GET", "consulta_comercial.php?"+ campo+"="+ dato, true); }
		if(gestion==2) 
			{ objeto.open("GET", "consulta_comercial.php?"+ campo+"="+ dato, true); }
		if(gestion==3)
			{ objeto.open("GET", "consulta_compras.php?"+ campo+"="+ dato, true); }
		if(gestion==4)
			{ objeto.open("GET", "consulta_produccion.php?"+ campo+"="+ dato, true); }
		if(gestion==5)
			{ objeto.open("GET", "consulta_compras_cl.php?"+ campo+"="+ dato, true); }
		if(gestion==6)
			{ objeto.open("GET", "consulta_despacho_oc.php?"+ campo+"="+ dato, true); }
		if(gestion==7)
			{ objeto.open("GET", "consulta_reasig_oc.php?"+ campo+"="+ dato, true); }
		if(gestion==8)
			{ objeto.open("GET", "consulta_reasig_nit.php?"+ campo+"="+ dato, true); }
		if(gestion==9)
			{ objeto.open("GET", "consulta_reasig_nit.php?"+ campo+"="+ dato, true); }
		if(gestion==10)
			{ objeto.open("GET", "consulta_op.php?"+ campo+"="+ dato, true); }
		if(gestion==11)
			{ objeto.open("GET", "consulta_kilos.php?"+ campo+"="+ dato, true); }
		if(gestion==14)
			{ objeto.open("GET", "consulta_op_impresion.php?"+ campo+"="+ dato, true); }
		if(gestion==15)
			{ objeto.open("GET", "consulta_kilos_s.php?"+ campo+"="+ dato, true); } 
		if(gestion==16)
			{ objeto.open("GET", "consulta_op_sellado.php?"+ campo+"="+ dato, true); }
		if(gestion==17)
			{ objeto.open("GET", "consulta_exportacion.php?"+ campo+"="+ dato, true); }
		if(gestion==18) 
			{ objeto.open("GET", "consulta_exportacion.php?"+ campo+"="+ dato, true); }
		if(gestion==19)
			{ objeto.open("GET", "consulta_empleados.php?"+ campo+"="+ dato, true); }
		if(gestion==20)
			{ objeto.open("GET", "consulta_costoreferencia.php?"+ campo+"="+ dato, true); }  
		if(gestion==21)
			{ objeto.open("GET", "consulta_op_refilado.php?"+ campo+"="+ dato, true); }
		if(gestion==22)
			{ objeto.open("GET", "consulta_proveedor.php?"+ campo+"="+ dato, true); } 
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

//-------------------------------GESTIONES VARIOS PARAMETROS------------------

function DatosGestiones3(gestion,campo,dato,campo1,dato1,campo2,dato2,campo3,dato3) {

	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else { 
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoGestionesGeneradores; 
// Enviar la consulta 
if(gestion==1)
	{ objeto.open("GET", "consulta_generadores.php?"+ campo+"="+ dato+ campo1+"="+ dato1+ campo2+"="+ dato2, true);  }
if(gestion==3)
	{ objeto.open("GET", "consulta_ajuste.php?"+ campo+"="+ dato+ campo1+"="+ dato1+ campo2+"="+ dato2, true);  }
if(gestion==4) 
	{ objeto.open("GET", "consulta_exportacion.php?"+ campo+"="+ dato, true); }  
if(gestion==5) 
	{ objeto.open("GET", "consulta_impre_rollos.php?"+ campo+"="+ dato+ campo1, true); }
if(gestion==6) 
	{ objeto.open("GET", "consulta_impre_edit_fecha.php?"+ campo+"="+ dato+ campo1+"="+ dato1, true); } 
if(gestion==7) 
	{ objeto.open("GET", "consulta_general_ajax.php?"+ campo+"="+ dato+ campo1+"="+ dato1+ campo2+"="+ dato2+ campo3+"="+ dato3, true); } 
if(gestion==8)
	{ objeto.open("GET", "inventario_consultacosto.php?"+ campo+"="+ dato+ campo1+"="+ dato1, true); } 
if(gestion==9) 
	{ objeto.open("GET", "consulta_refil_rollos.php?"+ campo+"="+ dato+ campo1+"="+ dato1+ campo2, true); }
if(gestion==10) 
	{ objeto.open("GET", "consulta_refil_edit_fecha.php?"+ campo+"="+ dato+ campo1+"="+ dato1, true); } 
if(gestion==11) 
	{ objeto.open("GET", "consulta_orden_prod.php?"+ campo+"="+ dato+ campo1+"="+ dato1+ campo2+"="+ dato2+ campo3+"="+ dato3, true);  }
if(gestion==12) 
	{ objeto.open("GET", "consulta_registro_sellado_PRUEBA.php?"+ campo+"="+ dato+ campo1, true); } 
if(gestion==13) 
	{ objeto.open("GET", "consulta_extruder_edit_fecha.php?"+ campo+"="+ dato+ campo1+"="+ dato1, true); }   
if(gestion==14) 
	{ objeto.open("GET", "consulta_sellado_edit_fecha.php?"+ campo+"="+ dato+ campo1+"="+ dato1, true); } 

objeto.send(null); } } 
function ResultadoGestionesGeneradores() {     
// Si aun esta revisando los datos...
if (objeto.readyState == 1) { document.getElementById('resultado_generador').innerHTML = "Cargando..."; }  
// objeto.responseText trae el Resultado que metemos al DIV de arriba
if (objeto.readyState == 4) { document.getElementById('resultado_generador').innerHTML = objeto.responseText; }
}
function mostrarFechas() {
//modulo insert
fecha1 = document.getElementById("fecha_ini_nueva");
fecha2 = document.getElementById("fecha_fin_nueva");
boton1 = document.getElementById("boton1");
boton2 = document.getElementById("boton2");
fecha1.style.display = "";
fecha2.style.display = "";
boton2.style.display = "";
//modulo de copia
boton1.style.display = "none";
document.getElementById('fecha_ini_gv').disabled = true;
document.getElementById('fecha_fin_gv').disabled = true;
document.getElementById('id_gv').disabled = true;
document.getElementById('maquina_gv').disabled = true;
document.getElementById('valor_gv').disabled = true;
document.getElementById('boton3').disabled = true;
}
// ------------------------------Definicion REF AC Y REF CLIENTE-----------
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
//---------------ref ac y rec add
function DefinicionRef(int_ref_ac_rc) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoDefinicion;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta.php?int_ref_ac_rc=" + int_ref_ac_rc, true);
objeto.send(null);
}
}
// -----CARGANDO VERSION REF
function ResultadoDefinicion() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
	document.getElementById('definicion').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion').innerHTML = objeto.responseText;
}
} 

// -----CARGANDO2 VERSION REF
function DefinicionRef2(int_ref_ac_rc2) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoDefinicion2;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta2.php?int_ref_ac_rc2=" + int_ref_ac_rc2, true);
objeto.send(null);
}
}
function ResultadoDefinicion2() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
	document.getElementById('definicion2').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion2').innerHTML = objeto.responseText;
}
}
// -----CARGANDO3 VERSION REF
function DefinicionRef3(int_ref_ac_rc3) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoDefinicion3;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta3.php?int_ref_ac_rc3=" + int_ref_ac_rc3, true);
objeto.send(null);
}
}
function ResultadoDefinicion3() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
	document.getElementById('definicion3').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion3').innerHTML = objeto.responseText;
}
}
// -------FIN---REF

//---------------ref ac y rec nit add
function DefinicionCliente(id_c_rc) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoNit;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta4.php?id_c_rc=" + id_c_rc, true);
objeto.send(null);
}
}
// -----CARGANDO CLIENTE NIT
function ResultadoNit() { 
// Si aun esta revisando los datos... 
if (objeto.readyState == 1) {
	document.getElementById('nit').innerHTML = "";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('nit').innerHTML = objeto.responseText;
}
} 
// -----NIT2 
function DefinicionCliente2(id_c_rc2) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoNit2;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta5.php?id_c_rc2=" + id_c_rc2, true);
objeto.send(null);
}
}
// -----CARGANDO CLIENTE NIT 2
function ResultadoNit2() { 
// Si aun esta revisando los datos... 
if (objeto.readyState == 1) {
	document.getElementById('nit2').innerHTML = "";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('nit2').innerHTML = objeto.responseText;
}
}
// -----NIT2
function DefinicionCliente3(id_c_rc3) {
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoNit3;
// Enviar la consulta
objeto.open("GET", "ref_ac_ref_cl_consulta6.php?id_c_rc3=" + id_c_rc3, true);
objeto.send(null);
}
}
// -----CARGANDO CLIENTE NIT 3
function ResultadoNit3() { 
// Si aun esta revisando los datos... 
if (objeto.readyState == 1) {
	document.getElementById('nit3').innerHTML = "";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('nit3').innerHTML = objeto.responseText;
}
}
// ------------FIN NIT 
/*----------------------Dos campos - Dos datos -extra---------------------*/
function DatosDos(campo1,dato1,campo2,dato2) {
	crearObjeto();
	if (objeto.readyState != 0) 
		{ alert('Error al crear el objeto XML. El Navegador no soporta AJAX'); } 
	else {
		objeto.onreadystatechange = ResultadoDos;
		objeto.open("GET", "consulta_dos.php?"+ campo1+"="+ dato1+"&"+campo2+"="+dato2, true);
		objeto.send(null);
	}
}
function ResultadoDos() { 
	if (objeto.readyState == 1) {
		document.getElementById('resultado2').innerHTML = "Cargando..."; }
		if (objeto.readyState == 4) {
			document.getElementById('resultado2').innerHTML = objeto.responseText; } 
		}
		/*----------------------Tres campos - Tres datos ----------------------*/
		function DatosTres(campo1,dato1,campo2,dato2,campo3,dato3) {
			crearObjeto();
			if (objeto.readyState != 0) 
				{ alert('Error al crear el objeto XML. El Navegador no soporta AJAX'); } 
			else {
				objeto.onreadystatechange = ResultadoTres;
				objeto.open("GET", "consulta_tres.php?"+ campo1+"="+ dato1+"&"+campo2+"="+dato2+"&"+campo3+"="+dato3, true);
				objeto.send(null);
			}
		}
		function ResultadoTres() { 
			if (objeto.readyState == 1) {
				document.getElementById('resultado3').innerHTML = "Cargando..."; }
				if (objeto.readyState == 4) {
					document.getElementById('resultado3').innerHTML = objeto.responseText; } 
				}
				/*------------------------------------------------------------------------*/
				/*----------------------ADJUNTAR ARCHIVOS---------------------------------*/
				function adjunto(archivo)
				{
					window.opener.document.form1.userfile.value = archivo;
					
					window.opener.document.all.adjuntado.innerHTML = "<a href='"+archivo+"'>"+archivo+"</a>";
//	window.opener.document.getElementById('adjuntado').innerHTML = "<a href='"+archivo+"'>"+archivo+"</a>";
}
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*----------------------ADJUNTAR ARCHIVOS opcion2-------------------------*/
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
//=========================INSUMO FICHA TECNICA===========================//
function fichatecnicaref(aditivo_ft) {  
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoFicha;
// Enviar la consulta
objeto.open("GET", "fichaTecnica_consulta.php?ref=" + aditivo_ft, true);
objeto.send(null);
}
}
// -----CARGANDO REF
function ResultadoFicha() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
	document.getElementById('definicionficha').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicionficha').innerHTML = objeto.responseText;
}
} 
/*---------------GESTION COMERCIAL----------------------------------------*/
/*CLIENTE*/
function consultacliente()
{ window.location ='cotizacion_bolsa_edit.php?n_cotiz='+document.form1.n_cotiz.value+'&id_c_cotiz='+document.form1.id_c_cotiz.value; }
/*EGP*/
function consultaegp()
{window.location ='cotizacion_bolsa_nueva.php?n_cotiz='+document.form1.n_cotiz.value+'&n_egp='+document.form1.egp.value; }
/*INDICATIVO CIUDAD*/
function consulIndicativo()
{window.location ='perfil_cliente_add2.php?n_egp='+document.form1.egp.value; }
/*CAMBIAR EL NUMERO DE EGP*/
function consultaegp2()
{ con=confirm("�En realidad desea cambiar de N� de EGP?");
if(con){ window.location ='cotizacion_bolsa_nueva_edit.php?n_cn='+document.form1.n_cn.value+'&n_cotiz='+document.form1.n_cotiz.value+'&n_egp='+document.form1.n_egp1.value; }
else{ window.location ='cotizacion_bolsa_nueva_edit.php?n_cn='+document.form1.n_cn.value+'&n_cotiz='+document.form1.n_cotiz.value+'&n_egp='+document.form1.n_egp.value; }
}
function consultaegp3()
{
	alert('Debe Seleccionar un N� de EGP para cambiarlo'); 
	window.location ='cotizacion_bolsa_nueva_edit.php?n_cn='+document.form1.n_cn.value+'&n_cotiz='+document.form1.n_cotiz.value+'&n_egp='+document.form1.n_egp_cn1.value;
}
/*------------PRODUCCION CALCULA BOLSILLO-----------*/

/*COTIZACION NUEVA CALCULAR*/
function calcular()
{
	$var1=document.form2.largo_cn.value;
	$var2=document.form2.solapa_cn.value;
	$var3=parseInt($var1);
	$var4=parseInt($var2);
	$var5=document.form2.ancho_cn.value*(($var3+$var4))*document.form2.calibre_cn.value*0.00467;
	$var5=parseFloat($var5);
	$var5=Math.round($var5*100)/100;
	document.form2.peso_millar_cn.value=$var5;
}
/*EGL-CALCULAR*/
function calcular_egl()
{
	$peso=(24*(parseFloat(document.form1.calibre_egl.value)));	
	document.form1.peso_egl.value=Math.round($peso*100)/100;
}
/*-------------------ORDEN PRODUCCION CALCULAR-------------------------*/
/*function calcular_pesomOP() 
{
//VARIABLES
    var ancho=document.form1.ancho.value
	var largo=parseFloat(document.form1.largo.value);
	var fuelle=parseFloat(document.form1.fuelle.value);
	var v_solapa=parseInt(document.form1.valor_s.value);
	var solapa=parseFloat(document.form1.solapa.value);
	var dsolapa=(solapa/v_solapa)
    var calibre=parseFloat(document.form1.int_calibre_op.value);
    var cons=parseFloat(0.00467);
//OPERACIONES FORMULA
var subm=ancho*(largo+fuelle+dsolapa)*calibre*cons;
var millar_t=subm.toFixed(2);
document.form1.int_pesom_op.value=millar_t;// millar para o.p sin bolsillo en extruder
}*/



function calcular_op()
{
	var tipo_lamina=document.form1.str_tipo_bolsa_op.value;
	//si es bolsa o lamina
	if(tipo_lamina!='LAMINA'){
		
		$peso=(25.4*(parseFloat(document.form1.int_calibre_op.value)));	
		document.form1.int_micras_op.value= $peso.toFixed(2);	 
		
		$cantpeso=((parseFloat(document.form1.int_cantidad_op.value))*(parseFloat(document.form1.int_pesom_op.value))/1000);	
		$cant=parseFloat($cantpeso);
		$porcen=parseFloat(document.form1.int_desperdicio_op.value);
		$porc=Math.round($cant*$porcen)/100;
		$total=$cant+$porc;
		$kiloRequerido=parseFloat($total);
		document.form1.int_kilos_op.value=Math.round($kiloRequerido*100)/100;
		
	//ancho del rollo
	var largo=parseFloat(document.form1.largo.value);
	var solapa=parseFloat(document.form1.solapa.value);
	var v_solapa= parseInt(document.form1.valor_s.value);
	var fuell=parseFloat(document.form1.fuelle.value);
	var fuelle=(fuell*2); 
	var pres=document.form1.str_presentacion_op.value;//presentacion
	//SI ES PRESENTACION LAMINA
	if (pres=='LAMINA' && tipo_lamina!='LAMINA'){
		
		if(v_solapa=='1'){
			var v_sol='2';
	  var dsolapa=(solapa*v_sol)//para ancho de rollo se multiplica
	  var aRext=((largo*2)+dsolapa+fuelle);
	  document.form1.int_ancho_rollo_op.value=aRext;
	}else
	if(v_solapa=='2'){
		var v_sol='1';
	  var dsolapa=(solapa*v_sol)//para ancho de rollo se multiplica
	  var aRext=((largo*2)+dsolapa+fuelle);
	  document.form1.int_ancho_rollo_op.value=aRext;
	}else
	if(v_solapa=='0'){
		var v_sol='0';
	  var dsolapa=(solapa*v_sol)//para ancho de rollo se multiplica
	  var aRext=((largo*2)+dsolapa+fuelle);
	  document.form1.int_ancho_rollo_op.value=aRext;
	}
}else {
	var aRext=(largo+solapa+fuelle); 	
	document.form1.int_ancho_rollo_op.value=aRext;
}
	//sellado metros cinta y metros lineales
	//operaciones
	var metrosCinta=((document.form1.ancho.value*document.form1.int_cantidad_op.value)/100);
	//100 porque es pasarlo a centimetros
	var metrosCint=metrosCinta.toFixed(2);

	var BolsaConPorcent=Math.round(($kiloRequerido*1000)/document.form1.int_pesom_op.value);
	//EXTRUDER LINEAL
	var metroslinealExtruder=((document.form1.ancho.value*BolsaConPorcent)/100);	
	
	//impresiones en campos
	document.form1.metroLineal_op.value=metroslinealExtruder.toFixed(2);
	document.form1.mts_cinta_sellado_op.value=Math.round(metrosCint*100)/100;
	document.form1.kls_req_imp_op.value=Math.round($kiloRequerido*100)/100;
	document.form1.kls_sellado_op.value=Math.round($kiloRequerido*100)/100;	 
	document.form1.mts_req_imp_op.value=Math.round(metrosCint);


	}else{//FIN SI ES DIFERENTE DE LAMINA
    //CUANDO ES LAMINA	
    var kilos_op=parseFloat(document.form1.int_cantidad_op.value)
    var porcen_op=parseFloat(document.form1.int_desperdicio_op.value);
    var pesom_op=parseFloat(document.form1.int_pesom_op.value);
    var porc_op=Math.round(kilos_op*porcen_op)/100;	
    var total=kilos_op+porc_op;
    var kiloRequerido_op=parseFloat(total);
    document.form1.kls_req_imp_op.value=Math.round(kiloRequerido_op*100)/100;
    document.form1.int_kilos_op.value=Math.round(kiloRequerido_op*100)/100;
 	document.getElementById('int_micras_op').hidden = true;//dejo invisible el campo micras
	//impresiones en campos
	var bolsasT=((kiloRequerido_op * 1000) / pesom_op);
	var metrosT=(bolsasT * document.form1.ancho.value)/100;
	document.form1.mts_req_imp_op.value=Math.round(metrosT);
	document.form1.metroLineal_op.value=Math.round(metrosT);
	document.form1.mts_cinta_sellado_op.value=Math.round(metrosT);	
	document.form1.kls_req_imp_op.value=Math.round(kiloRequerido_op*100)/100;
	document.form1.kls_sellado_op.value=Math.round(kiloRequerido_op*100)/100;
	document.form1.und_prod_sellado_op.value=Math.round(bolsasT);	 

}

}//FIN


function anchodelRollo(){

   
   var present = parseFloat($('#Str_presentacion').val())*parseInt(2); 
   /*var tipo = $('#tipo_bolsa_ref').val()*/
   
   if(present=="LAMINA"){
   	   var largo = parseFloat($('#largo_ref').val())*parseInt(2);
       var fuelle = parseFloat($('#B_fuelle').val())*parseInt(2); 
   }else{
   	   var largo = parseFloat($('#largo_ref').val());
   	   var fuelle = parseFloat($('#B_fuelle').val())*parseInt(2); 
   }

   var solapdoble = $('input:radio[name=valora]:checked').val(); 
   if(solapdoble==2){
      var solapa = parseFloat($('#solapa_ref').val()) ; 
   }else if(solapdoble==1){
    var solapa = parseFloat($('#solapa_ref').val()) * parseInt(solapdoble) ;
   }else{
     solapa=0;
   }
   anchoRollo = (largo+fuelle+solapa);
   anchoRollo=anchoRollo.toFixed(2)
   $('#ancho_rollo').val(anchoRollo);


}

function ResteFecha() { 
	f0= document.form1.fecha_ini_rp.value;
	f1= document.form1.fecha_fin_rp.value;
	var datePat = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;

	var fecha0 = f0;
	var matchArray0 = fecha0.match(datePat); 
	day0 = matchArray0[5];
	month0 = matchArray0[3];
	year0 = matchArray0[1]; 


	var fecha1 = f1;
	var matchArray1 = fecha1.match(datePat);
	day1 = matchArray1[5];
	month1 = matchArray1[3]; 
	year1 = matchArray1[1];

	var fechaIni = new Date();
	fechaIni.setFullYear(year0, month0, day0)


	var fechaFin = new Date();
	fechaFin.setFullYear(year1, month1, day1)

	var rest = fechaFin - fechaIni
	resta=(rest/(1000*24*60*60));
	var por24=resta*parseInt(24);
//resta = resta/86400000

document.form1.prueba.value=(por24);
return(resta);

} 
function calcularHora(){

	horatotale=new Array(0,0,0);
	for(b=0;b<arguments.length-1;b++){
		horas=obj(arguments[b]).value.split(":");

		for(a=0;a<3;a++){
			horas[a]=(isNaN(parseInt(horas[a])))?0:parseInt(horas[a])
			horatotale[a]=(b==0)?horas[a]:horatotale[a]-horas[a]; // Suma o resta seg�n prefieras

		}
	}

	horatotal=new Date()
	horatotal.setHours(horatotale[0]);
	horatotal.setMinutes(horatotale[1]);
	horatotal.setSeconds(horatotale[2]);

	obj(arguments[2]).value=horatotal.getHours()+":"+horatotal.getMinutes()+":"+horatotal.getSeconds();
	document.form1.prueba2.value=(por24);
}

//calcular horas de registro extrusion
function restarFechas() { 
	var datePat = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;

	
	var fecha0 = document.form1.fecha_ini_rp.value;
	var matchArray0 = fecha0.match(datePat); 
	day0 = matchArray0[5];
	month0 = matchArray0[3];
	year0 = matchArray0[1]; 

	var fecha1 = document.form1.fecha_fin_rp.value;
	var matchArray1 = fecha1.match(datePat); 
	day1 = matchArray1[5];
	month1 = matchArray1[3]; 
	year1 = matchArray1[1];

	var fechaIni = new Date();
	fechaIni.setFullYear(year0, month0, day0)

	var fechaFin = new Date();
	fechaFin.setFullYear(year1, month1, day1)
	
	var rest = fechaFin - fechaIni;
	var restaHoras = (rest/(1000*60*60));
	var dias = (rest/(1000*24*60*60)); 
	
//return(resta);
//calcula restaHoras inicio y final
var v1 = document.form1.hora_ini_rp.value;
var v2 = document.form1.hora_fin_rp.value;

horas1=v1.split(":"); /*Mediante la funci�n split separamos el string por ":" y lo convertimos en array. */ 
horas2=v2.split(":");
horatotale=new Array();
if((horas2>horas1)){
	for(a=0;a<3;a++) /*bucle para tratar la hora, los minutos y los segundos*/
	{
		horas1[a]=(isNaN(parseInt(horas1[a])))?0:parseInt(horas1[a]) /*si horas1[a] es NaN lo convertimos a 0, sino convertimos el valor en entero*/
		horas2[a]=(isNaN(parseInt(horas2[a])))?0:parseInt(horas2[a])
		horatotale[a]=(horas2[a]-horas1[a]);/* insertamos la resta dentro del array horatotale[a].*/

		horatotal=new Date()  /*Instanciamos horatotal con la clase Date de javascript para manipular las horas*/
		horatotal.setHours(horatotale[0]); /* En horatotal insertamos las horas, minutos y segundos calculados en el bucle*/ 
		horatotal.setMinutes(horatotale[1]);
		horatotal.setSeconds(horatotale[2]);

		var horast=horatotal.getHours()+":"+horatotal.getMinutes()+":"+
		horatotal.getSeconds();
		document.form1.horas_rp.value=(horast);
		/*formula para el total de horas utilizadas*/
var subt=restaHoras+horatotal.getHours();//define las horas total
var totalhorasextruidas=subt+":"+horatotal.getMinutes()+":"+horatotal.getSeconds();
document.form1.total_horas_rp.value=(totalhorasextruidas);
}	
}else {

	for(a=0;a<3;a++) /*bucle para tratar la hora, los minutos y los segundos*/
	{
		horas1[a]=(isNaN(parseInt(horas1[a])))?0:parseInt(horas1[a]) /*si horas1[a] es NaN lo convertimos a 0, sino convertimos el valor en entero*/
		horas2[a]=(isNaN(parseInt(horas2[a])))?0:parseInt(horas2[a])
		horatotale[a]=(horas1[a]-horas2[a]);/* insertamos la resta dentro del array horatotale[a].*/

		horatotal=new Date()  /*Instanciamos horatotal con la clase Date de javascript para manipular las horas*/
		horatotal.setHours(horatotale[0]); /* En horatotal insertamos las horas, minutos y segundos calculados en el bucle*/ 
		horatotal.setMinutes(horatotale[1]);
		horatotal.setSeconds(horatotale[2]);


		var horast=horatotal.getHours()+":"+horatotal.getMinutes()+":"+
		horatotal.getSeconds();
		document.form1.horas_rp.value=(horast);
		/*formula para el total de horas utilizadas*/
var subt=restaHoras-horatotal.getHours();//define las horas total
var totalhorasextruidas=subt+":"+horatotal.getMinutes()+":"+horatotal.getSeconds();
document.form1.total_horas_rp.value=(totalhorasextruidas);



}		
}
 //calcular kilos x hora
 var kilos_p=parseFloat(document.form1.int_kilos_prod_rp.value);  
 var kilos_d=parseFloat(document.form1.int_kilos_desp_rp.value);
 var t_k=kilos_p+kilos_d;
 var t_kilos=t_k.toFixed(2);
 var horas=(document.form1.total_horas_rp.value);
var horas1 = horas.split(":"); // hora se divide = ["24", "06"]
//horatotale=new Array();

var hora=horas1[0];
var minuto=horas1[1]/60;
Totalh = parseInt(hora) + parseFloat(minuto);
var subt=(kilos_p/Totalh);
var total=subt.toFixed(2);
document.form1.int_kilosxhora_rp.value=(total);

//IMPRESION HORAS A MINUTOS
var mL=document.form1.int_metro_lineal_rp.value;
var Minutos=horatotal.getMinutes();
var horaM=(subt*60);
var tHoraM=(horaM+Minutos);
var metroL=mL/tHoraM;
var metroLineal=metroL.toFixed(2);
document.form1.int_metroxmin_rp.value=(metroLineal);
//FIN
}



/*function tipoDesperdicio(){
      var totalTM = 0; 
      var ups = document.getElementsByName('id_rpd[]'), sum = 0, i;
	  var valor = document.getElementsByName('valor_desp_rd[]'), sum = 0, x;
    for(i = ups.length; i--;){
        if(ups[i].value=='54') {
			totalTM=ups[i].value;
			alert(totalTM);
			//for(x = valor.length; x--;){
            //totalTM=valor[x].value;
 			//alert(totalTM);
			//}
  	}else{
		alert('no es')
	  }
	}
}*/
//KILOS POR HORA
function kilosxHora()
{
 //CALCULAR HORAS TRABAJADAS
 var kilos_p=parseFloat(document.form1.int_kilos_prod_rp.value);  
 var kilos_d=parseFloat(document.form1.int_kilos_desp_rp.value);
 var t_k=parseFloat(kilos_p)+parseFloat(kilos_d);
 var t_kilos=t_k.toFixed(2);

var horas=(document.form1.total_horas_rp.value);//fecha inicial - fecha final
var horas1 = horas.split(":"); // hora se divide = ["24", "06"]  sepaaaro las horas de los minutos
//CALCULAR KILOS X HORA
var kilos_r=parseFloat(document.form1.int_kilos_prod_rp.value);   
var hora=horas1[0]; 
//paso los minutos equivalentes en porcentaje a horas
var minuto=(horas1[1]/60); 
var Minuts=minuto.toFixed(2);//maximo dos decimales
var Totalh =(parseInt(hora) + parseFloat(Minuts));//sumo horas y minutos en porcentaje
var restaT=(parseFloat(kilos_r) / parseFloat(Totalh));
var KiloxH=restaT.toFixed(2);//maximo dos decimales
document.form1.int_kilosxhora_rp.value=(KiloxH);  
//FIN
}

 //TIEMPOS EN IMPRESION Y SELLADO
 function restakilosT(){
 	var totalTM = 0;
 	var totalTP = 0;
 
  
 	var ups = document.getElementsByName('valor_tiem_rt[]'), sum = 0, i;
 	var id = document.getElementsByName('id_rpt[]'), i;
 	for(i = ups.length; i--;){
 		if(ups[i].value)
 			sum += parseFloat(ups[i].value, 10);
 		totalTM=sum.toFixed(2);
   	} //cierra for
   	var ups2 = document.getElementsByName('valor_prep_rtp[]'), sum2 = 0, x;
   	var id2 = document.getElementsByName('id_rtp[]'), x;
   	for(x = ups2.length; x--;){
   		if(ups2[x].value)
   			sum2 += parseFloat(ups2[x].value, 10);
   		totalTP=sum2.toFixed(2); 
  	} //for
 
   
    document.getElementById("horasmuertas").value= totalTM;//horas muertas
 
	document.getElementById("horasprep").value=totalTP;//horas preparacion
	kilosxHora2();//anidado causa el efecto en tiempo optimo
	
}	 
//EXTRUSION Y TIEMPOS EN IMPRESION Y SELLADO
function kilosxHora2()
{

		 //RESTA FECHAS
		 if(document.getElementById("id_proceso_rp").value =='4') {
		 	var kilos_r = document.getElementById("int_total_kilos_rp").value;
		 }else{
		 	var kilos_r = (document.getElementById("int_kilos_prod_rp").value);
		 }
		//var kilos_r = (document.getElementById("int_kilos_prod_rp").value);  
		var metrosL = document.getElementById("metro_r").value; 
		var fecha1 = new Date(document.getElementById("fecha_ini_rp").value);
		var fecha2 = new Date(document.getElementById("fecha_fin_rp").value); 
		
		var DespTm = parseInt(document.getElementById("horasmuertas").value);
		var DespTp = parseInt(document.getElementById("horasprep").value);  
	 
		var horas = ((fecha2-fecha1)/3600000);/*<!--hora en terminos de decimal-->*/
		var TiempOptimo = (horas*60);//hora a minuto termino minutos PARA impresion y sellado
		//los tiempos muertos y standby termino minutos
		var TotTiemKilxH=(DespTm);	 
 		//todos los tiempos para rodamiento termino de minutos
 		var TotalTiempoRod=(DespTm); 
         
 			//para el campo optimo y total horas en extruder edit
			//traigo total_horas_rp de extruder porq es el tiempo exacto
			if(document.getElementById("id_proceso_rp").value =='1') {
				   
				    //TIEMPO NORMAL DE FECHA A FECHA
				    var horas2 = document.getElementById("horas_real").value;
				    var horasDivide = horas2.split(":");
				    var horaNueva = horasDivide[0];
				    var minutNueva = parseFloat(horasDivide[1]);
				    var minutNueva = parseFloat(minutNueva/60); 
				    var horaDec = parseFloat(horaNueva)+parseFloat(minutNueva);
                                 
				     	 var kilos_r = (document.getElementById("int_kilos_prod_rp").value);
				     	 var horas_real = new String(horaDec);//hora entermino de decimales  
    				 
    				//Tiempo Optimo 
    				var horas_optimo = parseFloat(horas_real - parseFloat(TotTiemKilxH/60));//tiempo Optimo entermino de decimales 
                    var horas_optimo = new String(horas_optimo);
    			    var elem = horas_optimo.split(".");
    			    var H_Trab = parseInt(elem[0]*60);//horas en terminos de minutos
    			    var minu =  parseFloat('0.'+elem[1] );//minutos en terminos de hora Math.floor((elem[1]%3600)/60)
    			    var M_Trab =  parseInt(minu * 60 );//minutos en terminos de minutos normales
     		  
        		var Optimo_H_Trab =  parseInt(elem[0]) ; 
				var Optimo_M_Trab = M_Trab<10 ? "0"+M_Trab : M_Trab;  

        		var horas_real_fin = Optimo_H_Trab + ":" + Optimo_M_Trab + ":" + '00'; 

        		document.getElementById("horas_real").value = horaNueva + ":" + horasDivide[1] + ":" + '00';//Total Horas Trabajadas x fechas
        		//document.getElementById("Optimo_rp").value= horas_real_fin;// otal fechas sin T. muertos
        		document.getElementById("tiempoOptimo_rp").value= horas_real_fin;// otal fechas sin T. muertos
  
        		var KilosxtHoraT = parseFloat(kilos_r) / parseFloat(horas_optimo);//int_kilosxhora_rp 
        		var KilosxtHoraT = KilosxtHoraT.toFixed(2);
        		document.getElementById("int_kilosxhora_rp").value = KilosxtHoraT;

			}else {//FIN IF DE EXTRUDER
                 
       			//TIEMPO NORMAL DE FECHA A FECHA PARA CAMPO TOTAL HORAS 
    			var MintTH = (TiempOptimo); //tiempo real en minutos
    			var secTH = (MintTH*60);//con descuento tiempo convierto a segundos
    			var hrsTH = Math.floor(secTH/3600);
    			var minuTH = Math.floor((secTH%3600)/60); 
    			secTH = secTH % 60;
                
                var secTH = secTH<10 ? "0" + secTH : secTH;
    			var minuTH = minuTH<10 ? "0" + minuTH : minuTH; 
    		 
    			var tiempoOPTH = hrsTH + ":" + minuTH; 
    			document.getElementById("total_horas_rp").value = tiempoOPTH;
    			 
       			//TIEMPO NORMAL DE FECHA A FECHA SIN T. MUERTOS
      			var MintKH = (TiempOptimo - TotTiemKilxH); //tiempo real en minutos sin T. Muertos
        		var secKH = (MintKH*60);//con descuento T. Muertos convierto a segundos
        		var hrsKH = Math.floor(secKH/3600);
        		var minuKH = Math.floor((secKH%3600)/60);
        		
        		secKH = secKH % 60;
        		var secKH = secKH<10 && secKH>0 ? "0" + secKH : secKH;
                var minuKH = minuKH<10 && minuKH>0 ? "0" + minuKH : minuKH;  
        		var tiempoOPKH = hrsKH + ":" + minuKH;
        		//var minuto=parseFloat(minuKH/60);// minutos en terminos de hora  
        		//var KilosxtH=((parseFloat(kilos_r)/parseFloat(hrsKH+minuto)));

        		var TiemposinTM = parseFloat(MintKH/60);//Tiempo con descuento de T. Muertos en terminos de Hora sino es este (TTMint/60)
        		var minuto=parseFloat(TiemposinTM);//minutos en terminos de hora 
        		var KilosxtH = parseFloat(kilos_r) / parseFloat(minuto);//int_kilosxhora_rp

        		var KilosxtHora = KilosxtH.toFixed(2); 
        		//fin kilos *hora
        		if(MintKH<=0)
        		{ 
        			KilosxtHora=0;
        		}
        		document.getElementById("int_kilosxhora_rp").value = (KilosxtHora);
        		
                //PARA CAMPO RODAMIENTO
    			//FORMATEO A TIME 00:00
     		    var MinRO = (TiempOptimo - TotalTiempoRod); //resto tiempos Muertos  
    		 
    			var secRO = (MinRO*60);//con descuento tiempo convierto la hora a segundos
    			var hrsRO = Math.floor(secRO/3600);
    			var minuRO = Math.floor((secRO%3600)/60); 
    			secRO = secRO % 60;

    			var secRO = secRO<10 && secRO>0 ? "0" + secRO : secRO;
                var minuRO = minuRO<10 && minuRO>0 ? "0" + minuRO : minuRO;
    			 
    		 
    			var tiempoOPRO = hrsRO + ":" + minuRO; 

    			var minutoR=parseFloat(minuRO/60); /*minutos en terminos de hora */
    			var tiempoOPROperar = parseFloat(hrsRO+minutoR); 
    		 
         		document.getElementById("tiempoOptimo_rp").value=tiempoOPRO;//rodamiento optimo 			
         		
         		
         		
               var metros2=parseFloat(document.getElementById("metro_r2").value); //total rango de metros
               var metroxminuto= metros2/(tiempoOPROperar); /*<!--metros dividido minuto optimos de rodamiento-->*/
               
               document.getElementById("metroxmin").value = metroxminuto.toFixed(2);
           
       }
//FIN 

}
 //sellado
 function kilosxHora3(){ 
			 //RESTA FECHAS 
			 
			 var metrosL = document.getElementById("metro_r").value;
			 var fecha1 = new Date(document.getElementById("fecha_ini_rp").value);
			 var fecha2 = new Date(document.getElementById("fecha_fin_rp").value); 
			 var kilos_r = (document.getElementById("int_kilos_prod_rp").value);
			 var Desp = document.getElementById("int_kilos_desp_rp").value;
			 var DespStand=document.getElementById("standby").value; 
		/*	var DespTm = document.getElementById("valor_tiem_rt").value;
		var DespTp = document.getElementById("valor_prep_rt").value; */
		var DespTm = document.getElementById("horasmuertas").value;
		var DespTp = document.getElementById("horasprep").value; 			
		var horas = ((fecha2-fecha1)/3600000);/*<!--hora total en terminos de decimal-->*/
     			//REGLA DE TRES PARA NUEVOS METROS
			//SOLAMENTE PARA LOS NUEVOS METROS LINEALES SIN EL DESPERDICIO	
/* 			var kiloRestante=parseFloat(kilos_r)-parseFloat(Desp);	
 			var nuevosMetros = Math.round(kiloRestante * metrosL / kilos_r);
 			document.getElementById("metro_r").value = nuevosMetros;*/
 			
 			var TiempOptimo = (horas*60);//hora a minuto termino minutos
 			//solamente standby termino decimal
 			var TotTiemStand=parseFloat(DespStand); 
			//todos los tiempos para rodamiento termino de minutos
			var TotalTiempoRod=(parseFloat(DespTm) + parseFloat(DespStand));
		    //los tiempos muertos y standby termino minutos
		    var TotTiemKilxH=(parseFloat(DespTm) + parseFloat(DespStand));
 		//VALIDO SI TIENE TIEMPOS STANDBY
   			//PARA CAMPO TOTAL HORAS
			//FORMATEO A TIME 00:00
			var MintTH = (TiempOptimo - TotTiemStand); //tiempo real en minutos
			var secTH = (MintTH*60);//con descuento tiempo convierto a segundos
			var hrsTH = Math.floor(secTH/3600);
			var minuTH = Math.floor((secTH%3600)/60); 
			secTH = secTH % 60;
			if(secTH<10) secTH = "0" + secTH;   
			if(minuTH<10) minuTH = "0" + minuTH; 
			var tiempoOPTH = hrsTH + ":" + minuTH; 
			document.getElementById("total_horas_rp").value = tiempoOPTH;
  			///PARA CAMPO KILOS X HORA
			//FORMATEO A TIME 00:00 
			var MintKH = (TiempOptimo - TotTiemKilxH); //tiempo real en minutos
 			var secKH = (MintKH*60);//con descuento tiempo convierto a segundos
 			var hrsKH = Math.floor(secKH/3600);
 			var minuKH = Math.floor((secKH%3600)/60);
 			if(secKH<10) secKH = "0" + secKH;   
 			if(minuKH<10) minuKH = "0" + minuKH; 
 			var tiempoOPKH = hrsKH + ":" + minuKH; 
 			var minuto=parseFloat(minuKH/60);/*<!--minutos en terminos de hora-->*/
 			KilosxtH=(parseFloat(kilos_r)/parseFloat(hrsKH+minuto)); 
 			KilosxtHora = KilosxtH.toFixed(2);  
 			document.getElementById("int_kilosxhora_rp").value = KilosxtHora;			
            //PARA CAMPO RODAMIENTO
			//FORMATEO A TIME 00:00
 			var MinRO = (TiempOptimo - TotalTiempoRod); //resto tiempos preparacion 
			var secRO = (MinRO*60);//con descuento tiempo convierto la hora a segundos
			var hrsRO = Math.floor(secRO/3600);
			var minuRO = Math.floor((secRO%3600)/60); 
			secRO = secRO % 60;
			if(secRO<10) secRO = "0" + secRO;   
			if(minuRO<10) minuRO = "0" + minuRO; 
			var tiempoOPRO = hrsRO + ":" + minuRO; 
   			document.getElementById("rodamiento_rp").value=tiempoOPRO;//rodamiento optimo 
   			
   		}
   		function mlxHora()
   		{
             //Metros x Minutos impresion horas a minutos
             var horas=(document.form1.total_horas_rp.value);
             var horasML = horas.split(":"); // hora se divide = ["24", "06"] 
             var mL=document.form1.int_metro_lineal_rp.value;
             var minML=horasML[0]*60;  //PASO A MINUTOS LAS HORAS DE RESTAS DE FECHAS
             var minutML=horasML[1];//obtengo los minutos del array split de la resta de fechas
             var tHoraM=(parseInt(minML)+parseInt(minutML));//total en minutos resta de las fechas             

             //TIEMPOS DESPERDICIO
             var sumaT=(document.form1.sumaTiempos.value);//suma de tiempos muertos y preparacion en minutos
             var restaT=(parseInt(tHoraM) - parseInt(sumaT));//resta al total de las fechas la suma de desperdicion y muertos 
             //divido metros lineales con el tiempo total gastado de fechas
             var submetroL = (parseInt(tHoraM) - parseInt(restaT));//pendiente no es necesario             

             var metroL=(parseInt(mL) / parseInt(restaT)); 
             var metroLineal=metroL.toFixed(2);//maximo dos decimales             

             document.form1.int_metroxmin_rp.value=(metroLineal);             

             //PARA MOSTRAR FORMATO HORA EN TIEMPO OPTIMO
             var sec = restaT*60;//convierto a segundos
             var hrs = Math.floor(sec/3600);
             var min = Math.floor((sec%3600)/60);
             sec = sec % 60;
             if(sec<10) sec = "0" + sec;
             if(min<10) min = "0" + min;
             var tiempoOP = hrs + ":" + min + ":" + sec;
             document.form1.tiempoOptimo_rp.value=tiempoOP;
             //FIN
        }

function fechasDesp(){
	var fechaE = new Date(document.getElementById("fechaExt").value); 
	var fechaI = new Date(document.getElementById("fecha_ini_rp").value); 
	fechaExt=(fechaE.getMonth() +1); //extraer mes
	fechaImp=(fechaI.getMonth() +1); //extraer mes
	var dentroMes=fechaImp-fechaExt; //si es cero esta dentro del mes
         if(ups[x].value==54 && dentroMes==0){//54 es desp extruder 
         	alert("dentro del mes");	
         }else{alert("fuera")}
         
     }
 //IMPRESION, SELLADO DESPERDICIOS Y TIEMPOS
 function restakilosD(){
	 //evaluo que sea sellado porq es el unico con reproceso
	 if(document.getElementById("id_proceso_rp").value =='4'){
	 	var reproceso=parseFloat(document.getElementById("reproceso").value);
	 }else{reproceso='0';}
	//valor_desp_rd[] aqui viene el total acumulado y lo que ingresa de desperdicio
	//var desOper = parseFloat(document.getElementById("int_kilos_desp_rp").value);
	var kilos=parseFloat(document.getElementById("int_kilos_prod_rp").value);
	var metros=parseFloat(document.form1.metro_r.value); 
	
	var ups = document.getElementsByName('valor_desp_rd[]'), sum = 0, sum1 = 0, i;
	//si esta lleno el selct
	var id = document.getElementsByName('id_rpd[]'), i;
	
	if(ups.length >0){ 
		for(i = ups.length; i--;) {
		 //ALERTA DE SELECT VACIO 
	     if(ups[i].value=='')// || id[i].value==''
	     {
	     	swal("seleccione cantidad")
			//document.form1.int_kilos_desp_rp.value=desOper;
			ups[i].focus(); 
			return false; 
		  }//FIN
  		    sum1 += parseFloat(ups[i].value, 10);//suma todo el acumulado de desperdicio
			  //regla de tres para metros
			  var totalDesp=parseFloat(sum1)-parseFloat(reproceso);
			  var kilosTotales=parseFloat(kilos)-parseFloat(totalDesp);
			  var nuevosMetros = Math.round(kilosTotales * metros / kilos);
			  
  		    console.log(kilosTotales+"*"+metros+"/"+kilos)
 			document.form1.metro_r2.value = nuevosMetros;
 			document.form1.int_total_kilos_rp.value=kilosTotales;
 			document.form1.int_kilos_desp_rp.value=totalDesp.toFixed(2); 
            //restakilosT(); //para que opere los tiempos
 		}//for
 		
 	} else{
 		document.form1.int_total_kilos_rp.value=kilos;
 	}
} //FIN	 
 

 //SOLAMENTE SELLADO
 function kiloComparativoSell(){
 	
 	
 	var bolsa = parseInt(document.getElementById("bolsa_rp").value);
 	var metroImp = parseInt(document.getElementById("metro_r").value);
 	var kilosImp = parseFloat(document.getElementById("int_kilos_prod_rp").value);
 	
 	var metroInicial = parseInt(document.getElementById("metroInicial").value);
 	var kiloInicial = parseFloat(document.getElementById("kiloInicial").value);
 	
 	var reproceso = parseFloat(document.getElementById("reproceso").value);
	//var desOper = parseFloat(document.getElementById("int_kilos_desp_rp").value);
	var ancho = parseInt(document.getElementById("ancho").value)/100;
  //TOTAL DESPERDICIO
  var ups = document.getElementsByName('valor_desp_rd[]'), sum1 = 0, i;
  var id = document.getElementsByName('id_rpd[]'), i;
  if(ups.length >0){
  	for(i = ups.length; i--;) {
		  //ALERTA DE SELECT VACIO 
	     if(ups[i].value=='' )//|| id[i].value==''
	     {
	     	swal("seleccione cantidad");
			//document.form1.int_kilos_desp_rp.value=desOper;
			document.getElementByName("valor_desp_rd[]").focus();  
			return false;
		  }//FIN
		  
 		    sum1 += parseFloat(ups[i].value, 10);//suma todo el acumulado de desperdicio
 	       }//fin for		 
 	   }
 	   
 	   var DespTotal=(parseFloat(sum1)+(reproceso));
 	//REGLA DE TRES BOLSAS A KILOS
	var metrobolsa = bolsa*ancho;//bolsas a metros operario
	var nuevosKilos =  (metrobolsa * kilosImp/metroImp);
	var kilosTotales = (nuevosKilos);// 
	var nuevosMetros =  (kilosTotales * metroImp / kilosImp);
	document.getElementById("int_kilos_desp_rp").value=parseFloat(sum1);
	document.getElementById("metro_r2").value=Math.round(nuevosMetros);
	document.getElementById("metroIni_r").value=Math.round(metroInicial-nuevosMetros);
	var kilosSistema = (kiloInicial - (kilosTotales + DespTotal)); 
	document.getElementById("kiloSistema").value=kilosSistema.toFixed(2); 
	document.getElementById("int_total_kilos_rp").value=(kilosTotales).toFixed(2);
	 // }
	}
	
//EXCLUSIVO PARA REPROCESO SELLADO 
function reprocesoSell(){
	var desOper = parseFloat(document.getElementById("int_kilos_desp_rp").value);
	var reproceso = parseFloat(document.getElementById("reproceso").value);	
	var bolsa = parseInt(document.getElementById("bolsa_rp").value);	
	var totalkilo=parseFloat(document.getElementById("int_total_kilos_rp").value);
	var despsistema=parseFloat(document.getElementById("kiloSistema").value);
	 //TOTAL DESPERDICIO
	 var ups = document.getElementsByName('valor_desp_rd[]'), sum1 = 0, i;
	 if(ups.length >0){
	 	for(i = ups.length; i--;) {
 		    sum1 += parseFloat(ups[i].value, 10);//suma todo el acumulado de desperdicio
 	   }//fin for
 	   var totalDesp= parseFloat(sum1)+parseFloat(reproceso);
 	   document.form1.int_kilos_desp_rp.value=totalDesp.toFixed(2); 
 	   
		}else{sum1=0;} //fin if
		if(reproceso > despsistema){
		//alert("El reproceso no debe ser mayor al desp. del sistema");
		/*document.getElementById("reproceso").value ='0';
		document.form1.int_kilos_desp_rp.value=desOper; */
	}else{
        //regla de tres para bolsas de reproceso
        var nuevosBolsas = Math.round(reproceso * bolsa  / totalkilo);
        document.getElementById("bolsaRep_rp").value = nuevosBolsas;			
    }
    
}
  //SELLADO DESPERDICIO
  function pruebafor(){
  	var metrosL = document.getElementById("metro_r").value;
  	var fecha1 = new Date(document.getElementById("fecha_ini_rp").value);
  	var fecha2 = new Date(document.getElementById("fecha_fin_rp").value); 
  	var kilos_r = (document.getElementById("int_kilos_prod_rp").value);
  	var Desp= document.getElementById("int_kilos_desp_rp").value;
  	var DespStand=document.getElementById("standby").value;
  	var DespTm= document.getElementById("valor_tiem_rt").value;
  	var DespTp= document.getElementById("valor_prep_rtp").value;
  	var horas = ((fecha2-fecha1)/3600000);/*<!--hora total en terminos de decimal-->*/
  	var kiloRestante=parseFloat(kilos_r)-parseFloat(Desp);	
  	var nuevosMetros = Math.round(kiloRestante * metrosL / kilos_r);
 			var TiempOptimo = (horas*60);//hora a minuto termino minutos
			//solamente los tiempos muertos y standby termino decimal
			var TotTiemStand=parseFloat(DespStand); 
			//todos los tiempos para rodamiento termino de minutos
			var TotalTiempoRod=(parseFloat(DespTm) + parseFloat(DespTp) + parseFloat(DespStand)) ; 
		    //solamente los tiempos muertos y standby termino minutis
		    var TotTiemKilxH=(parseFloat(DespTm) + parseFloat(DespStand));  
		    
		    var MintTH = (TiempOptimo - TotTiemStand);
		    var MinRO = (TiempOptimo - TotalTiempoRod);
		    var MintKH = (TiempOptimo - TotTiemKilxH);

		    var totalTM = 0; 
		    var i;
		    var ups = [MintTH, MinRO, MintKH];
		    for(i = ups.length; i--;){
		    	if(ups[i] !='') {
		    		totalTM=ups[i];
		    		alert(totalTM);
			//for(x = valor.length; x--;){
            //totalTM=valor[x].value;
 			//alert(totalTM);
			//}
		}else{
			alert('no es')
		}
	}
	
  			/*var cars = [MintTH, MinRO, MintKH];
			var text = "";
            var i;
			for (i = 0; i < cars.length; i++) { 
 
			var secKH = (cars[i]*60);//con descuento tiempo convierto la hora a segundos
  			var hrsKH = Math.floor(secKH/3600);
			var minuKH = Math.floor((secKH%3600)/60);
			if(secKH<10) secKH = "0" + secKH;   
			if(minuKH<10) minuKH = "0" + minuKH; 
			var text = hrsKH + ":" + minuKH; 
			KilosxtH=(kilos_r/hrsKH);
			KilosxtHora = KilosxtH.toFixed(2); 
            alert(text);//.slice(0,2)

        }	*/

    }
  //codigo en javascript para sumar DESPERDICIO KILOS de arrays de extrusion
  function getSumD(){
  	var ups = document.getElementsByName('valor_desp_rd[]'), sum = 0, i;
  	for(i = ups.length; i--;)
  		if(ups[i].value)
  			sum += parseFloat(ups[i].value, 10);
  		var total=sum.toFixed(2);
  		document.form1.int_kilos_desp_rp.value=total;
  		return sum;
  	}  
//codigo en javascript para sumar PRODUCIDOS KILOS de arrays de extrusion
function getSumP(){
	var ups = document.getElementsByName('valor_prod_rp[]'), sum = 0, i;
	for(i = ups.length; i--;)
		if(ups[i].value)
			sum += parseFloat(ups[i].value, 10);
		var total=sum.toFixed(2);
		if(total!=0.00){
			document.form1.int_kilos_prod_rp.value=total;
		}else{document.form1.int_kilos_prod_rp.value='';}
		return sum;
	} 
//codigo en javascript para restar TOTAL DE KILOS CONSUMO
function getSumT(){
var kilos_tp=parseFloat(document.form1.int_kilos_prod_rp.value);//BRUTOS 
var kilos_td=parseFloat(document.form1.int_kilos_desp_rp.value);
var total_k=(kilos_tp-kilos_td);
var total_kilos=total_k.toFixed(2);
if(total_kilos!=0.00){  
	var Total_kilos_P=document.form1.int_total_kilos_rp.value=(total_kilos);
}else{document.form1.int_total_kilos_rp.value='';}
return sum;
} 
function getSumK(){
	var ups = document.getElementsByName('valor_tinta_rp[]'), sum = 0, i;
	for(i = ups.length; i--;)
		if(ups[i].value)
			sum += parseFloat(ups[i].value, 10);
		var total=sum.toFixed(2);
		if(total!=0.00){
			document.form1.int_totalKilos_tinta_rp.value=total;
		}else{document.form1.int_totalKilos_tinta_rp.value='';}
		return sum;
	} 
//funcion especial para captar el valor del id que desee
function captarDinamicos(){ 
	var ups = document.getElementsByName('id_rpd[]'), i;
	var valor = document.getElementsByName('valor_desp_rd[]'), sum = 0, i;
	for(i = ups.length; i--;)
        if(ups[i].value==54)//58 es mala impresion
        	sum += parseFloat(valor[i].value, 10);
        alert(sum);
    }
/*function selectvacios(){
 var ups = document.getElementsByName('valor_tiem_rt[]'), sum = 0, i;
	 var id = document.getElementsByName('id_rpt[]'), i;
     for(i = ups.length; i--;){
        if(ups[i].value){
		//ALERTA DE SELECT VACIO 
			 if(ups[i].value!='' && id[i].value==''){
				alert("seleccione tipo de Tiempo Muertos")
				 
				return false; 
			  }
		  }
  	   } 
  	}*/
//codigo en javascript para ocultar y mostrar capas o tablas de extrusion
function mostrardiv1() {
	div2 = document.getElementById("flotante");
	div2.style.display = "";
}
function ocultardiv1() {
	div2 = document.getElementById("flotante");
	div2.style.display="none";
}
//codigo en javascript para ocultar y mostrar capas o tablas de extrusion
function mostrardiv2() {
	div = document.getElementById("flotante2");
	div.style.display = "";
}
function ocultardiv2() {
	div = document.getElementById("flotante2");
	div.style.display="none";
}
function mostrardiv3() {
	div = document.getElementById("check"); 
	div.style.display="";
	div = document.getElementById("liquida");
	div.style.display="none";
}
/*PESO-MILLAR REFERENCIA*/
function calcular_pesom()
{
//evalua el valor de la solapa si es doble o sencilla
for(i=0;i<document.form1.valora.length;i++){
	if(document.form1.valora[i].checked) {
		marcado=i;
	}
}
var v_solapacero=document.form1.valora[marcado].value;//sencilla o doble 1 o 2
//fin	
//VARIABLES
if(v_solapacero==0){
	var v_solapa=1;
}else
if(v_solapacero==1){
	var v_solapa=1;
}else
if(v_solapacero==2){
	var v_solapa=2;
}
var solapa=parseFloat(document.form1.solapa_ref.value);


//Divide la cantidad de la solapa si es sencilla o doble si es cero no divide
var dsolapa=(solapa/v_solapa);
var cons= document.form1.tipo_bolsa_ref.value=="COMPOSTABLE" ? parseFloat(0.00665) : parseFloat(0.00467);
var fuelle=parseFloat(document.form1.B_fuelle.value);
var larg=parseFloat(document.form1.largo_ref.value);
var ancho=parseFloat(document.form1.ancho_ref.value);
var calibre=parseFloat(document.form1.calibre_ref.value);
//OPERACIONES FORMULA
var subm=ancho*(larg+fuelle+dsolapa)*calibre*cons;
var submillar=parseFloat(subm);
var millar_t=submillar.toFixed(2);
document.form1.peso_millar_ref.value=millar_t;// millar para referencia
//O.P
document.form1.int_pesom_op.value=subm;// millar para o.p  

}
function calcular_pesomBols()
{
//BOLSILLO CANGURO DE LA BOLSA
var cons=parseFloat(0.00467);
var ancho=parseFloat(document.form1.ancho_ref.value);
var calibreBols=parseFloat(document.form1.calibreBols_ref.value);
var lamina1=parseFloat(document.form1.bol_lamina_1_ref.value);
var lamina2=parseFloat(document.form1.bol_lamina_2_ref.value);
var sumaBol=parseFloat(lamina1+lamina2);
//OPERACIONES FORMULA
//lo divido en 2 porque no es tubular sino lamina
var submB=(ancho*(sumaBol)*calibreBols*cons)/2;
var millar_Bols=submB.toFixed(2); 
document.form1.peso_millar_bols.value=millar_Bols;// millar para  bolsillo en ref	
}
function medida_bolsillo(input)
{ 
	var tipo=(document.form1.tipolam.value);
	switch(tipo) {
		case "1406":  
		  document.form1.bol_lamina_1_ref.value = 9;
		  document.form1.bol_lamina_2_ref.value = 7;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "1407":
		  document.form1.bol_lamina_1_ref.value = 13;
		  document.form1.bol_lamina_2_ref.value = 8;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "1655":
		  document.form1.bol_lamina_1_ref.value = 18;
		  document.form1.bol_lamina_2_ref.value = 7;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "1657":
		  document.form1.bol_lamina_1_ref.value = 17;
		  document.form1.bol_lamina_2_ref.value = 13;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2621":
		  document.form1.bol_lamina_1_ref.value = 17;
		  document.form1.bol_lamina_2_ref.value = 10;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2618":
		  document.form1.bol_lamina_1_ref.value = 12;
		  document.form1.bol_lamina_2_ref.value = 7;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2616":
		  document.form1.bol_lamina_1_ref.value = 8;
		  document.form1.bol_lamina_2_ref.value = 6;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2617":
		  document.form1.bol_lamina_1_ref.value = 10;
		  document.form1.bol_lamina_2_ref.value = 7;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2620":
		  document.form1.bol_lamina_1_ref.value = 17;
		  document.form1.bol_lamina_2_ref.value = 8;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2622":
		  document.form1.bol_lamina_1_ref.value = 17;
		  document.form1.bol_lamina_2_ref.value = 13;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "2619":
		  document.form1.bol_lamina_1_ref.value = 13;
		  document.form1.bol_lamina_2_ref.value = 8;
		  document.form1.calibreBols_ref.value = 1.5;
		  break; 
		  case "3475":
		  document.form1.bol_lamina_1_ref.value = 10;
		  document.form1.bol_lamina_2_ref.value = 0;
		  document.form1.calibreBols_ref.value = 1.5;
		  break;
		  case "0":
		  document.form1.bol_lamina_1_ref.value = '0.00';
		  document.form1.bol_lamina_2_ref.value = '0.00';
		  document.form1.calibreBols_ref.value = '';
		  break;
		  
		/*default: 
		  //defecto lamina 1 de 0, lamina 2 de 0
          document.form1.bol_lamina_1_ref.value = 0;
          document.form1.bol_lamina_2_ref.value = 0;*/
      }		
  } 
  /*CALCULAR PESO/ML DE REFERENCIAS DE LAMINA*/
  function calcular_pesoml()
  {
  	var gramo=(25.4);
  	$peso=(gramo*(parseFloat(document.form1.calibre_ref.value)));	
  	document.form1.peso_ref.value=Math.round($peso*100)/100;
  } 
  /*-------------------------*/
  /*CONSULTA REFERENCIA*/
  function generica(selec) 
  {	
  	if ((document.form1.B_generica.value  == '1')) { 
  		window.location ='referencia_bolsa_generica2.php?cod_ref='+document.form1.ref_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
  	}
  }
/*function consultagenerica(selec) 
{
window.location ='referencia_bolsa_generica.php?id_ref='+document.form1.ref.value;
}*/
function consultagenerica2(selec) 
{
	window.location ='referencia_bolsa_generica2.php?id_ref='+document.form1.ref.value+'&cod_refe='+document.form1.cod_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
}
function consultagenerica3(selec) 
{
	window.location ='cotizacion_general_bolsa_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value+'&generica=1';
}
function consultaexistente3(selec) 
{
	window.location ='cotizacion_general_bolsa_generica.php?id_ref='+document.form1.ref2.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value+'&generica=1';
}
function consultaotros3(selec) 
{
	window.location ='cotizacion_general_bolsa_generica.php?id_ref='+document.form1.ref3.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value+'&generica=2';
}


function consultagenerica4(selec) 
{
	window.location ='cotizacion_general_laminas_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value;
}
function consultaexistente4(selec) 
{
	window.location ='cotizacion_general_laminas_generica.php?id_ref='+document.form1.ref2.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value;
}
function consultagenerica5(selec) 
{
	window.location ='cotizacion_general_packingList_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value;
}
function consultaexistente5(selec) 
{
	window.location ='cotizacion_general_packingList_generica.php?id_ref='+document.form1.ref2.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.Str_nit.value;
}
function genericalamina(selec) 
{	
	if ((document.form1.B_generica.value  == '1')) { 
		window.location ='referencia_lamina_generica.php?cod_ref='+document.form1.ref_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
	}
}
function genericalaminaref(selec) 
{
	window.location ='referencia_lamina_generica.php?id_ref='+document.form1.ref.value+'&cod_ref='+document.form1.cod_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
}
function genericapacking(selec) 
{	
	if ((document.form1.B_generica.value  == '1')) { 
		window.location ='referencia_packing_generica.php?cod_ref='+document.form1.ref_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
	}
}
function genericapackingref(selec) 
{
	window.location ='referencia_packing_generica.php?id_ref='+document.form1.ref.value+'&cod_ref='+document.form1.cod_gen.value+'&n_cotiz_ref='+document.form1.n_cotiz_ref.value+'&Str_nit='+document.form1.Str_nit.value;
}
/*<!--CONSULTAS POR CLIENTE PARA VER LAS REF GENERICAS O EXISTENTES DEPENDIENDO DEL CLIENTE-->*/
function consultanit(selec) 
{
	window.location ='cotizacion_general_bolsa_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.clientes.value;
}
function consultanit2(selec) 
{
	window.location ='cotizacion_general_laminas_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.clientes.value;
}
function consultanit3(selec) 
{
	window.location ='cotizacion_general_packingList_generica.php?id_ref='+document.form1.ref.value+'&N_cotizacion='+document.form1.N_cotizacion.value+'&Str_nit='+document.form1.clientes.value;
}
function consultanit4(selec) 
{
	window.location ='cotizacion_general_materia_prima.php?Str_nit='+document.form1.clientes.value;
}
/*function genericapacking(selec) 
{
PENDIENTE PARA AGREGAR REFERENCIAS A COTIZACION
function addref(selec) 
{
window.location ='cotizacion_general_bolsa_generica2.php?N_cotizacion='+document.form1.N_cotizacion.value;
}*/

function consultaref()
{
	window.location ='cotizacion_bolsa_existente.php?n_cotiz='+document.form1.n_cotiz.value+'&id_c='+document.form1.id_c.value+'&id_ref='+document.form1.ref.value;
}
function consultaref1()
{
	window.location ='cotizacion_bolsa_existente_edit.php?n_cotiz='+document.form1.n_cotiz.value+'&id_ref='+document.form1.ref.value+'&n_ce='+document.form1.n_ce.value+'&id_c='+document.form1.id_c.value+'&id_ref1='+document.form1.id_ref1.value;
}
/* pedido_bolsa_detalle (add-edit) */
function cotiz_ref()
{
	window.location ='pedido_bolsa_detalle.php?id_pedido='+document.form1.id_pedido.value+'&n_cotiz='+document.form1.n_cotiz_pedido.value;
}
function pedido_cliente()
{
	window.location ='pedido_bolsa_edit.php?id_pedido='+document.form1.id_pedido.value+'&id_c_pedido='+document.form1.id_c_pedido.value;
}

/*---------------------------------------------------------*/
/*-------------GESTION DISE�O Y DESARROLLO-----------------*/
/*CALCULAR PESO BRUTO*/
function calcularft(millar,unids)
{
	if(millar != '' & unids != '')
	{
		$millar=parseFloat(millar);
		$unids=parseFloat(unids);
		$bruto=($millar/1000)*($unids);
		$peso_caja=document.form1.peso_caja.value;
		if($peso_caja != '')
		{
			$peso=parseFloat($peso_caja);
			$bruto=$bruto+$peso;
		}
		$final=Math.round($bruto*100)/100;
		document.form1.peso_bruto_ft.value=$final;
	}
}
/*-------------ORDEN DE COMPRA CLIENTE---------------*/
function limpiaEspacios(){
	var cad=(document.form1.str_numero_oc.value);
	var cadena = cad;
	var valor=cadena.replace(/\s/g,'');
 //toLowerCase  a minusculas
 var valor_cadena = valor.toUpperCase();//mayusculas
 document.form1.str_numero_oc.value=valor_cadena;
//return valor;
}
function addoc()
{
	var statusConfirm = confirm("Quiere que el sistema ingrese el numero de O.C ?");
	if (statusConfirm == true)
	{
		
		document.form1.str_numero_oc.value=document.form1.sioc.value;
		document.form1.id_oc.value=document.form1.id_oc.value;
		document.form1.b_oc_interno.value=1;
		document.form1.b_oc_interno.checked=1;
		document.getElementById('str_numero_oc').readOnly=true
//window.location ='orden_compra_cl_add.php?str_numero_oc='+document.form1.sioc.value;
}else if (statusConfirm == false){
	document.form1.str_numero_oc.value='';
	document.form1.b_oc_interno.value=0;	
	document.form1.b_oc_interno.checked=0;
	document.getElementById('str_numero_oc').readOnly=false
}
}

function consultaclienteadd_oc(id_oc)
{
	crearObjeto();
	if (objeto.readyState != 0) {
		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
	} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoOc;
// Enviar la consulta
objeto.open("GET", "consulta_oc.php?id_oc=" + id_oc, true);
objeto.send(null);
}
//caga objeto ajax
function ResultadoOc() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
	document.getElementById('definicion_oc').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion_oc').innerHTML = objeto.responseText;
}
}	
}


/*function consultanitadd_oc(id_nit_oc)
{
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoOc2;
// Enviar la consulta
objeto.open("GET", "consulta_oc.php?id_oc=" + id_nit_oc, true);
objeto.send(null);
}
//caga objeto ajax
function ResultadoOc2() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
document.getElementById('definicion_oc').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('definicion_oc').innerHTML = objeto.responseText;
}
}	
}*/


function consultacliente_oc()
{
	window.location ='orden_compra_cl_edit.php?n_oc='+document.form1.n_oc.value+'&id_oc='+document.form1.id_oc.value;
}
function consultanit_oc()
{
	window.location ='orden_compra_cl_edit.php?n_oc='+document.form1.n_oc.value+'&id_oc='+document.form1.id_nit_oc.value;
}
/*-------------------------------------------------*/
/*--------------CONSULTA DESDE ITEMS O.C-----------------*/
//select ref
function refacvsrefcl(){
	if (document.form1.int_cod_ref_io.value != "") {
		window.location ='orden_compra_cl_add_detalle.php?str_numero_oc='+document.form1.str_numero_oc.value+'&id_oc='+document.form1.id_oc.value+'&nit_c='+document.form1.nit_c.value+'&int_cod_ref_io='+document.form1.int_cod_ref_io.value;	
			//document.form1.id_mp_vta_io.disabled = true;
			document.getElementById('ref_mp').disabled = true;
		}else if (document.form1.int_cod_ref_io.value == "") {
			document.getElementById('ref_mp').disabled = false;
		}				       	  
	}
 //select mp
 function refmpvsrefac(){
 	if (document.form1.id_mp_vta_io.value != "") {
 		window.location ='orden_compra_cl_add_detalle.php?str_numero_oc='+document.form1.str_numero_oc.value+'&id_oc='+document.form1.id_oc.value+'&nit_c='+document.form1.nit_c.value+'&int_cod_ref_io='+document.form1.id_mp_vta_io.value;	
 		document.getElementById('ref_cl').disabled = true;
 	}else if (document.form1.id_mp_vta_io.value == "") {
 		document.getElementById('ref_cl').disabled = false;
 		
 	}
 }
 function refmpvsrefac_edit(){
 	if (document.form1.id_mp_vta_io.value != "") {
 		window.location ='orden_compra_cl_edit_detalle.php?id_items='+document.form1.id_items.value+'&id_oc='+document.form1.id_oc.value+'&nit_c='+document.form1.nit_c.value+'&int_cod_ref_io='+document.form1.id_mp_vta_io.value;	
 		document.getElementById('ref_cl').disabled = true;
 	}else if (document.form1.id_mp_vta_io.value == "") {
 		document.getElementById('ref_cl').disabled = false;
 		
 	}
 } 
 function refacvsrefcl_edit(){
 	if (document.form1.int_cod_ref_io.value != "") {	  
 		window.location ='orden_compra_cl_edit_detalle.php?id_oc='+document.form1.id_oc.value+'&int_cod_ref_io='+document.form1.int_cod_ref_io.value+'&nit_c='+document.form1.nit_c.value+'&id_items='+document.form1.id_items.value;
 		document.getElementById('ref_mp').disabled = true;
 	}else if (document.form1.int_cod_ref_io.value == "") {
 		document.getElementById('ref_mp').disabled = false;
 	}				       	  
 }

 //ORDEN DE COMPRA
//DIFERENCIA DE FECHA ENTREGA EN O.C DETALLE

/*function fecha_detalle_oc(){
	var date1=(document.form1.fecha_ingreso_oc.value);
	var date2=(document.form1.fecha_entrega_io.value);
if (date1 > date2) { 
       alert("la fecha de entrega no puede ser menor a la fecha de ingreso");
         return false; 
         }else{		
		    indice = document.getElementById("str_direccion_desp_io").selectedIndex;
			if( indice == null || indice == '' || indice == 0) 
			  { 
			  swal('Debe Seleccionar una DIRECCION de DESPACHO, sino existe ingresela en el perfil del cliente');
			  return false;
			  }
			  
	    return true;
   }
   
}*/
function refacvsrefmp(){
	if (document.form1.int_cod_ref_io.value != "") {
		document.form1.id_mp_vta_io.disabled = true;
	}else{
		if (document.form1.int_cod_ref_io.value == "") {
			document.form1.id_mp_vta_io.disabled = false;
		}
	}
}
function existeop(){
	swal("El item ya se encuentra en produccion, por lo tanto no puede modificar las cantidades","verifique con el responsable de produccion.")
	return false;
}
function enProduccion(){
	swal("")	
	swal("No se puede Eliminar porque ya se encuentra en produccion o tiene remisiones!", "Verifique con el responsable de produccion, para que elimine la o.p")
}


/*-------------------------------------------------*/
/*-------------GESTION DE PRODUCCION---------------*/
//EXTRUSION
function consulta_oc_op(selec) 
{
	window.location ='produccion_op_add.php?str_numero_oc_op='+document.form1.str_numero_oc_op.value;
}

function consulta_ref_op(selec) 
{
	window.location ='produccion_op_add.php?str_numero_oc_op='+document.form1.str_numero_oc_op.value+'&int_cod_ref_op='+document.form1.int_cod_ref_op.value;
} 
function consulta_ref_op_interna(selec) 
{
	window.location ='produccion_op_interna.php?int_cliente_op='+document.form1.int_cliente_op.value+'&str_numero_oc_op='+document.form1.str_numero_oc_op.value+'&int_cod_ref_op='+document.form1.int_cod_ref_op.value;
}  
function consulta_ref_op_edit(selec) 
{
window.location ='produccion_op_edit.php?int_cliente_op='+document.form1.int_cliente_op.value+'&str_numero_oc_op='+document.form1.str_numero_oc_op.value+'&int_cod_ref_op='+document.form1.int_cod_ref_op.value+'&id_op='+document.form1.id_op.value;
}
function consulta_ref_mezcla(selec) 
{
	window.location ='produccion_mezclas_add.php?id_ref='+document.form1.id_ref.value+'&cod_ref='+document.form1.cod_ref.value+'&ref='+document.form1.ref.value;
}
function consulta_ref_temperatura(selec) 
{
	window.location ='produccion_caract_extrusion_add.php?id_pm='+document.form1.id_pm_cv.value+'&id_ref='+document.form1.id_ref_cv.value+'&cod_ref='+document.form1.cod_ref_cv.value+'&ref='+document.form1.ref.value;
}
function consulta_ref_temperatura_edit(selec) 
{
	window.location ='produccion_caract_extrusion_mezcla_edit.php?id_ref='+document.form2.id_ref_cv.value+'&id_pm='+document.form2.id_pm_cv.value+'&id_ref='+document.form2.id_ref.value;
}
//IMPRESION
function consulta_ref_mezcla_impresion(selec) 
{
	window.location ='produccion_mezclas_impresion_add.php?id_ref='+document.form1.id_ref.value+'&cod_ref='+document.form1.cod_ref.value+'&ref='+document.form1.ref.value;
}
function consulta_ref_impresion_add(selec) 
{
	window.location ='produccion_caract_impresion_add.php?id_ref='+document.form1.id_ref_pmi.value+'&cod_ref='+document.form1.int_cod_ref_pmi.value+'&ref='+document.form1.ref.value;
}
function consulta_ref_impresion_edit(selec)
{
	window.location ='produccion_caract_impresion_edit.php?id_ref='+document.form1.id_ref_pmi.value+'&ref='+document.form1.ref.value;
}
/*-------------FIN GESTION DE PRODUCCION---------------*/
/*-------------DISENO Y DESARROLLO--------------------*/
function consulta_certificacion_cl(selec) 
{
	window.location ='certificacion_add.php?id_ref='+document.form1.idref.value+'&idc='+document.form1.idc.value;
}
function consulta_certificacion_op(selec)  
{
	window.location ='certificacion_add.php?id_ref='+document.form1.idref.value+'&idc='+document.form1.idc.value+'&op='+document.form1.op.value;
}
function consulta_certificacion_cl_edit(selec) 
{
	window.location ='certificacion_add.php?id_ref='+document.form1.idref.value+'&idc='+document.form1.idc.value;
}
function consulta_certificacion_op_edit(selec)  
{
	window.location ='certificacion_edit.php?idcc='+document.form1.idcc.value+'&op='+document.form1.op.value;
}
/*-------------FIN DISENO Y DESARROLLO----------------*/
function calificacion()
{
	document.form1.primera_calificacion_p.value=0;
	$contador=0;
	$pregunta1=parseFloat(document.form1.directo_p.value);
	if($pregunta1=="5" || $pregunta1=="3" || $pregunta1=="1")
	{
		++$contador;
	}
	$pregunta2=parseFloat(document.form1.forma_pago_p.value);
	if($pregunta2=="5" || $pregunta2=="3" || $pregunta2=="1")
	{
		++$contador;
	}
	$pregunta3=parseFloat(document.form1.sist_calidad_p.value);
	if($pregunta3=="5" || $pregunta3=="3" || $pregunta3=="1")
	{
		++$contador;
	}
	$pregunta4=parseFloat(document.form1.certificado_p.value);
	if($pregunta4=="5" || $pregunta4=="3" || $pregunta4=="1")
	{
		++$contador;
	}
	$pregunta5=parseFloat(document.form1.analisis_p.value);
	if($pregunta5=="5" || $pregunta5=="3" || $pregunta5=="1")
	{
		++$contador;
	}
	$pregunta6=parseFloat(document.form1.orden_compra_p.value);
	if($pregunta6=="5" || $pregunta6=="3" || $pregunta6=="1")
	{
		++$contador;
	}
	$pregunta7=parseFloat(document.form1.tiempo_agil_p.value);
	if($pregunta7=="5" || $pregunta7=="3" || $pregunta7=="1")
	{
		++$contador;
	}
	$pregunta8=parseFloat(document.form1.entrega_p.value);
	if($pregunta8=="5" || $pregunta8=="3" || $pregunta8=="1")
	{
		++$contador;
	}
	$pregunta9=parseFloat(document.form1.flete_p.value);
	if($pregunta9=="5" || $pregunta9=="1")
	{
		++$contador;
	}
	$pregunta10=parseFloat(document.form1.plan_mejora_p.value);
	if($pregunta10=="5" || $pregunta10=="1")
	{
		++$contador;
	}
	$pregunta11=parseFloat(document.form1.precios_p.value);
	if($pregunta11=="5" || $pregunta11=="3" || $pregunta11=="1")
	{
		++$contador;
	}
	$pregunta12=parseFloat(document.form1.asesor_com_p.value);
	if($pregunta12=="5" || $pregunta12=="3" || $pregunta12=="1")
	{
		++$contador;
	}
	$pregunta13=parseFloat(document.form1.limite_min_p.value);
	if($pregunta13=="5" || $pregunta13=="1")
	{
		++$contador;
	}
	$pregunta14=parseFloat(document.form1.proceso_p.value);
	if($pregunta14=="5" || $pregunta14=="1")
	{
		++$contador;
	}

	$var25=parseFloat($contador);
	$var26=$var25*5;
	$var27=$pregunta1+$pregunta2+$pregunta3+$pregunta4+$pregunta5+$pregunta6+$pregunta7+$pregunta8+$pregunta9+$pregunta10+$pregunta11+$pregunta12+$pregunta13+$pregunta14;
	$var28=($var27/$var26)*100;
	$num=Math.round($var28*100)/100;
	document.form1.primera_calificacion_p.value=$num;
}
function consultaproveedor()
{
	window.location ='orden_compra_edit.php?n_oc='+document.form1.n_oc.value+'&id_p_oc='+document.form1.id_p_oc.value;
}
function consultaexportacion()
{
	window.location ='costo_exportacion_edit.php?n_ce='+document.form1.n_ce.value+'&id_c_ce='+document.form1.id_c_ce.value;
}


function adelanto()
{
	//var valortotal=document.form1.total_oc.value;
	var valoroperar=document.form1.total_operar.value;
	var reserva_total_oc=document.form1.reserva_total_oc.value;
	var adelanto=document.form1.adelanto_oc.value;
	if(adelanto!=0 || adelanto!=''){
    	var nuevo_total=parseFloat(valoroperar-adelanto)//ya tiene el valor iva; 
        decimalesForm(nuevo_total,'total_oc'); 
    }else{ 
    	decimalesForm(valoroperar,'total_oc');
    }

}

function rte_fte(){
	const_fte=parseFloat(document.form1.constante_fte.value); 
	var reserva_total_oc=document.form1.reserva_total_oc.value; 
	var fte_oc = document.form1.fte_oc.value;
	var fte_iva_oc = document.form1.fte_iva_oc.value;
	var fte_ica_oc = document.form1.fte_ica_oc.value;
	var total_todas = parseFloat(fte_iva_oc)+parseFloat(fte_ica_oc);
	
	if(const_fte!=0){
		var valor_const_fte=(reserva_total_oc*const_fte/100);
		document.form1.fte_oc.value=valor_const_fte.toFixed(2);
		var total = parseFloat(reserva_total_oc)-(parseFloat(valor_const_fte+total_todas));
		var valor_total=total.toFixed(2); 
		document.form1.total_operar.value=valor_total;//para operar sin puntos el nuevo total_oc
		decimalesForm(valor_total,'total_oc'); 
	}else if(const_fte==0){
		var total_operar=document.form1.total_operar.value;
		var valortotal = parseFloat(total_operar)+parseFloat(document.form1.fte_oc.value);  
		decimalesForm(valortotal,'total_oc'); 
		document.form1.total_operar.value=valortotal;//para operar sin puntos el nuevo total_oc
		document.form1.fte_oc.value=0;
	}
}

function fte_iva(){
	const_fte_iva=parseFloat(document.form1.constante_fte_iva.value); 
	var reserva_total_oc=document.form1.reserva_total_oc.value;  
	var fte_oc = document.form1.fte_oc.value;
	var fte_iva_oc = document.form1.fte_iva_oc.value;
	var fte_ica_oc = document.form1.fte_ica_oc.value;
	var total_todas = parseFloat(fte_oc)+parseFloat(fte_ica_oc);

	if(const_fte_iva!=0){
		var valor_const_fte_iva=(reserva_total_oc*const_fte_iva/100);
		document.form1.fte_iva_oc.value=valor_const_fte_iva.toFixed(2);
		var total = parseFloat(reserva_total_oc)-(parseFloat(valor_const_fte_iva+total_todas));
		var valor_total=total.toFixed(2);
		document.form1.total_operar.value=valor_total;//para operar sin puntos el nuevo total_oc 
		decimalesForm(valor_total,'total_oc'); 
	}else if(const_fte_iva==0){
		var total_operar=document.form1.total_operar.value; 
		var valortotal = parseFloat(total_operar)+parseFloat(document.form1.fte_iva_oc.value); 
		decimalesForm(valortotal,'total_oc'); 
		document.form1.total_operar.value=valortotal;//para operar sin puntos el nuevo total_oc
		document.form1.fte_iva_oc.value=0;   
	}
}

function fte_ica(){
	const_fte_ica=parseFloat(document.form1.constante_fte_ica.value); 
	var reserva_total_oc=document.form1.reserva_total_oc.value;  
	var fte_oc = document.form1.fte_oc.value;
	var fte_iva_oc = document.form1.fte_iva_oc.value;
	var fte_ica_oc = document.form1.fte_ica_oc.value;
	var total_todas = parseFloat(fte_oc)+parseFloat(fte_iva_oc);
	
	if(const_fte_ica!=0){ 
		var valor_const_fte_ica=(reserva_total_oc*const_fte_ica/100);
		document.form1.fte_ica_oc.value=valor_const_fte_ica.toFixed(2);
		var total = parseFloat(reserva_total_oc)-(parseFloat(valor_const_fte_ica+total_todas));
		var valor_total=total.toFixed(2); 
		document.form1.total_operar.value=valor_total;//para operar sin puntos el nuevo total_oc
		decimalesForm(valor_total,'total_oc'); 
	}else if(const_fte_ica==0){
		var total_operar=document.form1.total_operar.value;   
		var valortotal = parseFloat(total_operar)+parseFloat(document.form1.fte_ica_oc.value); 
		decimalesForm(valortotal,'total_oc'); 
		document.form1.total_operar.value=valortotal;//para operar sin puntos el nuevo total_oc
		document.form1.fte_ica_oc.value=0;
	}
}

function decimalesForm(valor,names)
{
	
	if(!isNaN(valor)){
		valor = valor.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
		valor = valor.split('').reverse().join('').replace(/^[\.]/,'');

		if(names=='valor_bruto_oc')
			$("[name='valor_bruto_oc']").val(valor) 
		if(names=='valor_iva_oc')
			$("[name='valor_iva_oc']").val(valor) 
		if(names=='fte_oc')
			$("[name='fte_oc']").val(valor) 
		if(names=='fte_iva_oc')
			$("[name='fte_iva_oc']").val(valor) 
		if(names=='fte_ica_oc')
			$("[name='fte_ica_oc']").val(valor) 
		if(names=='total_oc')
			$("[name='total_oc']").val(valor) 

	} 
}

/*function adelanto()
{
 var valor_iva_oc=0;
 var adelanto=0;
 var valor_iva_oc=0;
 var valortotal=0;
 var adelanto=0;
 var nuevo_bruto=0;
 var valor_const_fte=0;
 var valor_const_fte_iva=0;
 var valor_const_fte_ica=0;
 var total=0;
 var valor_total=0;
 var valor_total1=0;
 var valor_total2=0;
 var valor_total3=0;

 var const_fte=parseFloat(document.form1.constante_fte.value);
 var const_fte_iva=parseFloat(document.form1.constante_fte_iva.value);
 var const_fte_ica=parseFloat(document.form1.constante_fte_ica.value);


 var valortotal=document.form1.total_oc.value;
 var reserva_total_oc=document.form1.reserva_total_oc.value;
 var adelanto=document.form1.adelanto_oc.value;
 

 var nuevo_bruto=(valortotal-adelanto)//ya tiene el valor iva; 
 document.form1.total_oc.value=nuevo_bruto;

 var restatotal = 0;
 if(const_fte!='0'){
    var valor_const_fte=(nuevo_bruto*const_fte/100);
    document.form1.fte_oc.value=valor_const_fte.toFixed(2);
    var total1 = parseFloat(nuevo_bruto)-parseFloat(valor_const_fte);
    var valor_total1=total1.toFixed(2); 
    restatotal+=parseFloat(valor_total1);
 } 
 if(const_fte_iva!='0'){
    var valor_const_fte_iva=(nuevo_bruto*const_fte_iva/100);
    document.form1.fte_iva_oc.value=valor_const_fte_iva.toFixed(2);
    var total2 = parseFloat(nuevo_bruto)-parseFloat(valor_const_fte_iva);
    var valor_total2=total2.toFixed(2); 
    restatotal+=parseFloat(valor_total2);
 } 
 if(const_fte_ica!='0'){
    var valor_const_fte_ica=(nuevo_bruto*const_fte_ica/100);
    document.form1.fte_ica_oc.value=valor_const_fte_ica.toFixed(2); 
    var total3 = parseFloat(nuevo_bruto)-parseFloat(valor_const_fte_ica);
    var valor_total3=total3.toFixed(2);  
    restatotal+=parseFloat(valor_total3);
 } 

 document.form1.total_oc.value = restatotal;
 

 if(const_fte=='0'&&const_fte_iva=='0'&&const_fte_ica=='0'){ 
   document.form1.fte_oc.value=0; 
   document.form1.fte_iva_oc.value=0; 
   document.form1.fte_ica_oc.value=0; 
 }
 
 
 
}*/

function totaloc()
{
	var bruto=parseFloat(document.form1.valor_bruto_oc.value);
//var bruto=brut.replace(/\s/g,''); 
var const_iva=parseFloat(document.form1.constante_iva.value);
var const_fte=parseFloat(document.form1.constante_fte.value);
var const_fte_iva=parseFloat(document.form1.constante_fte_iva.value);
var const_fte_ica=parseFloat(document.form1.constante_fte_ica.value);

var adelanto=parseFloat(document.form1.adelanto_oc.value);

var nuevo_bruto=bruto-adelanto; 


if(nuevo_bruto!=0 || nuevo_bruto!=''){	
	var valor_iva=nuevo_bruto*const_iva/100; 
	var valor_const_fte=nuevo_bruto*const_fte/100;
	var valor_const_fte_iva=nuevo_bruto*const_fte_iva/100;
	var valor_const_fte_ica=nuevo_bruto*const_fte_ica/100;
//var valor_adelanto=nuevo_bruto;

document.form1.valor_iva_oc.value= valor_iva.toFixed(2);
document.form1.fte_oc.value=valor_const_fte.toFixed(2);
document.form1.fte_iva_oc.value=valor_const_fte_iva.toFixed(2);
document.form1.fte_ica_oc.value=valor_const_fte_ica.toFixed(2); 
document.form1.valor_bruto_oc.value= nuevo_bruto;

}
$total=parseFloat(nuevo_bruto+valor_iva)-parseFloat(valor_const_fte+valor_const_fte_iva+valor_const_fte_ica);
$valor_total=$total.toFixed(2); 
document.form1.total_oc.value=$valor_total;
}

/*function totaloc()
{
var bruto=parseFloat(document.form1.valor_bruto_oc.value);
//var bruto=brut.replace(/\s/g,''); 
var const_iva=parseFloat(document.form1.constante_iva.value);
var const_fte=parseFloat(document.form1.constante_fte.value);
var const_fte_iva=parseFloat(document.form1.constante_fte_iva.value);
var const_fte_ica=parseFloat(document.form1.constante_fte_ica.value);

var adelanto=parseFloat(document.form1.adelanto_oc.value);
 
var nuevo_bruto=bruto-adelanto; 
 

 if(nuevo_bruto!=0 || nuevo_bruto!=''){	
var valor_iva=nuevo_bruto*const_iva/100; 
var valor_const_fte=nuevo_bruto*const_fte/100;
var valor_const_fte_iva=nuevo_bruto*const_fte_iva/100;
var valor_const_fte_ica=nuevo_bruto*const_fte_ica/100;
//var valor_adelanto=nuevo_bruto;

document.form1.valor_iva_oc.value= valor_iva.toFixed(2);
document.form1.fte_oc.value=valor_const_fte.toFixed(2);
document.form1.fte_iva_oc.value=valor_const_fte_iva.toFixed(2);
document.form1.fte_ica_oc.value=valor_const_fte_ica.toFixed(2); 
document.form1.valor_bruto_oc.value= nuevo_bruto;

}
$total=parseFloat(nuevo_bruto+valor_iva)-parseFloat(valor_const_fte+valor_const_fte_iva+valor_const_fte_ica);
$valor_total=$total.toFixed(2); 
document.form1.total_oc.value=$valor_total;
}*/

function detalle()
{
	$valor=parseFloat(document.form1.valor_unitario_det.value);
	$cantidad=parseFloat(document.form1.cantidad_det.value);
	$descuento=parseFloat(document.form1.descuento_det.value);
	var const_iva=parseFloat(document.form1.constante_iva.value);
	var valor_iva =0;
	if($descuento!='0' || $descuento!='0,00')
	{
		var total1=(($cantidad*$valor)-$descuento);
		var total2=Math.round(total1*100)/100;
	}
	else
	{
		var total1=($cantidad*$valor);
		var total2=Math.round(total1*100)/100;
	}
	var valor_iva=(total2*const_iva/100); 
	document.form1.valor_iva.value=valor_iva.toFixed(2);
	document.form1.subtotal_det.value=total2.toFixed(2);
	document.form1.total_det.value=(total2+valor_iva).toFixed(2);

}

/*function detalle()
{
$valor=parseFloat(document.form1.valor_unitario_det.value);
$cantidad=parseFloat(document.form1.cantidad_det.value);
$descuento=parseFloat(document.form1.descuento_det.value);
if($descuento!='0')
{
$total1=(($cantidad*$valor)*$descuento)/100;
$total2=(($cantidad*$valor)-$total1);
$total3=Math.round($total2*100)/100;
document.form1.total_det.value=$total3;
}
else
{
$total1=($cantidad*$valor);
$total2=Math.round($total1*100)/100;
document.form1.total_det.value=$total2;
}
}*/

function detalle_ing()
{
	var inventario=parseFloat(document.form1.inventario.value); 
	var cantidad=parseFloat(document.form1.cantidad.value);
	var existente=parseFloat(document.form1.existente.value);
	var ingreso=parseFloat(document.form1.ingreso_ing.value); 

var existmasIngreso=(existente+ingreso);//se suma lo que existe mas lo que se esta ingresando para controlar que no sobrepase lo solicitado
if(existmasIngreso > cantidad){
	alert("La cantindad ingresada no puede superar la cantidad solicitada !!!")	
	document.form1.ingreso_ing.focus();
	return false;
}else{
	var total=(inventario+ingreso);
	var grantotal=total.toFixed(2); 
	document.form1.total_det.value=grantotal; 
	return true;
}
}

function detalle_oc()
{
	window.location ='orden_compra_edit_detalle.php?id_det='+document.form1.id_det.value+'&id_insumo='+document.form1.id_insumo_det.value;
}
function verificacion()
{
	window.location ='verificacion_insumo_add.php?n_oc='+document.form1.n_oc_vi.value+'&id_insumo='+document.form1.id_insumo_vi.value;
}
function faltantes()
{
	$pedida=parseFloat(document.form1.cantidad_solicitada_vi.value);
	$recibida=parseFloat(document.form1.cantidad_recibida_vi.value);
	$saldo=parseFloat(document.form1.saldo_anterior_vi.value);
	if($saldo>'0')
	{
		$falta1=$saldo-$recibida;	
	}
	else
	{
		$falta1=$pedida-$recibida;	
	}
	if($falta1<'0')
		{ document.form1.faltantes_vi.value=0; }
	else {
		$falta2=Math.round($falta1*100)/100;	
		document.form1.faltantes_vi.value=$falta2; }
	}
	function ocr_total()
	{
		$cantidad=parseFloat(document.form1.cantidad_ocr.value);
		$unitario=parseFloat(document.form1.valor_unitario_ocr.value);
		$neto=($cantidad*$unitario);
		document.form1.valor_neto_ocr.value=Math.round($neto*100)/100;	
		$iva=($neto*16)/100;
		document.form1.iva_ocr.value=Math.round($iva*100)/100;
		$total=($neto+$iva);
		document.form1.valor_total_ocr.value=Math.round($total*100)/100;
	}
	function ocr_calibremillas()
	{
		$micras=parseFloat(document.form1.calibre_micras_ocr.value);
		$millas=($micras)/25.4;
		document.form1.calibre_millas_ocr.value=Math.round($millas*100)/100;
	}
	/*VERIFICACION ROLLLOS*/
	function vr_cantidad()
	{
		if(document.form1.saldo_verificacion_ocr.value != '' && document.form1.cantidad_encontrada_vr.value != '')
		{
			$saldo=parseFloat(document.form1.saldo_verificacion_ocr.value);
			$encontrada=parseFloat(document.form1.cantidad_encontrada_vr.value);
			$conforme=document.form1.cantidad_no_conforme_vr.value;
			if($saldo!='0' && $encontrada!='0')
			{
				$falta1=$saldo-$encontrada;
				if($falta1<='0')
				{
					document.form1.faltantes_vr.value=0; 
				}
				else
				{
					$falta2=Math.round($falta1*100)/100;
					document.form1.faltantes_vr.value=$falta2;
				}
			}
			if($conforme=='' || $conforme=='0') 
				{ document.form1.cantidad_cumple_vr.value=1; }
			if($conforme!='' && $conforme!='0') 
				{ document.form1.cantidad_cumple_vr.value=0; }		
			$cumple=($encontrada/$saldo)*100;
			if($cumple>='90') { document.form1.entrega_vr.value=1; }
			if($cumple<'90') { document.form1.entrega_vr.value=0; }		
		}
		else { document.form1.cantidad_cumple_vr.value=2; }	
	}
	/*CALCULAR CALIBRE*/
	function vr_calibre()
	{
		if(document.form1.calibre_encontrado_vr.value=='')
		{
			document.form1.calibre_cumple_vr.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.calibre_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.calibre_encontrado_vr.value);
			$conforme=document.form1.calibre_no_conforme_vr.value;
			if($conforme=='0' || $conforme=='')
			{      
				$mas10=$solicitado+10;
				$menos10=$solicitado-10;
				if($encontrado<=$mas10 && $encontrado>=$menos10)
				{
					document.form1.calibre_cumple_vr.value=1;
				}
				else
				{
					document.form1.calibre_cumple_vr.value=0;
				}
			}
			else
			{
				document.form1.calibre_cumple_vr.value=0;
			}
		}
	}
	/*CALCULAR PESO*/
	function vr_peso()
	{
		if(document.form1.peso_encontrado_vr.value=='')
		{ 
			document.form1.peso_cumple_vr.value=2;
			document.form1.peso_no_conforme_vr.value='';
		}
		else
		{
			$solicitado=parseFloat(document.form1.peso_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.peso_encontrado_vr.value);
			$conforme=document.form1.peso_no_conforme_vr.value;
			if($conforme=='0' || $conforme=='')
			{
				$cumple=($encontrado/$solicitado)*100;
				if($cumple>='90')
				{
					document.form1.peso_cumple_vr.value=1;
				}
				if($cumple<'90')
				{
					document.form1.peso_cumple_vr.value=0;
				}
			}
			else
			{
				document.form1.peso_cumple_vr.value=0;
			}
		}	
	}
	/*CALCULAR ANCHO*/
	function vr_ancho()
	{
		if(document.form1.ancho_encontrado_vr.value=='')
		{ 
			document.form1.ancho_cumple_vr.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.ancho_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.ancho_encontrado_vr.value);
			$conforme=document.form1.ancho_no_conforme_vr.value;
			if($conforme=='0' || $conforme=='')
			{
				$encontrado1=$encontrado+1;
				$encontrado2=$encontrado-1;
				if($solicitado>=$encontrado2 && $solicitado<=$encontrado1)			
				{
					document.form1.ancho_cumple_vr.value=1;
				}
				else
				{
					document.form1.ancho_cumple_vr.value=0;
				}
			}
			else
			{
				document.form1.ancho_cumple_vr.value=0;
			}
		}	
	}
	/*CALCULAR RODILLO*/
	function vr_rodillo()
	{
		if(document.form1.rodillo_encontrado_vr.value=='')
		{ 
			document.form1.rodillo_cumple_vr.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.rodillo_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.rodillo_encontrado_vr.value);
			$conforme=document.form1.rodillo_no_conforme_vr.value;
			if($conforme=='0' || $conforme=='')
			{			
				if($solicitado==$encontrado)
				{
					document.form1.rodillo_cumple_vr.value=1;
				}
				else
				{
					document.form1.rodillo_cumple_vr.value=0;
				}
			}
			else
			{
				document.form1.rodillo_cumple_vr.value=0;
			}
		}	
	}
	/*CALCULAR TRATAMIENTO*/
	function vr_tratamiento()
	{
		if(document.form1.tratamiento_encontrado_vr.value=='')
		{ 
			document.form1.tratamiento_cumple_vr.value=2;	   
		}
		else
		{
			$encontrado=parseFloat(document.form1.tratamiento_encontrado_vr.value);
			$conforme=document.form1.tratamiento_no_conforme_vr.value;		
			if($conforme=='0' || $conforme=='')
			{
				if($encontrado>='38' && $encontrado<='42')
				{
					document.form1.tratamiento_cumple_vr.value=1;
				}
				else
				{
					document.form1.tratamiento_cumple_vr.value=0;
				}
			}
			else
			{
				document.form1.tratamiento_cumple_vr.value=0;
			}
		}
	}
	/*RESISTENCIA AL RASGADO MD*/
	function vr_md()
	{
		if(document.form1.md_solicitado_vr.value=='' && document.form1.md_encontrado_vr.value=='')
		{ 
			document.form1.md_cumple_vr.value=2;	   
		}
		else
		{
			$solicitado=parseFloat(document.form1.md_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.md_encontrado_vr.value);
			$conforme=document.form1.md_no_conforme_vr.value;		
			if($conforme=='0' || $conforme=='')
			{
				if($encontrado>=$solicitado)
				{
					document.form1.md_cumple_vr.value=1;
				}
				else
				{
					document.form1.md_cumple_vr.value=0;
				}			
			}
			else
			{
				document.form1.md_cumple_vr.value=0;
			}
		}
	}
	/*RESISTENCIA DEL RASGADO TD*/
	function vr_td()
	{
		if(document.form1.td_solicitado_vr.value=='' && document.form1.td_encontrado_vr.value=='')
		{ 
			document.form1.td_cumple_vr.value=2;  
		}
		else
		{
			$solicitado=parseFloat(document.form1.td_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.td_encontrado_vr.value);
			$conforme=document.form1.td_no_conforme_vr.value;		
			if($conforme=='0' || $conforme=='')
			{
				if($encontrado>=$solicitado)
				{
					document.form1.td_cumple_vr.value=1;
				}
				else
				{
					document.form1.td_cumple_vr.value=0;
				}			
			}
			else
			{
				document.form1.td_cumple_vr.value=0;
			}
		}
	}
	/*ANGULO DE DESLIZAMIENTO*/
	function vr_angulo()
	{
		if(document.form1.angulo_solicitado_vr.value=='' && document.form1.angulo_encontrado_vr.value=='') 
			{ document.form1.angulo_cumple_vr.value=2; }
		else {
			$solicitado=parseFloat(document.form1.angulo_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.angulo_encontrado_vr.value);
			$conforme=document.form1.angulo_no_conforme_vr.value;		
			if($conforme=='0' || $conforme=='')
			{
				if($encontrado>=$solicitado)
					{  document.form1.angulo_cumple_vr.value=1; }
				else
					{  document.form1.angulo_cumple_vr.value=0; }
			}
			else
				{ document.form1.angulo_cumple_vr.value=0; }
		}
	}
	/*FUERZA DE SELLE*/
	function vr_fuerzaselle()
	{
		if(document.form1.fuerzaselle_solicitado_vr.value=='' && document.form1.fuerzaselle_encontrado_vr.value=='') 
			{ document.form1.fuerzaselle_cumple_vr.value=2; }
		else {
			$solicitado=parseFloat(document.form1.fuerzaselle_solicitado_vr.value);
			$encontrado=parseFloat(document.form1.fuerzaselle_encontrado_vr.value);
			$conforme=document.form1.fuerzaselle_no_conforme_vr.value;		
			if($conforme=='0' || $conforme=='')
			{
				if($encontrado>=$solicitado)
					{ document.form1.fuerzaselle_cumple_vr.value=1; }
				else
					{ document.form1.fuerzaselle_cumple_vr.value=0; } 
			}
			else
				{ document.form1.fuerzaselle_cumple_vr.value=0; }
		}
	}
	/*SUMA DE TOTALES*/
	function vr_calificacion()
	{
		$calificacion=0;
		$cal=0;
		if(document.form1.cantidad_cumple_vr.value!='2')
		{
			$cantidad=parseFloat(document.form1.cantidad_cumple_vr.value);
			$calificacion=$calificacion+$cantidad;
			$cal=$cal+1;
		}
		if(document.form1.calibre_cumple_vr.value!='2')
		{
			$calibre=parseFloat(document.form1.calibre_cumple_vr.value);
			$calificacion=$calificacion+$calibre;
			$cal=$cal+1;
		}
		if(document.form1.peso_cumple_vr.value!='2')
		{
			$peso=parseFloat(document.form1.peso_cumple_vr.value);
			$calificacion=$calificacion+$peso;
			$cal=$cal+1;
		}
		if(document.form1.ancho_cumple_vr.value!='2')
		{
			$ancho=parseFloat(document.form1.ancho_cumple_vr.value);
			$calificacion=$calificacion+$ancho;
			$cal=$cal+1;
		}
		if(document.form1.rodillo_cumple_vr.value!='2')
		{
			$rodillo=parseFloat(document.form1.rodillo_cumple_vr.value);
			$calificacion=$calificacion+$rodillo;
			$cal=$cal+1;
		}
		if(document.form1.tratamiento_cumple_vr.value!='2')
		{
			$tratamiento=parseFloat(document.form1.tratamiento_cumple_vr.value);
			$calificacion=$calificacion+$tratamiento;
			$cal=$cal+1;
		}
		if(document.form1.md_cumple_vr.value!='2')
		{
			$md=parseFloat(document.form1.md_cumple_vr.value);
			$calificacion=$calificacion+$md;
			$cal=$cal+1;
		}
		if(document.form1.td_cumple_vr.value!='2')
		{
			$td=parseFloat(document.form1.td_cumple_vr.value);
			$calificacion=$calificacion+$td;
			$cal=$cal+1;
		}
		if(document.form1.angulo_cumple_vr.value!='2')
		{
			$angulo=parseFloat(document.form1.angulo_cumple_vr.value);
			$calificacion=$calificacion+$angulo;
			$cal=$cal+1;
		}
		if(document.form1.fuerzaselle_cumple_vr.value!='2')
		{
			$fuerzaselle=parseFloat(document.form1.fuerzaselle_cumple_vr.value);
			$calificacion=$calificacion+$fuerzaselle;
			$cal=$cal+1;
		}
		if(document.form1.apariencia_cumple_vr.value!='2')
		{
			$apariencia=parseFloat(document.form1.apariencia_cumple_vr.value);
			$calificacion=$calificacion+$apariencia;
			$cal=$cal+1;
		}
		if(document.form1.resistencia_sellos_cumple_vr.value!='2')
		{
			$resistencia_sellos=parseFloat(document.form1.resistencia_sellos_cumple_vr.value);
			$calificacion=$calificacion+$resistencia_sellos;
			$cal=$cal+1;
		}
		if(document.form1.impresion_cumple_vr.value!='2')
		{
			$impresion=parseFloat(document.form1.impresion_cumple_vr.value);
			$calificacion=$calificacion+$impresion;
			$cal=$cal+1;
		}
		if(document.form1.color_cumple_vr.value!='2')
		{
			$color=parseFloat(document.form1.color_cumple_vr.value);
			$calificacion=$calificacion+$color;
			$cal=$cal+1;
		}
		if(document.form1.tinta_cumple_vr.value!='2')
		{
			$tinta=parseFloat(document.form1.tinta_cumple_vr.value);
			$calificacion=$calificacion+$tinta;
			$cal=$cal+1;
		}
		$numero=($calificacion/$cal)*100;
		document.form1.calificacion_vr.value=Math.round($numero*100)/100;
	}
	/*O.C. BOLSA*/
	function ocb_total()
	{
		$cantidad=parseFloat(document.form1.cantidad_ocb.value);
		$unitario=parseFloat(document.form1.valor_unitario_ocb.value);
		$neto=($cantidad*$unitario);
		document.form1.valor_neto_ocb.value=Math.round($neto*100)/100;	
		$iva=($neto*19)/100;
		document.form1.valor_iva_ocb.value=Math.round($iva*100)/100;
		$total=($neto+$iva);
		document.form1.valor_total_ocb.value=Math.round($total*100)/100;
	}
	function ocb_calibremillas()
	{
		$micras=parseFloat(document.form1.calibre_micras_ocb.value);
		$millas=($micras)/25.4;
		document.form1.calibre_ocb.value=Math.round($millas*100)/100;
	}
	function ocb_calibremicras()
	{
		$millas=parseFloat(document.form1.calibre_ocb.value);
		$micras=$millas*25.4;
		document.form1.calibre_micras_ocb.value=Math.round($micras*100)/100;
	}
	/*VERIFICACION BOLSAS*/
	function vb_cantidad()
	{
		if(document.form1.saldo_verificacion_ocb.value!='' && document.form1.cantidad_encontrada_vb.value!='')
		{
			$saldo=parseFloat(document.form1.saldo_verificacion_ocb.value);
			$encontrada=parseFloat(document.form1.cantidad_encontrada_vb.value);
			$conforme=document.form1.cantidad_no_conforme_vb.value;
			if($saldo!='0' && $encontrada!='0')
			{
				$falta1=$saldo-$encontrada;
				if($falta1<='0')
				{
					document.form1.faltantes_vb.value=0; 
				}
				else
				{
					$falta2=Math.round($falta1*100)/100;
					document.form1.faltantes_vb.value=$falta2;
				}
			}
			if($conforme=='' || $conforme=='0') 
				{ document.form1.cantidad_cumple_vb.value=1; }
			if($conforme!='' && $conforme!='0') 
				{ document.form1.cantidad_cumple_vb.value=0; }		
			$cumple=($encontrada/$saldo)*100;
			if($cumple>='90') { document.form1.entrega_vb.value=1; }
			if($cumple<'90') { document.form1.entrega_vb.value=0; }
		}
		else { document.form1.cantidad_cumple_vb.value=2; }	
	}
	/*CALCULAR CALIBRE*/
	function vb_calibre()
	{
		if(document.form1.calibre_encontrado_vb.value=='')
			{ document.form1.calibre_cumple_vb.value=2; }
		else
		{
			$solicitado=parseFloat(document.form1.calibre_solicitado_vb.value);
			$encontrado=parseFloat(document.form1.calibre_encontrado_vb.value);
			$conforme=document.form1.calibre_no_conforme_vb.value;
			if($conforme=='0' || $conforme=='')
			{      
				$mas10=$solicitado+10;
				$menos10=$solicitado-10;
				if($encontrado<=$mas10 && $encontrado>=$menos10)
					{ document.form1.calibre_cumple_vb.value=1; }
				else { document.form1.calibre_cumple_vb.value=0; }
			} else { document.form1.calibre_cumple_vb.value=0; }
		}
	}
	/*CALCULAR ANCHO*/
	function vb_ancho()
	{
		if(document.form1.ancho_encontrado_vb.value=='')
		{ 
			document.form1.ancho_cumple_vb.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.ancho_solicitado_vb.value);
			$encontrado=parseFloat(document.form1.ancho_encontrado_vb.value);
			$conforme=document.form1.ancho_no_conforme_vb.value;
			if($conforme=='0' || $conforme=='')
			{
				$encontrado1=$encontrado+0.5;
				$encontrado2=$encontrado-0.5;
				if($solicitado>=$encontrado2 && $solicitado<=$encontrado1)			
					{ document.form1.ancho_cumple_vb.value=1; }
				else { document.form1.ancho_cumple_vb.value=0; }
			}
			else { document.form1.ancho_cumple_vb.value=0; }
		}	
	}
	/*CALCULAR LARGO*/
	function vb_largo()
	{
		if(document.form1.largo_encontrado_vb.value=='')
		{ 
			document.form1.largo_cumple_vb.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.largo_solicitado_vb.value);
			$encontrado=parseFloat(document.form1.largo_encontrado_vb.value);
			$conforme=document.form1.largo_no_conforme_vb.value;
			if($conforme=='0' || $conforme=='')
			{
				$encontrado1=$encontrado+1;
				$encontrado2=$encontrado-1;
				if($solicitado>=$encontrado2 && $solicitado<=$encontrado1)			
					{ document.form1.largo_cumple_vb.value=1; }
				else { document.form1.largo_cumple_vb.value=0; }
			}
			else { document.form1.largo_cumple_vb.value=0; }
		}	
	}
	/*CALCULAR SOLAPA*/
	function vb_solapa()
	{
		if(document.form1.solapa_encontrada_vb.value=='')
		{ 
			document.form1.solapa_cumple_vb.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.solapa_solicitada_vb.value);
			$encontrado=parseFloat(document.form1.solapa_encontrada_vb.value);
			$conforme=document.form1.solapa_no_conforme_vb.value;
			if($conforme=='0' || $conforme=='')
			{
				$encontrado1=$encontrado+1;
				$encontrado2=$encontrado-1;
				if($solicitado>=$encontrado2 && $solicitado<=$encontrado1)			
					{ document.form1.solapa_cumple_vb.value=1; }
				else { document.form1.solapa_cumple_vb.value=0; }
			}
			else { document.form1.solapa_cumple_vb.value=0; }
		}	
	}
	/*CALCULAR FUELLE*/
	function vb_fuelle()
	{
		if(document.form1.fuelle_encontrado_vb.value=='')
		{ 
			document.form1.fuelle_cumple_vb.value=2;
		}
		else
		{
			$solicitado=parseFloat(document.form1.fuelle_solicitado_vb.value);
			$encontrado=parseFloat(document.form1.fuelle_encontrado_vb.value);
			$conforme=document.form1.fuelle_no_conforme_vb.value;
			if($conforme=='0' || $conforme=='')
			{
				$fuelle1=($encontrado/$solicitado)*100;
				if($fuelle1>='90')	
					{ document.form1.fuelle_cumple_vb.value=1; }
				else { document.form1.fuelle_cumple_vb.value=0; }
			}
			else { document.form1.fuelle_cumple_vb.value=0; }
		}
	}
	/*SUMA DE TOTALES*/
	function vb_calificacion()
	{
		$calificacion=0;
		$cal=0;
		if(document.form1.cantidad_cumple_vb.value!='2')
		{
			$cantidad=parseFloat(document.form1.cantidad_cumple_vb.value);
			$calificacion=$calificacion+$cantidad;
			$cal=$cal+1;
		}
		if(document.form1.calibre_cumple_vb.value!='2')
		{
			$calibre=parseFloat(document.form1.calibre_cumple_vb.value);
			$calificacion=$calificacion+$calibre;
			$cal=$cal+1;
		}	
		if(document.form1.ancho_cumple_vb.value!='2')
		{
			$ancho=parseFloat(document.form1.ancho_cumple_vb.value);
			$calificacion=$calificacion+$ancho;
			$cal=$cal+1;
		}
		if(document.form1.largo_cumple_vb.value!='2')
		{
			$largo=parseFloat(document.form1.largo_cumple_vb.value);
			$calificacion=$calificacion+$largo;
			$cal=$cal+1;
		}
		if(document.form1.solapa_cumple_vb.value!='2')
		{
			$solapa=parseFloat(document.form1.solapa_cumple_vb.value);
			$calificacion=$calificacion+$solapa;
			$cal=$cal+1;
		}
		if(document.form1.fuelle_cumple_vb.value!='2')
		{
			$fuelle=parseFloat(document.form1.fuelle_cumple_vb.value);
			$calificacion=$calificacion+$fuelle;
			$cal=$cal+1;
		}	
		if(document.form1.empaque_cumple_vb.value!='2')
		{
			$empaque=parseFloat(document.form1.empaque_cumple_vb.value);
			$calificacion=$calificacion+$empaque;
			$cal=$cal+1;
		}
		if(document.form1.apariencia_cumple_vb.value!='2')
		{
			$apariencia=parseFloat(document.form1.apariencia_cumple_vb.value);
			$calificacion=$calificacion+$apariencia;
			$cal=$cal+1;
		}
		if(document.form1.resistencia_cumple_vb.value!='2')
		{
			$resistencia=parseFloat(document.form1.resistencia_cumple_vb.value);
			$calificacion=$calificacion+$resistencia;
			$cal=$cal+1;
		}	
		if(document.form1.tratamiento_cumple_vb.value!='2')
		{
			$tratamiento=parseFloat(document.form1.tratamiento_cumple_vb.value);
			$calificacion=$calificacion+$tratamiento;
			$cal=$cal+1;
		}
		$numero=($calificacion/$cal)*100;
		document.form1.calificacion_vb.value=Math.round($numero*100)/100;
	}
	function subtotal()
	{
		$var1=parseInt(document.form1.cantidad_pedido.value);
		$var2=parseInt(document.form1.valor_unitario_pedido.value);
		$var3=$var1*$var2;
		document.form1.subtotal_pedido.value=Math.round($var3*100)/100 ;
	}
	/*-------------------------------------------------*/
	/*-------------GESTION DE PRODUCCION NUMERACION SELLADO---------------*/
	function sumaNumeracion()
	{
		var inicio =(document.form1.int_desde_n.value);
		var hasta = (document.form1.int_hasta_n.value);
		var paqu =parseFloat(document.form1.int_bolsas_n.value);	
		var int=/([0-9\s\\]+)/i;
		var varchar = /[A-Za-z1-1\s]/i;
		var char = /([A-Za-z\s\\]+)/i;
//var inicio = inici.split("");
var letr="";num="";a="";b="";c="";d="";e="";f="";g="";h="";
var numeros="0123456789";

var z=(inicio.search(/AA1F|AA1G|AA1H|AA1I|AA1J|AA1K|AA1L|AA1M|AA1N|AA1B|AA1C|AA1D|AA1E/i));
if(z=='0'){
	var v = inicio; 
	var cad = v.substring(0,4);
	var num = v.substring(4);
	
	var paq=(paqu-1);
	var tnum=parseInt(num )+(paq);		
	document.form1.int_hasta_n.value=cad+tnum;	
	
		//alert('variable: '+cad+' '+num);
	}else{
		for(i=0; i<inicio.length; i++){
			f = inicio[i+1];
			if (numeros.indexOf(inicio.charAt(i),0)!=-1){		  
				c+=inicio[i]
				e+=f	 
				a=c
			}else{a=c;}
	//document.form1.int_hasta_n.value=parseInt (a)+ parseInt (e);  
}

   //var letras="abcdefghyjklmn�opqrstuvwxyz";
   var letras="ABCDEFGHIJKLMNNOPQRSTUVWXYZ";
   inicio = inicio.toUpperCase();
   for(x=0; x<inicio.length; x++){
   	if (letras.indexOf(inicio.charAt(x),0)!=-1){
   		d+=inicio[x]
   		b=d
   	}else{b=d;}
   	
	  //document.form1.int_hasta_n.value=g;
	}   
/*        h= b+a;
var as=(h.substring(0,4));*/
var paq=(paqu-1);
var tnum=parseInt(a)+(paq);		
document.form1.int_hasta_n.value=b+tnum;

		}//FIN SI NO CONTIENE LAS SUBCADENAS 
	}
	function hastaEdit()
	{
		var inicio =(document.form1.int_desde_tn.value);
		var hasta = (document.form1.int_hasta_tn.value);
		var paqu =parseFloat(document.form1.int_undxpaq_tn.value);	
		var int=/([0-9\s\\]+)/i;
		var varchar = /[A-Za-z1-1\s]/i;
		var char = /([A-Za-z\s\\]+)/i;
//var inicio = inici.split("");
var letr="";num="";a="";b="";c="";d="";e="";f="";g="";h="";
var numeros="0123456789";

var z=(inicio.search(/AA1F|AA1G|AA1H|AA1I|AA1J|AA1K|AA1L|AA1M|AA1N|AA1B|AA1C|AA1D|AA1E/i));
if(z=='0'){
	var v = inicio; 
	var cad = v.substring(0,4);
	var num = v.substring(4);
	
	var paq=(paqu-1);
	var tnum=parseInt(num )+(paq);		
	document.form1.int_hasta_tn.value=cad+tnum;		

		//alert('variable: '+cad+' '+num);
	}else{

		for(i=0; i<inicio.length; i++){
			f = inicio[i+1];
			if (numeros.indexOf(inicio.charAt(i),0)!=-1){		  
				c+=inicio[i]
				e+=f	 
				a=c
			}else{a=c;}
	//document.form1.int_hasta_n.value=parseInt (a)+ parseInt (e); 
	//document.form1.int_hasta_tn.value=cad+tnum; 
}

   //var letras="abcdefghyjklmn�opqrstuvwxyz";
   var letras="ABCDEFGHIJKLMNNOPQRSTUVWXYZ";
   inicio = inicio.toUpperCase();
   for(x=0; x<inicio.length; x++){
   	if (letras.indexOf(inicio.charAt(x),0)!=-1){
   		d+=inicio[x]
   		b=d
   	}else{b=d;} 
   	
	  //document.form1.int_hasta_n.value=g;
	}   
	var paq=(paqu-1);
	var tnum=parseInt(a)+(paq);		
	document.form1.int_hasta_tn.value=b+tnum;

		}//FIN SI NO CONTIENE LAS SUBCADENAS

	}
//FIN PRODUCCION

//COSTOS
function cargarop()
{
	window.location ='costos_op_add.php?id_op='+document.form1.id_op.value+'&fechafin='+document.form1.fechafin.value;
}
function consulta_gga_fechas(selec)
{
	window.location ='costos_gga_add.php?FechaInicio='+document.form1.FechaInicio.value+'&FechaFin='+document.form1.FechaFin.value;
}
function consulta_cm(selec) 
{
	window.location ='costos_referencia_cm2.php?ref='+document.form1.ref.value;
}
function consulta_gga_mensual(selec)
{
	window.location ='costos_listado_gga2.php?mensual='+document.form1.mensual.value+'&fecha='+document.form1.fecha.value;
}
function consulta_costo_mensual(selec)
{
	window.location ='costos_listado_ggaycif2.php?mensual='+document.form1.mensual.value+'&fecha='+document.form1.fecha.value;
}
function empleadodias() 
{
	var horasdialaborales = document.form1.horas_empleado.value;
						 var dias=parseInt(document.form1.dias_fp.value);//dias 365
						 var dominicales=parseInt(document.form1.domin_fest_fp.value);//dias 70
						 var vacaciones=parseInt(document.form1.vacacion_fp.value);//dias 15
						 var diasRealespormes=dias - parseFloat(dominicales+vacaciones);//280
						 var diames=diasRealespormes/12; 
						 var horasalmes=diames*horasdialaborales;  
						 document.form1.diasmes_reales.value =  diames;
						 document.form1.horasmes_reales.value =  horasalmes;
						}
						function factor_prestacional(){
							var dias=parseInt(document.form1.dias_fp.value);
							var domin_fest=parseInt(document.form1.domin_fest_fp.value);
							var vacacional=parseInt(document.form1.vacacion_fp.value);
							var dif_dias=(dias - domin_fest);
							document.form1.dif_dom_fp.value = dif_dias; 
							var dias_real=(dif_dias - vacacional);
							document.form1.dia_real_fp.value = dias_real;
							var dif_vac=(dias_real / 12); 
							ndif_vac=NaNAZero(dif_vac);
							document.form1.dif_vac_fp.value = ndif_vac;
							var hora_lab =(dif_vac * 8);
							nhora_lab=NaNAZero(hora_lab);
							document.form1.hora_lab_fp.value = nhora_lab; 
						}
						function NaNAZero(n){  
							return isNaN( n ) ? 0 : n;  
						}
//PROMEDIO NORMAL 100%
function totalGGAyCIF(){
	//PARCIAL
	var TotalGGA_parcial=parseFloat(document.form1.TotalGGA_parcial.value);
	var porc_parcial=parseInt(document.form1.porc_parcial.value);
	var totalPorc=(TotalGGA_parcial*porc_parcial)/100;
	var totalParcial=totalPorc.toFixed(2);
	document.form1.gga_parcial.value=totalParcial;
	//IMOPRESION
	var TotalGGA_impresion=parseFloat(document.form1.TotalGGA_impresion.value);
	var porc_impresion=parseInt(document.form1.porc_impresion.value);
	var totalPorc=(TotalGGA_impresion*porc_impresion)/100;
	var totalImpresion=totalPorc.toFixed(2);
	document.form1.gga_impresion.value=totalImpresion; 
}

function consulta_gga_ajuste()
{
	var gga250=parseInt(document.getElementById('real_250').value)-parseFloat(document.getElementById('ajuste_250').value);
	var gga500=parseInt(document.getElementById('real_500').value)-parseFloat(document.getElementById('ajuste_500').value);
	var gga1000=parseInt(document.getElementById('real_1000').value)-parseFloat(document.getElementById('ajuste_1000').value);
	var gga4000=parseInt(document.getElementById('real_4000').value)-parseFloat(document.getElementById('ajuste_4000').value);
	var Tgga250=gga250.toFixed(2);
	var Tgga500=gga500.toFixed(2);
	var Tgga1000=gga1000.toFixed(2);
	var Tgga4000=gga4000.toFixed(2);
	document.getElementById('gga_250').value=Tgga250;
	document.getElementById('gga_500').value=Tgga500;
	document.getElementById('gga_1000').value=Tgga1000;
	document.getElementById('gga_4000').value=Tgga4000;
}
//PROMEDIO PARCIAL
function promedioUnidadParcial(){
var TotalGGA_parcial=parseFloat(document.form1.gga_parcial.value);//tomo el que tiene el descuento gga_parcial
var bolsas=parseInt(document.form1.bolsas_parcial.value);
var totalProm=(TotalGGA_parcial/bolsas);
var PromedioParcial=totalProm.toFixed(2);
document.form1.CostoGGAxUn_parcial.value=PromedioParcial;
//promedio parcial
var enteroPromedio=totalProm.toFixed();
document.getElementById('promedio_250_parcial').value=enteroPromedio;
document.getElementById('promedio_500_parcial').value=enteroPromedio;
document.getElementById('promedio_1000_parcial').value=enteroPromedio;
document.getElementById('promedio_4000_parcial').value=enteroPromedio;
}
function consulta_gga_ajuste_parcial()
{
	 //MODULO PARA SACAR EL VALOR REAL
	 var CostoGGAxUn_parcial=parseInt(document.getElementById('CostoGGAxUn_parcial').value);
var cons='1000';//constante tope maximo de area de la bolsa
var	dc = CostoGGAxUn_parcial*parseInt(document.getElementById('dc').value)/cons;
var	dq = CostoGGAxUn_parcial*parseInt(document.getElementById('dq').value)/cons;
var	qm = CostoGGAxUn_parcial*parseInt(document.getElementById('qm').value)/cons;
var	mc = CostoGGAxUn_parcial*parseInt(document.getElementById('mc').value)/cons;	
var DC=dc.toFixed(); 
var DQ=dq.toFixed();
var DM=qm.toFixed();
var MC=mc.toFixed();	
	 (document.getElementById('real_250_parcial').value = DC);//inserto cada valor en cada input
	 (document.getElementById('real_500_parcial').value = DQ);
	 (document.getElementById('real_1000_parcial').value = DM);
	 (document.getElementById('real_4000_parcial').value = MC);	  
//FIN MODULO	
//MOSTRAR EL COSTO GGA Y CIF PARCIAL	
var gga250=dc-parseFloat(document.getElementById('ajuste_250_parcial').value);
var gga500=dq-parseFloat(document.getElementById('ajuste_500_parcial').value);
var gga1000=qm-parseFloat(document.getElementById('ajuste_1000_parcial').value);
var gga4000=mc-parseFloat(document.getElementById('ajuste_4000_parcial').value);

var Tgga250=gga250.toFixed(2); 
var Tgga500=gga500.toFixed(2);
var Tgga1000=gga1000.toFixed(2);
var Tgga4000=gga4000.toFixed(2);
document.getElementById('gga_250_parcial').value=Tgga250;
document.getElementById('gga_500_parcial').value=Tgga500;
document.getElementById('gga_1000_parcial').value=Tgga1000;
document.getElementById('gga_4000_parcial').value=Tgga4000;
	//FIN MODULO
}
//PROMEDIO PARCIAL SIN IMPRESION
function promedioUnidadImpresion(){
var TotalGGA_impresion=parseFloat(document.form1.gga_impresion.value);//tomo el que tiene el descuento gga_impresion
var bolsas=parseInt(document.form1.bolsas_impresion.value);
var totalProm=(TotalGGA_impresion/bolsas);
var PromedioImpresion=totalProm.toFixed(2);
document.form1.CostoGGAxUn_impresion.value=PromedioImpresion;
//promedio parcial
var enteroPromedio=totalProm.toFixed();
document.getElementById('promedio_250_impresion').value=enteroPromedio;
document.getElementById('promedio_500_impresion').value=enteroPromedio;
document.getElementById('promedio_1000_impresion').value=enteroPromedio;
document.getElementById('promedio_4000_impresion').value=enteroPromedio;
}
function consulta_gga_ajuste_impresion()
{
	 //MODULO PARA SACAR EL VALOR REAL
	 var CostoGGAxUn_impresion=parseInt(document.getElementById('CostoGGAxUn_impresion').value);
var cons='1000';//constante tope maximo de area de la bolsa
var	dc = CostoGGAxUn_impresion*parseInt(document.getElementById('dc').value)/cons;
var	dq = CostoGGAxUn_impresion*parseInt(document.getElementById('dq').value)/cons;
var	qm = CostoGGAxUn_impresion*parseInt(document.getElementById('qm').value)/cons;
var	mc = CostoGGAxUn_impresion*parseInt(document.getElementById('mc').value)/cons;	
	//Tdc=Math.round(dc*100)/100; 
	var DC=dc.toFixed(); 
	var DQ=dq.toFixed();
	var DM=qm.toFixed();
	var MC=mc.toFixed();
	 (document.getElementById('real_250_impresion').value = DC);//inserto cada valor en cada input
	 (document.getElementById('real_500_impresion').value = DQ);
	 (document.getElementById('real_1000_impresion').value = DM);
	 (document.getElementById('real_4000_impresion').value = MC);	
//FIN MODULO	
//MOSTRAR EL COSTO GGA Y CIF PARCIAL	
var gga250=dc-parseFloat(document.getElementById('ajuste_250_impresion').value);
var gga500=dq-parseFloat(document.getElementById('ajuste_500_impresion').value);
var gga1000=qm-parseFloat(document.getElementById('ajuste_1000_impresion').value);
var gga4000=mc-parseFloat(document.getElementById('ajuste_4000_impresion').value);

var Tgga250=gga250.toFixed(2); 
var Tgga500=gga500.toFixed(2);
var Tgga1000=gga1000.toFixed(2);
var Tgga4000=gga4000.toFixed(2);
document.getElementById('gga_250_impresion').value=Tgga250;
document.getElementById('gga_500_impresion').value=Tgga500;
document.getElementById('gga_1000_impresion').value=Tgga1000;
document.getElementById('gga_4000_impresion').value=Tgga4000;
	//FIN MODULO
}
//FIN PROMEDIOS
/*function restar_ajuste() { 
var prom=parseInt(document.getElementById('CostoGGAxUn_parcial').value);
var cons='1000';//constante tope maximo de area de la bolsa
		//var a = new Array();
		//a[0] = parseInt(document.getElementById('dc').value);
		//a[1] = parseInt(document.getElementById('dq').value);
		//a[2] = parseInt(document.getElementById('qm').value);
		//a[3] = parseInt(document.getElementById('mc').value);

		//for (i=0; i<a.length; i++)
		//{
		//var $max=(prom*a[i])/cons; 
		//var resul=$max.toFixed();//redondeo al entero proximo 
    //}
		dc = prom*parseInt(document.getElementById('dc').value)/cons;
		dq = prom*parseInt(document.getElementById('dq').value)/cons;
		qm = prom*parseInt(document.getElementById('qm').value)/cons;
		mc = prom*parseInt(document.getElementById('mc').value)/cons;	
	
	 (document.getElementById('real_250_parcial').value = dc);//inserto cada valor en cada input
	 (document.getElementById('real_500_parcial').value = dq);
	 (document.getElementById('real_1000_parcial').value = qm);
	 (document.getElementById('real_4000_parcial').value = mc);

	
	}*/
/*function consulta_inventario(id_insumo_inv) {
crearObjeto();
if (objeto.readyState != 0) {
alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
} else {
// Preparar donde va a recibir el Resultado
objeto.onreadystatechange = ResultadoInventario;
// Enviar la consulta
objeto.open("GET", "ajax_inventario.php?id_insumo_inv=" + id_insumo_inv, true);
objeto.send(null);
}
}
// -----CARGANDO MATERIA PRIMA
function ResultadoInventario() { 
// Si aun esta revisando los datos...
if (objeto.readyState == 1) {
document.getElementById('inventario').innerHTML = "Carg...";
}
// Si el estado es 4 significa que ya termino
if (objeto.readyState == 4) {
// objeto.responseText trae el Resultado que metemos al DIV de arriba
document.getElementById('inventario').innerHTML = objeto.responseText;
}
}*/
/*function consulta_mano_obra(selec)
{
window.location ='costos_liquidacion_mano_obra2.php?fecha_ini='+document.form1.fecha_ini.value+'&fecha_fin='+document.form1.fecha_fin.value;
} */
/*function consulta_porcen_proceso_mano_obra()
{
window.location ='costos_liquidacion_mano_obra2.php?fecha_ini='+document.form1.fecha_ini.value+'&fecha_fin='+document.form1.fecha_fin.value+'&porcen='+document.form1.porcen.value;
} */
function consulta_ref_xproceso(selec)
{
	window.location ='costos_listado_ref_xproceso2.php?fecha_ini='+document.form1.fecha_ini.value+'&fecha_fin='+document.form1.fecha_fin.value;
}
function consulta_ref_xproceso_tiempos(selec)
{
	window.location ='costos_listado_ref_xproceso_tiempos2.php?fecha_ini='+document.form1.fecha_ini.value+'&fecha_fin='+document.form1.fecha_fin.value;
}
/*function costoDias()
{
var dias=30;
var costoDia=(parseInt(document.form1.sueldo_empleado.value)/dias);	
var totalCosto=(parseInt(document.form1.dias_empleado.value)*costoDia);
var grantotal=totalCosto.toFixed(2); 
document.form1.costo_empleado.value=grantotal;
//return totalCosto;
}*/
function inactivo()
{
	if (document.form1.fechafinal_empleado.value !=''){
		document.getElementById("estado_empleado").value=0; 
//document.form1.estado_empleado.selec=0;
}
}
//FIN COSTOS
/*function consulta_m_op(selec) 
{
window.location ='sellado_control_numeracion.php?id_op='+document.form1.int_op_n.value;
}*/

function numeracionDistinta() 
{ 
	swal("Alerta! " , " la numeracion  de la o.p es distinta del ultimo paquete guardado :)", "error");
 //document.form1.int_desde_tn.disabled =true; 
}
function consulta_m_op(selec) 
{
	window.location ='sellado_control_numeracion_add.php?id_op='+document.form1.int_op_tn.value;
}
function consulta_sellado_op(selec)
{
	window.location ='despacho_direccion2.php?id_op='+document.form1.id_op.value;
}
function consulta_sellado_op_backup(selec)
{
	window.location ='despacho_direccion2_backup.php?id_op='+document.form1.id_op.value;
}
function consulta_sellado_oc(selec) 
{
	window.location ='despacho_direccion2.php?id_oc='+document.form1.id_oc.value;
}
function cajas()
{	
	var bolsa=parseFloat(document.form1.int_bolsas_n.value);
	var undcaja=parseFloat(document.form1.int_undxcaja_n.value);
	if( undcaja<=bolsa ){
		var divc=(bolsa/undcaja);
		document.form1.int_caja_n.value=divc;
		return true;
	}else {
		alert('Los paquetes: '+paq+' no puede ser menor a la cantidad: '+undcaja+' de Cajas !')
		return false;
	}
}
function paquetes()
{	
	var undcaja=parseFloat(document.form1.int_undxcaja_n.value);
	var undpaq=parseFloat(document.form1.int_undxpaq_n.value);
	if(undpaq <= undcaja){
		var div=(undcaja/undpaq);
		document.form1.int_paquete_n.value=div;
		return true;
	}else{
		alert('La unida x paquete: '+undpaq+' no puede ser mayor a la cantidad: '+bolsa+' de Bolsas !')
		return false;
	}
}
function total_paq_edit()
{
	var bolsa=parseFloat(document.form1.int_bolsas_tn.value);	
	var undcaja=parseFloat(document.form1.int_undxcaja_tn.value);
	var undpaq=parseFloat(document.form1.int_undxpaq_tn.value);
	if(undpaq <= undcaja){
		var div=(undcaja/undpaq);
		document.form1.paquetexcaja.value=div;
		return true;
	}else{
		alert('La unida x paquete: '+undpaq+' no puede ser mayor a la cantidad: '+bolsa+' de Bolsas !')
		return false;
	}
}
//COSTOS EXPORTACION
function totalce()
{
	subtotal=parseFloat(document.form1.subtotal_ce.value);
	flete=parseFloat(document.form1.flete_ce.value);
	seguro=parseFloat(document.form1.seguro_ce.value);
	total=(subtotal+flete+seguro);
	var grantotal=total.toFixed(2); 
	document.form1.total_ce.value=grantotal;
}
function detalle_ce()
{
	var precio=parseFloat(document.form1.precio_unid_det.value);
	var cantidad=parseFloat(document.form1.cantidad_det.value);
	var total=(cantidad*precio);
	var grantotal=total.toFixed(2); 
	document.form1.valor_total_det.value=grantotal; 
}
//ESTIQUERS DE ROLLOS EXTRUSION
function consulta_rollo_E(selec) 
{
	window.location ='produccion_extrusion_stiker_rollo_add.php?id_op_r='+document.form1.id_op_r.value;
}
function sumaBanderas()
{
	var rev=( (parseInt(document.form1.reven_r.value) || 0) + (parseInt(document.form1.corte_r.value) || 0) + (parseInt(document.form1.calib_r.value) || 0) + (parseInt(document.form1.arrug_r.value) || 0) + (parseInt(document.form1.medid_r.value) || 0) + (parseInt(document.form1.desca_r.value) || 0) + (parseInt(document.form1.trata_r.value) || 0) + (parseInt(document.form1.montaje_r.value) || 0) + (parseInt(document.form1.apagon_r.value) || 0));
	document.form1.bandera_r.value=rev;
}
//ESTIQUERS DE ROLLOS IMPRESION
function sumaBanderasI(){ 
	var suma = (parseInt(document.form1.desf_r.value)+ parseInt(document.form1.tante_r.value)+ parseInt(document.form1.manch_r.value)+ parseInt(document.form1.color_r.value)+ parseInt(document.form1.empat_r.value)+ parseInt(document.form1.medid_r.value)+ parseInt(document.form1.rasqueta_r.value) + parseInt(document.form1.montaje_r.value) + parseInt(document.form1.apagon_r.value));
	document.form1.bandera_r.value=suma;
}
//ESTIQUERS DE ROLLOS SELLADO
function consulta_rollo_S(selec) 
{
	window.location ='produccion_sellado_stiker_rollo_add.php?id_op_r='+document.form1.id_op_r.value;
}
function consulta_rollo_SEdit(selec)
{
	window.location ='produccion_sellado_stiker_rollo_edit.php?id_op_r='+document.form1.id_op_r.value;
}

//=================================INICIO DE NUMERACION DE TIQUETES=================================// 
function sumaPaqSellado() { 
	var desde=document.form1.int_desde_n.value;
	var bolsas=document.form1.int_bolsas_n.value;
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];         
	var tnum=parseInt(desde)+parseInt(bolsas)-parseInt(1); 
	document.form1.int_hasta_n.value=cadena+tnum; 
} 
function sumaPaqSelladoAdd() { 
	var desde=document.form1.int_desde_tn.value;
	var bolsas=document.form1.int_undxpaq_tn.value;
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];		
	var tnum=parseInt(desde)+parseInt(bolsas)-parseInt(1);
	document.form1.int_hasta_tn.value=cadena+tnum;
}
function sumaPaqSelladoEdit() {
	var desde=document.form1.int_desde_tn.value;
	var bolsas=document.form1.int_undxpaq_tn.value; 
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];		
	var desdemasuno=parseInt(desde) + parseInt(1);
	document.form1.int_desde_tn.value=(cadena+desdemasuno);  
	var tnum=parseInt(desde)+parseInt(bolsas);
	document.form1.int_hasta_tn.value=cadena+tnum;
}
//SELLADO POR TURNO
function sumaNumeracionTurnos() { 
	var inicio=document.form1.numIni_r.value;
	var masuno='1';
	var codigos = divideCadenas(inicio); 
	var inicio = codigos[0];
	var cadena = codigos[1];		
	var tnum=parseInt(inicio)+parseInt(masuno);
	var nuevoinicial=cadena+tnum
	document.form1.numIni_r.value=cadena+nuevoinicial;

/*var fin=document.form1.numFin_r.value; 
var faltante=document.form1.faltante.value;	 
	 var codigos2 = divideCadenas(fin); 
        var fin = codigos2[0];
		var cadena2 = codigos2[1];		
		var tnum2=parseInt(fin)-parseInt(tnum); 
		document.form1.bolsas_r.value=tnum2-faltante; */
	}
function sumaPaqSelladoTiqxCaja() { 
	var desde=document.form1.int_desde_tn.value;
	var caja=document.form1.int_undxcaja_tn.value;
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];		
	var tnum=parseInt(desde)+parseInt(caja)-parseInt(1);
	document.form1.int_hasta_tn.value=cadena+tnum;
}
//ORDEN DE PRODUCCION
function hastaordenP() {
	var desde=document.form1.numInicio_op.value;
    var conletras = desde;
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];		
	var desdemasuno=parseInt(desde) + parseInt(1);
	var hasta=cadena+desdemasuno;
	    var cerosizq = cerosIzquierda(conletras,desdemasuno,desde); //codigos especiales 
		  if(cerosizq!=undefined){
		    var hasta = cadena+cerosizq; 
		  } 
	document.form1.numInicio_op.value=hasta;  
}
function hastaordenTiq() {
	var desde=document.form1.int_desde_tn.value;
    var conletras = desde;
	var codigos = divideCadenas(desde); 
	var desde = codigos[0];
	var cadena = codigos[1];		
	var desdemasuno=parseInt(desde) + parseInt(1);
	var hasta=cadena+desdemasuno;
	var cerosizq = cerosIzquierda(conletras,desdemasuno,desde); //codigos especiales 
		  if(cerosizq!=undefined){
		    var hasta = cadena+cerosizq; 
		  } 
	document.form1.int_desde_tn.value=hasta;  
}

//FUNCION DE METROSLINEAL A KILOS BOLSILLO
function metrosAkilos() {  
	if(document.form1.metroLineal_op.value != "") { 		
		var lam1=parseFloat(document.form1.lam1.value);  			
		var lam2=parseFloat(document.form1.lam2.value);
		var calibre=parseFloat(document.form1.calibre_bols.value)/10; 
		var metros=parseFloat(document.form1.metroLineal_op.value); 
			//if((lam1 > 0 || lam2 > 0 && calibre > 0) || (lam1 == 0 && lam2 == 0 && calibre == 0))
			
			if((lam1 > 0 || lam2 > 0) && calibre == 0 ) {
				alert ("Debe ingresar el calibre del bolsillo en la referencia"); 
				return false;
			}else{
			//OPERACION
			var mt=0.1;//centimetros de un metro 
            var cons=0.00467;//constante	 		
            var multip = (mt * calibre * cons);
            var subKilos = ((lam1) + (lam2) * (multip));
            var toKilos = (subKilos*metros)/2;
            var Kilost = (toKilos/1000);	
            document.form1.kls_sellado_bol_op.value=Kilost.toFixed(2); 			
            return true; 
        }  
    }
}
//===============================FUNCION GENERAL PARA FALTANTES INPUT DINAMICOS DE SELLADO TIQUETES========================//
//------------------FUNCION PARA AGREGAR FALTANTES DINAMICOS----//
function AddItem() {
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
		tr.innerHTML = '<td><input type="text" name="int_desde_f[]" onChange="MayusEspacio(this);" value="" autofocus="autofocus" required="required"/></td><td><input type="text" name="int_hasta_f[]" onChange="Calcular(this);" onBlur="MayusEspacio(this);" value="" required="required"/></td><td><input type="text" size="2" name="int_total_f[]" readonly /></td><td><button type="button" value="Borrar" onclick="eliminaFaltantes(this);Calcular(this);">Borrar</button></td>';
		tbody.appendChild(tr);
	}
}
//------------------FUNCION PARA RESTAR HASTA MENOS DESDE----//
function Calcular(ele) {
	var num="",caden="",l="",b="",c="",d="",e="",g="",h="",desde="", sal="",sal2="",cadena="";
	var int_desde_f = 0, int_hasta_f = 0, int_total_f = 0;
	var tr = ele.parentNode.parentNode;
	var nodes = tr.childNodes;
	for (var x = 0; x<nodes.length;x++) { 
//------------------CADENA DEFINIDA DESDE-------------------//	
if (nodes[x].firstChild.name == 'int_desde_f[]') {
	int_desde_f = (nodes[x].firstChild.value);    		
	var codigos = divideCadenas(int_desde_f); 
	var adesde = codigos[0]; 
	var cadena = codigos[1];
}//FIN IF INPUT DESDE
//------------------CADENA DEFINIDA HASTA-------------------// 
if (nodes[x].firstChild.name == 'int_hasta_f[]') {
	int_hasta_f = (nodes[x].firstChild.value);     
	var codigos = divideCadenas(int_hasta_f); 
	var ahasta = codigos[0]; 
	var cadena = codigos[1];		
}//FIN IF INPUT HASTA
//------------INPUT CADENA SUBTOTAL-------------------------//  
if (nodes[x].firstChild.name == 'int_total_f[]') {
int_total = parseInt((ahasta-adesde),10);//RESTA
int_total_f=(int_total+1);
nodes[x].firstChild.value = int_total_f;
//verifica que no ingrese numeros tangrandes

}//FIN IF INPUT TOTAL
}//FIN FORDE NODOS

//ALERT DE VERIFICA QUE CUANDO FALTANTES SUPERAN CANTIDAD X PAQUETE 
var TOTALEZ=document.form1.int_undxpaq_tn.value;  
if(int_total_f > TOTALEZ){
	swal({ 
		type: 'warning',
		title: 'Faltantes muy Altos!',
		text: "ojo! Los faltantes estan superando la cantidad por paquete", 
		timer: 4000
	})
	}//fin verif
	
//------------------TOTALIZAR----------------------------// 
var total = document.getElementById("total");
if (total.innerHTML == 'NaN') {
	total.innerHTML = 0;
}else{ 
	var upsT = document.getElementsByName('int_total_f[]'), sum = 0, i;
	for(i = upsT.length; i--;)
		if(upsT[i].value)
			sum += parseInt(upsT[i].value, 10);
		
total.innerHTML =sum; //parseInt(total.innerHTML)+parseInt(int_total_f);//CONTADOR PARA TOTAL 
}
//--------------ADD TOTAL FALTANTES AL HASTA------------// 
//function totalizar() {
	var TotalHasta=document.form1.int_desde_tn.value;
	var Tbolsa=document.form1.int_undxpaq_tn.value; 
	var codigos = divideCadenas(TotalHasta); 
	var THasta = codigos[0]; 
	var cadena = codigos[1];
		var Tsum = parseInt(THasta)+parseInt(Tbolsa)+parseInt(sum)-1;//sumo desde + paq bolsa y resto 1
document.form1.int_hasta_tn.value=(cadena+Tsum);//SUMA EL TOTAL AL HASTA	
//}
//------------------ALERTAS FUERA DEL FOR------------------// 
function alertafaltantes() {
	var Alfa=document.form1.int_desde_tn.value;
	var Omega=document.form1.int_hasta_tn.value;
	var codigos = divideCadenas(Alfa); 
	var Alfa = codigos[0];
	var cadena = codigos[1];
		/*var codigos = divideCadenas(Omega); 
		var Omega = codigos[0]; */		 
		if(adesde<Alfa || ahasta<Alfa){
			swal("La numeracion inicial: "+cadena+adesde+" o final: "+cadena+ahasta+" de uno de los faltantes, no debe ser Menor que la numeracion inicial: "+cadena+Alfa+" del paquete")
			return false; }
			return true;
		}
alertafaltantes()//LLAMA LA FUNCION DE FALTANTES 
}//FIN FUNCION
//---FUNCION ELIMINA LINEA DE INPUT DE FALTANTES DINAMICOS-----//
function eliminaFaltantes(obj){
	var oTr = obj;
	while(oTr.nodeName.toLowerCase()!='tr'){
		oTr=oTr.parentNode;
	} 
	var root = oTr.parentNode;
	root.removeChild(oTr);
}
//=======================================================FIN=========================================================//
//FUNCION GENERAL AUXILIARES FALTANTES DE TIQUETES SELLADO  
function divideCadenas(carac){
	var num="",caden="",l="",b="",c="",d="",e="",g="",h="",desde="", sal="",sal2="",cadena="";
		var caract =carac.toUpperCase().replace(/\s/g,'');//a mayusculas,reemplaza espacios		
		var z=(caract.search(/AA1Y|AA1F|AA1G|AA1H|AA1I|AA1J|AA1K|AA1L|AA1M|AA1N|AA1O|AA1P|AA1Q|AA1R|AA1S|AA1T|AA1U|AA1V|AA1W|AA1X|AA1Z|AA1A|AA1B|AA1C|AA1D|AA1E|AA2Y|AA2F|AA2G|AA2H|AA2I|AA2J|AA2K|AA2L|AA2M|AA2N|AA2O|AA2P|AA2Q|AA2R|AA2S|AA2T|AA2U|AA2V|AA2W|AA2X|AA2Z|AA2A|AA2B|AA2C|AA2D|AA2E|AA3Y|AA3F|AA3G|AA3H|AA3I|AA3J|AA3K|AA3L|AA3M|AA3N|AA3O|AA3P|AA3Q|AA3R|AA3S|AA3T|AA3U|AA3V|AA3W|AA3X|AA3Z|AA3A|AA3B|AA3C|AA3D|AA3E|AA4Y|AA4F|AA4G|AA4H|AA4I|AA4J|AA4K|AA4L|AA4M|AA4N|AA4O|AA4P|AA4Q|AA4R|AA4S|AA4T|AA4U|AA4V|AA4W|AA4X|AA4Z|AA4A|AA4B|AA4C|AA4D|AA4E|AA5Y|AA5F|AA5G|AA5H|AA5I|AA5J|AA5K|AA5L|AA5M|AA5N|AA5O|AA5P|AA5Q|AA5R|AA5S|AA5T|AA5U|AA5V|AA5W|AA5X|AA5Z|AA5A|AA5B|AA5C|AA5D|AA5E|AA6Y|AA6F|AA6G|AA6H|AA6I|AA6J|AA6K|AA6L|AA6M|AA6N|AA6O|AA6P|AA6Q|AA6R|AA6S|AA6T|AA6U|AA6V|AA6W|AA6X|AA6Z|AA6A|AA6B|AA6C|AA6D|AA6E|AA7Y|AA7F|AA7G|AA7H|AA7I|AA7J|AA7K|AA7L|AA7M|AA7N|AA7O|AA7P|AA7Q|AA7R|AA7S|AA7T|AA7U|AA7V|AA7W|AA7X|AA7Z|AA7A|AA7B|AA7C|AA7D|AA7E|AA8Y|AA8F|AA8G|AA8H|AA8I|AA8J|AA8K|AA8L|AA8M|AA8N|AA8O|AA8P|AA8Q|AA8R|AA8S|AA8T|AA8U|AA8V|AA8W|AA8X|AA8Z|AA8A|AA8B|AA8C|AA8D|AA8E|AA9Y|AA9F|AA9G|AA9H|AA9I|AA9J|AA9K|AA9L|AA9M|AA9N|AA9O|AA9P|AA9Q|AA9R|AA9S|AA9T|AA9U|AA9V|AA9W|AA9X|AA9Z|AA9A|AA9B|AA9C|AA9D|AA9E/i));

            
            codigo1 = buscaDigitos(caract);//busca 5 fecha 
    		var n=(caract.search(/\d+/g));//d solo numeros
    		var l=(caract.search(/\w+/g));//w alfanumericos

         
        if(codigo1!= undefined ){
          var codigo = caract.split("-");//hasta el guion  
          var data = codigo[0];
          var num = codigo[1];
          cadena=data+"-";
          solonumeros=num;  
          return [  solonumeros, cadena ];    
        }else 
		if(z=='0'){
			var v = caract; 
			var data = v.substring(0,4);
			var num = v.substring(4); 
			cadena=data;
			desde=num;	
			return [  desde, cadena ]; 		
		}else
		//solo numeros 
		if( n=='0'){			
			var v = caract; 
			var num = v.substring(0);
			var vacia="";	 
			desde=num; 
			return [ desde, vacia ];		
		}else
		//letras al inici
		if(l=='0' && z!='0'&& n!='0'){
		//caract.match(/\d+/g).join('');
		l=caract.match(/\D+/g); //D acepta diferente de numeros
		cadena=l; 
		solonumeros=caract.match(/\d+/g); //d acepta solo numeros

		    var cerosizq = cerosIzquierda(caract,solonumeros,solonumeros); //codigos especiales 
			  if(cerosizq!=undefined){
			    var solonumeros = cerosizq; 
			  }  
		return [ solonumeros, cadena ];		 		
		}//fin if
	}

 function cerosIzquierda(conletras,solonumero,cuantos ){
 	var ceros=(conletras.search(/EM|MQ|AB|AC|BP|BM|C|BB|OA|BC/i));//codigos especiales 
     
 	 var cuantos = cuantos.length ;
 	 //if(ceros== 0 ){
 	  //var cuantos = 8;
 	   codigo = solonumero.toString().padStart(cuantos, "0");
 
         return codigo;	//si es cero es porq lo encuentra
 
     //}
 
 } 

    function buscaDigitos(caract){
     
        var codigo = caract.split("-");//hasta el guion
        if(codigo[1]){
 
            return codigo;	
 
        }
    
    }
//=====================CERTIFICACION=========================//
//=====================BOTONES EN SELLADO=========================//
function desperdicio(){
	var desp =document.getElementById("bolsa_rp").value;
	var rollo =document.getElementById("idrollo").selectedIndex;
	var fechaI =document.getElementById("fecha_ini_rp").value;
	var fecha =document.getElementById("fecha_fin_rp").value;  
	if(desp=='' || rollo=='' || fecha=='' || fechaI=='') { 
		
		swal({
	  // type: "warning", "error", "success" e "info".
	  type: 'warning',
	  title: 'Desperdicios!',
	  text: 'LAS BOLSAS, FECHAS O EL ROLLO ESTAN VACIOS',
	  timer: 3000
	})
	}else{tiemposD()}
}
function tiempoM(){
	var desp =document.getElementById("bolsa_rp").value;
	var rollo =document.getElementById("idrollo").selectedIndex;
	var fechaI =document.getElementById("fecha_ini_rp").value;
	var fecha =document.getElementById("fecha_fin_rp").value;  
	if(desp=='' || rollo=='' || fecha=='' || fechaI=='') { 
		
		swal({
	  // type: "warning", "error", "success" e "info".
	  type: 'warning',
	  title: 'Tiempos Muertos!',
	  text: 'LAS BOLSAS, FECHAS O EL ROLLO ESTAN VACIOS',
	  timer: 3000
	})
	}else{tiemposM()}
}
function tiempoP(){
	var desp =document.getElementById("bolsa_rp").value;
	var rollo =document.getElementById("idrollo").selectedIndex;
	var fechaI =document.getElementById("fecha_ini_rp").value;
	var fecha =document.getElementById("fecha_fin_rp").value;  
	if(desp=='' || rollo=='' || fecha=='' || fechaI=='') { 
		
		swal({
	  // type: "warning", "error", "success" e "info".
	  type: 'warning',
	  title: 'Tiempos de Preparacion!',
	  text: 'LAS BOLSAS, FECHAS O EL ROLLO ESTAN VACIOS',
	  timer: 3000
	})
	}else{tiemposP()}
}

function kiloDisponible() {
	var txt=document.getElementById("kiloSistema").value; 
	if (txt < 0) { 
		swal({
	  // type: "warning", "error", "success" e "info".
	  type: 'warning',
	  title: 'No kilos disponibles!',
	  text: 'ojo! no hay kilos disponibles! estan en negativo (-)',
	  timer: 3000
	})
	} 
}



function kiloMetroBajosExtruder(){
	var metro_r=document.getElementById("int_metro_lineal_rp").value;
	var metro_op=document.getElementById("metro_op").value; 
	var kilos_r=document.getElementById("int_kilos_prod_rp").value; 
	var kilos_op=document.getElementById("kilos_op").value; 	
	var cien =100;
	var porc =20;
	//operaciones
	var porcMetro = metro_r * porc / cien;
	var metroT = parseInt(metro_r) + parseInt(porcMetro);	

	 //operaciones
	 var porcKilos = kilos_r * porc / cien;
	 var kilosT = parseInt (kilos_r)+parseInt(porcKilos);



	 var kilosT = parseInt (kilos_r)-parseInt(porcKilos);

	if (metroT < metro_op) { 
		swal({
			type: 'warning',
			title: 'Metros Muy distintos!',
			text: 'Los Metros ingresados + 20 % son: '+metroT+' y son muy bajos con respecto los de la o.p que son: '+ metro_op + ' verifique!',
			timer: 6000
		})
		return false; 
	}else 
		
		if (metroT > metro_op) { 			
			swal({
				type: 'warning',
				title: 'Metros Muy distintos!',
				text: 'Los Metros ingresados - 20 % son: '+metroT+' y son muy Altos con respecto los de la o.p que son: '+ metro_op + ' verifique!',
				timer: 6000
			})			
		return false; 
		 
	}else 
	 if (kilosT < kilos_op) { 
	 	swal({
	 		type: 'warning',
	 		title: 'Kilos Muy distintos!',
	 		text: 'Los kilos ingresados + 20 % son: '+kilosT+' y son muy bajos con respecto los de la o.p que son: '+ kilos_op + ' verifique!',
	 		timer: 6000
	 	}) 
	 	return false; 
	 }else 
	 	if (kilosT > kilos_op) { 			
	 		swal({
	 			type: 'warning',
	 			title: 'Kilos Muy distintos!',
	 			text: 'Los kilos ingresados - 20 % son: '+kilosT+' y son muy Altos con respecto los de la o.p que son: '+ kilos_op + ' verifique!',
	 			timer: 6000
	 		})			
	 	 
	 	return false; 
	 }else {
    		  	return true;
    	 }
	 
 }
//--------TRASLADOS---------------//
/*function recargaGeneral(campo,dato) { //v1.0
var pag='produccion_op_edit'; 
   location.href =pag+".php?"+campo+"="+dato; 
 
}*/

function recargaRollo(campo2,dato2) { //v1.0
	op_or  = parseFloat(document.getElementById("id_op").value);
	var pag='produccion_op_edit'; 
	location.href = pag+".php?id_op="+op_or+"&"+campo2+"="+dato2; 
	habilitaCamposOpParcial();
} 

function trasladOp()
{ 
	var cankilos = parseFloat(document.getElementById("kilo_destino").value);
	var kilosRollo=parseFloat(document.getElementById("kilo_origen").value);
	if(kilosRollo !='' && cankilos > kilosRollo)
	{ 
		swal("Los kilos ingresados no deben ser:","Mayores a los kilos del Rollo!")	
		document.getElementById("kilo_destino").value = kilosRollo;
	}
} 
function mostrarOcultarTraslado(obj) {
	document.getElementById('grupo_tras').style.visibility = (obj.click) ? 'visible' : 'hidden';
}
function habilitaCamposOpTotal(obj) {
	document.getElementById('grupo_tras').style.visibility = (obj.click) ? 'visible' : 'hidden';
	if(document.getElementById('oc_interna').value != 1){
	    document.getElementById('str_numero_oc_op').value =  document.getElementById('oc_interna').value;
	}
	document.getElementById('int_cliente_op').disabled  = false; 
	document.getElementById('op_destino').hidden  = false; 
	document.getElementById('rollo_origen').hidden  = true; 
	document.getElementById("kilo_destino").readOnly = true;
	
}
function habilitaCamposOpRollo(obj) { 
	document.getElementById('grupo_tras').style.visibility = (obj.click) ? 'visible' : 'hidden';
	if(document.getElementById('oc_interna').value != 1){
	  document.getElementById('str_numero_oc_op').value =  document.getElementById('oc_interna').value;
    }
	document.getElementById('int_cliente_op').disabled  = false; 
	document.getElementById('op_destino').hidden  = false; 			 
	document.getElementById('rollo_origen').hidden  = false; 
	document.getElementById("kilo_destino").readOnly = true;
	document.getElementById("kilo_destino").value = document.getElementById('kilo_origen').value;
}			  
function habilitaCamposOpParcial(obj) {
	document.getElementById('grupo_tras').style.visibility = (obj.click) ? 'visible' : 'hidden';
	if(document.getElementById('oc_interna').value != 1){
	  document.getElementById('str_numero_oc_op').value =  document.getElementById('oc_interna').value;
    }
	document.getElementById('int_cliente_op').disabled  = false; 
	document.getElementById('op_destino').hidden  = false; 			 
	document.getElementById('rollo_origen').hidden  = false; 
	document.getElementById("kilo_destino").readOnly = false;
}	 
//BLOQUEAR FLECHA ATRAS DEL EXPLORADOR
function nobackbutton(){
	window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}
 //ENVIO POR BOTON GENERAL
 function EnvioBoton(pag,name,valor,name2,valor2){
 	window.location.href = pag+"?"+name+"="+valor+"&"+name2+"="+valor2;
 }

