<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>

<?php
if (!isset($_SESSION)) {
  session_start();
}

$currentPage = $_SERVER["PHP_SELF"];

$conexion = new ApptivaDB();

$colname_usuario = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

$row_usuario = $conexion->buscar('usuario', 'usuario', $colname_usuario);

$colname_remision_id = "-1";
if (isset($_GET["id_remision"])) {
  $colname_remision_id = (get_magic_quotes_gpc()) ? $_GET["id_remision"] : addslashes($_GET["id_remision"]);
}

$row_existe = $conexion->buscar('tbl_remision_interna', 'id_remision', $colname_remision_id);

$row_ver_nuevo = $conexion->buscarId('tbl_remision_interna', 'id_remision');

$proveedores = $conexion->llenaSelect('proveedor', '', 'ORDER BY proveedor_p DESC');

$insumos = $conexion->llenaSelect('insumo', '', 'ORDER BY descripcion_insumo DESC');


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="css/general.css" />
  <link rel="stylesheet" type="text/css" href="css/formato.css" />
  <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
  <script type="text/javascript" src="js/usuario.js"></script>
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/insert.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/consultas.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/delete.js"></script>
  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- css Bootstrap-->
  <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body onKeyDown="javascript:Verificar()">
  <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
    <div align="center">
      <table id="tabla1">


        <tr>
          <td align="center">
            <div class="row-fluid">
              <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h2>DEVOLUCION-REPOSICION PRODUCTO TERMINADO</h2>
                  </div>
                  <div id="cabezamenu">
                    <ul id="menuhorizontal">
                      <li id="nombreusuario"><?php echo $_SESSION['Usuario']; ?></li>
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li>
                      <li><a href="insumos_interno_listado.php">LISTADO ENTRADAS</a></li>
                    </ul>
                  </div>
                  <div class="panel-body">
                    <br>
                    <div class="container">
                      <div class="row">
                        <div class="span12">
                          <table id="tabla2">
                            <tr>
                              <td rowspan="4" id="fondo2"><img src="images/logoacyc.jpg"></td>
                            </tr>
                            <tr>
                              <td id="subtitulo">
                                REMISION <?php echo strtoupper($row_existe['entrada']); ?>
                              </td>
                            </tr>
                            <tr>
                              <td align="center">
                                <h5 id="numero2" class="id_remision">
                                  <h2>N° <?php $num = $_GET["id_remision"] == '' ? $row_ver_nuevo['id'] + 1 : $_GET["id_remision"];
                                          echo $num; ?></h2>
                                </h5>
                                <hr>
                                ALBERTO CADAVID R & CIA S.A. - Nit: 890915756-6 <br>
                                Carrera 45 N°. 14 - 15 Tel: 604 311-21-44 - Medellin-Colombia
                                <p></p>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>


                      <form action="guardar.php" method="post" id="form1" name="form1">
                        <table id="tabla1">
                          <tr>
                            <td><input id="id_remision" name="id_remision" type="hidden" value="<?php echo $num; ?>">
                              <strong>CLIENTE:</strong>
                              <input type="text" required="required" id="cliente" name="cliente" value="<?php echo $row_existe['cliente']; ?>" class="form-control negro_inteso">
                            </td>
                            <td>
                              <strong>DEVOLUCION - REPOSICION&nbsp;&nbsp;</strong>
                              <select id="entrada" name="entrada" required="required" class="form-control negro_inteso">
                                <option value="" <?php if (!(strcmp("", $row_existe['entrada']))) {
                                                    echo "selected=\"selected\"";
                                                  } ?>>Seleccione</option>
                                <option value="Devolucion" <?php if (!(strcmp("Devolucion", $row_existe['entrada']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>Devolucion</option>
                                <option value="Reposicion" <?php if (!(strcmp("Reposicion", $row_existe['entrada']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>Reposicion</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <strong>NIT / C.C:</strong>&nbsp;&nbsp;<input type="text" readonly required="required" id="documento" name="documento" value="<?php echo $row_existe['documento']; ?>" class="form-control negro_inteso">
                            </td>
                            <td>
                              <strong>PAIS/CIUDAD:</strong>&nbsp;&nbsp;<input type="text" id="pais" name="pais" value="<?php echo $row_existe['pais']; ?>" class="form-control negro_inteso">
                            </td>
                          </tr>

                          <tr>
                            <td colspan="2">
                              <strong>CONTACTO: </strong>
                              <input type="text" required="required" placeholder="Contacto" id="contacto" name="contacto" value="<?php echo $row_existe['contacto']; ?>" class='form-control negro_inteso'>
                            </td>
                          </tr>

                          <tr>
                            <td>
                              <strong>TELEFONO: </strong>
                              <input type="text" placeholder="Telefono" id="telefono" name=" telefono" value="<?php echo $row_existe['telefono']; ?>" class='form-control negro_inteso'>
                            </td>
                            <td>
                              <strong>N°CELULAR: </strong>
                              <input type="text" required="required" placeholder="Celular" id="celular" name="celular" value="<?php echo $row_existe['celular']; ?>" class='form-control negro_inteso'>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              <strong>DIRECCION: </strong>
                              <input type="text" placeholder="Direccion" id="direccion" name="direccion" value="<?php echo $row_existe['direccion']; ?>" class='form-control negro_inteso'>
                            </td>
                            <td>
                              <strong>FECHA: </strong>
                              <input type="date" required="required" id="fecha" name="fecha" value="<?php echo $row_existe['fecha']; ?>" class='form-control negro_inteso' style="width:200">
                            </td>
                          </tr>


                          <tr>
                            <td colspan="2">
                              <hr>
                              <table border="1" style="width: 100%;" id="tablaf">
                                <tr align="center">
                                  <td style="width:180px"><strong>REFERENCIA</strong></td>
                                  <td style="width:80px"><strong>CANTIDAD</strong></td>
                                  <td style="width:90px"><strong>NUMERACION INICIAL</strong></td>
                                  <td style="width:90px"><strong>NUMERACION FINAL</strong></td>
                                  <td style="width:85px"><strong>CAJA</strong></td>
                                  <td style="width:85px"><strong>ORDEN COMPRA</strong></td>
                                </tr>

                                <tbody id="DataResult">
                                  <!-- datos traidos desde consultas.js con javascript -->
                                </tbody>
                                
                              </table>
                                    
                              <table id="tableData">
                                <tr align="center">
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                              
                              <table id="tblTotal">
                                
                              </table>
                          <tr>
                            <td></td>
                            <td style="text-align: right">
                              <span>Añadir campo</span>
                              <button type="button" class="botonGMini" onClick="AddItemd();addTotal()"> + </button>
                            </td>

                          </tr>
          </td>
        </tr>

        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>


        <tr>
          <td colspan="2">
            <strong>OBSERVACIONES:</strong>
            <textarea class="form-control" id="observacion" name="observacion" cols="50" rows="3"><?php echo $row_existe['observacion']; ?></textarea>
          </td>
        </tr>



        <tr>
          <td>
            <strong>ELABORADO POR: </strong>
            <input type="text" placeholder="Elabora" id="elabora" name="elabora" value="<?php echo $_SESSION['Usuario']; ?>" class='form-control' readonly>
          </td>
          <td>
            <strong>RECIBIDO POR: </strong>
            <input type="text" placeholder="Recibe" id="recibe" name="recibe" value="<?php echo $row_existe['recibe']; ?>" class='form-control'>
          </td>
        </tr>

        <tr>
          <td align="center" colspan="2">
            <strong>CORREO DEL VENDEDOR</strong>
            <br>
            <strong>Elija el correo del vendedor asignado a ese cliente</strong>
          </td>

          <table border="1" style="width: 100%;">

            <tr>
              <td>
                <?php $email1 = "dariov@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email1 ?></a>
              </td>
              <td align="center"> <strong>Dario Villarraga</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo" value="<?php echo $email1 ?>" <?php if ($row_existe['correo'] == $email1) { ?>checked="checked" <?php } ?>>
              </td>
            </tr>

            <tr>
              <td>
                <?php $email2 = "mauricio.ruiz@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email2 ?></a>
              </td>
              <td align="center"> <strong>Mauricio Ruiz</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo2" value="<?php echo $email2 ?>" <?php if ($row_existe['correo'] == $email2) { ?>checked="checked" <?php } ?>>
              </td>
            </tr>

            <tr>
              <td>
                <?php $email3 = "sara.molina@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email3 ?></a>
              </td>
              <td align="center"> <strong>Sara Molina/PW</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo" value="<?php echo $email3 ?>" <?php if ($row_existe['correo'] == $email3) { ?>checked="checked" <?php } ?>>
              </td>
            </tr>

            <tr>
              <td>
                <?php $email4 = "alvarocadavid@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email4 ?></a>
              </td>
              <td align="center"> <strong>Alvaro Cadavid</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo2" value="<?php echo $email4 ?>" <?php if ($row_existe['correo'] == $email4) { ?>checked="checked" <?php } ?>>
              </td>
            </tr>

            <tr>
              <td>
                <?php $email5 = "coordinacion@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email5 ?></a>
              </td>
              <td align="center"> <strong>Edilson Serna</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo2" value="<?php echo $email5 ?>">
              </td>
            </tr>
           
            <tr>
              <td>
                <?php $email5 = "juliot@acycia.com" ?>
                <a href="http://" target="_blank" rel="noopener noreferrer"><?php echo $email5 ?></a>
              </td>
              <td align="center"> <strong>Julio Tagliaferri</strong></td>
              <td align="center" id="fondo_3">
                <input type="radio" name="correo" id="correo2" value="<?php echo $email5 ?>">
              </td>
            </tr>
        </tr>

        <tr>
          <td colspan="2">

            <div class="panel-footer" id="continuar" align="center">
              
                <button id="btnEnviarG" name="btnEnviarG" type="button" class="botonGeneral">GUARDAR Y CONTINUAR</button>
              
            </div>
          </td>
        </tr>
        </td>
        </tr>
        <input type="hidden" name="MM_insert" value="form1">
        </form>
        

      </table>

      </table>
      <!-- tabla para paginacion opcional -->
      <table border="0" width="50%" align="center">
        <tr>
          <td width="23%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                      ?>
              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, 0, $queryString_registros); ?>">Primero</a>
            <?php } // Show if not first page 
            ?>
          </td>
          <td width="31%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                      ?>
              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, max(0, $pageNum_registros - 1), $queryString_registros); ?>">Anterior</a>
            <?php } // Show if not first page 
            ?>
          </td>
          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                      ?>
              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, min($totalPages_registros, $pageNum_registros + 1), $queryString_registros); ?>">Siguiente</a>
            <?php } // Show if not last page 
            ?>
          </td>
          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                      ?>
              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, $totalPages_registros, $queryString_registros); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page 
            ?>
          </td>
        </tr>
      </table>


    </div> <!-- contenedor -->

  </div>
  </div>
  </div>
  </div>
  </td>
  </tr>
  </table>
  </div>
  </div>

  <!-- js Bootstrap-->
  <!-- <script src="bootstrap-4/js/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="bootstrap-4/js/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap-4/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->


