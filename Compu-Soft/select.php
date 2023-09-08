<!--INICIO  construccion del select con los nombres de los PROVEEDORES !-->
	<?php
		$sql_mov = "SELECT DISTINCT `modelo` FROM `equipos` ORDER BY `modelo` ASC ";
		$result_mov = mysql_query($sql_mov);
		$options_mov = '';
		while ($row_mov = mysql_fetch_array($result_mov))
			{	$options_mov = $options_mov.'<option value="'.$row_mov['modelo'].'">'.$row_mov['modelo'].'</option>'; }
	?> 
<!--FIN  construccion del select con los nombres de los PROVEEDORES !-->

<!--INICIO  construccion del select con los nombres de los PROVEEDORES !-->
	<?php
		$sql_mov2 = "SELECT DISTINCT `serv_modelo` FROM `mov_servicios` ORDER BY `serv_modelo` ASC ";
		$result_mov2 = mysql_query($sql_mov2);
		$options_mov2 = '';
		while ($row_mov2 = mysql_fetch_array($result_mov2))
			{	$options_mov2 = $options_mov2.'<option value="'.$row_mov2['modelo'].'">'.$row_mov2['modelo'].'</option>'; }
	?> 
<!--FIN  construccion del select con los nombres de los PROVEEDORES !-->

<?php
// INICIO  construccion consulta de de los ARTICULOS-->
//$articulo = $_POST['criterio'];  WHERE art_id = '$articulo'
$sql_prd = "SELECT DISTINCT `modelo` FROM `equipos` ORDER BY `modelo` ASC "; 
	      $result_prd = mysql_query($sql_prd); 
	      $options_prd = ''; 
	    while ($row_prd = mysql_fetch_array($result_prd))
		{	$options_prd = $options_prd.'<option value="'.$row_prd['modelo'].'">'.$row_prd['modelo'].'</option>'; }
// FIN  construccion consulta de de los ARTICULOS-->
?>

<?php
// INICIO  construccion consulta de de los ARTICULOS-->
$sql_marca = "SELECT DISTINCT `marca` FROM `equipos` ORDER BY `marca` ASC "; 
	      $result_marca = mysql_query($sql_marca); 
	      $options_marca = ''; 
	    while ($row_marca = mysql_fetch_array($result_marca))
		{	$options_marca = $options_marca.'<option value="'.$row_marca['marca'].'">'.$row_marca['marca'].'</option>'; }
// FIN  construccion consulta de de los ARTICULOS-->
?>


<?php
// INICIO  construccion consulta de de los ARTICULOS-->
$sql_cliente = "SELECT DISTINCT `cliente` FROM `equipos` ORDER BY `cliente` ASC "; 
	      $result_cliente = mysql_query($sql_cliente); 
	      $options_cliente = ''; 
	    while ($row_cliente = mysql_fetch_array($result_cliente))
		{	$options_cliente = $options_cliente.'<option value="'.$row_cliente['cliente'].'">'.$row_cliente['cliente'].'</option>'; }
// FIN  construccion consulta de de los ARTICULOS-->
?>

<?php
// INICIO  construccion consulta de de los ARTICULOS-->
$sql_cliente2 = "SELECT DISTINCT `abono_cliente` FROM `abonos` ORDER BY `abono_cliente` ASC "; 
	      $result_cliente2 = mysql_query($sql_cliente2); 
	      $options_cliente2 = ''; 
	    while ($row_cliente2 = mysql_fetch_array($result_cliente2))
		{	$options_cliente2 = $options_cliente2.'<option value="'.$row_cliente2['abono_cliente'].'">'.$row_cliente2['abono_cliente'].'</option>'; }
// FIN  construccion consulta de de los ARTICULOS-->
?>


