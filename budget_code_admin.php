 <div id="content">
      <br><legend>Manage Budget Code Data</legend>
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

	$tbl_name="budget_codes";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/

$sqlfilter ="";

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
}
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active =1 ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	/* Setup vars for query. */

	$targetpage = "index.php?c=budget_code_admin"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */


$sql="SELECT * FROM $tbl_name WHERE  active= 1".$sqlfilter." ORDER BY project_code, description LIMIT $start, $limit ";

	$result = mysql_query($sql);

?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><font color=red><strong>".$_GET['cmsg']."</strong></font></center>";
					?> 
      </p>
      <form name="deletefiles" action="" method="post">
       <tr>

      <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
		<thead>
          <tr>
		
            <th width="10%"><strong> Code </strong></th>
			<th width="25%"><strong>Description</strong></th>
            <th width="22%"><strong>Project Name</strong></th>
			<th width="14%"><strong>Project Code</strong></th>
			<th width="12%"><strong>Status</strong></th>
            <th width="17%"><strong>Action </strong></th>
			
          </tr>
		</thead>

		  <?php

								while($row = mysql_fetch_array($result))

		{

				 ?>

		<tbody>
			<tr>

       	<td width="87"><a href="index.php?c=budgetcde_detail&id=<?php echo  $row['id'];?>&src=bdj"><?php echo $row['code']; ?></a></td>

        <td width="117"><?php echo $row['description']; ?></td>
		
		<td width="91">	
             
			 <?php
			 $proj = $row['project_code'];
			 $sql="SELECT * FROM  projects where code = '$proj' and active = 1";
			 $line = $db->queryUniqueObject($sql);
			 		echo $line->name;
			
              ?></td>
      
       	<td width="60"><a href="index.php?c=project_detail&id=<?php echo  $line->id;?>&src=bdj"><?php echo $row['project_code']; ?></a></td>

        <td width="60"><?php echo $row['status']; ?></td>

		<td width="130"><?php if($row['alert_flag'] =='A' && $row['status']=="New - Awaiting Activation" ){
			?>
			<a onclick="return confirm('CONFIRM you want to Activate this New Budget Code?')" href="index.php?c=budget_code_edit&op=A&id=<?php echo $row['id'];?>">[Activate]</a>
			<a onclick="return confirm('CONFIRM you want to Decline Activation of this Budget Code?')" href="index.php?c=budget_code_edit&id=<?php echo $row['id'];?>&op=Rev">[Decline]</a>
		<?php }	?>
		<a href="index.php?c=budget_code_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<a onclick="return confirm('CAUTION!! This Action WILL DEACTIVATE the ENTIRE Budget Code including ALL of its associated Activity Codes - Are you sure you want to PROCEED?')" href="index.php?c=budget_code_edit&id=<?php echo $row['id'];?>&op=D">[Deactivate]</a></td>
		</tr> 
        <?php } ?>
		</tbody>
       </table></td>

        </tr>
		<tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

        </tr>
		</table>

	</form>
    
<div id="respond"></div>
<p><a href="index.php?c=budget_code_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Budget Code <i class="fa fa-user"></i></a></p>
    </div>