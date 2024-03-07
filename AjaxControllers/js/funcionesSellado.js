function numeracionDesdeAdd(
  numDesde,
  caja,
  paquete,
  ref = "",
  selladoadd = "",
  reservaAux = ""
) {
  var imprimirt = document.form1.imprimirt.value;
  var bolsas =
    imprimirt == 1
      ? document.form1.int_undxcaja_tn.value
      : document.form1.int_undxpaq_tn.value;

  var desde = numDesde; //document.form1.int_desde_tn.value;
  var dividida = numeracionChar(desde);
  var numeros = dividida[0];
  var cadena = dividida[1];

  if (selladoadd) {
    var sumoUno = parseInt(numeros) + parseInt(1); //VIENDE DESDE SELADO ADD
    var tnum = parseInt(numeros) + parseInt(bolsas); //  resto uno ya que iene de la op
  } else {
    var sumoUno = parseInt(numeros); // cuando viene de la op no le sumo el 1 parseInt(numeros)+parseInt(1)
    var tnum = parseInt(numeros) + parseInt(bolsas) - parseInt(1); //  resto uno ya que iene de la op
  }
  //mirar como dejar los ceros a la izquierda
  var cerosizq = cerosIzquierda(desde, sumoUno, numeros); //codigos especiales
  if (cerosizq != undefined) {
    var sumoUno = cerosizq;
  }
  document.form1.int_desde_tn.value = cadena + sumoUno;

  /*NUEVA FUNCION PARA EL MANEJO DE LAS BANDERAS  */
  let numeroDesde = numeracionChar(cadena + sumoUno);
  document.form1.int_desde_num.value = numeroDesde[0]; //lleno el input sin caracteres para que lo envie en el form y actualice la tabla tbl_info_rollo_sellado
  /* FIN */

  var cerosizq2 = cerosIzquierda(desde, tnum, numeros); //codigos especiales
  if (cerosizq2 != undefined) {
    var tnum = cerosizq2;
  }
  document.form1.int_hasta_tn.value = cadena + tnum;
  /*NUEVA FUNCION PARA EL MANEJO DE LAS BANDERAS  */
  let numeroHasta = numeracionChar(cadena + tnum);
  document.form1.int_hasta_num.value = numeroHasta[0]; //lleno el input sin caracteres para que lo envie en el form y actualice la tabla tbl_info_rollo_sellado
  /* FIN */
  cambioCajaODesdeListado(caja, paquete, ref, reservaAux);
}

function numeracionDesde(numDesde, caja, paquete, ref, reservaAux = "") {
  var imprimirt = document.form1.imprimirt.value;

  var bolsas =
    imprimirt == 1
      ? document.form1.int_undxcaja_tn.value
      : document.form1.int_undxpaq_tn.value;

  var desde = numDesde;
  var dividida = numeracionChar(desde);
  var numeros = dividida[0];
  var cadena = dividida[1];
  var sumoUno = parseFloat(numeros) + parseFloat(1);

  var cerosizq = cerosIzquierda(desde, sumoUno, numeros); //codigos especiales
  if (cerosizq != undefined) {
    var sumoUno = cerosizq;
  }
  document.form1.int_desde_tn.value = cadena + sumoUno;
  var tnum = parseInt(numeros) + parseInt(bolsas);
  var cerosizq2 = cerosIzquierda(desde, tnum, numeros); //codigos especiales
  if (cerosizq2 != undefined) {
    var tnum = cerosizq2;
  }
  document.form1.int_hasta_tn.value = cadena + tnum;

  cambioCajaODesdeListado(caja, paquete, ref, reservaAux);
}

//FUNCION GENERAL AUXILIARES FALTANTES DE TIQUETES SELLADO
function numeracionChar(carac) {
  var num = "",
    caden = "",
    l = "",
    b = "",
    c = "",
    d = "",
    e = "",
    g = "",
    h = "",
    desde = "",
    sal = "",
    sal2 = "",
    cadena = "";
  var caract = carac.toUpperCase().replace(/\s/g, ""); //a mayusculas,reemplaza espacios
  var z = caract.search(
    /AA1Y|AA1F|AA1G|AA1H|AA1I|AA1J|AA1K|AA1L|AA1M|AA1N|AA1O|AA1P|AA1Q|AA1R|AA1S|AA1T|AA1U|AA1V|AA1W|AA1X|AA1Z|AA1A|AA1B|AA1C|AA1D|AA1E|AA2Y|AA2F|AA2G|AA2H|AA2I|AA2J|AA2K|AA2L|AA2M|AA2N|AA2O|AA2P|AA2Q|AA2R|AA2S|AA2T|AA2U|AA2V|AA2W|AA2X|AA2Z|AA2A|AA2B|AA2C|AA2D|AA2E|AA3Y|AA3F|AA3G|AA3H|AA3I|AA3J|AA3K|AA3L|AA3M|AA3N|AA3O|AA3P|AA3Q|AA3R|AA3S|AA3T|AA3U|AA3V|AA3W|AA3X|AA3Z|AA3A|AA3B|AA3C|AA3D|AA3E|AA4Y|AA4F|AA4G|AA4H|AA4I|AA4J|AA4K|AA4L|AA4M|AA4N|AA4O|AA4P|AA4Q|AA4R|AA4S|AA4T|AA4U|AA4V|AA4W|AA4X|AA4Z|AA4A|AA4B|AA4C|AA4D|AA4E|AA5Y|AA5F|AA5G|AA5H|AA5I|AA5J|AA5K|AA5L|AA5M|AA5N|AA5O|AA5P|AA5Q|AA5R|AA5S|AA5T|AA5U|AA5V|AA5W|AA5X|AA5Z|AA5A|AA5B|AA5C|AA5D|AA5E|AA6Y|AA6F|AA6G|AA6H|AA6I|AA6J|AA6K|AA6L|AA6M|AA6N|AA6O|AA6P|AA6Q|AA6R|AA6S|AA6T|AA6U|AA6V|AA6W|AA6X|AA6Z|AA6A|AA6B|AA6C|AA6D|AA6E|AA7Y|AA7F|AA7G|AA7H|AA7I|AA7J|AA7K|AA7L|AA7M|AA7N|AA7O|AA7P|AA7Q|AA7R|AA7S|AA7T|AA7U|AA7V|AA7W|AA7X|AA7Z|AA7A|AA7B|AA7C|AA7D|AA7E|AA8Y|AA8F|AA8G|AA8H|AA8I|AA8J|AA8K|AA8L|AA8M|AA8N|AA8O|AA8P|AA8Q|AA8R|AA8S|AA8T|AA8U|AA8V|AA8W|AA8X|AA8Z|AA8A|AA8B|AA8C|AA8D|AA8E|AA9Y|AA9F|AA9G|AA9H|AA9I|AA9J|AA9K|AA9L|AA9M|AA9N|AA9O|AA9P|AA9Q|AA9R|AA9S|AA9T|AA9U|AA9V|AA9W|AA9X|AA9Z|AA9A|AA9B|AA9C|AA9D|AA9E/i
  );

  codigo1 = buscaDigitos(caract); //busca 5 fecha
  var n = caract.search(/\d+/g); //d solo numeros
  var l = caract.search(/\w+/g); //w alfanumericos

  if (codigo1 != undefined) {
    var codigo = caract.split("-"); //hasta el guion
    var data = codigo[0];
    var num = codigo[1];
    cadena = data + "-";
    solonumeros = num;
    return [solonumeros, cadena];
  } else if (z == "0") {
    var v = caract;
    var data = v.substring(0, 4);
    var num = v.substring(4);
    cadena = data;
    solonumeros = num;
    return [solonumeros, cadena];
  }
  //solo numeros
  else if (n == "0") {
    var v = caract;
    var num = v.substring(0);
    var vacia = "";
    solonumeros = num;
    return [solonumeros, vacia];
  }
  //letras al inicio
  else if (l == "0" && z != "0" && n != "0" && codigo1 == undefined) {
    //caract.match(/\d+/g).join('');
    l = caract.match(/\D+/g); //D acepta diferente de numeros
    cadena = l;
    solonumeros = caract.match(/\d+/g); //d acepta solo numeros

    var cerosizq = cerosIzquierda(caract, solonumeros, solonumeros); //codigos especiales
    if (cerosizq != undefined) {
      var solonumeros = cerosizq;
    }
    return [solonumeros, cadena];
  } //fin if
}

