<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *   The core of php ajax grid. Representa una Grilla con ordenamiento y paginado,
 *   se actualiza con ajax al paginar u ordenar.
 *    
 */

class AjaxGrid{
	
	public static $ASC = "ASC"; // órden ascendente
	public static $DESC = "DESC";// órden descendente
	
	private $_queryDescriptors;
	private $_columns;
	private $_maxRows;
	private $_maxPageLinks;
	private $_actualRow;
	private $_actualSortBy;
	private $_actualSortDir;
	private $_actualSortedColumn;
	private $_data;
	private $_totalRows;
	private $_gridName;
	private $_cellpadding;
	private $_cellspacing;
	private $_border;
	private $_nullValue;
	private $_whereCondition;
	private $_filterMenuWidth;
	private $_filterMenuHeight;
	private $_filterAfect;
	private $_filterAfected;
	
	// templates
	private $_tp_previous;
	private $_tp_no_previous;
	private $_tp_next;
	private $_tp_no_next;
	private $_tp_first;
	private $_tp_no_first;
	private $_tp_last;
	private $_tp_no_last;
	private $_tp_page_link;
	private $_tp_actual_page_link;
	private $_tp_navigation_bar;
	private $_tp_grid;
	private $_tp_rowsInfo;
	private $_tp_rowsInfo_empty;
	private $_tp_rowsPerPage;
	private $_tp_loading;
	private $_tp_filter_menu_clear_item;
	private $_tp_custom_filter;
	
	// estilos
	private $_css_table;
	private $_css_sortable;
	private $_css_sorted;
	private $_css_sorted_asc;
	private $_css_sorted_desc;
	private $_css_odd;
	private $_css_even;
	private $_filter_button;
	private $_filtered_button;
	private $_css_filter_menu;
	private $_css_filter_menu_item;
	private $_css_filter_menu_item_hover;
	
	private function getFieldsForSelect(){
		$ret = "";
		foreach($this->_queryDescriptors as $desc){
			$ret .= $desc->getFieldsForSelect();
		}
		return substr($ret,0,strlen($ret)-2);
	}
	
	private function getFromAndJoins(){
		$ret = "";
		foreach($this->_queryDescriptors as $desc){
			$ret .= $desc->getFromOrJoin();
		}
		return $ret;
	}
	
	private function getFiltersWhereCondition($link){
		$where = '';
		$firstFilter = true;
		foreach ($this->_columns as $col) {
			if($col->isFilteredColumn() && $col->isFilterActive()){
				$fields = $col->getFields();
				$filterString = mysqli_real_escape_string($link,urldecode($col->getFilterString()));
				if($col->isCustomFilter()){
					$condition = "{$fields[0]} LIKE '{$filterString}%' ";
				}
				else{
					$condition = "{$fields[0]} = '{$filterString}' ";
				}
				if($firstFilter){
					$where .= $condition;
					$firstFilter = false;
				}
				else{
					$where .= "AND {$condition} ";
				}
			}
		}
		return $where;		
	}
	
	private function getFilterDependentWhereCondition($link,$columnNumber){
		$where = '';
		$firstFilter = true;
		$keys = array_keys($this->_columns);
		$key = $keys[$columnNumber-1];
		if(array_key_exists($key,$this->_filterAfected)){
			foreach ($this->_filterAfected[$key] as $colName) {
				$column = $this->_columns[$colName];
				if($column->isFilteredColumn() && $column->isFilterActive()){
					$fields = $column->getFields();
					$filterString = mysqli_real_escape_string($link,urldecode($column->getFilterString()));
					if($column->isCustomFilter()){
						$condition = "{$fields[0]} LIKE '{$filterString}%' ";
					}
					else{
						$condition = "{$fields[0]} = '{$filterString}' ";
					}
					if($firstFilter){
						$where .= $condition;
						$firstFilter = false;
					}
					else{
						$where .= "AND {$condition} ";
					}
				}
			}
			
		}
		return $where;		
	}
	
	private function getQueryString($link){
		$where = $this->_whereCondition;
		$filtersWhere = $this->getFiltersWhereCondition($link);
		if($filtersWhere != ''){
			if($where == '1'){
				$where = $filtersWhere;
			}
			else{
				$where .= "AND {$filtersWhere}";
			}
		}
		return "SELECT SQL_CALC_FOUND_ROWS
					{$this->getFieldsForSelect()}
					{$this->getFromAndJoins()}
				WHERE {$where}
				ORDER BY {$this->_actualSortBy}
				LIMIT {$this->_actualRow}, {$this->_maxRows};
				SELECT FOUND_ROWS() AS total_rows;";
	}
	
	private function getQueryStringForFilter($link,$column,$columnNumber){
		$fields = $column->getFields();
		$where = $this->_whereCondition;
		$filtersWhere = $this->getFilterDependentWhereCondition($link,$columnNumber);
		if($filtersWhere != ''){
			if($where == '1'){
				$where = $filtersWhere;
			}
			else{
				$where .= "AND {$filtersWhere}";
			}
		}
		return "SELECT DISTINCT 
					{$fields[0]}
					{$this->getFromAndJoins()}
				WHERE {$where}
				ORDER BY {$fields[0]} ASC;";
	}
	
	private function getKeys(){
		$arrElems = "";
		$countQ = count($this->_queryDescriptors);
		for($iq = 0; $iq < $countQ; $iq++){
			$desc = $this->_queryDescriptors[$iq];
			$names =$desc->getColumnsNames();
			$countC = count($names);
			for($ic = 0; $ic < $countC; $ic++){
				if(($iq == $countQ -1) && ($ic == $countC -1)){
					$arrElems .= "'{$desc->getTableName()}.{$names[$ic]}'";
				}
				else{
					$arrElems .= "'{$desc->getTableName()}.{$names[$ic]}',";
				}
			}
		}
		eval('$arr = array('.$arrElems.');');
		return $arr;
	}
	
	private function filterNotInSelect($keys){
		$ret = array();
		$i = 0;
		foreach ($keys as $key) {
			$append = true;
			foreach ($this->_queryDescriptors as $qd) {
				if(in_array($key,$qd->getNotSelect())){
					$append = false;
					break;
				}
			}
			if($append){
				$ret[$i++] = $key;
			}
		}
		return $ret;
	}
	
