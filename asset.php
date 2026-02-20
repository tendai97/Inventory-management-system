 <div id="content">
      <br/><legend>Manage Own Allocated Assets</legend>
      <table width="700" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered" >
        <tr>
          <td><form action="" method="post" name="search" id="search2" >
            <input name="searchtxt" type="text" value="<?php echo $_POST['searchtxt']; ?>" />
            &nbsp;&nbsp;
            <input name="Search" type="submit" value="Search" />
          </form></td>
          <td><form action="" method="get" name="page" id="page">
            Page per Record
            <input name="limit" type="text"  style="margin-left:5px;" value="<?php if(isset($_GET['limit'])) echo $_GET['limit']; else echo "10"; ?>" size="3" maxlength="3" />
            <input name="go" type="submit" value="Go" />
			 <input name="c" type="hidden" value="<?php echo $_GET['c'];?>" />
          
          </form></td>
        </tr>
      </table>
      <p>
        <?php 

	$cust= $_SESSION [SITE_NAME]["person"];
	$tbl_name="assets";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/

$sqlfilter ="";

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = "AND assert_no LIKE '%".trim($_POST['searchtxt'])."%' OR asset_description LIKE '%".trim($_POST['searchtxt'])."%' OR purchase_date LIKE '%".trim($_POST['searchtxt'])."%'  ";
}

	$query = "SELECT COUNT(*) as num FROM $tbl_name as a inner join asset_type as t on a.asset_type = t.code WHERE a.active = 1 and a.custodian = $cust ". $sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=asset"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */

	//echo $cust;
	$sql="SELECT *,a.alert_flag as aaf, a.id as aid FROM $tbl_name as a inner join asset_type as t on a.asset_type = t.code WHERE a.active = 1 and a.custodian = $cust $sqlfilter ORDER BY  a.id LIMIT $start, $limit ";
	//echo $sql;

	$result = mysql_query($sql);

		if(isset($_GET['msg'])) echo "<br><center><font color=green><strong>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<br><center><font color=red><strong>".$_GET['cmsg']."</strong></font></center><br>";
		
					?> 
					
      </p>
      <form name="" action="" method="post">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Asset No </strong></td>
			<td width="91"><strong>Asset Type</strong></td>
			<td width="128"><strong>Description</strong></td>
			<td width="128"><strong>Allocation Project</strong></td>
			<td width="128"><strong>Action</strong></td>
			
			
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
      	<td width="117"><?php echo $row['name']; ?></td>
        <td width="117"><?php echo $row['asset_description']; ?></td>
        <td width="117"><?php echo $row['alloc_project']; ?></td>
        <td><a width="75">
		<?php
		$sql="select count(id) num from asset_allocation where asset = '".$row['assert_no']."' and active= 1 and custodian = ".$_SESSION[SITE_NAME]['person'];
		//echo $row['aaf'];
		$lin =  $db->queryUniqueObject($sql);
		//var_dump ($lin);
		if($row['aaf'] =='N' || $row['aaf'] =='E' )
		{
			if($row['alloc_status']=='Allocated' && $lin->num > 0){
		?>
		<a width="130"><a onclick="return confirm('Are you sure you want to RETURN this Asset?')" href="index.php?c=accept_decline&srce=ast&op=R&assert_no=<?php echo $row['assert_no'];?>">[Return]</a>
		<?php
		}
		if($row['alloc_status']=="Allocated - Awaiting Custodian Acceptance" && $lin->num > 0){
		?>
		<a width="130"><a href="index.php?c=accept_decline&srce=ast&op=A&assert_no=<?php echo $row['assert_no'];?>">[Accept]</a>
		<a width="130"><a onclick="return confirm('Confirm you want to DECLINE Allocation of this Asset?')" href="index.php?c=capture_reason&srce=ast&op=D&assert_no=<?php echo $row['assert_no'];?>">[Decline]</a>
			
		<?php } } ?>
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