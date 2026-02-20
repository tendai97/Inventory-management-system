<div id="content">
      <br><legend>Manage Project Data:- <?php if ($_GET['flag'] == 'A') echo "Active Projects"; else echo "Inactive Projects"; ?></legend> 
      <table width="700" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
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

        <?php 

	$tbl_name="projects";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		$sqlfilter ="";
		$flag = $_GET['flag'];

if(isset($_GET['alert'])){
	$sqlfilter=" and (alert_flag='A' or alert_flag='S') ";
	
}

		if ($flag == 'A')	{

				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  status = 'Active' ".$sqlfilter;

				$total_pages = mysql_fetch_array(mysql_query($query));

				$total_pages = $total_pages[num];

				

				/* Setup vars for query. */

				$targetpage = "index.php?c=project_admin&flag=$flag"; 	//your file name  (the name of this file)
				
				
				
			include("pagination.php");
				/* Get data. */



			$sql="SELECT * FROM projects WHERE  status = 'Active'  ".$sqlfilter." ORDER BY name desc LIMIT $start, $limit ";


			$result = mysql_query($sql);  }

		else {
				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  status <> 'Active'  ".$sqlfilter;

				$total_pages = mysql_fetch_array(mysql_query($query));

				$total_pages = $total_pages[num];

				

				/* Setup vars for query. */

				$targetpage = "index.php?c=project_admin&flag=$flag"; 	//your file name  (the name of this file)
				
				
				
			include("pagination.php");
				/* Get data. */



			$sql="SELECT * FROM projects WHERE  status <> 'Active' ".$sqlfilter." ORDER BY name desc LIMIT $start, $limit ";


			$result = mysql_query($sql);  }

?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><font color=red><strong>".$_GET['cmsg']."</strong></font></center>";
		
		if ($flag == 'D')	{ 	?> 
			
			<tr>
				<td width="486"><font color = "blue"><strong>NOTE:-</strong> A circled ? Mark Against Trigger Indicates Presence Of Additional Information - Click On The ? Mark To View The Details!!</font></td>
			</tr><br/>

		<?php	} 	?> 
			
      <br/>
	  <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
<thead>
          <tr>
		
            <th width="8"> Code </th>

            <th width="125">Name</th>
			<th width="145">Donor</th>
			<th width="35">Location</th>
			<th width="35">Status</th>
			<th width="100"><?php if ($flag <> 'D') echo "Budget Holder"; else echo "Deactive Trigger";  ?></th>
            <th width="100">Action </th>
			
           <!-- <th width="49">Deactivate</th>-->
          
          
          </tr>

		  </thead>

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

										 ?>

  											<tr>

       	<td width="8"><a href="index.php?c=project_detail&id=<?php echo  $row['id'];?>"><?php echo $row['code']; ?></a></td>

        <td width="125"><?php echo $row['name']; ?></td>

        <td width="145"><?php echo $row['donor']; ?></td>
		
		<td width="35"><?php echo $row['location']; ?></td>
		
		<td width="35"><?php echo $row['status']; ?></td>
		
        <td width="100"><?php if ($flag <> "D") echo $row['budget']; elseif ($row['status'] == "New - Awaiting Activation" ) echo "New - Awaiting Activation"; else { echo $row['deactv_trigger'];?><a href="index.php?c=display_reason&id=<?php echo $row['id'];?>&src=Proj&flag=D" title="Click To View Reason For Inactive Status"> <i class="fa fa-question-circle"></i></a> <?php } ?></td>

		<td width="100">
		<?php if($row['status'] == "Active" ){
			?>
			<a href="index.php?c=project_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<?php if($_SESSION[SITE_NAME]['a_init']=="1"){
			?>
			<a onclick="return confirm('CAUTION!! This Action WILL DEACTIVATE the ENTIRE Project including ALL of its associated Budget Codes - Are you sure you want to PROCEED?')" href="index.php?c=project_edit&id=<?php echo $row['id'];?>&op=D">[Deactivate]</a>
		<?php }	}
		
		if (($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['status']=="New - Awaiting Activation" ) || ($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['status']=="Reinstatement - Awaiting Activation" )) {
			?>
			<a onclick="return confirm('CONFIRM you want to Activate this New Project?')" href="index.php?c=project_edit&id=<?php echo $row['id'];?>&op=A">[Activate]</a>
			<a onclick="return confirm('CONFIRM you want to Decline Activation of this Project?')" href="index.php?c=project_edit&id=<?php echo $row['id'];?>&op=Rev">[Decline]</a>
		<?php }  
		
		if (($_SESSION[SITE_NAME]['a_init']=="1" && $row['status']=="Deactivated" || ($_SESSION[SITE_NAME]['a_init']=="1" && $row['status']=="Activation/Reactivation Declined" ))) {
			?>
			<a onclick="return confirm('CONFIRM you want to Re-Activate this Project?')" href="index.php?c=project_edit&id=<?php echo $row['id'];?>&op=R">[Reactivate]</a>
			<?php } 
		
		if ($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['status']=="Deactivation - Awaiting Approval" ) {
			?>
			<a onclick="return confirm('CONFIRM you want to Approve Deactivation of this Project?')" href="index.php?c=project_edit&op=Del&id=<?php echo $row['id'];?>">[Approve]</a>
			<a onclick="return confirm('CONFIRM you want to Decline Deactivation of this Project?')" href="index.php?c=project_edit&op=Rev&id=<?php echo $row['id'];?>">[Decline]</a>
		<?php 
		} ?>		</td></tr> 

                                             <?php

									  }

?>

        </table></td>

      </tr>
	  <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>

	</form>
    
<div id="respond"></div>
	<?php if($_SESSION[SITE_NAME]['a_init']=="1"){
		?> 
			<p><a href="index.php?c=project_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Project <i class="fa fa-user"></i></a></p>
       <?php }  ?>
    </div>