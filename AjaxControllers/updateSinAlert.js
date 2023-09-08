
function updateSinAlert(id,campo,pagina){
 
  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo,
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/update.php?"+id+"="+campo+"&pagina="+pagina,
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