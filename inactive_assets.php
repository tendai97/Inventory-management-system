 <div id="content">
      <br><legend>View Inactive Assets Data</legend>
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

		$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active = 0 ".$sqlfilter;
}

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=inactive_assets"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")  {

		$sql="SELECT * FROM $tbl_name WHERE  active = 0 $sqlfilter ORDER BY id LIMIT $start, $limit ";  }
		
	else  {

		$count = $db->countOf("assets","active='0'");
			 //echo $count;
			
		$sql="SELECT * FROM $tbl_name WHERE  active = 0 ORDER BY id LIMIT $start, $limit ";  }

//var_dump($_SESSION[SITE_NAME]);
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
			<td width="128"><strong>Status</strong></td>
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

		<td width="87"><a href="index.php?c=assetDetails&id=<?php echo  $row['id'];?>"><?php echo $row['assert_no']; ?></a></td>
      	<td width="117"><?php echo $atype->name; ?></td>
        <td width="117"><?php echo $row['asset_description']; ?></td>
        <td width="117"><?php echo $row['alloc_status']; ?></td>
		<td><a href="index.php?c=display_reason&id=<?php echo  $row['id'];?>&src=Asset&flag=D">[View Reason]</a></td>
		</tr> 

         <?php  }  ?>
									  
	
		</table></td>
		
        <?php	
		
			if ($count == 0) {echo "<br/><center><font color=red>There Are No Inactive Assets To Display At This Time!!</font></center><br/><br/>";  } ?>
	
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