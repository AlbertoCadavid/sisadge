<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>Registro de empleados</title>
  <script language="JavaScript" type="text/javascript" src="ajax.js"></script>
<style type="text/css">
	body{
		background-repeat:no-repeat;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		height:100%;
		background-color: #FFF;
		margin:0px;
		padding:0px;
		background-image:url('/images/heading3.gif');
		background-repeat:no-repeat;
		padding-top:85px;
	}
	
	fieldset{
		width:500px;
		margin-left:10px;
	}

	</style>
	</script>
    <script type="text/javascript" src="ajax.js"> </script>
	<script type="text/javascript">
	
	/************************************************************************************************************
	
	************************************************************************************************************/	
	var ajax = new sack();
	var currentClientID=false;
	function getClientData()
	{
		var clientId = document.getElementById('clientID').value.replace(/[^0-9]/g,'');
		if(clientId.length==4 && clientId!=currentClientID){
			currentClientID = clientId
			ajax.requestFile = 'getClient.php?getClientId='+clientId;	// Specifying which file to get
			ajax.onCompletion = showClientData;	// Specify function that will be executed after file has been found
			ajax.runAJAX();		// Execute AJAX function			
		}
		
	}
	
	function showClientData()
	{
		var formObj = document.forms['clientForm'];	
		eval(ajax.response);
	}
	
	
	function initFormEvents()
	{
		document.getElementById('clientID').onblur = getClientData;
		document.getElementById('clientID').focus();
	}
	
	
	window.onload = initFormEvents;
	</script>  
  </head>
<body><div id="resultado2">
	<form name="nuevo_empleado" action="" onsubmit="enviarDatosEmpleado(); return false">
			<h2>Nuevo Usuario</h2>
	  <table>
                <tr>
                	<td>Nombres</td><td><label><input name="nombre" type="text" value="<?php echo $row_consulta['nombre']; ?>"/></label></td>
               	</tr>
                <tr>
					<td>Apellido</td><td><label><input type="text" name="apellido" value="<?php echo $row_consulta['apellido']; ?>"></label></td>
				</tr>
                <tr>
                    <td>Web</td><td><label><input name="web" type="text"  value="<?php echo $row_consulta['web']; ?>" /></label></td>
				</tr>
                <tr>
                   	<td>&nbsp;</td><td><label><input type="submit" name="Submit" value="Grabar" /></label></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                   	<td><!--<a href="javascript:inputs('1','id_op','<?php echo $delrp="campo"; ?>')">consultar<img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a>-->
                             </td>
                    </tr>
                </table>
  </form>
 </div>
		<div id="resultado"><?php include('consulta.php');?></div>
        
 <form name="clientForm" action="ajax-client_lookup.html" method="post">	
		<legend>Client information</legend>
		<table>
			<tr>
				<td><label for="clientID">Client ID:</label></td>
				<td><input name="clientID" id="clientID" size="5" maxlength="4"></td>
			</tr>
			<tr>
				<td><label for="firstname">First name:</label></td>
				<td><input name="firstname" id="firstname" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="lastname">Last name:</label></td>
				<td><input name="lastname" id="lastname" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="address">Address:</label></td>
				<td><input name="address" id="address" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="zipCode">Zipcode:</label></td>
				<td><input name="zipCode" id="zipCode" size="4" maxlength="5"></td>
			</tr>
			<tr>
				<td><label for="city">City:</label></td>
				<td><input name="city" id="city" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="country">Country:</label></td>
				<td><input name="country" id="country" size="20" maxlength="255"></td>
			</tr>
		</table>	
</form>
<p>In this script, AJAX is used to autofill the form fields after a valid client ID is entered. Valid client IDs in this example are 1001,1002,1003 and 1004.</p>
  </body>
</html>