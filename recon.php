<div id="content">
<?php 
if(isset($_GET['col'])){
	$_SESSION[SITE_NAME]['cat']=$_GET['col'];
	$_SESSION[SITE_NAME]['value']=$_GET['value'];
}
if(!isset($_GET['id'])){
$db->query('UPDATE visit SET  conclusion_date = NOW() WHERE id ='.$_SESSION[SITE_NAME]['visit']);
if($_SESSION[SITE_NAME]['cat']=='all'){
$sql=" SELECT * FROM assets
WHERE  `assert_no` NOT IN 
(
  SELECT `asset_no`
  FROM `visit_assets`
  WHERE `visit` = ". $_SESSION[SITE_NAME]['visit']."
)";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '".$row['assert_no']."', NOW(),'N','Missing Asset',0)");
}
}
else{
	
	switch($_SESSION[SITE_NAME]['cat']){
	
	case 'project':
		$col="project";
		$pop="alloc_project";
	break;

	case 'dept':
		$col="dept";
		$pop="alloc_dept";
	break;
	
	case 'AC':
		$col="asset_group";
		$pop="asset_group";
	break;
	
	case 'AT':
		$col="asset_type";
		$pop="asset_type";
	break;
	
	case 'custodian':
		$col="custodian";
		$pop="custodian";
	break;
	 
 }
	
	
$sql ="SELECT * from assets where $pop ='".$_SESSION[SITE_NAME]['value']."' and assert_no NOT IN(SELECT asset_no FROM visit_assets where visit =".$_SESSION[SITE_NAME]['visit']." ) ";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '".$row['assert_no']."', NOW(),'N','Missing Asset',0)");}
	
}
//echo $sql;

}
else
$_SESSION[SITE_NAME]['visit']=$_GET['id'];

	$visit=$db->queryUniqueObject("SELECT *,
CAST(visit.insTS AS DATE)sdate,
CAST(visit.`conclusion_date` AS DATE)cdate
FROM visit WHERE visit.id=".$_SESSION[SITE_NAME]['visit'] );
		
		$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']);
		while($row = mysql_fetch_array($result))
			{
			
		}

		
?>
<?php 
switch($_SESSION[SITE_NAME]['cat']){
	
	case 'project':
		$col="project";
		$criteria= $col." - ". $_SESSION[SITE_NAME]['value'];
	break;

	case 'dept':
		$col="dept";
		$criteria= $col." - ". $_SESSION[SITE_NAME]['value'];
	break;
	
	case 'AC':
		$col="asset_group";
		$admin = $db->queryUniqueObject("SELECT * FROM asset_group WHERE active = 1 and code = '".$_SESSION[SITE_NAME]['value']."'");
		$criteria= $col." - ". $admin->name;
	break;
	
	case 'AT':
		$col="asset_type";
		$admin = $db->queryUniqueObject("SELECT * FROM asset_type WHERE active = 1 and code = '".$_SESSION[SITE_NAME]['value']."'");
		$criteria= $col." - ". $admin->name;
	break;
	
	case 'custodian':
		$col="custodian";
		$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['value']);
		$criteria= $col." - ". $admin->firstname . " " . $admin->surname;
		$cus= $admin->firstname . " " . $admin->surname;
		$value= $_SESSION[SITE_NAME]['value'];
	break;
	}
	if($col ==''){
		$criteria = 'WWF';
	}
	$value= $_SESSION[SITE_NAME]['value'];
 ?>

   <div id="content">
      <h3>Visit : <?php echo $_SESSION[SITE_NAME]['visit']; ?><br>
	<!--  Mining Venture : <?php echo $visit->rname; ?><br>
	  	  Company / Department: <?php echo $visit->cdname; ?><br>-->
	  <?php $conductor=$db->queryUniqueObject("SELECT * FROM _user WHERE username='". $visit->auditor."'" )?>
	  Conducted by: <?php echo $conductor->firstname." ".$conductor->surname; ?><br>
	  Start Date :  <?php echo $visit->sdate; ?><br>
	   Conclusion Date :  <?php echo $visit->cdate; ?>
	  </h3>
	  <legend>Summary of Inspection Results for <font color="blue"><em><?php echo $criteria?></em> </font></legend>
      <table width="auto" border="0" class="table table-responsive table-striped table-bordered">
      	<tr>
      		<td  align="center"><b>Case</b></td>
      		<td  align="center"><b>Result</b></td>
      		<td align="center"><b>Comment</b></td>
        <tr>
          <td>No of Assets Inspected</td>
          <td align="center"><?php echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and scanned = 1"); $inspected= $count;?></td>
          <td><font color="blue"> Total number of assets inspected during this visit</font></td>
      </tr>
      <tr>
      	<td>Matched Assets</td>
      	 <td align="center"><?php  echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and matches='Y' "); $matching= $count;?></td>
      	 <td><font color="blue">Assets that matched the inspection criteria</font></td>
      </tr>
          <tr>
          	<td>Missing Assets</td>
          	<td align="center"><?php if($col ==''){ $count = $db->countOf("asset_allocation","event='Allocated'");$alll = $count;} else $count = $db->countOf("asset_allocation"," $col = '".$_SESSION[SITE_NAME]['value']."' and event='Allocated'");$alll = $count; echo $missing= $count-$matching?></td>
          	<td><font color="blue">Assets that were not available for inspection</font></td>
          </tr>
          <tr>
          	<td>Foreign Assets</td>
          	<td align="center"> <?php  echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and matches='F' and scanned=1 ");$foreign= $count;?></td>
          	<td><font color="blue">Assets that were found but do not belong</font></td>
          </tr>
          <tr>
          	 <td>Invalid Assets</td>
          	 	<td width="40%" align="center"><?php  echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and reason='Asset No incorrect !' and scanned=1");$invalid= $count;?></td>
          	 	<td><font color="blue">Assets found without barcodes /unreadable barcodes</font></td>
          </tr>
         
       
      </table>
      <p align="justify">
      </p>
      <div align="justify"></div>
