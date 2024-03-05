<?php

class Mbanderas_listado
{
    
    public $db;

    public function __construct(){ 

    }

    public function mostrarListado($condicion = "", $condicion2 = "", $maxRows_registros,$pageNum_registros)
    {
        $startRow_registros = $pageNum_registros * $maxRows_registros;
        $this->db = Conectar::conexion();

        try {
            $query = "SELECT tb.id_op, tp.nombre_proceso, tb.rollo_r, tb.nombre, tb.metros, tb.metros_rollo, emp.nombre_empleado, emp.apellido_empleado, tb.fecha_verificacion, tb.visto 
                        FROM tbl_banderas as tb 
                        INNER JOIN tipo_procesos as tp 
                            ON (tb.proceso = tp.id_tipo_proceso) 
                        LEFT JOIN empleado as emp
                            ON (tb.operario_verificacion = emp.codigo_empleado)
                            $condicion 
                        ORDER BY tb.id_op DESC, tb.rollo_r ASC  LIMIT $startRow_registros, $maxRows_registros; ";
            
            $listado = $this->db->query($query);
            $rows = [];
            while ($row = $listado->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }

    public function contarListado($condicion = "", $tabla)
    {
        $this->db = Conectar::conexion();
        $resultado = $this->db->query("SELECT COUNT(*) FROM $tabla $condicion") or die($this->conexion->error);
        if($resultado)
          $resultfin = $resultado->fetch_row(); 
        return $resultfin[0];
        return false;
        $resultado->free();
        $resultado->close();
    }
}
