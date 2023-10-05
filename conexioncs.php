<?php
date_default_timezone_set('America/Bogota');

//$sConnection = odbc_connect ("Controlador = {Interfaz de motor ODBC generalizada}; ServerName = localhost; ServerDSN = DSNname;", "Maestro", "maestro", SQL_CUR_USE_ODBC);


 
    function conectar_PostgreSQL( $usuario, $pass, $host, $bd )
    {
         $conexion = pg_connect( "user=".$usuario." ".
                                "password=".$pass." ".
                                "host=".$host." ".
                                "dbname=".$bd
                               ) or die( "Error al conectar: ".pg_last_error() );
        return $conexion;
    }
 

 function buscarPersona( $conexion, $id )
 {
     $sql = "SELECT * FROM tbl_personas WHERE id=".$id."";
     $devolver = null;
     // Ejecutar la consulta:
      $rs = pg_query( $conexion, $sql );
     if( $rs )
     {
         // Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
          if( pg_num_rows($rs) > 0 )
              $devolver = pg_fetch_object( $rs, 0 );
     }
     return $devolver;
 }




/*function Conectarcs()
{
	$host = "localhost";
	$bd = "acycia_intranet";
	$user ="acyciapw";
	$password = "acyciapw";
	$mysqli = new mysqli($host, $user, $password, $bd );
	if ($mysqli->connect_errno) 
	{
		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit;
	}
	else
	{
		$mysqli->character_set_name();
		$mysqli->set_charset("utf8");
		logs(utf8_encode("Iniciando Conexion.. AcyciaPw..."));
		return $mysqli;
	}
}

//cerrar conexion a intranet
      $conexioncs->close();

  function logs($msg)
  {
  	echo $msg." - [".date('Y-m-d H:i:s')."]<br>";
  }*/

/*$conexionpw = Conectarcs();
 $query_cliente = $conexionpw->query("SELECT MAX(id_c) FROM cliente WHERE nit_c='".$cedulanit."' ");
 $result_cliente = $query_cliente->fetch_row(); 
 $idcliente=$result_cliente[0];

?>