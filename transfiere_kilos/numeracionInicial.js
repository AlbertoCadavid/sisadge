	 	 function consultaNumeracionInicio(op,bolsas=''){ 
		   
		     var getUrl = window.location; 
             var baseurl =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]; 
			  $.ajax({
			    dataType: "json",
			    data: { 
			      "int_op_tn": op,
			    },
			     url: baseurl+"/AjaxControllers/Actions/consultas.php?int_op_tn="+op, 
			    type:  'post', 
			  }).done(function( data, textStatus, jqXHR ) { 

			     if(data) { 
			           $("#numInicioControl").val(data.numInicio_op);  
     			       $("#n_ini_rp").val(data.numInicio_op); 
     			   
			     } 
			
			   }).fail(function( jqXHR, textStatus, errorThrown ) {
			     if ( console && console.log ) {
			       //console.log( "La solicitud a fallado: " +  textStatus);
			     }
			   });  
		} 
 

    function numeracionDesdeLiquidacion(bolsas='',numDesde) { 
                
				var desde=numDesde; 
				var dividida = numeracionChar(desde); 
				var numeros = dividida[0];
				var cadena = dividida[1];
				var sumoUno = parseInt(numeros) +parseInt(1);
                var bolsas=bolsas=='' ? 0 :bolsas;
                        var cerosizq = cerosIzquierda(desde,sumoUno); //codigos especiales 
                    	  if(cerosizq!=undefined){
                    	    var sumoUno = cerosizq; 
                    	  } 
				document.form1.n_ini_rp.value=cadena+sumoUno;		
				var tnum=parseInt(numeros)+parseInt(bolsas);
				//document.form1.n_fin_rp.value=cadena+tnum; 
	  

    }


 
    //FUNCION GENERAL AUXILIARES FALTANTES DE TIQUETES SELLADO  
    function numeracionChar(carac){
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
    			solonumeros=num;	
    			return [  solonumeros, cadena ]; 		
    		}else
    		//solo numeros 
    		if( n=='0'){			
    			var v = caract; 
    			var num = v.substring(0);
    			var vacia="";	 
    			solonumeros=num; 
    			return [ solonumeros, vacia ];		
    		}else
    		//letras al inicio 
    		if(l=='0' && z!='0'&& n!='0'){
    		//caract.match(/\d+/g).join('');
    		l=caract.match(/\D+/g); //D acepta diferente de numeros
    		cadena=l; 
    		solonumeros=caract.match(/\d+/g); //d acepta solo numeros

    		    var cerosizq = cerosIzquierda(caract,solonumeros); //codigos especiales 
    			  if(cerosizq!=undefined){
    			    var solonumeros = cerosizq; 
    			  } 
    		return [ solonumeros, cadena ];		 		
    		}//fin if
    }

    function cerosIzquierda(conletras,solonumero){
    	var ceros=(conletras.search(/EM|MQ/i));//codigos especiales 
    	 if(ceros== 0 ){
    	  var cuantos = 8;
    	   codigo = solonumero.toString().padStart(cuantos, "0");
    
            return codigo;	//si es cero es porq lo encuentra
    
        }
    
    }
 

    function buscaDigitos(caract){
     
        var codigo = caract.split("-");//hasta el guion
        if(codigo[1]){
 
            return codigo;	
 
        }
    
    }