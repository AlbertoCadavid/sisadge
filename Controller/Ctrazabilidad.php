<?php 
require './Models/Mtrazabilidad.php';
class CtrazabilidadController
{

public function inicioVista()
    {
        $vista = 'view_trazabilidad_producto.php';
        self::Cvista($vista);
    }


    public function Cvista($vista = '')
    {
        if ($vista) {
            require_once("views/" . $vista);  //header('Location:'.$vista);  
        } else {
            require_once("views/view_trazabilidad_producto.php?");
        };
    }

    public function stateCreate(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlExtruder = $conexion->searchFields("tbl_orden_produccion", "WHERE id_op = $_POST[op] ", " ", "*"); 
            $info = json_encode($sqlExtruder);
            echo $info;
        }
    }

    public function stateExtrusion(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlExtruder = $conexion->getManyResults("tblextruderrollo", "WHERE id_op_r = $_POST[op] ", "order by rollo_r asc ", "*"); 
            $info = json_encode($sqlExtruder);
            echo $info;
        }
    }

    public function stateimpresion(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlimpresion = $conexion->getManyResults("tblimpresionrollo", "WHERE id_op_r = $_POST[op] ", "order by rollo_r asc ", "*"); 
            $info = json_encode($sqlimpresion);
            echo $info;
        }
    }

    public function stateSellado(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlSellado = $conexion->getManyResults("tblselladorollo", "WHERE id_op_r = $_POST[op] ", "order by rollo_r asc ", "*"); 
            $info = json_encode($sqlSellado);
            echo $info;
        }
    }
}

?>