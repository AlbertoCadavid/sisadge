function actualizar(id,valor,colum,proceso,url){
 
   var valor = $(valor).val();
   var columna = $(colum).attr("id");
 
   swal({   
    title: "Actualizar?",   
    text: "Esta seguro que Quiere Actualizar!",   
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
        actualizacion(id,valor,columna,proceso,url);
      } else {     
        swal("Cancelado", "has cancelado :)", "error");
        
      } 
    });  

}

function actualizacion(id,valor,colum,proceso,url){ 
  var valor = $(valor).val();
  var columna = $(colum).attr("id");
  
  $.ajax({
    dataType: "json",
    data: { 
      "id": id, 
      "valor": valor, 
      "columna":columna,
      "proceso":proceso,
    },
    url: url, // '../view_index.php?c=comprasEM&a=Actualizar&columna=',
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
             //location.reload(); 
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
             // location.reload(); 
            },2000);
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}


function actualizacionBoton(id,valor,colum,proceso,url,tabla){ 
  
  $.ajax({
    dataType: "json",
    data: { 
      "id": id, 
      "valor": valor, 
      "colum":colum,
      "proceso":proceso,
      "url":url,
      "tabla":tabla
    },
    url: url, // '../view_index.php?c=comprasEM&a=Actualizar&columna=',
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
       $('#resp2').show(); 
       $('#resp2').fadeIn(); 

       setTimeout(function() {
        $("#resp2").fadeOut();           
      },2000);

       setTimeout(function() 
            {
             //location.reload(); 
            },2000);
       
    },
    error:  function(xhr,err){ 
       $('#resp2').show(); 
       $('#resp2').fadeIn();     
       setTimeout(function() {
        $("#resp2").fadeOut();           
      },2000);
       
       setTimeout(function() 
            {
             // location.reload(); 
            },2000);
      //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
    }
  }); 
}

function actualizapaso(ids,valorid,valores,tabla,url){ 
  var name = $(valores).attr("name");
  var valorc = $(valores).val();
   
  $.ajax({
      dataType: "json",
      data: { 
        "ids": ids, 
        "valorid": valorid, 
        "name":name,
        "valorc":valorc,
        "tabla":tabla,
        "url":url,
      },
      url: url, // '../view_index.php?c=comprasEM&a=Actualizar&columna=',
      type:  'post',  

      
      beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
      },
      success: function(data ){
           if(data==1){
              $('#AlertUpdate').show(); 
              $('#AlertUpdate').attr('style','display: none;  align-items: center; justify-content: center;color: green;'); 
              $("#AlertUpdate").text('Registro Actualizado... !');
              $('#AlertUpdate').fadeIn(); setTimeout(function() { $("#AlertUpdate").fadeOut(); },2000);    

           }else{
             $('#AlertUpdate').show(); 
             $('#AlertUpdate').attr('style','display: none;  align-items: center; justify-content: center;color: red;'); 
             $("#AlertUpdate").text('Error: No se Actualizado Registro ');
             $('#AlertUpdate').fadeIn(); setTimeout(function() { $("#AlertUpdate").fadeOut(); },2000);  
           }
      } 
  });  
} 


//envio form completo sin onSubmit
function updates(ids,colum,tabla,url){
 
  $.ajax({
    dataType: "json",
    data: {
      "id": ids,
      "colum": colum, 
      "tabla":tabla,
      "url":url 
    },
    url:  url+$("#form1").serialize(),//+id+'='+id+"&campo="+campo+"&pagina="+pagina, 
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(respuesta){
      //lo que se si el destino devuelve algo
      if(respuesta==1){
         $('#AlertUpdates').show(); 
         $('#AlertUpdates').attr('style','display: none;  align-items: center; justify-content: center;color: green;'); 
         $("#AlertUpdates").text('Registro Actualizado... !');
         $('#AlertUpdates').fadeIn(); setTimeout(function() { $("#AlertUpdates").fadeOut(); },4000);    

      }else{
        $('#AlertUpdates').show(); 
        $('#AlertUpdates').attr('style','display: none;  align-items: center; justify-content: center;color: red;'); 
        $("#AlertUpdates").text('Error: No se Actualizado Registro ');
        $('#AlertUpdates').fadeIn(); setTimeout(function() { $("#AlertUpdates").fadeOut(); },4000);  
      }
      setTimeout(function() {
        $("#AlertUpdates").fadeOut();           
      },4000);

      setTimeout(function() 
      {
        //location.reload(); 
      }, 4000);

    }, 
    error:  function(xhr,err){ 
     $('#AlertUpdate').show(); 
     $('#AlertUpdate').fadeIn();     
     setTimeout(function() {
      $("#AlertUpdate").fadeOut();           
    },4000);

     setTimeout(function() 
     {
      //location.reload(); 
    }, 4000); 
   
    }
  }); 

}