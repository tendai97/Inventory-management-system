<?php
include("core.php");
include("db.class.php");

// Open the base (construct the object):
$base="tindo";
$server="localhost";
$user="root";
$pass="";
$db = new DB($base, $server, $user, $pass);
$connection=$db->connection;



?>