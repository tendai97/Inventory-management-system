<?php 
//if(isset($_POST["submit"]))
//{

include_once "core/db.php"; 
$id=$_GET['id'];

$line=$db->queryUniqueObject("SELECT * from vehicle_purch_ord WHERE ord_numbr='$id'");

$lines=$db->queryUniqueObject("SELECT * FROM supplier_partner where name = '$line->supplier'");

$company = "WWF Zimbabwe";
$address = "10 Lanark Road, Belgravia, Harare";
$email = "info@wwf.org.zw";
$telephone ="04- 252532/ 0772 234513";

$number =$id;
$item = "mushonga";
$price = "23";
$vat = "34";
$bank = "stanchart";
$iban = "tuiit";
$paypal ="iririr";
$com = "P U R C H A S E   O R D E R";
$pay = 'Payment information';
$price = str_replace(",",".",$price);
$vat = str_replace(",",".",$vat);
$p = explode(" ",$price);
$v = explode(" ",$vat);
$re = $p[0] + $v[0];
function r($r)
{
$r = str_replace("$","",$r);
$r = str_replace(" ","",$r);
$r = $r." $";
return $r;
}
$price = r($price);
$vat = r($vat);

require('modules/u/fpdf.php');

class PDF extends FPDF
{
function Header()
{

$this->Image("img/wwf-logo.png",10,10,40);
$this->SetFont('Arial','B',12);
$this->Ln(1);
}
function Footer()
{
$this->SetY(-15);
$this->SetFont('Arial','I',8);
$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function ChapterTitle($num, $label)
{
$this->SetFont('Arial','',12);
$this->SetFillColor(200,220,255);
$this->Cell(0,6,"$num $label",0,1,'L',true);
$this->Ln(0);
}
function Label($num)
{
$this->SetFont('Arial','',12);
$this->SetFillColor(200,220,255);
$this->Cell(0,6,"$num",0,1,'L',true);
$this->Ln(0);
}
function ChapterTitle2($num, $label)
{
$this->SetFont('Arial','',12);
$this->SetFillColor(249,249,249);
$this->Cell(0,6,"$num $label",0,1,'L',true);
$this->Ln(0);
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetTextColor(32);
$pdf->Cell(0,5,$company,0,1,'R');
$pdf->Cell(0,5,$address,0,1,'R');
$pdf->Cell(0,5,$email,0,1,'R');
$pdf->Cell(0,5,'Tel: '.$telephone,0,1,'R');
$pdf->Cell(190,40,$com,0,0,'C');
$pdf->Cell(0,30,'',0,1,'R');
$pdf->Cell(0,10,'',0,1,'R');
$pdf->SetFillColor(200,220,255);
$pdf->ChapterTitle('Purchase Order Number :  ',$id);
$pdf->ChapterTitle('Purchase Order Date :       ',$line->order_date);
$pdf->Label('Supplier Details '); 

$pdf->ChapterTitle('Supplier Name :                 ',$line->supplier);

$pdf->ChapterTitle('Business Address :            ',$lines->sp_address); 
$pdf->ChapterTitle('Contact Person :                ',$lines->sp_contact_no);
$pdf->ChapterTitle('Email Address :                  ',$lines->email); 
    


$pdf->Cell(0,10,'',0,1,'R');
$pdf->SetFillColor(200,220,255);
$pdf->Label('Deliver To: ');
$pdf->SetFillColor(200,220,255);
$pdf->Cell(0,5,$company,0,1,'L');
$pdf->SetFillColor(200,220,255);
$pdf->Cell(0,5,$address,0,1,'L');
$pdf->Cell(0,5,$email,0,1,'L');
$pdf->Cell(0,5,'Tel: '.$telephone,0,1,'L');
$pdf->Cell(0,10,'',0,1,'L');
$pdf->SetFillColor(224,235,255);
$pdf->SetDrawColor(192,192,192);
$pdf->Cell(15,7,'Qty',1,0,'C');
$pdf->Cell(30,7,'Reg Number',1,0,'C');
$pdf->Cell(95,7,'Work Required',1,0,'C');
$pdf->Cell(30,7,'Unit Price',1,0,'C');
$pdf->Cell(20,7,'Price',1,1,'C');
$total = 0;
$result = mysql_query("SELECT * FROM vehicle_purch_ord WHERE ord_numbr = '$id' ");
		  	while($row = mysql_fetch_array($result))
			{
			
$pdf->Cell(15,7,$row['quantity'],1,0,'C');
$pdf->Cell(30,7,$row['reg_no'],1,0,'C');
$pdf->Cell(95,7,$row['serv_rep_item'],1,0,'C');
$pdf->Cell(30,7,number_format($row['cost'],2),1,0,'C');
$pdf->Cell(20,7,number_format($row['cost']*$row['quantity'],2),1,1,'C');
$total = $total + $row['cost']*$row['quantity'];
}
$pdf->Cell(0,0,'',0,1,'R');
$pdf->Cell(170,7,'Total',1,0,'R',0);
$pdf->Cell(20,7,number_format($total,2),1,1,'C',0);


$com = "ADDITIONAL NOTES:     _____________________________________________";
$com1 = "                                         _____________________________________________";
$com2 = "                                         _____________________________________________";

$pdf->Cell(190,40,$com,0,0,'L');
$pdf->Cell(0,6,'',0,1,'R');
$pdf->Cell(190,40,$com1,0,0,'L');
$pdf->Cell(0,6,'',0,1,'R');
$pdf->Cell(190,40,$com2,0,0,'L');
$pdf->Cell(0,20,'',0,1,'R');



$com = "SIGNATURE OF AUTHORISER:     _____________________________________";
$pdf->Cell(190,40,$com,0,0,'L');
$pdf->Cell(0,25,'',0,1,'R');


$filename="invoice.pdf";
$pdf->Output();

?>