function buscaDigitos(caract) {
  var codigo = caract.split("-"); //hasta el guion
  if (codigo[1]) {
    return codigo;
  }
}

function letrasalFinal(caract) {
  //var codigo = caract.split('')[caract.length - 1];
  var codigo = caract.charAt(caract.length - 1); //ultimo caracter
  if (codigo) {
    return codigo;
  }

  /*    else
            		//letras al inicio y al final
            		if(l=='0' && (z!='0' || n!='0' || ultimo!='0')&&codigo1== undefined){
            	 
            		primercadena=caract.match(/\D+/g); //D acepta diferente de numeros
            		cadena=primercadena;
            		solonumeros=caract.match(/\d+/g); //d acepta solo numeros 
                    cadena2 = caract.charAt(caract.length - 1)//ultimo caracter
         
                    var concatena = primercadena

            		return [ solonumeros, cadena, cadena2 ];		 		
            		}*/
}

//------------------FUNCION PARA AGREGAR FALTANTES DINAMICOS----//
function AddItem() {
  var count = 0;
  var tbody = null;
  var tablaf = document.getElementById("tablaf");
  var nodes = tablaf.childNodes;
  var acumula = 0;
  var falt = document.getElementsByClassName("focusNext");
  var numDivs = falt.length;
  var contadorNaranja = 0;
  for (var i = 0; i < numDivs; i++) {
    if (falt[i].className == "focusNext") contadorNaranja++;
    var acumula = contadorNaranja == "NaN" ? 0 : contadorNaranja;
    count++;
  }

  for (var x = 0; x < nodes.length; x++) {
    if (nodes[x].nodeName == "TBODY") {
      tbody = nodes[x];
      break;
    }
  }

  if (tbody != null) {
    var tr = document.createElement("tr");
    tr.innerHTML =
      '<td><input type="text" name="int_desde_f[]" tabindex=' +
      count +
      '  onKeypress="EnteryTap(event,this);" onChange="Calcular(this);" onBlur="MayusEspacio(this);" value="" required="required" class="focusNext errorRango" /></td><td><input type="text" tabindex=' +
      (count + 1) +
      '  id="int_hasta_f" name="int_hasta_f[]" onKeypress="EnteryTap(event,this);" onChange="Calcular(this);" onBlur="MayusEspacio(this);" value="" required="required" class="focusNext errorRango"/></td><td><input tabindex="-1" type="text" size="2" name="int_total_f[]" readonly /></td><td><button tabindex="-1" type="button" value="Borrar" onclick="eliminaFaltantes(this);Calcular(this);">Borrar</button></td>';
    tbody.appendChild(tr);
  }
}

function EnteryTap(evt, obj) {
  // Si el evento NO es una tecla Enter
  tecla = document.all ? evt.keyCode : evt.which;

  if (tecla != 13 && tecla != 9) {
    return;
  }

  let element = evt.target;

  // Si el evento NO fue lanzado por un elemento con class "focusNext"
  if (!element.classList.contains("focusNext")) {
    return;
  }

  // AQUI logica para encontrar el siguiente
  let tabIndex = element.tabIndex + 1;
  var next = document.querySelector('[tabindex="' + tabIndex + '"]');

  // Si encontramos un elemento
  if (next) {
    next.focus();
    event.preventDefault();
  }
}

function Enter(e, obj) {
  tecla = document.all ? e.keyCode : e.which;

  if (tecla != 13 && tecla != 9) return;
  if (tecla == 13 || tecla == 9) {
    frm = obj.form;
    for (i = 0; i < frm.elements.length; i++)
      if (frm.elements[i] == obj) {
        if (i == frm.elements.length - 1) i = -1;
        break;
      }

    if (frm.elements[i + 1].disabled == true) enter(e, frm.elements[i + 1]);
    else frm.elements[i + 1].focus();
    return false;
  }
}

/*	function submit_faltante(){
	 
	  var int_desde_f= document.getElementsByName('int_desde_f[]');
	  var int_hasta_f= document.getElementsByName('int_hasta_f[]'); 
	    for(x = int_desde_f.length; x--;){ 
	  
	              if( !(int_desde_f[x].value) || !(int_hasta_f[x].value ) ){ 
 
	                  return false;
	              }    
	       
	     }

	     return true;

	}*/

