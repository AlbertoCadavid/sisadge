<?php
session_start();
define('DIR_SITIO' 		, dirname(__FILE__) . '/');	// Directorio Base del Sistema siempre va en el index...
define('DIR_BASE'		, basename(dirname(__FILE__)));
include 'opet/config/config.ini';
include (DIR_OPET . DIR_CONTR . 'FrenteControl.php');

$erroresAMostrar	= isset($_SESSION['mostrarErrores']) ? $_SESSION['mostrarErrores'] : 0;
error_reporting($erroresAMostrar);
date_default_timezone_set(TIME_ZONE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DEAME3P - Exportar e Importar desde Excel a MySQL. Version <?php echo DM3P_VRSN;?></title>
<link rel="stylesheet" type="text/css" href="estilos/deame3p_vista.css"   />
<link rel="stylesheet" type="text/css" href="estilos/menu_estilo_1.css" />
<link rel="shortcut icon" type="image/png" href="imagenes/flechita.png" />
<script type="text/javascript" language="javascript" src="opet/javascript/stuHover.js"></script>
<script type="text/javascript" language="javascript" src="opet/javascript/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="opet/javascript/sistemaOpet.js"></script>
</head>
<body>
<div id='iniciarSistema'></div>
<br />
<table border="0" align="center" cellpadding="0" cellspacing="0" class="tablaVista">
  <tr>
    <td style="width:16px;"><img src="imagenes/superiorIzquierda.png" alt=""/></td>
    <td style="background-image:url(imagenes/superiorCentral.png); width:954px;"><div align="center"><img src="imagenes/logoDeame3pM.png" alt="Logo DEAME3P" /></div></td>
    <td style="width:16px;"><img src="imagenes/superiorDerecha.png" alt=""/></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/medioIzquierda.png); vertical-align:top;"><img src="imagenes/medioIzquierda.png" width="16" height="100" alt="" /></td>
    <td class="lateralCentral">
    	<!-- Menu Desplegable -->
    	<?php
			include 'opet/menu/menu_5.0.7.html';
   		?>
    	<!-- Fin Menu Desplegable -->
   		<div id='subMenu'>Servidor: <?php echo $_SESSION['OP_SERVIDOR'];?>   |  Usuario: <?php echo $_SESSION['OP_USUARIO'];?> | Puerto: <?php echo $_SESSION['OP_PUERTO'];?></div>
        <div id="contenido">
		<?php
			$cont2 	= new FrenteControl();
			$cont2	->main("");
		?>	
	</div>        </td>
    <td style="background-image:url(imagenes/medioDerecha.png); vertical-align:top;"><img src="imagenes/medioDerecha.png" alt="" /></td>
  </tr>
  <tr>
    <td style="background-image:url(imagenes/medioIzquierda.png); vertical-align:top;">&nbsp;</td>
    <td style="background-image:url(imagenes/barraEstado.gif)" class="pie">
	<?php
		echo DM3P_ATR . ' | ' . DM3P_CRR . ' | ' . DM3P_PIE;
	?>
    </td>
    <td style="background-image:url(imagenes/medioDerecha.png); vertical-align:top;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><img src="imagenes/inferiorDerecha.png" alt="" /></td>
    <td style="background-image:url(imagenes/inferiorCentral.png); background-repeat:repeat-x;">&nbsp;</td>
    <td valign="top"><img src="imagenes/inferiorIzquierda.png" alt="" /></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
$('#iniciarSistema').hide(500);
</script>
</body>
</html>