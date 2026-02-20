 <div id="content">
      <br><legend>System Parameter Types Management</legend>
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




	$tbl_name="param_drpdwn";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
	
	

$sqlfilter ="";


	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND param_name LIKE '%".trim($_POST['searchtxt'])."%' OR type LIKE '%".trim($_POST['searchtxt'])."%' OR module LIKE '%".trim($_POST['searchtxt'])."%' ";
}

if($_SESSION[SITE_NAME]['ao'] == 1) 
	{ $query = "SELECT COUNT(*) as num FROM $tbl_name WHERE ao = 1 and active = 1 ".$sqlfilter; }
if($_SESSION[SITE_NAME]['ex'] == 1) 
	{$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE ex = 1 and active = 1 ".$sqlfilter; }
if($_SESSION[SITE_NAME]['hra'] == 1) 
	{$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE hra = 1 and active = 1 ".$sqlfilter; }
if($_SESSION[SITE_NAME]['fa'] == 1) 
	{$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE fa = 1 and active = 1 ".$sqlfilter; }
if($_SESSION[SITE_NAME]['ita'] == 1) 
	{$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE ita = 1 and active = 1 ".$sqlfilter; }

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=params_admin"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */

if($_SESSION[SITE_NAME]['ao'] == 1) 
	{$sql="SELECT * FROM param_drpdwn WHERE ao = 1 and active = 1".$sqlfilter." ORDER BY param_name LIMIT $start, $limit "; }
if($_SESSION[SITE_NAME]['ex'] == 1) 
	{$sql="SELECT * FROM param_drpdwn WHERE ex = 1 and active = 1".$sqlfilter." ORDER BY param_name LIMIT $start, $limit "; }
if($_SESSION[SITE_NAME]['hra'] == 1) 
	{$sql="SELECT * FROM param_drpdwn WHERE hra = 1 and active = 1".$sqlfilter." ORDER BY param_name LIMIT $start, $limit "; }
if($_SESSION[SITE_NAME]['fa'] == 1) 
	{$sql="SELECT * FROM param_drpdwn WHERE fa = 1 and active = 1".$sqlfilter." ORDER BY param_name LIMIT $start, $limit "; }
if($_SESSION[SITE_NAME]['ita'] == 1) 
	{$sql="SELECT * FROM param_drpdwn WHERE ita = 1 and active = 1".$sqlfilter." ORDER BY param_name LIMIT $start, $limit "; }

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

            <th width="10"><strong> Type Code </strong></th>
            <th width="85"><strong>System Parameter Name</strong></th>
			<th width="115"><strong>Applicable Module</strong></th>
            <th width="35"><strong>Action </strong></th>
			
         </tr>

</thead>		  

		  <?php

								while($row = mysql_fetch_array($result))

		{

										 ?>

  	<tr>

       	<td width="10"><?php echo $row['type']; ?></td>

        <td width="85"><?php echo $row['param_name']; ?></td>

        <td width="115"><?php if ($row['module'] == 'ALL') echo 'All Modules'; 
							  elseif ($row['module'] == 'ATM') echo 'Assets Management';
							  elseif ($row['module'] == 'LAM') echo 'Leave of Absence';
							  elseif ($row['module'] == 'RPO') echo 'Requistions & Purchase Orders';
							  elseif ($row['module'] == 'TAE') echo 'Travel Advances & Expenses';
							  elseif ($row['module'] == 'VLM') echo 'Vehicle Logging'; ?></td>
		        
		<td width="35"><a href="index.php?c=params_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<a onclick="return confirm('CONFIRM you want to De-activate this System Parameter?')" href="index.php?c=params_edit&id=<?php echo $row['id'];?>&op=D">]Deactivate]</a></td>

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
<p><a href="index.php?c=params_edit" class="btn btn-theme-dark btn-ico btn-lg">Add System Parameter <i class="fa fa-user"></i></a></p>
    </div>