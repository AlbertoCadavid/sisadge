<?php

/**
 * Clase MiClase.
 * Responsabilidad de la clase.
 *
 * @package     General creado en el projecto deame3p_v5.3.1
 * @copyright   2012 - ObjetivoPHP
 * @license     Gratuito (Free) http://www.opensource.org/licenses/gpl-license.html
 * @author      Marcelo Castro (ObjetivoPHP)
 * @link        objetivophp@gmail.com
 * @version     1.0.0 (05/01/2012 - 06/01/2012)
 */
class MiClase
{
    
    private $md5 = false;
    
    /**
     * Rutina de inicio de la exportacion, se ejecuta antes de comenzar a exportar 
     * todas las filas de la planilla excel, se puede usar para configurar algo
     * necesario para ser usado en los demas campos.
     * en el sistema.
     * No recibe Parametros y Tampoco Retorna.
     */
    public function deame3p_inicio()
    {
        $this->md5 = (isset($_SESSION['md5']))? $_SESSION['md5'] : false;
    }
    
    /**
     * Rutina de Cierre de la exportacion, se ejecuta una vez que se exportaron
     * todas las filas de excel a Mysql. Util para enviar un mensaje de correo
     * electronico de finalizacion de la exportacion.
     * No recibe Parametros y tampoco retorna.
     */
    public function deame3p_final()
    {
          echo '</br>Envio Correo';
    }
    
    /**
     * Se ejecuta Al finalizar de exportar cada fila, y se puede utilizar por ejemplo.
     * para enviar correos de alta.
     * @param array     $valores    Arreglo que contiene nombre de campo y valor de
     *                              cada uno de los campos.
     * @param boolean   $resultado  true/false segun la consulta de exportacion
     *                              fue exitosa o no.
     */
    public function deame3p_fila(Array $valores, $resultado)
    {
        echo ($resultado)? "Bien" : "Mal";
    }
}