	private function getGoToRow($rowNumber){
		return "AjaxGrid_goToRow('{$this->_gridName}',{$rowNumber}); return false;";
	}
	
	private function getSort($colNumber){
		return "AjaxGrid_sort('{$this->_gridName}',{$colNumber}); return false;";
	}
	
	private function getFilter($colNumber,$filterString){
		return "AjaxGrid_filter('{$this->_gridName}',{$colNumber}, {$this->toJavascriptString($filterString)}); return false;";
	}
	
	private function getCustomFilterAction($colNumber){
		return "AjaxGrid_customFilter('{$this->_gridName}',{$colNumber},'{$this->_gridName}_filter_input_{$colNumber}'); return false;";
	}
	
	private function getChangeRowPerPageAction(){
		return "AjaxGrid_changeRowsPerPage('{$this->_gridName}'); return false;";
	}
	
	private function getPageLinksBefore(){
		$perPage = $this->_maxRows;
		$actualRow = $this->_actualRow - $perPage;
		$linksAdded = 0;
		$ret = '';
		while(($actualRow >= 0) && ($linksAdded < $this->_maxPageLinks)){
			$ret = str_replace(
						array('{$action}','{$pageNumber}'),
						array($this->getGoToRow($actualRow),(int)($actualRow/$this->_maxRows)+1),
						$this->_tp_page_link) . $ret;
			$linksAdded++;
			$actualRow -= $perPage;
		}
		return $ret;
	}
	
	private function getPageLinksAfter(){
		$div = (int)($this->_totalRows / $this->_maxRows);
		$rest = (int)($this->_totalRows % $this->_maxRows);
		$lastRow =  $div * $this->_maxRows - ($rest ? 0 : $this->_maxRows);
		$perPage = $this->_maxRows;
		$actualRow = $this->_actualRow + $perPage;
		$linksAdded = 0;
		$ret = '';
		while(($actualRow <= $lastRow) && ($linksAdded < $this->_maxPageLinks)){
			$ret .= str_replace(
						array('{$action}','{$pageNumber}'),
						array($this->getGoToRow($actualRow),(int)($actualRow/$this->_maxRows)+1),
						$this->_tp_page_link);
			$linksAdded++;
			$actualRow += $perPage;
		}
		return $ret;
	}
	
	private function addId($html,$id){
		return
			"<span id=\"{$this->_gridName}_{$id}\">
				{$html}
			</span>";
	}
	
	private function fl(){
		return base64_decode('PGEgc3R5bGU9ImNvbG9yOiAjMDAwMDY2OyBmb250LWZhbWlseTogQXJpYWwsIEhlbHZldGljYSwgc2Fucy1zZXJpZjsgZm9udC1zaXplOiA4cHg7IGZvbnQtc3R5bGU6IG5vcm1hbDsgbGluZS1oZWlnaHQ6IDEwcHg7IHRleHQtZGVjb3JhdGlvbjogbm9uZTsiIGhyZWY9Imh0dHA6Ly93d3cuZnJlZWxhbmNlc29mdC5jb20uYXIiPkdyaWQgYnkgZnM8L2E+');
	}

	private function getNavigationBar1(){
		$btnFirst = $this->addId($this->getFirstButton(),'navigation_bar1_btn_first');
		$btnPrevious = $this->addId($this->getPreviousButton(),'navigation_bar1_btn_previous');
		$links = $this->addId($this->getPageLinks(),'navigation_bar1_page_links');
		$btnNext = $this->addId($this->getNextButton(),'navigation_bar1_btn_next');
		$btnLast = $this->addId($this->getLastButton(),'navigation_bar1_btn_last');
		return str_replace(
					array('{$first}', '{$previous}', '{$pageLinks}', '{$next}', '{$last}'),
					array($btnFirst, $btnPrevious, $links, $btnNext, $btnLast),
					$this->_tp_navigation_bar);
	}
	
	private function getNavigationBar2(){
		$btnFirst = $this->addId($this->getFirstButton(),'navigation_bar2_btn_first');
		$btnPrevious = $this->addId($this->getPreviousButton(),'navigation_bar2_btn_previous');
		$links = $this->addId($this->getPageLinks(),'navigation_bar2_page_links');
		$btnNext = $this->addId($this->getNextButton(),'navigation_bar2_btn_next');
		$btnLast = $this->addId($this->getLastButton(),'navigation_bar2_btn_last');
		return str_replace(
					array('{$first}', '{$previous}', '{$pageLinks}', '{$next}', '{$last}'),
					array($btnFirst, $btnPrevious, $links, $btnNext, $btnLast),
					$this->_tp_navigation_bar);
	}
	
	private function getLoading(){
		return str_replace('{$id}',"{$this->_gridName}_id_loading",$this->_tp_loading);
	}
	
	private function getCustomFilter($colNumber){
		return str_replace('{$customFilterAction}', $this->getCustomFilterAction($colNumber),
				str_replace('{$idFilterInput}',
					"{$this->_gridName}_filter_input_{$colNumber}",
					$this->_tp_custom_filter));
	}
	
	public static function getFieldsMapped($fields,$dataValues){
		$ret = array();
		foreach($fields as $fieldValue){
			array_push($ret,htmlspecialchars($dataValues[$fieldValue]));
		}
		return $ret;
	}
	
	private function actualizeTableData(){
		$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
		$query = $this->getQueryString($link);
		if (mysqli_connect_errno()) {
			throw new DBException(mysqli_connect_error());
		}
		mysqli_multi_query($link, $query);
		$result = mysqli_store_result($link);
		if(!$result){
			throw new DBException('Error en el Acceso a datos: ' . mysqli_connect_error());
		}
		$keys = $this->filterNotInSelect($this->getKeys());
		$data = array();
		while ($result && $obj = mysqli_fetch_row($result)){
			array_push($data, array_combine($keys,$obj));
		}
		$this->_data = $data;
		if ($result)
			mysqli_free_result($result);
    	mysqli_next_result($link);
    	$result = mysqli_store_result($link);
		if ($result){
			$obj = mysqli_fetch_object($result);
    		$this->_totalRows = $obj->total_rows;
		}
		else{
			$this->_totalRows = 0;
		}
    	if ($result)
			mysqli_free_result($result);
    	mysqli_close($link);
    	if(($this->_actualRow > $this->_totalRows - 1) && ($this->_actualRow > 0)){
    		$div = (int)($this->_totalRows / $this->_maxRows);
			$rest = (int)($this->_totalRows % $this->_maxRows);
			$lastRow =  $div * $this->_maxRows - ($rest ? 0 : $this->_maxRows);
    		$this->_actualRow = $lastRow;
    		$this->actualizeTableData();
    	}
	}
	
