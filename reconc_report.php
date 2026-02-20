<?php
//============================================================+
// File name   : example_021.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 021 for TCPDF class
//               WriteHTML text flow
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML text flow.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).

require_once('tcpdf_include.php');
include_once "../../core/db.php";



$_SESSION[SITE_NAME]['visit']=$_GET['visit'];
$criteria=$_GET['criteria'];
$total=$_GET['total'];
$inspected=$_GET['inspected'];



$visit=$db->queryUniqueObject("SELECT *,CAST(visit.insTS AS DATE)sdate,CAST(visit.`conclusion_date` AS DATE)cdate FROM visit  WHERE visit.id=".$_SESSION[SITE_NAME]['visit']);

/*$visit=$db->queryUniqueObject("SELECT *,
CAST(visit.insTS AS DATE)sdate,
CAST(visit.`conclusion_date` AS DATE)cdate,
visit.id AS vid
, regions.`name` AS rname FROM visit INNER JOIN `regions` ON location=regions.`code`WHERE visit.id=".$_SESSION[SITE_NAME]['visit']);*/
$_SESSION[SITE_NAME]['region']=$visit->location;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle($visit->location.' Reconciliation Report');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('courierB', '', 9);

// add a page
$pdf->AddPage();

// create some HTML content
$conductor=$db->queryUniqueObject("SELECT * FROM _user WHERE username='". $visit->auditor."'" );
 $html="<h3>
		Visit : ". $_SESSION[SITE_NAME]['visit']."<br>
	
		Conducted by: ". $conductor->firstname." ".$conductor->surname."<br>
		Start Date :  ".$visit->sdate."<br>
		Conclusion Date :  ". $visit->cdate."<br><br>
		Signed By:_____________________________________ <br><br>
		Verified By :____________________________________ 
	  </h3>

	  <h3>The inspection was conducted for all the assets that belong to (<b>".$criteria." </b>).Records indicate that a total of ". $total." assets were allocated to (<b>".$criteria." </b>) and the total number  of assets inspected is  <b>". $inspected." </b></h3></p>

      <table width='200' border='0'>
       
		";
		
		/*$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']);
		while($row = mysql_fetch_array($result))
			{
			$html.= $row["asset_no"]."<br>";
		}*/
		
		$html.="<tr>
          <td><h1>No of Matched Assets  (  ".$db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and matches='Y'")." ) </h1></td>
          <td></td>
        </tr>
		<tr>
		<td colspan=\"2\">
		<table class='table table-striped'>
		<tr><td  width=\"100\">Asset No.</td><td width=\"150\">Description</td><td width=\"96\">Project</td><td width=\"96\">Department</td><td width=\"120\">Custodian</td><td width=\"200\">Observations</td></tr> <hr>";
		
		
		$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']." and matches='Y'");
		while($row = mysql_fetch_array($result))
			{
				if($_SESSION[SITE_NAME]['region']=="all")
	$sqlmain="SELECT * ,assets.asset_description as assdes  FROM assets  where assets.active=1 and assert_no='".$row["asset_no"]."'";
else
	$sqlmain="SELECT * ,assets.asset_description as assdes  FROM assets inner join asset_allocation on assert_no=asset where assets.active=1 and assert_no='".$row["asset_no"]."'";
		$res = $db->queryUniqueObject($sqlmain);
		$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$res->custodian);
		$cus= $admin->firstname . " " . $admin->surname;

		 
			$html.="<tr><td>$res->assert_no</td><td>$res->assdes </td><td>$res->alloc_project </td><td>$res->alloc_dept </td><td align='center'>$cus</td><td>{$row['observations']}</td></tr><tr><td><br></td></tr>";
		}
		
		$html.="
		</table>
		</td></tr>
		<hr>
        
      </table>
      <p align='justify'><br />
      </p>
      <p align='justify'>&nbsp;</p>
      <div align='justify'></div>
<div id='respond'></div>
    </div> ";
// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_021.pdf', 'I');
$pdf->Output();
//============================================================+
// END OF FILE
//============================================================+
