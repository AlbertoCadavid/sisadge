function validaTodoExtruder(){

	var indice0 = document.getElementById("montaje").value;
	var indice1 = document.getElementById("turno_r").value;
	var indice2 = document.getElementById("maquina").selectedIndex; 
	var indice5 = document.getElementById("metro_r").value;
	var indice6 = document.getElementById("kilos_r").value;
    
	var fecha_inicial=document.getElementById('fecha_ini_rp').value;
	var fecha_final=document.getElementById('fecha_fin_rp').value;
    

	if(indice0 == '') {
		swal("Error", 'Seleccione el OPERARIO!', "error"); 

		return false;
	}else
	if(indice1 == '') {
		swal("Error", 'Seleccione el TURNO!', "error"); 

		return false;
	}else
	if(indice2 == '') { 
		swal("Error", 'Seleccione la MAQUINA!', "error"); 

		return false;  
	}else
	if(Date.parse(fecha_final)<Date.parse(fecha_inicial)){
		swal("Error", 'La fecha final debe ser mayor a la fecha inicial!', "error");

		return false;
	}else 
	if ((fecha_inicial)==''){
		swal("Error", 'Llene la fecha inicial!', "error"); 

		return false; 
	}else
	if ((fecha_final)==''){
		swal("Error", 'Llene la fecha Final!', "error"); 

		return false; 
	}else
	if(indice5  == '') {  
		swal("Error", 'Ingrese las METROS!', "error"); 

		return false;
	}else
	if( indice6 ==  '') {  
		swal("Error", 'Ingrese el PESO!', "error"); 

		return false;
	} 

	return true;
 
 }

function parcial() {
    
      swal({
          title: 'Rollo Parcial o Total!',
          text: "Que desea Hacer Con el Rollo:",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Liquidar Total !',
          cancelButtonText: 'Dejar Parcial !',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          closeOnConfirm: false,
          closeOnCancel: false
          //allowOutsideClick:true//cierra dando clic fuera
        },
        function(isConfirm) {

          var txt;
          if (isConfirm === true) {
            swal(
              'Liquidar Rollo!',
              'ok para Liquidar Total.',
              'success'
            );
            txt = 0;
          } else if (isConfirm === false) {
            swal(
              'Dejar Parcial',
              'ok para Dejar parcial :)',
              'error'
            );
            txt = 1;
          } else {

            //outside click, isConfirm is undefinded
          }
          document.getElementById("rolloParcial_r").value = txt;
          document.form1.submit();

        })
  }

  function restaMetros(){
    let metrolineal = parseInt($("#metro_r").val());
    let metroultimoparcial = parseInt($("#mts_parcial_ant").val());
    if(metrolineal <= metroultimoparcial){
        swal("Error", "Los metros FINALES no pueden ser MENORES a los del PARCIAL", "error")
        $("#mts_parcial_actual").val(0)
    } else {
    let resta = metrolineal-metroultimoparcial;
    $("#mts_parcial_actual").val(resta);
    
    }
  }