//------------------FUNCION PARA RESTAR HASTA MENOS DESDE----//
function Calcular(ele) {
  //alertafaltantes();//valida si el faltante esta dentro del rango

  ahasta = "";
  adesde = "";
  var num = "",
    caden = "",
    l = "",
    b = "",
    c = "",
    d = "",
    e = "",
    g = "",
    h = "",
    desde = "",
    sal = "",
    sal2 = "",
    cadena = "";
  var int_desde_f = 0,
    int_hasta_f = 0,
    int_total_f = 0;
  var tr = ele.parentNode.parentNode;
  var nodes = tr.childNodes;
  for (var x = 0; x < nodes.length; x++) {
    //------------------CADENA DEFINIDA DESDE-------------------//
    if (nodes[x].firstChild.name == "int_desde_f[]") {
      int_desde_f = nodes[x].firstChild.value;
      if (int_desde_f != "") {
        var codigos = divideCadenas(int_desde_f);
        var adesde = codigos[0];
        var cadena = codigos[1];
      }
    } //FIN IF INPUT DESDE
    //------------------CADENA DEFINIDA HASTA-------------------//
    if (nodes[x].firstChild.name == "int_hasta_f[]") {
      int_hasta_f = nodes[x].firstChild.value;
      if (int_hasta_f != "") {
        var codigos = divideCadenas(int_hasta_f);
        var ahasta = codigos[0];
        var cadena = codigos[1];
      }
    } //FIN IF INPUT HASTA
    //------------INPUT CADENA SUBTOTAL-------------------------//
    if (nodes[x].firstChild.name == "int_total_f[]") {
      if (ahasta != "" && adesde != "") {
        int_total = parseInt(ahasta - adesde, 10);
        int_total_f = int_total + 1;
        nodes[x].firstChild.value = int_total_f;
      } else {
        nodes[x].firstChild.value = 0;
      }
    } //FIN IF INPUT TOTAL
  } //FIN FORDE NODOS

  //ALERT DE VERIFICA QUE CUANDO FALTANTES SUPERAN CANTIDAD X PAQUETE
  var TOTALEZ = document.form1.int_undxpaq_tn.value;
  if (int_total_f > TOTALEZ) {
    swal({
      type: "warning",
      title: "Faltantes muy Altos!",
      text: "Error! Los faltantes estan superando la cantidad por paquete",
      timer: 4000,
    });
  } //fin verif

  //------------------CAMPO TOTAL FALTANTES----------------------------//
  var total = document.getElementById("total");
  var validar = document.getElementById("validar");
  if (total.innerHTML == "NaN") {
    total.innerHTML = 0;
    validar.innerHTML = 0;
  } else {
    var totalF = document.getElementsByName("int_total_f[]"),
      contadorf = 0,
      i;
    for (i = totalF.length; i--; )
      if (totalF[i].value) contadorf += parseInt(totalF[i].value, 10);
    total.innerHTML = contadorf; //parseInt(total.innerHTML)+parseInt(int_total_f);//CONTADOR PARA TOTAL
    validar.value = contadorf;
  }
  //--------------ADD TOTAL FALTANTES AL HASTA------------//
  var TotalHasta = document.form1.int_desde_tn.value;
  var Tbolsa = document.form1.int_undxpaq_tn.value;
  var codigos = divideCadenas(TotalHasta);
  var THasta = codigos[0];
  var cadena = codigos[1];
  //var total_f = document.form1.totalFaltantes.value=='' ? 0 : document.form1.totalFaltantes.value;//agregado 24-05-2022
  var Tsum =
    parseInt(THasta) + parseInt(Tbolsa) + parseInt(contadorf) - parseInt(1); //sumo desde + contadorf y resto 1
  var cerosizq3 = cerosIzquierda(TotalHasta, Tsum, THasta); //codigos especiales
  if (cerosizq3 != undefined) {
    var Tsum = cerosizq3;
  }

  document.form1.int_hasta_tn.value = cadena + Tsum; //SUMA EL TOTAL AL HASTA &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
} //FIN FUNCION

//------------------ALERTAS FUERA DEL FOR------------------//
function alertafaltantes() {
  var desdeGeneral = document.form1.int_desde_tn.value;
  var hastaGeneral = document.form1.int_hasta_tn.value;

  var desdeGeneral = divideCadenas(desdeGeneral);
  var desdeGeneral = desdeGeneral[0];

  var hastaGeneral = divideCadenas(hastaGeneral);
  var hastaGeneral = hastaGeneral[0];
  var bandera = 0;
  var estado = false;

  var elements = document.getElementsByClassName("errorRango");
  // valida todos los faltantes iniciales
  Array.from(elements).map((element) => {
    if (element.value != "") {
      var resultF = divideCadenas(element.value);
      var numerosF = resultF[0];
      if (desdeGeneral != "" && hastaGeneral != "") {
        if (
          parseInt(numerosF) < parseInt(desdeGeneral) ||
          parseInt(numerosF) > parseInt(hastaGeneral)
        ) {
          bandera = 1;
          swal(
            "La numeracion inicial o final: " +
              numerosF +
              " de uno de los faltantes, no debe ser Menor al Inicial General: " +
              desdeGeneral +
              " ni mayor a Final General: " +
              hastaGeneral +
              " del paquete"
          );
          return false;
        }
      }
    } //fin if element.value
    if (element.value == "") {
      swal("No debe haber campos faltantes vacios !");
      bandera = 1;
    }
  });

  if (bandera == 0) {
    estado = true;
    $("#content").html('<div class="loader"></div>');
    setTimeout(function () {
      $(".loader").fadeOut("slow");
    }, 700);
  }
  return estado;
}

//alertafaltantes()//LLAMA LA FUNCION DE FALTANTES
//---FUNCION ELIMINA LINEA DE INPUT DE FALTANTES DINAMICOS-----//
function eliminaFaltantes(obj) {
  var oTr = obj;
  while (oTr.nodeName.toLowerCase() != "tr") {
    oTr = oTr.parentNode;
  }
  var root = oTr.parentNode;
  root.removeChild(oTr);
}
//=======================================================FIN=========================================================//
//FUNCION GENERAL AUXILIARES FALTANTES DE TIQUETES SELLADO
function divideCadenas(carac) {
  var num = "",
    caden = "",
    l = "",
    b = "",
    c = "",
    d = "",
    e = "",
    g = "",
    h = "",
    desde = "",
    sal = "",
    sal2 = "",
    cadena = "";
  var caract = carac.toUpperCase().replace(/\s/g, ""); //a mayusculas,reemplaza espacios
  var z = caract.search(
    /AA1Y|AA1F|AA1G|AA1H|AA1I|AA1J|AA1K|AA1L|AA1M|AA1N|AA1O|AA1P|AA1Q|AA1R|AA1S|AA1T|AA1U|AA1V|AA1W|AA1X|AA1Z|AA1A|AA1B|AA1C|AA1D|AA1E|AA2Y|AA2F|AA2G|AA2H|AA2I|AA2J|AA2K|AA2L|AA2M|AA2N|AA2O|AA2P|AA2Q|AA2R|AA2S|AA2T|AA2U|AA2V|AA2W|AA2X|AA2Z|AA2A|AA2B|AA2C|AA2D|AA2E|AA3Y|AA3F|AA3G|AA3H|AA3I|AA3J|AA3K|AA3L|AA3M|AA3N|AA3O|AA3P|AA3Q|AA3R|AA3S|AA3T|AA3U|AA3V|AA3W|AA3X|AA3Z|AA3A|AA3B|AA3C|AA3D|AA3E|AA4Y|AA4F|AA4G|AA4H|AA4I|AA4J|AA4K|AA4L|AA4M|AA4N|AA4O|AA4P|AA4Q|AA4R|AA4S|AA4T|AA4U|AA4V|AA4W|AA4X|AA4Z|AA4A|AA4B|AA4C|AA4D|AA4E|AA5Y|AA5F|AA5G|AA5H|AA5I|AA5J|AA5K|AA5L|AA5M|AA5N|AA5O|AA5P|AA5Q|AA5R|AA5S|AA5T|AA5U|AA5V|AA5W|AA5X|AA5Z|AA5A|AA5B|AA5C|AA5D|AA5E|AA6Y|AA6F|AA6G|AA6H|AA6I|AA6J|AA6K|AA6L|AA6M|AA6N|AA6O|AA6P|AA6Q|AA6R|AA6S|AA6T|AA6U|AA6V|AA6W|AA6X|AA6Z|AA6A|AA6B|AA6C|AA6D|AA6E|AA7Y|AA7F|AA7G|AA7H|AA7I|AA7J|AA7K|AA7L|AA7M|AA7N|AA7O|AA7P|AA7Q|AA7R|AA7S|AA7T|AA7U|AA7V|AA7W|AA7X|AA7Z|AA7A|AA7B|AA7C|AA7D|AA7E|AA8Y|AA8F|AA8G|AA8H|AA8I|AA8J|AA8K|AA8L|AA8M|AA8N|AA8O|AA8P|AA8Q|AA8R|AA8S|AA8T|AA8U|AA8V|AA8W|AA8X|AA8Z|AA8A|AA8B|AA8C|AA8D|AA8E|AA9Y|AA9F|AA9G|AA9H|AA9I|AA9J|AA9K|AA9L|AA9M|AA9N|AA9O|AA9P|AA9Q|AA9R|AA9S|AA9T|AA9U|AA9V|AA9W|AA9X|AA9Z|AA9A|AA9B|AA9C|AA9D|AA9E/i
  );

  codigo1 = buscaDigitos(caract); //busca 5 fecha
  var n = caract.search(/\d+/g); //d solo numeros
  var l = caract.search(/\w+/g); //w alfanumericos

  if (codigo1 != undefined) {
    var codigo = caract.split("-"); //hasta el guion
    var data = codigo[0];
    var num = codigo[1];
    cadena = data + "-";
    solonumeros = num;
    return [solonumeros, cadena];
  } else if (z == "0") {
    var v = caract;
    var data = v.substring(0, 4);
    var num = v.substring(4);
    cadena = data;
    desde = num;
    return [desde, cadena];
  }
  //solo numeros
  else if (n == "0") {
    var v = caract;
    var num = v.substring(0);
    var vacia = "";
    desde = num;
    return [desde, vacia];
  }
  //letras al inicio
  else if (l == "0" && z != "0" && n != "0") {
    //caract.match(/\d+/g).join('');
    l = caract.match(/\D+/g); //D acepta diferente de numeros
    cadena = l;
    solonumeros = caract.match(/\d+/g); //d acepta solo numeros

    var cerosizq = cerosIzquierda(caract, solonumeros, solonumeros); //codigos especiales
    if (cerosizq != undefined) {
      var solonumeros = cerosizq;
    }
    return [solonumeros, cadena];
  } //fin if
}

