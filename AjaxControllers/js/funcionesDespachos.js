	//------------------FUNCION PARA AGREGAR ITEMS DINAMICOS----//
	

  

	var num=0;
	function AddItemd() {
	  var contador = num++ ;
		var tbody = null;
		var tablaf = document.getElementById("tablaf");
		var nodes = tablaf.childNodes;
		var count = 0;
        var acumula = 0;
        
		        var falt =  document.getElementsByClassName("focusNext"); 
		    	var numDivs = falt.length; 
		    	var contadorNaranja = 0; 
		    	for(var i = 0; i < numDivs; i++){
		    	  if(falt[i].className == "focusNext") 
		    	     contadorNaranja++;
		    	   var acumula = contadorNaranja == 'NaN' ? 0 : contadorNaranja;
		    	 
		    	}

		for (var x = 0; x<nodes.length;x++) {
			if (nodes[x].nodeName == 'TBODY') {
				tbody = nodes[x];
				break;
			}
			count=acumula+x; 

	 
		}
		if (tbody != null) {
			  //$("#int_caja_rd").val(contador); 
			valorKilo = document.getElementById("valorKilo").value; //'+valorKilo+'
			cantotal = document.getElementById("int_cantidad_rest_io").value;
			var tr = document.createElement('tr');
			tr.innerHTML = '<td><input type="hidden" style="width:40px;" id="int_pesoneto_rd" name="int_pesoneto_rd[]"  value='+ num + ' required="required" /></td><td><input type="text" style="width:40px;" id="int_caja_rd" name="int_caja_rd[]" onKeypress="EnteryTap(event,this);" value='+contador+'  required="required" /></td><td><input type="text" style="width:150px;" id="int_numd_rd" name="int_numd_rd[]" onKeypress="EnteryTap(event,this);" onChange="CalcularRango(this);" onBlur="MayusEspacio(this);" value="" required="required" /></td><td><input type="text"  style="width:150px;"  id="int_numh_rd" name="int_numh_rd[]" onKeypress="EnteryTap(event,this);" onChange="CalcularRango(this);" onBlur="MayusEspacio(this);" value="" required="required" /></td><td><input type="text" style="width:80px;" id="int_cant_rd" name="int_cant_rd[]" value="'+cantotal+'" required="required" onChange="CalcularRango(this);" onKeypress="EnteryTap(event,this);" /></td><td><input type="text" style="width:80px;" id="int_peso_rd" name="int_peso_rd[]" value="'+valorKilo+'"  required="required" onKeypress="EnteryTap(event,this);" /></td><td><input tabindex="-1" type="text" style="width:80px;" size="2" id="total" name="total[]" readonly /></td><td><button tabindex="-1" class="botonDel" type="button" value="Borrar" onclick="eliminaItemDespacho(this);CalcularRango(this);">Borrar</button></td>';
			tbody.appendChild(tr);
		}
 
	}


	//consulata valor kilo x cada 1000 bolsas
	function valorx100bolsas(){
	 kilosDesp = document.getElementById("valorKilo").value; 
	  alert(kilosDesp) 
	  $.ajax({ 
	    type:  'post',
	    url: 'funciones/funciones_php.php',
	    data:{
	     "kilosDesp": kilosDesp, 
	    },
	   dataType: 'json',//define las variables a mostrar 
	 }).done(function( data, textStatus, jqXHR ) {

	   if(data) {
	    var html = '';
	      var i;
	      for (i = 0; i < data.length; i++) { 
	         alert(data[i].cod_ref); 
	      }
	       
	   } 
	 }).fail(function( jqXHR, textStatus, errorThrown ) {
	   if ( console && console.log ) {
	     console.log( "La solicitud a fallado: " +  textStatus);
	   }
	 });  
	
	}


	function EnteryTap(evt,obj){
		// Si el evento NO es una tecla Enter
		tecla=(document.all) ? evt.keyCode : evt.which;
	  
		if (tecla!=13 && tecla != 9) {
		  return;
		}
		 
		let element = evt.target;

		// Si el evento NO fue lanzado por un elemento con class "focusNext"
		if (!element.classList.contains('focusNext')) {
		  return;
		}
	
		// AQUI logica para encontrar el siguiente
		let tabIndex = element.tabIndex + 1;
		var next = document.querySelector('[tabindex="'+tabIndex+'"]'); 
	
		// Si encontramos un elemento
		if (next) {
		  next.focus();
		  event.preventDefault();
		}
	}

		//------------------FUNCION PARA RESTAR HASTA MENOS DESDE----//
		function CalcularRango(ele) {
			ahasta = '';adesde='';
			var num="",caden="",l="",b="",c="",d="",e="",g="",h="",desde="", sal="",sal2="",cadena="";
			var int_numd_rd = 0, int_numh_rd = 0, total = 0;
			var tr = ele.parentNode.parentNode;
			var nodes = tr.childNodes;
			for (var x = 0; x<nodes.length;x++) { 
	          	//------------------CADENA DEFINIDA DESDE-------------------//	
	          	if (nodes[x].firstChild.name == 'int_numd_rd[]') {
	          		int_numd_rd = (nodes[x].firstChild.value); 
	          		if(int_numd_rd!='') {
	            		var codigos = divideCadenas(int_numd_rd); 
	            		var adesde = codigos[0]; 
	            		var cadena = codigos[1];

	          		} 		
	          	}//FIN IF INPUT DESDE
	          	//------------------CADENA DEFINIDA HASTA-------------------// 
	          	if (nodes[x].firstChild.name == 'int_numh_rd[]') {
	          		int_numh_rd = (nodes[x].firstChild.value); 
	          		if(int_numh_rd!='') {    
	            		var codigos = divideCadenas(int_numh_rd); 
	            		var ahasta = codigos[0]; 
	            		var cadena = codigos[1];
	          		}  	
	          	}//FIN IF INPUT HASTA


	          	//------------INPUT CADENA SUBTOTAL-------------------------//  
	            	if(nodes[x].firstChild.name == 'total[]') {
	                	if(ahasta !='' && adesde!=''){
	                	   int_total = parseInt((ahasta-adesde),10);
	                	   total=(int_total+1);
	                	   nodes[x].firstChild.value = total;
	                	}else{
	                	   nodes[x].firstChild.value = 0;

	                	}

	            	}//FIN IF INPUT TOTAL
                   
                    //valor x 100 bolsas 
                 	if (nodes[x].firstChild.name == 'int_cant_rd[]') {
                 		int_cant_rd = (nodes[x].firstChild.value); 
                 		if(int_cant_rd!='0' || int_cant_rd!='') {    
                   		var int_cant_rd = int_cant_rd;  
                 		}   	
                 	}
                 	if (nodes[x].firstChild.name == 'int_peso_rd[]') {
                 		int_peso_rd = (nodes[x].firstChild.value); 
                 		if(int_peso_rd!='0' || int_peso_rd!='') {    
                   		   var int_peso_rd = int_peso_rd;  
                 		}else{
                 		 
	                	    nodes[x].firstChild.value = document.getElementById("valorKilo").value;
                 		} 	
	                  
                 	}
                 	if(nodes[x].firstChild.name == 'int_peso_rd[]') {
	                		valorKilo = document.getElementById("valorKilo").value;
	                		canttotal = document.getElementById("int_cantidad_rest_io").value;  
	                	if(int_cant_rd!=''){
	                	  
	                	   valor = (parseFloat(int_cant_rd)*parseFloat(valorKilo))/parseFloat(canttotal);
	                	   valor = parseFloat(valor).toFixed(2);
	               		   nodes[x].firstChild.value = valor;
	                	  
	                	}else{
	                	   nodes[x].firstChild.value  = document.getElementById("valorKilo").value;
                           
	                	}
	                	
	                } 	            
		    }//FIN FORDE NODOS
 
			
		//------------------CAMPO TOTAL TOTAL----------------------------// 
		var total2 = document.getElementById("total2");
		if (total2.innerHTML == 'NaN') {
			total2.innerHTML = 0;
		}else{ 
			    var totalF = document.getElementsByName('total[]'), contadorf = 0, i;
			     for(i = totalF.length; i--;)
				    if(totalF[i].value)
					    contadorf += parseInt(totalF[i].value, 10); 
		        total2.innerHTML = contadorf; //parseInt(total.innerHTML)+parseInt(total);//CONTADOR PARA TOTAL 
		}
		 
		//------------------ALERTAS FUERA DEL FOR------------------// 
		function alertaSupera() {
			var Alfa=document.form1.int_numd_rd.value;
			var Omega=document.form1.int_numh_rd.value;
			var codigos = divideCadenas(Alfa); 
			var Alfa = codigos[0];
			var cadena = codigos[1];
				/*var codigos = divideCadenas(Omega); 
				var Omega = codigos[0]; */
				//valida que el desdef no sea menor que el desde ni el hastaf sea menor que el desdef 
	        if(ahasta !='' && adesde!=''){
	    			if(adesde<Alfa || ahasta<Alfa){
	    				swal("La numeracion inicial: "+cadena+adesde+" o final: "+cadena+ahasta+" de uno de los Rangos, no debe ser Menor que la numeracion inicial: "+cadena+Alfa+" ")
	    				return false; 
	    			}
	    				return true;

	        }
	    }
		alertaSupera()//LLAMA LA FUNCION DE FALTANTES 

		}//FIN FUNCION

		//---FUNCION ELIMINA LINEA DE INPUT DE FALTANTES DINAMICOS-----//
		function eliminaItemDespacho(obj){
			var oTr = obj;
			while(oTr.nodeName.toLowerCase()!='tr'){
				oTr=oTr.parentNode;
			} 
			var root = oTr.parentNode;
			root.removeChild(oTr);
		}
		//=======================================================FIN=========================================================//

		//FUNCION GENERAL  
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
				//letras al inicio 
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