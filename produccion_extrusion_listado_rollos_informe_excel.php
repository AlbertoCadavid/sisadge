<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>


<html>

<head>
  <link href="css/formato.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="js/listado.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/envioListado.js"></script>

  <title>SISADGE AC &amp; CIA</title>

</head>

<body id="body">
  <table id="tabla1">
    <tr>
      <td colspan="2" id="dato3"></td>
    </tr>

    <!-- inserto los demas elementos con javascript -->

  </table>

</body>

</html>


<script type="text/javascript">
  let rollos = document.querySelector(".rollos");
  let metros = document.querySelector(".metros");
  let kilos = document.querySelector(".kilos");
  let undxestiba = <?php echo $_GET['undxestiba'] ?>;
  let cantRollos = <?php echo $_GET['rollos'] ?>;
  let sumKilos = 0,
    sumMetros = 0;

  var datosJSON = localStorage.getItem('dataObjetoJSON'); // Recuperar la cadena JSON desde localStorage
  var datos = JSON.parse(datosJSON); // Convertir la cadena JSON en un objeto JSON
  //console.log(datos);

  const tabla = document.getElementById('tabla1');
  if (undxestiba > cantRollos) {
    undxestiba = cantRollos;
  }
  let cant = undxestiba
  let inicio = 0;
  let fin = undxestiba;
  let num = 0;




  datos.forEach(element => {


    if (cant == undxestiba) {
      for (let i = inicio; i < fin; i++) {
        console.log(typeof(datos[i]));
        if (datos[i] !== undefined) {
          sumKilos = sumKilos + parseFloat(datos[i].kilos);
          sumMetros = sumMetros + parseInt(datos[i].metros);
          num = num + 1;
        } else {
          break
        }
      }

      const tr1 = document.createElement('tr');
      tr1.innerHTML = `
        <td id="subtitulo"><strong> LISTADO DE ROLLOS </strong></td>
      `;
      tabla.appendChild(tr1)

      const tr2 = document.createElement('tr');
      tr2.innerHTML = `
            <td>&nbsp;</td>
      `;
      tabla.appendChild(tr2)

      const tr3 = document.createElement('tr');
      tr3.innerHTML = `
      <tr>
            <td id="subtitulo1" style="text-align: right">ORDEN DE PRODUCCION:</td>
            <td id="fuente2" ><?php echo $_GET['id_op_r'] ?></td>
          </tr>
          <tr>
            <td id="subtitulo1" style="text-align: right">CANTIDAD DE ROLLOS:</td>
            <td id="fuente2" class="rollos" style="text-align: left"> ${num}</td>
          </tr>
      `;
      tabla.appendChild(tr3)

      const tr0 = document.createElement('tr');
      tr0.id = "tb";
      tr0.innerHTML = `
          
          <tr>
            <td id="subtitulo1" style="text-align: right">METROS TOTALES:</td>
            <td id="fuente2" class="metros">${sumMetros}</td>
          </tr>
          <tr>
            <td id="subtitulo1" style="text-align: right">KILOS TOTALES:</td>
            <td id="fuente2" class="kilos">${sumKilos.toFixed(2)}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>


`;
      tabla.appendChild(tr0);

      const tr = document.createElement('tr');

      tr.innerHTML = `
            <td nowrap="nowrap" id="titulo4" style="text-align: right">ROLLO N</td>
            <td nowrap="nowrap" id="titulo4" style="text-align: center" >KILOS</td>
            <td nowrap="nowrap" id="titulo4" style="text-align: center">METRO</td>
            <td nowrap="nowrap" id="titulo4" style="text-align: center">OPERARIO</td>
          
`;
      tabla.appendChild(tr)

      sumKilos = 0;
      sumMetros = 0;
      cant = 0;
      inicio = inicio + undxestiba;
      fin = fin + undxestiba;
      num = 0;
    }


    const tr2 = document.createElement('tr');
    tr2.innerHTML = `
            <td id="dato2" style="text-align: right">${element.rollo}</td>
            <td id="dato2" style="text-align: center">${element.kilos}</td>
            <td id="dato2" style="text-align: center">${element.metros}</td>
            <td id="dato2" style="text-align: center">${element.operario}</td>
  `;
    tabla.appendChild(tr2);

    cant = cant + 1;

  });





  exportTableToExcel("tabla1", "Listado de rollos");
  //window.close();
  var form = "id_op_r=<?php echo $_GET['id_op_r']; ?>";
  var vista = 'produccion_extrusion_listado_rollos_informe.php';
  enviovarListados(form, vista);

  function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById("tabla1");
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
      var blob = new Blob(['ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
    }
  }
</script>