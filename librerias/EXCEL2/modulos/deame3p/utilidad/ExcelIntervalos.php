<?php
include_once( DIR_OPET . DIR_UTILI . 'PHPExcel/Reader/IReadFilter.php');

/**
 * Descripcion de ExcelIntervalos
 *
 * @author      Marcelo Castro
 * @package     ExcelIntervalos creado en el projecto DEAME3P
 * @copyright   2010 - ObjetivoPHP
 * @license     Gratuito (Free) http://www.opensource.org/licenses/gpl-license.html
 * @author      Marcelo Castro (ObjetivoPHP)
 * @link        objetivophp@gmail.com
 * @link        http://objetivophp.com
 * @version     0.1.0 (27/11/2010 - 27/11/2010)
 */
class ExcelIntervalos implements PHPExcel_Reader_IReadFilter
{
    /**
     * Contiene hasta cual columna se exportara.
     * @var integer
     */
    private $_colLimite;

    /**
     * Contiene cuales filas se exportaran la primera es el titulo.
     * @var array
     */
    private $_intervalos = array();

    /**
     * Metodo __construct.
     * Constuye la instancia que se encargara de exportar por intervalos.
     * @param   integer $columna    Columna hasta la cual se exportara.
     * @param   array   $intervalos Intervalos de exportacion.
     * @return  void
     */
    public function __construct($columna, array $intervalos)
    {
        $this->_colLimite   = (int) $columna;
        $this->_intervalos  = $intervalos;
    }

    /**
     * Metodo readCell.
     * Dice si una celda se debe exportar o no.
     * @param   integer $column         Numero de columna.
     * @param   integer $row            Numero de fila.
     * @param   string  $worksheetName  Nombre de la hoja a exportar.
     * @return  boolean true se exporta la celda, false no se exporta.
     */
    public function readCell($column, $row, $worksheetName = '')
	{

        //if ($column <= $this->_colLimite) {
            foreach ($this->_intervalos as $intervalo) {
                if ($intervalo[0]<= $row && $row <= $intervalo[1]) {
                    
                    return true;
                }
            }
        //}
		return false;
	}
}
