 <div id="content">
      <br><legend>Manage Asset Data</legend>
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
			
		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active = 1 and alert_flag = 'A' "; }

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=assert_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")  {

		$sql="SELECT * FROM $tbl_name WHERE  active = 1 $sqlfilter ORDER BY id LIMIT $start, $limit ";  }
		
	else  {

		$count = $db->countOf("assets","active='1' and alert_flag = 'A' ");
			 //echo $count;
			
		$sql="SELECT * FROM $tbl_name WHERE  active = 1 and alert_flag = 'A' ORDER BY id LIMIT $start, $limit ";  }

//var_dump($_SESSION[SITE_NAME]);
//echo $sql;
	$result = mysql_query($sql);

	if (isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") {  ?>
	
	<br/>  <?php }  else {  ?>
	  <tr>
            <td width="486"><font color = "blue"><strong>NOTE:-</strong> This Following List Contains Assets Requiring <strong>Active</strong> User Attention Only - To Initiate <strong>Passive</strong> User Action e.g. Edit, Deactivate or Reprint Barcode For ALL Other Assets Search By Asset No. or Description or Serial No. Using Search Box Above</font></td>
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
			<td width="91"><strong>Asset Type</strong></td>
			<td width="128"><strong>Description</strong></td>
			<td width="128"><strong>Allocation Status</strong></td>
			<td width="102"><strong>Action </strong></td>
			
          <!--  <td width="49"><strong>Deactivate</strong></td>-->
                    
          </tr>

		  <?php

								while($row = mysql_fetch_array($result))

		{

			$aclass = $db->queryUniqueObject("SELECT * FROM asset_group WHERE code= '$row[asset_group]'");
			$atype = $db->queryUniqueObject("SELECT * FROM asset_type WHERE code='$row[asset_type]'");

										 ?>

  											<tr>


       	<!--td width="87"><?php echo $row['assert_no']; ?></td-->
		<td width="87"><?php if ($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['alloc_status']=="New Asset - Awaiting Confirmation"){ ?>
			<a onclick="return confirm('This Allows You To Correct/Amend Initial Asset Values Before Activation - Confirm you want to make changes to this New Asset?')" href="index.php?c=asset_edit&id=<?php echo  $row['id'];?>"><?php echo $row['assert_no']; ?></a>
			<?php } else { ?>
			<a href="index.php?c=assetDetails&id=<?php echo  $row['id'];?>"><?php echo $row['assert_no']; ?></a>
			<?php } ?></td>
      	<td width="117"><?php echo $atype->name; ?></td>
        <td width="117"><?php echo $row['asset_description']; ?></td>
        <td width="117"><?php echo $row['alloc_status']; ?></td>
      <td>
		<?php 
			if($_SESSION[SITE_NAME]['a_init']=="1" && $row['alert_flag'] =='N' && $row['alloc_status']=="Awaiting Allocation"){
			?>
			<a onclick="return confirm('CONFIRM you want to Deactivate or Dispose of this Asset?')" href="index.php?c=deactivate&assert_no=<?php echo $row['assert_no'];?>">[Deactivate/Dispose]<br></a>
		<?php 
		}  
			if ($row['alloc_status'] <> "New Asset - Awaiting Confirmation" && $row['alloc_status'] <> "Asset Deactivated / Disposed"){
			?>
			<a href="tcpdf/examples/barcode1.php?value=<?php echo $row['assert_no'];?>&at=<?php echo $aclass->name;?>&ac=<?php echo $atype->name;?>" target="_blank">[Barcode]</a>
			<a href="index.php?c=asset_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<?php 
		}
			if ($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['alloc_status']=="New Asset - Awaiting Confirmation"){
			?>
			<a onclick="return confirm('Confirm you want to Activate this New Asset?')" href="index.php?c=asset_edit&op=Con&id=<?php echo $row['id'];?>">[Confirm]</a>
			<a onclick="return confirm('Confirm you want to Reject Activation of this New Asset? This will Permanently DELETE the Asset, Cancel and Click on the Asset No. instead to Correct/Amend ANY Initial Values before Activation')" href="index.php?c=confirm_reject&assert_no=<?php echo $row['assert_no'];?>">[Reject]</a>
		<?php 
		}
			if($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['alloc_status']=="Asset Deactivation - Awaiting Approval"){
			?>
			<a onclick="return confirm('Do you Approve of the DeActivation of this Asset?')" href="index.php?c=accept_decline&srce=cad&op=Apr&assert_no=<?php echo $row['assert_no'];?>">[Approve]</a>
			<a onclick="return confirm('You are Declining the DeActivation of this Asset?')" href="index.php?c=accept_decline&srce=cad&op=Dis&assert_no=<?php echo $row['assert_no'];?>">[Disapprove]</a>
		<?php 
		}
		?>
		</td>
		</tr> 

         <?php  }  ?>
									  
	
		</table></td>
		
        <?php	
		
			if((isset($_POST['Search']) AND trim($_POST['searchtxt'])!="") || (isset($_GET['alert'])))  {}
			elseif ($count == 0) {echo "<br/><center><font color=red>There Are No Assets Requiring Central Admin Active Attention At This Time!!</font></center><br/><br/>";  } ?>
	
      </tr>
	  <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    

	</form>
    
<div id="respond"></div>
<p>
	<?php if($_SESSION[SITE_NAME]['a_init']=="1"){
			?>
		<a href="index.php?c=asset_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Asset <i class="fa fa-user"></i></a>
		<?php 
		}
		?>
		</p>
    </div>