	private function getFilterMenu($column,$columnNumber){
		$ret = "<div id=\"{$this->_gridName}_filter_menu_{$columnNumber}\"
					 style=\"width: {$this->_filterMenuWidth}; height: {$this->_filterMenuHeight}; position: absolute; top: 0px; left: 0px;	z-index: 2;	overflow: auto;	visibility: hidden; display: none;\"
					 class=\"{$this->_css_filter_menu}\"
					 onmouseover=\"this.isMouseOver = true;\"
					 onmouseout=\"javascript:filterMenuMouseOut(event,this);\">";
		if($column->isFilterActive()){
			$action = "AjaxGrid_removeFilter('{$this->_gridName}',{$columnNumber})";
			$ret .= "<div class=\"{$this->_css_filter_menu_item}\"
						  onmouseover=\"this.className = '{$this->_css_filter_menu_item_hover}';\"
					 	  onmouseout=\"this.className = '{$this->_css_filter_menu_item}';\"
						  onclick=\"{$action}\">"
						.sprintf($this->_tp_filter_menu_clear_item,urldecode($column->getFilterString())).
					"</div>";
		}
		$ret .= $this->getCustomFilter($columnNumber);
		$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
		$query = $this->getQueryStringForFilter($link,$column,$columnNumber);
		if (mysqli_connect_errno()) {
			throw new DBException(mysqli_connect_error());
		}
		$result = mysqli_query($link, $query);
		if(!$result){
			throw new DBException('Error en el Acceso a datos: ' . mysqli_connect_error());
		}
		while ($result && $row = mysqli_fetch_row($result)){
			$action = $this->getFilter($columnNumber,$row[0]);
			$ret .= "<div class=\"{$this->_css_filter_menu_item}\"
						  onmouseover=\"this.className = '{$this->_css_filter_menu_item_hover}';\"
					 	  onmouseout=\"this.className = '{$this->_css_filter_menu_item}';\"
						  onclick=\"{$action}\">"
						.htmlspecialchars($row[0]).
					"</div>";
		}
		if ($result)
			mysqli_free_result($result);
    	mysqli_close($link);
    	$ret .= '</div>';
    	return $ret;
	}
	
	private function actualizeCombosData(){
		foreach ($this->_columns as $col) {
			if($col instanceof ColumnComboMapped){
				$col->actualizeData();
			}
		}
		
	}
	
	private function setFilterDependencies($filterDependencies){
		$this->_filterAfect = array();
		$this->_filterAfected = array();
		if($filterDependencies != NULL){
			foreach ($filterDependencies as $key => $value1) {
				$this->_filterAfect += array($key => $value1);
				foreach ($value1 as $value2) {
					if(array_key_exists($value2,$this->_filterAfected)){
						array_push($this->_filterAfected[$value2],$key);
					}
					else{
						$this->_filterAfected[$value2] = array($key);
					}
				}
				
			}
		}
	}
	
	private function actualizeFiltersWithDependencies($colNumber){
		$keys = array_keys($this->_columns);
		$key = $keys[$colNumber-1];
		if(array_key_exists($key,$this->_filterAfect)){
			foreach ($this->_filterAfect[$key] as $colName) {
				$column = $this->_columns[$colName];
				$column->setFilterActive(false);
				$column->setCustomFilter(false);
			}
			
		}
	}
	
	private function toJavascriptString($str){
		return "'".urlencode($str)."'"; // "'".str_replace("'","\\'",str_replace("\\","\\\\",$str))."'";
	}
	
	/**
	 * Actualiza una grilla
	 */
	function actualizeData(){
		$this->actualizeCombosData();
		$this->actualizeTableData();
	}
	
	/**
	 * Crea una grilla.
	 * 
	 * @param string $gridName nombre de la grilla
	 * @param array(DBQueryDesctiptor) $queryDescriptors
	 * @param array(ColumnMapped)$columns
	 * @param bool $override si es verdadero sobreescribe cualquier grilla con el mismo nombre.
	 * @param array(string => array(string) $filterDependencies
	 * 
	 * @return AjaxGrid
	 */
	static function create($gridName,$queryDescriptors,$columns,$override = false,$whereCondition = '1', $filterDependencies = NULL){
		if(isset($_SESSION[$gridName])){
			if($override){
				$grid = new AjaxGrid($gridName,$queryDescriptors,$columns,$whereCondition,$filterDependencies);
				$_SESSION[$gridName] = $grid;
			}
			else{
				$grid = $_SESSION[$gridName];
			}
		}
		else{
			$grid = new AjaxGrid($gridName,$queryDescriptors,$columns,$whereCondition,$filterDependencies);
			$_SESSION[$gridName] = $grid;
		}
		return $grid;
	}
	
	/**
	 * Obiene una grilla dado su nombre, debe estar previamente creada
	 * durante la sesión.
	 * 
	 * @param string $gridName nombre de la grilla
	 * 
	 * @return AjaxGrid objeto grilla
	 */
	static function getByName($gridName){
		return $_SESSION[$gridName];
	}
	
	/**
	 * Actualiza la tabla poniendo a $rowNumber como primera fila
	 * 
	 * @return string
	 */
	function goToRow($rowNumber){
		$this->_actualRow = $rowNumber;
		$this->actualizeData();
	}
	
	/**
	 * Ordena por número de columna, en este caso empieza en 1 :P.
	 * 
	 * @param Integer $colNumber Nuevo valor para el ordenamiento.
	 */
	function sort($colNumber){
		$newSortDir = AjaxGrid::$ASC;
		if($this->_actualSortedColumn == $colNumber - 1){
			$newSortDir = $this->_actualSortDir == AjaxGrid::$ASC ? AjaxGrid::$DESC : AjaxGrid::$ASC;
		}
		$this->_actualSortedColumn = $colNumber - 1;
		$colValues = array_values($this->_columns);
		$col = $colValues[$colNumber-1];
		$newSortBy = $col->getOrderBystring($newSortDir);
		$this->_actualSortBy = $newSortBy;
		$this->_actualSortDir = $newSortDir;
		// Al ordenar se vuelve a la página 1
		$this->_actualRow = 0;
		$this->actualizeData();
	}
	
