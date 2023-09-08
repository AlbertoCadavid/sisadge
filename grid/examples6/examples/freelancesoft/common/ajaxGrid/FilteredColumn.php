<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *    Represents a column that can be filtered.
 *    
 */
 
 class FilteredColumn{
 	protected $_isFilteredColumn;
 	protected $_filterActive;
 	protected $_filterString;
 	protected $_isCustomFilter;
 	
 	/**
 	 * Returns true if de column allow filters.
 	 *
 	 * @return bool
 	 */
 	public function isFilteredColumn(){
 		return $this->_isFilteredColumn;
 	}
 	
 	/**
 	 * Sets filter active.
 	 *
 	 * @param bool $val
 	 */
 	public function setFilterActive($val){
 		$this->_filterActive = $val;
 	}
 	
 	/**
 	 * Gets filter active.
 	 *
 	 * @return bool
 	 */
 	public function isFilterActive(){
 		return $this->_filterActive;
 	}
 	
 	/**
 	 * Gets filter string.
 	 *
 	 * @return string
 	 */
 	public function getFilterString(){
 		return $this->_filterString;
 	}
 	
 	/**
 	 * Sets filter string.
 	 *
 	 * @param string $val
 	 */
 	public function setFilterString($val){
 		$this->_filterString = $val;
 	}
 	
 	/**
 	 * Sets custom filter.
 	 *
 	 * @param bool $val
 	 */
 	public function setCustomFilter($val){
 		$this->_isCustomFilter = $val;
 	}
 	
 	/**
 	 * Gets custom filter.
 	 *
 	 * @return bool
 	 */
 	public function isCustomFilter(){
 		return $this->_isCustomFilter;
 	}
 }

?>