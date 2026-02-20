 <div id="content">

        <?php 

	$tbl_name="parameters";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/	
	
	$sqlfilter="";
	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{

$sqlfilter = "AND name LIKE '%".trim($_POST['searchtxt'])."%' OR code LIKE '%".trim($_POST['searchtxt'])."%' OR  description LIKE '%".trim($_POST['searchtxt'])."%'  ";


}
$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE type = 'vehbody' and active = 1 $sqlfilter";
//echo $query;
	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=vehicle_body"; 	//your file name  (the name of this file)
	
	
	include ("core/pagination.php");

	/* Get data. */

	$sql="SELECT * FROM parameters WHERE  type = 'vehbody' and active= 1 $sqlfilter ORDER BY name LIMIT $start, $limit ";

	$result = mysql_query($sql);

	if(isset($_GET['msg'])) echo "<center><strong><font color=green>".$_GET['msg']."</font></strong></center>"; 
					
					if(isset($_GET['cmsg'])) echo "<center><strong><font color=red>".$_GET['cmsg']."</font></strong></center>";
					?> 
      <br/><legend>Vehicle Body Type Management</legend>
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

										 ?>

  	<tr>

       	<td width="10"><?php echo $row['code']; ?></td>

        <td width="85"><?php echo $row['name']; ?></td>

        <td width="115"><?php echo $row['description']; ?></td>
		        
		<td width="35"><a href="index.php?c=vehbdy_edit&id=<?php echo $row['id'];?>">[Edit]</a>
		<a onclick="return confirm('CONFIRM you want to Permanently Delete this Vehicle Body Type?')" href="index.php?c=vehbdy_edit&id=<?php echo $row['id'];?>&op=D">]Delete]</a></td>

		</tr> 

        <?php }  ?>
                              	  
        </table></td>

      </tr>
	  <tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
	</form>
    
<div id="respond"></div>
<p><a href="index.php?c=vehbdy_edit" class="btn btn-theme-dark btn-ico btn-lg">Add Vehicle Body Type</a></p>
    </div>