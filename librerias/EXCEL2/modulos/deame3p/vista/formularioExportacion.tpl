<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<br />
<div align="center" class="boldtext1 Estilo11">{php_zip}</div>
<form id="deExcelAMysql" name="deExcelAMysql" method="post" action="index.php?mdl=deame3p&amp;ctr=Exportar&amp;acc=relaciones" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong><span class="titulosInternosRedondeados">DEAME3P - V.({version}) - Formulario de Opciones de Exportaci&oacute;n</span>.-</strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);"><table width="700" border="0" align="center" cellpadding="0" cellspacing="5" class="bordeTablaRedondeado">
      <tr style="height:18px;">
        <td width="10">&nbsp;</td>
        <td width="128">&nbsp;</td>
        <td width="10">&nbsp;</td>
        <td colspan="5"><div id='progreso'>
            <div align="center"><img src="imagenes/ajax-loader.gif" width="43" height="11" alt="Consultando ..." /><span id='msjProgreso' class="boldtext1"> ... Trabajando ...</span> <img src="imagenes/ajax-loader.gif" width="43" height="11" alt="Consultando ..."/></div>
        </div></td>
        <td width="10">&nbsp;</td>
        <td width="128">&nbsp;</td>
        <td width="10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td >Exportar a:</td>
        <td>&nbsp;</td>
        <td colspan="3"><select name="baseDeDatos" class="inputsText" id="baseDeDatos">
            <option>Base de Datos ...</option>
          </select>        </td>
        <td width="10">&nbsp;</td>
        <td colspan="3"><select name="tabla" class="inputsText" id="tabla">
            <option>Tabla de Datos ...</option>
          </select>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td >Excel 2007:</td>
        <td>&nbsp;</td>
        <td colspan="3"><input type="file" name="archivo" id="archivo" class="inputsText" size="25" /></td>
        <td>&nbsp;</td>
        <td colspan="3"><select name="planServ" class="inputsText" id="planServ" style="width:85%;">
            <option>Seleccione Archivo ...</option>
          </select>
          
          <input type="button" name="previa" id="previa" value="&nbsp;&nbsp;" title="Previa del Archivo Excel del Servidor." style="background-image:url(imagenes/page_excel.png); border-style:solid; border-width:1px; border-color:#999999; background-repeat:no-repeat; background-position:center; vertical-align:middle;" />          </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td >Patron de Export.:</td>
        <td>&nbsp;</td>
        <td colspan="7">
          <table border="0" style="width:100%;">
           <tr>
             <td width="95%"><input type="text" name="patronExportacion" id="patronExportacion" class="inputsText" placeholder="Patron de Exportacion 1-100,120,130-*" /></td>
             <td width="5%"><img src="imagenes/ayuda.gif" width="16" height="16" alt="Ayuda sobre Patrones Permitidos" title="Desplegar Ayuda sobre Patrones de Exportaci&oacute;n." style="cursor:pointer;" id="ayudaPatrones" />&nbsp;</td>
           </tr>
         </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td >Modo:</td>
        <td>&nbsp;</td>
        <td colspan="3"><select name="funcionesDeame3p" class="inputsText" id="funcionesDeame3p">
            <option value="1" selected="selected">INSERT</option>
            <option value="4">SI CLAVE REPETIDA UPDATE</option>
          </select>        </td>
        <td>&nbsp;</td>
        <td colspan="3"><select name="funciones" class="inputsText" id="funciones">
            <option>Seleccione Funcion ...</option>
          </select>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td >Especiales:</td>
        <td>&nbsp;</td>
        <td colspan="7"><table width="100%" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td style="width:33%;"><select name="codificacion" class="inputsText" id="codificacion">
                  <option value="" selected="selected">Sin Codificacion</option>
                  <option value="UTF8">Codificar a UTF8</option>
                </select>              </td>
              <td style="width:33%;"><select name="tiempoLimiteScript" class="inputsText" id="tiempoLimiteScript">
            <option value="30">Limite Script por defecto 30 seg.</option>
            <option value="60">1 minuto</option>
            <option value="300">5 minutos</option>
            <option value="600">10 minutos</option>
            <option value="1200">20 minutos</option>
			<option value="1800">30 minutos</option>
			<option value="2400">40 minutos</option>
			<option value="3000">50 minutos</option>
			<option value="3600">60 minutos</option>
            <option value="0">Ilimitado</option>
                </select>              </td>
              <td style="width:33%;"><select name="limiteMemoria" class="inputsText" id="limiteMemoria">
                  <option value="">Memoria por Defecto</option>
                  <option value="12">Memoria 8M</option>
                  <option value="16">Memoria 16M</option>
                  <option value="32">Memoria 32M</option>
                  <option value="64">Memoria 64M</option>
                  <option value="128">Memoria 128M</option>
                  <option value="256">Memoria 256M</option>
                  <option value="512">Memoria 512M</option>
                  <option value="1024">Memoria 1024M</option>
                  <option value="2048">Memoria 2048M</option>
                </select>              </td>
            </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td rowspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="7" ><fieldset class="legend">
          <legend>Modos de Visualizacion</legend>
          <input type="radio" name="modoDeame3p" id="radio" value="1" />
          Correctos |
          <input name="modoDeame3p" type="radio" id="radio2" value="2" checked="checked" />
          Incorrectos |
          <input type="radio" name="modoDeame3p" id="radio3" value="3" />
          Todos |
          <input type="radio" name="modoDeame3p" id="radio4" value="4" />
          TextArea
        </fieldset></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><div align="left" >
            <input name="borrarArchivo" type="checkbox" id="borrarArchivo" value='1' />
          Borrar Archivo al Terminar</div></td>
        <td>&nbsp;</td>
        <td><div class="aerobuttonmenu"><samp class="aero"><span>
        <button  name="procesar" id="procesar" class="boton"> Vincular &nbsp;</button>
        </span></samp></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="128">&nbsp;</td>
        <td width="10">&nbsp;</td>
        <td width="128">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="128">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
