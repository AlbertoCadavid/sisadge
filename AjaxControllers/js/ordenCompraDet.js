  $(document).ready(flete);


  function flete(){  
      if (document.getElementById('cobra_flete').checked)
      {
        
        elem = document.getElementById('recuadro') ;
        elem.style.display = 'block'; 
      }else{
        document.getElementById('precio_flete').value='';
        elem.style.display = 'none'; 
        
      }
  } 

 function submitform(){
  var date1=(document.form1.fecha_ingreso_oc.value);
  var date2=(document.form1.fecha_entrega_io.value);
  var precio = document.getElementById('precio_flete').value; 
      indice = document.getElementById("str_direccion_desp_io").selectedIndex;
  var vendedor = document.getElementById("int_vendedor_io").selectedIndex;
  var total_item = document.getElementById('int_total_item_io').value;  

   if(document.getElementById('cobra_flete').checked && precio==''){
    swal("Debe agregar un valor al Flete!");
    return false;
  }else if( total_item == '') { 
    swal('El TOTAL del Item no debe estar vacio! ');
    return false;
  }else if( indice == null || indice == '' || indice == 0) { 
    swal('Debe Seleccionar una DIRECCION de DESPACHO, sino existe ingresela en el perfil del cliente');
    return false;
  }else if( vendedor == '') { 
    swal('Debe Seleccionar un VENDEDOR, sino existe ingresela en el perfil del cliente');
    return false;
  }else if(date1 > date2) { 
    swal("la fecha de entrega no puede ser menor a la fecha de ingreso");
    return false; 
  }else{
    document.form1.submit();
     //form1.submit();
     return true;
      }
 

  } 

  //VALIDA PRECIOS SEGUN MONEDA EN LAS O.C
  function itemsoc()
  {
  var cantidad=parseFloat(document.form1.int_cantidad_io.value).toFixed(2);
  var valor=parseFloat(document.form1.valor.value).toFixed(2);//valor
  var valorimpuesto=parseFloat(document.form1.N_precio_old.value).toFixed(2);//valor
  var valor_trm=parseFloat(document.form1.trm.value);
  var moneda = String(document.form1.str_moneda_io.value); 

     if(moneda=="COL$") {
      var z=(cantidad*valorimpuesto).toFixed(2); 
      var w = Math.round(z * Math.pow(10,2))/Math.pow(10,2);
      var valortrm = (valorimpuesto * valor_trm);
      document.form1.int_precio_io.value=valor;
      document.form1.int_precio_trm.value='0';
      document.form1.int_total_item_io.value=w; 
   
    }
    if(moneda=="USD$"){
      var valortrm = Math.round(valorimpuesto * valor_trm);//me da el millar en pesos
      var z=(cantidad*valorimpuesto).toFixed(2);
      var w = Math.round(z * Math.pow(10,2))/Math.pow(10,2);
      document.form1.int_precio_io.value=valortrm;//guardo el millar en pesos
      document.form1.int_precio_trm.value=valor;//guardo el valor millar en dolares
      document.form1.int_total_item_io.value=w;//se guarda el total de cantidades en dolares    
    
    }
    if(moneda=="EUR&euro;"){
      var valortrm = Math.round(valor * valor_trm);
      var z=(cantidad*valorimpuesto).toFixed(2);
      var w = Math.round(z * Math.pow(10,2))/Math.pow(10,2);
      document.form1.int_precio_io.value=valortrm;
      document.form1.int_precio_trm.value=valor;
      document.form1.int_total_item_io.value=w;     
    }
  }
/*  const flete = () => {

   document.querySelector(".recuadro").classList.toggle("ocultar");
 
  }*/