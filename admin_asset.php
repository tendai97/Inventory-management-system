 <div id="content">
      <br/><legend>Asset Management</legend>
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
	$sqlfilter = "AND assert_no LIKE '%".trim($_POST['searchtxt'])."%' OR asset_description LIKE '%".trim($_POST['searchtxt'])."%' OR serial_no LIKE '%".trim($_POST['searchtxt'])."%'  ";

		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active = 1 ".$sqlfilter;
}
	
		else   {
			
		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active = 1 and alert_flag = 'S' '"; }

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	/* Setup vars for query. */

	$targetpage = "index.php?c=admin_asset"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */

	if((isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") || (isset($_GET['alert'])))  {

		$sql="SELECT * FROM $tbl_name WHERE  active = 1 $sqlfilter ORDER BY id LIMIT $start, $limit ";  }
		
	else  {

		$count = $db->countOf("assets","active='1' and alert_flag = 'S' ");
			 //echo $count;
			
		$sql="SELECT * FROM $tbl_name WHERE  active = 1 and alert_flag = 'S' ORDER BY id LIMIT $start, $limit ";  }
	
	$result = mysql_query($sql);

	if (isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") {  ?>
	
	<br/>  <?php }  else {  ?>
	  <tr>
            <td width="486"><font color = "blue"><strong>NOTE:-</strong> This Following List Contains Assets Requiring <strong>Active</strong> Admin User Attention Only - To Initiate <strong>Passive</strong> Admin User Action e.g. Allocatation or Reclaiming For ALL Other Assets Search By Asset No. or Description or Serial No. Using Search Box Above</font></td>
         </tr><br/><br/>

	<?php }  		
	
	if(isset($_GET['msg'])) echo "<br><center><font color=green><strong>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<br><center><font color=red><strong>".$_GET['cmsg']."</strong></font></center><br>";
		
			?> 
					
      </p>
      <form name="" action="" method="post">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Asset No </strong></td>
			<?php if (isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") { ?> 
				<td width="91"><strong>Asset Type</strong></td>
			<?php  }  else  {  ?>
				<td width="91"><strong>Custodian</strong></td>
			<?php  }  ?>
			<td width="128"><strong>Description</strong></td>
			<td width="128"><strong>Allocation Status</strong></td>
			<td width="128"><strong>Action</strong></td>
			
			
          <!--  <td width="49"><strong>Deactivate</strong></td>-->
          
           </tr>

		  <?php

								while($row = mysql_fetch_array($result))

		{
			$atype = $db->queryUniqueObject("SELECT * FROM asset_type WHERE code='$row[asset_type]'");
			$cust = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = '$row[custodian]'");
										 ?>

 	<tr>
       	<td width="87"><a href="index.php?c=assetDetails&id=<?php echo  $row['id'];?>"><?php echo $row['assert_no']; ?></a></td>
		<?php if (isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") { ?> 
			<td width="117"><?php echo $atype->name; ?></td>
		<?php  }  else  {  ?>
			<td width="117"><?php echo $cust->firstname.' '.$cust->surname; ?></td>
		<?php  }  ?>
        <td width="117"><?php echo $row['asset_description']; ?></td>
        <td width="117"><?php echo $row['alloc_status']; ?></td>
        <td><a width="75">
		<?php
		
		$assert = $row['assert_no'];
		$count2 = $db->countOf("asset_allocation","active='1' and asset = '$assert' and allocate_status = 'Asset Allocated'");
			//echo $count2;
			
		if ($row['alert_flag'] =='N' && $_SESSION[SITE_NAME]['a_init']=="1" && $count2 == 0 && $row['alloc_status']=="Awaiting Allocation"){?>
			<a href="index.php?c=allocate&assert_no=<?php echo $row['assert_no'];?>">[Allocate]</a>
		<?php  }
		 
		elseif ($row['alert_flag'] =='N' && $_SESSION[SITE_NAME]['a_init']=="1" && $count2 > 0 && $row['alloc_status']=="Allocated"){?>
			<a width="130"><a onclick="return confirm('You are about to Unconditionally RECLAIM of this Asset from the Current Custodian - Confirm')" href="index.php?c=reclaim&assert_no=<?php echo $row['assert_no'];?>">[Reclaim]</a>
		<?php  }
		 
		elseif($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='S' && $row['alloc_status']=="Asset Return - Awaiting Confirmation"){
			?>
			<a onclick="return confirm('Confirm you want to Accept this Returned Asset?')" href="index.php?c=accept_decline&srce=atm&op=C&assert_no=<?php echo $row['assert_no'];?>">[Confirm]</a>
			<a onclick="return confirm('Confirm you want to Reject this Returned Asset?')" href="index.php?c=capture_reason&srce=atm&op=Rej&assert_no=<?php echo $row['assert_no'];?>">[Reject]</a>
			
		<?php 
		} elseif($_SESSION[SITE_NAME]['a_init']=="1" && $row['alert_flag'] =='S' && $row['alloc_status']=="Allocation Declined - Awaiting Confirmation"){
			?>
			<a onclick="return confirm('This is Confirmation of Declined Asset Allocation')" href="index.php?c=accept_decline&srce=atm&op=C&assert_no=<?php echo $row['assert_no'];?>">[Confirm]</a>
						
		<?php }  ?>
		</td>
	</tr> 


 <?php
	}
?>

        </table></td>
		
        <?php	
		
			if((isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") || (isset($_GET['alert'])))  {}
			elseif ($count == 0) {echo "<br/><center><font color=red>There Are No Assets Requiring Active Admin User Attention At This Time!!</font></center><br/><br/>";  } ?>
	
      </tr>

	   <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    </table>

	</form>
   
    </div>