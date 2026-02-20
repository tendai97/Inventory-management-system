<?php
include_once "core/db.php";
require 'core/PasswordHash.php';
require 'core/pwqcheck.php';

$specimen = $db->query("select * from _user   ");

	while($row = mysql_fetch_array($specimen))
	
	{
		$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
$hash = $hasher->HashPassword($row['password']);
$db->query("update _user set password ='".$hash."' where id = ".$row['id']);
	}
?>