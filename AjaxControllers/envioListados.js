function envioListados() { 
    var str_numero_oc = document.getElementById("str_numero_oc").value;
    var elaborador = document.getElementById("elaborador").value;
    var vendedor = document.getElementById("vendedor").value;
    var id_c = document.getElementById("id_c").value;
    var nit_c = document.getElementById("nit_c").value;
    var estado_oc = document.getElementById("estado_oc").value;
    var pendiente = document.getElementById("pendiente").value;
    var cod_ref = document.getElementById("cod_ref").value;
    var tbpw = document.getElementById("tbpw").value;
    var fecha_ini = document.getElementById("fecha_ini").value;
    var fecha_fin = document.getElementById("fecha_fin").value;
    var factura = document.getElementById("factura").value;
    var nfactura = document.getElementById("nfactura").value;
    var autorizado = document.getElementById("autorizado").value;
 window.location.href ="orden_compralist_excel.php?str_numero_oc="+str_numero_oc+'&elaborador='+elaborador+'&vendedor='+vendedor+'&id_c='
 +id_c+'&nit_c='+nit_c+'&estado_oc='+estado_oc+'&pendiente='+pendiente+'&cod_ref='+cod_ref+'&tbpw='+tbpw
 +'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&factura='+factura+'&nfactura='+nfactura+'&autorizado='+autorizado;
}  