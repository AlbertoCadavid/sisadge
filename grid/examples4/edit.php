<?php
sleep(1);
$data = $_POST['value'];
$field = $_POST['value'];

$conexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
$update = "UPDATE `users3` SET `'".$field."'`='".$data."' WHERE id=1";
$conexion->query($update);
echo $data;
?>