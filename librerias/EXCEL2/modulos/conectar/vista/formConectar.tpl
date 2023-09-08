<br />
<form name="registrarModulo" id="registrarModulo" method="post" action="index.php?mdl=conectar&amp;ctr=Conexion&amp;acc=formConexion" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong>Conectarse con el Servidor</strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);"><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td colspan="3"><div align="center" style="margin:5px;"><strong>&nbsp;{mensajeError}&nbsp;</strong></div></td>
        </tr>
      <tr>
        <td width="140">Servidor :</td>
        <td width="12">&nbsp;</td>
        <td width="250"><input name="servidor" type="text" class="inputsText" id="servidor" value="{servidor}" /></td>
      </tr>
      <tr>
        <td>Usuario :</td>
        <td>&nbsp;</td>
        <td><input name="usuario" type="text" class="inputsText" id="usuario" value="{usuario}" /></td>
      </tr>
      <tr>
        <td>Clave :</td>
        <td>&nbsp;</td>
        <td><input name="clave" type="password" class="inputsText" id="clave" value="{clave}" /></td>
      </tr>
      <tr>
        <td>Puerto :</td>
        <td>&nbsp;</td>
        <td><input name="puerto" type="text" class="inputsText" id="puerto" value="{puerto}" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
        	<table width="243">
          		<tr>
                	<td width="64">
                    	<div class="aerobuttonmenu"><samp class="aero"><span><button type="reset" name="restablecer" id="restablecer" class="boton">Limpiar</button></span></samp></div></td>
       			  <td width="97">&nbsp;</td>
                <td width="73"><div class="aerobuttonmenu"><samp class="aero"><span><button type="submit" name="enviar" id="enviar" class="boton">Conectar</button></span></samp></div></td></tr>
                </table>
      	</td>
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