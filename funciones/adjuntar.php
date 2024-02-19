<?php /*PROGRAMACION ESTRUCTURADA FUNCIONES PHP*/
require_once('Connections/conexion1.php'); 
//include('funciones/funciones_php.php');
function adjuntarArchivoOK($tieneadjunto='', $directorio, $nuevoadjunto='', $tmp_name, $tipoejecutar='' ){
     $tieneadjunto = eliminarTildes($tieneadjunto);
     $nuevoadjunto = eliminarTildes($nuevoadjunto);
     $tmp_name = eliminarTildes($tmp_name);  

     $fileTmpPath = $tmp_name['tmp_name'];
     $fileName = $nuevoadjunto=='' ? $tieneadjunto : $nuevoadjunto;//$tmp_name['name'];
     $fileSize = $tmp_name['size'];
     $fileType = $tmp_name['type'];
     $fileNameCmps = explode(".", $fileName);
     $fileExtension = strtolower(end($fileNameCmps));
     //$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
     //$newFileName = $fileName . '.' . $fileExtension;
     $allowedfileExtensions = array('pdf','jpeg','jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
     if (in_array($fileExtension, $allowedfileExtensions)) {
  
 
         if ( $nuevoadjunto != "") {
           if($tieneadjunto != '') {
             if (file_exists($directorio.$tieneadjunto))
               { unlink($directorio.$tieneadjunto);	} 
           }
  
         $directorio = $directorio;
         $tieneadjunto = str_replace(" ", "", $nuevoadjunto);//quita espacios en cadena
         $archivo_temporal = $fileTmpPath;
         if (!copy($archivo_temporal,$directorio.$tieneadjunto)) {
           $error = "Error al enviar el Archivo";
         } else { $imagen = $directorio.$tieneadjunto; }
         }

     }
 

     return $tieneadjunto;
 
 
}



function adjuntarArchivo($tieneadjunto='', $directorio, $nuevoadjunto, $tmp_name, $tipoejecutar ){

	/*$tamano_archivo = $_FILES[$nuevoadjunto]['size'];//1048576 es una mega 
	$tipo_archivo = $_FILES[$nuevoadjunto]['type'];*/
	  //if (!((strpos($tipo_archivo, "pdf")) && ($tamano_archivo < 10485770))) 
   $tieneadjunto = eliminarTildes($tieneadjunto);
   $nuevoadjunto = eliminarTildes($nuevoadjunto);
   $tmp_name = eliminarTildes($tmp_name);

	if ($nuevoadjunto != "") { 
		if($tipoejecutar == 'UPDATES' || $tipoejecutar == 'NUEVOS'){

          	 //UPDATE DEL ARCHIVO ELN EL SERVIDOR 
          	 if($tieneadjunto != ""){
      			if (file_exists($directorio.$tieneadjunto)) 
      			{ 
      				unlink($directorio.$tieneadjunto); 
      			}  
          	 } 
          	  
			$tieneadjunto2 = str_replace(' ', '', $nuevoadjunto);
			$archivo_temporal = $tmp_name;

			if (!copy($archivo_temporal,$directorio.$tieneadjunto2)) {
				$error = "Error al enviar el Archivo";
			} else { 
				$tieneadjunto = $tieneadjunto2; 
			}

			return $tieneadjunto;      	     

		} 

	}else{
		return $tieneadjunto;
	}
 




}


function cambioExtension($name,$otraextension=''){

   $name = str_replace(' ', '', $name);
   $porciones = explode(".", $name);
   $str_archivo_oc = $name =! '' ? $otraextension :$name; 
   $result = $str_archivo_oc . "." . $porciones[1];
   return $result;
}


function eliminarTildes($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);//modificado 08-02-2022

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    ); 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena; 
}

 
?>