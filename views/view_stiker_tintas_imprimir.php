<?php
$pictgramas_tinta = ['pictograma_riesgotoxico.png', 'pictograma_riesgocancerigeno.png', 'pictograma_riesgoinflamable.png', 'pictograma_riesgomedioambiente.png', 'pictograma_riesgocorrosivo.png'];
$pictgramas_alcohol = ['pictograma_riesgoinflamable.png', 'pictograma_riesgomedioambiente.png', 'pictograma_riesgopeligro.png'];
$data_serialize = $_GET['info'];
$data = unserialize(urldecode($data_serialize));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="self.print();">
    <div>
        <div id="seleccion" class="containerEtiqueta" style="display: flex;" onClick="cerrar('seleccion');return false">
            <div id="contenedorizq" class="border">
                <div class="bordeInferior">
                    <p class="titulo">Nombre de la sustancia química:</p>
                    <p><?php echo $data['sustancia'] ?></p>
                </div>
                <div class="bordeInferior">
                    <p class="titulo">Identificacion del peligro:</p>
                    <p>Líquido y vapores muy inflamables.<br>Provoca irritación ocular grave.<br>Puede provocar somnolencia o vértigo.</p>
                </div>
                <p class="titulo">Pictogramas</p>
                <div id="imagenes" class="bordeInferior">
                    <?php if ($data['sustancia'] === 'TINTA') {
                        foreach ($pictgramas_tinta as $value) {
                            echo '<img src="../images/' . $value . '" alt="' . $value . '">';
                        }
                    } else if ($data['sustancia'] === 'ALCOHOL') {
                        foreach ($pictgramas_alcohol as $value) {
                            echo '<img src="../images/' . $value . '" alt="' . $value . '">';
                        } ?>
                    <?php } ?>
                </div>
                <p class="titulo">Identificador del proveedor:</p>
                <p> <?php echo $data['proveedor'] ?></p>
            </div>
            <div id="contenedorder" class="border">
                <div class="bordeInferior">
                    <p class="titulo">Consejos de prudencia:</p>
                    <p class="sizeLetersConsejos">
                        Usar guantes de protección.
                        Usar protección para los ojos o la cara.
                        Mantener alejado del calor, chispas, llamas al descubierto,
                        superficies calientes y otras fuentes de ignición.
                        No fumar.
                        Todos los equipos eléctricos, de ventilación, de iluminación
                        y para la manipulación de materiales deben ser
                        antideflagrantes.
                        No utilizar herramientas que produzcan chispas.
                        Tomar medidas de precaución contra las descargas
                        electrostáticas.
                        Mantener el recipiente herméticamente cerrado.
                        Utilizar sólo al aire libre o en un lugar bien ventilado.
                        Evitar respirar vapor.
                    </p>
                </div>
                <p class="titulo">OBSERVACIÓN:</p>
                <p> <?php echo $data['observaciones'] ?></p>
            </div>
        </div>
    </div>
    <div style="margin-top:50px">
        <div id="seleccion" class="containerEtiqueta " style="display: flex;" onClick="cerrar('seleccion');return false">
            <div id="contenedor2izq" class="letraGrande">
                <div class="">
                    <p>COLOR:</p>
                </div>
                <div class="">
                    <p>PANTONE:</p>
                </div>
                <div class="">
                    <p>PESOFINAL:</p>
                </div>
                <div class="">
                    <p>RETORNO:</p>
                </div>
                <div class="">
                    <p>ORIGINAL:</p>
                </div>
            </div>
            <div id="contenedor2der" class="letraGrande">
                <div id="sizecolor">
                    <p id="contenerTexto"><?php echo $data['color']  ?></p>
                </div>
                <div>
                    <p><?php echo $data['panton'] ?></p>
                </div>
                <div class="">
                    <p><?php echo $data['pesofinal'] ?></p>
                </div>
                <div class="space">
                    <p><?php echo $data['retorno'] == "" ? " " : $data['retorno']?></p>
                </div>
                <div class="">
                    <p><?php echo $data['original'] == "" ? " " : $data['original']?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    .space {
        width: 232px;
        height: 66px;
    }
    .containerEtiqueta {
        text-align: justify;
        justify-content: center;
        width: 490px;
        height: 350px;
        background-color: white;
        font-family: Arial, sans-serif;
        /* margin: 50px auto; */
        font-size: 13px;
    }

    #contenedorder {
        width: 50%;
        padding: 5px;
    }

    #contenedorizq {
        width: 50%;
        padding: 5px;
    }

    #contenedor2der {
        width: 50%;
        /* padding: 15px; */
    }

    #contenedor2izq {
        width: 50%;
        padding-left: 15px;
    }

    .border {
        border: 1px solid black;
    }


    #imagenes {
        width: fit-content;
        height: auto;
        text-align: center;
    }

    img {
        width: 70px;
        height: 70px;
    }

    .bordeInferior {
        border-bottom: 1px solid black;
    }

    .titulo {
        font-weight: 700;
        margin: 0px;
    }

    .letraGrande p {
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-weight: 800;
        font-size: 43px;
    }

    .sizeLetersConsejos {
        font-size: 13px;
    }

    #seleccion p {
        margin: 3px;
    }

    #sizecolor {
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;

    }

    #contenerTexto {
        width: 100%;
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
    }
</style>

<script>
    function cerrar(num) {
        window.close();
    }

    window.addEventListener('DOMContentLoaded', (event) => {
        ajustarTamanoTexto();
    });

    function ajustarTamanoTexto() {
        const contenedor = document.querySelector('#sizecolor');
        const texto = document.querySelector('#contenerTexto');
        const contenedorAncho = contenedor.offsetWidth;
        const textoAncho = texto.scrollWidth;

        if (textoAncho > contenedorAncho) {
            const nuevoTamano = contenedorAncho / textoAncho * parseFloat(window.getComputedStyle(texto).fontSize);
            texto.style.fontSize = nuevoTamano + 'px';
        }
    }
</script>