<?php
 

class oFormulacion{
    private $db;
    private $formula;

    public function __construct(){
        $this->db=Conectar::conexion();
        $this->formula=array(); 

    }
 

    public function get_Provee(){

        try 
        {
            $consulta=$this->db->query("SELECT id_p, proveedor_p FROM proveedor ORDER BY proveedor_p ASC");
            while($filas=$consulta->fetch_assoc()){
                $this->proveedores[]=$filas;
            }
 
            return $this->proveedores;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function get_Insumo(){

        try 
        {
            $consulta=$this->db->query("SELECT id_insumo,descripcion_insumo, valor_unitario_insumo FROM insumo ORDER BY descripcion_insumo ASC");
            while($filas=$consulta->fetch_assoc()){
                $this->insumo[]=$filas;
            }
    
            return $this->insumo;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function get_Maquina(){

        try 
        {
            $consulta=$this->db->query("SELECT * FROM maquina WHERE proceso_maquina <>'0' ORDER BY nombre_maquina ASC");
            while($filas=$consulta->fetch_assoc()){
                $this->maquina[]=$filas;
            }
    
            return $this->maquina;
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }


    public function Obtener($tabla,$columnas='',$columna='' )
    {

        try 
        {
            if($tabla!='' ){ 
                //echo "SELECT $columnas FROM $tabla $columna ";die;
                $stm = $this->db->query("SELECT $columnas FROM $tabla $columna ");

                while($filas=$stm->fetch_assoc()){
                    $this->formula[]=$filas;
                }
            return $this->formula;
            }

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }


    //BUSCAR REGISTROS
      public function camposEditar($tabla,$distinct='',$columna='' ){

              try 
              { 
                  //echo "SELECT $columnas FROM $tabla $columna ";die;
                  $stm = $this->db->query("SELECT $distinct FROM $tabla $columna ");
                  if($stm){
                  while($filas=$stm->fetch_assoc()){
                      $this->formula=$filas;
                  }
                  
                  return $this->formula;

                  }
              } catch (Exception $e) 
              {
                  die($e->getMessage());
              }
          }


    public function Registrar($tabla,$columna, $data)
    { 

        try 
        {
                $array_codificado = UtilHelper::arrayEncode($data);
                $array_deco = UtilHelper::arrayDecode($array_codificado); 
                $arrayPHP =  ($array_deco); 
                   
                   $stmt = $this->db->query("INSERT INTO $tabla ($columna) VALUES ( '". $arrayPHP['nombre'] ."','". $arrayPHP['formulacion'] ."' );"); 
             


       
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
 


    public function Delete($tabla,$columna,$id )
    {
        try 
        {  
       
              //Elimina 
              
               $stm = $this->db->query("DELETE FROM $tabla WHERE $columna = '$id' ");             
      
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Update($data)
    {
        try 
        {
         
             $updatepro = $this->db->query($data); echo '<br>';

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
