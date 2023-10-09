<?php
require('../fpdf/fpdf.php');

$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("sample.html","r");
$strContent = fread($fp, filesize("sample.html"));
fclose($fp);
$pdf->WriteHTML($strContent);
$pdf->Output("sample.pdf");
?>
<?php
/*require('../fpdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage("http://www.acycia.com/intranet/cotizacion_g_materiap_vista.php");
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'hola');
$pdf->Link(10,8,10,10,"http://www.acycia.com/intranet/cotizacion_g_materiap_vista.php");
//$pdf->Image('leon.jpg' , 80 ,22, 35 , 38,'JPG', 'http://www.desarrolloweb.com');
$pdf->Output();*/
?>