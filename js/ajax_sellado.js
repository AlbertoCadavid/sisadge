// JavaScript Document


 function getClientData(){
 
 var clientId=document.getElementById("idrollo").value;
 
  $.ajax({ 
    type:  'get',
    url: 'consulta_registro_sellado.php',
    data:{
     "getClientId": clientId
    },
   dataType: 'json',//define las variables a mostrar 
 }).done(function( data, textStatus, jqXHR ) {

   if(data) {
    var html = '';
      var i;
           for (i = 0; i < data.length; i++) {
      
              document.getElementById("bolsa_rp").readOnly = false;
             
              $("#placa_rp").val(data[i].placa_rp);
              $("#kiloInicial").val(data[i].kilos);
              $("#int_kilos_prod_rp").val(data[i].kilos);
              $("#int_total_kilos_rp").val(data[i].kilos);
              $("#str_maquina_rp").val(data[i].str_maquina_rp); 
              $("#fecha_ini_rp").val(data[i].fecha_ini_rp);
              $("#rollo_rp").val(data[i].rollo);
              $("#metroInicial").val(data[i].metros);
              $("#metro_r").val(data[i].metros);
              $("#metroIni_r").val(data[i].metros);
              $("#metro_r2").val(data[i].metros); 
              $("#n_ini_rp").val(data[i].n_ini_rp);    
              $("#numInicioControl").val(data[i].n_ini_rp);
              $("#int_cod_empleado_rp").val(data[i].int_cod_empleado_rp);
              $("#int_cod_liquida_rp").val(data[i].int_cod_liquida_rp);
        }

      } 
 }).fail(function( jqXHR, textStatus, errorThrown ) {
        
        document.getElementById("bolsa_rp").readOnly = true;

 		$("#placa_rp").val('');
 		$("#kiloInicial").val('');
 		$("#int_kilos_prod_rp").val('');
 		$("#int_total_kilos_rp").val('');
 		$("#str_maquina_rp").val(''); 
 		$("#fecha_ini_rp").val('');
 		$("#rollo_rp").val('');
 		$("#metroInicial").val('');
 		$("#metro_r").val('');
 		$("#metroIni_r").val('');
 		$("#metro_r2").val(''); 
 		$("#n_ini_rp").val('');
 		$("#numInicioControl").val('');
 		$("#int_cod_empleado_rp").val('');
 		$("#int_cod_liquida_rp").val(''); 
   if ( console && console.log ) {
     console.log( "La solicitud a fallado: " +  textStatus);
   }
 });  

} 

