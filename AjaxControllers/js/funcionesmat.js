
function sumar_valores(valoresArray) {
    suma=0;
       $.each(valoresArray, function(index, value){
         result = ( value == "" || value == "NaN" ) ? 0 : value; 
        suma += parseFloat(result);
       });
    return  suma.toFixed(2);
}

function multiplica_valores(valor1,valor2) {

  result1 = ( valor1 == "" ) ? 0 : valor1;
  result2 = ( valor2 == "" ) ? 0 : valor2;  
  
  multiplica =  parseFloat(result1) * parseFloat(result2);
  return  multiplica.toFixed(2);
} 


function dividir_valores(valor1,valor2) {

  result1 = ( valor1 == "" ) ? 0 : valor1;
  result2 = ( valor2 == "" ) ? 0 : valor2;  
  
  divide =  parseFloat(result1) / parseFloat(result2);
  return  divide.toFixed(2);
} 

function decimales(campo){

    campo.on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value ) {
                return value.replace(/\D/g, "")
                            .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    }); 

}
 

function humanizeNumber(n) {
  n = n.toString()
  while (true) {
    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
    if (n == n2) break
    n = n2
  }
  return n
}


function sumaImpuesto( precio='',vimpuesto='' ){    
   
        if(vimpuesto==''){
             vimpuesto=0;
        }
        bolsa = parseFloat(precio)+parseFloat(vimpuesto);
        bolsa = bolsa.toFixed(2);
    if(!this.checked) {
        $('#N_precio_old').val(precio);
/*        $('#valor_impuesto').val(vimpuesto);
        $('#valor').val(precio);//campo de la oc detalle
        $('#int_precio_io').val(precio);//campo de la oc detalle
        $('#precioreal').val(precio);//campo de la oc detalle*/
    } 
     //check
    if( $('#impuesto').prop('checked') ) {
         $('#valor_impuesto').val(vimpuesto);
         $("#adjuntos" ).show();
         $('#N_precio_old').val(bolsa);//nuevoprecio con impuesto
         $('#valor').val(precio);//campo de la oc detalle  
         $('#int_precio_io').val(precio);//campo de la oc detalle 
         $("#impuesto").val(1);
     }else{
         $('#valor').val(precio);//campo de la oc detalle
         $('#N_precio_old').val(precio);
         $('#int_precio_io').val(precio);//campo de la oc detalle 
         $('#valor_impuesto').val(vimpuesto);
         $('#precioreal').val(precio);//campo de la oc detalle 
         $("#impuesto").val(0); 
         $("#adjuntos" ).hide();
     }
 
  
 
}

function sumaImpuestoPacking( precio='',vimpuesto='' ){    
    
    if(vimpuesto==''){
         vimpuesto=0;
    } 

     bolsa = parseFloat(precio)+parseFloat(vimpuesto);
     bolsa = bolsa.toFixed(2);
 if(!this.checked) {
    $('#N_precio_old').val(precio);
    /*$('#valor_impuesto').val(vimpuesto);
    $('#valor').val(precio);//campo de la oc detalle
    $('#int_precio_io').val(precio);//campo de la oc detalle
    $('#precioreal').val(precio);//campo de la oc detalle*/
 } 
  //check
 if( $('#impuesto').prop('checked') ) {
      $('#valor_impuesto').val(vimpuesto);
      $( "#adjuntos" ).show();
      $('#N_precio_old').val(bolsa);//nuevoprecio con impuesto
      $('#int_precio_io').val(precio);//campo de la oc detalle 
      $('#precioreal').val(precio);//campo de la oc detalle 
      $("#impuesto").val(1);
  }else{
      $('#valor').val(precio);//campo de la oc detalle
      $('#N_precio_old').val(precio);
      $('#precioreal').val(precio);//campo de la oc detalle 
      $('#int_precio_io').val(precio);//campo de la oc detalle
      $('#valor_impuesto').val(vimpuesto);
      $("#impuesto").val(0); 
      $( "#adjuntos" ).hide();
  }
 
  
 
}


function sumaImpuestoLamina( precio='',vimpuesto='' ){    
     
     if(vimpuesto==''){
          vimpuesto=0;
     } 
 
     bolsa = parseFloat(precio)+parseFloat(vimpuesto);
     bolsa = bolsa.toFixed(2);
 if(!this.checked) {
    $('#N_precio_old').val(precio); 
 } 
  //check
 if( $('#impuesto').prop('checked') ) {
      $('#valor_impuesto').val(vimpuesto); 
      $( "#adjuntos" ).show();
      $('#N_precio_old').val(bolsa);//nuevoprecio con impuesto
      $('#int_precio_io').val(precio);//campo de la oc detalle 
      $('#precioreal').val(precio);//campo de la oc detalle 
      $("#impuesto").val(1);
  }else{
      $('#valor').val(precio);//campo de la oc detalle
      $('#N_precio_old').val(precio);
      $('#precioreal').val(precio);//campo de la oc detalle 
      $('#int_precio_io').val(precio);//campo de la oc detalle
      $('#valor_impuesto').val(vimpuesto);
      $("#impuesto").val(0); 
      $( "#adjuntos" ).show();
  }
 
  
 
}

