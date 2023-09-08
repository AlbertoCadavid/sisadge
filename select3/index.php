<!doctype html>
<html>
    <head>
        <title>Poblar Select con jQuery, Select2 PDO MySQL</title>
        

        <!-- Select2 Nuevo -->
        <meta charset="UTF-8">
        <!-- jQuery -->
        <script src='assets/js/jquery-3.4.1.min.js' type='text/javascript'></script>

        <!-- select2 css -->
        <link href='assets/plugin/select2/dist/css/select2.min.css' rel='stylesheet' type='text/css'>

        <!-- select2 script -->
        <script src='assets/plugin/select2/dist/js/select2.min.js'></script>
        <!-- Styles -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- Fin Select2 Nuevo -->
        
    </head>
    <body>
        <script>
      /* $(document).ready(function() { $(".buscador").select2(); }); */
  </script>
        <form method="post" name="consulta">
          <div class="main"> 
               <select class='buscador' id='usuario' name='usuario'   style='width: 200px;'>
                   <option value='0'>- Buscar usuarios -</option>
               </select>
          </div>

          <div class="main"> 
               <select class='buscador' id='remision' name='remision'  style='width: 200px;'>
                   <option value='0'>- Buscar usuarios2 -</option>
               </select>
          </div>

         </form>
        <script>

         $(document).ready(function(){  
            $('#usuario').select2({ 
                ajax: {
                    url: "proceso.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term, // search term
                            var1:"*",
                            var2:"usuario",
                            var3:"",
                            var4:"ORDER BY nombre_usuario ASC",
                            var5:"id_usuario",
                            var6:"nombre_usuario"
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });


            $('#remision').select2({ 
                ajax: {
                    url: "proceso.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term, // search term
                            var1:"*",
                            var2:"tbl_remisiones",
                            var3:"",
                            var4:"ORDER BY int_remision DESC",
                            var5:"int_remision",
                            var6:"int_remision"
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });


        });
       

        </script>
    </body>
</html>