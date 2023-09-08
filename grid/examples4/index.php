<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit in line con jQuery, Ajax y PHP</title>
<style>
#content {	
	float:left;
	width:700px;
	margin-top:20px;
	border:1px solid #CCCCCC;
	padding:10px;
}

.input {
	float:left;
	width:95%;
}

label {
    background: none repeat scroll 0 0 #F3F3F3;
    display: block;
    float: left;
    font-size: 13px;
    font-weight: bold;
    height: 24px;
    margin: 0 10px 0 0;
    padding: 3px 7px;
    width: 150px;
}

input, textarea {
    background-color: #F3F3F3;
    border: 1px solid #CCCCCC;
    height: 16px;
    padding: 7px;
    width: 435px;
	margin-bottom:15px;
	float:left;
}

textarea {
	height:48px;
}

.loader, .ok {
	float: right;
	/*margin-right:50px;*/
}
</style>
<script type="text/javascript" src="examples4/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('input').focus(function() {
		$(this).css('background-color','#ffffff');
	});
	
	$('input').blur(function(){
		var field = $(this);
		var parent = field.parent().attr('id');
		field.css('background-color','#F3F3F3');
		
		if($('#'+parent).find(".ok").length){
			$('#'+parent+' .ok').remove();
			$('#'+parent+' .loader').remove();
            $('#'+parent).append('<div class="loader"><img src="images/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#'+parent).append('<div class="loader"><img src="images/loader.gif"/></div>').fadeIn('slow');
        }
		
		var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');
		$.ajax({
            type: "POST",
            url: "edit.php",
            data: dataString,
            success: function(data) {
				field.val(data);
				$('#'+parent+' .loader').fadeOut(function(){
					$('#'+parent).append('<div class="ok"><img src="images/ok.png"/></div>').fadeIn('slow');
				});
				
            }
        });
	});
	
	$('textarea').blur(function(){
		var field = $(this);
		var parent = field.parent().attr('id');
		field.css('background-color','#F3F3F3');
		//alert(parent);
		$('#'+parent).append('<img class="loader" src="images/loader.gif"/>').fadeIn('slow');
		var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');
		$.ajax({
            type: "POST",
            url: "edit.php",
            data: dataString,
            success: function(data) {
				field.val(data);
				$('#'+parent+' .loader').fadeOut(function(){
					$('#'+parent).append('<img class="ok" src="images/ok.png"/>').fadeIn('slow');
				});
				
            }
        });
	});
});

</script>
</head>

<body>
<div id="content">
<h2>Editar los campos en el sitio o lugar haciendo click</h2>
<form id="ficha">
	<div id="content_name" class="input">
    	<label>Nombre</label>
    	<input type="text" id="name" name="name" value="Ronal" />
    </div>
    <div id="content_lastname" class="input">
    	<label>Apellidos</label>
   		<input type="text" id="lastname" name="lastname" value="PEPEP" />
    </div>
    <div id="content_email" class="input">
    	<label>Email</label>
    	<input type="text" id="email" name="email" value="PEPEPEP" />
    </div>
    <div id="content_biography" class="input">
    	<label>Biografía</label>
    	<textarea rows="7" cols="30" name="biography">COMO VA TODO EPEPEPE</textarea>
    </div>
</form>
</div>
</body>
</html>