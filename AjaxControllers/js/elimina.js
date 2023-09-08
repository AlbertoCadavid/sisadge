function eliminar(id,columna,proceso,url,master){
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
        eliminacion(id,columna,proceso,url,master);
      } else {     
        swal("Cancelado", "has cancelado :)", "error");
        //window.history.go();
      } 
    });  

}

function eliminacion(id,columna,proceso,url,master){ 

 
  $.ajax({
    dataType: "json",
    data: { 
      "id": id, 
      "columna": columna,
      "proceso":proceso,
      "master":master,
    },
    url: url, // '../view_index.php?c=comprasEM&a=Eliminar&columna=',
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
              location.reload(); 
            },2000);
       
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
            },2000);
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}


