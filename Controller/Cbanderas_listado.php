<?php

//Llamada al modelo
include("./Models/Mbanderas_listado.php");

class Cbanderas_listadoController
{

    public function mostrarListado($maxRows_registros, $pageNum_registros)
    {

        $objMmostrarListado = new Mbanderas_listado();
        $busqueda = $_GET['busqueda'];
        $valor = $_GET["valor"];

        if (isset($busqueda)) {
            switch ($busqueda) {
                case 'id_op':
                    return $objMmostrarListado->mostrarListado("WHERE $busqueda = $valor", "", $maxRows_registros, $pageNum_registros);
                    break;
                case 'proceso':
                    return $objMmostrarListado->mostrarListado("WHERE $busqueda = $valor", "", $maxRows_registros, $pageNum_registros);
                    break;
                case 'nombre_empleado':
                    return $objMmostrarListado->mostrarListado("WHERE $busqueda LIKE '%$valor%'", "", $maxRows_registros, $pageNum_registros);
                    break;

                default:
                    return $objMmostrarListado->mostrarListado("", "", $maxRows_registros, $pageNum_registros);

                    break;
            }
        } else {
            return $objMmostrarListado->mostrarListado("", "", $maxRows_registros, $pageNum_registros);
        }
    }

    public function contarListado($busqueda, $valor){
        $objcontarListado = new Mbanderas_listado();
        return $objcontarListado->contarListado("WHERE $busqueda = $valor", "tbl_banderas");
    }

    public function inicioListado()
    {
        $vista = 'view_banderas_listado.php';
        self::Cvista($vista);
    }


    public function Cvista($vista = '')
    {
        if ($vista) {
            require_once("views/" . $vista);  //header('Location:'.$vista);  
        } else {
            require_once("views/view_banderas_listado.php?");
        }
    }
}