<div id="ayudaSobrePatrones" style="display:none; position:absolute; width: 527px; background-color:#FFFFFF;">
<table bordercolor="#000000" style="border-width:1px; border-style:solid;">
  <tr>
    <td width="5">&nbsp;</td>
    <td width="507" bgcolor="#245F86" valign="middle" height="20px;"><div align="center" class="Estilo1">Ayuda sobre Patrones de Exportaci&oacute;n.</div></td>
    <td width="10"><img src="imagenes/button-close-grey.png" width="15" height="9" alt="Cerrar Ayuda" title="Cerrar Ayuda." id="cerrarAyuda" style="cursor:pointer;" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <div style="height: 155px; overflow:auto;">
    <div align="justify">
      <p>Los patrones de exportaci&oacute;n permiten exportar rangos de filas a la base de datos.<br />
        La notaci&oacute;n b&aacute;sica es <strong>n-m</strong> donde <strong>n</strong> es la fila inicial y <strong>m</strong> la final. Tambi&eacute;n se puede enviar mas de un rango en el mismo patr&oacute;n, para ello debemos escribir <strong>n-m,x-y</strong> o sea los intervalos se separan por una coma.<br />
        El &uacute;nico car&aacute;cter especial permitido es <strong>*</strong> (asterisco) e indica hasta el final o sea si usamos <strong>9-*</strong>, le indicamos que exporte de la fila 9 hasta el final y que en la fila 9 se encuentran los t&iacute;tulos de la planilla.</p>
      <p>Siempre la fila con el menor numero sera tomada como la fila de T&iacute;tulos. En caso de no incluirse ning&uacute;n patr&oacute;n actuara en modo est&aacute;ndar o sea t&iacute;tulos en la primera fila e intenta la exportaci&oacute;n de toda la planilla.</p>
      <p>No es necesario ingresar los intervalos en orden aunque si es aconsejable.</p>
    </div>
      </div>
      </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</form>