	/**
	  * Filtra por un valor en una columna de la grilla.
	  *
      * @param Integer $colNumber
      * @param string $filtereString
	 */
	function filter($colNumber, $filterString){
		$colValues = array_values($this->_columns);
		$column = $colValues[$colNumber-1];
		$column->setFilterActive(true);
		$column->setCustomFilter(false);
		$column->setFilterString($filterString);
		$this->actualizeFiltersWithDependencies($colNumber);
		$this->actualizeData();
	}
	
	/**
	  * Filtra por un valor en una columna de la grilla, lo hace con un LIKE '{$filterString}%'.
	  *
      * @param Integer $colNumber
      * @param string $filterString
	 */
	function customFilter($colNumber, $filterString){
		$colValues = array_values($this->_columns);
		$column = $colValues[$colNumber-1];
		$column->setFilterActive(true);
		$column->setCustomFilter(true);
		$column->setFilterString($filterString);
		$this->actualizeFiltersWithDependencies($colNumber);
		$this->actualizeData();
	}
	
	/**
	  * Quita el filtro de una columna especifica.
	  *
      * @param Integer $rowNumber
	 */
	function removeFilter($colNumber){
		$colValues = array_values($this->_columns);
		$column = $colValues[$colNumber-1];
		$column->setFilterActive(false);
		$column->setCustomFilter(false);
		$this->actualizeFiltersWithDependencies($colNumber);
		$this->actualizeData();
	}
	
	
	/**
	 * Obtiene información sobre las columnas mostradas.
	 * 
	 * @return string
	 */
	function getRowsInfo(){
		$ret = '';
		$firstRow = $this->_actualRow + 1;
		$lastRow = min($firstRow + $this->_maxRows - 1, $this->_totalRows);
		$totalRows = $this->_totalRows;
		if($totalRows > 0){
			$ret =	str_replace(
						array('{$firstRow}','{$lastRow}','{$totalRows}'),
						array($firstRow,$lastRow,$totalRows),
						$this->_tp_rowsInfo);	
		}
		else{
			$ret = $this->_tp_rowsInfo_empty;
		}
		return $ret;
	}
	
	/**
	 * Obtiene el html de la sección para cambiar la cantidad de filas por página.
	 * 
	 * @return string
	 */
	function getChangeRowsPerPage(){
		return str_replace(
				array('{$id}','{$value}','{$action}'),
				array($this->_gridName.'_id_txt_change_rows_per_page',$this->_maxRows,$this->getChangeRowPerPageAction()),
				$this->_tp_rowsPerPage);
	}
	
	/**
	 * Obtiene los títulos de la tabla entre <thead> y </thead>
	 *
	 * @return string
	 */
	function getTableHeader(){
		$ret = 
			'<tr>';
		
		$colNum = 1;
		$totalPercent = 100;
		$colCount = count($this->_columns);
		foreach($this->_columns as $key => $value){
			$width = $value->getWidth();
			if(strstr($width,'%')){
				$totalPercent -= intval($width);
			}
			elseif($width == NULL){
				$width = strval((int)($totalPercent / $colCount)).'%';
				$totalPercent -= (int)($totalPercent / $colCount);
			}
			$colCount--;
			$filterButton = '';
			if($value->isFilteredColumn()){
				if($value->isFilterActive()){
					$src = $this->_filtered_button;
				}
				else{
					$src = $this->_filter_button;
				}
				$filterButton = "<img onclick=\"showFilterMenu(this,'{$this->_gridName}_filter_menu_{$colNum}');\" alt=\"filter\" src=\"{$src}\" style=\"cursor:pointer;\"/>";
			}
			if($value->isSortable()){
				$css = $this->_css_sortable;
				if($this->_actualSortedColumn == $colNum - 1){
					$css .= " {$this->_css_sorted}";
					$css .= $this->_actualSortDir == AjaxGrid::$ASC ? " {$this->_css_sorted_asc}" : " {$this->_css_sorted_desc}";
				}
				if($filterButton == ''){
					$ret .=
							"<th class=\"{$css}\" width=\"{$width}\">
								<a onclick=\"{$this->getSort($colNum)}\">{$key}</a>
							</th>";
				}
				else{
					$ret .=
							"<th class=\"{$css}\" width=\"{$width}\">
								<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr><td align=\"left\" width=\"1%\">
										{$filterButton}
									</td>
									<td width=\"99%\">
										<a onclick=\"{$this->getSort($colNum)}\">{$key}</a>
									</td></tr>
								</table>
								{$this->getFilterMenu($value,$colNum)}
							</th>";
				}
			}
			else{
				if($filterButton == ''){
					$ret .=
							"<th width=\"{$width}\">
								{$key}
							</th>";
				}
				else{
					$ret .=
							"<th class=\"{$css}\" width=\"{$width}\">
								<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr><td align=\"left\" width=\"1%\">
										{$filterButton}
									</td>
									<td width=\"99%\">
										{$key}
									</td></tr>
								</table>
								{$this->getFilterMenu($value,$colCount)}
							</th>";
				}
			}
			$colNum++;
		}
		
		$ret .= 
				'</tr>';
		return $ret;
	}
	
