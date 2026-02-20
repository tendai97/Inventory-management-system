<div id="content">
      <br/><legend>Supplier / Partner Data:- <?php if ($_GET['flag'] == 'A') echo "Active "; else echo "Inactive "; ?></legend> 

      <table width="700" border="0" cellspacing="0" cellpadding="0">
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

	$tbl_name="supplier_partner";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
	
	

		$flag = $_GET['flag'];
		$sqlfilter ="";

if(isset($_GET['alert'])){
	$sqlfilter=" and (alert_flag='A' or alert_flag='S') ";
	
}

		if ($flag == 'A')	{

			if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
		{
		$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
		}
		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  activity_status = 'Active' ".$sqlfilter;

			$total_pages = mysql_fetch_array(mysql_query($query));

			$total_pages = $total_pages[num];

			

			/* Setup vars for query. */

			$targetpage = "index.php?c=partner_admin"; 	//your file name  (the name of this file)
			
			
			
		include("pagination.php");
			/* Get data. */



		$sql="SELECT * FROM $tbl_name WHERE  activity_status = 'Active' ".$sqlfilter." ORDER BY alert_flag, name LIMIT $start, $limit ";

		//echo $sql;
			$result = mysql_query($sql);	}

		else {

			if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
		{
		$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
		}
		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  activity_status <> 'Active'  ".$sqlfilter;

			$total_pages = mysql_fetch_array(mysql_query($query));

			$total_pages = $total_pages[num];

			

			/* Setup vars for query. */

			$targetpage = "index.php?c=partner_admin"; 	//your file name  (the name of this file)
			
			
			
		include("pagination.php");
			/* Get data. */



		$sql="SELECT * FROM $tbl_name WHERE  activity_status <> 'Active' ".$sqlfilter." ORDER BY alert_flag, name LIMIT $start, $limit ";

		//echo $sql;
			$result = mysql_query($sql);	}
			
		if(isset($_GET['msg'])) echo "<br><center><font color=green><strong>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<br><center><font color=red><strong>".$_GET['cmsg']."</strong></font></center><br>";
		
		if ($flag <> 'A')	{ 	?> 
			<br/><tr>
				<td width="486"><font color = "purple"><strong>NOTE:-</strong> A circled ? Mark Against Status Indicates Presence Of Additional Information - Click On The ? Mark To View The Details!!</font></td>
			</tr><br/>
		<?php	} 	?> 

      <tr>

         <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Code </strong></td>
			<td width="91"><strong>Supplier/Partner Name</strong></td>
			<td width="128"><strong>Description</strong></td>
			<td width="128"><strong>Activity Status</strong></td>
			<td width="102"><strong>Action </strong></td>
			
           <!-- <th width="49">Deactivate</th>-->
          
          
          </tr>

		  </thead>

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr>



       	<td width="87"><?php echo $row['code']; ?></td>

        <td width="91"><?php echo $row['name']; ?></td>

        <td width="128"><?php echo $row['description']; ?></td>
      
        <td width="128"><?php if ($flag == "A" || $row['activity_status']=='New - Awaiting Approval') echo $row['activity_status']; else { echo $row['activity_status'];?><a href="index.php?c=display_reason&id=<?php echo $row['id'];?>&src=Supp&flag=D" title="Click To View Reason For Inactive Status"> <i class="fa fa-question-circle"></i></a> <?php } ?></td>

		<td width="102"><?php if($row['active'] == 1) {?>
		<a href="index.php?c=partner_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<?php } if ($_SESSION[SITE_NAME]['f_apro']=="1" && $row['alert_flag'] =='A' && $row['activity_status']=='New - Awaiting Approval'){
			?>
		<a onclick="return confirm('CONFIRM you want to Activate this New Supplier/Partner?')" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=A">[Activate]</a>
		<a onclick="return confirm('CONFIRM you want to Reject Activation of this New Supplier/Partner? This will Irreversibly Deactivate the New Supplier/Partner, Cancel and Click on the Edit instead to Correct/Amend ANY Initial Values before Activation')" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=R">[Decline]</a>
		<?php } if($row['activity_status'] == "Active" && $row['alert_flag'] =='N') { ?>
		<a href="index.php?c=partner_review&id=<?php echo $row['id'];?>">[Review]</a>
		<?php } if ($row['activity_status'] == "Active" && $_SESSION[SITE_NAME]['f_init']=="1") { ?>
		<a onclick="return confirm('CONFIRM you want to Deactivate this Supplier/Partner Record?')" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=D">[Deactivate]</a>
		<?php } if($_SESSION[SITE_NAME]['f_apro']=="1" && $row['alert_flag'] =='A' && $row['activity_status']=="Deactivation - Awaiting Approval"){
			?>
			<a onclick="return confirm('CONFIRM you want to Approve of the DeActivation of this Supplier/Partner?')" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=Del">[Approve]</a>
			<a onclick="return confirm('CONFIRM you want to Reject the DeActivation of this Supplier/Partner?')" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=Rev">[Disapprove]</a>
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
<div id="respond"></div>
<p>
	<?php if($_SESSION[SITE_NAME]['f_init']=="1"){
			?>
			<a href="index.php?c=partner_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Supplier / Partner <i class="fa fa-user"></i></a>
	<?php } ?>
</p>
    </div>    