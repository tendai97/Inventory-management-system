<?php

$id = $_GET['id'];
$flag=$_GET['flag'];

if($_SESSION[SITE_NAME]['id']==$id){
	$msg="YOU CAN NOT DEACTIVATE YOUR OWN ACCOUNT";
	?>
	<script language="javascript" type="text/javascript">
window.location = "index.php?c=emp_admin&flag=A&cmsg=<?php echo $msg;?>";
</script><?php
	
}
else if($flag=='A')
{
	$sql="UPDATE users set active='0', status='Offline' WHERE id = ".$id ;
    $result=$db->query($sql);
    $msg="ACCOUNT DEACTIVATED  ";
    ?>
	<script language="javascript" type="text/javascript">
window.location = "index.php?c=emp_admin&flag=D&cmsg=<?php echo $msg;?>";
</script>
<?php
}
else
{
	$sql="UPDATE users set active=1, status='Offline' WHERE id = ".$id ;
    $result=$db->query($sql);
    $msg="ACCOUNT ACTIVATED  ";
    ?>
    <script language="javascript" type="text/javascript">
window.location = "index.php?c=emp_admin&flag=A&msg=<?php echo $msg;?>";
</script>
<?php
   
	
}
?>

