<?php
include_once "db.php"; 
$sql="UPDATE users set status='Offline' WHERE id = ".$_GET['id'] ;
$result=mysqli_query($db->connection,$sql);

session_start();
session_destroy();
unset($_SESSION[SITE_NAME]["id"]);
unset($_SESSION[SITE_NAME]["username"]);
unset($_SESSION[SITE_NAME]["usertype"]);

header("location:../index.php?c=login&msg=You%20have%20been%20logged%20out!");
?>