function buscaDigitos(caract) {
  var codigo = caract.split("-"); //hasta el guion
  if (codigo[1]) {
    return codigo;
  }
}

//funcion para agregar un cero a la izquierda dependiendo de las dos letras
function cerosIzquierda(conletras, solonumero, cuantos) {
  var ceros = conletras.search(/EM|MQ|AB|AC|BP|BM|C|BB|OA|BC/i); //codigos especiales

  var cuantos = cuantos.length;
  //if(ceros== 0 ){
  //var cuantos = 8;
  codigo = solonumero.toString().padStart(cuantos, "0");

  return codigo; //si es cero es porq lo encuentra

  //}
}

function guardarSelladoTiquetes() {
  $.ajax({
    type: $("#form1").attr("method"),
    url:
      $("#form1").attr("action") +
      "&" +
      $("#form1").serialize() +
      "&" +
      $("#formfalta").serialize(),
    data: $("#form1").serialize(),
    dataType: "json", //define las variables a mostrar
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#AlertItem").text("Guardado correctamente... !");

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          //var sumaCaja = parseInt(data[i].int_caja_tn) + parseInt(1);
          //$("#int_caja_tn").val(sumaCaja);
          $("#consecutivoPaq").text(data[i].id_tn);
          $("#int_paquete_tn").val("");
          $("#int_paquete_tn").val(data[i].int_paquete_tn);
          $("#int_desde_tn").val(data[i].int_hasta_tn);
          numeracionDesde(
            data[i].int_hasta_tn,
            data[i].int_caja_tn,
            data[i].int_paquete_tn,
            data[i].ref_tn,
            data[i].contador_tn
          ); /*para sumarle uno a la numeracion inicial*/
          $("#int_op_tn").val(data[i].int_op_tn);
          $("#int_bolsas_tn").val(data[i].int_bolsas_tn);
          $("#int_undxcaja_tn").val(data[i].int_undxcaja_tn);
          $("#int_undxpaq_tn").val(data[i].int_undxpaq_tn);
          $("#int_cod_empleado_tn").val(data[i].int_cod_empleado_tn);
          $("#int_cod_rev_tn").val(data[i].int_cod_rev_tn);

          consultaPaquetes(data[i].int_op_tn, data[i].int_caja_tn);
          consultaUnSoloPaquetes(data[i].id_tn);
          consultaPaquetesxOp(data[i].int_op_tn);
          consultaFaltantes(data[i].id_tn);
        }
        $("#tablaf > tbody").empty(); //limpia tabla de faltantes
        $("#total").text("0"); //limpia tabla de faltantes
      } else {
        $("#AlertItem").text("Error: No se Guardo");
      }
      $("#AlertItem").fadeIn();
      //location.reload();
      setTimeout(function () {
        $("#AlertItem").fadeOut();
      }, 1000);

      setTimeout(function () {}, 1000);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function guardarSelladoFaltantes() {
  $.ajax({
    type: $("#formfalta").attr("method"),
    url:
      $("#formfalta").attr("action") +
      "&" +
      $("#formfalta").serialize() +
      "&" +
      $("#form1").serialize(),
    data: $("#formfalta").serialize(),
    dataType: "json", //define las variables a mostrar
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        data[i].int_hasta_tn;
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
      }
    });
}

