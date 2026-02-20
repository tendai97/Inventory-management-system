 <div id="content">
      <br><legend>Geographic Location Management</legend>
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
      <p>
        <?php 




	$tbl_name="parameters";		//your table name

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
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  type = 'geoloc' and active =1 ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=location_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */



$sql="SELECT * FROM parameters WHERE  type = 'geoloc' and active= 1".$sqlfilter." ORDER BY name LIMIT $start, $limit ";


	$result = mysql_query($sql);

	

?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><font color=red><strong>".$_GET['cmsg']."</strong></font></center>";
					?> 
     <input name="table" type="hidden" value="patients" />
      <input name="return" type="hidden" value="patients.php" />
      </p>
      <form name="deletefiles" action="deleteselected.php" method="post">
	 <input name="table" type="hidden" value="customer_details">
	 <input name="return" type="hidden" value="view_customer_details.php">

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
<thead>

      <tr>

            <th width="10"><strong> Code </strong></th>
            <th width="85"><strong>Name</strong></th>
			<th width="115"><strong>Description</strong></th>
            <th width="35"><strong>Action </strong></th>
			
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

       	<td width="10"><?php echo $row['code']; ?></td>

        <td width="85"><?php echo $row['name']; ?></td>

        <td width="115"><?php echo $row['description']; ?></td>
		        
		<td width="35"><a href="index.php?c=location_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<?php if($row['alert_flag'] =='A' && $row['status']=='New - Awaiting Activation') {?>
		<a onclick="return confirm('CONFIRM you want to Activate this New Location?')" href="index.php?c=location_edit&id=<?php echo $row['id'];?>&op=A">[Activate]</a>
		<?php } ?>
		<a onclick="return confirm('CONFIRM you want to De-activate this Location?')" href="index.php?c=location_edit&id=<?php echo $row['id'];?>&op=D">]Deactivate]</a></td>

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
<p><a href="index.php?c=location_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Geo Location <i class="fa fa-user"></i></a></p>
    </div>