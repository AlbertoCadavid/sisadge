<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
require_once('AjaxControllers/Actions/funcioness.php');
?>
<?php require_once('Connections/conexion1.php'); ?>



<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>SISADGE AC &amp; CIA</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link href="css/formato.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/listado.js"></script>
    <script type="text/javascript" src="js/consulta.js"></script>
    <script type="text/javascript" src="js/validacion_numerico.js"></script>
    <script type="text/javascript" src="js/formato.js"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/general.css" />

</head>

<body>

    <table id="tabla1">
        <tr>
            <td colspan="2" id="dato3"></td>
        </tr>

        <!-- inserto los demas elementos con javascript -->

    </table>
</body>

</html>


<script type="text/javascript">
    var datosJSON = localStorage.getItem('miObjetoJSON'); // Recuperar la cadena JSON desde localStorage
    var datos = JSON.parse(datosJSON); // Convertir la cadena JSON en un objeto JSON
    
    const tabla = document.getElementById('tabla1');
    const tr = document.createElement('tr');
    tr.innerHTML = `
            <td id="titulo4">N. O.P</td>
            <td id="titulo4">REF</td>
            <td id="titulo4">N. CAJA</td>
            <td id="titulo4">N. PAQUETE</td>
            <td id="titulo4">NUMERACION</td>
            <td id="titulo4">CONTADOR</td>
            `;
    tabla.appendChild(tr);

    let array_numeracion = []; //array para guardar la informacion sin numeros repetidos
    let numeros_faltantes = []; //array para guardar los consecutivos de los numeros faltantes
    datos.forEach(element => {
       /* creo un array con todos los numeros faltantes */
        for (let faltantes = parseInt(element.falDesde); faltantes <= parseInt(element.falHasta); faltantes++) {
            numeros_faltantes.push(faltantes);
        }

        for (let numeracion = parseInt(element.desde); numeracion <= parseInt(element.hasta); numeracion++) {

            if (!array_numeracion.some(obj => obj.numero === numeracion)) { // Verificar si el elemento no está en el array
                array_numeracion.push({
                    op: element.op,
                    ref: element.ref,
                    caja: element.caja,
                    paquete: element.paquete,
                    numero: numeracion,
                }) // Agregar el elemento al array
            }
        }
    });
    
    let cont = 1
    array_numeracion.forEach(item => {
        
        let color = ""
        let value = ""
            const tr = document.createElement('tr');
            let existe = numeros_faltantes.indexOf(item.numero);
            if (existe != -1) {
                color = "red"
                value = ""
            } else {
                value = cont++
            }
            tr.innerHTML = `
        <td class="dato2 " style="text-align: center">${item.op}</td>
        <td class="dato2" style="text-align: center">${item.ref}</td>
        <td class="dato2" style="text-align: center">${item.caja}</td>        
        <td class="dato2" style="text-align: center">${item.paquete}</td>

        <td class="dato2" style="text-align: center; color:${color}">${item.numero}</td>
        
        <td class="dato2" style="color:blue; text-align: center">${value}</td>
    `;
            tabla.appendChild(tr);
    });

    exportTableToExcel("tabla1", "despachoFaltantesEspecial")
    window.close();

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