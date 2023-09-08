<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *    Describes a Data Base Query.
 *    
 */

class DBQueryDescriptor{
	
	// Join types
	public static $MAIN_TABLE = "MAIN TABLE";
	public static $INNER_JOIN = "INNER JOIN";
	public static $LEFT_JOIN = "LEFT JOIN";
	public static $RIGHT_JOIN = "RIGHT JOIN";
	
	private $_tableName;
	private $_columnsNames;
	private $_joinType;
	private $_joinCondition;
	private $_distinct;
	private $_notSelect;
	
//	/**
//	 * Actualiza el nombre de tabla.
//	 *
//	 * @param String $tableName nuevo nombre
//	 */
//	function setTableName($tableName){
//		$this->_tableName = $tableName;
//	}
//	
//	
//	/**
//	 * Actualiza los nmbres de columnas.
//	 *
//	 * @param array $columnName nuevos nombres
//	 */
//	function setColumnsNames($columnsNames){
//		$this->_columnsNames = $columnName;
//	}
//	
//	
//	/**
//	 * Actualiza el tipo de JOIN.
//	 *
//	 * @param String $join nuevo JOIN
//	 */
//	function setJoinType($join){
//		$this->_joinType = $join;
//	}
//	
//	/**
//	 * Obtiene el tipo de JOIN
//	 *
//	 * @return String
//	 */
//	function getJoinType(){
//		return $this->_joinType;
//	}

	/**
	 * Obtiene los nombres de columnas.
	 *
	 * @return array
	 */
	function getColumnsNames(){
		return $this->_columnsNames;
	}
	
	/**
	 * Obtiene el nombre de tabla.
	 *
	 * @return String
	 */
	function getTableName(){
		return $this->_tableName;
	}
	
	/**
	 * Obtiene los nombres de columnas qeu no deben estar en la cláusula select.
	 *
	 * @return array
	 */
	function getNotSelect(){
		return $this->_notSelect;
	}
	
	/**
	 * Setea los nombres de columnas qeu no deben estar en la cláusula select.
	 *
	 * @param array $names
	 */
	function setNotSelect($names){
		$this->_notSelect = $names;
	}

	/**
	 * Retorna una concatenación de <nombre_tabla>.<nombre_campo>
	 * 
	 * @return String
	 */
	function getFieldsForSelect(){
		$tableName = $this->_tableName;
		if($this->_distinct){
			$ret = "DISTINCT ";
		}
		else{
			$ret = "";
		}
		foreach($this->_columnsNames as $col){
			if(!in_array("{$tableName}.{$col}",$this->_notSelect)){
				$ret .= "{$tableName}.{$col} AS {$tableName}_{$col},\n";
			}
		}
		return $ret;
	}
	
	/**
	 * Obtiene un string que representa un FROM o JOIN.
	 * 
	 * @return String
	 */
	function getFromOrJoin(){
		if($this->_joinType == DBQueryDescriptor::$MAIN_TABLE){
			$ret = "FROM {$this->_tableName}\n";
		}
		else{
			$ret = "{$this->_joinType} {$this->_tableName} ON {$this->_joinCondition}\n";
		}
		return $ret;
	}
	
	function getDefaultSortBy(){
		return "{$this->_tableName}.{$this->_columnsNames[0]}";
	}
	
	/**
	 * Constructor
	 *
	 * @param String $tableName nombre de tabla
	 * @param array $columnsNames nombres de campos
	 * @param String $joinType se debe usar una de las constantes, por defaul toma MAIN_TABLE
	 */
	function __construct($tableName,$columnsNames,$joinType = "MAIN TABLE",$joinCondition = NULL, $distinct = FALSE, $notSelect = array()){
		$this->_tableName = $tableName;
		$this->_columnsNames = $columnsNames;
		$this->_joinType = $joinType;
		$this->_joinCondition = $joinCondition;
		$this->_distinct = $distinct;
		$this->_notSelect = $notSelect;
	}
}
?>