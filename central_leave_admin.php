 <div id="content">
      <legend>Manage Employee Leave Types</legend> 
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




	$tbl_name="leave_type";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		
$sqlfilter ="";


	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
}
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active =1  ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=central_leave_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */



$sql="SELECT * FROM $tbl_name WHERE  active= 1 ".$sqlfilter." ORDER BY name LIMIT $start, $limit ";


	$result = mysql_query($sql);

	

?>
     <?php if(isset($_GET['msg'])) echo "Record ID:[ ".$_GET['id']." ] <center>".$_GET['msg']."</center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center>".$_GET['cmsg']."</center>";
					?> 
     <input name="table" type="hidden" value="patients" />
      <input name="return" type="hidden" value="patients.php" />
      </p>
      <form name="deletefiles" action="deleteselected.php" method="post">
	 <input name="table" type="hidden" value="customer_details">
	 <input name="return" type="hidden" value="view_customer_details.php">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="5%"><strong> Code </strong></td>

            <td width="25%"><strong>Name</strong></td>
			<td width="35%"><strong>Description</strong></td>
            <td width="10%"><strong>Annual Ent (W/A)</strong></td>
            <td width="10%"><strong>Days to Escalation</strong></td>
            <td width="15%"><strong>Action</strong></td>
			
          </tr>

		  <?php

	
								while($row = mysql_fetch_array($result))

		{

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr>



       	<td width="5%"><?php echo $row['code']; ?></td>

        <td width="25%"><?php echo $row['name']; ?></td>

        <td width="35%"><?php echo $row['description']; ?></td>
         
		<td width="10%"><?php echo $row['entitlement']; ?></td>
     
        <td width="10%"><?php echo $row['esc_days']; ?></td>
     
        <td width="15%"><a href="index.php?c=leave_type_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		
		<?php 
		
		if($_SESSION[SITE_NAME]['h_apro']=="1" && $row['alert_flag'] =='A' && $row['status']=="New - Awaiting Confirmation" ){
			?>
			<a width="130"><a href="index.php?c=leave_type_edit&op=A&id=<?php echo $row['id'];?>&op=A">[Confirm]</a>
		<?php }  
		
		if($row['status'] == "Active" ){
			?>
			<a onclick="return confirm('CONFIRM you want to Deactivate this Leave Type?')" href="index.php?c=leave_type_edit&id=<?php echo $row['id'];?>&op=D">[Deactivate]</a></td>
		<?php }  ?>
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
		<?php if($_SESSION[SITE_NAME]['h_init']=="1")  {  ?>
				<a href="index.php?c=leave_type_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Leave Type <i class="fa fa-user"></i></a>
		<?php 	} ?>		
</p>
    </div>