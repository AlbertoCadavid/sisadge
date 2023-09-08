function editCity(id){
	var cbo = getObjectById('peopleis_' + id);
	var txtName = getObjectById('name_'  + id);
	var peopleis = cbo.value;
	var name = txtName.value;
	xajax_city_edit(id,peopleis,name);
}

function deleteCity(id,gridName){
	xajax_city_delete(id,gridName);
}

function actualizeSeven(id){
	var cbo = getObjectById('peopleis_' + id);
	var peopleis = cbo.value;
	xajax_city_actualizeSeven(id,peopleis);
}