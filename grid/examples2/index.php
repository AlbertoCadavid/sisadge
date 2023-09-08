<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Flexigrid</title>
<link rel="stylesheet" type="text/css" href="css/flexigrid.css" />
<script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="flexigrid.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#flex1").flexigrid
			(
			{
			url: 'post2.php',
			dataType: 'json',
			colModel : [
			//COLUMNAS
				{display: 'ID', name : 'id', width : 40, sortable : true, align: 'center'},
				{display: 'ISO', name : 'iso', width : 40, sortable : true, align: 'center'},
				{display: 'Name', name : 'name', width : 180, sortable : true, align: 'left'},
				{display: 'Printable Name', name : 'printable_name', width : 120, sortable : true, align: 'left'},
				{display: 'ISO3', name : 'iso3', width : 130, sortable : true, align: 'left', hide: true},
				{display: 'Number Code', name : 'numcode', width : 80, sortable : true, align: 'right'},
				{display: 'Date Reg', name : 'fecha_reg', width : 80, sortable : true, align: 'right'}
				],
			campo : [
				{name: 'Add', bclass: 'add', onpress : test},
				{name: 'Delete', bclass: 'delete', onpress : test},
				{separator: true},
				{name: '2014-11', onpress: sortAlpha},
<!--				{name: 'Fecha_reg <input name="fecha_fin" type="date" id="fecha_fin" min="2000-01-02" size="10" required value=""/>', onpress: sortAlpha},
				{separator: true},
				{name: 'A', onpress: sortAlpha},
				{name: '#', onpress: sortAlpha}

				],
			searchitems : [
				{display: 'ISO', name : 'iso'},
				{display: 'Name', name : 'fecha_reg', isdefault: true}//DEFINA LA COLUMNA A CONSULTAR
				],
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			title: 'Countries',
			useRp: true,
			rp: 10,
			showTableToggleBtn: true,
			width: 700,
			height: 255
			}
			);   
	
});
function sortAlpha(com)
			{ 
			jQuery('#flex1').flexOptions({newp:1, params:[{name:'letter_pressed', value: com},{name:'qtype',value:$('select[name=qtype]').val()}]});
			jQuery("#flex1").flexReload(); 
			}

function test(com,grid)
{
    if (com=='Delete')
        {
           if($('.trSelected',grid).length>0){
		   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
            var items = $('.trSelected',grid);
            var itemlist ='';
        	for(i=0;i<items.length;i++){
				itemlist+= items[i].id.substr(3)+",";
			}
			$.ajax({
			   type: "POST",
			   dataType: "json",
			   url: "delete.php",
			   data: "items="+itemlist,
			   success: function(data){
			   	alert("Query: "+data.query+" - Total affected rows: "+data.total);
			   $("#flex1").flexReload();
			   }
			 });
			}
			} else {
				return false;
			} 
        }
    else if (com=='Add')
        {
            alert('Add New Item Action');
           
        }            
} 
</script>
</head>

<body>
<h1>COSTOS TOTALES</h1>
<br />
<br /><br />
<table id="flex1" style="display:none"></table>
</body>
</html>