function eliminacionSinReload(columna, id, op, url, caja) {
  $("#content").html('<div class="loader"></div>');
  setTimeout(function () {
    $(".loader").fadeOut("slow");
  }, 700);

  $.ajax({
    dataType: "json",
    data: {
      id: id,
      columna: columna,
      op: op,
      caja: caja,
    },
    url: url, // '../?c=csellado&a=Eliminar',
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data != "") {
        $("#AlertItem").text("Eliminado correctamente... !");

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          //var sumaCaja = parseInt(data[i].int_caja_tn) + parseInt(1);
          $("#consecutivoPaq").text(data[i].id_tn);
          $("#int_caja_tn").val(data[i].int_caja_tn);
          $("#int_paquete_tn").val(data[i].int_paquete_tn);
          $("#int_desde_tn").val(data[i].int_hasta_tn);
          $("#contador_tn").val(data[i].contador_tn); //-1

          numeracionDesde(
            data[i].int_hasta_tn,
            data[i].int_caja_tn,
            data[i].int_paquete_tn,
            data[i].ref_tn,
            data[i].contador_tn
          ); /*para sumarle uno a la numeracion inicial*/
          $("#int_op_tn").val(data[i].int_op_tn);
          $("#int_bolsas_tn").val(data[i].int_bolsas_tn);
          $("#int_undxcaja_tn").val(data[i].int_undxcaja_tn);
          $("#int_undxpaq_tn").val(data[i].int_undxpaq_tn);
          $("#int_cod_empleado_tn").val(data[i].int_cod_empleado_tn);
          $("#int_cod_rev_tn").val(data[i].int_cod_rev_tn);

          $("#validar_paquete").val(0);
          consultaPaquetes(data[i].int_op_tn, data[i].int_caja_tn);
          consultaUnSoloPaquetes(data[i].id_tn);
          consultaPaquetesxOp(data[i].int_op_tn);
          consultaFaltantes(data[i].id_tn);
        }
      } else {
        get = window.location.pathname;
        window.location.href = get + "?c=csellado&a=Inicio";
        $("#AlertItem").text("Error: Ya no hay registros en base de datos");
      }
      $("#AlertItem").fadeIn();
      //location.reload();

      setTimeout(function () {
        $("#AlertItem").fadeOut();
      }, 1000);

      setTimeout(function () {}, 1000);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function cargaInfoOpAdd(op) {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
    },
    url: getUrl + "/view_index.php?c=csellado&a=ConsultarOP&int_op_tn=" + op, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      $("#int_paquete_tn").val("");
      $("#int_caja_tn").val("");
      $("#int_hasta_tn").val("");

      if (data) {
        $("#AlertItem").text("Consultando ... !");

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          $("#cod_ref_n").val(data[i].int_cod_ref_op);
          $("#int_desde_tn").val(data[i].numInicio_op);
          $("#tienefaltantes").val(data[i].imprimiop);
          $("#int_bolsas_tn").val(data[i].int_cantidad_op);
          $("#int_undxcaja_tn").val(data[i].int_undxcaja_op);
          $("#int_undxpaq_tn").val(data[i].int_undxpaq_op);
          $("#ref_tn").val(data[i].int_cod_ref_op);
          $(".referenci").text(data[i].int_cod_ref_op);
          $(".paqhasta").text(data[i].int_undxcaja_op / data[i].int_undxpaq_op);
          $(".charfin").val(data[i].charfin);
          $("#tienefaltantesOP").val(data[i].imprimiop);

          consultaCajaPaqAdd(
            "cod_ref_n",
            data[i].int_cod_ref_op,
            data[i].numInicio_op
          ); //se cambio cod_ref_n ref_tn
          //valida si desde o.p dice que no lleva faltantes
          if (data[i].imprimiop == 0 || data[i].imprimiop == "") {
            $("#imprimirt").attr("disabled", true);
            //$("#faltantess").css("display", "block");//NUEVO
          } else {
            $("#imprimirt").prop("checked"); //$("input[type=checkbox]").prop("checked",true);
            $("#imprimirt").attr("disabled", false);
            //$("#faltantess").css("display", "none");//NUEVO
          }
          valCheck(data[i].numInicio_op);
        }
      } else {
        $("#AlertItem").text("Error: No se Consulto");
      }
      $("#AlertItem").fadeIn();
      //location.reload();

      setTimeout(function () {
        $("#AlertItem").fadeOut();
      }, 1000);

      setTimeout(function () {}, 1000);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function cargaInfoOpAddNew(op) {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
    },
    url: getUrl + "/view_index.php?c=csellado&a=ConsultarAdd&int_op_tn=" + op, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      $("#int_paquete_tn").val("");
      $("#int_caja_tn").val("");
      $("#int_hasta_tn").val("");

      if (data) {
        $("#AlertItem").text("Consultando ... !");

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          $("#cod_ref_n").val(data[i].int_cod_ref_op);
          $("#int_desde_tn").val(data[i].int_hasta_tn);
          $("#tienefaltantes").val(data[i].imprimiop);
          $("#int_bolsas_tn").val(data[i].int_cantidad_op);
          $("#int_undxcaja_tn").val(data[i].int_undxcaja_op);
          $("#int_undxpaq_tn").val(data[i].int_undxpaq_op);
          $("#ref_tn").val(data[i].int_cod_ref_op);
          $(".referenci").text(data[i].int_cod_ref_op);
          $(".paqhasta").text(data[i].int_undxcaja_op / data[i].int_undxpaq_op);
          $(".charfin").val(data[i].charfin);
          $("#tienefaltantesOP").val(data[i].imprimiop);

          consultaCajaPaqAddNew(
            "cod_ref_n",
            data[i].int_cod_ref_op,
            data[i].int_hasta_tn
          ); //se cambio cod_ref_n ref_tn
          //valida si desde o.p dice que no lleva faltantes

          if (data[i].imprimiop == 0 || data[i].imprimiop == "") {
            $("#imprimirt").attr("disabled", true);
          } else {
            $("#imprimirt").prop("checked");
            $("#imprimirt").attr("disabled", false);
          }
          valCheck(data[i].int_hasta_tn);
        }
      } else {
        $("#AlertItem").text("Error: No se Consulto");
      }
      $("#AlertItem").fadeIn();
      //location.reload();

      setTimeout(function () {
        $("#AlertItem").fadeOut();
      }, 1000);

      setTimeout(function () {}, 1000);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaCajaPaqAddNew(columna, ref, numeracionIni) {
  var getUrl = window.location.pathname;
  var numeracionInicial = numeracionIni;
  //var  numeracionIni = JSON.parse(numeracionIni);

  $.ajax({
    dataType: "json",
    data: {
      id: ref,
    },
    //url: getUrl+"/view_index.php?c=csellado&a=ConsultarxId&columnna="+columna+"&id="+ref+"&order=ORDER BY id_tn DESC LIMIT 1"+"&tabla=tbl_tiquete_numeracion", //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    url:
      getUrl +
      "/view_index.php?c=csellado&a=ConsultarxId&columnna=" +
      columna +
      "&id=" +
      ref +
      "&order=ORDER BY fecha_ingreso_n DESC LIMIT 1" +
      "&tabla=tbl_numeracion",
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        var i;
        for (i = 0; i < data.length; i++) {
          $("#int_caja_tn").val(data[i].int_caja_n);
          $("#int_paquete_tn").val(data[i].int_paquete_n);
          $(".paqdesde").val(data[i].contador_n);
          $("#contador_tn").val(data[i].contador_n);

          numeracionIni =
            numeracionInicial == undefined
              ? data[i].int_hasta_n
              : numeracionInicial; //se cambio , numeracionInicial es de la op

          var sellado = 1;
          consultaPaquetes(data[i].int_op_n, data[i].int_caja_n);

          numeracionDesdeAdd(
            numeracionIni,
            data[i].int_caja_n,
            data[i].int_paquete_n,
            ref,
            sellado,
            data[i].contador_n
          );
        }
      } else {
        //Todo esto es si nunca se ha sellado esa referencia
        var caja = $("#imprimirt").val() == 1 ? 0 : 1; // si selecciona sin faltantes la caja debe ser = 1
        var paquete = "0";
        var numeracionIni =
          numeracionInicial == undefined ? "0" : numeracionInicial;
        var contador = "0";
        var sellado = 1;

        numeracionDesdeAdd(
          numeracionIni,
          caja,
          paquete,
          ref,
          sellado,
          contador
        ); //esto es porque la ref nunca se ha sellado  y no existe en tablas de sellado

        if ($("#imprimirt").val() == 0) {
          padesde = 1;
          $(".paqdesde").text(padesde);
        }
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
      }
    });
}

