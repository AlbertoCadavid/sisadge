<style type="text/css">
.check
{	font-size:12px;
	font-weight:bold;
	color:#000000;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	cursor:pointer;
}
</style>
<br />
<center><div>{php_zip}</div></center>
<form id="planillas" name="planillas" method="post" action="index.php?mdl=deame3p&amp;ctr=Planillas&amp;acc=admArchivos" enctype="multipart/form-data">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong><span class="titulosInternosRedondeados">DEAME3P - V.({version}) - Administrar planillas.</span></strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);"><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">{errores}</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="4%">&nbsp;</td>
        <td colspan="4"><div align="center"><samp class="check" id="invertir">invertir</samp> - <samp class="check" id="ninguno">ninguno</samp> - <samp class="check" id="todos">todos</samp></div></td>
        <td>&nbsp;</td>
      </tr>
      <!-- BEGIN archivos -->
      
      <tr>
        <td><input type="checkbox" name="planillaEliminar[]" value="{archivos.nombre}" /></td>
        <td>&nbsp;{archivos.nombre}&nbsp;</td>
        <td>&nbsp;{archivos.update}&nbsp;</td>
        <td><div align="right">&nbsp;{archivos.size}&nbsp;</div></td>
        <td><input {archivos.attr} type="button" name="previa_{archivos.previa}" id="previa_{archivos.previa}" class="opfg_mostrar_previa_xlsx" value="&nbsp;&nbsp;" title="{archivos.nombre}" style="background-image:url(imagenes/page_excel.png); border-style:solid; border-width:1px; border-color:#999999; background-repeat:no-repeat; background-position:center; vertical-align:middle;" /></td>
      </tr>
   <!-- END archivos -->

      <tr>
        <td>&nbsp;</td>
        <td><strong>La vista previa solo esta disponible par archivos xlsx.</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3"><div class="aerobuttonmenu"><samp class="aero"><span><button  name="procesar" id="procesar" class="boton" value=""> Eliminar &nbsp;</button></span></samp></div></td>
      	<td>&nbsp;</td>
      </tr>
      
    </table></td>
    <td style="background-image:url(imagenes/ventanaAyudaLMD.png);" >&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/ventanaAyudaLII.png" width="21" height="19" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCI.png);">&nbsp;</td>
    <td><img src="imagenes/ventanaAyudaLID.png" width="21" height="19" alt="" /></td>
  </tr>
</table>
</form>