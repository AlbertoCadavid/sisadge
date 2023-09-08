<?php /*PROGRAMACION ESTRUCTURADA FUNCIONES PHP*/
require_once('Connections/conexion1.php'); 

function adjuntarArchivoOK($tieneadjunto='', $directorio, $nuevoadjunto='', $tmp_name, $tipoejecutar='' ){
 
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


?>