function pesoMillar(N_ancho,N_alto,B_fuelle='',N_solapa='',N_calibre,N_tam_bol='',precio='',millar='',millarBols=''){    
 
  
    
/*    if(!this.checked) {
        bolsa= ((parseFloat(millar)+parseFloat(millarBols) )*2.12);
        sumaimpuesto = bolsa.toFixed(2);
        bolsa = parseFloat(precio)+parseFloat(bolsa);
        bolsa = bolsa.toFixed(2);

       $('#N_precio_old').val(bolsa);
       $('#valor').val(bolsa);//campo de la oc detalle
       $('#int_precio_io').val(bolsa);//campo de la oc detalle
       $('#precioreal').val(precio);//campo de la oc detalle
    } 
    if( $('#impuesto').prop('checked') ) {
       $("#impuesto").val(1);
       $('#sumaimpuesto').text(sumaimpuesto);
       $( "#adjuntos" ).show();
       $('#N_precio_old').val(bolsa); 
     }else{
         $('#N_precio_old').val($("#N_precio_old").val()); 
         $('#valor').val($("#N_precio_old").val());//campo de la oc detalle
         $('#int_precio_io').val($("#N_precio_old").val());//campo de la oc detalle
         $('#precioreal').val($("#N_precio_old").val());//campo de la oc detalle 
          $('#sumaimpuesto').text(sumaimpuesto);
         $("#impuesto").val(0); 
         $( "#adjuntos" ).hide();
     }*/
 
  
 
}


function pesoMillarPacking( precio='',millar='',millarBols=''){    
 
  
    
    if(!this.checked) {
        bolsa= ((parseFloat(millar)+parseFloat(millarBols) )*2.12);
        sumaimpuesto = ((parseFloat(millar)+parseFloat(millarBols) )*2.12);
        sumaimpuesto = sumaimpuesto.toFixed(2);
        bolsa = parseFloat(precio)+parseFloat(bolsa);
        bolsa = bolsa.toFixed(2);
 
       $('#N_precio_old').val(bolsa);//campo de la oc detalle
       $('#int_precio_io').val(bolsa);//campo de la oc detalle
       $('#precioreal').val(precio);//campo de la oc detalle
    } 
    if( $('#impuesto').prop('checked') ) {
       $("#impuesto").val(1);
       $('#sumaimpuesto').text(sumaimpuesto);
       $( "#adjuntos" ).show();
     }else{ 
         $('#N_precio_old').val($("#N_precio_old").val());//campo de la oc detalle
         $('#int_precio_io').val($("#N_precio_old").val());//campo de la oc detalle
         $('#precioreal').val($("#N_precio_old").val());//campo de la oc detalle 
          $('#sumaimpuesto').text(sumaimpuesto);
         $("#impuesto").val(0); 
         $( "#adjuntos" ).hide();
     }
 
  
 
}

function pesoMillarFormula(N_ancho,N_alto,B_fuelle='',N_solapa='',N_calibre,N_tam_bol='',precio =''){    
 
  
    
    if(!this.checked) {
        bolsa=((parseFloat(N_ancho)*parseFloat(N_alto)+parseFloat(B_fuelle)+parseFloat(N_solapa)) * parseFloat(N_calibre)*parseFloat(0.00467))+(parseFloat(N_ancho)*parseFloat(N_tam_bol)*parseFloat(1.5)*(parseFloat(0.00467)/parseFloat(2)));
        bolsa = bolsa*parseFloat(2.12);
        bolsa = parseFloat(precio)+parseFloat(bolsa);
        bolsa = bolsa.toFixed(2);
       $('#N_precio').val(bolsa);
       $('#valor').val(bolsa);//campo de la oc detalle
       $('#int_precio_io').val(bolsa);//campo de la oc detalle
       $('#precioreal').val(bolsa);//campo de la oc detalle
    } 
    if( $('#impuesto').prop('checked') ) {
       $("#impuesto").val(1);
       $( "#adjuntos" ).show();
     }else{
         $('#N_precio').val($("#N_precio_old").val()); 
         $('#valor').val($("#N_precio_old").val());//campo de la oc detalle
         $('#int_precio_io').val($("#N_precio_old").val());//campo de la oc detalle
         $('#precioreal').val($("#N_precio_old").val());//campo de la oc detalle
         $("#impuesto").val(0);
         $( "#adjuntos" ).hide();
     }
 
  
 
}

function pesoMillarFormulaCotiz(tiposolapa,N_ancho,N_alto,B_fuelle='',N_solapa='',N_calibre,N_tam_bol='',precio=''){    

        precioingresado=precio; 
         
        nuevasolapa = N_solapa >0 ? (parseFloat(N_solapa) / parseFloat(tiposolapa)) : 0;
        pesoMillar=((parseFloat(N_ancho)*parseFloat(N_alto)+parseFloat(B_fuelle)+parseFloat(nuevasolapa)) * parseFloat(N_calibre)*parseFloat(0.00467))+(parseFloat(N_ancho)*parseFloat(N_tam_bol)*parseFloat(1.5)*(parseFloat(0.00467)/parseFloat(2)));
        
        impuesto = pesoMillar*parseFloat(2.12);
       
        precio_old = parseFloat(precio)-parseFloat(impuesto);

        precio_new = parseFloat(precio);

        precio_old = precio_old.toFixed(2);
        pesoMillar = pesoMillar.toFixed(2);
        precio_new = precio_new.toFixed(2);
        impuesto = impuesto.toFixed(2);

/*    if(!this.checked) { 
       $('#N_precio').val(precioingresado);
       $('#valor_impuesto').val(impuesto); 
       $('#N_precio_old').val(precio_new); 
       $("#calculaformula").val(0);   

    }*/ 
    if( $('#calculaformula').prop('checked') ) {

        $('#N_precio').val(precio_old);
        $('#valor_impuesto').val(impuesto); 
        $('#N_precio_old').val(precio_new);  
        $("#calculaformula").val(1);
     }else{ 
          precioingresado=parseFloat(precio)+parseFloat(impuesto);; 
        $('#N_precio').val(precioingresado);
        $('#valor_impuesto').val(0); 
        $('#N_precio_old').val(precioingresado); 
        $("#calculaformula").val(0); 
     }
 
  
 
}