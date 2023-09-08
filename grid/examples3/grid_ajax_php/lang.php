<? if(!isset($_SESSION)) session_start();
   
   if(!isset($_SESSION["lang"])){
     if($_SERVER["HTTP_HOST"]=="www.freelancesoft.com.ar" || $_SERVER["HTTP_HOST"]=="freelancesoft.com.ar"){
          $_SESSION["lang"]="es";
      } else {
          $_SESSION["lang"]="en";
     }
   }

   if(isset($_GET["lang"])){
      switch($_GET["lang"]){
	   case 'es': $_SESSION["lang"]='es'; break;
	   case 'en': $_SESSION["lang"]='en'; break;
	  }
   }
   
   switch($_SESSION["lang"]){
     case 'es': require('lang/spanish.php'); break;
	 case 'en': require('lang/english.php'); break;
   }

?>