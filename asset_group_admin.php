 <div id="content">
      <br><legend>Manage Asset Class Data</legend> 
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




	$tbl_name="asset_group";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		$adminregion="";
$admin = $db->queryUniqueObject("SELECT *  FROM _user WHERE username='".$_SESSION[SITE_NAME]['username']."'");
if (isset($admin->region)){
$adminregion=" and region= ".$admin->region;
}
	

$sqlfilter ="";

if(isset($_GET['alert'])){
	$sqlfilter=" and (status='New - Awaiting Activation') ";
	
}


	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
}
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active =1  $adminregion ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=asset_group_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */



$sql="SELECT * FROM $tbl_name WHERE  active= 1  $adminregion ".$sqlfilter." ORDER BY name desc LIMIT $start, $limit ";


	$result = mysql_query($sql);

		if(isset($_GET['msg'])) echo "<br><center><font color=green><strong>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<br><center><font color=red><strong>".$_GET['cmsg']."</strong></font></center><br>";
		
			?> 
     </p>
      <form name="deletefiles" action="" method="post">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Code </strong></td>
            <td width="91"><strong>Name</strong></td>
			<td width="128"><strong>Description</strong></td>
			<th width="115"><strong>Status</strong></th>
            <td width="102"><strong>Action</strong></td>
          
          </tr>

		  <?php

								while($row = mysql_fetch_array($result))

		{

										 ?>

  											<tr>

       	<td width="87"><?php echo $row['code']; ?></td>

        <td width="91"><?php echo $row['name']; ?></td>

        <td width="117"><?php echo $row['description']; ?></td>
       
        <td width="115"><?php echo $row['status']; ?></td>
		        
		<td width="130"><a href="index.php?c=asset_group_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<?php if ($_SESSION[SITE_NAME]['a_apro']=="1" && $row['alert_flag'] =='A' && $row['status']=='New - Awaiting Activation'){
			?>
		<a onclick="return confirm('CONFIRM you want to Activate this New Asset Class?')" href="index.php?c=asset_group_edit&id=<?php echo $row['id'];?>&op=A">[Activate]</a>
		<a onclick="return confirm('CONFIRM you want to Reject Activation of this New Asset Class? This will Irreversibly Deactivate the New Asset Class, Cancel and Click on the Edit instead to Correct/Amend ANY Initial Values before Activation')" href="index.php?c=asset_group_edit&id=<?php echo $row['id'];?>&op=R">[Decline]</a>
		<?php } ?>
		<a onclick="return confirm('CONFIRM you want to Deactivate this Asset Class? This will Irreversibly Deactivate the Asset Class')" href="index.php?c=asset_group_edit&id=<?php echo $row['id'];?>&op=D">[Deactivate]</a></td>
		</tr> 

        <?php } ?>

        </table></td>

      </tr>
<tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>

	</form>
    
<div id="respond"></div>
<p>
	<?php if($_SESSION[SITE_NAME]['a_init']=="1"){
			?>
		<a href="index.php?c=asset_group_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Asset Class <i class="fa fa-user"></i></a>
	<?php } ?>
</p>
    </div>
	