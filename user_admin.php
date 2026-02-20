  <div id="content">
      <br><legend>User Data</legend>
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




	$tbl_name="_user";		//your table name

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
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE  active =1 ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=user_admin"; 	//your file name  (the name of this file)
	
	
	
include("pagination.php");
	/* Get data. */



//$sql="SELECT * FROM _user WHERE user_type!= 'User' AND active= 1".$sqlfilter." ORDER BY firstname desc LIMIT $start, $limit ";
$sql="SELECT * FROM _user WHERE active= 1".$sqlfilter." ORDER BY firstname desc LIMIT $start, $limit ";


	$result = mysql_query($sql);

	

?>
     <?php if(isset($_GET['msg'])) echo "<center><font color=red  >".$_GET['msg']."</font></center>"; 
			?> 
     <input name="table" type="hidden" value="patients" />
      <input name="return" type="hidden" value="patients.php" />
      </p>
      <form name="deletefiles" action="deleteselected.php" method="post">
	 <input name="table" type="hidden" value="customer_details">
	 <input name="return" type="hidden" value="view_customer_details.php">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <br />

       <tr>

        <td align="center">
		
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
	
<thead>
          <tr>

            <th width="87"> Name </th>

            <th width="91">Surname</th>

           <!-- <td width="117"><strong>Patient Number </strong></td>-->
			<th width="128">Role</th>
            <th width="102">Action</th>
			
           <!-- <th width="49">Deactivate</th>
            <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>

		  <tbody>

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr >



       	<td width="87"><?php echo $row['firstname']; ?></td>

        <td width="91"><?php echo $row['surname']; ?></td>

        <td width="117"><?php echo $row['user_type']; ?></td>

        

        <!--<td width="102">&nbsp;</td>-->
		<td width="130"><a href="index.php?c=user_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<a href="index.php?c=user_prof_details&id=<?php echo $row['id'];?>">[View]</a>
		<a onclick="return confirm('CONFIRM you want to RESET PASSWORD for this User?')" href="index.php?c=user_edit&id=<?php echo $row['id'];?>&op=R">[ResetPword]</a></td>
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
<!--p><a href="index.php?c=user_edit" class="btn btn-theme-dark btn-ico btn-lg">Add User <i class="fa fa-user"></i></a></p-->
    </div>