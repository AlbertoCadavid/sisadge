<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *   Representa una columna de la grilla mapeada a una propiedad del objeto
 *   que intenta mostrarse en la misma.
 *    
 */

class ColumnMapped extends FilteredColumn {
	
	private $_fields;
	private $_format;
	private $_sortable;
	private $_width;
	private $_changeValues;
	
	private function foundNewValue($dbValue){
		foreach ($this->_changeValues as $oldValue => $newValue) {
			if($oldValue == $dbValue){
				return $newValue;
			}
		}
		return $dbValue;
	}
	
	/**
	 * Obtiene los nombres de métodos a invocar sobre el objeto de la lista
	 * para mostrar en esta columna.
	 *
	 * @return Array Arreglo de strings con nombres de métodos
	 */
	public function getfields(){
		return $this->_fields;
	}
	
	/**
	 * Actualiza el nombre del metodo a invocar sobre el objeto de la lista
	 * para mostrar en esta columna.
	 *
	 * @param String $method Nuevo nombre
	 */
	public function setfields($fields){
		$this->_fields = $fields;
	}
	
	/**
	 *
	 * @return Array Arreglo de con valores a cambiar por los que se obtiene de la BD
	 */
	public function getChangeValues(){
		return $this->_changeValues;
	}
	
	/**
	 *
	 * @param Array $fields Nuevo Arreglo de con valores a cambiar por los que se obtiene de la BD
	 */
	public function setChangeValues($change){
		$this->_changeValues = $change;
	}
	
	/**
	 * Determina si esta columna se puede ordenar.
	 *
	 * @return Boolean
	 */
	public function isSortable(){
		return $this->_sortable;
	}
	
	/**
	 * Actualiza el valor que determina si la columna se puede ordernar.
	 *
	 * @param Boolean $sortable Nuevo valor
	 */
	public function setSortable($sortable){
		$this->_sortable = $sortable;
	}
	
	/**
	 * Obtiene el formato a aplicar sobre la columna.
	 *
	 * @return String
	 */
	public function getFormat(){
		return $this->_format;
	}
	
	/**
	 * Actualiza el formato.
	 *
	 * @param String $format Nuevo formato
	 */
	public function setFormat($format){
		$this->_format = $format;
	}
	
	/**
	 * Obtiene el ancho de la columna.
	 *
	 * @return String
	 */
	public function getWidth(){
		return $this->_width;
	}
	
	/**
	 * Actualiza el ancho de la columna.
	 *
	 * @param String $width Nuevo ancho, ejemplo 10% 2px
	 */
	public function setWidth($width){
		$this->_width = $width;
	}
	
	/**
	 * Obtiene <nombre-tabla>.<nombre-campo1> $order, <nombre-tabla>.<nombre-campo2> $order, ...
	 * Sirve para la clausula ORDER BY
	 * 
	 * @param String $order
	 * 
	 * @return String
	 */
	function getOrderByString($order){
		$ret = '';
		$countF = count($this->_fields);
		for($i = 0; $i < $countF - 1; $i++){
			$ret .= "{$this->_fields[$i]} {$order}, ";
		}
		if($countF > 0){
			$ret .= "{$this->_fields[$countF-1]} {$order}";
		}
		$ret = $ret == '' ? '0' : $ret;
		return $ret;
	}
	
	/**
	 * Cambia uno o más valores de la BD
	 *
	 * @param array $value
	 * @return array Valor cambiado
	 */
	function getValuesChanged($value){
		$ret = array();
		foreach ($value as $fieldName => $fieldValue) {
			$ret[$fieldName] = $this->foundNewValue($fieldValue);
		}
		return $ret;		
	}
	
	/**
	 * Constructor de Columnas.
	 *
	 * @param array $fields campos de tabla a mostrar, deben respetar la forma <tabla>.<campo> 
	 * @param String $format formato a aplicar sobre lo que retornan los metodos
	 * @param Boolean $sortable determina si la columna se puede ordenar
	 * @param String $width ancho de la columna, ejemplo 10% 2px
	 * @param bool $filter determina si esta columna permite filtrado
	 * @param array $changeValues
	 */
	public function __construct($format = "%s", $fields = array(), $sortable = false, $width = NULL, $filter = false, $changeValues = array()){
		$this->_fields = $fields;
		$this->_format = $format;
		$this->_sortable = $sortable;
		$this->_width = $width;
		$this->_isFilteredColumn = $filter;
		$this->_changeValues = $changeValues;
	}

}

?>