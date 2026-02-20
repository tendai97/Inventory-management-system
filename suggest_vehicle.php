<?php


include_once "core/db.php"; 

//echo "hope";
$sqlFilter = '';
// $_GET['q'] contains the character entered
if ($_GET['q']) {
	$words = explode(' ', $_GET['q']);
	for ($i=0, $count = count($words); $i<$count; $i++) {
		$sqlFilter .= 'reg_no LIKE \'%'.$words[$i].'%\' or make LIKE \'%'.$words[$i].'%\' or model LIKE \'%'.$words[$i].'%\'';
	}
}
$json=array();

//echo $sqlFilter;

if($results=mysql_query("SELECT * FROM vehicle_master where active = 1 and alert_flag= 'N' and ".$sqlFilter))
while($data = mysql_fetch_array($results)) {
	
	$unit=array("reg_no"=>$data['reg_no'],"make"=>$data['make'],"model"=>$data['model'],"id"=>$data['id']);
	//array_push($unit, $data['id_number']);
		array_push($json, $unit);
	}
	
	
echo json_encode($json);
//echo $json;
			
			


?>