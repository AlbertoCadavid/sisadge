<?php include('../lang.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $proyect_title; ?></title>
<link rel="stylesheet" href="http://freelance-soft.com/templates/proyect.css" media="screen" type="text/css" />
<?php echo $proyect_html_head; ?>
</head>

<body>

<div id="contenedor">
<div id="cabecera">
   <span class="Titulo"><a style="color:#0066CC; text-decoration: none;" href="http://www.freelance-soft.com">Freelance Soft</a></span> 
   <span class="TituloProyecto"><?php echo $proyect_title; ?></span>
<span class="Idiomas">
     <FORM action="http://translate.google.com/translate">  
      <input type="hidden" size=55 value="<? echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" name="u"> 
      <SELECT name="langpair"> 
         <option value="es|en">English</option> 
       </SELECT>
       <INPUT type="hidden" value="es" name="hl">
       <INPUT type="hidden" value="UTF-8" name="ie">
       <INPUT type="hidden" value="UTF-8" name="oe">
       <INPUT type="hidden" value="/language_tools" name="prev">
       <INPUT type="submit" value="Google Translator">
      </FORM>
   </span> 
</div>
<div id="contenido">
         <h1><?php echo $proyect_section_title; ?></h1>
         <p><?php echo $proyect_text; ?></p>
  </div>
<div id="navegacion">
   <?php 
      
	   foreach($proyect_menu as $proyect_menu_title => $proyect_menu_array){
	       echo "<h2>$proyect_menu_title</h2>\n<ul>\n";
		   foreach($proyect_menu_array as $proyect_menu_item => $link){
		          echo "<li><a href=\"$link\">$proyect_menu_item</a></li>\n";
		   }
		   echo "</ul>\n";	      
	   }
	   
   
   ?>
   <h2>Lista de Proyectos</h2>
   <ul>
   <li><a href="../phpajaxgrid/">PHP Ajax Grid</a></li>
   <li><a href="../fdesktop/">FDesktop</a></li>
    <li><a href="../filemanager/">Web File Manager</a></li>
   </ul>
<div style="font-size: 11px; color: #666666;">
     <div align="left">Este software es de <strong>distribuci&oacute;n libre y gratuita</strong>, puedes ayudar a que siga creciendo enviandonos una donaci&oacute;n:
     </div>
     <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
       <div align="center">
  <input type="hidden" name="cmd" value="_s-xclick">
  <input type="image" src="https://www.paypal.com/es_XC/i/btn/x-click-but04.gif" border="0" name="submit" alt="Apoya este proyecto realizando una donación de monto que desees.">
  <img alt="" border="0" src="https://www.paypal.com/es_XC/i/scr/pixel.gif" width="1" height="1">
  <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
       </div>
     </form>
   </div>
</div>
</div>
</body>
</html>
