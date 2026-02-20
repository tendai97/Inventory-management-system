<?php
session_start();
include_once "db.php"; 

$tbl_name="users"; // Table name
/*
//var_dump($_POST);
//exit;
// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'" ;
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
*/
if(isset($_GET['id'])){
// Register $myusername, $mypassword and redirect to file "login_success.php"
$sql="SELECT * FROM $tbl_name WHERE id = ".$_GET['id'] ;

$result=mysqli_query($connection,$sql);
$row = mysqli_fetch_row($result);

$_SESSION[SITE_NAME]['id']=$row[0];
$_SESSION[SITE_NAME]['username']=$row[3];
$_SESSION[SITE_NAME]['usertype']=$row[5];
$_SESSION[SITE_NAME]['active']=$row[7];
$_SESSION[SITE_NAME]['fname']=$row[1];
$_SESSION[SITE_NAME]['sname']=$row[2];
echo $row[7];

if($row[7]==0){
session_destroy();
unset($_SESSION[SITE_NAME]["id"]);
unset($_SESSION[SITE_NAME]["username"]);
unset($_SESSION[SITE_NAME]["usertype"]);
header("location:../index.php?c=login&msg=User%20Account%20Deactivated");
}

else if($row[5]=="Admin" || $row[5]=="User" ){
	$sql="UPDATE users set status='Online' WHERE id = ".$_GET['id'] ;
	$result=mysqli_query($connection,$sql);

	header("location:../index.php?c=home");

}

else {
header("location:../index.php?c=login&msg=Wrong%20Username%20or%20Password");
}
}
?>