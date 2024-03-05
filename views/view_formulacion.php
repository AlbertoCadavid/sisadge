<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php //require_once('Connections/conexion1.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$conexion = new ApptivaDB();
  

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISADGE AC &amp; CIA</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="AjaxControllers/js/elimina.js"></script>
<script type="text/javascript" src="AjaxControllers/js/updates.js"></script>

<!-- desde aqui para listados nuevos -->
<link rel="stylesheet" type="text/css" href="css/desplegable.css" />
<link rel="stylesheet" type="text/css" href="css/general.css"/>

<!-- sweetalert -->
<script src="librerias/sweetalert/dist/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
<!-- jquery -->
<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script> 
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- select2 -->
<link href="select2/css/select2.min.css" rel="stylesheet"/>
<script src="select2/js/select2.min.js"></script>

<!-- css Bootstrap-->
<link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 

</head>
<body>
<?php echo $conexion->header('listas'); ?>
 
  <table border="0" class="table table-bordered table-sm">
    
  <tr>
    <td id="dato2">
      <form method="post" name="form1" action="view_index.php?c=cformulacion&a=Guardar">
        <table>
          <tr>
            <td id="fuente2">CODIGO</td>
            <td id="fuente2">FORMULACION </td>
            <td id="fuente2">DELETE</td>
          </tr>
          <?php foreach($this->modelos as $modelos) { ?>
            <tr >
              <td id="detalle1"><a href="view_index.php?c=cformulacion&a=llenarEditar&id_for=<?php echo $modelos['id_for']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $modelos['nombre']; ?></a></td>
              <td id="detalle1"><a href="view_index.php?c=cformulacion&a=llenarEditar&id_for=<?php echo $modelos['id_for']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $modelos['formulacion']; ?></a></td>
              <td id="detalle2">
               
                <!-- <a class="botonDel" id="btnDelItems" onclick='eliminar("<?php echo $modelos['id_for']; ?>","id_for","0","view_index.php?c=cformulacion&a=Eliminar","0" )' type="button">DELETE</a> -->
               <a href='javascript:eliminar("<?php echo $modelos['id_for']; ?>","id_for","0","view_index.php?c=cformulacion&a=Eliminar","0" )'><img src="images/por.gif" alt="ELIMINAR" border="0" style="cursor:hand;"/></a> 
              </td>
            </tr>
            <?php } ?>
          <tr>
            <td id="dato2"><input name="nombre" type="text" id="nombre" value="" size="5" required /></td>
            <td colspan="2" id="dato2"><input name="formulacion" type="text" id="formulacion" value="" size="30" required/></td>
            </tr>
          <tr>
            <td colspan="3" id="dato2"><input type="submit" value="ADICIONAR FORMULACION"></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
    </td>
    
    <td id="dato2"> 
      <?php if($this->modelos_editar['id_for']!='') { ?>
      <form method="post" name="form2" action="view_index.php?c=cformulacion&a=Editar">
        <table align="center">
          <tr>
            <td id="fuente2">CODIGO</td>
            <td id="fuente2">EDITAR FORMULACION </td>
          </tr>
          <tr>
            <td id="fuente2"><input name="nombre" type="text" id="nombre" value="<?php echo $this->modelos_editar['nombre']; ?>" size="5" /></td>
            <td id="fuente2"><input name="formulacion" type="text" id="formulacion" value="<?php echo $this->modelos_editar['formulacion']; ?>" size="30"></td>
          </tr>
          <tr>
            <td colspan="2" id="dato2">
              <!-- <a href='javascript:UpdateGenerals("<?php echo $this->modelos_editar['id_for']; ?>","id_for","view_index.php?c=cformulacion&a=llenarEditar","MM_update" )'><img src="images/por.gif" alt="ELIMINAR" border="0" style="cursor:hand;"/></a>  -->

               <input name="submit" type="submit" value="ACTUALIZAR FORMULACION" /> <!-- onclick='javascript:UpdateGenerals("<?php echo $this->modelos_editar['id_for']; ?>","id_for","view_index.php?c=cformulacion&a=llenarEditar","")' -->
             </td> 
            </tr>
        </table>
        <input type="hidden" name="id_for" value="<?php echo $this->modelos_editar['id_for']; ?>">
        <input type="hidden" name="MM_update" value="form2">
      </form>
      <?php } ?>
    </td>

  </tr>
</table>
  </td>
</tr></table>
 
<?php echo $conexion->header('footer'); ?>
</body>
</html>
<script>
  
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
      if (e.keyCode == 13) {
        e.preventDefault();
      }
    }))
</script>
