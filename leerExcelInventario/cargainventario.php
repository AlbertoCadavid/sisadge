<?php
    include ('C:/xampp/htdocs/config.php');//$_SERVER['DOCUMENT_ROOT'] 
   include_once('C:/xampp/htdocs/acycia/Controller/controller.php');//ROOT_BBDD /Controller/controller.php 
 //'C:/xampp/htdocs/acycia/Controller/controller.php'
?>
<?php

//__DIR__//C:\xampp\htdocs\acycia_dev\leerExcelInventario //directorio donde esta el archivo
//ROOT_PATH//C:/xampp/htdocs/acycia_dev/
//CONTROLLER_PATH//C:/xampp/htdocs/acycia_dev/controller/
 
 //require_once('conexion1.php');
 $conexion = new ApptivaDB();  
/**
 * Demostrar lectura de hoja de cálculo o archivo
 * de Excel con PHPSpreadSheet: leer todo el contenido
 * de un archivo de Excel
 *
 */
# Cargar librerias y cosas necesarias
require_once  "C:/xampp/htdocs/acycia/leerExcelInventario/vendor/autoload.php";//ROOT
 
# Indicar que usaremos el IOFactory
use PhpOffice\PhpSpreadsheet\IOFactory;

# Recomiendo poner la ruta absoluta si no está junto al script
# Nota: no necesariamente tiene que tener la extensión XLSX
$rutaArchivo = "C:/xampp/htdocs/acycia/INVENTARIODIARIO/INVENTARIO.xlsx";//ROOT
$documento = IOFactory::load($rutaArchivo);
# Recuerda que un documento puede tener múltiples hojas
# obtener conteo e iterar
$totalDeHojas = $documento->getSheetCount();

//Actualizo los estados de todas las facturas existentes en cartera A cero
logs("SE ACTUALIZAN APARTIR DE LA FECHA: " );

 actualizoInventario();//todos a cero
 
# Iterar hoja por hoja 
 
for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
    # Obtener hoja en el índice que vaya del ciclo
    $hojaActual = $documento->getSheet($indiceHoja);
    //echo "<h3>Vamos en la hoja con índice $indiceHoja</h3>";


    $ultimaHoja = $indiceHoja+1;//variable que controla que se imprima la ultima hoja
    # Iterar filas
if($ultimaHoja == $totalDeHojas){

    echo '<br>ULTIMA HOJA #. '. ($ultimaHoja).'<br><br>'; 
    foreach ($hojaActual->getRowIterator() as $fila) {
        foreach ($fila->getCellIterator() as $celda) {
            // Aquí podemos obtener varias cosas interesantes
            #https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Cell/Cell.html

            # El valor, así como está en el documento
            $valorRaw = $celda->getValue();

            # Formateado por ejemplo como dinero o con decimales
            $valorFormateado = $celda->getFormattedValue();

            # Si es una fórmula y necesitamos su valor, llamamos a:
            $valorCalculado = $celda->getCalculatedValue();

            # Fila, que comienza en 1, luego 2 y así...
            $fila = $celda->getRow();
            # Columna, que es la A, B, C y así...
            $columna = $celda->getColumn();
            
   
              
              if($columna && $fila > 3 && $columna  < 'L' )//APARTIR DE CUAL FILA $fila > 2  Y HASTA CUAL COLUMNA $columna  < 'L'
               {
                     //A PARTIR DE AQUI LO HAGO PARA PODER IMPRIMIR POR REGISTRO
                     if($columna == 'B' ){
                          $columnaB = $valorRaw . ' ';//LA REFERENCIA  
                     }
                     if($columna == 'F' ){
                          $columnaF = $valorRaw . ' ';//VALOR INICIAL INVENTARIO
                     }
                     if($columna == 'I' ){
                          $columnaI = $valorRaw . ' ';//VALOR TOTAL DESPACHO
                     }
                     if($columna == 'K' ){
                          $columnaK = $valorRaw . '<BR>';//VALOR DISPONIBLE
                     }
                     
                     if($columnaB!='')//PARA IMPRIMIR COLUMNA LLENA 
                     {
                        $fechas = date('Y-m-d');

                        $existe=$conexion->llenarCampos("tbl_inventario","WHERE referencia='".$columnaB."'","","referencia");  
                            $existeRef = $existe['referencia'];//SI EXISTE LA REF EN BASE DE DATOS 

                        if($existeRef){
                         $actualizo = $conexion->actualizar("tbl_inventario", " inventario='".$columnaF."', fecha='".$fechas."', despacho='".$columnaI."',disponible='".$columnaK."', activo = '1' ", " referencia= '".$columnaB."' " );
                            logs("Se Actualiza REF #: ".$columnaB); 
                        }else{
                          
                         $insert = $conexion->insertar("tbl_inventario", " referencia, inventario,fecha,despacho,disponible, activo ", " '".$columnaB."','".$columnaF."','".$fechas."','".$columnaI."','".$columnaK."', '1' " );
                            logs("Se Inserto REF #: ".$columnaB); 
                        }
                          



                     }

                   
               }
 
        } 
    }
}
}
 
 exit();

function actualizoInventario(){

    $conexion = new ApptivaDB(); 
    
    $fechaActual = date('Y-m-d');
    $fechaini = restaDia($fechaActual,'2');
     $actualizo = $conexion->actualizar("tbl_inventario", " activo='0' ", " fecha >= '$fechaini' AND fecha <= '$fechaActual' " );
    logs("Actualiza a 0 Estado Inventario Despues de fecha 2023-06-01 " );

}

function logs($msg)
  {
    echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
  }


function restaDia($fecha,$dias=''){
 $dias=$dias=='' ? 1 : $dias;
  $fecha = date('Y-m-d');$nuevafecha = strtotime ( '-'.$dias.'day' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );  
return $nuevafecha; 
}
