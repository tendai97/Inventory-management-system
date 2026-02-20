 <div id="content">
      <br/><legend>Make Inventory Request</legend>
      <table width="700" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered" >
        <tr>
          <td><form action="" method="post" name="search" id="search2" >
            <input name="searchtxt" type="text" class="form-control" value="<?php echo $_POST['searchtxt']; ?>" />
            &nbsp;&nbsp;
            <input name="Search" type="submit" value="Search" class="btn btn-pad btn-primary" />
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
        $u_id= $_SESSION[SITE_NAME]['id'] ;
	
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
$sqlfilter = "AND category in(select id from categories where name LIKE '%".trim($_POST['searchtxt'])."%' ) or name LIKE '%".trim($_POST['searchtxt'])."%' OR id LIKE '%".trim($_POST['searchtxt'])."%' OR available LIKE '%".trim($_POST['searchtxt'])."%' ";
}

	$query = "SELECT COUNT(*) as num FROM $tbl_name  WHERE 1 ". $sqlfilter;

	$total_pages = mysqli_fetch_array($db->query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=req_inv"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */

	//echo $cust;
	$sql="SELECT * FROM $tbl_name  WHERE 1 $sqlfilter ORDER BY  id LIMIT $start, $limit ";
	//echo $sql;

	$result = $db->query($sql);

		if(isset($_GET['msg'])) echo "<br><center><font color=green><strong>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<br><center><font color=red><strong>".$_GET['cmsg']."</strong></font></center><br>";
		
					?> 
					
      </p>
      <form name="" action="" method="post">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>
		
            <td width="87"><strong> Asset No </strong></td>
			<td width="91"><strong> Asset Type</strong></td>
			<td width="128"><strong>Description</strong></td>
			<td width="128"><strong>Avalable</strong></td>
			<td width="128"><strong>Action</strong></td>
			
			
          <!--  <td width="49"><strong>Deactivate</strong></td>-->
          
           </tr>

		  <?php

								while($row = mysqli_fetch_array($result))

		{
		 $cat = $db->queryUniqueObject("SELECT * FROM categories WHERE id= '$row[category]'");

										 ?>

 	<tr>
       	<td width="87"><?php echo $row['id']; ?></td>
      	<td width="117"><?php echo $cat->name; ?></td>
        <td width="117"><?php echo $row['name']; ?></td>
        <td width="117"><?php echo $row['available']; ?></td>
        <td>
		<?php
		
		if($row['available'] ==0 )
		{
			echo "OUT OF STOCK"

		?>
		
		<?php
		}
		else{
		?>
		<a href="javascript: void(0)" onclick="popup('request_check.php?inv_id=<?php echo $row[id];?>&cat=<?php echo $cat->id;?>&u_id=<?php echo $u_id;?>')">[Request]</a>
	
			
		<?php } } ?>
		</td>
	</tr> 


 <?php
	
?>

        </table></td>
		
      </tr>

	   <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    </table>

	

	</form>
   
    </div>
    <script type="text/javascript">
<!--
function popup(url) 
{
 var width  = 300;
 var height = 500;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 	 return false;
}
// -->
</script>	 