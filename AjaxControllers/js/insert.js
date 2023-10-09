 

/*function Guardar() {

 
 
      swal({   
      title: "GUARDAR?",   
      text: "Esta seguro que Quiere Guardar.",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Guardar!",   
      cancelButtonText: "No, Guardar!",   
      closeOnConfirm: false,   
      closeOnCancel: false }, 
      function(isConfirm){   
        if (isConfirm) {  
           estrue = guardarConAlert();
           if(estrue)
          swal("Guardando!", "Se esta Guardando.", "success");  
          } else {     
            swal("Cancelado", "has cancelado :)", "error"); 
          } 
        }); 

 
      }*/

      function guardarConAlert(id){
      
        $.ajax({ 
          type: $("#form1").attr("method"),
          url: 'AjaxControllers/Actions/'+$("#form1").attr("action")+'?'+$("#form1").serialize(),
          data: $("#form1").serialize(), 
          success: function(data){   
            $('#alertG').show(); 
            if(data==1) {
              $("#alertG").text('Guardando correctamente... !');
               //$("#btnEnviarG").text('Guardado ... !'); 
               $("#btnEnviarG").hide(); 
               $('#btnFinalizar').show(); 
               $('#items').show(); 
             }
             else {
               $("#alertG").text('Se Guardo');  
             } 
             $('#alertG').fadeIn(); 

             setTimeout(function() {
               $("#alertG").fadeOut();           
                   },3000);//lo q tarde activo

             setTimeout(function() 
             {
                //window.history.go();
                window.location="insumos_interno_entrada_salida_vista.php?id_remision="+id; 
              },2000); 
           },
           error: function(data){
             $('#alertG').show(); 
             $('#alertG').fadeIn();     
             setTimeout(function() {
               $("#alertG").fadeOut();           
             },1000);

             setTimeout(function() 
             {
               window.history.go();
             }, 1000);   
           }
         }); 

      }


      function guardarConAlertItems(){
 
        $.ajax({ 
          type: $("#formItems").attr("method"),
          url: 'AjaxControllers/Actions/'+$("#formItems").attr("action")+'?'+$("#formItems").serialize(),
          data: $("#formItems").serialize(), 
         dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {

         if(data) {
           $("#AlertItem").text('Guardando correctamente... !');  
           $("#insumo").val(''); 
           $("#tipo").val('');
           $("#peso").val('');
           $("#precio").val('');
           $("#cantidad").val('');
           //$("#grid").load();
           //$("#btnEnviarItems").text('Guardando ... !');
           
           var html = '';
           var i;
           for (i = 0; i < data.length; i++) {
             html += '<tr>' +
             '<td> - </td>' + 
             '<td>' + data[i].tipo + '</td>' +
             '<td>' + data[i].insumo + '</td>' +
             '<td>' + data[i].peso + '</td>' +
             '<td>' + data[i].precio + '</td>' +
             '<td>' + data[i].cantidad + '</td>' + 
             '<td><button onClick="eliminar('+"'id_items'"+','+data[i].id+','+"'insumos_interno_entrada_salida_edit.php'," +data[i].remision_id+')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
             '</tr>'; 
           }
           $('#DataResult').html(html);

         }else {
           $("#AlertItem").text('Se Guardo');  
         }
         $('#AlertItem').fadeIn();     

         setTimeout(function() {
             $("#AlertItem").fadeOut();           
            },3000);//lo q tarde activo    

         setTimeout(function(){ 
            //window.history.go(); 
         },2000); 

       }).fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
           //console.log( "La solicitud a fallado: " +  textStatus);
         }
       });  

     }

     function guardarGeneral(action){
      
      $.ajax({ 
         type: $("#form1").attr("method"),
         url: /*'AjaxControllers/Actions/'+*/action+'?'+$("#form1").serialize(),
         data: $("#form1").serialize(), 
         success: function(data){   
           $('#alertG').show(); 
           if(data==1) {
             $("#alertG").text('Guardando correctamente... !');
              $('#tiquetxCajas').show(); 
            } else {
              $("#alertG").text('Error: No se Guardo');  
            } 
            $('#alertG').fadeIn(); 

            setTimeout(function() {
              $("#alertG").fadeOut();           
                  },3000);//lo q tarde activo

            setTimeout(function() 
            { 
               //window.location=$("#form1").attr("action"); //trae la url y las variables q se envian por get o post
             },2000); 
          },
          error: function(data){
            $('#alertG').show(); 
            $('#alertG').fadeIn();     
            setTimeout(function() {
              $("#alertG").fadeOut();           
            },1000);

            setTimeout(function() 
            {
              //window.history.go();
            }, 1000);   
          }
        }); 

     }


      function guardarConAlertBodegas(){
 
        $.ajax({ 
          type: $("#formItems").attr("method"),
          url: 'AjaxControllers/Actions/'+$("#formItems").attr("action")+'?'+$("#formItems").serialize(),
          data: $("#formItems").serialize(), 
         dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {

         if(data) {
           $("#AlertItem").text('Guardando correctamente... !');  
           $("#nombre_responsable").val('');
           $("#direccion").val('');
           $("#indicativo").val('');
           $("#telefono").val('');
           $("#extension").val('');
           $("#ciudad").val('');
           //$("#grid").load();
           //$("#btnEnviarItems").text('Guardando ... !');
           
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
             '<td nowrap="nowrap"><button onClick="eliminacionyConsulta('+"'id_bodega'"+','+data[i].id+','+"'pagina'"+','+data[i].id_d+')" id="btnDelItems" name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
             '</tr>'; 
           }
           $('#DataResult').html(html);
           $('#busqueda').fadeIn();  
           setTimeout(function() { $("#busqueda").fadeOut();},2000); 


         }else {
           $("#AlertItem").text('Error: No se Guardo');  
         }
         $('#AlertItem').fadeIn();     

         setTimeout(function() {
             $("#AlertItem").fadeOut();           
            },3000);//lo q tarde activo    

         setTimeout(function(){ 
            //window.history.go(); 
         },2000); 

       }).fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
           //console.log( "La solicitud a fallado: " +  textStatus);
         }
       });  

     }



      function guardarItemsCireles(){
 
        $.ajax({ 
          type: $("#formPlanchas").attr("method"),
          url: 'AjaxControllers/Actions/'+$("#formPlanchas").attr("action")+'?'+$("#formPlanchas").serialize(),
          data: $("#formPlanchas").serialize(),  
         dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {

         if(data) {
           $("#AlertItem").text('Guardando correctamente... !'); 
           $("#color1").val('');
           $("#motivo").val('');
           $("#color2").val('');
           $("#motivo2").val('');
           $("#color3").val('');
           $("#motivo3").val('');
           $("#color4").val('');
           $("#motivo4").val(''); 
           $("#se_hizo_repo").val('');
           $("#fecha_repo").val('');
           $("#responsable").val('');   
           //$("#grid").load();
           //$("#btnEnviarItems").text('Guardando ... !');         
           var html = '';
           var i;
           for (i = 0; i < data.length; i++) {
             html += '<tr>' + 
             '<td id="fuente_1">' + data[i].cliente + '</td>' +
             '<td id="fuente_1">' + data[i].ref + '</td>' +
             '<td id="fuente_1">' + data[i].color1 + '</td>' +
             '<td id="fuente_1">' + data[i].motivo + '</td>' +
             '<td id="fuente_1">' + data[i].color2 + '</td>' +
             '<td id="fuente_1">' + data[i].motivo2 + '</td>' + 
             '<td id="fuente_1">' + data[i].color3 + '</td>' +
             '<td id="fuente_1">' + data[i].motivo3 + '</td>' +
             '<td id="fuente_1">' + data[i].color4 + '</td>' +
             '<td id="fuente_1">' + data[i].motivo4 + '</td>' +
             '<td id="fuente_1">' + data[i].fecha_reporte + '</td>' +
             '<td id="fuente_1">' + data[i].se_hizo_repo + '</td>' + 
             '<td id="fuente_1">' + data[i].fecha_repo + '</td>' +
             '<td id="fuente_1">' + data[i].responsable + '</td>' +  
             '<td id="fuente_1">' + data[i].adjunto + '</td>' + 
             '<td id="fuente_1">' + data[i].obs + '</td>' +   
             '<td id="fuente_1"><button onClick="eliminar('+"'idplanchas'"+','+data[i].id+','+"'verificacion_cireles.php'," +data[i].id_verif+')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
             '<td><a href="verificacion_cireles_imprime.php?id_imprime='+data[i].id+' " target="_blank"><img src="images/impresor.gif" alt="IMPRIME" title="IMPRIME" border="0" style="cursor:hand;width:20px;height:20px;" /></a></td>' +
             '</tr>'; 
           }
           $('#DataResultcirel').html(html);

         }else {
           $("#AlertItem").text('Error: No se Guardo');  
         }
         $('#AlertItem').fadeIn();     

         setTimeout(function() {
             $("#AlertItem").fadeOut();           
            },3000);   

         setTimeout(function(){ 
            //window.history.go(); 
         },2000); 

       }).fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
           //console.log( "La solicitud a fallado: " +  textStatus);
         }
       });  

     }
/*     function Guardares(pagina){
        swal({   
         title: "GUARDAR?",   
         text: "Esta seguro que Quiere Guardar! ",   
         type: "warning",   
         showCancelButton: true,   
         confirmButtonColor: "#DD6B55",   
         confirmButtonText: "Si, Guardar!",   
         cancelButtonText: "No, Guardar!",   
         closeOnConfirm: false,   
         closeOnCancel: false }, 
         function(isConfirm){   
           if (isConfirm) {  
              window.location.href = pagina;
           } else {     
             swal("Cancelado", "has cancelado :)", "error");
             
            // window.history.go();
           } 
         });  

     }*/