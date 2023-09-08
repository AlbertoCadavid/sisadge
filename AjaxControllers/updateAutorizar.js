function updateAutorizar(id,campo,pagina,oc){
   
  if(id=='Autorizar'){
    var texto = 'Si Autorizar la Orden: ' + oc + ' al despacho, es porque el Cliente ya Pagó!';
  }else{
    var texto = "No Autorizar la Orden: " + oc + " al despacho!";
  }
  swal({
    title: "Está seguro de "+id+"?",
    text: texto,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Si, "+id+" Orden!",
    closeOnConfirm: false
  },
  function(){
    if(id=='Autorizar'){
       swal(id, 'Despachos procederá a Enviarlo! Orden', 'success');
    }else{
       swal(id, "Se Procederá a Desautorizarse la Orden!", "success");
    }
    Autorizar(id,campo,pagina);
  });

}


function Autorizar(id,campo,pagina){
  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo,
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/updateAutorizar.php?"+id+"="+campo+"&pagina="+pagina, // '../AjaxControllers/Actions/delete.php',
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
      $('#autorizado').show(); 
      $('#autorizado').fadeIn(); 

      setTimeout(function() {
        $("#autorizado").fadeOut();           
      },3000);

      setTimeout(function() 
      {
        location.reload(); 
      }, 3000);

    }, 
    error:  function(xhr,err){ 
     $('#autorizado').show(); 
     $('#autorizado').fadeIn();     
     setTimeout(function() {
      $("#autorizado").fadeOut();           
    },3000);

     setTimeout(function() 
     {
      location.reload(); 
    }, 3000); 
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}


