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