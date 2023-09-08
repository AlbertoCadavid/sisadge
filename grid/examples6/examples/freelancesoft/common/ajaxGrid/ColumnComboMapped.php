<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *    Representa una fila de la grilla mapeada a una propiedad del objeto
 * 	  que intenta mostrarse en la misma.
 *    
 */

class ColumnComboMapped extends FilteredColumn {
	
	private $_fields;
	private $_format;
	private $_table;
	private $_value;
	private $_content;
	private $_valueSelected;
	private $_sortExpresion;
	private $_width;
	private $_data;
	
	/**
	 * Actualiza valores del combo.
	 */
	function actualizeData(){
		$query = 
			"SELECT
				{$this->_value},
				{$this->_content}
			FROM
				{$this->_table}
			WHERE 1;";
		$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
		if (mysqli_connect_errno()) {
			throw new Exception(mysqli_connect_error());
		}
		$result = mysqli_query($link, $query);
		if(!$result){
			throw new DBException('Error en el Acceso a datos: ' . mysqli_connect_error());
		}
		$this->_data = array();
		while ($result && $obj = mysqli_fetch_row($result)){
			$this->_data[$obj[0]] = $obj[1];
		}
	}
	
	/**
	 * Obtiene el Html para el combo.
	 * 
	 * @param array[string] $actualRow
	 * 
	 * @return string
	 */
	function getHtml($actualRow){
		$ret = vsprintf($this->_format,AjaxGrid::getFieldsMapped($this->getFields(),$actualRow));
		$options = '';
		foreach ($this->_data as $key => $value) {
			if($actualRow[$this->_valueSelected] == (string)$key){
				$key = htmlspecialchars($key);
				$value = htmlspecialchars($value);
				$options .= "<option value=\"{$key}\" selected=\"selected\">{$value}</option>";
			}
			else{
				$key = htmlspecialchars($key);
				$value = htmlspecialchars($value);
				$options .= "<option value=\"{$key}\">{$value}</option>";
			}
		}
		return str_replace('{$options}',$options,$ret);
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
		$this->_method = $method;
	}
	
	/**
	 * Determina si esta columna se puede ordenar.
	 *
	 * @return Boolean
	 */
	public function isSortable(){
		return ($this->_sortExpresion != NULL);
	}
	
	/**
	 * Obtiene el formato a aplicar sobre la columna.
	 *
	 * @return string
	 */
	public function getFormat(){
		return $this->_format;
	}
	
	/**
	 * Actualiza el formato.
	 *
	 * @param string $format Nuevo formato
	 */
	public function setFormat($format){
		$this->_format = $format;
	}
	
	/**
	 * Obtiene el campo para value de las opciones.
	 *
	 * @return string
	 */
	public function getValue(){
		return $this->_value;
	}
	
	/**
	 * Actualiza el campo para value de las opciones.
	 *
	 * @param string $value Nuevo valor
	 */
	public function setValue($value){
		$this->_value = $value;
	}
	
	/**
	 * Obtiene el nombre de la tabla de la cual obtener las opciones.
	 *
	 * @return string
	 */
	public function getTable(){
		return $this->_table;
	}
	
	/**
	 * Actualiza el nombre de la tabla de la cual obtener las opciones.
	 *
	 * @param string $table Nuevo valor
	 */
	public function setTable($table){
		$this->_table = $table;
	}
	
	/**
	 * Obtiene el campo para contenido de las opciones.
	 *
	 * @return string
	 */
	public function getContent(){
		return $this->_content;
	}
	
	/**
	 * Actualiza el campo para contenido de las opciones.
	 *
	 * @param string $content Nuevo contenido
	 */
	public function setContente($content){
		$this->_content = $content;
	}
	
	/**
	 * Obtiene el campo para comparar con value.
	 *
	 * @return string
	 */
	public function getValueSelected(){
		return $this->_valueSelected;
	}
	
	/**
	 * Actualiza el campo para comparar con value.
	 *
	 * @param string $value Nuevo valor
	 */
	public function setValueSelected($value){
		$this->_valueSelected = $value;
	}
	
	/**
	 * Obtiene el campo para ordenar.
	 *
	 * @return string
	 */
	public function getSortExpresion(){
		return $this->_sortExpresion;
	}
	
	/**
	 * Actualiza el campo para ordenar.
	 *
	 * @param string $value Nuevo valor
	 */
	public function setSortExpresion($value){
		$this->_sortExpresion = $value;
	}
	
	/**
	 * Obtiene el ancho de la columna.
	 *
	 * @return string
	 */
	public function getWidth(){
		return $this->_width;
	}
	
	/**
	 * Actualiza el ancho de la columna.
	 *
	 * @param string $width Nuevo ancho, ejemplo 10% 2px
	 */
	public function setWidth($width){
		$this->_width = $width;
	}
	
	/**
	 * Obtiene <nombre-tabla>.<nombre-campo1> $order, <nombre-tabla>.<nombre-campo2> $order, ...
	 * Sirve para la clausula ORDER BY
	 * 
	 * @param string $order
	 * 
	 * @return string
	 */
	function getOrderBystring($order){
		return "$this->_sortExpresion {$order}";
	}
	
	/**
	 * Constructor de Columnas.
	 *
	 * @param array[string] $fields campos de tabla a mostrar, deben respetar la forma <tabla>.<campo> 
	 * @param string $format formato a aplicar sobre lo que retornan los metodos
	 * @param string $table <tabla>.<campo> de la cual obtener las opciones
	 * @param string $value <tabla>.<campo> para poner en el value de las opciones combo
	 * @param string $content <tabla>.<campo> para poner en el contenido de las opciones combo
	 * @param string $valueSelected <tabla>.<campo> valor con el que comparar value para determinar la opción seleccionada
	 * @param string $sortExpresion <tabla>.<campo> por la cual ordenar
	 * @param string $width ancho de la columna, ejemplo 10% 2px
	 * @param bool $filter determina si esta columna permite filtrado
	 */
	public function __construct($format = '<select>{$options}</select>', $table, $value, $content, $valueSelected = NULL, $fields = array(), $sortExpresion = NULL, $width = NULL, $filter = false){
		$this->_format = $format;
		$this->_table = $table;
		$this->_value =$value;
		$this->_content = $content;
		$this->_valueSelected = $valueSelected; 
		$this->_fields = $fields;
		$this->_sortExpresion = $sortExpresion;
		$this->_width = $width;
		$this->_isFilteredColumn = $filter;
	}

}

?>