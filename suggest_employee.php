<?php

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