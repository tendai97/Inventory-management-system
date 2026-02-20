 <div id="content">
      <br/><legend>View Filtered Asset Information </legend>

	  <?php 

	$tbl_name="assets";		//your table name
	$cat = $_GET['cat'];
	$filt = $_GET['filt'];

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
	$sqlfilter="";

	if($cat=="project"){
		$proj = $_GET['filt'];
		$sqlfilter.= " and alloc_project = '$proj'";
		$extract = $_GET['filt'];
		
	}
	if($cat=="dept"){
		$dept = $_GET['filt'];
		$sqlfilter.= " and alloc_dept = '$dept'";
		$extract = $_GET['filt'];
		
	}
	if($cat=="AC"){
		$agrp = $_GET['filt'];
		$sqlfilter.= " and asset_group = '$agrp'";
		$class = $db->queryUniqueObject("SELECT * FROM asset_group WHERE code = '$agrp'");
		$extract = $class->description;
		
	}
	if($cat=="AT"){
		$atyp = $_GET['filt'];
		$sqlfilter.= " and asset_type = '$atyp'";
		$type = $db->queryUniqueObject("SELECT * FROM asset_type WHERE code = '$atyp'");
		$extract = $type->description;
		
	}
	if($cat=="custodian"){
		$custodian = $_GET['filt'];
		$sqlfilter.= " and custodian = ".$_GET['filt'];
		$cust = $db->queryUniqueObject("SELECT * FROM persons WHERE id = '$custodian'");
		$extract = $cust->firstname." ".$cust->surname;
		
	}
	

//echo "test : ". $sqlfilter;
$query = "SELECT COUNT(*) as num FROM $tbl_name where active= 1 $sqlfilter";

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=filtered_assets&cat=$cat&filt=$filt"; 	//your file name  (the name of this file)
	
	
	include("pagination.php");
	/* Get data. */

		$sql="SELECT *,a.alert_flag as aaf, a.id as aid FROM $tbl_name as a inner join asset_type as t on a.asset_type = t.code WHERE a.active = 1 $sqlfilter ORDER BY  a.id LIMIT $start, $limit ";
			$result = mysql_query($sql);

?>
       <p>

	   <?php if(isset($_GET['msg'])) echo "Record ID:[ ".$_GET['id']." ] <center>".$_GET['msg']."</center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center>".$_GET['cmsg']."</center>";
					?> 
     </p>
      <form action="" method="post">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><div><strong><span style="color: blue;">FILTER CATEGORY :</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($cat=='project') echo 'Project'; elseif ($cat=='dept') echo 'Department'; elseif ($cat=='AC') echo 'Asset Class'; elseif ($cat=='AT') echo 'Asset Type'; elseif ($cat=='custodian') echo 'Custodian'; ?>&nbsp;&nbsp;-&nbsp;&nbsp;[ <?php echo $extract; ?> ] </strong></div></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

          <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Asset No </strong></td>
			<td width="91"><strong>Asset Type</strong></td>
			<td width="115"><strong>Description</strong></td>
			<td width="100"><strong><?php if ($cat <> "custodian") echo 'Custodian (Status)'; else echo 'Allocation Status'; ?></strong></td>
            <td width="20"><strong>Action</strong></td>
			
          <!--  <td width="49"><strong>Deactivate</strong></td>-->
          
          
          </tr>

		  

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);
										 ?>

	<tr>
       	<td width="87"><a href="index.php?c=assetDetails&id=<?php echo  $row['aid'];?>"><?php echo $row['assert_no']; ?></a></td>
      	<td width="91"><?php echo $row['name']; ?></td>
        <td width="115"><?php echo $row['asset_description']; ?></td>
        <td width="100"><?php if ($cat == "custodian") echo $row['alloc_status']; else {  
				$temp = $row['custodian'];
				$line = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = '$temp'");
				echo $line->firstname.' '.$line->surname;
				echo '<br/>(&nbsp;'; echo $row['alloc_status']; echo '&nbsp;)&nbsp;';} ?></td>
        <td><a width="20">
		<?php
		
		$assert = $row['assert_no'];
		$count2 = $db->countOf("asset_allocation","active='1' and asset = '$assert' and allocate_status = 'Asset Allocated'");
			//echo $count2;
			
		if($row['aaf'] =='N' && $_SESSION[SITE_NAME]['a_init']=="1" && $count2 == 0 && $row['alloc_status']=="Awaiting Allocation"){?>
			<a href="index.php?c=allocate&assert_no=<?php echo $row['assert_no'];?>">[Allocate]</a>
			<a width="130"><a onclick="return confirm('You are about to DISPOSE of this Asset - Confirm')" href="index.php?c=dispose&assert_no=<?php echo $row['assert_no'];?>">[Dispose]</a>
		<?php  }
		 
		elseif($_SESSION[SITE_NAME]['a_apro']=="1" && $row['aaf'] =='A' && $row['alloc_status']=="Asset Return - Awaiting Confirmation"){
			?>
			<a onclick="return confirm('Confirm you want to Accept this Returned Asset?')" href="index.php?c=accept_decline&srce=atm&op=C&assert_no=<?php echo $row['assert_no'];?>">[Confirm]</a>
			<a onclick="return confirm('Confirm you want to Reject this Returned Asset?')" href="index.php?c=accept_decline&srce=atm&op=Rej&assert_no=<?php echo $row['assert_no'];?>">[Reject]</a>
			
		<?php 
		} elseif($_SESSION[SITE_NAME]['a_apro']=="1" && $row['aaf'] =='A' && $row['alloc_status']=="Allocation Declined - Awaiting Confirmation"){
			?>
			<a onclick="return confirm('This is Confirmation of Declined Asset Allocation')" href="index.php?c=accept_decline&srce=atm&op=C&assert_no=<?php echo $row['assert_no'];?>">[Confirm]</a>
						
		<?php }  ?>
		</td>
	</tr> 


 <?php
	}
?>

        </table></td>
		
      </tr>

	   <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    </table>

	

	</form>
   
    </div>