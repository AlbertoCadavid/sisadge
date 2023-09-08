<br />
<form name="phpini" id="phpini" method="post" action="index.php?mdl=deame3p&amp;ctr=Exportar&amp;acc=phpini" enctype="multipart/form-data">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"><img src="imagenes/ventanaAyudaLSI.png" width="21" height="35" alt="" /></td>
    <td style="background-image:url(imagenes/ventanaAyudaCS.png)" ><strong>Variables de configuracion de php.ini</strong></td>
    <td width="10"><img src="imagenes/ventanaAyudaLSD.png" width="21" height="35" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/ventanaAyudaLMI.png);">&nbsp;</td>
    <td style="background-image:url(imagenes/ventanaAyudaFondo.png);">
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="5" class="bordeTablaRedondeado">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" ><div align="center">{mensajeconfiguracion}</div></td>
        <td>&nbsp;</td>
      </tr>
      <!-- BEGIN conexion -->
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class='titulosInternos'>Tiempo Maximo de Ejecucion</td>
        <td>&nbsp;</td>
        <td class='titulosInternos'>Limite Maximo de Memoria</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td ><label for="tiempoLimiteScript"></label>
          <select name="tiempoLimiteScript" class="inputsText" id="tiempoLimiteScript">
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
          </select>          </td>
        <td>&nbsp;</td>
        <td >
          <select name="limiteMemoria" class="inputsText" id="limiteMemoria">
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
          </select>          </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="titulosInternos" >Configurar Errores a Mostrar</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" ><table border="0" style="width:100%;">
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><div style="text-align:center" >Seleccionar: <span style="font-weight: bold">
              <label id="todos" style="cursor:pointer;">Todos los Errores</label>
            </span> - <span style="font-weight: bold">
            <label id="invertir" style="cursor:pointer;">Invertir Seleccion</label>
            </span> - <span style="font-weight: bold">
            <label id="ninguno" style="cursor:pointer;">Ningun Error</label>
            </span></div></td>
            </tr>
          <tr>
            <td><label>
              <input type="checkbox" name="E_ERROR[1]" id="E_ERROR[1]" value="{e1}" {chequed_1} />
            </label></td>
            <td>E_ERROR({e1})</td>
            <td><label>
              <input name="E_ERROR[2]" type="checkbox" id="E_ERROR[2]" value="{e2}" {chequed_2} />
            </label></td>
            <td>E_WARNING({e2})</td>
            <td><label>
              <input name="E_ERROR[3]" type="checkbox" id="E_ERROR[3]" value="{e3}" {chequed_3} />
            </label></td>
            <td>E_PARSE({e3})</td>
          </tr>
          <tr>
            <td><label>
              <input name="E_ERROR[4]" type="checkbox" id="E_ERROR[4]" value="{e4}" {chequed_4} />
            </label></td>
            <td>E_NOTICE({e4})</td>
            <td><label>
              <input name="E_ERROR[5]" type="checkbox" id="E_ERROR[5]" value="{e5}"  {chequed_5} />
            </label></td>
            <td>E_CORE_ERROR({e5})</td>
            <td><label>
              <input name="E_ERROR[6]" type="checkbox" id="E_ERROR[6]" value="{e6}" {chequed_6} />
            </label></td>
            <td>E_CORE_WARNING({e6})</td>
          </tr>
          <tr>
            <td><label>
              <input name="E_ERROR[7]" type="checkbox" id="E_ERROR[7]" value="{e7}" {chequed_7} />
            </label></td>
            <td>E_COMPILE_ERROR({e7})</td>
            <td><label>
              <input name="E_ERROR[8]" type="checkbox" id="E_ERROR[8]" value="{e8}" {chequed_8} />
            </label></td>
            <td>E_COMPILE_WARNING({e8})</td>
            <td><label>
              <input name="E_ERROR[9]" type="checkbox" id="E_ERROR[9]" value="{e9}" {chequed_9} />
            </label></td>
            <td>E_USER_ERROR({e9})</td>
          </tr>
          <tr>
            <td><label>
              <input name="E_ERROR[10]" type="checkbox" id="E_ERROR[10]" value="{e10}" {chequed_10} />
            </label></td>
            <td>E_USER_WARNING({e10})</td>
            <td><label>
              <input name="E_ERROR[11]" type="checkbox" id="E_ERROR[11]" value="{e11}" {chequed_11} />
            </label></td>
            <td>E_USER_NOTICE({e11})</td>
            <td><label>
              <input name="E_ERROR[12]" type="checkbox" id="E_ERROR[12]" value="{e12}" {chequed_12} />
            </label></td>
            <td>E_STRICT({e12})</td>
          </tr>
          <tr>
            <td><label>
              <input name="E_ERROR[13]" type="checkbox" id="E_ERROR[13]" value="{e13}" {chequed_13} />
            </label></td>
            <td>E_RECOVERABLE_ERROR({e13})</td>
            <td><label>
              <input name="E_ERROR[14]" type="checkbox" id="E_ERROR[14]" value="{e14}" {chequed_14} />
            </label></td>
            <td>E_DEPRECATED({e14})</td>
            <td><label>
              <input name="E_ERROR[15]" type="checkbox" id="E_ERROR[15]" value="{e15}" {chequed_15} />
            </label></td>
            <td>E_USER_DEPRECATED({e15})</td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" ><strong><em>Nota: </em></strong>es conveniente, tener todos los errores deshabilitados. En caso de fallo de alguna rutina activarlos para ver que error se puede estar generando.</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td ><div class="aerobuttonmenu"><samp class="aero"><span><button  name="procesar" id="procesar" class="boton">Configurar</button></span></samp></div></td>
        <td>&nbsp;</td>
      </tr>
      <!-- END conexion -->
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td ><input name="phpiniConfig" type="hidden" id="phpiniConfig" value="1" /></td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class='titulosInternos'>Configuracion por Defecto del sistema</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="10">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="233" >1.Tiempo Maximo de Ejecucion:</td>
    <td width="10">&nbsp;</td>
    <td width="234" ><div align="center">{tiempo} segundos.</div></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >2.Memoria Asignada:</td>
    <td>&nbsp;</td>
    <td ><div align="center">{memoria} Megas.</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >3.Envio Maximo por Formulario:</td>
    <td>&nbsp;</td>
    <td ><div align="center">{formulario} Megas.</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >4.Envio Maximo por Archivo:</td>
    <td>&nbsp;</td>
    <td ><div align="center">{archivo} Megas.</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" ><div align="justify">
      <p>(1) Es el tiempo que tiene cada script que pertenece a la rutina para ejecutarse. Si una parte de la rutina excede ese tiempo se produce un error fatal. Tome en cuenta este dato para configurar su servidor de acuerdo a los datos a transferir.<br />
        (2) Memoria asignada al script, si la sobrepasa en algun momento se produce un error y se corta la ejecucion.<br />
        (3) La sumatoria del tama&ntilde;o de los archivos a subir a traves de un formulario no pueden sobrepasar dicho valor.<br />
        (4) Maximo valor permitido para un solo archivo. Es un doble tope por formulario y por archivo.</p>
      <p>Errores: si entre parentesis se encuentra N/D, significa que para esa version de php no se encuentra disponible.</p>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
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