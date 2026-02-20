<div id="content">
      <br><legend>Manage Staff Bulletin Articles</legend> 
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


	$author = $_SESSION [SITE_NAME]["person"];
	$tbl_name="bulletin_posts";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/

$sqlfilter ="";

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
$sqlfilter = " AND department LIKE '%".trim($_POST['searchtxt'])."%' OR firstname LIKE '%".trim($_POST['searchtxt'])."%' OR surname LIKE '%".trim($_POST['searchtxt'])."%' ";
}
$query = "SELECT COUNT(*) as num FROM $tbl_name as b inner join persons as p on author_id = p.id WHERE  b.active = 1 ".$sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	/* Setup vars for query. */

	$targetpage = "index.php?c=bulletin_admin"; 	//your file name  (the name of this file)
	
include("pagination.php");
	/* Get data. */

	$sql="SELECT *, b.id as bid, p.id as pid FROM $tbl_name as b inner join persons as p on author_id = p.id WHERE  b.active = 1 ".$sqlfilter." ORDER BY bid DESC LIMIT $start, $limit ";

		$result = mysql_query($sql);

?>
     <?php if(isset($_GET['msg'])) echo "<font color=green><strong><center>".$_GET['msg']."</strong></font></center><br>"; 
					
					if(isset($_GET['cmsg'])) echo "<font color=red><strong><center>".$_GET['cmsg']."</strong></font></center><br>";
					?> 
					  <tr>
                           <td width="486"><font color = "purple">HINT:- Select and click on a TITLE listed below to View The Actual Posted Information About That Particular Article!!</font></td>
                         </tr></br>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
		<thead>
          <tr>
		
            <th width="19%"> Department </th>

            <th width="20%">Title</th>
			<th width="20%"> Author (Posted By)</th>
			<th width="13%">Date Posted</th>
			<th width="13%">Status</th>
            <th width="15%">Action </th>
          
          </tr>

		  </thead>

		  <?php

				while($row = mysql_fetch_array($result))

		{
				 ?>
			<tr>

       	<td><?php echo $row['dept_of_article']; ?></a></td>

        <td><a href="index.php?c=view_article&id=<?php echo $row['bid'];?>"><?php echo $row['title']; ?></a></td>

        <td><?php echo $row['firstname']." ".$row['surname']; ?></td>
		
		<td><?php echo $row['date_posted']; ?></td>
		
        <td><?php if ($row['publish'] == 'Y') echo 'Published'; else echo 'Not Published'; ?></td>

		<td>
		<?php if($row['pid'] == $author  || $_SESSION[SITE_NAME]['ita']=="1") {?>
		<a href="index.php?c=article_edit&id=<?php echo $row['bid'];?>&op=Edt">[Edit]</a>
		<a onclick="return confirm('CONFIRM you want to Permanently Delete this Article?')" href="index.php?c=article_edit&id=<?php echo $row['bid'];?>&op=Del">[Remove]</a>
		<?php if($row['publish'] == "N") {?>
		<a onclick="return confirm('CONFIRM you want to Publish This Article?')" href="index.php?c=article_edit&id=<?php echo $row['bid'];?>&op=Pub">[Publish]</a>
		<?php } else { ?>
		<a onclick="return confirm('CONFIRM you want to Un-Publish This Article?')" href="index.php?c=article_edit&id=<?php echo $row['bid'];?>&op=Unp">[Un-Publish]</a>
		<?php } } ?></td>

		<?php }	?>

        </table></td>

<tr>

        <td align="center"><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>

      </tr>
    

    </table>

	</form>
    
<div id="respond"></div>
		<?php if($_SESSION[SITE_NAME]['hra'] == "1" || $_SESSION[SITE_NAME]['fa'] == "1" || $_SESSION[SITE_NAME]['ao'] == "1") {?>
			<p><br><a href="index.php?c=select_dept" class="btn btn-theme-dark btn-ico btn-lg">Add Article</a></p>
		<?php }	?>
    </div>