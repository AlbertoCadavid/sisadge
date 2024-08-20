<?php require_once('Connections/conexion1.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php

$conexion = new ApptivaDB();
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
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
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "usuario.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
    $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: " . $MM_restrictGoTo);
  exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";
  die;
}

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_conexion1, $conexion1);
$query_tipos = "SELECT * FROM tipo ORDER BY nombre_tipo ASC";
$tipos = mysql_query($query_tipos, $conexion1) or die(mysql_error());
$row_tipos = mysql_fetch_assoc($tipos);
$totalRows_tipos = mysql_num_rows($tipos);

mysql_select_db($database_conexion1, $conexion1);
$query_clases = "SELECT * FROM clase ORDER BY nombre_clase ASC";
$clases = mysql_query($query_clases, $conexion1) or die(mysql_error());
$row_clases = mysql_fetch_assoc($clases);
$totalRows_clases = mysql_num_rows($clases);

mysql_select_db($database_conexion1, $conexion1);
$query_indices = "SELECT * FROM indices ORDER BY nombre ASC";
$indices = mysql_query($query_indices, $conexion1) or die(mysql_error());
$row_indices = mysql_fetch_assoc($indices);
$totalRows_indices = mysql_num_rows($indices);





?><html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

  <link href="css/formato.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/general.css" />
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="js/validacion_numerico.js"></script>
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script> 
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
  <div align="center">
    <table align="center" id="tabla">
      <tr align="center">
        <td>
          <div>
            <b class="spiffy">
              <b class="spiffy1"><b></b></b>
              <b class="spiffy2"><b></b></b>
              <b class="spiffy3"></b>
              <b class="spiffy4"></b>
              <b class="spiffy5"></b></b>
            <div class="spiffy_content">
              <table id="tabla1">
                <tr>
                  <td colspan="2" align="center"><img src="images/cabecera.jpg"></td>
                </tr>
                <tr>
                  <td id="nombreusuario"><?php echo $row_usuario['nombre_usuario']; ?></td>
                  <td id="cabezamenu">
                    <ul id="menuhorizontal">
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li>
                      <li><a href="compras.php">GESTION COMPRAS</a></li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="center" id="linea1">
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onSubmit="MM_validateForm('id_p','','R');return document.MM_returnValue">
                      <table id="tabla2">
                        <tr>
                          <td colspan="2" align="center" id="titulo">LISTADO DE INDICES</td>
                        </tr>
                        <tr>
                          <td align="center" colspan="2">
                            <table class="table table-bordered table-sm">
                              <tr id="tr1">
                                <td id="titulo4" style="width: 70px;">
                                  <span onclick="addIndice()"><img src="images/mas.gif" border="0" style="cursor:hand;" alt="AGREGAR ITEM" title="AGREGAR NUEVO INDICE"></span> N&ordm;
                                </td>
                                <td id="titulo4" style="width: 90px;">INDICE</td>
                                <td id="titulo4" style="width: 90px;">EDITAR</td>
                              </tr>
                              <?php do { ?>
                                <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF" bordercolor="#ACCFE8">
                                  <td id="dato2"><?php echo $row_indices['id_i']; ?></a></td>
                                  <td id="dato2"><?php echo $row_indices['nombre']; ?></a></td>
                                  <td id="dato2" onclick="editarIndice('<?php echo $row_indices['id_i']; ?>','<?php echo $row_indices['nombre']; ?>')"><img src="images/menos.gif" style="cursor:hand;" alt="EDITAR INDICE" title="EDITAR INDICE" border="0"></a></td>
                                </tr>
                              <?php } while ($row_indices = mysql_fetch_assoc($indices)); ?>
                             
                              <tr>
                                <td id="dato3">&nbsp;</td>
                              </tr>
                             
                            </table>
                      <table id="tabla2">
                        <tr>
                          <td colspan="2" align="center" id="titulo">LISTADO DE RELACIONES</td>
                        </tr>
                        <tr>
                          <td align="center" colspan="2">
                            <table class="table table-bordered table-sm">
                              <tr id="tr1">
                                <td id="titulo4" style="width: 190px;">CLASE DE INSUMO</td>
                                <td id="titulo4" style="width: 90px;">INDICES</td>
                                <td id="titulo4" style="width: 90px;">EDITAR</td>
                              </tr>
                              <?php do { ?>
                                <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF" bordercolor="#ACCFE8">
                                  <td id="dato1"><?php echo $row_clases['nombre_clase']; ?></a></td>
                                  <td id="dato2" onclick="consultaIndice('<?php echo $row_clases['id_clase']; ?>','<?php echo $row_clases['nombre_clase']; ?>')"><img src="images/mas.gif" style="cursor:hand;" alt="AGREGAR ITEM" title="AGREGAR INDICE A <?php echo $row_clases['nombre_clase']; ?>" border="0"> 
                                      <?php 
                                      $row_relaciones = $conexion->llenaSelect("insumos_clases_indices as ci", "INNER JOIN clase as c ON ci.id_clase = c.id_clase INNER JOIN indices as i ON ci.id_indice = i.id_i WHERE ci.id_clase = $row_clases[id_clase]", "ORDER BY i.nombre ASC");
                                      
                                      foreach ($row_relaciones as $value) { ?>
                                        
                                    <tr>
                                    <td id="dato2"></td>
                                    <td id="dato2"><?php echo  $value['nombre']; ?></td>
                                    <td id="dato2" onclick="msjEliminar('<?php echo $row_clases['id_clase']; ?>','<?php echo $value['id_indice']; ?>')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR INDICE" title="ELIMINAR INDICE <?php echo $value['nombre']?>" border="0"></td>
                                    
                                    </tr>
                                      <?php }  ?>
                                  </td>
                                </tr>
                              <?php } while ($row_clases = mysql_fetch_assoc($clases)); ?>
                             
                              <tr>
                                <td id="dato3">&nbsp;</td>
                              </tr>
                             
                            </table>
                    </form>
                  </td>
                </tr>
              </table>
            </div>
            <b class="spiffy">
              <b class="spiffy5"></b>
              <b class="spiffy4"></b>
              <b class="spiffy3"></b>
              <b class="spiffy2"><b></b></b>
              <b class="spiffy1"><b></b></b></b>
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>

