<div id="content">
      <h3>Supplier / Partner Data</h3>
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
	
	
	

$sqlfilter ="";


	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR description LIKE '%".trim($_POST['searchtxt'])."%' ";
}
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active =1 ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=partner_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */



$sql="SELECT * FROM $tbl_name WHERE  active= 1".$sqlfilter." ORDER BY name desc LIMIT $start, $limit ";


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

      <tr>

        <td bgcolor="#FFFFFF"><div align="center"><strong><span class="style1">View Partner Details </span></strong></div></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped">
<thead>
          <tr>
		
            <th width="87"> Code </th>

            <th width="91">Name</th>
			<th width="128">Description</th>

          <!--  <td width="102"><strong>Edit </strong></td>
			
            <td width="49"><strong>Deactivate</strong></td>-->
          
          
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

        <td width="117"><?php echo $row['description']; ?></td>
      
		<!--<td width="130"><a href="index.php?c=partner_edit&id=<?php echo $row['id'];?>"><img src="images/edit-icon.png" border="0" alt="edit" /></a></td>
		
		<td width="49"><a onclick="return confirmSubmit()" href="index.php?c=partner_edit&id=<?php echo $row['id'];?>&op=D"><img src="images/delete.png" border="0" alt="Deactivate"></a></td>-->
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
<!--<p><a href="index.php?c=partner_edit"><img src="images/add_user.gif" width="280" height="34" alt= "Add Supplier / Partner"/></a></p>-->
    </div>