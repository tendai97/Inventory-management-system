 <?php
 if(isset($_GET['id'])){
	 if($_GET['op']=='R'){
		 
		 $sql="UPDATE `allocation` SET  returned = 1 , `rtnTS` = NOW() , active=0 WHERE	`asset` = ".$_GET['id'];
			$db->query($sql);
			$sql="UPDATE `assets` SET  status = 'Unallocated'  WHERE	`id` = ".$_GET['id'];
			$db->query($sql);
	 }
	 if($_GET['op']=='A'){
		  $sql="UPDATE `allocation` SET `accepted` = 1 , `accepted_date` = NOW()  WHERE	`asset` = ".$_GET['id'];
			$db->query($sql);
			$sql="UPDATE `assets` SET  status = 'Allocated'  WHERE	`id` = ".$_GET['id'];
			$db->query($sql);
	 }
	  if($_GET['op']=='Rej'){
		  $sql="UPDATE `allocation` SET `reject` = 1 , `reject_date` = NOW(), active=0  WHERE	`asset` = ".$_GET['id'];
			$db->query($sql);
			$sql="UPDATE `assets` SET  status = 'Unallocated'  WHERE	`id` = ".$_GET['id'];
			$db->query($sql);
	 }
	 
 }
 ?>
 
 <div id="content">
      <h3> Asset Management</h3>
      <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><form action="" method="post" name="search" id="search2" >
            <input name="searchtxt" type="text" />
            &nbsp;&nbsp;
            <input name="Search" type="submit" value="Search" />
          </form></td>
          <td><form action="" method="get" name="page" id="page">
            Page per Record
            <input name="limit" type="text"  style="margin-left:5px;" value="<?php if(isset($_GET['limit'])) echo $_GET['limit']; else echo "10"; ?>" size="3" maxlength="3" />
            <input name="go" type="submit" value="Go" />
			 <input name="c" type="hidden" value="<?php echo $_GET['c'];?>" />
           <!-- <input type="button" name="selectall" value="SelectAll" onclick="checkAll()"  style="margin-left:5px;"/>
            <input name="dsubmit" type="button" value="View Selected" style="margin-left:5px;" onclick="return confirmDeleteSubmit()"/>-->
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
$sqlfilter = " AND firstname LIKE '%".trim($_POST['searchtxt'])."%' OR username LIKE '%".trim($_POST['searchtxt'])."%' OR surname LIKE '%".trim($_POST['searchtxt'])."%' ";
}
if($_SESSION[SITE_NAME]['usertype']=="Admin")

 $query = "SELECT COUNT(*) as num FROM $tbl_name as ass INNER JOIN persons AS p ON p.id=ass.custodian WHERE  ass.active =1 ".$sqlfilter;
else 
	$query = "SELECT COUNT(*) as num  FROM assets AS ass INNER JOIN allocation AS al ON ass.id = al.asset  INNER JOIN persons AS p ON p.id=al.custodian WHERE  al.active =1 and ass.active=1 and al.custodian= '".$_SESSION[SITE_NAME]['id']."' ".$sqlfilter;

//echo $query;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=user_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */


if($_SESSION[SITE_NAME]['usertype']=="Admin")
$sql="SELECT *,ass.id as sid FROM $tbl_name as ass INNER JOIN persons AS p ON p.id=ass.custodian WHERE  ass.active= 1 ".$sqlfilter." ORDER BY ass.id desc LIMIT $start, $limit ";
else 
	$sql = "SELECT *,ass.id as sid  FROM assets AS ass INNER JOIN allocation AS al ON ass.id = al.asset  INNER JOIN persons AS p ON p.id=al.custodian WHERE  al.active =1 and ass.active=1 and al.custodian= '".$_SESSION[SITE_NAME]['id']."' ".$sqlfilter;


//echo $sql;

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

      <table width="700" border="0" cellspacing="0" cellpadding="0">
<thead>
      <tr>

        <th bgcolor="#FFFFFF">View Asset Details</th>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>
</thead>
      <tr>

        <td align="center">
		
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped">
	
<thead>
          <tr>

            <th width="87"> Description </th>

            <th width="91">Asset No</th>

         
			<th width="128">Custodian</th>  
			<th width="117">Status</th>
            <th width="102">Action</th>
			
           <!--   <th width="49">Deactivate</th>
          <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>

		  <tbody>

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

		//var_dump($row);

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr >



       	<td width="87"><?php echo $row['description']; ?></td>

        <td width="91"><?php echo $row['assert_no']; ?></td>

        <td width="117"><?php echo $row['custodian']; ?></td>

        

        <td width="102"><?php echo $row['status']; ?></td>
		<td width="130">
		<?php
		$sql="select count(id) num from asset_allocation where asset = ".$row['sid']." and active= 1 and custodian = ".$_SESSION[SITE_NAME]['id'];
		$lin =  $db->queryUniqueObject($sql);
		if($row['status']=='Allocated' && $lin->num > 0){
		?>
		<a href="index.php?c=return&op=R&id=<?php echo $row['sid'];?>"><img src="images/edit-icon.png" border="0" alt="Return" /></a>
		<?php  }
		if($row['status']=="Awaiting" && $lin->num > 0){
		?>
		<a href="index.php?c=return&op=Rej&id=<?php echo $row['sid'];?>"><img src="images/edit-icon.png" border="0" alt="Reject" /></a>
		<a href="index.php?c=return&op=A&id=<?php echo $row['sid'];?>"><img src="images/edit-icon.png" border="0" alt="Accept" /></a>
		<?php } 
		if ($_SESSION[SITE_NAME]["ao"]=="1"){?>
		<a href="index.php?c=allocation&id=<?php echo $row['sid'];?>"><img src="images/edit-icon.png" border="0" alt="Allocate" /></a>
		<a href="index.php?c=dispose&id=<?php echo $row['sid'];?>"><img src="images/edit-icon.png" border="0" alt="Dispose" /></a>
		<?php } ?>
		</tr>
		<!--<td width="128"> <a href="index.php?c=user_details&sid=<?php echo $row['holder'];?>"><img src="images/view-icone-6308-128.png" width="20" height="20" /></a><a href="update_customer_details.php?sid=<?php echo $row['id'];?>"></a></td>-->
		<!--<a onclick="return confirmSubmit()" href="index.php?c=user_edit&id=<?php echo $row['id'];?>&op=D"><img src="images/delete.png" border="0" alt="Deactivate"></a></td>
		<!--<td width="52">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="<?php echo $row['id']; ?>" name="checklist[]" /></td>-->

							</tr> 


                                             <?php

									  }

							  			

?>


</tbody>
        </table></td>

      </tr>
<tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    

    </table>

	

	</form>
    
<div id="respond"></div>
<!--<p><a href="index.php?c=user_edit"><img src="images/add_user.gif" width="280" height="34" alt= "Add User"/></a></p>-->
    </div>