/*function adelanto()
{
 
	var valoroperar=document.form1.subtotal.value;
	var reserva_total_oc=document.form1.total_items.value;
	var adelanto=document.form1.adelanto_oc.value;
	if(adelanto!=0 || adelanto!=''){
    	var nuevo_total=parseFloat(valoroperar-adelanto)//ya tiene el valor iva; 
        decimalesForm(nuevo_total,'total_oc'); 
    }else{ 
    	decimalesForm(valoroperar,'total_oc');
    }

}
*/
/*function rte_fte(){
 
	var constante_fte=parseFloat(document.form1.constante_fte.value); 
	var valor_bruto_oc=document.form1.valor_bruto_oc.value; 
  
	if((valor_bruto_oc !='' ) && (constante_fte !='' ) ){
	var valor_const_fte = parseFloat(valor_bruto_oc)*parseFloat(constante_fte)/100; 
	 valor_const_fte=valor_const_fte.toFixed(2);
	 document.form1.fte_oc.value  = valor_const_fte ;
 
	} 
}

function fte_iva(){
	const_fte_iva=parseFloat(document.form1.constante_fte_iva.value); 
	var reserva_total_oc=document.form1.total_items.value;  
	var fte_oc = document.form1.fte_oc.value;
	var fte_iva_oc = document.form1.fte_iva_oc.value;
	var fte_ica_oc = document.form1.fte_ica_oc.value;
	var total_todas = parseFloat(fte_oc)+parseFloat(fte_ica_oc);

	if(const_fte_iva!=0){
		var valor_const_fte_iva=(reserva_total_oc*const_fte_iva/100);
		document.form1.fte_iva_oc.value=valor_const_fte_iva.toFixed(2);
		var total = parseFloat(reserva_total_oc)-(parseFloat(valor_const_fte_iva+total_todas));
		var valor_total=total.toFixed(2);
		document.form1.subtotal.value=valor_total;//para operar sin puntos el nuevo total_oc 
		decimalesForm(valor_total,'total_oc'); 
	}else if(const_fte_iva==0){
		var subtotal=document.form1.subtotal.value; 
		var valortotal = parseFloat(subtotal)+parseFloat(document.form1.fte_iva_oc.value); 
		decimalesForm(valortotal,'total_oc'); 
		document.form1.subtotal.value=valortotal;//para operar sin puntos el nuevo total_oc
		document.form1.fte_iva_oc.value=0;   
	}
}

function fte_ica(){
	const_fte_ica=parseFloat(document.form1.constante_fte_ica.value); 
	var reserva_total_oc=document.form1.total_items.value;  
	var fte_oc = document.form1.fte_oc.value;
	var fte_iva_oc = document.form1.fte_iva_oc.value;
	var fte_ica_oc = document.form1.fte_ica_oc.value;
	var total_todas = parseFloat(fte_oc)+parseFloat(fte_iva_oc);
	
	if(const_fte_ica!=0){ 
		var valor_const_fte_ica=(reserva_total_oc*const_fte_ica/100);
		document.form1.fte_ica_oc.value=valor_const_fte_ica.toFixed(2);
		var total = parseFloat(reserva_total_oc)-(parseFloat(valor_const_fte_ica+total_todas));
		var valor_total=total.toFixed(2); 
		document.form1.subtotal.value=valor_total;//para operar sin puntos el nuevo total_oc
		decimalesForm(valor_total,'total_oc'); 
	}else if(const_fte_ica==0){
		var subtotal=document.form1.subtotal.value;   
		var valortotal = parseFloat(subtotal)+parseFloat(document.form1.fte_ica_oc.value); 
		decimalesForm(valortotal,'total_oc'); 
		document.form1.subtotal.value=valortotal;//para operar sin puntos el nuevo total_oc
		document.form1.fte_ica_oc.value=0;
	}
}*/




function neto_totalizar(){
    	var adelanto_oc=document.form1.adelanto_oc.value==''?'0':document.form1.adelanto_oc.value; 
    	var subtotal=document.form1.valor_bruto_oc.value;  // es el subtotal de los items
    	var constante_iva=document.form1.constante_iva.value;  
    	

	if(subtotal!=0){ 
		

		var valor_iva_oc=(subtotal*constante_iva/100);
		document.form1.valor_iva_oc.value=valor_iva_oc.toFixed(2);//valor iva
        
        var totalconiva= (parseFloat(subtotal)+parseFloat(valor_iva_oc))-parseFloat(adelanto_oc);//total siempre se le resta adelanto
      
		var fte_oc = parseFloat(subtotal)*(parseFloat(document.form1.constante_fte.value)/100); 
	    document.form1.fte_oc.value= fte_oc.toFixed(2);//valor Rte. Fte

	    var fte_iva_oc = parseFloat(subtotal)*(parseFloat(document.form1.constante_fte_iva.value)/100); 
	    document.form1.fte_iva_oc.value= fte_iva_oc.toFixed(2);//valor Rte. IVA

	    var fte_ica_oc = parseFloat(subtotal)*(parseFloat(document.form1.constante_fte_ica.value)/100); 
	    document.form1.fte_ica_oc.value= fte_ica_oc.toFixed(2);//valor Rte. ICA
 
        var total_todas = parseFloat(document.form1.fte_oc.value)+parseFloat(document.form1.fte_iva_oc.value)+parseFloat(document.form1.fte_ica_oc.value);
		 
		var total = parseFloat(totalconiva)-(parseFloat(total_todas));
		var valor_total=total.toFixed(2); 
		document.form1.total_oc.value=valor_total;//para operar sin puntos el nuevo total_oc

		decimalesForm(valor_total,'total_oc'); 
	}else {
		 
	}
}


function decimalesForm(valor,names)
{
	
	if(!isNaN(valor)){
		valor = valor.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
		valor = valor.split('').reverse().join('').replace(/^[\.]/,'');

		if(names=='valor_bruto_oc')
			$("[name='valor_bruto_oc']").val(valor) 
		if(names=='valor_iva_oc')
			$("[name='valor_iva_oc']").val(valor) 
		if(names=='fte_oc')
			$("[name='fte_oc']").val(valor) 
		if(names=='fte_iva_oc')
			$("[name='fte_iva_oc']").val(valor) 
		if(names=='fte_ica_oc')
			$("[name='fte_ica_oc']").val(valor) 
		if(names=='total_oc')
			$("[name='total_oc']").val(valor) 

	} 
}