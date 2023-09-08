<?php require_once('Connections/conexion1.php'); ?>
<?php
$id_proceso = $_POST['id_proceso'];
$codigo = $_POST['codigo'];
$result = $conexion->query("SELECT cl.id_rtp AS id,cl.nombre_rtp FROM tipo_procesos c
                            LEFT JOIN tbl_reg_tipo_desperdicio cl ON (cl.codigo_rtp='$codigo' AND cl.id_proceso_rtd = c.id_tipo_proceso)
                            WHERE cl.id_proceso_rtd = ".$id_proceso." ORDER BY cl.nombre_rtp ASC");
if ($result->num_rows > 0) {
	echo $Todos="<option value='Todos'>Todos</option>";
    while ($row = $result->fetch_assoc()) { 
	                              
        $html .= '<option value="'.$row['id'].'">'.$row['nombre_rtp'].'</option>';
    }
}
echo $html;
?>
 