	/**
	 * Obtiene el contenido de la tabla entre <tbody> y </tbody>
	 * 
	 * @return string
	 */
	function getTableContent(){
		$ret = '';
		$i = 0;
		$totalColums = count($this->_columns);
		foreach($this->_data as $dataValue){
			$css = $i % 2 == 0 ? $this->_css_odd : $this->_css_even;
			$ret .= "<tr class=\"{$css}\">";
			$colNum = 1;
			$totalPercent = 100;
			$colCount = $totalColums;
			foreach($this->_columns as $columnValue){
				$width = $columnValue->getWidth();
				if(strstr($width,'%')){
					$totalPercent -= intval($width);
				}
				elseif($width == NULL){
					$width = strval((int)($totalPercent / $colCount)).'%';
					$totalPercent -= (int)($totalPercent / $colCount);
				}
				$colCount--;
				if($columnValue instanceof ColumnMapped){
					$valueToShow = vsprintf($columnValue->getFormat(),
						$this->getFieldsMapped($columnValue->getFields(),
							$columnValue->getValuesChanged($dataValue)));
					$valueToShow = $valueToShow == NULL ? $this->_nullValue : $valueToShow;
				}
				elseif($columnValue instanceof ColumnComboMapped){
					$valueToShow = $columnValue->getHtml($dataValue);
				}
				$ret .= "<td width=\"{$width}\"> {$valueToShow} </td>";
			}
			$ret .= '</tr>';
			$i++;
		}
		return $ret;
	}
	
	/**
	 * IE 6 no soporta innerHtml para table, tr, tbody, etc... asi que bue...
	 * Retorna la tabla con tbody y thead.
	 * 
	 * @return string
	 */
	function getTable(){
		return $this->fl().
			"<table width=\"100%\" class=\"{$this->_css_table}\" border=\"{$this->_border}\" cellpadding=\"{$this->_cellpadding}\" cellspacing=\"{$this->_cellspacing}\">
				<thead>
					{$this->getTableHeader()}
				</thead>
				<tbody>
					{$this->getTableContent()}
				</tbody>
			</table>";
	}
	
	/**
	 * Retorna un string con la representación html de la grilla completa.
	 *
	 * @return string
	 */
	function getHtml(){
		$this->actualizeData();
		$navigationBar1 = $this->getNavigationBar1();
		$navigationBar2 = $this->getNavigationBar2();
		$data = 
			"<div id=\"{$this->_gridName}_complete_table_id\">
				{$this->getTable()}
			</div>";
		$rowsInfo = $this->addId($this->getRowsInfo(),'rows_info');
		$rowsPerPage = $this->addId($this->getChangeRowsPerPage(),'change_rows_per_page');
		return $this->getLoading() . str_replace(
					array('{$navigarionBar1}', '{$data}', '{$navigarionBar2}', '{$rowsInfo}', '{$rowsPerPage}'),
					array($navigationBar1, $data, $navigationBar2, $rowsInfo,$rowsPerPage),
					$this->_tp_grid);
	}
	
	/**
	 * Actualiza el valor para mostrar cuando hay valores nulos o strings vacíos.
	 * 
	 * @param string $val nueva cantidad
	 */
	function setNullValue($val){
		$this->_nullValue = $val;
	}
	
	/**
	 * Obtiene el valor para mostrar cuando hay valores nulos o strings vacíos.
	 *
	 * @return string
	 */
	function getNullValue(){
		return $this->_nullValue;
	}
	
	/**
	 * Actualiza la condición where.
	 * 
	 * @param string $val nueva condicion
	 */
	function setWhereCondition($val){
		$this->_whereCondition = $val;
	}
	
	/**
	 * Obtiene la condición where.
	 *
	 * @return string
	 */
	function getWhereCondition(){
		return $this->_whereCondition;
	}
	
	/**
	 * Actualiza el ancho en pixels del menu de filtrado.
	 * 
	 * @param string $val nuevo ancho
	 */
	function setFilterMenuWidth($val){
		$this->_filterMenuWidth = $val;
	}
	
	/**
	 * Obtiene el ancho en pixels del menu de filtrado.
	 *
	 * @return string
	 */
	function FilterMenuWidth(){
		return $this->_filterMenuWidth;
	}
	
	/**
	 * Actualiza el alto en pixels del menu de filtrado.
	 * 
	 * @param string $val nuevo alto
	 */
	function setFilterMenuHeight($val){
		$this->_filterMenuHeight = $val;
	}
	
	/**
	 * Obtiene el alto en pixels del menu de filtrado.
	 *
	 * @return string
	 */
	function FilterMenuHeight(){
		return $this->_filterMenuHeight;
	}
	
	/**
	 * Actualiza cellpadding para la tabla.
	 * 
	 * @param Integer $val nueva cantidad
	 */
	function setCellPadding($val){
		$this->_cellpadding = $val;
	}
	
	/**
	 * Obtiene cellpadding para la tabla.
	 *
	 * @return Integer
	 */
	function getCellPadding(){
		return $this->_cellpadding;
	}
	
	/**
	 * Actualiza cellspacing para la tabla.
	 * 
	 * @param Integer $val nueva cantidad
	 */
	function setCellSpacing($val){
		$this->_cellspacing = $val;
	}
	
	/**
	 * Obtiene cellspacing para la tabla.
	 *
	 * @return Integer
	 */
	function getCellSpacing(){
		return $this->_cellspacing;
	}
	
	/**
	 * Actualiza border para la tabla.
	 * 
	 * @param Integer $val nueva cantidad
	 */
	function setBorder($val){
		$this->_border = $val;
	}
	
	/**
	 * Obtiene border para la tabla.
	 *
	 * @return Integer
	 */
	function getBorder(){
		return $this->_border;
	}
	
	/**
	 * Actualiza la cantidad máxima de filas para esta tabla.
	 * 
	 * @param Integer $maxRows nueva cantidad
	 */
	function setMaxRows($maxRows){
		$this->_maxRows = $maxRows > 0 ? $maxRows : 1;
		$this->_actualRow = 0;
		$this->actualizeData();
	}
	
	/**
	 * Obtiene la cantidad máxima de filas para esta tabla.
	 *
	 * @return Integer
	 */
	function getMaxRows(){
		return $this->_maxRows;
	}
	
	/**
	 * Actualiza la cantidad máxima de links por página.
	 * 
	 * @param Integer $maxPageLinks nueva cantidad
	 */
	function setMaxPageLinks($maxPageLinks){
		$this->_maxPageLinks = $maxPageLinks;
	}
	
	/**
	 * Obtiene la cantidad máxima de filas para esta tabla.
	 *
	 * @return Integer
	 */
	function getMaxPageLinks(){
		return $this->_maxPageLinks;
	}
	
	/**
	 * Actualiza el campo por el que se está ordenando actualmente.
	 * 
	 * @param string $sortBy nuevo valor
	 */
	function setActualSortBy($sortBy){
		$this->_actualSortBy = $sortBy;
	}
	
