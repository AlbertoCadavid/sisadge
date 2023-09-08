<?php
   //require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   //require (ROOT_BBDD); 
?> 
<?php 
//$conexion = new ApptivaDB();

//$proveedores = $conexion->llenaSelect('proveedor','','ORDER BY proveedor_p ASC');


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>SISADGE AC &amp; CIA</title>
 
</head>
<body style="background-color:#D9DAE1;">
 <div style="align-content: center;" > <h3> ARCHIVOS ADJUNTOS COMERCIO EXTERIOR </h3></div>
      <h5> AQUÍ PUEDE DESCARGAR EL ARCHIVO DE LIQUIDACION Y CONTROL DE OPERACIONES</h5> 
 
       <?php 
         // Se comprueba que realmente sea la ruta de un directorio
             $ruta = '../pdfprocesocompras';
                   showFiles($ruta);
        ?> 
  
</body>
</form>
</html>
 <?php 


 function showFiles($path){
    $dir = opendir($path);
    $files = array();
    while ($current = readdir($dir)){
        if( $current != "." && $current != "..") {
            if(is_dir($path.$current)) {
                showFiles($path.$current.'/');
            }
            else {
               if( !(eregi(".*\.php", $path.$current)) && !(eregi(".*\.png", $path.$current))  ){

                $files[] = $current;
               }
            }
        }
    }
 
    echo '<ul>';
    if($files){
       for($i=0; $i<count( $files ); $i++){
           echo  "<a href=".$path."/".$files[$i]." style='text-decoration:none;'  > <img src='".$path."/excel.png' style='width: 50px; height: 40px;'  alt='Excel' title='Excel'>"  .$files[$i]. "</a><br><br>";
           //echo "<img src='".$path."/".$files[$i]."' width='200px' alt='".$files[$i]."' title='".$files[$i]."'>";
           //echo '<li>'.$files[$i]."</li>";
       }
       echo '</ul>';

    }else{
       echo 'No hay archivos adjuntos';
    }



    // Cierra el gestor de directorios
    closedir($dir);
} 
 ?>
 