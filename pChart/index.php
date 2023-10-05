<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 

include_once("Models/Mconnection.php");
$conexion = new ApptivaDB();

   $row_codigo_empleado = $conexion->llenaSelect('empleado a INNER JOIN TblProcesoEmpleado b ','ON a.codigo_empleado=b.codigo_empleado WHERE b.estado_empleado=1 ','ORDER BY a.nombre_empleado ASC');//a.tipo_empleado IN(4) AND 


?> 
<html>
<head>
	<title> Graficas Acycia</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/indexcss.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../css/general.css"/>
    <link rel="stylesheet" type="text/css" href="../css/formato.css"/>
    <link rel="stylesheet" type="text/css" href="../css/desplegable.css" />
 </head>
<body>
 
  <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
    <div align="center">
      <table style="width: 100%">
        <tr>
         <td align="center">
           <div class="row-fluid">
             <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
               <div class="panel panel-primary">
                <div class="panel-heading" align="left" ></div><!--color azul-->
                 <div class="row" >
                   <div class="span12"  align="left" >&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/cabecera.jpg"><!-- <a href="../menu.php"><input name="logo" src="images/logoacyc.jpg" type="image"></a> --> 
                         &nbsp;&nbsp;&nbsp;  </div>
                 </div>
                 <div class="panel-heading" align="left" ></div><!--color azul-->
                    <div id="cabezamenu">
                     <ul id="menuhorizontal"> 
                      <li><a href="../menu.php">MENU PRINCIPAL</a></li>  
                    </ul>
                </div> 
               <div class="panel-body">
                  
                 <div ><!--  SI QUITO  class="container" SE ALINEA A LA IZQUIERDA TODO EL CONTENIDO DE ESTE Y SE REDUCE -->
           
          <!-- grid -->
	<table>
    <tr>
      <td colspan="12" id="titulo">GRAFICA ESPECIFICA </td>
    </tr>
      <tr > 
           
            <td colspan="4" id="titulo1">
             <strong >PROCESOS: </strong>
              <select name="proceso" id="proceso" class="busqueda selectsMedio">
                  <option value="0">TODOS</option> 
                  <option value="1">Extrusion</option>
                  <option value="2">Impresion</option>
                  <option value="4">Sellado</option> 
              </select> 
            </td> 
          <td colspan="4" id="titulo1">
           <strong >MAQUINA: </strong>
            <select name="maqui" id="maqui" class="busqueda selectsMedio">
                <option value="0">TODAS</option> 
                <option value="10">1 Maquina Extrusora</option>
                <option value="21">2 Maquina Extrusora</option>
                <!-- <option value="8">1 Maquina Impresora</option> -->
                <option value="9">2 Maquina Impresora</option>
                <option value="20">3 Maquina Impresora</option>
                <option value="1">1 Maquina Selladora</option>
                <option value="2">2 Maquina Selladora</option>
                <!-- <option value="3">3 Maquina Selladora</option> -->
                <!-- <option value="6">4 Maquina Selladora</option> -->
                <!-- <option value="14">5 Maquina Selladora</option>  -->
                <option value="16">7 Maquina Selladora</option>
                <!-- <option value="17">6 Maquina Selladora</option> -->
                <option value="18">8 Maquina Selladora</option>
                <option value="19">9 Maquina Selladora</option> 
                <option value="22">10 Maquina Selladora</option>
                <option value="23">11 Maquina Selladora</option>
            </select> 
        
             <strong >OPERARIO: </strong>
             <select name="operario" id="operario" class="busqueda selectsMedio"> 
              <option value="0"<?php if (!(strcmp("0", $_GET['operario']))) {echo "selected=\"selected\"";} ?>>TODOS</option>
                  <?php  foreach($row_codigo_empleado as $row_codigo_empleado ) { ?>
                    <option value="<?php echo $row_codigo_empleado['codigo_empleado']?>"<?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $_GET['operario']))) {echo "selected=\"selected\"";} ?>><?php echo $row_codigo_empleado['codigo_empleado']." - ".$row_codigo_empleado['nombre_empleado']." ".$row_codigo_empleado['apellido_empleado']?></option>
                  <?php } ?>
                </select>

          </td> 
  </tr>
	<tr>
    <td >
      <br><br><br><br> <br><br><br><br> 
    </td> 
    <td><a class="botonGeneral" style="text-decoration:none; " onClick="opcion1();">Tiempo M</a></td>
    <td><a class="botonGeneral" style="text-decoration:none; " onClick="opcion2();">Tiempo P</a></td> 
    <td><a class="botonGeneral" style="text-decoration:none; " onClick="opcion3();">Desperdicio</a></td> 
    <td><a class="botonFinalizar" style="text-decoration:none; " onClick="opcion4();">Exportar</a></td>   

<!--    <td><a href="../menu.php"><input name="logo" src="images/logoacyc.jpg" type="image"></a></td> 
   <td><input name="tiempom" src="images/tiempom.png" type="image"  onClick="opcion1();" class="boton"></td>
   <td><input name="tiempop" src="images/tiempop.png" type="image" onClick="opcion2();" class="boton"></td>
   <td><input name="desperdicio" src="images/desperdicio.png" type="image" onClick="opcion3();" class="boton"> </td>
   <td><input name="exportar" src="images/exportar.png" type="image" onClick="opcion4();" class="boton"></td>
   <td><a href="../menu.php"><input name="menu" src="images/menu.png" type="image" class="boton"></a></td>  -->

    <td><em><strong><a href="index_categories.php">Ir a Grafica Especifica</a></strong></em></td>
    <td><em><strong><a href="index_categories.php">Consulta por a&ntilde;o</a></strong></em></td>
    <td><em><strong><a href="index_categories.php">Indicador</a></strong></em></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
 </tr>
 <tr>
  <td colspan="14"><em> Nota: para que el informe grafico sea mas acertado es muy importante que todas las op esten registradas y liquidadas.<em></td>
  </tr>
	</table>
 <div id="contenido">
<iframe id="marco">

</iframe>
</div>
 
</div> 

          </div> 
             


   </div> <!-- contenedor -->

 </div>
</div>
</div>
</div>
</td>
</tr>
</table>
</div> 
</div>
</body>

</html>


<script languaje="javascript">



function opcion1(){
var m=document.getElementById('marco'); 
codigo = '1'
m.src="tiempom.php?codigo="+codigo+"&maqui="+document.getElementById('maqui').value+"&proceso="+document.getElementById('proceso').value+"&operario="+document.getElementById('operario').value;
}
function opcion2(){
var m=document.getElementById('marco');
codigo = '2'
m.src="tiempop.php?codigo="+codigo+"&maqui="+document.getElementById('maqui').value+"&proceso="+document.getElementById('proceso').value+"&operario="+document.getElementById('operario').value;

}
function opcion3(){
var m=document.getElementById('marco');
codigo = '3'
m.src="desperdicio.php?codigo="+codigo+"&maqui="+document.getElementById('maqui').value+"&proceso="+document.getElementById('proceso').value+"&operario="+document.getElementById('operario').value;
}
function opcion4(){
var m=document.getElementById('marco');
m.src="exportar.php?codigo="+codigo+"&maqui="+document.getElementById('maqui').value+"&proceso="+document.getElementById('proceso').value+"&operario="+document.getElementById('operario').value;

} 
</script>