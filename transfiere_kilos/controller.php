<?php 
  class ApptivaDB{    
  private $host   = 'localhost';
  private $usuario= 'acycia_dev';
  private $clave  = 'acycia_dev';
  private $db     = 'acycia_intranet_dev';
  public  $conexion; 
  
  public function __construct(){
    $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db)
    or die(mysql_error());
    $this->conexion->set_charset("utf8");
  }

   //BUSCAR UNO
  public function buscar($tabla, $columna, $condicion){
    //echo "SELECT * FROM $tabla WHERE  $columna = '{$condicion}' ORDER BY $columna DESC";die;
    $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE  $columna = '{$condicion}' ORDER BY $columna DESC") or die($this->conexion->error);
    if($resultado)
      $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
    $total = $fila; 
    return $total;
    return false;
    $resultado->free();
    $resultado->close();
  }

   //BUSCAR DOS
  public function buscarDos($tabla, $columna, $condicion, $columna2, $condicion2){ 
    $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $columna = '{$condicion}' AND $columna2 = '{$condicion2}' ORDER BY $columna DESC") or die($this->conexion->error); 
    if($resultado)
      $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
    $total = $fila; 
    return $total;
    return false;
    $resultado->free();
    $resultado->close();
  }
  
  //LLENA LISTAS CON ASSOC
  public function buscarTres($tabla, $columnas, $condicion='', $order=''){
    //echo "SELECT $columnas FROM $tabla $condicion $order";die;
    $resultado = $this->conexion->query("SELECT $columnas FROM $tabla $condicion $order") or die($this->conexion->error);
    if($resultado)
      $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
    $total = $fila; 
    return $total;
    return false;
    $resultado->free();
    $resultado->close();
  }

   //BUSCAR ID CONSECUTIVO
  public function buscarId($tabla, $columna ){
    $resultado = $this->conexion->query("SELECT $columna AS id FROM $tabla ORDER BY $columna DESC LIMIT 0,1") or die($this->conexion->error);
    if($resultado) 
       $resultfin = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
      return $resultfin;//si quiero enviar $resultfin['id'] o $resultfin[$columna] con nombre de la columna o $resultfin y se recibe $resultfin['id']
      return false;
      $resultado->free();
      $resultado->close();
    } 

     //LLENAR CAMPOS
    public function llenarCampos($tabla, $condicion, $orden='', $distinct='' ){  
      //echo "SELECT $distinct FROM $tabla $condicion $orden ";die;
      $resultado = $this->conexion->query("SELECT $distinct FROM $tabla $condicion $orden ") or die($this->conexion->error);
      if($resultado)
        $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
      $total = $fila; 
      return $total;
      return false;
      $resultado->free();
      $resultado->close();
    }

    //LLENA COMBOS CONVIERTE 
     public function llenaSelect($tabla, $condicion='', $orden='' ){ 
     //echo "SELECT * FROM $tabla $condicion $orden "."<br>"; 
       $resultado = $this->conexion->query("SELECT * FROM $tabla $condicion $orden ") or die($this->conexion->error); 
       if($resultado) 
         //return $resultado->fetch_array(MYSQLI_BOTH);//MYSQLI_BOTH muestra numerico y asociativo 
         return self::getResultados($resultado);
       return false; 
       $resultado->free();
       $resultado->close();
     }  

     //LLENA LISTADOS CON FOREACH
      public function llenaListas($tabla, $condicion, $orden='', $distinct=''){ 
        //echo "SELECT $distinct FROM $tabla $condicion $orden";die;
        $resultado = $this->conexion->query("SELECT $distinct FROM $tabla $condicion $orden") or die($this->conexion->error);

        if($resultado) 
          return self::getResultados($resultado);
        return false;
        $resultado->free();
        $resultado->close();
      }

   //BUSCAR ROW VARIOS CON ID
    public function buscarList($tabla, $columna, $condicion){
      $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE  $columna = {$condicion}") or die($this->conexion->error);

      if($resultado) 
        return self::getResultados($resultado);
      return false;
      $resultado->free();
      $resultado->close();
    }

   //LISTAR VARIOS SIN ID TRAE TODOS OPCION GROUP ORDER Y COLUMNAS, COLUMNAS DISTINCT ETC
    public function buscarListar($tabla, $asterisco, $orden='', $group='', $maxRows_registros='' , $pageNum_registros='', $condicion='' ){
      //echo "SELECT $asterisco FROM $tabla $condicion $group $orden";die;
      $startRow_registros = $pageNum_registros * $maxRows_registros;
      $sql = "SELECT $asterisco FROM $tabla $condicion $group $orden ";  
      //echo $sql;die;
      $query_limit_registros = sprintf("%s LIMIT %d, %d", $sql, $startRow_registros, $maxRows_registros);
      $resultado = $this->conexion->query($query_limit_registros) or die($this->conexion->error);
      if($resultado) 
        //return $resultado->fetch_array(MYSQLI_BOTH);//MYSQLI_BOTH muestra numerico y asociativo 
        return self::getResultados($resultado);
      return false; 
      $resultado->free();
      $resultado->close();
    }
 
   //CONTADOR PARA LISTAS
    public function conteo($tabla){
      $resultado = $this->conexion->query("SELECT COUNT(*) FROM $tabla ") or die($this->conexion->error);
      if($resultado)
        $resultfin = $resultado->fetch_row(); 
      return $resultfin[0];
      return false;
      $resultado->free();
      $resultado->close();
    } 

   //INSERTAR
    public function insertar($tabla,$columna, $datos){
      $query = "INSERT INTO $tabla ($columna) VALUES ($datos) ";
      $resultado =    $this->conexion->query($query) or die($this->conexion->error);
      if($resultado)
        return true;
      return false;
    } 

  //BORRAR
    public function borrar($tabla, $condicion){    
      $resultado  =   $this->conexion->query("DELETE FROM $tabla WHERE $condicion") or die($this->conexion->error);
      if($resultado)
        return true;
      return false;
    }

  //ACTUALIZAR
    public function actualizar($tabla, $campos, $condicion){   
    //echo "UPDATE $tabla SET $campos WHERE $condicion";die; 
      $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);
      if($resultado)
        return true;
      return false;        
    } 

  //CONTADOR 
   public function conteoRegistro($tabla,$columna,$condicion='',$order=''){
    //echo "SELECT COUNT($columna) as total FROM $tabla $condicion $order ";die; 
     $resultado = $this->conexion->query("SELECT COUNT($columna) as total FROM $tabla $condicion $order ") or die($this->conexion->error);
     if($resultado)
       $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
     $total = $fila; 
     return $total;
     return false;
     $resultado->free();
     $resultado->close();
   } 

  //CONTADOR 
   public function conteos($tabla,$columna,$condicion='',$order=''){
    //echo "SELECT COUNT(DISTINCT($columna)) as total FROM $tabla $condicion $order ";die; 
     $resultado = $this->conexion->query("SELECT COUNT(DISTINCT($columna)) as total FROM $tabla $condicion $order ") or die($this->conexion->error);
     if($resultado)
       $fila = $resultado->fetch_assoc();//mysqli_fetch_assoc($resultado)
     $total = $fila; 
     return $total;
     return false;
     $resultado->free();
     $resultado->close();
   } 


   public function get_materiaPrima($tabla, $condicion='', $order){   

       try 
       {   
           //echo "SELECT * FROM $tabla $condicion $order";die;
           $consulta=$this->conexion->query("SELECT * FROM $tabla $condicion $order");
           while($filas=$consulta->fetch_assoc()){
               $this->maquina[]=$filas;
           }
   
           return $this->maquina;
       } catch (Exception $e) 
       {
           die($e->getMessage());
       }
   }

  
  public function get_Maquina(){   

      try 
      {
          $consulta=$this->conexion->query("SELECT * FROM maquina WHERE proceso_maquina='2' ORDER BY nombre_maquina ASC");
          while($filas=$consulta->fetch_assoc()){
              $this->maquina[]=$filas;
          }
  
          return $this->maquina;
      } catch (Exception $e) 
      {
          die($e->getMessage());
      }
  }


  public function get_Anilox(){   

      try 
      {   
          $consulta=$this->conexion->query("SELECT * FROM anilox ORDER BY descripcion_insumo ASC");
          while($filas=$consulta->fetch_assoc()){
              $this->anilox[]=$filas;
          }
  
          return $this->anilox;
      } catch (Exception $e) 
      {
          die($e->getMessage());
      }
  }




  public function header($vista='')
    {
       try 
         { 
          switch ($vista) {
            case 'listas':
              $page = require_once($_SERVER['DOCUMENT_ROOT'].'/acycia_dev/view_cabecera.php'); 
              break;
            case 'footer':
              $page = require_once($_SERVER['DOCUMENT_ROOT'].'/acycia_dev/view_footer.php'); 
              break;
            case 'vistas':
              $page = require_once($_SERVER['DOCUMENT_ROOT'].'/acycia_dev/view_cabecerav.php'); 
              break;
            default:
              $page = require_once($_SERVER['DOCUMENT_ROOT'].'/acycia_dev/view_cabecera.php'); 
              break;
          } 
        

         } catch (Exception $e) {
               die($e->getMessage());
        }

    }


  public function llenaCombos()
    {
     
     // Numero de registros
     $numero_de_registros = 100;

      

      $var1=$_POST['var1']=='' ? "" : $_POST['var1'];
      $var2=$_POST['var2']=='' ? "" : $_POST['var2'];
      $var3=$_POST['var3']=='' ? "" : $_POST['var3'];
      $var4=$_POST['var4']=='' ? "" : $_POST['var4']; 
      $var5=$_POST['var5']=='' ? "" : $_POST['var5'];
      $var6=$_POST['var6']=='' ? "" : $_POST['var6'];  
     if(!isset($_POST['palabraClave']) ){
      // Obtener registros
      $where  = $var3 == "" ? "" : "WHERE " . $var3;
       //echo "SELECT $var1, $var5 as id, $var6 as descrip FROM ".$var2." ". $where." ". $var4;die;
      $sql = "SELECT $var1, $var5 as id, $var6 as descrip FROM ".$var2." ". $where." ". $var4; 
    
      $query_limit_registros = sprintf("%s LIMIT %d, %d", $sql, 1, $numero_de_registros);
      $usersList = $this->conexion->query($query_limit_registros) or die($this->conexion->error);

     }else{

      $search = $_POST['palabraClave'];// Palabra a buscar
      
      // Obtener registros
     
         $var3 = $var3 == "" ? "" : " AND ".$var3;

      if($search)
       $where = "WHERE ".$var6. " LIKE " . ' "%'.$search.'%" ' . $var3;
       
       $stmt=$this->conexion->query("SELECT $var1, $var5 as id, $var6 as descrip FROM   ".$var2." $where  ". $var4);
       if($stmt) 
         $usersList = self::getResultados($stmt);
       
       
     }
      
      
     $response = array();

     // Leer la informacion
     foreach($usersList as $user){
      $response[] = array(
        "id" => $user['id'],
        "text" => $user['descrip']
      );
     }

     echo json_encode($response);
     
    /* $usersList->free();
     $usersList->close();*/
    

    }
 



    public function seleccionProceso($iddesp,$rollo,$ops,$kilos ){
       
       $saextruder = [
        "82" => "82", //Apariencia
        "83" => "83", //Grumos de Extrusión
        "85" => "85", //Arrugas
        "108" => "108", //Descalibre
        "138" => "138", //Medida
        "225" => "225" //Tratamiento
       ];

       $iaextruder = [
          "60" => "60", //Arrugas
          "54" => "54" //Extruder
       ];

       $saimpresion = [
          "81" => "81" //Mala Impresión
       ];

       foreach($iaextruder as &$valor) { 
            if($valor == $iddesp){

              $id_proceso_rp = 1;//a este proceso se envia el desperdicio

              self::updateLiquidacion("tbl_reg_produccion","1",$rollo,$ops,$kilos);//se modifica la liquidacion 
             
            } 
       }
       foreach($saimpresion as &$valor2) { 
            if($valor2 == $iddesp){ 

              $id_proceso_rp = 2;//a este proceso se envia el desperdicio

              self::updateLiquidacion("tbl_reg_produccion","2",$rollo,$ops,$kilos);//se modifica la liquidacion
            
            } 
       }
       foreach($saextruder as &$valor3) { 
            if($valor3 == $iddesp){

              $id_proceso_rp = 1;//a este proceso se envia el desperdicio 
             
              self::updateLiquidacion("tbl_reg_produccion","4",$rollo,$ops,$kilos);//se modifica la liquidacion
 
            } 
       }

       return $id_proceso_rp;

    }

   
    public function updateLiquidacion($tabla,$proceso_modificar,$rollo,$ops,$kilos){
    
     try 
       { 
      //Metros correspondientes a ese desperdicio
      $nuevometros=self::operacionesGenmetros("TblExtruderRollo" ," WHERE id_op_r = '$ops' AND rollo_r='$rollo'","", $kilos);
      $nuevometros2=self::operacionesGenmetros("tblimpresionrollo" ," WHERE id_op_r = '$ops' AND rollo_r='$rollo'","", $kilos);
      $nuevometros3=self::operacionesGenmetros("tblselladorollo" ," WHERE id_op_r = '$ops' AND rollo_r='$rollo'","", $kilos);
      //actualizo rollos kilos y metros
      $extruderRollos=self::updateRollos($ops,$rollo,$nuevometros,$kilos,$proceso_modificar);
      /*$impresionRollos=self::updateRollos($ops,$rollo,$nuevometros2,$kilos,"2");
      $selladoRollos=self::updateRollos($ops,$rollo,$nuevometros3,$kilos,"4"); */
 

     if($proceso_modificar=='1'){
      
      $extruder=$this->conexion->query("UPDATE $tabla SET int_kilos_desp_rp = int_kilos_desp_rp + '$kilos',int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='1' ");//modifico Liquidacion
      $impresion=$this->conexion->query("UPDATE $tabla SET int_kilos_prod_rp = int_kilos_prod_rp - '$kilos', int_kilos_desp_rp = int_kilos_desp_rp - '$kilos', int_total_kilos_rp=int_kilos_prod_rp-'$kilos'  WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'");//Impresion
      $sellado=$this->conexion->query("UPDATE $tabla SET int_kilos_prod_rp = int_kilos_prod_rp - '$kilos', int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros3' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'");//sellado

     }else if($proceso_modificar=='2'){
      
      $impresion=$this->conexion->query("UPDATE $tabla SET int_kilos_desp_rp = int_kilos_desp_rp + '$kilos', int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros2' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'");
      $sellado=$this->conexion->query("UPDATE $tabla SET int_kilos_prod_rp = int_kilos_prod_rp - '$kilos', int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros3' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'");//sellado

     }else if($proceso_modificar=='4'){

      $extruder=$this->conexion->query("UPDATE $tabla SET int_kilos_desp_rp = int_kilos_desp_rp + '$kilos',int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='1' ");//modifico Liquidacion 
      $impresion=$this->conexion->query("UPDATE $tabla SET int_kilos_prod_rp = int_kilos_prod_rp - '$kilos', int_total_kilos_rp=int_total_kilos_rp-'$kilos', int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros2' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'");//Impresion
      $sellado=$this->conexion->query("UPDATE $tabla SET int_kilos_prod_rp = int_kilos_prod_rp - '$kilos', int_kilos_desp_rp = int_kilos_desp_rp - '$kilos',  int_metro_lineal_rp=int_metro_lineal_rp-'$nuevometros3' WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'");//sellado
      $sellado=$this->conexion->query("UPDATE $tabla SET int_total_kilos_rp=int_kilos_prod_rp-int_kilos_desp_rp WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'");//sellado

     }

 
     $kilosxhora=self::generalkiloxhora($tabla," WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='1'","int_kilos_prod_rp");
     $kilosxhora2=self::generalkiloxhora($tabla," WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'","int_total_kilos_rp");
     $kilosxhora3=self::generalkiloxhora($tabla," WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'","int_total_kilos_rp");
    
     $extruderM=$this->conexion->query("UPDATE $tabla SET int_kilosxhora_rp='$kilosxhora' WHERE id_op_rp='$ops' AND rollo_rp='$rollo' AND id_proceso_rp='1'");
     $impresionM=$this->conexion->query("UPDATE $tabla SET int_kilosxhora_rp='$kilosxhora2' WHERE id_op_rp='$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'"); 
     $selladoM=$this->conexion->query("UPDATE $tabla SET int_kilosxhora_rp='$kilosxhora3' WHERE id_op_rp='$ops' AND rollo_rp='$rollo' AND id_proceso_rp='4'"); 
     

     $metroxmin=self::generalMetrosxmin($tabla," WHERE id_op_rp = '$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2' " );
     $impresionMxM=$this->conexion->query("UPDATE $tabla SET int_metroxmin_rp='$metroxmin' WHERE id_op_rp='$ops' AND rollo_rp='$rollo' AND id_proceso_rp='2'");

    } catch (Exception $e) 
       {
             $update=0;
            die($e->getMessage());
        }
         return $update;   
    } 


   public function updateRollos($ops,$rollo,$nuevometros,$kilos,$proceso){
   
    try 
      { 
      //impresion a extruder
      if($proceso=='1'){
       $extruder=$this->conexion->query("UPDATE tblextruderrollo SET kilos_r = kilos_r  - '$kilos', metro_r=metro_r-'$nuevometros' WHERE id_op_r = '$ops' AND rollo_r='$rollo' "); //se modifica Rollo Extruder
      }
      //sellado a impresion
     if($proceso=='2'){
       $impresion=$this->conexion->query("UPDATE tblimpresionrollo SET kilos_r = kilos_r  - '$kilos', metro_r=metro_r-'$nuevometros' WHERE id_op_r = '$ops' AND rollo_r='$rollo' "); //se modifica Rollo Impresion
     }
     //sellado a extruder
     if($proceso=='4'){
      $extruder=$this->conexion->query("UPDATE tblextruderrollo SET kilos_r = kilos_r  - '$kilos', metro_r=metro_r-'$nuevometros' WHERE id_op_r = '$ops' AND rollo_r='$rollo' "); //se modifica Rollo Extruder
      $impresion=$this->conexion->query("UPDATE tblimpresionrollo SET kilos_r = kilos_r  - '$kilos', metro_r=metro_r-'$nuevometros' WHERE id_op_r = '$ops' AND rollo_r='$rollo' "); //se modifica Rollo Impresion
       //$sellado=$this->conexion->query("UPDATE tblselladorollo SET kilos_r = kilos_r  - '$kilos', metro_r=metro_r-'$nuevometros' WHERE id_op_r = '$ops' AND rollo_r='$rollo' "); //se modifica Rollo Sellado 
     }
      


        } catch (Exception $e) 
        {
             $update=0;
            die($e->getMessage());
        }
         return $update;   
    } 



    public function generalkiloxhora($tabla,$condicion,$columna){

        $resultado2 = $this->conexion->query("SELECT ($columna) as total_kilos,total_horas_rp FROM $tabla $condicion") or die($this->conexion->error);
   
        if($resultado2)
          $fila2 = $resultado2->fetch_assoc();//mysqli_fetch_assoc($resultado)
        $total = $fila2; 
       
        $kilos2=$total['total_kilos']; //kilos del proceso inicial  
        $horas2=$total['total_horas_rp'];//horas salida proceso inicial
        $horasdiv2 = explode(":", $horas2);
        $horash2=($horasdiv2[0]*60);
        $horasm2=$horasdiv2[1];
        $sumahoras2=($horash2 + $horasm2) / 60; 
        $kiloxhora2=$kilos2 / ($sumahoras2);

        return $kiloxhora2;
       
    }


    public function generalMetrosxmin($tabla,$condicion ){
      $resultado3 = $this->conexion->query("SELECT total_horas_rp,int_metro_lineal_rp FROM $tabla $condicion ") or die($this->conexion->error);
      
      /*while($filas3=$resultado3->fetch_assoc()){
          $this->general3[]=$filas3;
      }*/
       if($resultado3)
          $fila3 = $resultado3->fetch_assoc();//mysqli_fetch_assoc($resultado)
        $general3 = $fila3; 
 
      $metros=$general3['int_metro_lineal_rp'];//metros 
      $horas=$general3['total_horas_rp'];//horas salida proceso inicial
      $horasdiv = explode(":", $horas);
      $horash=($horasdiv[0]*60);
      $horasm=$horasdiv[1];
      $sumahoras=($horash + $horasm); 
     
      $metroxmin= ($metros/$sumahoras);

      
      return $metroxmin;

    } 




      public function operacionesGenmetros($tabla,$condicion,$order='',$desp){
        
          $resultado = $this->conexion->query("SELECT * FROM $tabla $condicion $order ") or die($this->conexion->error);
         
          while($filas=$resultado->fetch_assoc()){
              $this->general[]=$filas;
          }
          
          
          $kilos=$this->general[0]['kilos_r']; //kilos del proceso inicial 
          $metros=$this->general[0]['metro_r'];//metros salida proceso inicial 
          $kilosTotales=($kilos-$desp);
          $metrosfinal = round(($desp * $metros) / $kilos,0);

        
          return $metrosfinal;

      } 





      //convierte a Array
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
?>