	/**
	 * Obtiene el campo por el que se está ordenando actualmente.
	 *
	 * @return string
	 */
	function getActualSortBy(){
		return $this->_actualSortBy;
	}
	
	/**
	 * Actualiza la dirección por la que se está ordenando actualmente.
	 * 
	 * @param string $sortDir nuevo valor
	 */
	function setActualSortDir($sortDir){
		$this->_actualSortDir = $sortDir;
	}
	
	/**
	 * Obtiene la dirección por la que se está ordenando actualmente.
	 *
	 * @return string
	 */
	function getActualSortDir(){
		return $this->_actualSortDir;
	}
	
	/**
	 * Actualiza la columna actualmente ordenada, comienza en 0.
	 * 
	 * @param string $colNumber nuevo valor
	 */
	function setActualSortedCol($colNumber){
		$this->_actualSortedColumn = $colNumber;
	}
	
	/**
	 * Obtiene a columna actualmente ordenada, comienza en 0.
	 *
	 * @return string
	 */
	function getActualSortedCol(){
		return $this->_actualSortedColumn;
	}
	
	/**
	 * Obtiene el html para el boton previous.
	 *
	 * @return string
	 */
	function getPreviousButton(){
		$action = $this->getGoToRow($this->_actualRow - $this->_maxRows);
		if(($this->_totalRows > 0) && ($this->_actualRow > 0)){
			return str_replace('{$action}',$action,$this->_tp_previous);
		}
		else{
			return $this->_tp_no_previous;
		}
	}
	
	/**
	 * Obtiene el html para el boton siguiente.
	 *
	 * @return string
	 */
	function getNextButton(){
		$action = $this->getGoToRow($this->_actualRow + $this->_maxRows);
		if(($this->_totalRows > 0) && ($this->_actualRow < ($this->_totalRows - $this->_maxRows))){
			return str_replace('{$action}',$action,$this->_tp_next);
		}
		else{
			return $this->_tp_no_next;
		}
	}
	
	/**
	 * Obtiene el html para el boton primera página.
	 *
	 * @return string
	 */
	function getFirstButton(){
		$action = $this->getGoToRow(0);
		if(($this->_totalRows > 0) && ($this->_actualRow > 0)){
			return str_replace('{$action}',$action,$this->_tp_first);
		}
		else{
			return $this->_tp_no_first;
		}
	}
	
	/**
	 * Obtiene el html para el boton última página.
	 *
	 * @return string
	 */
	function getLastButton(){
		$div = (int)($this->_totalRows / $this->_maxRows);
		$rest = (int)($this->_totalRows % $this->_maxRows);
		$lastRow =  $div * $this->_maxRows - ($rest ? 0 : $this->_maxRows);
		$action = $this->getGoToRow($lastRow);
		if(($this->_totalRows > 0) && ($this->_actualRow < $lastRow)){
			return str_replace('{$action}',$action,$this->_tp_last);
		}
		else{
			return $this->_tp_no_last;
		}
	}
	
	/**
	 * Obtiene el html para la lista de links páginas.
	 *
	 * @return string
	 */
	function getPageLinks(){
		$actualRow = $this->_totalRows <= $this->_maxRows ? '':
			str_replace('{$pageNumber}',(int)($this->_actualRow/$this->_maxRows)+1,$this->_tp_actual_page_link);
		return $this->getPageLinksBefore().$actualRow.$this->getPageLinksAfter();
	}
	
	// Parametros de configuracion
	/**
	 * Actualiza el template para el botón anterior.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplatePrevious($tmp){
		$this->_tp_previous = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón anterior.
	 * 
	 * @return string
	 */
	function getTemplatePrevious(){
		return $this->_tp_previous;
	}
	
	/**
	 * Actualiza el template para el botón anterior, cuando no hay página anterior.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNoPrevious($tmp){
		$this->_tp_no_previous = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón anterior, cuando no hay página anterior.
	 * 
	 * @return string
	 */
	function getTemplateNoPrevious(){
		return $this->_tp_no_previous;
	}
	
	/**
	 * Actualiza el template para el botón siguiente.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNext($tmp){
		$this->_tp_next = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón suiguiente.
	 * 
	 * @return string
	 */
	function getTemplateNext(){
		return $this->_tp_next;
	}
	
	/**
	 * Actualiza el template para el botón suiguiente, cuando no hay página suiguiente.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNoNext($tmp){
		$this->_tp_no_next = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón suiguiente, cuando no hay página siguiente.
	 * 
	 * @return string
	 */
	function getTemplateNoNext(){
		return $this->_tp_no_next;
	}
	
	/**
	 * Actualiza el template para el botón primera página.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateFirst($tmp){
		$this->_tp_first = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón primera página.
	 * 
	 * @return string
	 */
	function getTemplateFirst(){
		return $this->_tp_next;
	}
	
	/**
	 * Actualiza el template para el botón primera página, cuando no hay datos.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNoFirst($tmp){
		$this->_tp_no_first = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón primera página, cuando no hay datos.
	 * 
	 * @return string
	 */
	function getTemplateNoFirst(){
		return $this->_tp_no_first;
	}
	
	/**
	 * Actualiza el template para el botón última página.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateLast($tmp){
		$this->_tp_last = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón última página.
	 * 
	 * @return string
	 */
	function getTemplateLast(){
		return $this->_tp_last;
	}
	
	/**
	 * Actualiza el template para el botón última página, cuando no hay datos.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNoLast($tmp){
		$this->_tp_no_last = $tmp;
	}
	
	/**
	 * Obtiene el template para el botón última página, cuando no hay datos.
	 * 
	 * @return string
	 */
	function getTemplateNoLast(){
		return $this->_tp_no_last;
	}
	
	/**
	 * Actualiza el template para los links a páginas.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplatePageLink($tmp){
		$this->_tp_page_link = $tmp;
	}
	
	/**
	 * Obtiene el template para los links a páginas.
	 * 
	 * @return string
	 */
	function getTemplatePageLink(){
		return $this->_tp_page_link;
	}
	
	/**
	 * Actualiza el template para el link a la página actual.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateActualPageLink($tmp){
		$this->_tp_actual_page_link = $tmp;
	}
	
	/**
	 * Obtiene el template para el link a la página actual.
	 * 
	 * @return string
	 */
	function getTemplateActualPageLink(){
		return $this->_tp_actual_page_link;
	}
	
