<?
require('../fpdfhtml/html2fpdf.php');
$Str_nit = $_GET['Str_nit'];
$N_cotizacion = $_GET['N_cotizacion'];


$pdf=new HTML2FPDF();
$pdf->AddPage('P');
$fp = fopen("cotizacion_g_materiap_vista.php","r");
$strContent = fread($fp, filesize("cotizacion_g_materiap_vista.php"));
$pdf->Cell(0,10,'NIT DEL CLIENTE '.$Str_nit,0,1,'C');
$pdf->Cell(0,10,'COTIZACION DEL CLIENTE '.$N_cotizacion,0,1,'C');
fclose($fp);
$pdf->WriteHTML($strContent);
$pdf->Output("cotizacion.pdf" , 'I');
?>
