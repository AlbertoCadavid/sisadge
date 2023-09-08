//Actualiar registro completamente
//GENERAL
function updates(id,campo,pagina=''){

   swal({   
    title: "Actualiar?",   
    text: "Esta seguro que Quiere Actualiar y Finalizar! id: "+campo,   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Si, Actualiar!",   
    cancelButtonText: "No, Actualiar!",   
    closeOnConfirm: false,   
    closeOnCancel: false }, 
    function(isConfirm){   
      if (isConfirm) {  
        swal("Actualizado!", "El registro se ha Actualizado.", "success"); 
        actualizacion(id,campo,pagina);
      } else {     
        swal("Cancelado", "has cancelado :)", "error");
        window.history.go();
      } 
    });  

}
//GENERAL
function actualizacion(id,campo,pagina=''){ 
  $.ajax({
    dataType: "json",
    data: { 
    },
    url: 'AjaxControllers/Actions/update.php?'+$("#form1").serialize(),
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
       $('#resp').show(); 
       $('#resp').fadeIn(); 

       setTimeout(function() {
        $("#resp").fadeOut();           
      },2000);

       setTimeout(function() 
            {
              window.location=pagina;
            }, 2000);
       
    },
    error:  function(xhr,err){ 
       $('#resp').show(); 
       $('#resp').fadeIn();     
       setTimeout(function() {
        $("#resp").fadeOut();           
      },2000);
       
       setTimeout(function() 
            {
               window.location=pagina;
            }, 2000);
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}


function updateGeneral(id,campo,cualfuncion,pagina ){
 
  swal({   
   title: "ACTUALIZAR?",   
   text: "Esta seguro que Quiere Actualizar " ,   
   type: "warning",   
   showCancelButton: true,   
   confirmButtonColor: "#DD6B55",   
   confirmButtonText: "Si, Actualizar!",   
   cancelButtonText: "No, Actualizar!",   
   closeOnConfirm: false,   
   closeOnCancel: false }, 
   function(isConfirm){   
     if (isConfirm) {  
       swal("Actualizado!", "Los registros se han Actualizado.", "success"); 
       cualfuncion(id,campo,pagina);//este actualiza en base
        
     } else {     
       swal("Cancelado", "has cancelado :)", "error");
       //window.history.go();
     } 
   }); 

}


function updateList(id,campo,pagina){
    swal({
      title: "Factura!",
      text: "Ingrese el Numero Factura:",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      inputPlaceholder: "Escribe el Número"
    }, function (inputValue) {
      if (inputValue === false) return false;
      if (inputValue === "") {
        swal.showInputError("El campo es Obligatorio!");
        return false
      }
      swal("Listo!", "Tu Número: " + inputValue, "success");
      configUpdate(id,campo,pagina,inputValue);
    });
}


 function updateListProf(id,campo,pagina){
    swal({
      title: "Proforma!",
      text: "Ingrese el Numero Proforma:",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      inputPlaceholder: "Escribe el Número"
    }, function (inputValue) {
      if (inputValue === false) return false;
      if (inputValue === "") {
        swal.showInputError("El campo es Obligatorio!");
        return false
      }
      swal("Listo!", "Tu Número: " + inputValue, "success");
      configUpdate(id,campo,pagina,inputValue);
    });
} 


function configUpdate(id,campo,pagina,valor){
  $.ajax({
    dataType: "json",
    data: {
      "id":id,
      "campo":campo,
      "pagina":pagina,
      "valor":valor
    },
    url:  "AjaxControllers/Actions/update.php?"+id+"="+campo+"&pagina="+pagina+"&valor="+valor, // '../AjaxControllers/Actions/delete.php',
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
       $('#resp').show(); 
       $('#resp').fadeIn(); 

       setTimeout(function() {
        $("#resp").fadeOut();           
      },3000);

       setTimeout(function() 
            {
              location.reload(); 
            }, 3000);
        
    }, 
    error:  function(xhr,err){ 
       $('#resp').show(); 
       $('#resp').fadeIn();     
       setTimeout(function() {
        $("#resp").fadeOut();           
      },3000);
       
        setTimeout(function() 
            {
              location.reload(); 
            }, 3000); 
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}

 
/*function updatenumFactura(id,campo,pagina){
   alert($("#form1").serialize());
  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo, 
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/update.php?"+$("#form1").serialize(),//+id+'='+id+"&campo="+campo+"&pagina="+pagina, 
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
      $('#updatefac').show(); 
      $('#updatefac').fadeIn(); 

      setTimeout(function() {
        $("#updatefac").fadeOut();           
      },3000);

      setTimeout(function() 
      {
        //location.reload(); 
      }, 3000);

    }, 
    error:  function(xhr,err){ 
     $('#updatefac').show(); 
     $('#updatefac').fadeIn();     
     setTimeout(function() {
      $("#updatefac").fadeOut();           
    },3000);

     setTimeout(function() 
     {
      //location.reload(); 
    }, 3000); 
   
    }
  }); 

}*/