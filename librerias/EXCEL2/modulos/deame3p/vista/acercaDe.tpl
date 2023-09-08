<br />
    <!-- TABLA INTERIOR -->
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="5">
    <tr>
        <td colspan="2"><strong>Estado del Desarrollo:</strong></td>
    </tr>
    <tr>
        <td valign="top">31.</td>
        <td><span class="acercade">Version 5.4.0 - 08/01/2012</span><br />
        Regreso de Funciones de Usuario para el proceso de los datos de exportacion.
        Se requiere seguir algunas convenciones, ver anexos del manual.
        </td>
    </tr>
  <tr>
    <td valign="top">30.</td>
    <td><span class="acercade">Version 5.3.4 - 28/09/2011</span><br />
        Correccion error con nombres de tablas que contienen - (guion) en su nombre.
    </td>
  </tr>
  <tr>
    <td valign="top">29.</td>
    <td><span class="acercade">Version 5.3.3 - 30/08/2011</span><br />
        Correccion de error al generar excel a partir de tablas de mas de 26 columnas. (importarControl ,getNumeroALetra).
        Arreglo de error que se producia al cargar tablas con nombres de funciones MySQL.
    </td>
  </tr>
  <tr>
    <td valign="top">28.</td>
    <td><span class="acercade">Version 5.3.2 - 25/08/2011</span><br />
        Mejora en carga de tablas al seleccionar la base. En caso de error o estar vacia despliega el mensaje en el Select.
    </td>
  </tr>
  <tr>
    <td valign="top">27.</td>
    <td><span class="acercade">Version 5.3.1 - 13/05/2011</span><br />
      Mejora en generación de archivos excel al tener tildes, eñes y dieresis, probado con tipo de collation MySQL UTF-8 y LATIN1.<br />
      Si tiene error con otro tipo de codificación por favor avisar.</td>
  </tr>
  <tr>
    <td valign="top">26.</td>
    <td><span class="acercade">Version 5.3.0 - 05/12/2010</span><br />
      Posibilidad de elegir la hoja a exportar, ahora no se necesita que sea la primera y ademas se añadio capacidad de exportar todas las hojas de una vez, con el unico requisito que se hara con la misma configuracion para todas ellas.<br />
      Acceso al Administrador de planillas limitado a haberse conectado antes al servidor mysql.<br />
      Seleccionar si se realiza la exportacion cruda del valor de la celda o que se calculen sus formulas al exportar.<br />
      Manual en pdf para la seccion DEAME3P.</td>
  </tr>
  <tr>
    <td valign="top">25.</td>
    <td><span class="acercade">Version 5.2.0 - 28/11/2010</span><br />
      Deame3p: Se incorporan patrones de exportación. Con esta funcionalidad se podra exportar intervalos de filas de la hoja de calculo, con una patron similar al seleccionar hojas para imprimir.<br />
      Se actualizo la libreria PHPExcel de la version 1.7.0 a la 1.7.4. (Si existe algun error por favor enviarmelo... Gracias).<br />
      Mejoras en el formulario de Adminstrar Plantillas.<br /></td>
  </tr>
  <tr>
    <td valign="top">24.</td>
    <td><span class="acercade">Version 5.1.0 - 07/11/2010</span><br />
      Deame3p: Arreglos de error de tipo Notice, que hacian crear un archivo xls/xlsx no valido. Generalmente se producia en entornos de desarrollo en donde se activan todos los errores para depuracion, tambien influia en el buscador generico largando el error entre cada registro obtenido.<br />
      Arreglo de problemas de campos MySQL en donde su nombre contenia espacios.<br />
      ABM-Tablas: mejora en problema con libreria iconv con caracteres extraños al igual que errores de tipo Notice (Otorga mayor compatibilidad  con ñ y tildes).
      <br />
    Incorpora el poder establecer los niveles de errores que debera mostrar la rutina(Servidor &gt; Configurar php.ini).</p>      </td>
  </tr>
  <tr>
    <td valign="top">23.</td>
    <td><span class="acercade">Version 5.0.7 - 25/09/2010</span><br />
    General:<br />
    Cambio del menu, formado completamente por una lista. Elimina el espacio que se generaba, en la primera carga del menu.</td>
  </tr>
  <tr>
    <td valign="top">22.</td>
    <td><span class="acercade">Version 5.0.6 - 11/04/2010</span><br />
    Modulo Deame3p:<br />
    Mejora en Funcion de validacion de fechas provenientes de excel. Cambio de la funcion ereg en clase exportar a preg_martch para otorgar compatibilidad con php 5.3.-<br />
    Agregado validacion para campos char.    </td>
  </tr>
  <tr>
    <td valign="top">21.</td>
    <td><span class="acercade">Version 5.0.5 - 12/03/2010</span><br />
      Modulo Deame3p:<br />
      Correcion error Strict Standards: Non-static method Config::set() should not be called   statically, assuming $this from incompatible context in... que se producia en servidores que tenian activados los errores de E_STRICT, si bien no imposibilitaba a la rutina seguir corriendo.</td>
  </tr>
  <tr>
    <td valign="top">20.</td>
    <td><span class="acercade">Version 5.0.4 - 23/12/2009</span><br />
      Modulo Deame3p:<br />
      Arreglo espacio en blanco botones tipo vista a la izquierda y alineacion derecha.<br />
      Mejora de codigo en llamadas a clases a traves de FrenteControl.</td>
  </tr>
  <tr>
    <td valign="top">19.</td>
    <td><span class="acercade">Version 5.0.3 - 20/12/2009</span><br />
      Modulo ABM Tablas:<br />
      Error en campos float, double y decimal cuando no se definia la cantidad de enteros y decimales. Es decir se definen por ejemplo como solo FLOAT y no FLOAT(10,2). En estos casos el sistema por defecto adjudicara para la validacion de float 12,12 y para double o decimal 27,27.</td>
  </tr>
  <tr>
    <td valign="top">18.</td>
    <td><span class="acercade">Version 5.0.2 - 13/12/2009</span><br />
      Modulo ABM Tablas:<br />
    Arreglado error en clave foranea cuando un campo estaba presente en mas de una tabla.<br />
    Mejora codificacion en campos select para mostrar caracteres con tildes, eñes etc.</td>
  </tr>
  <tr>
    <td valign="top">17.</td>
    <td><span class="acercade">Version 5.0.1 - 03/11/2009</span><br />
      Correccion  exportacion con archivos xls, si era el primero en subir...(Arreglado tambien en version 4.0.2)<br />
      Aparte de los formtos de fecha dd*mm*aaaa , aaaa*mm*dd , numero general de excel, se incluye el formato dmmaaaa o ddmmaaaa.<br />
      Eliminacion de vinculos a css rotos.<br />
      Mejora en la plantilla Previa Excel.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">16.</div></td>
    <td><span class="acercade">Version 5.0.0 - 26/10/2009</span><br />
      ABM basico para tablas de Mysql incluye buscador con paginacion.<br />
      Consola para generar archivos Excel a traves de consultas MySQL.<br />
      Configuracion de php.ini no solo en la exportacion, ahora puede realizarse de forma independiente.<br />
      Menu de borrado de archivos en el directorio planillas, separado de la accion de envio.<br />
      <strong>Importar a Excel desde MySQL con seleccion de los campos a importar.</strong><br />
      Vista previa para archivos que se encuentran en el servidor solo para los excel 2007.<br />
      Actualizacion del logo<br />
      Diseño de la Plantilla estilo Vista extraido de : <a href="http://blog.itookia.com/post/How-to-create-VISTA-style-toolbar-with-CSS.aspx" target="_blank">Blog Itioka<br />
      </a>Combinandolo con Menu desplegable y botones diseño vista de <a href="http://www.dynamicdrive.com/dynamicindex1/ddlevelsmenu/" target="_blank">ddlevelsmenu<br />
    </a></td>
  </tr>
  <tr>
    <td valign="top">15.</td>
    <td><span class="acercade">Version 4.0.1 - 14/10/2009</span><br />
      - Arreglado problema con PHPExcel_IOFactory<br />
