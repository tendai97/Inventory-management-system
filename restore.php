 <div id="content">
<?php

if($_FILES['restore']['size']>0){

ini_set('memory_limit','128M'); // set memory limit here
//$db = mysql_connect ( 'Your Host', 'Your Username', 'Your password' ) or die('not connected');
//mysql_select_db( 'Your database', $db) or die('Not found');
$fp = fopen ( $_FILES['restore']['tmp_name'], 'r' );
$fetchData = fread ( $fp, filesize (  $_FILES['restore']['tmp_name']) );
$sqlInfo = explode ( ";\n", $fetchData); // explode dump sql as a array data

foreach ($sqlInfo AS $sqlData )
{
//mysql_query ( $sqlData ) or die('Query not executed');
if($sqlData!="")
$db->query($sqlData ) or die('Query not executed');
}

echo 'Done';
}
?>
<form action="" method="post" enctype="multipart/form-data">


<table class="myTableStyle" >
	   
	   <tr>
	   <td >Restoration File:
           </td>
           <td><input type="file" name="restore" />

</td></tr> 
<tr><td><input type="submit" value="Restore"  value="1"/></td></tr>
</table>
</form>
</div>