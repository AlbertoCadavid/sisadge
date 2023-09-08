<?php

/**
 * Autor: Martin Bascal
 * Created on: 18/09/2007
 * Description:
 *    
 *    Configuration file.
 *    
 */

define('MAX_ROWS',10);
// Son la cantidad máxima antes, y después de la página actual. No el total.
define('MAX_PAGE_LINKS',7);
define('CELLPADDING',2);
define('CELLSPACING',1);
define('BORDER',0);
define('NULL_VALUE','&nbsp;');

define('TABLE_CLASS','AjaxGrid');
define('SORTABLE_CLASS','sortable');
define('SORTED_CLASS','sorted');
define('SORTED_ASC_CLASS','asc');
define('SORTED_DESC_CLASS','desc');
define('ODD_CLASS', 'odd');
define('EVEN_CLASS', 'even');

define('TP_PREVIOUS',
	'<img onclick="{$action}"
		src="'.IMAGE_PATH_URL.'btn_previous_32_32.gif"
		alt="Previous"
		style="cursor:pointer;"/>');
	
define('TP_NO_PREVIOUS',
	'&nbsp;');
	
define('TP_NEXT',
	'<img onclick="{$action}"
		src="'.IMAGE_PATH_URL.'btn_next_32_32.gif"
		alt="Next"
		style="cursor:pointer;"/>');
	
define('TP_NO_NEXT',
	'&nbsp;');
	
define('TP_FIRST',
	'<img onclick="{$action}"
		src="'.IMAGE_PATH_URL.'btn_first_32_32.gif"
		alt="First"
		style="cursor:pointer;"/>');
	
define('TP_NO_FIRST',
	'&nbsp;');
	
define('TP_LAST',
	'<img onclick="{$action}"
		src="'.IMAGE_PATH_URL.'btn_last_32_32.gif"
		alt="Last"
		style="cursor:pointer;"/>');
	
define('TP_NO_LAST',
	'&nbsp;');
	
define('TP_PAGE_LINK',
	'<a onclick="{$action}"> {$pageNumber} </a>');
	
define('TP_ACTUAL_PAGE_LINK',
	' {$pageNumber} ');
	
define('TP_NAVIGATION_BAR',
	'<table width="100%" border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td align="left" width="25%">
				{$first} {$previous}
			</td>
			<td align="center" width="50%" class="pageLinks">
				{$pageLinks}
			</td>
			<td align="right" width="25%">
				{$next} {$last}
			</td>
		</tr>
	</table>');
	
define('TP_GRID',
	'<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="100%" align="center">
				{$navigarionBar1}
			</td>
		</tr>
		<tr>
			<td width="100%" align="left">
				{$data}
			</td>
		</tr>
		<tr>
			<td class="ajaxGridInfo" width="100%">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="50%" align="left">
								{$rowsPerPage}
						</td>
						<td width="50%" align="right">
							{$rowsInfo}
						</td>
					</tr>
				</table>
			</td>
		<tr>
			<td width="100%" align="center">
				{$navigarionBar2}
			</td>
		</tr>
	</table>');

define('TP_ROWS_INFO',
	'Record {$firstRow} to {$lastRow} of {$totalRows}');

define('TP_ROWS_INFO_EMPTY',
	'<span style="color: #FF0000;">Not record yet</span>');
	
define('TP_ROWS_PER_PAGE',
	'<input class="txtRowsPerPage" type="text" id="{$id}" value="{$value}"
			onkeyup="digitsMask(this,\'{$value}\');" maxlength="3" />
		Rows per page (<a onclick="{$action}">Change</a>)');

// Debe ser una capa
define('TP_LOADING',
	'<div id="{$id}" style="visibility: hidden;
							display: none;
							position: absolute;
							width: 20px;
							height: 20px;
							z-index: 1;
							margin: 12px;
							padding: 2px;">
		<img alt="" src="'.IMAGE_PATH_URL.'espera.gif'. '" />
	</div>');

define('FILTER_BUTTON_IMAGE',IMAGE_PATH_URL.'filter.gif');

define('FILTERED_BUTTON_IMAGE',IMAGE_PATH_URL.'filtered.gif');

define('FILTER_MENU_CLASS','filterMenu');

define('FILTER_MENU_WIDTH','165px');

define('FILTER_MENU_HEIGHT','200px');

define('FILTER_MENU_ITEM_CLASS','filterMenuItem');

define('FILTER_MENU_ITEM_HOVER_CLASS','filterMenuItemHover');

define('TP_FILTER_MENU_CLEAR_ITEM','Clear <span class="clearItem">%s</span>');

define('TP_CUSTOM_FILTER',
	'<form action="#" method="post" onsubmit="{$customFilterAction}" class="customFilterForm">
		<table width="140" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="20px">
			  <input title="Apply custom filter" type="image" name="imageField" src="'.IMAGE_PATH_URL.'filtered.gif" />
			</td>
			<td width="120px" align="left">
			  <input id="{$idFilterInput}" type="text" class="customFilterInput" />
			</td>
		  </tr>
		</table>
	</form>');

?>