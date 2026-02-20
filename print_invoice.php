<?php 
//if(isset($_POST["submit"]))
//{

include_once "db.php"; 
$id=$_GET['id'];
if(isset($_GET['type']))
{
$line=$db->queryUniqueObject("SELECT *,DATE_FORMAT(insTS,'%d %M, %Y') AS zuva FROM transactions WHERE id=$id");
$branch=$db->queryUniqueObject("SELECT * FROM branch  WHERE id=".$line->branch);
$company = $branch->name;
$address = $branch->address;
$email = "bmc@gmail.com";
$telephone ="";
$number =$line->id;
$item = "mushonga";
$price = "23";
$vat = "34";
$bank = "stanchart";
$iban = "tuiit";
$paypal ="iririr";
$com = "BMC";
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

require('invoice/u/fpdf.php');

class PDF extends FPDF
{
function Header()
{

$this->Image("invoice/logo/logo.jpg",10,10,20);
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
$pdf->Cell(0,30,'',0,1,'R');
$pdf->SetFillColor(200,220,255);
$pdf->ChapterTitle('Receipt Number :',$number);
$pdf->ChapterTitle('Receipt Date :',$line->zuva);
$pdf->ChapterTitle('Amount :',"$".number_format($line->amount,2));
$pdf->ChapterTitle('Account Number :',$line->account);
$patient=$db->queryUniqueObject("SELECT * FROM persons inner join accounts on persons.id=owner WHERE acc_number=".$line->account);
$pdf->ChapterTitle('Account Holder :',$patient->firstname." ".$patient->surname);
$pdf->Cell(0,10,'',0,1,'R');
$pdf->SetFillColor(224,235,255);
$pdf->SetDrawColor(192,192,192);
//$pdf->Cell(15,7,'Qty',1,0,'C');
$pdf->Cell(15,7,'Code',1,0,'C');
$pdf->Cell(110,7,'Description',1,0,'C');
//$pdf->Cell(30,7,'Unit Price',1,0,'C');
$pdf->Cell(20,7,'Amount',1,1,'C');

//$pdf->Cell(15,7,$row['qty'],1,0,'C');
$pdf->Cell(15,7,$line->id,1,0,'C');
$pdf->Cell(110,7,"Account Top-up",1,0,'C');
//$pdf->Cell(30,7,number_format($row['price'],2),1,0,'C');
$pdf->Cell(20,7,number_format($line->amount,2),1,1,'C');


$pdf->Cell(0,0,'',0,1,'R');
//$pdf->Cell(170,7,'Subtotal',1,0,'R',0);
//$pdf->Cell(20,7,number_format($line->total_bill,2),1,1,'C',0);
//$pdf->Cell(170,7,'Transaction Fee',1,0,'R',0);
//$pdf->Cell(20,7,number_format($line->trans_fee,2),1,1,'C',0);
$pdf->Cell(125,7,'Total',1,0,'R',0);
$pdf->Cell(20,7," $".number_format($line->amount,2),1,0,'C',0);
/*$pdf->Cell(0,20,'',0,1,'R');
$pdf->Cell(0,5,$pay,0,1,'L');
$pdf->Cell(0,5,$bank,0,1,'L');
$pdf->Cell(0,5,$iban,0,1,'L');
$pdf->Cell(0,20,'',0,1,'R');
$pdf->Cell(0,5,'PayPal:',0,1,'L');
$pdf->Cell(0,5,$paypal,0,1,'L');*/
$pdf->Cell(190,40,$com,0,0,'C');
$filename="invoice.pdf";
$pdf->Output();



}
else{
$line=$db->queryUniqueObject("SELECT *,DATE_FORMAT(date_of_sevice,'%d %M, %Y') AS zuva FROM bill INNER JOIN persons ON persons.id=acc_owner INNER JOIN accounts ON persons.id=OWNER WHERE nature='I' AND bill.id=$id");
$branch=$db->queryUniqueObject("SELECT * FROM branch  WHERE id=".$line->branch);
$company = $branch->name;
$address = $branch->address;
$email = "bmc@gmail.com";
$telephone ="";
$number =$line->id;
$item = "mushonga";
$price = "23";
$vat = "34";
$bank = "stanchart";
$iban = "tuiit";
$paypal ="iririr";
$com = "BMC";
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

require('invoice/u/fpdf.php');

class PDF extends FPDF
{
function Header()
{

$this->Image("invoice/logo/logo.jpg",10,10,20);
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
$pdf->Cell(0,30,'',0,1,'R');
$pdf->SetFillColor(200,220,255);
$pdf->ChapterTitle('Invoice Number :',$number);
$pdf->ChapterTitle('Invoice Date :',$line->zuva);
$pdf->ChapterTitle('Amount :',"$".number_format($line->total_bill+$line->trans_fee,2));
$pdf->ChapterTitle('Account Number :',$line->acc_number);
$patient=$db->queryUniqueObject("SELECT * FROM persons  WHERE id=".$line->patient);
$pdf->ChapterTitle('Patient :',$patient->firstname." ".$patient->surname);
$pdf->Cell(0,10,'',0,1,'R');
$pdf->SetFillColor(224,235,255);
$pdf->SetDrawColor(192,192,192);
$pdf->Cell(15,7,'Qty',1,0,'C');
$pdf->Cell(15,7,'Code',1,0,'C');
$pdf->Cell(110,7,'Description',1,0,'C');
$pdf->Cell(30,7,'Unit Price',1,0,'C');
$pdf->Cell(20,7,'Price',1,1,'C');
$result = mysql_query("SELECT * FROM treatment INNER JOIN products_services ON products_services.id=product WHERE invoice=$id");
		  	while($row = mysql_fetch_array($result))
			{
$pdf->Cell(15,7,$row['qty'],1,0,'C');
$pdf->Cell(15,7,$row['code'],1,0,'C');
$pdf->Cell(110,7,$row['description'],1,0,'C');
$pdf->Cell(30,7,number_format($row['price'],2),1,0,'C');
$pdf->Cell(20,7,number_format($row['price']*$row['qty'],2),1,1,'C');

}
$pdf->Cell(0,0,'',0,1,'R');
$pdf->Cell(170,7,'Subtotal',1,0,'R',0);
$pdf->Cell(20,7,number_format($line->total_bill,2),1,1,'C',0);
$pdf->Cell(170,7,'Transaction Fee',1,0,'R',0);
$pdf->Cell(20,7,number_format($line->trans_fee,2),1,1,'C',0);
$pdf->Cell(170,7,'Total',1,0,'R',0);
$pdf->Cell(20,7," $".number_format($line->total_bill+$line->trans_fee,2),1,0,'C',0);
/*$pdf->Cell(0,20,'',0,1,'R');
$pdf->Cell(0,5,$pay,0,1,'L');
$pdf->Cell(0,5,$bank,0,1,'L');
$pdf->Cell(0,5,$iban,0,1,'L');
$pdf->Cell(0,20,'',0,1,'R');
$pdf->Cell(0,5,'PayPal:',0,1,'L');
$pdf->Cell(0,5,$paypal,0,1,'L');*/
$pdf->Cell(190,40,$com,0,0,'C');
$filename="invoice.pdf";
$pdf->Output();
}
?>

