// JavaScript Document
                //*** Este Codigo permite Validar que sea un campo Numerico
                function telefono(telefono_c){
                    Numer=parseInt(telefono_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Numer;
                }
                //*** Fin del Codigo para Validar que sea un campo Numerico
                function fax(fax_c){
                    Numer=parseInt(fax_c); 
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                			
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function cupo_solicitado_c(cupo_solicitado_c){
                    Numer=parseInt(cupo_solicitado_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function cupo_aprobado_c(cupo_aprobado_c){
                    Numer=parseInt(cupo_aprobado_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
				
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function nit_c(nit_c){
                    Numer=parseInt(nit_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function telefono_bodega_c(telefono_bodega_c){
                    Numer=parseInt(telefono_bodega_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function celular_contacto_c(celular_contacto_c){
                    Numer=parseInt(celular_contacto_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                				
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function fax_bodega_c(fax_bodega_c){
                    Numer=parseInt(fax_bodega_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
                function telefono_envio_factura_c(telefono_envio_factura_c){
                    Numer=parseInt(telefono_envio_factura_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function fax_envio_factura_c(fax_envio_factura_c){
                    Numer=parseInt(fax_envio_factura_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function telefono_dpto_pagos_c(telefono_dpto_pagos_c){
                    Numer=parseInt(telefono_dpto_pagos_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                	
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function fax_dpto_pagos_c(fax_dpto_pagos_c){
                    Numer=parseInt(fax_dpto_pagos_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                					
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function tel_1ref_comercial_c(tel_1ref_comercial_c){
                    Numer=parseInt(tel_1ref_comercial_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                       
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function tel_2ref_comercial_c(tel_2ref_comercial_c){
                    Numer=parseInt(tel_2ref_comercial_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function tel_3ref_comercial_c(tel_3ref_comercial_c){
                    Numer=parseInt(tel_3ref_comercial_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function telefono_1ref_bancaria_c(telefono_1ref_bancaria_c){
                    Numer=parseInt(telefono_1ref_bancaria_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                	
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function telefono_2ref_bancaria_c(telefono_2ref_bancaria_c){
                    Numer=parseInt(telefono_2ref_bancaria_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
                
                //*** Fin del Codigo para Validar que sea un campo Numerico	
           function telefono_3ref_bancaria_cc(telefono_3ref_bancaria_c){
                    Numer=parseInt(telefono_3ref_bancaria_c);
                    if (isNaN(Numer)){
                        return "";
                    }
                    return Nume;
                }
               
				  
				  <!--mayusculas-->
				function conMayusculas(field) {
                    field.value = field.value.toUpperCase()
                }
				
				function MayusculaSinEspacios(field) {  
				   field.value = field.value.toUpperCase().trim(); 
				}
				function MayusEspacio(st) {
                    st.value = st.value.toUpperCase().replace(/\s/g,'');//a mayusculas,reemplaza espacios	
                }
				<!--el siguiente codigo es para controlar el campos si es extranjero o colombiano-->
/*				function ocultarCampo(selec) {  
				if ((selec.value == "NACIONAL")||(selec.value == " ")) { 
				document.getElementById('miCampoDeTexto').hidden = false; 
				
				} 
				else if (selec.value == "EXTRANJERO") { 
				document.getElementById('miCampoDeTexto').hidden = true; 
				 
				} 
					if(selec.value == "NACIONAL"){
					document.getElementById('ciudadexterno').hidden = true;
				}
				else if (selec.value == "EXTRANJERO"){
					document.getElementById('ciudadexterno').hidden = false;
				}
					if(selec.value == "NACIONAL"){
					document.getElementById('id_pais').hidden = true;
				}
				else if (selec.value == "EXTRANJERO"){
					document.getElementById('id_pais').hidden = false;
				}
				}*/
				function ocultarCampo(selec) {  
				if ((selec.value == "NACIONAL")||(selec.value == "")) { 
				document.getElementById('miCampoDeTexto').hidden = false;                document.getElementById('ciudadexterno').value = "";
                document.getElementById('id_pais').hidden = true;
				document.getElementById('ciudadexterno').hidden = true;

				
				}  else if (selec.value == "EXTRANJERO") {
				document.getElementById('id_pais').hidden = false; 
				document.getElementById('miCampoDeTexto').hidden = true;
				document.getElementById('miCampoDeTexto').value =  ""
				document.getElementById('ciudad_dest').value =  ""
				document.getElementById('ciudadexterno').hidden = false;
				} 
 				}//fin funcion
				function  desapareceClick(input){
					if ((input.value != " ")||(input.value == " ")){
					document.getElementById('ciudadexterno').hidden = true;
				}
				}
				
				<!--este codigo es para controlar que aparezca algunos botones de lamina, materia prima, bolsas,  packing list-->
				function mostrarColor(selec) {  
				if ((selec.value == "0")||(selec.value == "")) { 
				document.getElementById('N_colores_impresion').value  = "0";
				document.getElementById('N_colores_impresion').hidden = true; 
				
				document.getElementById('B_cyreles').hidden = true;
				
				} 
				else if (selec.value == "1") { 
				document.getElementById('N_colores_impresion').hidden = false; 
				document.getElementById('B_cyreles').hidden = false; 
				} 
				}
				///////FUNCION DE BOLSILLO
				function mostrarBolsillo(selec) {  
				if ((selec.value == "0")||(selec.value == "")) { 
				document.getElementById('N_tamano_bolsillo').hidden = true;
				document.getElementById('N_tamano_bolsillo').value  = "0";
 				} 
				else if (selec.value == "1") { 
				document.getElementById('N_tamano_bolsillo').hidden = false;
				} 
				}
				//////// MUESTRA TIPO DE EXTRUSION INTERNA O EXTERNA
				function mostrarCapa(selec) {  
				if (selec.value == "TRANSPARENTE") {  
				document.getElementById('Str_capa_ext_coext').value  = "TRANSPARENTE";
				document.getElementById('Str_capa_inter_coext').value  ="TRANSPARENTE";
 				}
				if (selec.value == "PIGMENTADO B/N") { 
 				document.getElementById('Str_capa_ext_coext').value = "BLANCO";
				document.getElementById('Str_capa_inter_coext').value = "NEGRO";
 				}
				if (selec.value == "PIGMENTADO B/B") { 
				document.getElementById('Str_capa_ext_coext').value  = "BLANCO";
				document.getElementById('Str_capa_inter_coext').value  ="BLANCO";
 				} 
				}
				<!--fin validacion extranjero-->
				<!--referencia aparece select-->
				function mostrarBols(input) {  
				if ((document.form1.bolsillo_guia_ref.value == "0.00")||(document.form1.bolsillo_guia_ref.value == '0')||(document.form1.bolsillo_guia_ref.value == '')) { 
				document.getElementById('str_bols_ub_ref').disabled = true;
				document.getElementById('str_bols_fo_ref').disabled = true; 
				document.getElementById('bol_lamina_1_ref').disabled =true; 
				document.getElementById('bol_lamina_2_ref').disabled =true;
				document.getElementById('calibreBols_ref').disabled = true; 
				document.getElementById('tipolam').disabled = true; 
				document.getElementById('str_bols_ub_ref').value = '0';
				document.getElementById('str_bols_fo_ref').value = '0';
				document.getElementById('bol_lamina_1_ref').value = '0'; 
				document.getElementById('bol_lamina_2_ref').value = '0';
				document.getElementById('calibreBols_ref').value = '0'; 
				document.getElementById('tipoLamina_ref').disabled ='N.A'; 				
				}else{
				document.getElementById('str_bols_ub_ref').disabled = false;
				document.getElementById('str_bols_fo_ref').disabled = false;
				document.getElementById('bol_lamina_1_ref').disabled = false; 
				document.getElementById('bol_lamina_2_ref').disabled = false;
				document.getElementById('calibreBols_ref').disabled = false; 
				document.getElementById('tipolam').disabled = false;  
				}															 							
				}
				
				//Código para colocar 
				//los indicadores de miles mientras se escribe
				function puntos(donde,caracter){
					pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/
					valor = donde.value
					largo = valor.length
					crtr = true
					if(isNaN(caracter) || pat.test(caracter) == true){
						if (pat.test(caracter)==true){ 
							caracter = "/" + caracter
						}
						carcter = new RegExp(caracter,"g")
						valor = valor.replace(carcter,"")
						donde.value = valor
						crtr = false
					}
					else{
						var nums = new Array()
						cont = 0
						for(m=0;m<largo;m++){
							if(valor.charAt(m) == "." || valor.charAt(m) == " ")
								{continue;}
							else{
								nums[cont] = valor.charAt(m)
								cont++
							}
						}
					}
					var cad1="",cad2="",tres=0
					if(largo > 3 && crtr == true){
						for (k=nums.length-1;k>=0;k--){
							cad1 = nums[k]
							cad2 = cad1 + cad2
							tres++
							if((tres%3) == 0){
								if(k!=0){
									cad2 = "." + cad2
								}
							}
						}
						donde.value = cad2
					}
				}
				//fin codigo
//EXTRUSION 
function validaTodo(){
 			 var kilosT = document.getElementById("int_kilos_prod_rp").value; 
			 var MateriasT = document.getElementById("materiaPrima").value;
 			 var kilosT = (parseFloat(kilosT));
 			 var MateriasT = (parseFloat(MateriasT));
 			 
             var fecha_inicial=document.getElementById('fecha_ini_rp').value;
             var fecha_final=document.getElementById('fecha_fin_rp').value; 

             var montaje = document.getElementById("montaje").selectedIndex; 
             var liquida = document.getElementById("liquida").selectedIndex;

             //var turno = document.getElementById("turno_r").selectedIndex;

             var rollos=(document.form1.int_total_rollos_rp.value);

             var Optimo_rp= document.getElementById('tiempoOptimo_rp').value;

             var metro_r = document.getElementById('metro_r').value; 
             var int_kilosxhora_rp = document.getElementById('int_kilosxhora_rp').value;  


             var str_maquina_rp = document.getElementById('str_maquina_rp').value; 
 
 
			  if ( (kilosT >0 && MateriasT>0) && kilosT != MateriasT){ 
			      swal("Error", 'Los kilos de los Rollos deben ser iguales a los kilos de las materias primas; corrija!', "error");
					return false; 
		      }else
    		   if(str_maquina_rp==''){
    		        swal("Error", "Debe agregar un valor al campo Maquina! :)", "error"); 
    		        return false;
    		  }else
		      if((montaje == null && liquida == null) || (montaje == '' && liquida == '')) {
				  swal("Error", 'Debe seleccionar al menos un operario', "error");
				  document.getElementById("montaje").focus();
			      return false;
			  }else
    		  if(Date.parse(fecha_final) < Date.parse(fecha_inicial)) {
				    swal("Error", 'La fecha final debe ser mayor a la fecha inicial', "error");
 				    return false;
			  }else
			  if(fecha_inicial=='') {
					swal("Error", 'Llene la fecha Inicial', "error");
					document.getElementById("fecha_ini_rp").focus();
				    return false; 
			  }else
			  if(fecha_final=='') {
				 	swal("Error", 'Llene la fecha final', "error"); 
				    return false; 
			  }else
			  if(rollos=='') {
			        swal('El campo de rollos esta vacio, debe ingresar los rollos para poder liquidar!', "error")
			        document.getElementById("int_total_rollos_rp").focus(); 
			        return false;	
			  }else
    		  if(Optimo_rp==''){
    		       swal("Error", "Debe agregar un valor al campo Tiempo Optimo! :)", "error"); 
    		       return false;
    		  }else
    		   if(metro_r==''){
    		       swal("Error", "Debe agregar un valor al campo Metro lineal! :)", "error"); 
    		       return false;
    		  }else
    		   if(int_kilosxhora_rp==''){
    		        swal("Error", "Debe agregar un valor al campo Kilos x Hora! :)", "error"); 
    		        return false;
    		  }else
    		  {
    		  	return true;
    		  } 
    		  
              
               
}
/*function validacion_losdos() { 
			var valorRetorno = true;
			 indice = document.getElementById("montaje").selectedIndex; 
			 indice2 = document.getElementById("liquida").selectedIndex;
			
			return valorRetorno;  
}*/
 
 
//FIN EXTRUSION



function validacion_unodelosdos_imp() {  
   			 var indice1 = document.getElementById("idrollo").selectedIndex;
			 var indice2 = document.getElementById("operario").selectedIndex;
			 var indice3 = document.getElementById("auxiliar").selectedIndex;
			 var indice4 = document.getElementById("maquina").selectedIndex; 

             var fecha_inicial=document.getElementById('fecha_ini_rp').value;
             var fecha_final=document.getElementById('fecha_fin_rp').value;
			 var metrosBanderas = document.getElementsByName("metroBandera[]");
			
			 
			 if(indice1 == '') {
 			  swal('[ERROR] Seleccione el rollo');
			  document.getElementById("idrollo").focus();
			  return false;
			  }else if((indice2 == '') && (indice3 == '')){
						swal('[ERROR] Los Operarios no deben estar vacios');
						document.getElementById("operario").focus();
						return false;  
						}else if(indice2 == indice3) { 
							swal('[ERROR] Los Operarios no deben ser iguales');
							document.getElementById("operario").focus(); 
							return false;
							} 

			  if(document.getElementById('turno_r').value=='' ) { 
 			  swal('[ERROR] Llene el Turno');
			  document.getElementById("turno_r").focus(); 
			  return false;
			  }else if(indice4 == '') { 
						swal('[ERROR] Seleccione la maquina'); 
						document.getElementById("maquina").focus();
						return false;
						}else if(Date.parse(fecha_final)<Date.parse(fecha_inicial)){
								swal('[ERROR] La fecha final debe ser mayor a la fecha inicial');
								return false;
								} 

				if ((fecha_inicial)==''){
				swal('[ERROR] Llene la fecha inicial');
				document.getElementById("fecha_ini_rp").focus();
				return false; 
				} 

				if ((fecha_final)==''){
				swal('[ERROR] Llene la fecha final');
				/*document.getElementById("fecha_fin_rp").focus();*/
				return false; 
				}  	

				if(metrosBanderas.length > 0){
					let res = validacionBanderas();
					return res;
				} 

			   if(document.getElementById('button_imp_rollo').value){
                document.getElementById('button_imp_rollo').style.display = 'none';
			  	}	 

			    
				
			  return true;
}


//SELLADO

function validaTodoSell(){

	var valorRetorno = true;
	var indice0 = document.getElementById("turno_rp").value;
	var indice1 = document.getElementById("idrollo").selectedIndex;
	var indice5 = document.getElementById("bolsa_rp").value;
	var indice2 = document.getElementById("maquina").selectedIndex; 
	var indice3 = document.getElementById("operario").selectedIndex;
	var indice4 = document.getElementById("auxiliar").selectedIndex;
	var indice6 = document.getElementById("turno_rp").value;
	var indice7 = document.getElementById("n_ini_rp").value;
	var indice8 = document.getElementById("n_fin_rp").value;

	var indice9 = document.getElementById("int_kilosxhora_rp").value;

	var fecha_inicial=document.getElementById('fecha_ini_rp').value;
	var fecha_final=document.getElementById('fecha_fin_rp').value;



	if(indice0 == '') {
		swal("Error", 'Seleccione el Turno!', "error"); 

		return false;
	}else
	if(indice1 == '') {
		swal("Error", 'Seleccione el rollo!', "error"); 

		return false;
	}else
	if(indice5 == '') { 
		swal("Error", 'Agregue Bolsas!', "error"); 

		return false;  
	}else
	if(indice6 == '') {  
		swal("Error", 'Seleccione el turno!', "error");

		return false;  
	} else
	if(indice2 == '') { 
		swal("Error", 'Seleccione la maquina!', "error");

		return false;  
	}else
	if( (indice3==0 && indice4==0) ) {  
		swal("Error", 'Seleccione un Operarios o Revisor!', "error");

		return false;
	}else
	if( (indice3!=0 && indice4!=0) && (indice3 == indice4 ) ) {  
		swal("Error", 'El operario y revisor deben ser distintos!', "error");

		return false;
	}else 
	if(Date.parse(fecha_final)<Date.parse(fecha_inicial)){
		swal("Error", 'La fecha final debe ser mayor a la fecha inicial!', "error");

		return false;
	}else 
	if ((fecha_inicial)==''){
		swal("Error", 'Llene la fecha inicial!', "error"); 

		return false; 
	}else
	if ((fecha_final)==''){
		swal("Error", 'Llene la fecha Final!', "error"); 

		return false; 
	}else
	if(indice7  == '' && indice8 == '') {  
		swal("Error", 'Ingrese las numeraciones!', "error"); 

		return false;
	}else
	if( indice7 != 0 && indice8 == '' ) {  
		swal("Error", 'Ingrese la numeraciones Final!', "error"); 

		return false;
	}else
	if( indice9 ==  ''  ) {  
		swal("Error", 'Ingrese los Kilos*Hora!', "error"); 

		return false;
	} 

	return true;
 	// return valorRetorno;
 

 }


function numeracioInicial(){
   //desde el edit normal
   if(document.getElementById("idrollo").value)
   consultaNumeracionInicio(document.getElementById("id_op_rp").value,document.getElementById("bolsa_rp").value)

}

function numeracioInicialParcial(){
  
   if(document.getElementById("numInicioControl").value!='' )
   numeracionDesdeLiquidacion(document.getElementById("bolsa_rp").value,document.getElementById("numInicioControl").value)

}
 
//esta validacion es cuando registran rollos en extruder
function validacion_registro_rollo() { 
    			var valorRetorno = true;
    			var indice1 = document.getElementById("montaje").selectedIndex; 
                var fecha_inicial=document.getElementById('fecha_ini_rp').value;
                var fecha_final=document.getElementById('fecha_fin_rp').value; 
				var metrosBanderas = document.getElementsByName("metroBandera[]");

				if(indice1 == '' || indice1 == 0) {
				    swal("Error", 'Debe seleccionar el operario!', "error"); 
				    document.getElementById("montaje").focus();
				return false;
				}else	
				if(document.getElementById('turno_r').value=='' ) { 
     			   swal("Error", 'Llene el Turno!', "error");
    			   document.getElementById("turno_r").focus(); 
    			   return false;
    			} else 
				if (Date.parse(fecha_final)<Date.parse(fecha_inicial))
				{
					swal("Error", 'La fecha final debe ser mayor a la fecha inicial', "error"); 
 				return false;
				} else
				if (fecha_inicial=='')
				{
					swal("Error", 'Llene la fecha inicial', "error");
					document.getElementById("fecha_ini_rp").focus();
				return false; 
				}else
				if (fecha_final=='')
				{
				 	swal("Error", 'Llene la fecha final', "error");
				   
				return false; 
				} 

				if(metrosBanderas.length > 0){
					let res = validacionBanderasExt();
					return res;
				}
				
  		 return true; 
 			  
}

function validacionBanderas(){
    let metrosBanderas = document.getElementsByName("metroBandera[]");
    let estado = true;
    metrosBanderas.forEach(element => {
      if(parseInt(element.value) >= parseInt(document.querySelector("#metro_r2").value)){
        swal("Los metros "+element.value+" de la bandera deben ser menor a los del metros rollo final "+(document.querySelector("#metro_r2").value) );
        estado = false;
      }
    });
    return estado;
  }

  function validacionBanderasExt(){
	  let metrosBanderas = document.getElementsByName("metroBandera[]");
	  let estado = true;
    metrosBanderas.forEach(element => {
      if(parseInt(element.value) >= parseInt(document.querySelector("#metro_r").value)){
        swal("Los metros "+element.value+" de la bandera deben ser menor a los metros del rollo final "+(document.querySelector("#metro_r").value) );
        estado = false;
      }
    });
    return estado;
  }

//FIN SELLADO

//esta es para borrar&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
/*function validacion_unodelosdos_sell() {  
	var valorRetorno = true;
	var indice1 = document.getElementById("idrollo").selectedIndex;
	var indice5 = document.getElementById("bolsa_rp").value;
	var indice2 = document.getElementById("maquina").selectedIndex; 
	var indice3 = document.getElementById("operario").selectedIndex;
	var indice4 = document.getElementById("auxiliar").selectedIndex;
	var indice6 = document.getElementById("turno_rp").value;
	var indice7 = document.getElementById("n_ini_rp").value;
	var indice8 = document.getElementById("n_fin_rp").value;



	var fecha_inicial=document.getElementById('fecha_ini_rp').value;
	var fecha_final=document.getElementById('fecha_fin_rp').value;

	if(indice1 == '') {
		swal('[ERROR] Seleccione el rollo');


		return false;
	}else
	if(indice5 == '') { 
		swal('[ERROR] Agregue Bolsas'); 


		return false;  
	}else
	if(indice6 == '') { 
		swal('[ERROR] Seleccione el turno'); 


		return false;  
	}  else
	if(indice2 == '') { 
		swal('[ERROR] Seleccione la maquina'); 


		return false;  
	} else
	if((indice3 == indice4)) {  
		valorRetorno = false; 
		swal('[ERROR] Seleccione uno de lo Operarios o Revisor');


		return false;
	}else
	if((indice3 == null) && (indice4 == null) || (indice3 == '') && (indice4 == '')){
		swal('[ERROR] llene el operario o auxiliar');


		return false;  
	}	else
	if (Date.parse(fecha_final)<Date.parse(fecha_inicial))
	{
		swal('[ERROR] La fecha final debe ser mayor a la fecha inicial');

		return false;
	}else 
	if ((fecha_inicial)=='')
	{
		swal('[ERROR] Llene la fecha inicial');


		return false; 
	}else
	if ((fecha_final)=='')
	{
 
				return false; 
	}else

	if((indice7  != 0 && indice8 == '') || (indice7  == '' && indice8 == '')) {  
		
		
		swal('[ERROR] Ingrese las numeraciones');
		valorRetorno = false; 


		 return false;
	 } 

	 if(document.getElementById('ENVIAR').value){

	 }

		 return valorRetorno;
  }*/
//esta es para borrar&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


  function validacion_sellado(){
  var kOp=document.form1.kilos_op.value; //kilos de la o.p	
  var kP=document.form1.kilos_r.value;//kilos ingresados manualmente
  var op=document.form1.id_op_rp.value; 
  			
      var ups=document.getElementsByName('kilos_sellado[]'), sum = 0, i;//suma de todos los kilos ya registrados en impresion
      for(i = ups.length; i--;)
          if(ups[i].value)
              sum += parseFloat(ups[i].value, 10);
              var tkilos_s=sum.toFixed(2);
  					
  			var sumaK=parseFloat(tkilos_s)+parseFloat(kP);
  			//SUMO EL 2% A LOS KILOS DE LA O.P
  			porcr=document.form1.porcentaje.value;//Porcentaje ya que el peso de la tinta no varia mucho
  			//saco el porcentaje del total de kilos o.p
  			kOpP=((kOp*porcr)/100);
  			kOpTotal=(Math.round(parseFloat(kOpP)+parseFloat(kOp)));//sumo el porcentaje del total de la o.p a el mismo de la o.p
  			if(sumaK > kOpTotal)//comparo si el que esta ingresando manualmente supera el total kilos de la o.p mas el porsentaje
  			{				
  			alert ("Los kilos que esta ingresando son muy altos. se han registrado en sellado: Kilos: ("+tkilos_s+") y el maximo de la o.p "+ op+" son: Kilos:("+kOp+" mas el "+porcr+" %), debe bajar la cantidad de kilos")
  			return false;
  			}

    return true;
  	

  }

function validacion_select() {

			//valida codigo empleado vacio	
			indice = document.getElementById("operario").selectedIndex;
			if( indice == null || indice == 0 ) {
				  swal('[ERROR] Debe seleccionar el nombre');
				  form1.operario.focus();//importante dirigirlo al campo correspondiente, sino no funciona
			return false;
			}
		  else 	
			indice2 = document.getElementById("revisor").selectedIndex;
			if( indice2 == null || indice2 == 0 ) {
				  swal('[ERROR] Debe seleccionar el nombre'); 
				  form1.revisor.focus();//importante dirigirlo al campo correspondiente, sino no funciona
			return false;
			}

  return true;
}
  
   function maquina() {
					var valorRetorno = true;
 					var maquina = document.getElementById("maquina").selectedIndex;
					//Comprobamos si selecciono operario
					if (maquina == 0 || maquina == null){
						valorRetorno = false;
						alert("[ERROR] Debe seleccionar el nombre maquina");
						document.getElementById("maquina").focus();
						 
					}
					return valorRetorno;
					}	
					
					
					
					
	 function validar(form) {
					var valorRetorno = true;
					var operario = form.operario.selectedIndex;
				    //var revisor = form.revisor.selectedIndex;
					var maquina = form.maquina.selectedIndex;
					//Comprobamos si selecciono operario
					if (operario == 0 || operario == null) {
						valorRetorno = false;
						alert ("[ERROR] Debe seleccionar el nombre");
						form1.operario.focus();
					}/*else	
					//Comprobamos si selecciono revisor
					if ( revisor == 0 || revisor == null) {
						valorRetorno = false;
						alert ("[ERROR] Debe seleccionar el nombre");
						form1.revisor.focus();
					}else*/					
					//Comprobamos si selecciono maquina
					if (maquina == 0 || maquina == null){
						valorRetorno = false;
						alert("[ERROR] Debe seleccionar el nombre maquina");
						form1.maquina.focus();
					}
					return valorRetorno;
	 }	
					
 
function validacion_select_oc() {   
 
			//valida codigo empleado vacio	
			indice = document.getElementById("cliente").selectedIndex;
			if( indice == null || indice == 0 ) {
				  alert('[ERROR] Debe seleccionar el cliente');
			return false;
			}
		  else 	
			indice2 = document.getElementById("nit").selectedIndex;
			if( indice2 == null || indice2 == 0 ) {
				  alert('[ERROR] Debe seleccionar el nit');
			return false;
			}
  return true;
}
function validacion_select_ref() {

			//valida codigo empleado vacio	
			indice = document.getElementById("Str_presentacion").selectedIndex; 
			if( indice == null || indice == 0 ) {
				  alert('[ERROR] Debe seleccionar los select'); 
			return false; 
			}
		 return true;	
}
//valida adhesivo y bolsillo desde referencia, o.p y detalle sellado
function validacion_select_bolsillo() {
	        indice = document.getElementById("adhesivo").selectedIndex;
	        indice1 = document.getElementById("tipocinta").selectedIndex; 
   			if(indice != "" && indice1 == "") {
				  alert('[ERROR] Debe seleccionar el Tipo de Adhesivo'); 
				 document.getElementById("tipocinta").focus();
			return false;   
			}else
			if(indice == "" && indice1 == "") 
			{return true;}
			
 			indice3 = document.getElementById("tipolam").selectedIndex;
		    indice4 = document.getElementById("valorlam").value;
			if(indice3 == "0" &&  indice4 > 0.00) { 
				  alert('[ERROR] Debe seleccionar el Tipo de Lamina'); 
				  document.getElementById("tipolam").focus();
			return false;   
			}else{return true;}
  
  			indice5 = document.getElementById("tipoterm").selectedIndex;
		    indice6 = document.getElementById("valortermica").value;  			
			if(indice5 == "" &&  indice6 > 0.00) { 
				  alert('[ERROR] Debe seleccionar el Tipo de Termica'); 
				  document.getElementById("tipoterm").focus();
			return false;   
			}else{return true;}			
}
//valida adhesivo desde o.p unicamente
function validacion_tipocinta() {
			indice =  document.form1.adhesivo_ref.value;
		    indice1 = document.form1.tipoCinta_ref.value; 
			if((indice != "N.A" && indice1 == "")||(indice != "N.A" && indice1 == "")) {
				  alert('Debe seleccionar el Tipo de Adhesivo en la Referencia'); 
				 document.getElementById("tipocinta").focus();
			return false;   
			 }
			return true;
			} 
//PROCESO EMPLEADOS
function aportes(){
	var dias=parseInt(30);//dejar 30 que es lo maximo q se liquida
	var diasueldo=document.form1.sueldo_empleado.value/dias;
	var diaaux=document.form1.aux_empleado.value/dias;
		
	var sueldo=diasueldo*document.form1.dias_empleado.value;//dejarlo asi para q se mueva la liquidacion
	var auxtranporte=diaaux*document.form1.dias_empleado.value;//dejarlo asi para q se mueva la liquidacion
 
	var sueldoyauxilio = parseFloat(sueldo) + parseFloat(auxtranporte); 
	var constante=parseInt(100);//para dar el porcentaje
	cesant=parseFloat(sueldoyauxilio*document.form1.cesantias_porc.value)/constante;
	document.form1.cesantias.value=cesant.toFixed(2);
	var intcesan =  parseFloat(sueldoyauxilio*document.form1.interesCesantias_porc.value)/constante;
	var totalint=intcesan/12; 
	document.form1.interesCesantias.value = totalint.toFixed(2); 
	prima=parseFloat(sueldoyauxilio*document.form1.prima_porc.value)/constante;
	document.form1.prima.value=prima.toFixed(2); 
	salud=parseFloat(sueldo*document.form1.salud_porc.value)/constante;     
	document.form1.salud.value=salud.toFixed(2);
	pension=parseFloat(sueldo*document.form1.pension_porc.value)/constante; 
	document.form1.pension.value=pension.toFixed(2); 
	vacaciones=parseFloat(sueldo*document.form1.vacaciones_porc.value)/constante;
	document.form1.vacaciones.value=vacaciones.toFixed(2);
	caja=parseFloat(sueldo*document.form1.cajaCompensacion_porc.value)/constante;
	document.form1.cajaCompensacion.value=caja.toFixed(2);
	sena=parseFloat(sueldo*document.form1.sena_porc.value)/constante;
	document.form1.sena.value=sena.toFixed(2)
	arl=parseFloat(sueldo*document.form1.arl_porc.value)/constante;
	document.form1.arl.value=arl.toFixed(3);
	total=parseFloat(cesant+totalint+prima+salud+pension+vacaciones+caja+sena+arl)
	document.form1.total.value=total.toFixed(3);
	
	
	}
function novedadEmpleado(){
	var sueldo=document.form1.sueldo.value;
	var auxtranporte=document.form1.aux_empleado.value;
	var porcentaje=parseFloat(document.form1.porc_incapacidad.value);
	var dia_ley=parseInt(document.form1.dia_ley.value);
    var dias_incapacidad=parseInt(document.form1.dias_incapacidad.value);
	
	var totalSueldo=parseFloat(sueldo ) + parseFloat(auxtranporte);
    var valorDia=totalSueldo/30;
    var valorDiaIncapacidad=parseFloat(valorDia)*parseFloat(porcentaje)/100;

	if(dias_incapacidad<=dia_ley)//dia de ley son 2 los estipulados
	{
	var valorPagar = parseFloat(valorDiaIncapacidad)*parseInt(dias_incapacidad);
	document.form1.pago_acycia.value=valorPagar.toFixed(2);
	document.form1.pago_eps.value='0';
	}else{
	var	diasPago_acycia=dia_ley;
	var diasPago_eps = parseInt(dias_incapacidad)- parseInt(dia_ley)
	var valorPagarAcycia= parseFloat(valorDiaIncapacidad)*parseInt(diasPago_acycia);
    var valorPagarEps = parseFloat(valorDiaIncapacidad)*parseInt(diasPago_eps);
	document.form1.pago_acycia.value=valorPagarAcycia.toFixed(2);
	document.form1.pago_eps.value=valorPagarEps.toFixed(2);		
		}
	
	}	
function envioFormEmpleadoProceso(){
		empleado = document.getElementById("input1").selectedIndex;
		if( empleado == null || empleado == 0 ) {
		      alert('[ERROR] Debe seleccionar el nombre');
			  document.getElementById("input1").focus();
			return false;
			}
		  else 	
			proceso = document.getElementById("input2").selectedIndex;
			if( proceso == null || proceso == 0 ) {
				  alert('[ERROR] Debe seleccionar el proceso');
				  document.getElementById("input2").focus();
			return false;
			}
		  /*else 	
			fecha1 = document.getElementById("fecha1").selectedIndex;
			fecha2 = document.getElementById("fecha2").selectedIndex;
			if(fecha1 == null || fecha2 == null && Date.parse(fecha2 <= fecha1)) {
				  alert('[ERROR] La fecha final debe ser mayor a la inicial');
				  document.getElementById("fecha2").focus(); 
			return false;
			}*/ 			 
			else 
			subm = document.form1.envio.value;
              if(subm=='1'){
	            alert("El empleado ya Existe!!")
	        return false;
	        }					
	return true;
	}
	//AJUSTE PROCESO EN COSTOS
	function envioFormAjusteProceso(){
		empleado = document.getElementById("input2").selectedIndex;
		if( empleado == null || empleado == 0 ) {
		      alert('[ERROR] Debe seleccionar el proceso');
			  document.getElementById("input1").focus();
			return false;
			}
/*		  else 	
			fecha1 = document.getElementById("fecha1").selectedIndex; 
			fecha2 = document.getElementById("fecha2").selectedIndex;
			if(fecha1 == null || fecha2 == null && Date.parse(fecha2 <= fecha1)) {
				  alert('[ERROR] La fecha final debe ser mayor a la inicial');
				  document.getElementById("fecha2").focus(); 
			return false;
			} */		 
			else 
			subm = document.form1.envio.value;
              if(subm=='1'){
	            alert("No se puede agregar un procesos en un mismo rango de fechas")
	        return false;
	        }					
	return true;
	}
//EXTRUSION DESDE POPUP DE INGRESO MATERIA PRIMA
function validacion_kilos_extrusion() {

	//evalua la suma de kilos no sea mayor a la o.p
    var kOp=document.form2.kilos_op.value;		
	var op=document.form2.id_op_rp.value;
	 
    var upt = document.getElementsByName('valor_prod_rp[]'), sump = 0, i;
    for(i = upt.length; i--;)
        if(upt[i].value)
            sump += parseFloat(upt[i].value, 10);
            var totalP=sump.toFixed(2);			
	     
   
    var ups=document.getElementsByName('kilos_extruido[]'), sum = 0, x;
    for(x = ups.length; x--;)
        if(ups[x].value)
            sum += parseFloat(ups[x].value, 10);
            var kilos_r=sum.toFixed(2);		
			var sumaK=parseFloat(kilos_r)+parseFloat(totalP);//kilos que se ingresan 
			
			//SUMO EL % A LOS KILOS DE LA O.P
			porcr=document.form2.porcentaje.value;//Porcentaje
			kOpP=((kOp*porcr)/100);
			var porcent=kOpP.toFixed(2); 
			kOpPorc=(Math.round(parseFloat(porcent)+parseFloat(kOp)));
			if(sumaK > kOpPorc){				
			alert ("Los kilos que esta ingresando son muy altos. el maximo de la o.p "+ op+" son: Kilos:("+kOp+" mas el "+porcr+" %), debe bajar la cantidad de kilos")
			return false;
			}
  
  // Si el script ha llegado a este punto, todas las condiciones
  // se han cumplido, por lo que se devuelve el valor true
  return true;
}
function validacion_kilos_Impresos(){
var kOp=document.form1.kilos_op.value; //kilos de la o.p	
var kP=document.form1.int_total_kilos_rp.value;//kilos ingresados manualmente
var op=document.form1.id_op_rp.value;

    var ups=document.getElementsByName('kilos_impreso[]'), sum = 0, i;//suma de todos los kilos ya registrados en impresion
    for(i = ups.length; i--;)
        if(ups[i].value)
            sum += parseFloat(ups[i].value, 10);
            var kilos_r=sum.toFixed(2);
			
			var sumaK=parseFloat(kilos_r)+parseFloat(kP);//kilos que se ingresan y existentes en otros registros, para que no se pase el limite			
			
			//SUMO EL 2% A LOS KILOS DE LA O.P
			porcr=document.form1.porcentaje.value;//Porcentaje ya que el peso de la tinta no varia mucho
			kOpP=((kOp*porcr)/100);
			kOpPorc=(Math.round(parseFloat(kOpP)+parseFloat(kOp)));//sumo el porcentaje del total de la o.p a el mismo de la o.p
			if(sumaK > kOpPorc)//comparo si el que esta ingresando manualmente supera el total kilos de la o.p mas el porsentaje
			{				
			alert ("Los kilos que esta ingresando son muy altos. se han registrado en impresion: Kilos: ("+kilos_r+") y el maximo de la o.p "+ op+" son: Kilos:("+kOp+" mas el "+porcr+" %), debe bajar la cantidad de kilos")
			return false;
			}
  return true;
	
}

 

//IMPRESION
function tintasVacio(){
var tinta=(document.form1.int_totalKilos_tinta_rp.value);
if(tinta=='')
   {
alert ('Debe Ingresar los Kilos de tinta utilizados en detalle Kilos')
document.getElementById("int_totalKilos_tinta_rp").focus(); 
return false;	
   }
    return true;
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
			  alert('Debe Seleccionar una DIRECCION de DESPACHO, sino existe ingresela en el perfil del cliente');
			  return false;
			  }
			  
	   return true;
   }
   
}*/
function valores(){  
        var id_c=(document.form1.id_c_oc.value);
  		var valor1=(document.form1.valor.value);
	    var valor2=(document.form1.precioreal.value);	
 
		if (id_c != '520' && valor1 != valor2)//520 ES LINIO
		{
			 swal("El valor no puede ser distinto del actual, debe crear una nueva cotizacion!")	
			 document.form1.valor.value = valor2;//devuelvo el valor actual
			 document.getElementById('valor').disabled = true;  	
			 return false;   
				  }
				  return true;
}
//REFERENCIA CLIENTE Y ACYCIA 
function validacion_select_refac_cliente() {
			var indice1 = document.getElementById("int_ref_ac_rc").selectedIndex;
			var indice2 = document.getElementById("int_ref_ac_rc2").selectedIndex;
			var indice3 = document.getElementById("int_ref_ac_rc3").selectedIndex;
			var indice4 = document.getElementById("id_c_rc").selectedIndex;
			var indice5 = document.getElementById("id_c_rc2").selectedIndex;
			var indice6 = document.getElementById("id_c_rc3").selectedIndex;
			if (( indice1 != '' && indice4 == '0') || (indice2 != '' && indice5 == '0') || (indice3 != '' && indice6 == '0') ) {
				  alert('Debe seleccionar un cliente');
			return false;
			}

			  // Si el script ha llegado a este punto, todas las condiciones
			  // se han cumplido, por lo que se devuelve el valor true
			  return true;
			}
			function primeraMayusc(e,solicitar){
			  // Admitir solo letras
			  tecla = (document.all) ? e.keyCode : e.which;
			  if (tecla==8) return true;
			  patron =/[\D\s]/;
			  te = String.fromCharCode(tecla);
			  if (!patron.test(te)) return false;
			  // No amitir espacios iniciales y convertir 1ª letra a mayúscula
			  txt = solicitar.value;
			  if(txt.length==0 && te==' ') return false;
			  if (txt.length==0 || txt.substr(txt.length-1,1)==' ') {
				solicitar.value = txt+te.toUpperCase();
				return false;
			  } 
			}											
				/*====================FICHA TECNICA================*/
			//ficha tecnica
				function traslape(selec) {  
				var aux = document.getElementById('auxil').value;
				if (selec.value == "TRANSLAPE") { 
				document.getElementById('B_cantforma').value = aux
 				document.getElementById('B_cantforma').disabled = false;
				}else{
			    document.getElementById('B_cantforma').value = ''
				document.getElementById('B_cantforma').disabled = true;
				}
			}	
				function tipoSello(selec) {   
				 if (selec.value != "HILO") { 
				document.getElementById('tamano_ft').value = 15;
				document.getElementById('tamano2_ft').value = 5;
				}else{
				document.getElementById('tamano_ft').value = 0;
				document.getElementById('tamano2_ft').value = 0;
				}
			}			
			
	function validacion_select_ft() {   
 
			//valida cliente ft	
			indice = document.getElementById("cliente_ft").selectedIndex;
			if( indice == null || indice == 0 ) {
				  alert('[ERROR] Debe seleccionar el cliente');
			return false;
			}
			return true;
	}
//valida radio referencias	
$(document).ready(function(){
	var solapa=document.form1.solapa_ref.value;	
 $("input[name=valora]").change(function () {	 
			var valor=($(this).val());
			    if(valor==0){
					$ ( "#solapa_ref"). val ('0.00'); 
				   $('#solapa_ref').attr('readonly', true);
                }
				if(valor > 0){
					$('#solapa_ref').attr('readonly', false);
					alert("Debe agregar un valor al campo solapa!");
 					$("#solapa_ref").show();
					$("#solapa_ref").focus();
				}				
  			});
});

/*function validarRadio(){
var i 
var ok
ok=0
var solapa=document.form1.solapa_ref.value;
for(i=0; i < document.form1.valora.length;i++){
if(document.form1.valora[i].checked)
{
ok=1
}
}
if(ok==1 && solapa=='0.00'){
alert("No seleccione sin agregar valor a la solapa!");
for (x=0; ele = document.form1.valora[x]; x++)//deselecciona el radio
{
    ele.checked = false;
	document.form1.solapa_ref.focus();//retorno el foco
}//fin de deseleccionar
return false
}
if(ok==0 && solapa!='0.00'){
alert( "Seleccione solapa sencilla o doble!" );
return false
}
return true
}*/


function primeraletra()
{
String.prototype.capitalize = function()
{
    return this.replace(/\w+/g, function(a)
    {
        return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase();
    });
};
}	
function validacion_todos_select() {

			//valida codigo empleado vacio	
			indice = document.getElementById("nombre").selectedIndex;
			if( indice == null || indice == 0 ) {
				porTagName=document.getElementsByTagName("select")[0].value;
				  alert('[ERROR] Debe seleccionar, verifique!');
				  
				  form1.nombre.focus();//importante dirigirlo al campo correspondiente, sino no funciona
			return false;
			}
  return true;
			
}
//ordenes de compra alerta de cambio de estado a facturado
function ActualizarEstadosOc() { //v1.0
if(form1.b_estado_oc.value=='5'){
   msg=confirm("Usted quiere cambiar la O.C a estado Facturado Total ?, al aceptarlo; el sistema actualizara todos los items a facturacion total de forma automatica.");
   if (msg == true){
   document.forms["form1"].submit(); 
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
  }
}

function reasignarnit(){
	alert('Si quiere modificar el Nit, debe dirigirse al linc reasignar Nit.');
	}

function ActualizarEstadosRemision() { //v1.0
if(form1.b_estado_oc.value=='5'){
   msg=confirm("Quiere cambiar la remision general a estado Facturacion total, recuerde que se cambiara tambien la O.C general pero SIN los items");
   if (msg == true){
   document.forms["form1"].submit(); 
   return true;
   }
   else if (msg == false){window.history.go(); 
   return false;
   } 
  }
}
$(document).ready(function(){  
    $("#form1").submit(function () {  
        if($("#opciones option:selected").val() == "") {  
            alert("Debe seleccionar, verifique");
			form1.opciones.focus();  
            return false;  
        } 
        if($("#opciones2 option:selected").val() == "") {  
            alert("Debe seleccionar, verifique");
			form1.opciones2.focus();   
            return false;  
        } 		
            return true; 			 
    });  
});
 
//sellado de metros lineales a kilos
function metrosakilos(){
				//REGLA DE TRES
		    var bolsas=document.getElementById("bolsas_r").value 
			var pesomillar=document.getElementById("peso_millar_op").value;
			var nuevosKilos = Math.round(bolsas * pesomillar / 1000);
			document.getElementById("kilos_r").value=nuevosKilos;
/*	var ancho=document.getElementById("ancho_ref").value;
	var bolsas=document.getElementById("bolsas_r").value 
	var calibre=document.getElementById("calibre_ref").value;
	
	//operar
 	var metrolineal = ((ancho * bolsas)/100);
				//OPERACION
			
 			var mt = 0.01;//en terminos de centimetro para ancho
			var cen = 0.1;// en termino de decimales para calibre	
			var cons = 0.467;//constante
			var calibr=(calibre*cen); <!-- en terminos de centimetros de un metro-->
			var anchodec = (mt * ancho);
  			var subKilos = (anchodec*calibr*cons);
 			var toKilos = (subKilos*metrolineal);
 			var Kilost = (toKilos);	 
			var totalkilos=Kilost.toFixed(2); 
			document.getElementById("kilos_r").value=totalkilos; */

 	}

	