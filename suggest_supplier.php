<?php


include_once "core/db.php"; 

//echo "hope";
$sqlFilter = '';
// $_GET['q'] contains the character entered
if ($_GET['q']) {
	$words = explode(' ', $_GET['q']);
	for ($i=0, $count = count($words); $i<$count; $i++) {
		$sqlFilter .= 'code LIKE \'%'.$words[$i].'%\' or name LIKE \'%'.$words[$i].'%\'';
	}
}
$json=array();

//echo $sqlFilter;

if($results=mysql_query("SELECT * FROM supplier_partner where active = 1 and alert_flag= 'N' and ".$sqlFilter))
while($data = mysql_fetch_array($results)) {
	
	$unit=array("code"=>$data['code'],"name"=>$data['name'],"id"=>$data['id']);
	//array_push($unit, $data['id_number']);
		array_push($json, $unit);
	}
	
	
echo json_encode($json);
//echo $json;
			
			


?>