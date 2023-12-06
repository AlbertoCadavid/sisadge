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

    /* variables para saber si se repiten numeros en las columnas */
    let paqueteAnterior = 0;
    let refRepetida = 0;
    let cajaAnterior = (datos[0].caja)-1;
    let i = 0;
    /*  */

    let paquete, ref, desde, hasta, totalFalt, caja;

    datos.forEach(element => {

        
        if (cajaAnterior != element.caja) {
            
            caja = element.caja;
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td id="titulo4">N. O.P</td>
            <td id="titulo4">REF</td>
            <td id="titulo4">N. CAJA</td>
            <td id="titulo4">UND X CAJA</td>
            <td id="titulo4">N. PAQUETE</td>
            <td id="titulo4">DESDE</td>
            <td id="titulo4">HASTA</td>
            <td id="titulo4">UND X PAQ</td>
            <td id="titulo4">FALTANTES DESDE</td>
            <td id="titulo4">FALTANTES HASTA</td>
            <td id="titulo4">UND FALTANTES</td>
            <td id="titulo4">TOTAL FALTANTES PAQUETE</td>
            `;
            tabla.appendChild(tr);
            cajaAnterior = element.caja;
            paqueteAnterior = 0;
            
        }

       
        if (paqueteAnterior != element.paquete) {
            paquete = element.paquete;
            desde = element.desde;
            hasta = element.hasta;
            totalFalt = element.totalFaltantes;
            paqueteAnterior = element.paquete
        } else {
            paquete = '';
            desde = '';
            hasta = '';
            totalFalt = '';
            
        }
        

        if (refRepetida != element.ref) {
            ref = element.ref;
        } else {
            ref = element.ref;
            /* ref = ''; */
        }




        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td class="dato2 " style="text-align: center">${element.op}</td>
        <td class="dato2" style="text-align: center">${ref}</td>
        <td class="dato2" style="text-align: center">${element.caja}</td>
        <td class="dato2" style="text-align: center">${element.undCaja}</td>
        <td class="dato2 paquete${i}" style="text-align: center">${paquete}</td>
        <td class="dato2 desde${i}" style="text-align: center">${desde}</td>
        <td class="dato2 hasta${i}" style="text-align: center">${hasta}</td>
        <td class="dato2" style="text-align: center">${element.undPaquete}</td>
        <td class="dato2" style="color:red; text-align: center">${element.falDesde}</td>
        <td class="dato2" style="color:red; text-align: center">${element.falHasta}</td>
        <td class="dato2" style="color:red; text-align: center">${element.undFaltantes}</td>
        <td class="dato2 total${i}" style="color:red; text-align: center">${totalFalt}</td>
    `;

        tabla.appendChild(tr);
       
        refRepetida = element.ref;
        i += 1;

    });
    combinarCeldas('paquete');
    exportTableToExcel("tabla1", "despachofaltantes")
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

    function combinarCeldas(item, condicion) {
        let cont = 0;
        let indice = 0;
        let repet = 0;
        let num_actual = document.querySelector(`.${item}0`).innerHTML;
        let num_ant;
        let nrowSpan;


        for (let j = 0; j < datos.length; j++) {
            let valor_item = document.querySelector(`.${item}${j}`).innerHTML; //valor de cada fila de paquetes
            
            if (j == (datos.length - 1)) { //condicional para que coja el ultimo item y lo combine
                valor_item = 1;
            }

            if (valor_item != '') { //condicional para saber donde esta el numero
                num_ant = valor_item
                if (repet == 0) {
                    indice = j;
                    repet += 1;
                }
                num_actual=0;
            } else { //condicional para contar y eliminar los nodos que estan vacios
                repet = 0;
                cont += 1;
                num_ant = num_actual
                borraNodo(`.${item}${j}`)
                borraNodo(`.total${j}`)
                borraNodo(`.desde${j}`)
                borraNodo(`.hasta${j}`)
            }

            if (j == (datos.length - 1)) { // condicional para el ultimo item pueda ingresar al if (num_actual != num_ant)
                num_ant = 2;
                if (cont != 0) {
                    borraNodo(`.${item}${j}`)
                    borraNodo(`.total${j}`)
                    borraNodo(`.desde${j}`)
                    borraNodo(`.hasta${j}`)
                    nrowSpan = cont + 1 //condiccion para combinar el ultimo item de la lista
                }
            } else {
                nrowSpan = cont;
            }

            if (num_actual != num_ant) { //condicional para combinar las celdas del item anterior

                if (cont != 0) { //condicional para aplicar solo a los items que estan repetidos
                    document.querySelector(`.${item}${indice-(cont+1)}`).rowSpan = (nrowSpan + 1);
                    document.querySelector(`.total${indice-(cont+1)}`).rowSpan = (nrowSpan + 1);
                    document.querySelector(`.desde${indice-(cont+1)}`).rowSpan = (nrowSpan + 1);
                    document.querySelector(`.hasta${indice-(cont+1)}`).rowSpan = (nrowSpan + 1);
                    cont = 0
                    nrowSpan = 0
                }
            }


        }
    }


    function borraNodo(nombre) {
        //Buscar el nodo
        var nodo = document.querySelector(nombre);
        //borrar el nodo
        nodo.remove()
    }
</script>