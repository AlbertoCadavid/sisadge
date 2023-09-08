function getObjNN4(obj,name){
	var x = obj.layers;
	var foundLayer;
	
	for (var i=0;i<x.length;i++)
	{
		if (x[i].id == name)
			foundLayer = x[i];
		else if (x[i].layers.length)
			var tmp = getObjNN4(x[i],name);
		if (tmp) foundLayer = tmp;
	}
	return foundLayer;
}
	
function getObjectById(name){
	var obj;
	
	if(document.getElementById){
		obj = document.getElementById(name);
	}
	else if(document.all)
	{
		obj = document.all[name];
	}
	else if(document.layers)
	{
		obj = getObjNN4(document,name);
		obj.style = obj;
	}
	return obj;
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	else if(obj.x){
		curleft += obj.x;
		curtop += obj.y;
	}
	return [curleft,curtop];
}

function setVisibility(obj,value){
    if(value){
        obj.style.display = '';
        obj.style.visibility = 'visible';
    }
    else{
        obj.style.display = 'none';
        obj.style.visibility = 'hidden';
    }
}

function showLoading(gridName){
	var loadingDiv = getObjectById(gridName + '_id_loading');
	var gridDiv = getObjectById(gridName + '_complete_table_id');
	var pos = findPos(gridDiv);
	loadingDiv.style.left = pos[0];
	loadingDiv.style.top = pos[1];
	setVisibility(loadingDiv,true);
}

function isAllDigits(str){
    for(i = 0; i < str.length; i++){
        var ch = str.charAt(i);
        if( (ch != '0') && (ch != '1') &&
            (ch != '2') && (ch != '3') &&
            (ch != '4') && (ch != '5') &&
            (ch != '6') && (ch != '7') &&
            (ch != '8') && (ch != '9') )
            return false;
    }
    return true;
}

function digitsMask(txt,defaultValue){
	if(!isAllDigits(txt.value))
		txt.value = defaultValue;
}

// INICIO - FILTER MENUS
var filterMenus = new Array();

function pxToInt(px){
	var i = 0;
	var cont = true;
	var str = '';
	for(i = 0; ((i < px.length) && (cont)); i++){
		var ch = px.charAt(i);
		if((ch == 'p') || (ch == 'P')){
        	cont = false;
        }
        else{
        	str += ch;
        }
	}
	return parseInt(str);
}

function tryHideFilterMenu(idMenu){
	var menu = getObjectById(idMenu);
	if(!menu.isMouseOver){
		menu.style.display = 'none';
    	menu.style.visibility = 'hidden';
	}
}

function addFilterMenu(menu){
	var i;
	var found;
	found = false;
	for( i = 0; i < filterMenus.length; i++){
		var actualMenu = filterMenus[i];
		if((actualMenu) && (actualMenu != null)){
			if(actualMenu.id == menu.id){
				found = true;
				filterMenus[i] = menu;
			}
		}
	}
	if(!found){
		filterMenus[filterMenus.length++] = menu;
	}
}

function hideAllFilterMenus(){
	var i;
	for( i = 0; i < filterMenus.length; i++){
		var menu = filterMenus[i];
		if((menu) && (menu != null)){
			menu.style.display = 'none';
    		menu.style.visibility = 'hidden';
		}
	}
}

function showFilterMenu(button,idMenu){
	var menu = getObjectById(idMenu);
	var pos = findPos(button);
	var x = pos[0];
	var y = pos[1];
	addFilterMenu(menu);
	hideAllFilterMenus();
	menu.style.top = (y + 20) + 'px';
	menu.style.left = x + 'px';
	menu.style.display = 'block';
    menu.style.visibility = 'visible';
    menu.isMouseOver = false;
    setTimeout('tryHideFilterMenu(\'' + idMenu + '\')',2000);
}

function filterMenuGetMouseX(evt) {
	if (evt.pageX) return evt.pageX;
	else if (evt.clientX)
   		return evt.clientX + (document.documentElement.scrollLeft ?	document.documentElement.scrollLeft : document.body.scrollLeft);
	else return null;
}

function filterMenuGetMouseY(evt) {
	if (evt.pageY) return evt.pageY;
	else if (evt.clientY)
   		return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
	else return null;
}

function filterMenuMouseOut(e,divMenu){
	var	menuX = pxToInt(divMenu.style.left);
	var	menuY = pxToInt(divMenu.style.top);
	var menuW = pxToInt(divMenu.style.width);
	var menuH = pxToInt(divMenu.style.height);
	if (!e) var e = window.event;
	var mx = filterMenuGetMouseX(e);
	var my = filterMenuGetMouseY(e);
	if( (mx <= menuX) || (mx >= (menuX + menuW)) || (my <= menuY) || (my >= (menuY + menuH)) ){
		divMenu.style.display = 'none';
    	divMenu.style.visibility = 'hidden';
	}
}

// FIN - FILTER MENUS

function AjaxGrid_filter(gridName,colNumber, filterString){
	hideAllFilterMenus();
	showLoading(gridName);
	xajax_AjaxGrid_filter(gridName,colNumber, filterString);
}

function AjaxGrid_customFilter(gridName,colNumber,idInput){
	hideAllFilterMenus();
	showLoading(gridName);
	var inp = getObjectById(idInput);
	var filterString = inp.value;
	xajax_AjaxGrid_customFilter(gridName,colNumber, filterString);
}

function AjaxGrid_removeFilter(gridName,colNumber){
	hideAllFilterMenus();
	showLoading(gridName);
	xajax_AjaxGrid_removeFilter(gridName,colNumber);
}

function AjaxGrid_sort(gridName,colNumber){
	showLoading(gridName);
	xajax_AjaxGrid_sort(gridName,colNumber);
}

function AjaxGrid_goToRow(gridName,rowNumber){
	showLoading(gridName);
	xajax_AjaxGrid_goToRow(gridName,rowNumber);
}

function AjaxGrid_refresh(gridName){
	showLoading(gridName);
	xajax_AjaxGrid_refresh(gridName);
}

function AjaxGrid_changeRowsPerPage(gridName){
	showLoading(gridName);
	txtId = gridName + '_id_txt_change_rows_per_page';
	txt = getObjectById(txtId);
	xajax_AjaxGrid_changeRowsPerPage(gridName,txt.value);
}