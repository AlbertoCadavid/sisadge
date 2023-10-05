<body>
<div class="container">
    <h2>Ejemplo: Leer Archivos Excel con PHP</h2>   
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Resultados de archivo de Excel.</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
            
<?php
require_once ('PHPExcel/Classes/PHPExcel.php');

$archivo = __DIR__. "/carteraAnticipos/ListaPersonal.xlsx";
  $inputFileType = PHPExcel_IOFactory::identify($archivo);
 //$inputFileType = PHPExcel_IOFactory::createReader ("/carteraAnticipos/ListaPersonal.xlsx");
 echo $inputFileType;die;
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
?>
<table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Cargo</th>
          <th>Sede</th>
        </tr>
      </thead>
      <tbody>
<?php
$num=0;
for ($row = 2; $row <= $highestRow; $row++){ $num++;?>
       <tr>
          <th scope='row'><?php echo $num;?></th>
          <td><?php echo $sheet->getCell("A".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("D".$row)->getValue();?></td>
        </tr>
    <?php    
}
?>
         </tbody>
    </table>
  </div>  
 </div>   
</div>
</body>