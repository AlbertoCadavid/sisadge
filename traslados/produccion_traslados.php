<?php
require_once("../traslados/produccion_traslados_funciones.php");
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "usuario.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
  if($_POST["c_kilos"]=='0')
  {
	$cant_kilos=$_POST["localidad"]; 
 }else{
	$cant_kilos=$_POST["c_kilos"];
	$id_r = $_POST["municipio"];
	$sqlr="UPDATE TblExtruderRollo SET kilos_r='$cant_kilos' WHERE id_r='$id_r'";
	$resultr=mysql_query($sqlr);	
	 }
	 


}
?>
 
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<script src="../librerias/sweetalert/dist/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../librerias/sweetalert/dist/sweetalert.css">

<link href="../css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/formato.js"></script>
<script type="text/javascript" src="../js/consulta.js"></script> 
<script type="text/javascript" src="../traslados/consulta_trasladOp.js"> </script>
<script src="../traslados/jquery-1.10.2.min.js"></script>
 </head>

<body>
<div align="center">
<table align="center" id="tabla"><tr align="center"><td>
<div> 
<b class="spiffy"> 
<b class="spiffy1"><b></b></b>
<b class="spiffy2"><b></b></b>
<b class="spiffy3"></b>
<b class="spiffy4"></b>
<b class="spiffy5"></b></b>
<div class="spiffy_content">
<table id="tabla1"><tr>
<td colspan="2" align="center"><img src="../images/cabecera.jpg"></td></tr>
<tr><td id="nombreusuario"><?php echo $_SESSION['MM_Username']; ?></td>
  <td id="cabezamenu"><ul id="menuhorizontal">
  <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
<li><a href="../menu.php">MENU PRINCIPAL</a></li>
<!--<li><a  href="#" onClick="cerrar()">SALIR</a></li>-->
</ul></td>
</tr>  
  <tr>
    <td colspan="2">
 <form name="form1" method="post" enctype="multipart/form-data"><fieldset>
        <table id="tabla2">
          <tr>
            <td colspan="3" id="subtitulo1">TRASLADOS DE O.P
            A O.P</td>
            </tr>
          <tr>
            <td id="fuente1">&nbsp; </td>
            <td colspan="2" id="fuente3"><a href="../orden_compra_cl.php"><img src="../images/o.gif" alt="ORDENES DE COMPRA" title="ORDENES DE COMPRA" border="0" style="cursor:hand;"/></a><a href="../combos/combo1/menu.php"><img src="../images/identico.gif" style="cursor:hand;" alt="MENU PRINCIPAL" title="MENU PRINCIPAL" border="0"/></a></td>
            </tr>
          
          <tr>
            <td colspan="3" id="fuente1">&nbsp;</td>
            </tr>
         
          <tr id="tr2">
            <td colspan="4" id="dato2"><table id="tabla1">
              <tr>
                <td colspan="4" id="fuente1">O.P ORIGEN</td>
                <td id="fuente1"><span id="sprytextfield1"><span class="textfieldRequiredMsg">O.P DESTINO</span></span></td>
                </tr>
              
                <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
                  <td id="nivel"># O.P</td>
                  <td id="nivel">ROLLO</td>
                  <td id="nivel">KILOS</td>
                  <td id="nivel">CANTIDAD KILOS</td>
                  <td id="nivel">NUEVA O.P</td>
                  </tr>
                <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
                  <td id="fuente1"><select name="estado" id="estado" style="width: 80px"   onChange="getClientData(this.name,this.value);">
                    <option value="" >- O.P -</option>
                    <?php
		$estados = dameEstado();
		
		foreach($estados as $indice => $registro){
			echo "<option value=".$registro['id_op'].">".$registro['id_op']."</option>";
		}
		?>
                  </select></td>
                  <td id="fuente1"><select name="municipio" id="municipio" style="width: 80px">
                    <option value="">- Rollos -</option>
                  </select></td>
                  <td id="fuente1"><select name="localidad" id="localidad" style="width: 80px">
                    <option value="">- Kilos -</option>
                  </select></td>
                  <td id="fuente1"><input type="number" name="c_kilos" min="0.10" id="c_kilos" value="0" style="width:100px" onChange="trasladOp()"></td>
<td id="fuente1"><input type="text" name="op_destino" id="op_destino" style="width:100px" readonly value=""></td>                    
                  </tr>
                <tr >
                  <td colspan="5" id="fuente1"></td>
                </tr>
           

            </table></td>
            </tr>

          <tr>
            <td colspan="3" id="dato1">
            
            </td>
          </tr>
          <tr>
            <td colspan="3" id="dato1"></td>
          </tr>
          <tr>
            <td colspan="3" id="dato1">Nota: el campo cantidad kilos solamente se llena si va adescontar parte del rollo, sino se deja en cero '0'</td>
          </tr>
          <tr>
            <td colspan="3" id="dato2"> 
              <input type="button" name="ENVIAR" id="ENVIAR" value="TRASLADAR" onClick="reasignar();"/></td>
            </tr>
        </table>
   </fieldset>
</form>
 <input type="hidden" name="MM_update" value="form1">
       </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
</div>
<b class="spiffy"> 
<b class="spiffy5"></b>
<b class="spiffy4"></b>
<b class="spiffy3"></b>
<b class="spiffy2"><b></b></b>
<b class="spiffy1"><b></b></b></b></div> 
</td></tr></table>
</div>
 <script>
$("#estado").on("change", buscarMunicipios);
$("#municipio").on("change", buscarLocalidades); 

function buscarMunicipios(){
	$("#localidad").html("<option value='' style='width: 80px'>- Kilos -</option>");
    //$("#localidad").html("<input type='text' value=''>");
   //$("#localidad").html("<input type='text' list='misdatos' value=''>");
   
	$estado = $("#estado").val(); 
	
	if($estado == ""){
			$("#municipio").html("<option value='' style='width: 80px'>- Rollos -</option>");
	}
	else {
		$.ajax({
			dataType: "json",
			data: {"estado": $estado},
			url:   '../traslados/produccion_traslados_buscar.php',
			type:  'post',
			beforeSend: function(){
				//Lo que se hace antes de enviar el formulario
				},
			success: function(respuesta){
				//lo que se si el destino devuelve algo
				$("#municipio").html(respuesta.html);
			},
			error:	function(xhr,err){ 
				alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});
	}
}

function buscarLocalidades(){
	$municipio = $("#municipio").val();
	
	$.ajax({
		dataType: "json",
		data: {"municipio": $municipio},
		url:   '../traslados/produccion_traslados_buscar.php',
        type:  'post',
		beforeSend: function(){
			//Lo que se hace antes de enviar el formulario
			},
        success: function(respuesta){
			//lo que se si el destino devuelve algo
			$("#localidad").html(respuesta.html);
		},
		error:	function(xhr,err){ 
			alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});	
}

</script>

</body>
</html>