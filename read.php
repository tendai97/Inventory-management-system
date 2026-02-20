<!DOCTYPE html>
<html>
<head>
<title> WWF SIMPLE BLOG</title>
<meta content="noindex, nofollow" name="robots">
<link href="basic.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
<div class="divA">
<div class="title">
<h2> VIEW YOUR MESSAGES</h2>
</div>
<div class="divB">
<div class="divD">
</div>
<?php
include_once "core/db.php";

$connection = mysql_connect("localhost", "root", ""); 
$db = mysql_select_db("wwf", $connection); 
//MySQL Query to read data

if ($_GET['dept']=="hra")  {

$query1 = mysql_query("select * from bulletin_posts where dept_of_article= 'Human Resources Dept' AND publish= 'Y'", $connection);}

elseif ($_GET['dept']=="fin" ) {
$query1 = mysql_query("select * from bulletin_posts where dept_of_article= 'Finance Department' AND publish= 'Y'", $connection);}

elseif ($_GET['dept']=="con") {
	$query1 = mysql_query("select * from bulletin_posts where dept_of_article= 'Conservation Projects' AND publish= 'Y'", $connection);}


	while ($row1 = mysql_fetch_array($query1)) {
?>

<div class="form">
<h2>---MESSAGE---</h2>
<!-- Displaying Data Read From Database -->
<span>TITLE:</span> <?php echo $row1['title']; ?><br>

<span>POST:</span> <?php echo $row1['post']; ?><br>

<span>DATE POSTED:</span> <?php echo $row1['date_posted']; ?><br>

<span>DATE LAST EDITED:</span> <?php echo $row1['date_last_edit']; ?><br>
</div>
<?php
}
?>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
<?php
mysql_close($connection); 
?>
</body>
</html>