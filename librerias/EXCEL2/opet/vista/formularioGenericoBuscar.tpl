<!-- BEGIN listado -->
<p><h4>{listado.titulo}</h4>Publicado el [{listado.fechaPublicacion}] por {listado.usuario}<br /> 
  <a href="index.php?ctr=temaphp&amp;acc=vertema&amp;itm={listado.idTema}">{listado.texto}</a><br />
</p>
<hr />
  <!-- END listado -->
<div align="center">
  <!-- BEGIN paginacion -->
  <a href="index.php?ctr=temasphp&acc=listarTemas&pag={paginacion.numero}" class="paginador">{paginacion.vista}</a>
<!-- END paginacion --></div>