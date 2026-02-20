 <div id="content">
      <br><legend>Manage Inventory Data:- <?php if ($_GET['flag'] == 'A') echo "In Stock Inventory "; else echo "Out Of Stock"; ?></legend> 
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
	<br>
      
      <p>
        <?php 
		$sqlfilter ="";
		$flag = $_GET['flag'];
		
if(isset($_GET['alert'])){
	$sqlfilter=" and (alert_flag='A' or alert_flag='S') ";
	
}



	$tbl_name="assets";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		if ($flag == 'D')	{

				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR available LIKE '%".trim($_POST['searchtxt'])."%' OR id LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  available <= '0' ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=inv_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM assets WHERE  available <= '0' ".$sqlfilter." ORDER BY name LIMIT $start, $limit ";

				$result = $db->query($sql);}

		else {
			
				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR available LIKE '%".trim($_POST['searchtxt'])."%' OR id LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  available > 0 ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=inv_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM assets WHERE  available > 0 ".$sqlfilter." ORDER BY name LIMIT $start, $limit ";

				$result = $db->query($sql); }


?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><font color=red><strong>".$_GET['cmsg']."</strong></font></center>";
		
		if ($flag == 'D')	{ 	?> 
			
			
		<?php	} 	?> 
		 <tr>
            <td width="486"><font color = "blue"><strong>NOTE:-</strong> By clicking the pending request you can directly go to the request Menu <strong></font></td>
         </tr><br/><br/>
			
      <br/>
	  <tr>

        <td align="center">
		
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
	
<thead>
          <tr>

            <th width="87"> Inv No. </th>
			<th width="87"> Description </th>
            <th width="91">Available</th>

           <!-- <td width="117"><strong>Patient Number </strong></td>-->
			<th width="128">Used</th>
			<th width="128">Pending Requests</th>
            <th width="102">Action</th>
			
           <!-- <th width="49">Deactivate</th>
            <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>

		  <tbody>

		  

		  <?php

	 

								while($row = mysqli_fetch_array($result))

		{

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr >

		<td width="87"><?php echo $row['id']; ?></td>

       	<td width="87"><?php echo $row['name']; ?></td>

        <td width="91"><?php echo $row['available']; ?></td>

        <td width="117"><?php echo $row['used']; ?></td>

        <td width="117"><?php $count = $db->countOf("requests","asset_id={$row['id']} and status='P'") ;
        			if($count > 0)
						{?>
						<a href="index.php?c=req_admin&flag=P"><?php echo $count; ?></a><?php }else echo $count?> [view]  </td>

		<td width="130">
		<?php if($flag == 'A'){
			?>
		<a href="index.php?c=inv_edit&id=<?php echo $row['id'];?>&op=E">[ADD or Edit ]</a>
		<!--
		<a onclick="return confirm('CONFIRM you want to De-activate this Employee Record?')" href="index.php?c=emp_acc&id=<?php echo $row['id'];?>&flag=A">[Deactivate Stock]</a>
		-->
		<?php } 
		
		if ($flag == 'D') {
			?>
			<a href="index.php?c=inv_edit&id=<?php echo $row['id'];?>&op=E">[ADD or Edit]</a>
			<!--
			<a onclick="return confirm('CONFIRM you want to Re-Activate this Employee Record?')" href="index.php?c=emp_acc&id=<?php echo $row['id'];?>&flag=D">[Reactivate Stock]</a>
		-->

		<?php }  ?>
			</td></tr> 


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

			<p><a href="index.php?c=emp_edit" class="btn btn-theme-dark btn-ico btn-lg">Add New Invetory <i class="fa fa-briefcase"></i></a></p>
      
	
    </div>