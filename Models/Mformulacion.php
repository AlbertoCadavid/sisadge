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
            $consulta=$this->db->query("SELECT * FROM maquina WHERE proceso_maquina=1 ORDER BY nombre_maquina ASC");
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

    public function ObtenerColumn($tabla,$columna,$columna2,$id,$order='')
    {

        try 
        { 

            if($tabla!='' && $columna!='' && $columna2!='' && $id!=''){ 
                 //echo "SELECT $columna2 FROM $tabla WHERE $columna = '$id' $order ";die;
                $stm = $this->db->query("SELECT $columna2 FROM $tabla WHERE $columna = '$id' $order ");
                while($filas=$stm->fetch_assoc()){
                    $this->ordenc=$filas;
                }
            return $this->ordenc;
            }

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function get_materiaPrima($tabla, $condicion='', $order){   

        try 
        {
            $consulta=$this->db->query("SELECT * FROM $tabla $condicion $order");
            while($filas=$consulta->fetch_assoc()){
                $this->maquina[]=$filas;
            }
    
            return $this->maquina;
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
                  if($arrayPHP['nombre']!='' && $arrayPHP['formulacion']!=''){
                    
                   $stmt = $this->db->query("INSERT INTO $tabla ($columna) VALUES ( '". $arrayPHP['nombre'] ."','". $arrayPHP['formulacion'] ."','". $arrayPHP['proceso'] ."','". $arrayPHP['material'] ."' );"); 
                  } 
             


       
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
 

 public function RegistrarFormula($tabla,$columna,$filtro,$id, $data)
 { 


     try 
     {
         $array_codificado = UtilHelper::arrayEncode($data);
         $array_deco = UtilHelper::arrayDecode($array_codificado); 
         $arrayPHP =  ($array_deco) ;
         

         $consulta=$this->db->query("SELECT * FROM $tabla WHERE ".$filtro." ='$id' and id_proceso='1' ");
         if($consulta){
          while($filas=$consulta->fetch_assoc()){
             $this->existe[]=$filas;
          }

         }

         if(is_null($this->existe)){ 
 
      

           $stmt = $this->db->query("INSERT INTO $tabla ($columna) VALUES ( '". $arrayPHP['id_proceso'] ."','". $arrayPHP['fecha_registro_pm'] ."','". $arrayPHP['str_registro_pm'] ."','". $arrayPHP['id_ref_pm'] ."','". $arrayPHP['int_cod_ref_pm'] ."','". $arrayPHP['version_ref_pm'] ."','". $arrayPHP['int_ref1_tol1_pm'] ."','". $arrayPHP['int_ref1_tol1_porc1_pm'] ."','". $arrayPHP['int_ref2_tol1_pm'] ."','". $arrayPHP['int_ref2_tol1_porc2_pm'] ."','". $arrayPHP['int_ref3_tol1_pm'] ."','". $arrayPHP['int_ref3_tol1_porc3_pm'] ."','". $arrayPHP['int_ref1_tol2_pm'] ."','". $arrayPHP['int_ref1_tol2_porc1_pm'] ."','". $arrayPHP['int_ref2_tol2_pm'] ."','". $arrayPHP['int_ref2_tol2_porc2_pm'] ."','". $arrayPHP['int_ref3_tol2_pm'] ."','". $arrayPHP['int_ref3_tol2_porc3_pm'] ."','". $arrayPHP['int_ref1_tol3_pm'] ."','". $arrayPHP['int_ref1_tol3_porc1_pm'] ."','". $arrayPHP['int_ref2_tol3_pm'] ."','". $arrayPHP['int_ref2_tol3_porc2_pm'] ."','". $arrayPHP['int_ref3_tol3_pm'] ."','". $arrayPHP['int_ref3_tol3_porc3_pm'] ."','". $arrayPHP['int_ref1_tol4_pm'] ."','". $arrayPHP['int_ref1_tol4_porc1_pm'] ."','". $arrayPHP['int_ref2_tol4_pm'] ."','". $arrayPHP['int_ref2_tol4_porc2_pm'] ."','". $arrayPHP['int_ref3_tol4_pm'] ."','". $arrayPHP['int_ref3_tol4_porc3_pm'] ."','". $arrayPHP['int_ref1_rpm_pm'] ."','". $arrayPHP['int_ref1_tol5_porc1_pm'] ."','". $arrayPHP['int_ref2_rpm_pm'] ."','". $arrayPHP['int_ref2_tol5_porc2_pm'] ."','". $arrayPHP['int_ref3_rpm_pm'] ."','". $arrayPHP['int_ref3_tol5_porc3_pm'] ."','". $arrayPHP['extrusora_mp'] ."','". $arrayPHP['observ_pm'] ."','". $arrayPHP['b_borrado_pm'] ."' );");
          

         }else{ 
 
             $updatepro = $this->db->query("UPDATE $tabla SET id_proceso = '". $arrayPHP['id_proceso'] ."',fecha_registro_pm = '". $arrayPHP['fecha_registro_pm'] ."',str_registro_pm = '". $arrayPHP['str_registro_pm'] ."',int_ref1_tol1_pm = '". $arrayPHP['int_ref1_tol1_pm'] ."',int_ref1_tol1_porc1_pm = '". $arrayPHP['int_ref1_tol1_porc1_pm'] ."',int_ref2_tol1_pm = '". $arrayPHP['int_ref2_tol1_pm'] ."',int_ref2_tol1_porc2_pm = '". $arrayPHP['int_ref2_tol1_porc2_pm'] ."',int_ref3_tol1_pm = '". $arrayPHP['int_ref3_tol1_pm'] ."',int_ref3_tol1_porc3_pm = '". $arrayPHP['int_ref3_tol1_porc3_pm'] ."',int_ref1_tol2_pm = '". $arrayPHP['int_ref1_tol2_pm'] ."',int_ref1_tol2_porc1_pm = '". $arrayPHP['int_ref1_tol2_porc1_pm'] ."',int_ref2_tol2_pm = '". $arrayPHP['int_ref2_tol2_pm'] ."',int_ref2_tol2_porc2_pm = '". $arrayPHP['int_ref2_tol2_porc2_pm'] ."',int_ref3_tol2_pm = '". $arrayPHP['int_ref3_tol2_pm'] ."',int_ref3_tol2_porc3_pm = '". $arrayPHP['int_ref3_tol2_porc3_pm'] ."',int_ref1_tol3_pm = '". $arrayPHP['int_ref1_tol3_pm'] ."',int_ref1_tol3_porc1_pm = '". $arrayPHP['int_ref1_tol3_porc1_pm'] ."',int_ref2_tol3_pm = '". $arrayPHP['int_ref2_tol3_pm'] ."',int_ref2_tol3_porc2_pm = '". $arrayPHP['int_ref2_tol3_porc2_pm'] ."',int_ref3_tol3_pm = '". $arrayPHP['int_ref3_tol3_pm'] ."',int_ref3_tol3_porc3_pm = '". $arrayPHP['int_ref3_tol3_porc3_pm'] ."',int_ref1_tol4_pm = '". $arrayPHP['int_ref1_tol4_pm'] ."',int_ref1_tol4_porc1_pm = '". $arrayPHP['int_ref1_tol4_porc1_pm'] ."',int_ref2_tol4_pm = '". $arrayPHP['int_ref2_tol4_pm'] ."',int_ref2_tol4_porc2_pm = '". $arrayPHP['int_ref2_tol4_porc2_pm'] ."',int_ref3_tol4_pm = '". $arrayPHP['int_ref3_tol4_pm'] ."',int_ref3_tol4_porc3_pm = '". $arrayPHP['int_ref3_tol4_porc3_pm'] ."',int_ref1_rpm_pm = '". $arrayPHP['int_ref1_rpm_pm'] ."',int_ref1_tol5_porc1_pm = '". $arrayPHP['int_ref1_tol5_porc1_pm'] ."',int_ref2_rpm_pm = '". $arrayPHP['int_ref2_rpm_pm'] ."',int_ref2_tol5_porc2_pm = '". $arrayPHP['int_ref2_tol5_porc2_pm'] ."',int_ref3_rpm_pm = '". $arrayPHP['int_ref3_rpm_pm'] ."',int_ref3_tol5_porc3_pm = '". $arrayPHP['int_ref3_tol5_porc3_pm'] ."',extrusora_mp = '". $arrayPHP['extrusora_mp'] ."',observ_pm = '". $arrayPHP['observ_pm'] ."',b_borrado_pm = '". $arrayPHP['b_borrado_pm'] ."' WHERE ".$filtro." = '". $id ."'  and id_proceso='1';" );
           
         }
         /*echo '<pre>';
            var_dump($stmt) ;
         echo '<pre>';die; */
 

  
     } catch (Exception $e) 
     {
         die($e->getMessage());
     }
 }


 public function RegistrarFormulaHistorico($tabla,$columna,$filtro,$id, $data)
 { 


     try 
     {
         $array_codificado = UtilHelper::arrayEncode($data);
         $array_deco = UtilHelper::arrayDecode($array_codificado); 
         $arrayPHP =  ($array_deco) ;
         
           

           $stmt = $this->db->query("INSERT INTO $tabla ($columna) VALUES ( '". $arrayPHP['id_proceso'] ."','". $arrayPHP['fecha_registro_pm'] ."','". $arrayPHP['str_registro_pm'] ."','". $arrayPHP['id_ref_pm'] ."','". $arrayPHP['int_cod_ref_pm'] ."','". $arrayPHP['version_ref_pm'] ."','". $arrayPHP['int_ref1_tol1_pm'] ."','". $arrayPHP['int_ref1_tol1_porc1_pm'] ."','". $arrayPHP['int_ref2_tol1_pm'] ."','". $arrayPHP['int_ref2_tol1_porc2_pm'] ."','". $arrayPHP['int_ref3_tol1_pm'] ."','". $arrayPHP['int_ref3_tol1_porc3_pm'] ."','". $arrayPHP['int_ref1_tol2_pm'] ."','". $arrayPHP['int_ref1_tol2_porc1_pm'] ."','". $arrayPHP['int_ref2_tol2_pm'] ."','". $arrayPHP['int_ref2_tol2_porc2_pm'] ."','". $arrayPHP['int_ref3_tol2_pm'] ."','". $arrayPHP['int_ref3_tol2_porc3_pm'] ."','". $arrayPHP['int_ref1_tol3_pm'] ."','". $arrayPHP['int_ref1_tol3_porc1_pm'] ."','". $arrayPHP['int_ref2_tol3_pm'] ."','". $arrayPHP['int_ref2_tol3_porc2_pm'] ."','". $arrayPHP['int_ref3_tol3_pm'] ."','". $arrayPHP['int_ref3_tol3_porc3_pm'] ."','". $arrayPHP['int_ref1_tol4_pm'] ."','". $arrayPHP['int_ref1_tol4_porc1_pm'] ."','". $arrayPHP['int_ref2_tol4_pm'] ."','". $arrayPHP['int_ref2_tol4_porc2_pm'] ."','". $arrayPHP['int_ref3_tol4_pm'] ."','". $arrayPHP['int_ref3_tol4_porc3_pm'] ."','". $arrayPHP['int_ref1_rpm_pm'] ."','". $arrayPHP['int_ref1_tol5_porc1_pm'] ."','". $arrayPHP['int_ref2_rpm_pm'] ."','". $arrayPHP['int_ref2_tol5_porc2_pm'] ."','". $arrayPHP['int_ref3_rpm_pm'] ."','". $arrayPHP['int_ref3_tol5_porc3_pm'] ."','". $arrayPHP['extrusora_mp'] ."','". $arrayPHP['observ_pm'] ."','". $arrayPHP['b_borrado_pm'] ."' );");
          

       
         /*echo '<pre>';
            var_dump($stmt) ;
         echo '<pre>';die; */
 

  
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