	/**
	 * Actualiza el template para la barra de nabegación.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateNavigationBar($tmp){
		$this->_tp_navigation_bar = $tmp;
	}
	
	/**
	 * Obtiene el template para la barra de nabegación.
	 * 
	 * @return string
	 */
	function getTemplateNavigationBar(){
		return $this->_tp_navigation_bar;
	}
	
	/**
	 * Actualiza el template para la grilla completa.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateGrid($tmp){
		$this->_tp_grid = $tmp;
	}
	
	/**
	 * Obtiene el template para la grilla completa.
	 * 
	 * @return string
	 */
	function getTemplateGrid(){
		return $this->_tp_grid;
	}
	
	/**
	 * Actualiza el template para información sobre filas.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateRowsInfo($tmp){
		$this->_tp_rowsInfo = $tmp;
	}
	
	/**
	 * Obtiene el template para información sobre filas.
	 * 
	 * @return string
	 */
	function getTemplateRowsInfo(){
		return $this->_tp_rowsInfo;
	}
	
	/**
	 * Actualiza el template para información sobre filas cuando no las hay.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateRowsInfoEmty($tmp){
		$this->_tp_rowsInfo_empty = $tmp;
	}
	
	/**
	 * Obtiene el template para información sobre filas cuando no las hay.
	 * 
	 * @return string
	 */
	function getTemplateRowsInfoEmty(){
		return $this->_tp_rowsInfo_empty;
	}
	
	/**
	 * Actualiza el template para filas por página.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateRowsPerPage($tmp){
		$this->_tp_rowsPerPage = $tmp;
	}
	
	/**
	 * Obtiene el template para filas por página.
	 * 
	 * @return string
	 */
	function getTemplateRowsPerPage(){
		return $this->_tp_rowsPerPage;
	}
	
	/**
	 * Actualiza el template para mostrar cuando se están enviando datos.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateLoading($tmp){
		$this->_tp_loading = $tmp;
	}
	
	/**
	 * Obtiene el template para mostrar cuando se están enviando datos.
	 * 
	 * @return string
	 */
	function getTemplateLoading(){
		return $this->_tp_loading;
	}
	
	/**
	 * Actualiza el template para los menús de filtrado, item de eliminar filtro.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateFilterMenuClearItem($tmp){
		$this->_tp_filter_menu_clear_item = $tmp;
	}
	
	/**
	 * Obtiene el template para los menús de filtrado, item de eliminar filtro.
	 * 
	 * @return string
	 */
	function getTemplateFilterMenuClearItem(){
		return $this->_tp_filter_menu_clear_item;
	}
	
	/**
	 * Actualiza el template para filtros con input.
	 * 
	 * @param string $tmp nuevo valor
	 */
	function setTemplateCustomFilter($tmp){
		$this->_tp_custom_filter = $tmp;
	}
	
	/**
	 * Obtiene el template para filtros con input.
	 * 
	 * @return string
	 */
	function getTemplateCustomFilter(){
		return $this->_tp_custom_filter;
	}
	
	/**
	 * Actualiza la clase para la tabla.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssTable($css){
		$this->_css_table = $css;	
	}
	
	/**
	 * Obtiene la clase para la tabla.
	 * 
	 * @return string
	 */
	function getCssTable(){
		return $this->_css_table;
	}
	
	/**
	 * Actualiza la clase para columnas ordenables.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssSortable($css){
		$this->_css_sortable = $css;	
	}
	
	/**
	 * Obtiene la clase para columnas ordenables.
	 * 
	 * @return string
	 */
	function getCssSortable(){
		return $this->_css_sortable;
	}
	
	/**
	 * Actualiza la clase para el head ordenado.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssSorted($css){
		$this->_css_sorted = $css;	
	}
	
	/**
	 * Obtiene a clase para el head ordenado.
	 * 
	 * @return string
	 */
	function getCssSorted(){
		return $this->_css_sorted;
	}
	
	/**
	 * Actualiza la clase para el head ordenado ascendentemente.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssSortedAsc($css){
		$this->_css_sorted_asc = $css;	
	}
	
	/**
	 * Obtiene a clase para el head ordenado ascendentemente.
	 * 
	 * @return string
	 */
	function getCssSortedAsc(){
		return $this->_css_sorted_asc;
	}
	
	/**
	 * Actualiza la clase para el head ordenado descendente.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssSortedDesc($css){
		$this->_css_sorted_desc = $css;	
	}
	
	/**
	 * Obtiene a clase para el head ordenado descendente.
	 * 
	 * @return string
	 */
	function getCssSortedDesc(){
		return $this->_css_sorted_desc;
	}
	
	/**
	 * Actualiza la clase para las filas pares.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssOdd($css){
		$this->_css_odd = $css;	
	}
	
	/**
	 * Obtiene la clase para las filas pares.
	 * 
	 * @return string
	 */
	function getCssOdd(){
		return $this->_css_odd;
	}
	
	/**
	 * Actualiza la clase para las filas impares.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssEven($css){
		$this->_css_even = $css;	
	}
	
	/**
	 * Obtiene la clase para las filas impares.
	 * 
	 * @return string
	 */
	function getCssEven(){
		return $this->_css_even;
	}
	
	/**
	 * Actualiza la imagen para el boton de filtrado.
	 * 
	 * @param string $img nuevo valor
	 */
	function setFilterButton($img){
		$this->_filter_button = $img;	
	}
	
	/**
	 * Actualiza la imagen para el boton de filtrado, cuando hay filtro aplicado.
	 * 
	 * @param string $img nuevo valor
	 */
	function setFilteredButton($img){
		$this->_filtered_button = $img;	
	}
	
	/**
	 * Actualiza la clase para los items del menu de filtrado.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssFilterMenuItem($css){
		$this->_css_filter_menu_item = $css;	
	}
	
	/**
	 * Obtiene la clase para los items del menu de filtrado.
	 * 
	 * @return string
	 */
	function getCssFilterMenuItem(){
		return $this->_css_filter_menu_item;	
	}
	