/*	var ajax = new sack();
	var currentClientID=false;
	function getClientData(clientId,dato)
	{
		var client=clientId;
 
		if( clientId!=currentClientID){
			currentClientID = clientId  //'+ getClientId+"="+ dato+ getrollo+"="+ dato2;  getClientId='+dato+'getRollo='+dato2;
			ajax.requestFile = 'consulta_registro_sellado.php?getClientId='+dato;// Specifying which file to get
			ajax.onCompletion = showClientData;	// Specify function that will be executed after file has been found 
			ajax.runAJAX();		// Execute AJAX function
			
		  if(dato!='0'){
		     document.getElementById("bolsa_rp").readOnly = false;				
		   }else{
			document.getElementById("bolsa_rp").readOnly = true;

		   }
		} 
		
	}
	
	function showClientData() 
	{
		var formObj = document.forms['form1'];	
		eval(ajax.response);
	}
	
	function initFormEvents()
	{
		document.getElementById('clientId').onblur = getClientData;
		document.getElementById('clientId').focus();
	}
	
	
	window.onload = initFormEvents;


function sack(file) {
	this.xmlhttp = null;

	this.resetData = function() {
		this.method = "POST";
  		this.queryStringSeparator = "?";
		this.argumentSeparator = "&";
		this.URLString = "";
		this.encodeURIString = true;
  		this.execute = false;
  		this.element = null;
		this.elementObj = null;
		this.requestFile = file;
		this.vars = new Object();
		this.responseStatus = new Array(2);
  	};

	this.resetFunctions = function() {
  		this.onLoading = function() { };
  		this.onLoaded = function() { };
  		this.onInteractive = function() { };
  		this.onCompletion = function() { };
  		this.onError = function() { };
		this.onFail = function() { };
	};

	this.reset = function() {
		this.resetFunctions();
		this.resetData();
	};

	this.createAJAX = function() {
		try {
			this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e1) {
			try {
				this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				this.xmlhttp = null;
			}
		}

		if (! this.xmlhttp) {
			if (typeof XMLHttpRequest != "undefined") {
				this.xmlhttp = new XMLHttpRequest();
			} else {
				this.failed = true;
			}
		}
	};

	this.setVar = function(name, value){
		this.vars[name] = Array(value, false);
	};

	this.encVar = function(name, value, returnvars) {
		if (true == returnvars) {
			return Array(encodeURIComponent(name), encodeURIComponent(value));
		} else {
			this.vars[encodeURIComponent(name)] = Array(encodeURIComponent(value), true);
		}
	}

	this.processURLString = function(string, encode) {
		encoded = encodeURIComponent(this.argumentSeparator);
		regexp = new RegExp(this.argumentSeparator + "|" + encoded);
		varArray = string.split(regexp);
		for (i = 0; i < varArray.length; i++){
			urlVars = varArray[i].split("=");
			if (true == encode){
				this.encVar(urlVars[0], urlVars[1]);
			} else {
				this.setVar(urlVars[0], urlVars[1]);
			}
		}
	}

	this.createURLString = function(urlstring) {
		if (this.encodeURIString && this.URLString.length) {
			this.processURLString(this.URLString, true);
		}

		if (urlstring) {
			if (this.URLString.length) {
				this.URLString += this.argumentSeparator + urlstring;
			} else {
				this.URLString = urlstring;
			}
		}

		// prevents caching of URLString
		this.setVar("rndval", new Date().getTime());

		urlstringtemp = new Array();
		for (key in this.vars) {
			if (false == this.vars[key][1] && true == this.encodeURIString) {
				encoded = this.encVar(key, this.vars[key][0], true);
				delete this.vars[key];
				this.vars[encoded[0]] = Array(encoded[1], true);
				key = encoded[0];
			}

			urlstringtemp[urlstringtemp.length] = key + "=" + this.vars[key][0];
		}
		if (urlstring){
			this.URLString += this.argumentSeparator + urlstringtemp.join(this.argumentSeparator);
		} else {
			this.URLString += urlstringtemp.join(this.argumentSeparator);
		}
	}

	this.runResponse = function() {
		eval(this.response);
	}

	this.runAJAX = function(urlstring) {
		if (this.failed) {
			this.onFail();
		} else {
			this.createURLString(urlstring);
			if (this.element) {
				this.elementObj = document.getElementById(this.element);
			}
			if (this.xmlhttp) {
				var self = this;
				if (this.method == "GET") {
					totalurlstring = this.requestFile + this.queryStringSeparator + this.URLString;
					this.xmlhttp.open(this.method, totalurlstring, true);
				} else {
					this.xmlhttp.open(this.method, this.requestFile, true);
					try {
						this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
					} catch (e) { }
				}

				this.xmlhttp.onreadystatechange = function() {
					switch (self.xmlhttp.readyState) {
						case 1:
							self.onLoading();
							break;
						case 2:
							self.onLoaded();
							break;

						case 3:
							self.onInteractive();
							break;
						case 4:
							self.response = self.xmlhttp.responseText;
							self.responseXML = self.xmlhttp.responseXML;
							self.responseStatus[0] = self.xmlhttp.status;
							self.responseStatus[1] = self.xmlhttp.statusText;

							if (self.execute) {
								self.runResponse();
							}

							if (self.elementObj) {
								elemNodeName = self.elementObj.nodeName;
								elemNodeName.toLowerCase();
								if (elemNodeName == "input"
								|| elemNodeName == "select"
								|| elemNodeName == "option"
								|| elemNodeName == "datetime-local"
								|| elemNodeName == "date"  
								|| elemNodeName == "textarea") {
									self.elementObj.value = self.response;
								} else {
									self.elementObj.innerHTML = self.response;
								}
							}
							if (self.responseStatus[0] == "200") {
								self.onCompletion();
							} else {
								self.onError();
							}

							self.URLString = "";
							break;
					}
				};

				this.xmlhttp.send(this.URLString);
			}
		}
	};

	this.reset();
	this.createAJAX();
}*/
 