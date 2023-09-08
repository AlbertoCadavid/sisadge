<br />
<table width="700" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr>
    <td width="10">&nbsp;</td>
    <td colspan="3" class="titulosInternos">1. &iquest;Que es ABM tablas?</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="233">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="234">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Es un formulario de altas, bajas y modificaciones dinamico. Es generado al vuelo por el sistema y esta en etapa de pruebas, al igual que el generador de excel es la primera version. Funciona mejor o esta mas orientado a tablas que tienen una clave primaria o un campo unico, aunque realiza todas las operaciones igualmente sin que las tablas cumplan con esta estructura.</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr>
    <td width="10">&nbsp;</td>
    <td colspan="3" class="titulosInternos">2. Uso de ABM Tablas</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="233">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="234">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><p>Lo primero es conectarse con el servidor al igual que cuando exportamos o importamos una planilla excel.  Para ello  vamos al menu a la opcion <strong>Servidor</strong> y luego <strong>Conectar</strong>.  Completamos el formulario con los datos de conexion y oprimimos  conectar, si nos aparece conexion exitosa podemos continuar.</p>
      <p>Una vez conectados, en el menu elegimos <strong>ABM. Tablas MySQL</strong> y dentro de este elegimos <strong>Seleccionar Base y Tabla</strong>, nos aparece la siguiente pantalla donde debemos seleccionar la base, luego la tabla y oprimir seleccionar.</p>
      <p align="center"><img src="imagenes/VentanaSeleccionarBase.png" alt="Ventana Seleccionar Base" /></p>
      <p>Si todo esta bien se muestra nuevamente el formulario y arriba de los campos aparece el mensaje Seleccion exitosa. En este momento vamos al menu principal elegimos otra vez <strong>ABM. Tablas MySQL</strong> y ahora <strong>Formulario ABM</strong>; se desplegara el formulario para la base y tabla seleccionada con el siguiente aspecto.</p>
      <p align="center"><img src="imagenes/VentanaFormularioGenerico.png" alt="Ventana Formulario Generico" /></p>
      <p>En la parte superior aparecen dos selects uno para base y otro para tabla, para cambiar se puede realizar de los selects y una vez seleccionado oprimimos <strong>Generar Form.</strong> para que nos despliegue el nuevo formulario. La segunda barra nos da la utilidad para recorrer la base registro a registro o al primero o ultimo. Para utilizar la busqueda tenemos que insertar algun valor en los campos y seleccionamos en el select <strong>todos Coinciden</strong> para buscar con el metodo y (and), o <strong>alguna coincidencia</strong> o (or) y luego oprimimos Buscar. Entre esta barra y el cuerpo de formulario se despliegan los resultados si cliqueamos en algun registro nos lo trasladara a el cuerpo del formulario.<br />
        Luego tenemos el cuerpo del formulario compuesto por todos los campos de la tabla y por ultimo la barra para insertar, modificar y eliminar.<br />
      El formulario tambien puede ser recorrido con el teclado.</p>
      <p align="center"><img src="imagenes/VentanaFormularioTecla.png" alt="Ventana Formulario Acceso con Teclado" /></p>
    <p align="left">En caso de encontrar a la izquierda de un campo select el icono (<img src="imagenes/textfield_add.png"  alt="Cambiar por Campo de Texto" />), significa que si el valor buscado no se encuentra en el, oprimiendo podremos ingresar cualquier valor puesto que el campo se convertira en un campo de texto. Este atributo no esta disponible para todos los selects.</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
