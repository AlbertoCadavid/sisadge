<?php
  define('DB_HOST',"localhost");
  define('DB_USER',"root");
  define('DB_PASS',"");
  define('DB_DATABASE',"world");

 
  define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/phpajaxgrid/examples/');
  
  define('BASE_URL', 'http://'.$_SERVER["HTTP_HOST"].'/phpajaxgrid/examples/');

  
  define('XAJAX_PATH', ROOT."xajax/");
  
  define('XAJAX_PATH_URL', BASE_URL."xajax/");
  
  define('XAJAX_SERVER_PATH', ROOT."xajaxServer/");
  
  define('XAJAX_SERVER_PATH_URL', BASE_URL."xajaxServer/");
  
  define('JS_PATH_URL', BASE_URL."js/");

  define('AJAX_GRID_PATH', ROOT."freelancesoft/common/ajaxGrid/");
  
  define('AJAX_GRID_PATH_URL', BASE_URL."freelancesoft/common/ajaxGrid/");
  
  define('CSS_PATH', ROOT."style/");
  
  define('CSS_PATH_URL', BASE_URL."style/");
  
  define('IMAGE_PATH', ROOT."images/");

  define('IMAGE_PATH_URL', BASE_URL."images/");

  date_default_timezone_set('America/Argentina/Buenos_Aires'); // For no warning

  // delete if you use custom exceptions, then add DBException
  class DBException extends Exception{
  	
  }
?>