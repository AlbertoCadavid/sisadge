     function consultaInsumos(){
      idinsumo = document.getElementById("insumo").value; 

       $.ajax({ 
         type:  'post',
         url: 'AjaxControllers/Actions/consultas.php',
         data:{
          "idinsumo": idinsumo, 
         },
        dataType: 'json',//define las variables a mostrar 
      }).done(function( data, textStatus, jqXHR ) {

        if(data) {
         var html = '';
           var i;
           for (i = 0; i < data.length; i++) {
              $('#busqueda').show(); 
              $("#tipo").val(data[i].tipo_insumo);
              $("#ref_ac").val(data[i].codigo_insumo);
              $("#precio").val(data[i].valor_unitario_insumo);
              $("#peso").val(data[i].peso_insumo);
              $("#busqueda").text('Registro Encontrado... !'); 
           }
           $('#busqueda').fadeIn();  
           setTimeout(function() { $("#busqueda").fadeOut();},2000); 
        } 
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      });  
     
     }

   function consultasItems(remision_id){  
 
        $.ajax({ 
           type:  'post',
           url: 'AjaxControllers/Actions/consultas.php',
           data:{
            "remision_id": remision_id, 
           },
          dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {
          
         if(data) { 
           var html = '';
           var i; 
           var pes = 0;
           var prec = 0;
           var cant = 0;
           for (i = 0; i < data.length; i++) {
             pes +=Number(data[i].peso);
             prec +=Number(data[i].precio);
             cant +=Number(data[i].cantidad);
             subtotal = Number(data[i].peso)*Number(data[i].cantidad)
             html += '<tr>' +  
             '<td>' + data[i].insumo + '</td>' +
             '<td>' + data[i].medida + '</td>' + 
             '<td>' + data[i].cantidad + '</td>' +
             '<td>' + data[i].peso + '</td>' +
             '<td>' + data[i].precio + '</td>' +
             '<td><button onClick="eliminar('+"'id_items'"+','+data[i].id+','+"'insumos_interno_entrada_salida_edit.php'," +data[i].remision_id+')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
             '</tr>'; 
           }
             html += '<tr><td></td><td></td>'+'<td colspan="2" ><b> TOTAL: </b></td>'+'</td>'+'<td><b>'+prec+'</b></td>'+'</tr>';
           $('#DataResult').html(html);
           $('#busqueda').fadeIn();  
           setTimeout(function() { $("#busqueda").fadeOut();},2000); 

         } 
       }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 

     }

     function consultasItemsVista(remision_id){  
     
          $.ajax({ 
             type:  'post',
             url: 'AjaxControllers/Actions/consultas.php',
             data:{
              "remision_id": remision_id, 
             },
            dataType: 'json',//define las variables a mostrar 
         }).done(function( data, textStatus, jqXHR ) {
            
           if(data) { 
             var html = '';
             var i; 
             var pes = 0;
             var prec = 0;
             var cant = 0;
             for (i = 0; i < data.length; i++) {
               pes +=Number(data[i].peso);
               prec +=Number(data[i].precio);
               cant +=Number(data[i].cantidad);
               html += '<tr>' +  
               '<td>' + data[i].insumo + '</td>' +
               '<td>' + data[i].medida + '</td>' + 
               '<td>' + data[i].cantidad + '</td>' +
               '<td>' + data[i].peso + '</td>' +
               '<td>' + data[i].precio + '</td>' +  
               '</tr>'; 
             }
               html += '<tr><td></td><td></td>'+'<td colspan="2" ><b> TOTAL: </b></td>'+'</td>'+'<td><b>'+prec+'</b></td>'+'</tr>';
             $('#DataResult').html(html);
             $('#busqueda').fadeIn();  
             setTimeout(function() { $("#busqueda").fadeOut();},2000); 

           } 
         }).fail(function( jqXHR, textStatus, errorThrown ) {
          if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
          }
        }); 

       }


/*     function consultasItems(remision_id){  
          $.ajax({ 
             type:  'post',
             url: 'AjaxControllers/Actions/consultas.php',
             data:{
              "remision_id": remision_id, 
             },
            dataType: 'json',//define las variables a mostrar 
         }).done(function( data, textStatus, jqXHR ) {
            
           if(data) { 
             var html = '';
             var i; 
             var pes = 0;
             var prec = 0;
             var cant = 0;
             for (i = 0; i < data.length; i++) {
               pes +=Number(data[i].peso);
               prec +=Number(data[i].precio);
               cant +=Number(data[i].cantidad);
               html += '<tr>' +
               '<td> - </td>' +
               '<td>' + data[i].ref_ac + '</td>' +
               '<td>' + data[i].tipo + '</td>' +
               '<td>' + data[i].insumo + '</td>' +
               '<td>' + data[i].peso + '</td>' +
               '<td>' + data[i].precio + '</td>' +
               '<td>' + data[i].cantidad + '</td>' + 
               '<td><button onClick="eliminar('+"'id_items'"+','+data[i].id+','+"'insumos_interno_entrada_salida_edit.php'," +data[i].remision_id+')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' + 
               '</tr>'; 
             }
               html += '<tr><td></td><td></td><td></td><td></td>'+'<td>Total: <b>'+pes+'</b></td>'+'<td>Total: <b>'+prec+'</b></td>'+'<td>Total: <b>'+cant+'</b></td>'+'</tr>';
             $('#DataResult').html(html);
             $('#busqueda').fadeIn();  
             setTimeout(function() { $("#busqueda").fadeOut();},2000); 

           } 
         }).fail(function( jqXHR, textStatus, errorThrown ) {
          if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
          }
        }); 

       }*/
   function consultaPorcentajesOp(ref){
      ref_porcent = ref; 
     
       $.ajax({ 
         type:  'post',
         url: 'AjaxControllers/Actions/consultas.php',
         data:{
          "ref_porcent": ref_porcent, 
         },
        dataType: 'json',//define las variables a mostrar 
        success: function(data){ 

        }
      }).done(function( data, textStatus, jqXHR ) {
        if(data) { 
          var totporc = Number(data.total.toFixed(2)); 
         $("#int_desperdicio_op").val(totporc);
         $("#extruderpor").val(data.extruder);
         $("#impreporc").val(data.impresion);
         $("#selladoporc").val(data.sellado);
       }
        /*if(data) { 
           var totporc = Math.round(data.totalporc);
            $("#int_desperdicio_op").val(totporc);//se quita uya que se hace el promedioen de los 3 procesos en php directamente en la vista 
           calcular_op();
           validacion_tipocinta();  
        }*/ 
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 

    } 

    function consultaPorcentajesOpList(meslis,anyolis,ref,ops,cliente){
   
        $.ajax({ 
          type:  'post',
          url: 'AjaxControllers/Actions/consultas.php',
          data:{
           "meslis": meslis,
           "anyolis": anyolis,
           "ref": ref,
           "ops": ops,
           "cliente": cliente
          },
         dataType: 'json',//define las variables a mostrar 
         success: function(data){ 

         }
       }).done(function( data, textStatus, jqXHR ) {
         if(data) { 
           var totporc = Number(data.total.toFixed(2)); 
          $("#extruder").val(data.extruder);
          $("#impre").val(data.impresion);
          $("#sellado").val(data.sellado);
          $("#desperdiciototal").val(totporc);
        }
         /*if(data) { 
            var totporc = Math.round(data.totalporc);
             $("#int_desperdicio_op").val(totporc);//se quita uya que se hace el promedioen de los 3 procesos en php directamente en la vista 
            calcular_op();
            validacion_tipocinta();  
         }*/ 
       }).fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
           console.log( "La solicitud a fallado: " +  textStatus);
         }
       }); 

     } 


    function consultaPorcentajesProduccion(meslis,anyolis,ref,ops,cliente){
    
        $.ajax({ 
          type:  'post',
          url: 'AjaxControllers/Actions/consultas.php',
          data:{
           "meslis": meslis,
           "anyolis": anyolis,
           "ref": ref,
           "ops": ops,
           "cliente":cliente
          },
         dataType: 'json',//define las variables a mostrar 
         success: function(data){ 

         }
       }).done(function( data, textStatus, jqXHR ) {
         if(data) { 
           var totporc = Number(data.total.toFixed(2)); 
          $("#extruder").val(data.extruder);
          $("#impre").val(data.impresion);
          $("#sellado").val(data.sellado);
          $("#desperdiciototal").val(totporc);
        }  
       }).fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
           console.log( "La solicitud a fallado: " +  textStatus);
         }
       }); 

     } 



   function verConsulta(id,campo,pagina){
 
          $.ajax({
            dataType: "json",
            data: {
              "id": id,
              "historico": campo,
              "pagina":pagina,
            },
            url:  "AjaxControllers/Actions/consultas.php?"+id+"="+campo+"&pagina="+pagina, 
            type:  'post',
            beforeSend: function(){
              
            },
            success: function(data){ 
              var elem = '';
              var i; 
              cont =1;
              //var titulos = 'Fecha   Modificacion   Usuario ' + '\n';
             for (i = 0; i < data.length; i++) { 
               elem +=cont+' - '+data[i].fecha +' Modificacion:'+data[i].modificacion+' Usuario:'+data[i].usuario +' '+ '\n';
               cont++;
             }
                swal("Informacion Historico ", elem);  
                //$('#DataResult').html(elem); 
            } 
          });  
 
    }
 

 function verConsultaSencillo(id,campo,pagina){  
       $.ajax({
         dataType: "json",
         url:  "AjaxControllers/Actions/consultas.php?"+id+"="+campo+"&pagina="+pagina, 
         type:  'POST',
         data: {
           "id": id,
           "campo": campo,
           "pagina":pagina
         }, 
         beforeSend: function(){
           
         },
         success: function(data){  
           if(data!=0){
            var numero_oc = data.pref+'-'+data.valor;
            $('#str_numero_oc').val(numero_oc);
            if(data.pref=='AC'){
               $("#b_oc_interno").prop("checked", true);
               $("#oc_internas").show(200);  
             } else { 
               $("#b_oc_interno").prop("checked", false); 
               $("#oc_internas").hide(200);
             }
           }else{
             $('#str_numero_oc').val('');
             $("#oc_internas").hide(200);
           }
         } 
       });  
 
 }

  function verConsultaAlertGenerico(id,campo,msn,pagina=''){  
       $(".verAlert").text('');
       $.ajax({
         dataType: "json",
         url:  "AjaxControllers/Actions/consultas.php?"+id+"="+campo+"&msn="+msn, 
         type:  'POST',
         data: {
           "id": id,
           "campo": campo,
           "msn": msn,
           "pagina":pagina
         }, 
         beforeSend: function(){
           
         },
         success: function(data){  
           if(data!=0){
            var factura_oc = data.factura_oc; 
             var ordenc = data.str_numero_oc; 
            if(factura_oc!=''){
              
               $(".verAlert").show(200); 
               $(".verAlert").text(msn+' ID1: '+factura_oc+'  ID2: '+ordenc);  
             } else { 

               $(".verAlert").hide(200);
             }
           }else{

             $(".verAlert").hide(200);
           }
         } 
       });  
 
 }



  function consultaGenerico(tabla,columna,valorid,cliente='',sms=''){  
    // "Controller/Cgeneral.php?tabla="+tabla+"&columna="+columna+"&valorid="+valorid+"&sms="+sms, 
 
       $("#verAlert").text('');
       $.ajax({
         dataType: "json", 
         url: "view_index.php?c=cgeneral&a=consultarlog",
         type:  'POST',
         data: {
          "tabla":tabla,
          "columna":columna, 
          "valorid":valorid, 
          "sms":sms+cliente
         }, 
         beforeSend: function(){
           
         },
         success: function(data){  
           //alert(data);
           if(data==1){ 
               $("#verAlert").show(); 
               $("#verAlert").text(sms+' Cliente: '+cliente ); 
               $('#verAlert').fadeIn();  
               setTimeout(function() { $("#verAlert").fadeOut();},8000);  
             } else { 

               $("#verAlert").hide();
          
           } 
         } 
       });  
 
 }



  function consultaGeneral(tabla,where,columna,columna2,valorid,sms='',fecha='',order=''){  
    // "Controller/Cgeneral.php?tabla="+tabla+"&columna="+columna+"&valorid="+valorid+"&sms="+sms, 
      

        $.ajax({ 
           type:  'post',
           url: "view_index.php?c=cgeneral&a=consultarlogGeneral",
           data:{
            "tabla":tabla,
            "where":where,
            "columna":columna, 
            "columna2":columna2,
            "valorid":valorid, 
            "sms":sms,
            "fecha":fecha,
            "order":order
           },
          dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {
          
         if(data) { 
        
           var i; 
      
           for (i = 0; i < data.length; i++) {
            if(data[i].insumoveinte!=''){

               $("#verAlert").show(); 
               $("#verAlert").text('Este insumo de ID: ' + data[i].insumoveinte + ' tiene menos de 20 cantidades en stock! ' ); 
               $('#verAlert').fadeIn();  
               setTimeout(function() { $("#verAlert").fadeOut();},4000); 
            }
 
           }
               
         

         } 
       }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 
 
 
 }


 function consultaGeneralTodos(tabla,distinct,columna1,columna2='',columna3='',valorid1,valorid2='',valorid3='' ){  
 
        $.ajax({ 
           type:  'post',
           url: "view_index.php?c=cgeneral&a=consultarTodos",
           data:{
            "tabla":tabla,
            "distinct":distinct,
            "columna1":columna1, 
            "columna2":columna2,
            "columna3":columna3,
            "valorid1":valorid1, 
            "valorid2":valorid2,
            "valorid3":valorid3 
           },
          dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {
        
        $("#validar_paquete").val(0); 
         if(data != 'null') { 
          
               $("#validar_paquete").val(1);//para validar
               $("#verAlert").show(); 
               $("#verAlert").text("Ya Existe!"); 
               $('#verAlert').fadeIn();  
               swal("Error", "El registro Ya Existe! :)", "error");  
               setTimeout(function() { $("#verAlert").fadeOut();},4000); 
          
         } 
      

       }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 
 
 
 }

 function consultaGeneralTodosAjax(tabla,distinct,columna1,columna2='',columna3='',valorid1,valorid2='',valorid3='' ){  
 
        $.ajax({ 
           type:  'post',
           url: "view_index.php?c=cgeneral&a=consultarTodos",
           data:{
            "tabla":tabla,
            "distinct":distinct,
            "columna1":columna1, 
            "columna2":columna2,
            "columna3":columna3,
            "valorid1":valorid1, 
            "valorid2":valorid2,
            "valorid3":valorid3 
           },
          dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {
        
        $("#validar_paquete").val(0); 
         if(data != 'null') { 
            
              $("#evaluacion").val(data.id)   
         
          
         } 
      

       }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 
 
 
 }

 function consultasBodegas(bodegas_id,pagina){  

      $.ajax({ 
         type:  'post',
         url: 'AjaxControllers/Actions/consultas.php',
         data:{
          "bodegas_id": bodegas_id, 
         },
        dataType: 'json',//define las variables a mostrar 
     }).done(function( data, textStatus, jqXHR ) {
        
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
         $('#busqueda').fadeIn();  
         setTimeout(function() { $("#busqueda").fadeOut();},2000); 

       } 
     }).fail(function( jqXHR, textStatus, errorThrown ) {
      if ( console && console.log ) {
        console.log( "La solicitud a fallado: " +  textStatus);
      }
    }); 

   }



   function consultasPlanchas(codref){  
        $.ajax({ 
           type:  'post',
           url: 'AjaxControllers/Actions/consultas.php',
           data:{
            "refplanchas": codref, 
           },
          dataType: 'json',//define las variables a mostrar 
       }).done(function( data, textStatus, jqXHR ) {
          
         if(data) { 
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
            '<td><button onClick="eliminar('+"'idplanchas'"+','+data[i].id+','+"'verificacion_cireles.php'," +data[i].id_verif+')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus=""  >DELETE</button></td>' + 
            '<td><a href="verificacion_cireles_imprime.php?id_imprime='+data[i].id+' " target="_blank"><img src="images/impresor.gif" alt="IMPRIME" title="IMPRIME" border="0" style="cursor:hand;width:20px;height:20px;" /></a></td>' +
            '</tr>'; 
           }
            
           $('#DataResultcirel').html(html);
           $('#busqueda').fadeIn();  
           setTimeout(function() { $("#busqueda").fadeOut();},2000); 

         } 
       }).fail(function( jqXHR, textStatus, errorThrown ) {
        if ( console && console.log ) {
          console.log( "La solicitud a fallado: " +  textStatus);
        }
      }); 

     }



     function consultaNumeroOrden(id,campo,pagina){  
           $.ajax({
             dataType: "json",
             url:  "AjaxControllers/Actions/consultas.php?"+id+"="+campo+"&pagina="+pagina, 
             type:  'POST',
             data: {
               "id": id,
               "campo": campo,
               "pagina":pagina
             }, 
             beforeSend: function(){
               
             },
             success: function(data){  
               if(data!=""){
              
                $("#validar_oc").val(0); 
                if(data.valor==1){
                   $("#mensaje").text(data.mns); 
                   $("#mensaje").attr('style', 'color: red');
                   $("#validar_oc").val(1); 
                 } else if(data.valor==2){ 
                   $("#mensaje").text(data.mns);
                   $("#mensaje").attr('style', 'color: green'); 
                   $("#validar_oc").val(0); 
                 }else{
                   $("#validar_oc").val(0);
                 }
               } 

             } 
           });  
     
     }

 function Salir(pagina){

   swal({   
    title: "SALIR?",   
    text: "Esta seguro que Quiere Salir ",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Si, Salir!",   
    cancelButtonText: "No, Salir!",   
    closeOnConfirm: false,   
    closeOnCancel: false }, 
    function(isConfirm){   
      if (isConfirm) {  
        window.location.href = pagina;
      } else {   
        window.history.go();
      } 
    });  

}

 
