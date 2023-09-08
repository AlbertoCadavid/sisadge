function verFoto(img, ancho, alto){
	derecha=(screen.width-ancho)/2;
	arriba=(550-alto)/2;
	string="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto+",left="+derecha+",top="+arriba+"";
	fin=window.open(img,"",string);
}

    function sumaDias(fecha, dias){
         var calcfecha = new Date(fecha+"T00:00:00"); // fuerza la zona horaria  al formato yyyy-MM-ddT00:00:00, si no se hace esto los dias se resta uno (explicación? tiene que ver con la zona horaria y que resta tiempo automáticamente)
         var calctiempopermiso = parseInt(dias); //mis horas que se suman se ingresan por un input
         calcfecha.setDate(calcfecha.getDate() + calctiempopermiso); //lo mismo del pibe
         calcfecha.setMonth(calcfecha.getMonth()); //por alguna razón sumar 1 aquí no ayudaba
         var finanno = calcfecha.getFullYear();//guardo año
         var finmes = calcfecha.getMonth();//guardo mes
         var findia = calcfecha.getDate() < 10 ? '0' + calcfecha.getDate() : '' + calcfecha.getDate();//doy formato a dia para que sea de 2 dígitos "01", "05", "10", etc.  
         finmes = finmes + 1; // sume + 1 por que parece que los meses inician desde "0" es decir que enero seria 0 y diciembre seria 11 (para que lo acepte el input date que tengo) 
         finmes = finmes < 10 ? '0' + finmes : '' + finmes; // el mismo tratamiento del día    
         fecha = (finanno+"-"+finmes+"-"+findia); //imprimo por consola la fecha ya correcta
         $('#fecha_plazo').val(fecha);
    } 