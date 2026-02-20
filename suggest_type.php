<?php
include_once "core/db.php"; 
$q = strtolower($_GET["q"]);
if (!$q) return;

 
$sqlfilter="";

 
$sql = "SELECT *  FROM categories  WHERE 1  AND (name LIKE '%$q%' $sqlfilter  or name LIKE '%$q%' )ORDER BY name ";
//echo $sql;
$rsd = $db->query($sql);
$resultSet = '';
while($rs = mysql_fetch_array($rsd)) {

$resultSet .=$rs['name']
	."|". $rs['id']
		."|".  $rs['name']
		."\n";
}
if($resultSet=='')
$resultSet="No Records Found";

echo $resultSet ;
?>