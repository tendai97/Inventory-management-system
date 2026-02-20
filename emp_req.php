 <div id="content">
      <br><legend>Requests Data:- <?php if ($_GET['flag'] == 'P') echo "Pending Requests"; else if($_GET['flag'] == 'A') echo "Aprroved Requests"; else echo "Declined Requests" ; ?></legend> 
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
		$admin=$_SESSION[SITE_NAME]['id'] ;
		$flag = $_GET['flag'];
		if(isset($_GET['up']))
		{
			$up = $_GET['up'];

			if($up=="A" )
			{
				$sql="UPDATE requests set active = 0 where user_id=$admin and status='A' ";
				$db->query($sql);
			}
			else if($up=="D")
			{
				$sql="UPDATE requests set active = 0 where user_id=$admin and status='D' ";
				$db->query($sql);
			}
		}
		
if(isset($_GET['alert'])){
	$sqlfilter=" and (alert_flag='A' or alert_flag='S') ";
	
}



	$tbl_name="requests";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		if ($flag == 'P')	{

				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND user_id in(select id from users where name LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in (select id from assets where name  LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in(select id from assets where category in (select id from categories where name LIKE '%".trim($_POST['searchtxt'])."%' ))  ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE user_id=$admin and status = 'P' ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=req_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM requests WHERE user_id=$admin and status = 'P' ".$sqlfilter." ORDER BY id LIMIT $start, $limit ";

				$result = $db->query($sql);}

		 else if ($flag == 'A')	{

				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND user_id in(select id from users where name LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in (select id from assets where name  LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in(select id from assets where category in (select id from categories where name LIKE '%".trim($_POST['searchtxt'])."%' ))  ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE user_id=$admin and status = 'P' ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=req_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM requests WHERE user_id=$admin and status = 'A' ".$sqlfilter." ORDER BY id LIMIT $start, $limit ";
				$result = $db->query($sql);}

		else {
			
				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND user_id in(select id from users where name LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in (select id from assets where name  LIKE '%".trim($_POST['searchtxt'])."%') OR asset_id in(select id from assets where category in (select id from categories where name LIKE '%".trim($_POST['searchtxt'])."%' ))  ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE user_id=$admin and status = 'D' ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=req_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM requests WHERE user_id=$admin and status = 'D' ".$sqlfilter." ORDER BY id LIMIT $start, $limit ";
				$result = $db->query($sql); }


?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><font color=red><strong>".$_GET['cmsg']."</strong></font></center>";
		
		if ($flag == 'D')	{ 	?> 
			
			
		<?php	} 	?> 
			
      <br/>
	  <tr>

        <td align="center">
		
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
	
<thead>
          <tr>

            <th width="87"> Req No. </th>
            <th width="91">Description</th>
             <th width="91">Inventory Type</th>
            <th width="87"> Req Date</th>
			<th width="128">Req Quantity</th>
			<th width="128">Available</th>
            
			
           <!-- <th width="49">Deactivate</th>
            <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>

		  <tbody>
		  <?php

	 

								while($row = mysqli_fetch_array($result))

		{
			$emp = $db->queryUniqueObject("SELECT * FROM users WHERE id= '$row[user_id]'");
			$inv = $db->queryUniqueObject("SELECT * FROM assets WHERE id= '$row[asset_id]'");
			$cat= $db->queryUniqueObject("SELECT * FROM categories WHERE id= '$inv->category'");

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr >

		<td width="87"><?php echo $row['id']; ?></td>

       	<td width="87"><?php echo $inv->name; ?></td>

        <td width="91"><?php echo $cat->name; ?></td>

        <td width="117"><?php echo $row['date']; ?></td>

        <td width="117"><?php echo $row['quantity']; ?></i></a> </td>
        <td width="117"><?php  echo $inv->available ?></i></a> </td>

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

			
      
	
    </div>