function consultaCajaPaqAdd(columna, ref, numeracionIni) {
  var getUrl = window.location.pathname;
  var numeracionInicial = numeracionIni;
  //var  numeracionIni = JSON.parse(numeracionIni);

  $.ajax({
    dataType: "json",
    data: {
      id: ref,
    },
    //url: getUrl+"/view_index.php?c=csellado&a=ConsultarxId&columnna="+columna+"&id="+ref+"&order=ORDER BY id_tn DESC LIMIT 1"+"&tabla=tbl_tiquete_numeracion", //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    url:
      getUrl +
      "/view_index.php?c=csellado&a=ConsultarxId&columnna=" +
      columna +
      "&id=" +
      ref +
      "&order=ORDER BY fecha_ingreso_n DESC LIMIT 1" +
      "&tabla=tbl_numeracion",
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        var i;
        for (i = 0; i < data.length; i++) {
          $("#int_caja_tn").val(data[i].int_caja_n);
          $("#int_paquete_tn").val(data[i].int_paquete_n);
          $(".paqdesde").val(data[i].contador_n);
          $("#contador_tn").val(data[i].contador_n);

          numeracionIni =
            numeracionInicial == undefined
              ? data[i].int_hasta_n
              : numeracionInicial; //se cambio , numeracionInicial es de la op

          consultaPaquetes(data[i].int_op_n, data[i].int_caja_n);
          numeracionDesdeAdd(
            numeracionIni,
            data[i].int_caja_n,
            data[i].int_paquete_n,
            ref,
            "",
            data[i].contador_n
          );
        }
      } else {
        //Todo esto es si nunca se ha sellado esa referencia
        var caja = $("#imprimirt").val() == 1 ? 0 : 1; // si selecciona sin faltantes la caja debe ser = 1
        var paquete = "0";
        var numeracionIni =
          numeracionInicial == undefined ? "0" : numeracionInicial;
        var contador = "0";

        numeracionDesdeAdd(numeracionIni, caja, paquete, ref, "", contador); //esto es porque la ref nunca se ha sellado  y no existe en tablas de sellado

        if ($("#imprimirt").val() == 0) {
          padesde = 1;
          $(".paqdesde").text(padesde);
        }
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
      }
    });
}

function consultaMaestroAlCargar(columna, id, ref = "") {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      id: id,
    },
    url:
      getUrl +
      "/view_index.php?c=csellado&a=ConsultarxId&columnna=" +
      columna +
      "&id=" +
      id +
      "&order=ORDER BY fecha_ingreso_n DESC LIMIT 1" +
      "&tabla=tbl_numeracion", //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      //
      if (data) {
        var i;
        for (i = 0; i < data.length; i++) {
          $("#int_desde_tn").val(data[i].int_hasta_n);
          numeracionDesde(
            data[i].int_hasta_n,
            data[i].int_caja_n,
            data[i].int_paquete_n,
            data[i].cod_ref_n,
            data[i].contador_n
          ); /*para sumarle uno a la numeracion inicial*/
          //$("#int_op_tn").val(data[i].int_op_n);
          $("#int_bolsas_tn").val(data[i].int_bolsas_n);
          $("#int_undxcaja_tn").val(data[i].int_undxcaja_n);
          $("#int_undxpaq_tn").val(data[i].int_undxpaq_n);
          $("#int_cod_empleado_tn").val(data[i].int_cod_empleado_n);
          $("#int_cod_rev_tn").val(data[i].int_cod_rev_n);
          //$("#contador_tn").val(data[i].contador_n); //no se debe habilitar ya que me sobrescribe el campo

          consultaPaquetes(data[i].int_op_n, data[i].int_caja_n);
          consultaUnSoloPaquetes(data[i].id_tn_n);
          consultaPaquetesxOp(data[i].int_op_n);
        }
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaPaquetes(op, caja) {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
      int_caja_tn: caja,
    },
    url:
      getUrl +
      "/view_index.php?c=csellado&a=Consultar&int_op_tn=" +
      op +
      "&int_caja_tn=" +
      caja, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#Mostrando").text("Consultando ... !");
        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_paquete_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_desde_tn +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_hasta_tn +
            "</a></td>" +
            "</tr>";
        }
        $("#DataConsulta").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaPaquetesHistorico(op, caja, func) {
  var getUrl = window.location;
  var baseurl = getUrl.origin + "/" + getUrl.pathname.split("/")[1];

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
      int_caja_tn: caja,
    },
    url:
      baseurl +
      "/view_index.php?c=csellado&a=" +
      func +
      "&int_op_tn=" +
      op +
      "&int_caja_tn=" +
      caja, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#Mostrando").text("Consultando ... !");
        setTimeout(function () {
          $("#Mostrando").fadeOut();
        }, 2000);

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_paquete_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_desde_tn +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_hasta_tn +
            "</a></td>" +
            "</tr>";
        }
        $("#paquetexcaja").show();
        $("#tiquetxCajas").hide();
        $("#DataConsulta").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaPaquetesHistoricoColas(op, caja, func) {
  var getUrl = window.location;
  var baseurl = getUrl.origin + "/" + getUrl.pathname.split("/")[1];

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
    },
    url: baseurl + "/view_index.php?c=csellado&a=" + func + "&int_op_tn=" + op, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#Mostrando").text("Consultando ... !");
        setTimeout(function () {
          $("#Mostrando").fadeOut();
        }, 2000);

        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_caja_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_desde_tn +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_hasta_tn +
            "</a></td>" +
            "</tr>";
        }
        $("#tiquetxCajas").show();
        $("#paquetexcaja").hide();
        $("#DataConsultaxCaja").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaUnSoloPaquetes(id_tn) {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      id_tn: id_tn,
    },
    url: getUrl + "/view_index.php?c=csellado&a=ConsultarUnSolo&id_tn=" + id_tn, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      //
      if (data) {
        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].id_tn +
            "</span></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].fecha_ingreso_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_paquete_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_caja_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_desde_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'views/view_sellado_caja.php?id_op=" +
            data[i].int_op_tn +
            "&int_paquete_tn=" +
            data[i].int_paquete_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_hasta_tn +
            "</button></td>" +
            '<td><button onClick="eliminacionSinReload(' +
            "'id_tn'" +
            "," +
            data[i].id_tn +
            "," +
            data[i].int_op_tn +
            "," +
            "'?c=csellado&a=Eliminar'" +
            ", " +
            data[i].int_caja_tn +
            ')" id="btnDelItems"  name="btnDelItems" type="button" class="botonDel" autofocus="" >DELETE</button></td>' +
            "</tr>";
        }
        $("#DataResult").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
      }
    });
}

