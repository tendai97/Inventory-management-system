<?php
session_start();
include_once "db.php"; 

$tbl_name="_user"; // Table name


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

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
$row = mysql_fetch_row($result);

$_SESSION[SITE_NAME]['id']=$row[0];
$_SESSION[SITE_NAME]['username']=$row[3];
$_SESSION[SITE_NAME]['usertype']=$row[5];
$_SESSION[SITE_NAME]['branch']=$row[6];

if($row[5]=="Admin"|| $row[5] =='Radmin')
header("location:index.php?c=home");
else if($row[5]=="User")
header("location:index.php?c=user_home");
else if($row[5]=="Supervisor")
header("location:index.php?c=user_home");
else if($row[5]=="Patient"){
header("location:index.php?c=pat-home");
$_SESSION[SITE_NAME]['patientId']=$row[8];
}
else
echo "error in validate user";

}
else {
header("location:login.php?msg=Wrong%20Username%20or%20Password");
}
?>