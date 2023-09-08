<br />
<div id=""seleccionarHojasExcel">
<form name="selHoja" id="selHoja" method="post" action="index.php?mdl=deame3p&ctr=Exportar&acc=relaciones" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong><span class="titulosInternosRedondeados">DEAME3P {version} - Cambiar Hoja Activa</span></strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);">
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="5" class="bordeTablaRedondeado">
  <tr >
    <td width="15">&nbsp;</td>
    <td width="223" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archivo&nbsp;: </td>
    <td colspan="2" >{archivo}</td>
    <td width="15">&nbsp;</td>
  </tr>
    <tr >
    <td width="15">&nbsp;</td>
    <td width="223" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Funciones&nbsp;: </td>
    <td colspan="2" >{funciones}</td>
    <td width="15">&nbsp;</td>
  </tr>
    </tr>
    <tr >
    <td width="15">&nbsp;</td>
    <td width="223" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td width="15">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span >
        </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hojas Excel :&nbsp;</td>
    <td colspan="2" >&nbsp;
    
    <select name="hojasExcel" id="hojasExcel" class="inputsText">
		<!-- BEGIN hojasExcel -->
		<option value="{hojasExcel.valor}" {hojasExcel.seleccionado} >{hojasExcel.nombre}</option> 
		<!-- END hojasExcel -->
		</select>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><input name="baseDeDatos" type="hidden" id="baseDeDatos" value="{baseDeDatos}" />
      <input name="tabla" type="hidden" id="tabla" value="{tabla}" />
      <input name="borrarArchivo" type="hidden" id="borrarArchivo" value="{borrarArchivo}" />
      <input name="modoDeame3p" type="hidden" id="modoDeame3p" value="{modoDeame3p}" />
      <input name="funcionesDeame3p" type="hidden" id="funcionesDeame3p" value="{funcionesDeame3p}" />
      <input name="funciones" type="hidden" id="funciones" value="{funciones}" />
      <input name="codificacion" type="hidden" id="codificacion" value="{codificacion}" />
      <input name="tiempoLimiteScript" type="hidden" id="tiempoLimiteScript" value="{tiempoLimiteScript}" />
      <input name="limiteMemoria" type="hidden" id="limiteMemoria" value="{limiteMemoria}" />
      <input name="planServ" type="hidden" id="planServ" value="{planServ}" />
      <input name="patronExportacion" type="hidden" id="patronExportacion" value="{patronExportacion}" /></td>
    <td width="223">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
      <div class="aerobuttonmenu" style="float:right;"><samp class="aero"><span>
        <button type="submit" name="sstm_Submit" id="sstm_Submit" class="boton"> Cambiar Hoja&nbsp;</button>
      </span></samp></div>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="224">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    
    </td>
    <td style="background-image:url(imagenes/ventanaAyudaLMD.png);" >&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/ventanaAyudaLII.png" width="21" height="19" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCI.png);">&nbsp;</td>
    <td><img src="imagenes/ventanaAyudaLID.png" width="21" height="19" alt="" /></td>
  </tr>
</table>
</form>
<div>
<br />
<form name="tabla" id="tabla" method="post" action="index.php?mdl=deame3p&amp;ctr=ExcelAMysql&amp;acc=exportar" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong><span class="titulosInternosRedondeados">DEAME3P {version} - Relacionar Campos</span></strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);">
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="5" class="bordeTablaRedondeado">
  <tr >
    <td width="15">&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archivo&nbsp;: </td>
    <td colspan="2" >{archivo}</td>
    <td width="15">&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hoja Excel&nbsp;: </td>
    <td colspan="2" >{hojaExcel}</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Base&nbsp; : 
        <input name="sstm_baseDeDatos" type="hidden" id="sstm_baseDeDatos" value="{base}" />    </td>
    <td colspan="2"  >{base}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tabla&nbsp;: 
        <input name="sstm_tabla" type="hidden" id="sstm_tabla" value="{tabla}" />    </td>
    <td colspan="2"  >{tabla}</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patron sugerido&nbsp;: </td>
    <td colspan="2"  ><input type="text" name="sstm_patron_sugerido" id="sstm_patron_sugerido" class="inputsText" value="{patronSugerido}" readonly="readonly" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patron a exportar&nbsp;:      </td>
    <td colspan="2"  ><input type="text" name="sstm_patron_exportacion" id="sstm_patron_exportacion" class="inputsText" value="{patron}" placeholder="Patron de Exportacion" readonly="readonly" />    </td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="titulosInternos" >Opciones Especiales</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" ><div align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="exportarTodasLasHojas" id="exportarTodasLasHojas" value="1" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Exportar todas las hojas con la misma configuracion.</div></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="formulaValor" id="formulaValor" value="1" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calcular Formulas antes de Exportar.</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td colspan="2"  >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="223" class="titulosInternos">Campos MySQL</td>
    <td width="224" class="titulosInternos">Titulos Columnas Excel</td>
    <td width="223" class="titulosInternos">Ingresar desde Excel</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<!-- BEGIN formulario -->
  <tr>
    <td>&nbsp;</td>
    <td><span >{formulario.nombreMySQL}:
        <!-- BEGIN propiedades -->
          <input name="{formulario.nombreMySQL}[{formulario.propiedades.indice}]" type="hidden" value="{formulario.propiedades.valor}" />
        <!-- END propiedades -->
        </span>     </td>
    <td width="224" >
<select name="{formulario.nombreMySQL}[0]" id="{formulario.nombreMySQL}" class="inputsText">
<option value="###NO###" >Elige / No Importar</option>
<!-- BEGIN select -->
<option value="{formulario.select.nroColumnaExcel}" {formulario.select.selected} >{formulario.select.nombreColumnaExcel}</option> 
<!-- END select -->
</select></td>
    <td><select name="{formulario.nombreMySQL}[1]" id="{formulario.nombreMySQL}_aux" class="inputsText" {formulario.desabilitado}>
		<!-- BEGIN selectOpciones -->
		<option value="{formulario.selectOpciones.valor}">{formulario.selectOpciones.texto}</option>
		<!-- END selectOpciones -->
    </select></td>
    <td>&nbsp;</td>
  </tr>
<!-- END formulario -->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
      <div class="aerobuttonmenu" style="float:right;"><samp class="aero"><span><button type="submit" name="sstm_Submit" id="sstm_Submit" class="boton"> Exportar &nbsp;</button></span></samp></div>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="sstm_archivo" type="hidden" id="sstm_archivo" value="{archivo}" />
      <input type="hidden" name="sstm_cantidad" id="sstm_cantidad" value="{cantidad}"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    
    </td>
    <td style="background-image:url(imagenes/ventanaAyudaLMD.png);" >&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/ventanaAyudaLII.png" width="21" height="19" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCI.png);">&nbsp;</td>
    <td><img src="imagenes/ventanaAyudaLID.png" width="21" height="19" alt="" /></td>
  </tr>
</table>
</form>
<br />