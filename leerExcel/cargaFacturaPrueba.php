<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 
?>
<?php
 
 //require_once('conexion1.php');
 $conexion = new ApptivaDB();  
/**
 * Demostrar lectura de hoja de cálculo o archivo
 * de Excel con PHPSpreadSheet: leer todo el contenido
 * de un archivo de Excel
 *
 * @author parzibyte
 */
# Cargar librerias y cosas necesarias
require_once __DIR__."/vendor/autoload.php";

# Indicar que usaremos el IOFactory
use PhpOffice\PhpSpreadsheet\IOFactory;

# Recomiendo poner la ruta absoluta si no está junto al script
# Nota: no necesariamente tiene que tener la extensión XLSX
$rutaArchivo = "../PDF_FE/CARTERADEV.xls";
$documento = IOFactory::load($rutaArchivo);

# Recuerda que un documento puede tener múltiples hojas
# obtener conteo e iterar
$totalDeHojas = $documento->getSheetCount();

# Iterar hoja por hoja
for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
    # Obtener hoja en el índice que vaya del ciclo
    $hojaActual = $documento->getSheet($indiceHoja);
    //echo "<h3>Vamos en la hoja con índice $indiceHoja</h3>";

    # Iterar filas
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
            
            

            if($columna && $fila && $fila >1 && $columna=='C' ){
               
                $columnaC = $valorRaw;
  
            }
 

        if($columna && $fila >0 && ($columna=='D' || $columna=='E'  || $columna=='F' || $columna=='G' || $columna=='H')){

           $tipo = tipo($columna,$valorRaw,$fila);  
           //echo $tipo . '<br>';
            if($valorRaw>0 ){ 
                $columnaD = $valorRaw;
                //echo $columnaC.';'.$columnaD.';'.$tipo. '<br>';
                 $actualizo = $conexion->actualizar("tbl_orden_compra", " estado_cartera='1', tipo_pago_cartera='$tipo', valor_cartera='".$columnaD."' ", " factura_oc= '".$columnaC."' " );
                 logs("Finalizando Proceso Factura #: ".$columnaC);
             }


            }
 
        }
    }
}
 

function tipo($columna,$valorRaw,$fila){
    
    if($columna=='D' && $valorRaw > 0 && $fila > 1) { 
           $tipo = "Vencida -  91 o más días"; 
          }else if($columna=='E' && $valorRaw > 0 && $fila > 1){    
           $tipo = "Vencida -  61- 90 días";
    
          }else if($columna=='F' && $valorRaw > 0 && $fila > 1){
           $tipo = "Vencida -  31- 60 días";
    
          }else if($columna=='G' && $valorRaw > 0 && $fila > 1){
           $tipo = "Vencida - 1- 30 días";
    
          }else if($columna=='H' && $valorRaw > 0 && $fila > 1){   
          $tipo = "Por Vencer";      

          } else{
          $tipo=0;
    }
 
          return $tipo;
  
}

function logs($msg)
  {
    echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
  }