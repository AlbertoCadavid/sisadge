<?php
 
class Cadenas 
{
 
public function str_split_unicode($str, $length = 1) {
    $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
    if ($length > 1) {
        $chunks = array_chunk($tmp, $length);
        foreach ($chunks as $i => $chunk) {
            $chunks[$i] = join('', (array) $chunk);
        }
        $tmp = $chunks;
    }
    return $tmp;
}

public function retornaNumer($cadena){
   foreach ($cadena as &$valor) {
     if( is_numeric($valor))
     {
      $cadenaNum .= $valor;
     } 
      
   } 
   return $cadenaNum;
}

public function retornaLetras($cadena){
  foreach ($cadena as &$valor) {
    if( !(is_numeric($valor)) )
    {
     $cadenaNum .= $valor;
    } 
     
  } 
  return $cadenaNum;  
}



}


 
?>