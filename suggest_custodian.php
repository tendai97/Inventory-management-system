<?php
/*include_once "core/db.php"; 
$q = strtolower($_GET["q"]);
if (!$q) return;

 
$sqlfilter="";

 
$sql = "SELECT *  FROM persons  WHERE 1 AND (firstname LIKE '%$q%' $sqlfilter or surname LIKE '%$q%' )ORDER BY id ";

$rsd = $db->query($sql);
$resultSet = '';
while($rs = mysql_fetch_array($rsd)) {

$resultSet .=$rs['firstname']
	."|". $rs['surname']
		."|".  $rs['id_number']
		."\n";
}
if($resultSet=='')
$resultSet="No Records Found";

echo $resultSet ;*/
/////////////////////////////////////////////////////////////////////////////////

include_once "core/db.php"; 


$sqlFilter = '';
// $_GET['q'] contains the character entered
if ($_GET['q']) {
	$words = explode(' ', $_GET['q']);
	for ($i=0, $count = count($words); $i<$count; $i++) {
		$sqlFilter .= 'id LIKE \'%'.$words[$i].'%\' or firstname LIKE \'%'.$words[$i].'%\'or surname LIKE \'%'.$words[$i].'%\'';
	}
}
$json=array();

if($results=mysql_query("SELECT * FROM persons where active= 1 and alert_flag= 'N' and ".$sqlFilter))
while($data = mysql_fetch_array($results)) {
	
	$unit=array("id"=>$data['id'],"firstname"=>$data['firstname'],"surname"=>$data['surname']);
	//array_push($unit, $data['id_number']);
		array_push($json, $unit);
	}
	
	
echo json_encode($json);
//echo $json;
			
			
?>