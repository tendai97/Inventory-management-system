 <div id="content">
      <h1>Visit Details      </h1>
      <table width="900" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
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
          </form></td>
        </tr>
      </table>
      <p>
        <?php 




	$tbl_name="visit";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	

	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	
	
	

	
	$sqlfilter="";
	
	if(isset($_GET['alert'])){
	$sqlfilter=" and isnull(conclusion_date) and auditor='".$_SESSION[SITE_NAME]['username']."' ";
	
}
elseif(isset($_GET['flag'])){
	$sqlfilter=" and  conclusion_date IS NOT NULL and auditor='".$_SESSION[SITE_NAME]['username']."' ";
	
}

	if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{

$sqlfilter = "AND id LIKE '%".trim($_POST['searchtxt'])."%' OR auditor LIKE '%".trim($_POST['searchtxt'])."%' OR start_date LIKE '%".trim($_POST['searchtxt'])."%' OR location LIKE '%".trim($_POST['searchtxt'])."%'  ";


}

$query = "SELECT COUNT(*) as num FROM $tbl_name where  1 ". $sqlfilter;

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */

	$targetpage = "index.php?c=asset"; 	//your file name  (the name of this file)
	
	
	include("pagination.php");
	/* Get data. */

	

$sql = "SELECT *,
CAST(visit.insTS AS DATE)sdate,
CAST(visit.`conclusion_date` AS DATE)cdate,
visit.id AS vid
 FROM visit   where 1  $sqlfilter ORDER BY visit.id desc LIMIT $start, $limit ";

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

      <table width="700" border="0" cellspacing="0" cellpadding="0" >

      <tr>

        <td bgcolor="#FFFFFF"><div align="center"><strong><span class="style1">View Inspection Details </span></strong></div></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

          <tr>

            <td width="87"><strong> Visit No </strong></td>

           <!-- <td width="103"><strong>Region</strong></td>-->

            <td width="126"><strong>Date </strong></td>

            <td width="130"><strong>Creator</strong></td>
             <td width="130"><strong>Inspection Coverage</strong></td>
             <td width="130"><strong>Value</strong></td>
            <td width="130"><strong>Action</strong></td>
			
          
          </tr>

		  

		  

		  <?php

	 

								while($row = mysql_fetch_array($result))

		{

		

		 $mysqldate=$row['date'];

 		$phpdate = strtotime( $mysqldate );

 		$phpdate = date("d/m/Y",$phpdate);



										 ?>

  											<tr>

       	<td width="87"><a href="index.php?c=recon&id=<?php echo  $row['vid'];?>"><?php echo $row['vid']; ?></a></td>

       <!-- <td width="103"><?php echo $row['rname']; ?></td>-->

        <td width="126"><?php echo $row['sdate']; ?></td>

        <td width="126"><?php echo $row['auditor']; ?></td>
        <td width="126"><?php echo $row['location'];?></td>
        <td width="126"><?php echo $row['value'];?></td>
        <?php if(isset($_GET['flag'])){
		 	?>
		 	<td width="87"><a href="index.php?c=recon&col=<?php echo $row['location'];?>&value=<?php echo $row['value'];?>&id=<?php echo $row['vid'];?>">[retrieve]</a></td>
		 	<?php
        }else{ ?>
        	<td width="87"><a href="index.php?c=card&vid=<?php echo  $row['vid'];?>&cat=<?php echo  $row['location'];?>&vv=<?php echo  $row['value'];?>">[resume]</a></td>
        	<?php
        }
        ?>
	
    

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
   
    </div>