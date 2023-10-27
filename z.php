<?php
 require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
 require (ROOT_BBDD); 
 

$conexion = new ApptivaDB();
if($_POST['nombre']){
$query = "INSERT INTO `a1`(`nombre`) VALUES ('$_POST[nombre]')";
$conexion->query($query, "$_POST[lugar]");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <label for="">Nombre</label>
        <input type="text" id="nombre" name="nombre">
        <label for="">Lugar</label>
        <input type="text" id="lugar" name="lugar">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

