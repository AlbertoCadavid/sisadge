function updateConAlert(form,vista) {
 
  swal({   
   title: "ACTUALIZAR?",   
   text: "Esta seguro que Quiere Actualizar al Consecutivo! N."+consecFinal,   
   type: "warning",   
   showCancelButton: true,   
   confirmButtonColor: "#DD6B55",   
   confirmButtonText: "Si, Actualizar!",   
   cancelButtonText: "No, Actualizar!",   
   closeOnConfirm: false,   
   closeOnCancel: false }, 
   function(isConfirm){   
     if (isConfirm) {  
       swal("Actualizado!", "El registro se ha Actualizado.", "success"); 
       updateSinAlert('UpdateSiTick='+'1',form,vista);//este actualiza en base
       popUpImprimir(vista+'?'+form, '900', '800');//este muestra la ventana poup
     } else { 
       swal("Cancelado", "has cancelado :)", "error");
       //window.history.go();
     } 
   });  
  
}


function updateSinAlert(UpdateSiTick,form,vista=''){
  
  $.ajax({
    dataType: "json",
    data: {
      "UpdateSiTick":UpdateSiTick,
      "form": form, 
      "vista":vista,
    },
    url:  "AjaxControllers/Actions/update.php?UpdateSiTick="+UpdateSiTick+"&"+form+"&vista="+vista,
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
      
    }
  });
}


function popUpImprimir(URL, ancho, alto ){
  day = new Date();
  id = day.getTime();
  derecha=(screen.width-ancho)/2;
  arriba=(screen.height-alto)/2;
  ventana="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
  eval("page" + id + " = window.open(URL, '" + id + "', '" + ventana + "');");
}