<script>
  function addIndice() {
    Swal.fire({
      title: "Ingrese el nuevo Indice",
      input: "text",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Guardar",
      showLoaderOnConfirm: true,
      preConfirm: (res) => {
        txt = res.trim().toUpperCase(),

          $.ajax({
            type: "POST",
            url: "AjaxControllers/Actions/guardar.php",
            data: {
              add_indice: true,
              nombre: txt,
            },
            success: function(data) {
              console.log(data)
              if (data == 1) {
                Swal.fire({
                  title: "Guardado!",
                  text: "Indice Guardado con Exito",
                  icon: "success"
                }).then((result) => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  title: "NO Guardado!",
                  text: "Upps hubo un error, No se guardo",
                  icon: "error"
                }).then((result) => {
                  location.reload();
                });
              }

            },
            error: function(data) {
              console.log(data)
            }
          });
      },


    });
  }

  function editarIndice(id, nombre) {
    Swal.fire({
      title: "Ingrese el nuevo Indice",
      input: "text",
      inputValue: nombre,
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Guardar",
      showLoaderOnConfirm: true,
      preConfirm: (res) => {
        txt = res.trim().toUpperCase(),

          $.ajax({
            type: "POST",
            url: "AjaxControllers/Actions/update.php",
            data: {
              update_indice: true,
              nombre: txt,
              id: id
            },
            success: function(data) {
              if (data == 1) {
                Swal.fire({
                  title: "Actualizado!",
                  text: "Indice Actualizado con Exito",
                  icon: "success"
                }).then((result) => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  title: "NO Actualizado!",
                  text: "Upps hubo un error, No se guardo",
                  icon: "error"
                }).then((result) => {
                  location.reload();
                });
              }

            },
            error: function(data) {
              console.log(data)
            }
          });
      },


    });
  }

   /* Consulta el listado de indices */
   function consultaIndice(id_clase, nombreClase) {
    
  $.ajax({
    data: {
      traerIndices: true,
    },
    url: "AjaxControllers/Actions/consultas.php",
    type: "POST",
    success: function (data) {
      if(data != 0) {
      object = JSON.parse(data);
      let indice = {};
      object.forEach((element) => {
        indice[element.nombre] = element.nombre;
      });
      Swal.fire({
        title: "Indices",
        input: "select",
        inputOptions: {
          Indices: {
            ...indice,
          },
        },
        inputPlaceholder: "Selecciona un Indice",
        showCancelButton: true,
        inputValidator: (value) => {
          return new Promise((resolve) => {
            if (value) {
              resolve();
            } else {
              resolve("Debes seleccionar un Indice");
            }
          });
        },
      }).then((result) => {
        if (result.isConfirmed) {
          let indice = result.value;
          let idSeleccionado;

          object.forEach((value) => {
            if (value.nombre == indice) {
              id_indice = value.id_i;
            }
          });
            Swal.fire({
              title: "Agregar",
              text: `Esta seguro de agregar el indice ${indice} al insumo ${nombreClase}`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Si, Guardalo!"
            }).then((result) => {
              if (result.isConfirmed) {
                guardarRelacionClaseIndice(id_clase, id_indice)
              }
            });
          
          
        }
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Indice no existe, Escribelo de nuevo",
      });
    }
    },
    error: function (xhr, status, error) {
      console.log(error);
      swal("Indice no existe", JSON.parse(data));
    },
  });
}

