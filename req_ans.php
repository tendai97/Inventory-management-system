<?php

$flag = $_GET['op'];
$id = $_GET['id'];
$admin=$_SESSION[SITE_NAME]['id'] ;
$req = $db->queryUniqueObject("SELECT * FROM requests WHERE id= '$id'");
$inv = $db->queryUniqueObject("SELECT * FROM assets WHERE id= '$req->asset_id'");

if($inv->available==0 || $inv->available <0){
	$sql="UPDATE `assets` SET `available`=0 WHERE id=$inv->id";

	$db->query($sql);
	?>

	<script language="javascript" type="text/javascript">
window.location = "index.php?c=req_admin&flag=A&msg=<?php echo 'Request Approved';?>";
</script>
<?php
}
if(isset($_GET['qm']))
{
	$sql="update requests set quantity =$inv->available where id =$id ";
	$db->query($sql);
	$req = $db->queryUniqueObject("SELECT * FROM requests WHERE id= '$id'");
}


if($flag == "A"){


	$sql="UPDATE `requests` SET `status`='A' WHERE id=$req->id";

	$db->query($sql);

	$sql="UPDATE `assets` SET `available`=available-$req->quantity, `used`=used+$req->quantity WHERE id=$req->asset_id";

	$db->query($sql);

	$sql="INSERT INTO `allocations`( `request_id`, `date`, `admin`) VALUES ($req->id,NOW(),$admin)";

	$db->query($sql);
	?>

	<script language="javascript" type="text/javascript">
window.location = "index.php?c=req_admin&flag=A&msg=<?php echo 'Request Approved';?>";
</script>
<?php



}

else{

	$sql="UPDATE `requests` SET `status`='D' WHERE id=$req->id";
	$db->query($sql);

	?>

	<script language="javascript" type="text/javascript">
window.location = "index.php?c=req_admin&flag=D&msg=<?php echo 'Request Declined';?>";
</script>
<?php
}
?>
