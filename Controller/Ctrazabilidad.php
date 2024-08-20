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
            /* $sqlExtruder = $conexion->getManyResults("tblextruderrollo", "WHERE id_op_r = $_POST[op] ", "order by rollo_r asc ", "*");  */
            $sqlExtruder = $conexion->getManyResults("tblextruderrollo  t1", "JOIN (
                SELECT rollo_r, MAX(fechaF_r) AS max_fechaF_r
                FROM tblextruderrollo
                WHERE id_op_r = $_POST[op]
                GROUP BY rollo_r
            ) t2 ON t1.rollo_r = t2.rollo_r AND t1.fechaF_r = t2.max_fechaF_r WHERE t1.id_op_r = $_POST[op] ", "ORDER BY t1.rollo_r ASC ", "t1.*"); 
            $info = json_encode($sqlExtruder);
            echo $info;
        }
    }

    public function stateimpresion(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlimpresion = $conexion->getManyResults("tblimpresionrollo", "WHERE id_op_r = $_POST[op] ", "ORDER BY fechaF_r ASC", "*"); 
            $info = json_encode($sqlimpresion);
            echo $info;
        }
    }

    /* FUNCION PARA SABER SI AL MENOS YA SE HA NUMERADO UN PAQUETE ASI NO HALLAN LIQUIDADO ROLLO EN SELLADO PARA SABER LA FECHA EN QUE SE EMPEZO A TIQUETAR */
    /* public function stateSellado(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlLlegadaSellado = $conexion->searchFields("tbl_numeracion", "WHERE int_op_n = $_POST[op]", "", "fecha_ingreso_n as fecha_ingreso");
            $existe = json_encode($sqlLlegadaSellado);

            $sqlSellado = $conexion->getManyResults("tblselladorollo", "WHERE id_op_r = $_POST[op] ", "ORDER BY fechaF_r ASC", "*"); 
            $infoSellado = json_encode($sqlSellado);
            
            $response = [
                'existe' => $existe, 
                'infoSellado' => $infoSellado
            ];
            echo json_encode($response);
        }
    } */

    public function stateSellado(){
        $conexion = new Mtrazabilidad();
        if(isset($_POST['op'])){
            $sqlSellado = $conexion->getManyResults("tblselladorollo", "WHERE id_op_r = $_POST[op] ", "ORDER BY fechaF_r ASC", "*"); 
            $info = json_encode($sqlSellado);
            echo $info;
        }
    }
}

?>