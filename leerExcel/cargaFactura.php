<?php
   
   require ('C:/xampp/htdocs/config.php');// $_SERVER['DOCUMENT_ROOT'].'/config.php'
   include_once('C:/xampp/htdocs/acycia/Controller/controller.php');//ROOT_BBDD /Controller/controller.php 
?> 
<?php
 
 //require_once('conexion1.php');
 $conexion = new ApptivaDB();  
/**
 * Demostrar lectura de hoja de cálculo o archivo
 * de Excel con PHPSpreadSheet: leer todo el contenido
 * de un archivo de Excel
 * 
 */
# Cargar librerias y cosas necesarias
require_once "C:/xampp/htdocs/acycia/leerExcel/vendor/autoload.php";//ROOT

# Indicar que usaremos el IOFactory
use PhpOffice\PhpSpreadsheet\IOFactory;

# Recomiendo poner la ruta absoluta si no está junto al script
# Nota: no necesariamente tiene que tener la extensión XLSX
$rutaArchivo = "C:/xampp/htdocs/acycia/CARTERAEXCEL/CARTERA.xlsx";//ROOT
$documento = IOFactory::load($rutaArchivo);

# Recuerda que un documento puede tener múltiples hojas
# obtener conteo e iterar
$totalDeHojas = $documento->getSheetCount();

//Actualizo los estados de todas las facturas existentes en cartera A cero
logs("SE ACTUALIZAN APARTIR DE LA FECHA: 2024-01-01 ". '<br>');
actualizoEstadoCartera();//todos a cero
 
# Iterar hoja por hoja
for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
    # Obtener hoja en el índice que vaya del ciclo
    $hojaActual = $documento->getSheet($indiceHoja);
    //echo "<h3>Vamos en la hoja con índice $indiceHoja</h3>";

    # Iterar filas
    foreach ($hojaActual->getRowIterator() as $fila) {
        foreach ($fila->getCellIterator() as $celda) {
            // Aquí podemos obtener varias cosas interesantes 

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
            
            

        if($columna && $fila && $fila > 3 && $columna=='Q' ){
               
                $columnaQ = $valorRaw;//$columna=='Q' ES EL COLUMNA DOCUMENTO DEL ARCHIVO DE EXCEL ES NUMERO DE FACTURA
                
        }

        //SI TIENE MAS DE UNA FACTURA
        if($columna && $fila && $fila > 3 && $columna=='B' ){
               
                $columnaB = $valorRaw;//$columna=='B' ES LA COLUMNA DEL ID DOCUMENTO DEL CLIENTE
                
        }
       
            //SON LAS COLUMNAS CON VENCIMIENTOS EN DIAS
            if($columna && $fila >2 && ($columna=='AC' || $columna=='AD'  || $columna=='AE' || $columna=='AF' || $columna=='AG')){    

               $tipo = tipo($columna,$valorRaw,$fila);  
               //echo $tipo . '<br>';
                if($valorRaw>0 ){ 
                       $columnaD = $valorRaw;//VALOR DE LO QUE DEBE
                       
                        $fact=$conexion->llenarCampos("tbl_orden_compra","WHERE factura_oc='".$columnaQ."'","","factura_oc");  
                            $columnaQ = $fact['factura_oc'];//$valorRaw; //NUMERO DE FACTURA       

                       if($columnaQ!=''){
                            $columnaQ = trim($columnaQ);
                         echo $columnaQ.';'.$columnaD.';'.$tipo. '<br>'; 
                         $actualizo = $conexion->actualizar("tbl_orden_compra", " estado_cartera='1', tipo_pago_cartera='$tipo', valor_cartera='".$columnaD."' ", " factura_oc= '".$columnaQ."' " );
                        logs("Existe en O.C y se Actualiza Factura #: ".$columnaQ);       

                       } 
                    }   
            }

 
        }
    }
}
 

function tipo($columna,$valorRaw,$fila){
    
    if($columna=='AC' && $valorRaw > 0 && $fila > 3) { 
           $tipo = "Vencida -  91 o más días"; 
          }else if($columna=='AD' && $valorRaw > 0 && $fila > 3){    
           $tipo = "Vencida -  61- 90 días";
    
          }else if($columna=='AE' && $valorRaw > 0 && $fila > 3){
           $tipo = "Vencida -  31- 60 días";
    
          }else if($columna=='AF' && $valorRaw > 0 && $fila > 3){
           $tipo = "Vencida - 1- 30 días";
    
          }else if($columna=='AG' && $valorRaw > 0 && $fila > 3){   
          $tipo = "Por Vencer";      

          } else{
          $tipo=0;
    }
 
          return $tipo;
  
}

function actualizoEstadoCartera(){
    $conexion = new ApptivaDB(); 
     $actualizo = $conexion->actualizar("tbl_orden_compra", " estado_cartera='0', tipo_pago_cartera='', valor_cartera='' ", " fecha_ingreso_oc >= '2024-01-01' " );
    logs("Actualiza a 0 Estado Factura Despues de fecha 2024-01-01 " );

}

function logs($msg)
  {
    echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
  }

