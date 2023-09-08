<link rel="stylesheet" type="text/css" href="estilos/{claseBase}" />
<form id="opfg_form_cambiar_base_tabla" action="index.php?mdl=abmTablas&amp;ctr=Formulario&amp;acc=formGenerico" method="post">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="bordeTablas">
  <tr>
    <td><table width="700px" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="270">
          <select name="opfg_elegir_base" id="opfg_elegir_base" class="inputsText">
          <option value="">Seleccionar Base de Datos ...</option>
          </select>         </td>
        <td width="270">
          <select name="opfg_elegir_tabla" id="opfg_elegir_tabla" class="inputsText">
          <option value="">Seleccionar Tabla de Datos ...</option>
          </select>         </td>
        <td width="140">
        <div align="center">
        <button id="opfg_cambiar_base_tabla" class="btnBN" title="Generar Nuevo Formulario"><img src="imagenes/application_form.png" alt="" /><samp class="textoBTN"> Generar Form.</samp></button>
        </div>         </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="bordeTablas">
  <tr>
    <td><table width="700" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><button id="opfg_primero" class="btnBN" title="Primer Registro [Inicio]"><img  src="imagenes/control_start_blue.png" alt=""  /><samp class="textoBTN">&nbsp;Primero</samp></button></td>
        <td><button id="opfg_anterior" class="btnBN" title="Registro Anterior [<-]"><img  src="imagenes/control_rewind_blue.png" alt=""  /><samp class="textoBTN">&nbsp;Anterior</samp></button></td>
        <td><span style="margin:0px;">
        <form id="opForm" style="margin:0px;" action="#" method="post" name="opForm">
          <select class="inputTextForm" name="opfg_operador" id="opfg_operador" style="padding-top:2px; width:150px">
           <option value="AND" selected="selected">Todos Coinciden</option>
            <option value="OR">Alguna Coincidencia</option>
          </select>
          </form>
        </span></td>
        <td><button id="opfg_buscar" class="btnBN" title="Buscar Registro [F4]"><img  src="imagenes/magnifier.png" alt="" /><samp class="textoBTN">&nbsp;Buscar</samp></button></td>
        <td><button id="opfg_siguiente" class="btnBN" title="Proximo Registro [->]"><img  src="imagenes/control_fastforward_blue.png" alt="" /><samp class="textoBTN">&nbsp;Siguiente</samp></button></td>
        <td><button id="opfg_ultimo" class="btnBN" title="Ultimo Registro [Fin]"><img  src="imagenes/control_end_blue.png" alt="" /><samp class="textoBTN">&nbsp;Ultimo</samp></button></td>
      </tr>
    </table></td>
  </tr>
</table>
<center>
  <a name="consultaFormGenerico" id="consultaFormGenerico"></a>
  <div align="center" id="consultas" class="bordeTablas" style="width:700px"></div>
  </center>
  <a name="topFormulario" id="topFormulario"></a>
<form action="{action}" method="post" enctype="{codificacion}" name="formGenerico" id="formGenerico" style="margin:0px">
  <table id="tablaFormularioGenerico" width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="bordeTablaPrincipal">
    <tr>
      <td width="5">&nbsp;</td>
      <td colspan="4" class="{claseForm}"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td>{titulo} </td>
          </tr>
        </table></td>
      <td width="5">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4" style="height:26px;"><div id="pizarra"></div></td>
      <td>&nbsp;</td>
    </tr>
<!-- BEGIN campos -->    
    <tr>
      <td width="5">&nbsp;</td>
      <td width="175" class="{campos.class}"><div title="{campos.collation}" >&nbsp;{campos.etiqueta}</div></td>
      <td width="20">&nbsp;{campos.romper}</td>
      <td width="210" style="padding:2px">{campos.elementos}</td>
      <td width="30">{campos.btn}</td>
      <td width="5">&nbsp;</td>
    </tr>
<!-- END campos -->    
    <tr>
      <td width="5" valign="top">&nbsp;</td>
      <td height="15px" colspan="4"></td>
      <td width="5" valign="top">&nbsp;</td>
    </tr>
  </table>
</form>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="bordeTablas">
<tr>
<td >

     <table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
            <td style="padding-top:3px;"><div align="center">
          <button id="opfg_reset" class="btnBNaccion" title="Limpiar Campos [Esc]"><img src="imagenes/application_form_delete.png" alt="" /><samp class="textoBTN"> Vaciar Form.</samp></button>
         </div></td>
          <td style="padding-top:3px;"><div align="center">
            <button id="opfg_cancelar" class="btnBNaccion" title="Eliminar Registro [F10]"><img src="imagenes/cancel.png" alt="" /><samp class="textoBTN"> Eliminar Registro</samp></button>
          </div></td>
          <td style="padding-top:3px;"><div align="center">
            <button id="opfg_editar" class="btnBNaccion" title="Editar Registro [F2]"><img src="imagenes/page_edit.png" alt="" /><samp class="textoBTN"> Editar Registro</samp></button>
          </div></td>
          <td style="padding-top:3px;"><div align="center">
            <button id="opfg_insertar" class="btnBNaccion" title="Insertar Registro [Enter]"><img src="imagenes/add.png" alt="" /><samp class="textoBTN"> Insertar Registro</samp></button>
          </div></td>
        </tr>
      </table>
    </td>
  </tr>
  </table>
<form id="camposOcultos" method="post" action="">
<input name='opfg_indiceMySQL' 		id='opfg_indiceMySQL' 		type='hidden'  			value='{indiceMySQL}' />
<input name='opfg_base' 			id='opfg_base' 				type='hidden'  			value='{base}' />
<input name='opfg_tabla' 			id='opfg_tabla' 			type='hidden'  			value='{tabla}' />
<input name='opfg_insertIndice' 	id='opfg_insertIndice'		type='hidden'  			value='{insertIndice}' />
<input name='opfg_valorAyudas' 		id='opfg_valorAyudas' 		type='hidden'  			value='{valorAyudas}' />
<input name='opfg_controladorBase' 	id='opfg_controladorBase'	type='hidden'  			value='{controlador}' />
<input name='opfg_iubase' 			id='opfg_iubase'			type='hidden'  			value='{iubase}' />
</form>
{calendarioGenerico}
<script language="javascript">
campo_opfg_elegir_base		= '{base_seleccionada}'; 
campo_opfg_elegir_tabla		= '{tabla_seleccionada}';
</script>