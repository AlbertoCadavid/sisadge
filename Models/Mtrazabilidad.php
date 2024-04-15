<?php
class Mtrazabilidad
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }

    //return one result
    public function searchFields($table, $condition, $order = '', $distinct = '')
    {
        //echo "SELECT $distinct FROM $table $condition $order ";die;
        $result = $this->conexion->query("SELECT $distinct FROM $table $condition $order ") or die($this->conexion->error);
        if ($result)
            $fila = $result->fetch_assoc(); //mysqli_fetch_assoc($resultado)
        $total = $fila;
        return $total;
        return false;
        $result->free();
        $result->close();
    }

     //return some results 
     public function getManyResults($tabla, $condicion = '', $orden = '')
     {
         $resultado = $this->conexion->query("SELECT * FROM $tabla $condicion $orden ") or die($this->conexion->error);
         if ($resultado)
             //return $resultado->fetch_array(MYSQLI_BOTH);//MYSQLI_BOTH muestra numerico y asociativo 
             return self::getResultados($resultado);
         return false;
         $resultado->free();
         $resultado->close();
     }

     public function getResultados($arreglo)
    {
        $rows = array();
        while ($row = $arreglo->fetch_array(MYSQLI_BOTH)) //MYSQLI_ASSOC array asociativo, MYSQLI_NUM array numérico
        {
            $rows[] = $row;
        }

        return $rows;
    }
}
