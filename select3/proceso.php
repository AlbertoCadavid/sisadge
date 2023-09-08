<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
require (ROOT_BBDD); 
?> 
<?php
//include 'config.php';

$conexion = new ApptivaDB();

 

// Numero de registros
//$numero_de_registros = 10;

 

$row_ano = $conexion->llenaCombos($_POST['var1'],$_POST['palabraClave'],$_POST['var2'],$_POST['var3'],$_POST['var4'],$_POST['var5'],$_POST['var6']); 
/*
if(!isset($_POST['palabraClave'])){

	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM usuarios ORDER BY nombres LIMIT :limit");
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$usersList = $stmt->fetchAll();

}else{

	$search = $_POST['palabraClave'];// Palabra a buscar
	
	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM usuarios WHERE nombres like :nombres ORDER BY nombres LIMIT :limit");
	$stmt->bindValue(':nombres', '%'.$search.'%', PDO::PARAM_STR);
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$usersList = $stmt->fetchAll();

}
	
$response = array();

// Leer la informacion
foreach($usersList as $user){
	$response[] = array(
		"id" => $user['id'],
		"text" => $user['nombres']
	);
}

echo json_encode($response);
exit();*/