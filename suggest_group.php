<?php

/////////////////////////////////////////////////////////////////////////////

include_once "core/db.php"; 


$sqlFilter = '';
// $_GET['q'] contains the character entered
if ($_GET['q']) {
	$words = explode(' ', $_GET['q']);
	for ($i=0, $count = count($words); $i<$count; $i++) {
		$sqlFilter .= 'id LIKE \'%'.$words[$i].'%\' or name LIKE \'%'.$words[$i].'%\'';
	}
}
$json=array();

if($results=mysql_query("SELECT * FROM categories where 1 and ".$sqlFilter))
while($data = mysql_fetch_array($results)) {
	
	$unit=array("id"=>$data['id'],"name"=>$data['name']);
	//array_push($unit, $data['id_number']);
		array_push($json, $unit);
	}
	
	
echo json_encode($json);
//echo $json;
			
			
?>