function consultaPaquetesxOp(op) {
  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: op,
    },
    url:
      getUrl +
      "/view_index.php?c=csellado&a=ConsultarTiquetxOP&int_op_tn=" +
      op, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#Mostrando").text("Consultando ... !");
        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_caja_tn +
            "</button></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_desde_tn +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_totaltiqxcaja_colas.php?id_op=" +
            data[i].int_op_tn +
            "&int_caja_tn=" +
            data[i].int_caja_tn +
            "'" +
            ',1200,780)" >' +
            data[i].int_hasta_tn +
            "</a></td>" +
            "</tr>";
        }
        $("#DataConsultaxCaja").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function consultaFaltantes(id) {
  var getUrl = window.location.pathname;
  $("#Faltantes").hide();
  $.ajax({
    dataType: "json",
    data: {
      id_tn: id,
    },
    url: getUrl + "/view_index.php?c=csellado&a=ConsultarFaltantes&id_tn=" + id, //"Controller/Csellado.php?int_op_tn="+op+"&int_caja_tn="+caja, //,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data) {
        $("#Faltantes").show();
        $("#Mostrando").text("Consultando ... !");
        var html = "";
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            "<tr>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].id_op_f +
            "&int_paquete_tn=" +
            data[i].int_paquete_f +
            "&int_caja_tn=" +
            data[i].int_caja_f +
            "'" +
            ',1200,780)" >' +
            data[i].int_paquete_f +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].id_op_f +
            "&int_paquete_tn=" +
            data[i].int_paquete_f +
            "&int_caja_tn=" +
            data[i].int_caja_f +
            "'" +
            ',1200,780)" >' +
            data[i].int_inicial_f +
            "</a></td>" +
            '<td><span style=cursor:pointer onclick="popUpNew(' +
            "'sellado_control_numeracion_vista.php?id_op=" +
            data[i].id_op_f +
            "&int_paquete_tn=" +
            data[i].int_paquete_f +
            "&int_caja_tn=" +
            data[i].int_caja_f +
            "'" +
            ',1200,780)" >' +
            data[i].int_final_f +
            "</a></td>" +
            "</tr>";
        }
        $("#DataConsultaFaltantes").html(html);
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function eliminarconAlerta(idop, caja) {
  swal(
    {
      title: "Estas seguro?",
      text: "Quiere Eliminar Todos los paquetes de la caja?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, Eliminarlos!",
      cancelButtonText: "No, cancelarlo!",
      closeOnConfirm: false,
      // closeOnCancel: false
    },
    function (isConfirm) {
      if (isConfirm) {
        swal(
          {
            title: "Preseleccion!",
            text: "Los archivos fueron eliminados correctamente!",
            type: "success",
            timer: 5,
            showConfirmButton: false,
          },
          function () {
            elimacionCajas(idop, caja, "");

            /*window.opener.location.reload();
	     						window.close();*/
          }
        );
      } else {
        swal("Cancelado ", " Su archivo no se Eliminaros :)", "error");
      }
    }
  );
}

function elimacionCajas(idop, caja, vista = "") {
  //var getUrl = window.location.origin
  var getUrl = window.location;
  var baseurl = getUrl.origin + "/" + getUrl.pathname.split("/")[1];

  $.ajax({
    dataType: "json",
    data: {
      idop: idop,
      caja: caja,
    },
    url:
      baseurl +
      "/view_index.php?c=csellado&a=EliminaCajas&idop=" +
      idop +
      "&caja=" +
      caja,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data == 2) {
        //data==2 quiere decir que ya no hay registros por ende se va para el add de sellado
        var ventanaPadre = window.opener; // padre actual
        if (ventanaPadre && ventanaPadre.location) {
          // Cambia la URL de la ventana padre
          ventanaPadre.location.href =
            baseurl + "/view_index.php?c=csellado&a=Inicio";
        }
        window.close();
      } else {
        window.opener.location.reload();
        window.close();
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      if (console && console.log) {
        //console.log( "La solicitud a fallado: " +  textStatus);
      }
    });
}

function cambioCajaODesdeListado(caja, paquete, ref, reservaAux = "") {
  var totalPaquete = $("#int_undxcaja_tn").val() / $("#int_undxpaq_tn").val();

  //se cambio para imprimir el paquete infinito para ref especial 096
  var reservaAux = parseInt(reservaAux) + parseInt(1);
  //alert(reservaAux)
  if (ref == "096") {
    if ($("#imprimirt").val() == 1) {
      $("#int_paquete_tn").val(parseInt(paquete) + parseInt(totalPaquete));
      $("#int_caja_tn").val(parseInt(caja) + parseInt(1));
      $(".paqdesde").text(totalPaquete);
      $(".paqhasta").text(totalPaquete);
      $("#contador_tn").val(totalPaquete);
    } else {
      var contador = parseInt($("#contador_tn").val());

      $(".paqdesde").text(contador);
      $(".paqhasta").text(totalPaquete);

      if (reservaAux > totalPaquete) {
        //Paquete es mayor al total x caja, cambio de caja
        $("#int_paquete_tn").val(parseInt(paquete) + parseInt(1)); //ok
        $("#contador_tn").val(parseInt(1)); //parseInt(contador)+parseInt(1);
        $(".paqdesde").text(parseInt(1)); //parseInt(contador)-parseInt(1) le resto uno solamente por tema visual
        $("#int_caja_tn").val(parseInt(caja) + parseInt(1)); //$('#int_caja_tn').val( parseInt(caja) )
      } else {
        $("#int_paquete_tn").val(parseInt(paquete) + parseInt(1));
        $("#contador_tn").val(parseInt(reservaAux));
        $(".paqdesde").text(parseInt(reservaAux));
        $("#int_caja_tn").val(parseInt(caja));
      }
    }
  } else {
    if ($("#imprimirt").val() == 1) {
      $("#int_paquete_tn").val(totalPaquete);
      $("#int_caja_tn").val(parseInt(caja) + parseInt(1));
      $(".paqdesde").text(totalPaquete);
      $(".paqhasta").text(totalPaquete);
      $("#contador_tn").val(totalPaquete);
    } else {
      $(".paqdesde").text(paquete);
      $(".paqhasta").text(totalPaquete);

      if (paquete >= totalPaquete) {
        //Paquete es mayor al total x caja, cambio de caja
        $("#int_paquete_tn").val(1);
        $("#contador_tn").val(1);
        $(".paqdesde").text(1);
        $("#int_caja_tn").val(parseInt(caja) + parseInt(1));
      } else {
        $("#int_paquete_tn").val(parseInt(paquete) + parseInt(1));
        $("#contador_tn").val($("#int_paquete_tn").val());
        $(".paqdesde").text(parseInt(paquete) + parseInt(1));
        $("#int_caja_tn").val(caja);
      }
    }
  }
}

function valCheck(numDesde) {
  if ($("#imprimirt").val() == 1) {
    $("#imprimirt").prop("checked", true);
  } else {
    $("#imprimirt").prop("checked", false);
  }

  //NUEVO
  if ($("#tienefaltantesOP").val() == 1) {
    $("#faltantess").css("display", "none");
  } else {
    $("#faltantess").css("display", "block");
  }
  //
  if ($("#imprimirt").val() == 1) {
    $("#tiquetxCajas").show(50);
    $("#botonporCajas").show();
    //$("#faltantess").css("display", "none");//NUEVO
    $("#botonSellado").hide();
    $("#element").show(50);
    $("#paqycajasnormal").hide();
    $("#paquetexcaja").hide(50);
    $("#pesot").show();
    $("#checkfaltantes").text("SIN FALTANTES");
  } else {
    $("#tiquetxCajas").hide();
    $("#botonSellado").show();
    //$("#faltantess").css("display", "block");//NUEVO
    $("#botonporCajas").hide();
    $("#element").show(50);
    $("#paqycajasnormal").show(50);
    $("#paquetexcaja").show(50);
    $("#checkfaltantes").text("CON FALTANTES");
  }
  $("#tienefaltantes").val($("#imprimirt").val()); //
}

function popUpNew(URL, ancho, alto) {
  day = new Date();
  id = day.getTime();
  derecha = (screen.width - ancho) / 2;
  arriba = (screen.height - alto) / 2;
  ventana =
    "toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=" +
    ancho +
    ",height=" +
    alto +
    ",left=" +
    derecha +
    ",top=" +
    arriba +
    "";
  eval("page" + id + " = window.open(URL, '" + id + "', '" + ventana + "');");
}

/* ++++++++++INICIO NUEVAS FUNCIONES PARA EL MANEJO DE LAS BANDERAS +++++++++*/
function cargaInfoRollos(id_op) {
  //consulta los rollos que estan asociados a la op seleccionada en sellado numeracion inicio
  var getUrl = window.location.pathname;
  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: id_op,
    },
    url:
      getUrl +
      "/view_index.php?c=csellado&a=ConsultarOProllo&int_op_tn=" +
      id_op,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      document.querySelector("#id_rollo").innerHTML = ""; //Borra todo lo que tenga el select
      if (data != "0") {
        $("#id_rollo").append(
          $("<option>", {
            value: "",
            text: "Rollos",
          })
        );
        data.forEach((element) => {
          $("#id_rollo").append(
            $("<option>", {
              value: element.rollo_r,
              text: element.rollo_r,
            })
          );
        });
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      document.querySelector("#id_rollo").innerHTML = ""; //Borra todo lo que tenga el select
      console.log("La solicitud a fallado: " + textStatus);
    });
}

