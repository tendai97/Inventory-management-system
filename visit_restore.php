 <div id="content">
<?php

if($_FILES['restore']['size']>0){

ini_set('memory_limit','128M'); // set memory limit here
//$db = mysql_connect ( 'Your Host', 'Your Username', 'Your password' ) or die('not connected');
//mysql_select_db( 'Your database', $db) or die('Not found');
$fp = fopen ( $_FILES['restore']['tmp_name'], 'r' );
$fetchData = fread ( $fp, filesize (  $_FILES['restore']['tmp_name']) );
//echo $fetchData ;
$sqlInfo = explode ( ";\n", $fetchData); // explode dump sql as a array data

//foreach ($sqlInfo AS $sqlData )
//{
//mysql_query ( $sqlData ) or die('Query not executed');
//if($sqlData!="")
// Establishing connection with mysqli database 
$con = new mysqli($server, $user, $pass, $base); 
/* check connection */ 
if(mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error()); 
    exit(); 
} 	

$con->multi_query($fetchData ) or die('Query not executed');
//}

echo 'Done';
}
?>
<form action="" method="post" enctype="multipart/form-data">


<table class="myTableStyle" >
	   
	   <tr>
	   <td >Visit upload File:
           </td>
           <td><input type="file" name="restore" />

</td></tr> 
<tr><td><input type="submit" value="Restore"  value="1"/></td></tr>
</table>
</form>
</div>