/* Agrega una relacion */
function guardarRelacionClaseIndice(id_clase, id_indice){
      
      $.ajax({ 
         type: "POST",
         url: "AjaxControllers/Actions/guardar.php",
         data: {
          add_relacion_clase_indice: true,
          id_clase : id_clase, 
          id_indice : id_indice,
        },
         success: function(data){   

           if(data == 1) {
            Swal.fire({
                  title: "Actualizado!",
                  text: "Indice Actualizado",
                  icon: "success"
                }).then((result) => {
                      location.reload();
                   });
            } else {
              Swal.fire({
                  title: "NO Actualizado!",
                  text: "Upps hubo un error, No se actualizo",
                  icon: "error"
                }).then((result) => {
                      location.reload();
                   }); 
            } 
           
          },
          error: function(data){
            console.log(data)  
          }
        }); 

     }

/* ELIMINAR UNA RELACION */
function msjEliminar(id_clase, id_indice){
  console.log(id_indice)
  Swal.fire({
  title: "ELIMINAR?",
  text: "Esta seguro que Quiere Eliminar!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Si, eliminar!",
  cancelButtonText: "No eliminar!"
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
    eliminarRelacion(id_clase, id_indice)
  }
});  
  }

function eliminarRelacion(id_clase, id_indice){
  $.ajax({ 
         type: "POST",
         url: "AjaxControllers/Actions/delete.php",
         data: {
          eliminar_relacion_clase_indice: true,
          id_clase : id_clase, 
          id_indice : id_indice,
        },
         success: function(data){   
console.log(data)
           if(data == 1) {
            Swal.fire({
                  title: "Eliminado!",
                  text: "Indice Eliminado",
                  icon: "success"
                }).then((result) => {
                      location.reload();
                   });
            } else {
              Swal.fire({
                  title: "NO Eliminado!",
                  text: "Upps hubo un error, No se Elimino",
                  icon: "error"
                }).then((result) => {
                      location.reload();
                   }); 
            } 
           
          },
          error: function(data){
            console.log(data)  
          }
        });
}
</script>

<?php
mysql_free_result($usuario);

mysql_free_result($tipos);

mysql_free_result($clases);

mysql_free_result($medidas);
?>