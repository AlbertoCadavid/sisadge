//eliminar registro completamente
function eliminar(id,campo,pagina='',id_add=''){

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
        swal("Eliminado!", "El registro se ha eliminado.", "success"); 
        eliminacion(id,campo,pagina,id_add);
      } else {     
        swal("Cancelado", "has cancelado :)", "error");
        window.history.go();
      } 
    });  
}

function eliminarItemProdTerm(id,campo,pagina='',id_add=''){
  
  Swal.fire({
    title: "ELIMINAR?",
    text: "Esta seguro que Quiere Eliminar!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!"
  }).then((result) => {
    if (result.isConfirmed) {
      swal.fire("Eliminado!", "El registro se ha eliminado.", "success"); 
        eliminacion(id,campo,pagina,id_add);
    }else {     
      swal.fire("Cancelado", "has cancelado :)", "error");
      window.history.go();
    } 
  });  
}

function eliminacion(id,campo,pagina='',id_add=''){ 
  
  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo,
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/delete.php?"+id+"="+campo+"&pagina="+pagina+"&id_add="+id_add, // '../AjaxControllers/Actions/delete.php',
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



function eliminacionyConsulta(id,campo,pagina='',id_add=''){ 
  $.ajax({
    dataType: "json",
    data: {
      "id": id,
      "campo": campo,
      "pagina":pagina,
    },
    url:  "AjaxControllers/Actions/delete.php?"+id+"="+campo+"&pagina="+pagina+"&id_add="+id_add, // '../AjaxControllers/Actions/delete.php',
    type:  'post',
    beforeSend: function(){
      //Lo que se hace antes de enviar el formulario
    },
    success: function(data){
      //lo que se si el destino devuelve algo
       $('#resp').show(); 
       $('#resp').fadeIn(); 

       setTimeout(function() {
        $("#resp").fadeOut();           
      },2000);
       
            if(data) { 
              var html = '';
              var i; 
            
              for (i = 0; i < data.length; i++) {
            
                html += '<tr>' + 
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Nombre Responsable" id="nombre_responsable" name="nombre_responsable" value="'+data[i].nombre_responsable+'" class="campostext" ></td>' +
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Direccion" id="direccion" name="direccion" value="'+data[i].direccion+'" class="selectsMMedio"></td>' +
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Indicativo" id="indicativo" name="indicativo" value="'+data[i].indicativo+'" class="campostextMini"></td>' +
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Telefono" id="telefono" name="telefono" value="'+data[i].telefono+'" class="campostextMini"></td>' +
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Extension" id="extension" name="extension" value="'+data[i].extension+'" class="campostextMini"></td>' +
                '<td nowrap="nowrap"><input onChange="Updates('+data[i].id+',this)" type="text" required="required" placeholder="Ciudad" id="ciudad" name="ciudad" value="'+data[i].ciudad+'" class="campostextMini"></td>' +
                '<td nowrap="nowrap" ><button onClick="eliminacionyConsulta('+"'id_bodega'"+','+data[i].id+','+"'pagina'"+','+data[i].id_d+')" id="btnDelItems" name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
                '</tr>'; 
              }
                  
              $('#DataResult').html(html);
              $("#AlertItem").show();
              $("#AlertItem").text('Eliminado correctamente... !');  
              setTimeout(function() {
                  $("#AlertItem").fadeOut();           
                 },2000);
            }
         
    },
    error:  function(xhr,err){ 
       
    }
  }); 
}