<?php 
require_once('funciones/funciones_php.php');  
//require_once 'Models/McomercialList.php';

class mComercialList{
    private $db;
    private $ordenc;

    public function __construct(){
        $this->db=Conectar::conexion();
        $this->ordenc=array();
        /*$this->proveedores=array();
        $this->insumo=array();*/

    }
 
 
    public function Update($tabla,$id,$valor,$columna,$proceso)
    { 
        try 
        { 
            $fecha = date("Y-m-d");  
 
            $update = $this->db->query("UPDATE $tabla SET pago_pendiente = 'NO', fecha_ingreso_oc = '$fecha' WHERE $id = $valor "); 
          die;//dejarlo para q no bote error
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
  
  public function UpdateProforma($id,$valor,$colum,$proceso='',$url='',$tabla='')
    { 
        try 
        { 
            $fecha = date("Y-m-d");  

          
            $hora_actual = fechahoraActual();
            $hoy = $hora_actual; 

            $fechas_entrega = sumarMesyDias($fecha,3); //se agrega un mes mas 3 dias
             
            $update = $this->db->query("UPDATE $tabla SET $colum = 'NO', autorizado = 'SI',  fecha_ingreso_oc='$fecha', fecha_entrega_oc='$fechas_entrega', fecha_autoriza='$hoy' WHERE $id = $valor");
           
            
            $logs = $this->db->query("INSERT INTO tbl_logs ( codigo_id, descrip, fecha, modificacion, usuario) values ('$valor','OC','$hoy','autorizado SI','".$_SESSION['Usuario']."' ) " ); 
 

            if($update)
                echo 'ok';
          
          die;//dejarlo para q no bote error
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Updateweb($id,$valor,$colum,$proceso='',$url='',$tabla='')
    { 
        try 
        { 
             
            // id,valor,colum,proceso,url, tabla,
          
            $update = $this->db->query("UPDATE $tabla SET $colum = '0' WHERE $id = $valor "); 
          die;//dejarlo para q no bote error
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

      public function getResultados($arreglo)
      {
        $rows = array();
      while($row = $arreglo->fetch_array(MYSQLI_BOTH))//MYSQLI_ASSOC array asociativo, MYSQLI_NUM array numérico
      {
        $rows[] = $row;
      }

      return $rows;
    }


}

class UtilHelper {
   /* Crea un string codificado a partir de un array
   * @param Array array: array asociativo clave => valor
   * @return cadena de texto con el array listo para insertarse en BD
   */
   static function arrayEncode($array){
      return base64_encode(json_encode($array));
  }

   /* Crea un array a partir de un string codificado
   * @param String array_texto : string codificado de un array asociativo clave => valor
   * @return Array php
   */
   static function arrayDecode($array){
      return json_decode((base64_decode($array)),true);
  }
}
?>
