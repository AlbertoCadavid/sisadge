<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DEAME3P - Previa Excel 2007</title>
<link rel="stylesheet" type="text/css" href="estilos/deame3p_vista.css"   />
</head>
<body style="background-color:#FFFFFF;">
<table width="983px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><img src="imagenes/previaExcelSuperior.png" width="983" height="180" alt="Excel 2007" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/previaExcelBordeIzq.png); width:16px;" >&nbsp;</td>
    <td>
   	<div style="width:100%; overflow:auto; height:375px; background-color:#FFFFFF;" >
    <table cellpadding="0" cellspacing="0" class="previaExcel">
    <tr><td style="background-color:#A9C4E9; background-image:url(imagenes/previaExcelFlecha.png); background-repeat:no-repeat; background-position:right; min-width:20px;">&nbsp;</td>
      	<!-- BEGIN columnas -->
        	<td style="background-image:url(imagenes/fondoColumnaExcel.png); height:19px; text-align:center; font-weight:bold;" >{columnas.letra}</td>
		<!-- END columnas -->
    </tr>
  <tr>
  	<td style="text-align:center; background-color:#E4ECF7;">1</td>
  	<!-- BEGIN titulos -->
    <td class='previaExceltitulo'>&nbsp;{titulos.nombre}</td>
    <!-- END titulos -->
  </tr>
  <!-- BEGIN fila -->
  <tr>
  	<td style="text-align:center; background-color:#E4ECF7;" >{fila.numero}</td>
  	<!-- BEGIN datos -->
    <td>&nbsp;{fila.datos.nombre}</td>
    <!-- END datos -->
  </tr>
  <!-- END fila -->
</table>
    </div>

    
    </td>
    <td style="background-image:url(imagenes/previaExcelBordeDer.png); width:18px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><img src="imagenes/previaExcelInferior.png" width="983" height="44" alt="Excel2007" /></td>
  </tr>
</table>
</body>
</html>