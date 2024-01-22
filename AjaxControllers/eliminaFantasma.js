//eliminar registro completamente
function eliminar_fantasma(id,campo,pagina){

   swal({   
    title: "ELIMINAR?",   
    text: "Esta seguro que Quiere Eliminar! id: "+campo,   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Si, eliminar!",   
    cancelButtonText: "No, eliminar!",   
    closeOnConfirm: false,   
    closeOnCancel: false }, 
    function(isConfirm){   
      if (isConfirm) {  
        configEliminacion(id,campo,pagina);
        swal("Eliminado!", "El registro se ha eliminado.", "success"); 
      } else {     
        swal("Cancelado", "has cancelado :)", "error");
        window.history.go();
      } 
    });  

}
 
function configEliminacion(id,campo,pagina){

  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo,
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/delete.php?"+id+"="+campo+"&pagina="+pagina, // '../AjaxControllers/Actions/delete.php',
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
      if(respuesta){
       $('#resp').show(); 
       $('#resp').fadeIn(); 
        
      }

       setTimeout(function() {
        $("#resp").fadeOut();           
      },2000);

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
      },2000);
       
       setTimeout(function() 
            {
              location.reload(); 
            }, 3000);
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}