</body>

</html>

<script type="text/javascript">
  $(document).ready(function() {
    consultasItemsProdTerminado($("#id_remision").val()); //despliega los items
  });

  $("#btnEnviarG").on("click", function() {

    if ($("#cliente").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo cliente! :)", "error");
      return false;
    } else
    if ($("#entrada").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo Devolucion-Reposicion! :)", "error");
      return false;
    } else
    if ($("#documento").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo documento! :)", "error");
      return false;
    } else
    if ($("#contacto").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo contacto! :)", "error");
      return false;
    } else
    if ($("#fecha").val() == '') {
      swal.fire("Error", "Debe agregar un valor a la fecha! :)", "error");
      return false;
    } else
    if ($('input:radio[name=correo]:checked').val() == undefined) {
      swal.fire("Error", "Debe agregar un valor al campo Email! :)", "error");
      return false;
    } else
    if ($("#referencia").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo referencia! :)", "error");
      return false;
    } else if ($("#cantidad").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo cantidad! :)", "error");
      return false;
    } else if ($("#oc").val() == '') {
      swal.fire("Error", "Debe agregar un valor al campo orden de produccion! :)", "error");
      return false;
    } else {
      guardarConAlert($("#id_remision").val());
    }

  });

  function showAlert(msj) {
    if (msj === "guardado" ) {
      Swal.fire({
      position: "center",
      icon: "success",
      title: "Registro Guardado con Exito",
      showConfirmButton: false,
      timer: 1500
    });
    } else if(msj === "No guardado") {
      Swal.fire({
      position: "center",
      icon: "error",
      title: "Registro No se Guardado",
      showConfirmButton: false,
      timer: 1500
    });
    }
   
  }

  $('#cliente').change(function() {
    cliente = $("#cliente").val();
    let resp = consultaCliente('comprobarCliente', cliente)
  })

  //------------------FUNCION PARA AGREGAR ITEMS DINAMICOS----//
  var num = 0;
  var contador = 1

  function AddItemd() {
    var contador = num++;
    var tbody = null;
    var tablaf = document.getElementById("tableData");
    var nodes = tablaf.childNodes;
    var count = 0;
    var acumula = 0;

    var falt = document.getElementsByClassName("focusNext");
    var numDivs = falt.length;
    var contadorNaranja = 0;
    for (var i = 0; i < numDivs; i++) {
      if (falt[i].className == "focusNext")
        contadorNaranja++;
      var acumula = contadorNaranja == 'NaN' ? 0 : contadorNaranja;
    }

    for (var x = 0; x < nodes.length; x++) {
      if (nodes[x].nodeName == 'TBODY') {
        tbody = nodes[x];
        break;
      }
      count = acumula + x;
    }
    if (tbody != null) {
      contador = contador + 1;
      var tr = document.createElement('tr');
      tr.innerHTML = `<tr ><td colspan="12" id="dato1"> <input type="hidden" name="remision_id" id="remision_id" value="<?php echo $num; ?>" style="width:70px"><input type="text" required="required" placeholder="Referencia" id="referencia" name="referencia[]" value="" style="width:180px"><input oninput= actualizarTotal() class="cantidad" type="number" required="required" placeholder="Cantidad" id="cantidad" name="cantidad[]" value="" style="width:80px"><input type="text" placeholder="Inicio" id="numInicio" name="numInicio[]" value="" style="width:90px"><input type="text" placeholder="Final" id="numFinal" name="numFinal[]" value="" style="width:90px"><input type="text" required="required" placeholder="# Caja" id="caja" name="caja[]" value="" style="width:85px"><input type="text" required="required" placeholder="OC" id="oc" name="oc[]" value="" style="width:85px"> </td></tr>`;
      tbody.appendChild(tr);
      contador = contador + 1;
    }

  }

  //funcion para añadir el campo total
function addTotal(){
  let table = document.querySelector("#tblTotal");
  
  if(table.childNodes[1] === undefined){
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <tr>
      <td style="width:180px"></td>
      <td colspan="1">Total: <strong id="totales"></strong> </td>
      <td id="dato3">
        <input type="hidden" name="formItems" value="formItems">
      </td>
    </tr>
  `;
  table.appendChild(tr);
  }
}

  //fin

  //funcion para sumar total de las cantidades

  function actualizarTotal() {
    var cantidades = document.getElementsByClassName("cantidad");

    var total = 0;
    for (var i = 0; i < cantidades.length; i++) {
      var valorCampo = parseFloat(cantidades[i].value) || 0; // Convertir a número o usar 0 si no es válido
      total += valorCampo;
    }

    // Actualizar el contenido del campo "total"
    document.getElementById('totales').innerText = total;
  }
</script>
<?php
mysql_free_result($usuario);
mysql_free_result($ver_nuevo);
mysql_free_result($proveedores);
mysql_free_result($insumos);

?>