<div id="respond"></div>
    </div>
    <tr>
    	<td><font color="blue">Reports :</font></td>
    	<td>&emsp;&emsp;&emsp;&emsp;&emsp;</td>
    	<td><a href="tcpdf/examples/reconc_report2.php?visit=<?php echo $_SESSION[SITE_NAME]['visit']; ?>&criteria=<?php echo $criteria; ?>&total=<?php echo $alll; ?>&inspected=<?php echo $inspected; ?>&missing=<?php echo $missing; ?>&invalid=<?php echo $invalid; ?>&foreign=<?php echo $foreign; ?>&col=<?php echo $col; ?>&value=<?php echo $value; ?>" target="_blank""><img src="white.png" height="30" width="30">Invalid Report Only</a></td>
    	<td>&emsp;&emsp;&emsp;&emsp;&emsp;</td>
    	<td><a href="tcpdf/examples/reconc_report.php?visit=<?php echo $_SESSION[SITE_NAME]['visit']; ?>&criteria=<?php echo $criteria; ?>&total=<?php echo $alll; ?>&inspected=<?php echo $inspected; ?>" target="_blank""><img src="black.png" height="30" width="30">Matched Report Only</a></td>
    	<td>&emsp;&emsp;&emsp;&emsp;&emsp;</td>
    	<td><a href="tcpdf/examples/full_report.php?visit=<?php echo $_SESSION[SITE_NAME]['visit']; ?>&criteria=<?php echo $criteria; ?>&total=<?php echo $alll; ?>&inspected=<?php echo $inspected; ?>&missing=<?php echo $missing; ?>&invalid=<?php echo $invalid; ?>&foreign=<?php echo $foreign; ?>&col=<?php echo $col; ?>&value=<?php echo $value; ?>" target="_blank"><img src="blue.png" height="30" width="30">Full Report</a></td>
    </tr>

</div>