 <div id="content">
      <br><legend>Manage Category Data:- </legend> 
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



	$tbl_name="categories";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
		if ($flag == 'D')	{

				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR name LIKE '%".trim($_POST['searchtxt'])."%' OR id LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE 1 ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=emp_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM categories WHERE  1 ".$sqlfilter." ORDER BY name LIMIT $start, $limit ";

				$result = $db->query($sql);}

		else {
			
				if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
			{
			$sqlfilter = " AND name LIKE '%".trim($_POST['searchtxt'])."%' OR name LIKE '%".trim($_POST['searchtxt'])."%' OR id LIKE '%".trim($_POST['searchtxt'])."%' ";
			}
			$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE 1 ".$sqlfilter;

				$total_pages = mysqli_fetch_array($db->query($query));

				$total_pages = $total_pages[num];

				/* Setup vars for query. */

				$targetpage = "index.php?c=cat_admin&flag=$flag"; 	//your file name  (the name of this file)
				
			include("pagination.php"); 
					
			/* Get data. */

			$sql="SELECT * FROM categories WHERE  1 ".$sqlfilter." ORDER BY name LIMIT $start, $limit ";

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

            <tr>

            <th width="87"> Cat No. </th>
			<th width="87"> Name </th>
            <th width="91">Date Created</th>

           <!-- <td width="117"><strong>Patient Number </strong></td>-->
			<th width="128"> Category Assets </th>
            <th width="102">Action</th>
			
           <!-- <th width="49">Deactivate</th>
            <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>

		  <tbody>

		  

		  <?php

	 

								while($row = mysqli_fetch_array($result))

		{
			$count = $db->countOf("assets", "category={$row['id']}");

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr >

		<td width="87"><?php echo $row['id']; ?></td>

       	<td width="87"><?php echo $row['name']; ?></td>

        <td width="91"><?php echo $row['date']; ?></td>

        <td width="117"><?php echo $count; ?></td>

        <td width="117"><a href="index.php?c=cat_edit&id=<?php echo $row['id'];?>&op=E">[Edit]</a></td>

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

			<p><a href="index.php?c=cat_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Category Record <i class="fa fa-bank"></i></a></p>
      
	
    </div>