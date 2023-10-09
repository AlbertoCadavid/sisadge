          /* CONFIRMACION AL DARLE CLICK EN SALIR BOTON */
            function salir()
            {

              var nit_c = document.getElementById("nit_c").value;
              var str_numero_oc = document.getElementById("str_numero_oc").value;
  
             if( str_numero_oc !='' && nit_c!='' ){
              swal({   
               title: "PROCESAR?",   
               text: "Esta seguro de finalizar el proceso?",   
               type: "warning",   
               showCancelButton: true,   
               confirmButtonColor: "#DD6B55",   
               confirmButtonText: "Si, Finalizar!",   
               cancelButtonText: "No, Finalizar!",   
               closeOnConfirm: false,   
               closeOnCancel: false }, 
               function(isConfirm){   
                 if (isConfirm) {  
                   swal("Procesado!", "El registro se ha procesado.", "success"); 
                   window.location ='orden_compra_cl.php';
                 } else {     
                   swal("Cancelado", "has cancelado :)", "error"); 
                 } 
               }); 

              /*var statusConfirm = confirm("Esta seguro de finalizar el proceso?");
              if (statusConfirm == true)
              {
               window.location ='orden_compra_cl.php'
             }else if (statusConfirm == false)
             {
               window.close();
             }*/
              
             }else{
              swal("Obligatorio!", "Ingrese los valores! OC, NIT  ", "warning", {
                button: " OK!",
              });
             }

           }

   
/*           function envio(){
            if (document.form1.validar_oc.value!="1"){
                 document.form1.submit(); 
             return true;
           }else {
             swal("EXISTE!", "EL NUMERO DE ORDEN YA EXISTE O EXISTEN CARACTERES EXTRAÑOS, FAVOR HACER REVISION ", "warning", {
                button: " OK!",
              });
             document.form1.str_numero_oc.focus();
             return false;
           }
         }*/