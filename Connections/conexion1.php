<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet_dev";
$username_conexion1 = "acycia_dev";
$password_conexion1 = "acycia_dev";
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
 

/*   class ApptivaDB{    
    private $host   ="localhost";
    private $usuario="acycia_root";
    private $clave  ="ac2006";
    private $db     ="acycia_intranet";
    public $conexion;
    
    public function __construct(){
      $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db)
      or die(mysql_error());
      $this->conexion->set_charset("utf8");
    }

     //BUSCAR
    public function buscar($tabla, $columna, $condicion){
      $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE  $columna = {$condicion}") or die($this->conexion->error);
      if($resultado)
        return $resultado->fetch_all(MYSQLI_ASSOC);
      return false;
    } 
     //INSERTAR
    public function insertar($tabla, $datos){
      $resultado =    $this->conexion->query("INSERT INTO $tabla VALUES (null,$datos)") or die($this->conexion->error);
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
      $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);
      if($resultado)
        return true;
      return false;        
    } 

  }*/
?>