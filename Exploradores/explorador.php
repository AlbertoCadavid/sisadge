<?php  require_once('Connections/conexion1.php'); ?>
<?php 
      function explorador()
	  {
        $U_agent  = $_SERVER [ 'HTTP_USER_AGENT' ];
        $Ub  = '' ;
        if (preg_match ( '/Safari/i' , $U_agent ))
        {
             header('location: menu.php');
			  //$Ub  = " Safari" ;
			// echo "variable ".$U_agent ;
        }
       return  $Ub; 
    }
?>