- Mejorada performance con archivos xls (Excel 2003 o anteriores)</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">14.</div></td>
    <td><span class="acercade">Version 4.0.0  - 08/09/2009</span><br />
- Compatibilidad con  Excel 2007, tambien  con excel 2003<br />
- Re-escrito con el patron MVC (Modelo-Vista-Controlador)<br />
- Cambio en la clase de lectura de excel que paso a ser PHPExcel<br />
- Nuevo dise&ntilde;o de la interfaz visual.<br />
- Mayor capacidad de proceso, pasa el limite de las 65535 filas. Probado con 150.463 filas excel.<br />
- Mantenimiento (persistencia) de las variables de conexion.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">13.</div></td>
    <td><span class="acercade">Version 3.2.1 - 30/08/2009</span><br />
- Correcci&oacute;n error include clasesPHP/clase.Insertar.php<br />
- Correcci&oacute;n en visualizaci&oacute;n de variables del sistema y configuraci&oacute;n.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">12.</div></td>
    <td><span class="acercade">Version 3.2.0 - 03/08/2009</span><br />
- Inclusion para configurar el limite de memoria.<br />
- Mejoras en el codigo JavaScript.<br />
- Ventana de informacion de Variables PHP relevantes para deame3p.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">11.</div></td>
    <td><span class="acercade">Version 3.1.1 - 01/08/2009</span><br />
