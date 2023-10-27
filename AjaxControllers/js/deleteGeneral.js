 function sinconsumo(id,campo,pagina='',id_add='',msn='',funcionn ){
     var funcionn=funcionn;
     swal({   
      title: "ELIMINAR?",   
      text: msn+campo,   
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
          funcionn(id,campo,pagina,id_add,msn='');
        } else {     
          swal("Cancelado", "has cancelado :)", "error");
          /*window.history.go();*/
        } 
      });  
  }

  /* INICIO Eliminar e inmediatamente Actualizar el id de liquidacion en los rollos */
  function eliminacionYactualizacion(id,campo,pagina='',id_add='',msn='', funcionn1, funcionn2, array){
    var funcionn1=funcionn1;
    var funcionn2=funcionn2;

     swal({   
      title: "ELIMINAR?",   
      text: msn+campo,   
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
          funcionn1(id,campo,pagina,id_add,msn='');
          array.forEach(element => {
            funcionn2(element, "id_r");
          });
        } else {     
          swal("Cancelado", "has cancelado :)", "error");
          /*window.history.go();*/
        } 
      });
  }
  function actualizacion(id,campo,pagina=''){ 
    $.ajax({
      dataType: "json",
      data: { 
      },
      url: 'AjaxControllers/Actions/update.php?'+"act_rollos=true&"+campo+"="+id,
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
  /* FIN Eliminacion liquidacio y Actualizacion de rollos*/


  function eliminacionAlSalirPopUp(id,campo,pagina='',id_add='',msn=''){ 
    $.ajax({
      dataType: "json",
      data: {
        "id": id,
        "campo": campo,
        "pagina":pagina,
      },
      url:  "AjaxControllers/Actions/delete.php?"+id+"="+campo+"&pagina="+pagina+"&id_add="+id_add+"&msn="+msn, // '../AjaxControllers/Actions/delete.php',
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
                window.close();
                //location.reload(); 
              },2000);
        //alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
      }
    }); 
  }

  function eliminacionAlSalir(id,campo,pagina='',id_add='',msn=''){ 
    $.ajax({
      dataType: "json",
      data: {
        "id": id,
        "campo": campo,
        "pagina":pagina,
      },
      url:  "AjaxControllers/Actions/delete.php?"+id+"="+campo+"&pagina="+pagina+"&id_add="+id_add+"&msn="+msn, // '../AjaxControllers/Actions/delete.php',
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