function cargaInfoRolloSellado(id_op, rollo_r) {
  //consulta la cantidad de bolsas que han sellado de un rollo en especifico en la pag sellado numeracion

  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: id_op,
      rollo_r: rollo_r,
    },
    url:
      getUrl +
      "?c=csellado&a=ConsultarInfoRollo&int_op_tn=" +
      id_op +
      "&rollo_r=" +
      rollo_r,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      var anchoBolsa = $("#anchoRef").val();
      var metros = parseInt( //cantidad de metros que se van sellando, incrementa cada vez que guardan numeracion
        (data[0].num_final - data[0].num_inicial + 1) * (anchoBolsa / 100)
      );
      $("#cant_metros").val(metros);
      $("#desperdicio_inicial").val(data[0].mts_desperdicio);
      console.log( "anchobolsa:" + anchoBolsa +"cm cantBolsas:" +(data[0].num_final - data[0].num_inicial + 1) + "--" +"metros:" +metros+" desperdicio:"+data[0].mts_desperdicio+"mts");
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(
        "La solicitud a fallado: " + textStatus + " -- " + errorThrown
      );
    });
}

async function consultaBanderas(id_op, rollo_r) {
  //consulta la cantidad de bolsas que han sellado de un rollo en especifico en la pag sellado numeracion

  var getUrl = window.location.pathname;

  return new Promise((resolve, reject) => {
    $.ajax({
      dataType: "json",
      data: {
        id_op: id_op,
        rollo_r: rollo_r,
      },
      url:
        getUrl +
        "?c=csellado&a=consultarBanderas&id_op=" +
        id_op +
        "&rollo_r=" +
        rollo_r,
      type: "POST",
    })
      .done(function (data, textStatus, jqXHR) {
        resolve(data);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        reject("La solicitud a fallado: " + textStatus + " -- " + errorThrown);
      });
  });
}

//consulta si existen rollos disponibles para sellado y llena el select id_rollo en view_sellado_numeracion
async function verificarRollo(id_op) {
  var getUrl = window.location.pathname;

  return new Promise((resolve, reject) => {
    $.ajax({
      dataType: "json",
      data: {
        id_op: id_op,
      },
      url: getUrl + "?c=csellado&a=ConsultarCantidadRollos&id_op=" + id_op,
      type: "POST",
    })
      .done(function (data, textStatus, jqXHR) {
        document.querySelector("#id_rollo").innerHTML = ""; //Borra todo lo que tenga el select
        if (data[0].length != 1 || data[1] == false) {
          $("#id_rollo").append(
            $("<option>", {
              value: "",
              text: "Rollos",
            })
          );
          data[0].forEach((element) => {
            $("#id_rollo").append(
              $("<option>", {
                value: element.rollo_r,
                text: element.rollo_r,
              })
            );
          });
          resolve(false);
        } else {
          $("#id_rollo").append(
            $("<option>", {
              value: data[0][0].rollo_r,
              text: data[0][0].rollo_r,
            })
          );
          $("#rollo_r").val(data[0][0].rollo_r);
          resolve(true);
        }

      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        reject("La solicitud a fallado: " + textStatus + " -- " + errorThrown);
      });
  });
}

function actualizaInfoRolloSellado(id_op, rollo_r, num_final) {
  //consulta la cantidad de bolsas que han sellado de un rollo en especifico en la pag sellado numeracion

  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: id_op,
      rollo_r: rollo_r,
      num_final: num_final,
    },
    url:
      getUrl +
      "?c=csellado&a=actualizarInfoRollo&int_op_tn=" +
      id_op +
      "&rollo_r=" +
      rollo_r +
      "&num_final=" +
      num_final,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {})
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(
        "La solicitud a fallado: " + textStatus + " -- " + errorThrown
      );
    });
}

function actualizaBandera(operario, fecha, estado, id_op, id_bandera) {
  //consulta la cantidad de bolsas que han sellado de un rollo en especifico en la pag sellado numeracion

  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      operario_verificacion: operario,
      fecha_verificacion: fecha,
      estado: estado,
      id_op: id_op,
      id_bandera: id_bandera,
    },
    url:
      getUrl +
      "?c=csellado&a=actualizarBandera&int_op_tn=" +
      id_op +
      "&id_bandera=" +
      id_bandera,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      console.log(data);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(
        "La solicitud a fallado: " + textStatus + " -- " + errorThrown
      );
    });
}

function guardarRolloSeleccionado(id_op, numRollo, desde, hasta) {
  //consulta la cantidad de bolsas que han sellado de un rollo en especifico en la pag sellado numeracion

  var getUrl = window.location.pathname;

  $.ajax({
    dataType: "json",
    data: {
      int_op_tn: id_op,
      numRollo: numRollo,
      desde: desde,
      hasta: hasta,
    },
    url:
      getUrl +
      "?c=csellado&a=guardarInfoCompletaRollo&int_op_tn=" +
      id_op +
      "&numRollo=" +
      numRollo +
      "&desde=" +
      desde +
      "&hasta=" +
      hasta,
    type: "post",
  })
    .done(function (data, textStatus, jqXHR) {
      console.log(textStatus);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(
        "La solicitud a fallado: " + textStatus + " -- " + errorThrown
      );
    });
}

/* ++++++++++FIN NUEVAS FUNCIONES PARA EL MANEJO DE LAS BANDERAS +++++++++*/
