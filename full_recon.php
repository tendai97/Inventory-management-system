<div id="content">
<?php 
//$_SESSION[SITE_NAME]['visit']=$_GET['visit'];

//var_dump($_SESSION[SITE_NAME]);
	$visit=$db->queryUniqueObject("SELECT * FROM visit WHERE id=".$_SESSION[SITE_NAME]['visit'] );
		/*$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']);
		while($row = mysql_fetch_array($result))
			{
			
		}
*/
		
?>

   <div id="content">
      <h1>Visit <?php echo $_SESSION[SITE_NAME]['visit']; ?></h1>
	  <h1>Region <?php echo $_SESSION[SITE_NAME]['region']; ?></h1>
      <table width="200" border="0">
        <tr>
          <td width="66%"><h1>"No of assets recorded"</h1></td>
          <td width="34%"><?php echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']);?></td>
        </tr>
		<tr>
		<td></td><td>
		
		<?php
		//$visit=$db->queryUniqueObject("SELECT * FROM visit WHERE id=".$_SESSION[SITE_NAME]['visit'] );
		$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']);
		while($row = mysql_fetch_array($result))
			{
			echo $row["asset_no"]."<br>";
		}
		
		?>
		
		</td></tr>
        <tr>
          <td><h1>Found Assets</h1></td>
          <td><?php  echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and matches='Y'");?></td>
        </tr>
		<tr>
		<td></td><td>
		
		<?php
		//$visit=$db->queryUniqueObject("SELECT * FROM visit WHERE id=".$_SESSION[SITE_NAME]['visit'] );
		$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']." and matches='Y'");
		while($row = mysql_fetch_array($result))
			{
			echo $row["asset_no"]."<br>";
		}
		
		?>
		
		</td></tr>
		
        <tr>
          <td><h1> Missing Assets</h1></td>
          <td><?php $count =  $db->queryUniqueObject(" SELECT count(assert_no) num FROM assets
WHERE region= '". $_SESSION[SITE_NAME]['region']."' AND `assert_no` NOT IN 
(
  SELECT `asset_no`
  FROM `visit_assets`
  WHERE `visit` = ". $_SESSION[SITE_NAME]['visit']."
) ");
		  echo  $count ->num;?></td>
        </tr>
		<tr>
		<td></td><td>
		
		<?php
		//$visit=$db->queryUniqueObject("SELECT * FROM visit WHERE id=".$_SESSION[SITE_NAME]['visit'] );
		$result = mysql_query(" SELECT * FROM assets
WHERE region= '". $_SESSION[SITE_NAME]['region']."' AND `assert_no` NOT IN 
(
  SELECT `asset_no`
  FROM `visit_assets`
  WHERE `visit` = ". $_SESSION[SITE_NAME]['visit']."
) ");
		while($row = mysql_fetch_array($result))
			{
			echo $row["assert_no"]."<br>";
		}
		
		?>
		
		</td></tr>
        <tr>
          <td height="22"><h1>New Assets</h1></td>
          <td> <?php  echo  $count = $db->countOf("visit_assets","visit=".$_SESSION[SITE_NAME]['visit']." and matches='N'");;?></td>
        </tr>
		<tr>
		<td></td><td>
		
		<?php
		//$visit=$db->queryUniqueObject("SELECT * FROM visit WHERE id=".$_SESSION[SITE_NAME]['visit'] );
		$result = mysql_query("SELECT * FROM visit_assets WHERE visit=".$_SESSION[SITE_NAME]['visit']." and matches='N'");
		while($row = mysql_fetch_array($result))
			{
			echo $row["asset_no"]."<br>";
		}
		
		?>
		
		</td></tr>
        
      </table>
      <p align="justify"><br />
      </p>
      <p align="justify">&nbsp;</p>
      <div align="justify"></div>
<div id="respond"></div>
    </div>

</div>