- Posibilidad de setear desde el paso 1, el tiempo de ejecucion del script y cambiar codificacion a UTF8.<br />
- Correccion de fechas levantadas en formato texto de excel, el cual daba un dia menos.<br />
- Logo de Objetivophp en flash (Adapatado por Pablo Rebollo)</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">10.</div></td>
    <td><span class="acercade"> Version 3.0.0 b - 25/05/2008 = 3.0.0 (29/05/2008)</span><br />
- Reescritura completa de codigo. Mas orientacion a objetos.<br />
- Soporta distinto orden en columnas MySQL con Tablas Excel.<br />
- Nuevo dise&ntilde;o de la interfaz visual.<br />
- Motor de plantilla ahora es MGTheme.<br />
- Inclusion de UPDATE cuando se repiten las claves.<br />
- Utilizacion de JavaScript no intrusivo con JQuery.<br />
- Incorporacion por defecto de versiones reducidas para formateo de  		campos Varchar, Date, DateTime,TimeStamp, Time, Year(4), tinyint,  		smallint, mediumint, int, bigint, bool, boolean, bit, float,double, set y enum. Ademas  		de incluir un metodo por defecto para los campos no implementados todavia.-</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">9.</div></td>
    <td><span class="acercade">Version 2.5.0 - 23/08/2007 </span><br />
Se incorporo Mensaje de Error dentro de Select Tabla, por si el  		usuario no tenia Permisos, puesto que esto hacia que el select  		desapareciera. Se incorpora Autenticacion con Servidor - Usuario -  		Clave. Se muestran solo las bases del Usuario que se autentifica. Se  		muestra mensaje de cargando cuando se ejecuta una peticion ajax.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">8.</div></td>
    <td><span class="acercade">Version 2.4.2 - 06/08/2007</span> <br />
Correccion error de carga archivo en servidores con register Global  		desactivado pagina InsertarExcelAMysql</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">7.</div></td>
    <td><span class="acercade">Version 2.4.1 - 06/08/2007</span><br />
Peque&ntilde;a modificacion en codigo en los resultados se  		separo el Formulario de porcentajes. Regreso como en la version 1.0.0,  		en la pagina de Relacion de Campos se agrego nuevamente el  		pre-seleccionado de campos cuando coinciden titulo excel y tabla  		MySql.<br />
Correccion: 1&gt; Error de JavaScript cuando una columna excel no  		traia encabezado.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">6.</div></td>
    <td><span class="acercade">version 2.3.0 - 05/08/2007</span> <br />
Incorporacion de Modos para mostrar los resultados finales.<br />
Incorporacion de estadisticas de las consultas.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">5.</div></td>
    <td><span class="acercade">Version 2.2.1 - 04/08/2007</span> <br />
Posibilidad del Usuario de Elegir si borrar o no el archivo despues de  		realizada la inserccion de datos. Si existen archivos en el servidor  		nos da la posibilidad de Usarlos sin subir nada.<br />
Correcciones : 1&gt; Error en Bases con tablas vinculadas. Comenzo con  		la correccion del error para columnas Excel con menos de 3 Caracteres  		(Version 2.0.1)</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">4.</div></td>
    <td><span class="acercade">Version 2.1.0 - 04/08/2007 </span><br />
Inclusion de Libreria de funciones. Permite procesar cada campo antes  		de incluirlo en la tabla Mysql.<br />
Reglas: la libreria se debe llamar nombre de la base . nombre de tabla  		. php (Minusculas el php) Las funciones iguales que los campos Solo se  		pasa como parametro el valor original del campo y se recibe solo un  		valor. El archivo deben encontrarse en el directorio librerias.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">3.</div></td>
    <td><span class="acercade">Version 2.0.1 - 03/08/2007</span><br />
Correcciones :<br />
1&gt; Error de conexion. Se perdia la conexion (Generado en la version  		2.0.0).-<br />
2&gt; Error para nombre de columnas excel de menos de 3 caracteres, lo  		cual producia un error 1136 =&gt;El n&uacute;mero de columnas no  		corresponde al n&uacute;mero en la l&iacute;nea 1<br />
3&gt; Error de salto de vinculo en procesar.php.-</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">2.</div></td>
    <td><span class="acercade">Version 2.0.0 - 03/04/2007</span><br />
Rescritura del codigo principal, pasando a ser una clase PHP.  		Inclusion de Rutinas de Control Javascript y Ajax. Soporte para  		decidir que valor se ingresa de Excel cuando un campo de la tabla que  		estamos cargando es campo indice de otra tabla de la misma Base de  		datos.
Primer version publica.</td>
  </tr>
  <tr>
    <td valign="top"><div align="right">1.</div></td>
    <td><span class="acercade">Version 1.0.0 - 20/02/2007</span><br />
Cargar un archivo Excel, permitiendo vincular columnas de la planilla  		con las columnas de una tabla MySql. La tabla requeria ser configurada previamente, por esto mismo fue una version interna.</td>
  </tr>
</table>
    
<!-- FIN TABLA INTERIOR -->