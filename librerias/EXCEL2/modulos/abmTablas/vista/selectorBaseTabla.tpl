<br />
<div align="center" class="boldtext1 Estilo11">{php_zip}</div>
<form id="deExcelAMysql" name="deExcelAMysql" method="post" action="index.php?mdl=abmTablas&amp;ctr=SeleccionarBase&amp;acc=seleccionarBase" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong><span class="titulosInternosRedondeados">DEAME3P - V.({version}) - Seleccion de Base de datos y Tabla</span>.-</strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);"><table width="700" border="0" align="center" cellpadding="0" cellspacing="5" class="bordeTablaRedondeado">
      <tr style="height:18px; width:40%">
        <td width="10">&nbsp;</td>
        <td colspan="3"><div id='progreso'>
          <div align="center"><img src="imagenes/ajax-loader.gif" width="43" height="11" alt="Consultando ..." /><span id='msjProgreso' class="boldtext1"> ... Trabajando ...</span> <img src="imagenes/ajax-loader.gif" width="43" height="11" alt="Consultando ..."/></div>
        </div></td>
        <td width="10">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" ><div align="center"><strong>{errores}</strong></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="128" >Importar desde:</td>
        <td><select name="baseDeDatos"  id="baseDeDatos" class="inputsText" >
          <option>Base de Datos ...</option>
        </select>        </td>
        <td style="width:40%;"><select name="tabla" class="inputsText" id="tabla">
          <option>Tabla de Datos ...</option>
        </select></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:40%;"><div class="aerobuttonmenu" >
          <samp class="aero"><span>
            <button  name="procesar" id="procesar" class="boton">Seleccionar</button>
            </span></samp>
        </div></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:40%;">&nbsp;</td>
        <td></td>
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