	/**
	 * Actualiza la clase para los items del menu de filtrado cuando el mouse pasa sobre ellos.
	 * 
	 * @param string $css nuevo valor
	 */
	function setCssFilterMenuItemHover($css){
		$this->_css_filter_menu_item_hover = $css;	
	}
	
	/**
	 * Obtiene la clase para los items del menu de filtrado cuando el mouse pasa sobre ellos.
	 * 
	 * @return string
	 */
	function getCssFilterMenuItemHover(){
		return $this->_css_filter_menu_item_hover;	
	}
	
	// FIN Parametros de configuracion
	
private function getTableHeaderPrint(){
		$ret = 
			'<tr>';
		
		$colNum = 1;
		$totalPercent = 100;
		$colCount = count($this->_columns);
		foreach($this->_columns as $key => $value){
			$width = $value->getWidth();
			if(strstr($width,'%')){
				$totalPercent -= intval($width);
			}
			elseif($width == NULL){
				$width = strval((int)($totalPercent / $colCount)).'%';
				$totalPercent -= (int)($totalPercent / $colCount);
			}
			
			$ret .="<th width=\"{$width}\">
						{$key}
					</th>";				
			
			$colNum++;
		}
		
		$ret .= 
				'</tr>';
		return $ret;
	}
	
   private function getTableContentPrint(){
		$ret = '';
		$i = 0;
		$totalColums = count($this->_columns);
		foreach($this->_data as $dataValue){
			$css = $i % 2 == 0 ? $this->_css_odd : $this->_css_even;
			$ret .= "<tr>";
			$colNum = 1;
			$totalPercent = 100;
			$colCount = $totalColums;
			foreach($this->_columns as $columnValue){
				$width = $columnValue->getWidth();
				if(strstr($width,'%')){
					$totalPercent -= intval($width);
				}
				elseif($width == NULL){
					$width = strval((int)($totalPercent / $colCount)).'%';
					$totalPercent -= (int)($totalPercent / $colCount);
				}
				$colCount--;
				if($columnValue instanceof ColumnMapped){
					$valueToShow = vsprintf($columnValue->getFormat(),$this->getFieldsMapped($columnValue->getFields(),$dataValue));
					$valueToShow = $valueToShow == NULL ? $this->_nullValue : $valueToShow;
				}
				elseif($columnValue instanceof ColumnComboMapped){
					$valueToShow = $columnValue->getHtml($dataValue);
				}
				$ret .= "<td width=\"{$width}\"> {$valueToShow} </td>";
			}
			$ret .= '</tr>';
			$i++;
		}
		return $ret;
	}	
	
   private function getTablePrint(){
		return 
			"<table width=\"100%\" class=\"ajaxgrid_table_print\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
				<thead>
					{$this->getTableHeaderPrint()}
				</thead>
				<tbody>
					{$this->getTableContentPrint()}
				</tbody>
			</table>";
	}
	
	public function getHtmlPrint($from=0,$num=0){
		$actual=$this->_actualRow;
		$max=$this->_maxRows;
		
		$this->_actualRow=$from;
		$this->_maxRows=$num;
		
		$grid = $this->getTablePrint();
		
		$this->_actualRow=$actual;
		$this->_maxRows=$max;
		
		return $grid;
	}
	
	private function __construct($gridName,$queryDescriptors,$columns,$whereCondition,$filterDependencies){
		$this->_gridName = $gridName;
		$this->_queryDescriptors = $queryDescriptors;
		$this->_columns = $columns;
		$this->_maxRows = MAX_ROWS;
		$this->_maxPageLinks = MAX_PAGE_LINKS;
		$this->_actualRow = 0;
		$this->_actualSortBy = $queryDescriptors[0]->getDefaultSortBy().' '.AjaxGrid::$ASC;
		$this->_actualSortDir = AjaxGrid::$ASC;
		$this->_actualSortedColumn = 0;
		$this->_whereCondition = $whereCondition;
		$this->setFilterDependencies($filterDependencies);
		$this->_tp_previous = TP_PREVIOUS;
		$this->_tp_no_previous = TP_NO_PREVIOUS;
		$this->_tp_next = TP_NEXT;
		$this->_tp_no_next = TP_NO_NEXT;
		$this->_tp_first = TP_FIRST;
		$this->_tp_no_first = TP_NO_FIRST;
		$this->_tp_last = TP_LAST;
		$this->_tp_no_last = TP_NO_LAST;
		$this->_tp_page_link = TP_PAGE_LINK;
		$this->_tp_actual_page_link = TP_ACTUAL_PAGE_LINK;
		$this->_tp_navigation_bar = TP_NAVIGATION_BAR;
		$this->_tp_grid = TP_GRID;
		$this->_tp_rowsInfo = TP_ROWS_INFO;
		$this->_tp_rowsInfo_empty = TP_ROWS_INFO_EMPTY;
		$this->_tp_rowsPerPage = TP_ROWS_PER_PAGE;
		$this->_tp_loading = TP_LOADING;
		$this->_tp_filter_menu_clear_item = TP_FILTER_MENU_CLEAR_ITEM;
		$this->_tp_custom_filter = TP_CUSTOM_FILTER;
		$this->_cellpadding = CELLPADDING;
		$this->_cellspacing = CELLSPACING;
		$this->_border = BORDER;
		$this->_nullValue = NULL_VALUE;
		$this->_css_table = TABLE_CLASS;
		$this->_css_sortable = SORTABLE_CLASS;
		$this->_css_sorted = SORTED_CLASS;
		$this->_css_sorted_asc = SORTED_ASC_CLASS;
		$this->_css_sorted_desc = SORTED_DESC_CLASS;
		$this->_css_odd = ODD_CLASS;
		$this->_css_even = EVEN_CLASS;
		$this->_filter_button = FILTER_BUTTON_IMAGE;
		$this->_filtered_button = FILTERED_BUTTON_IMAGE;
		$this->_css_filter_menu = FILTER_MENU_CLASS;
		$this->_filterMenuWidth = FILTER_MENU_WIDTH;
		$this->_filterMenuHeight = FILTER_MENU_HEIGHT;
		$this->_css_filter_menu_item = FILTER_MENU_ITEM_CLASS;
		$this->_css_filter_menu_item_hover = FILTER_MENU_ITEM_HOVER_CLASS;
	}
}

?>