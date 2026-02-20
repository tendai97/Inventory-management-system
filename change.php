<?php 
if(isset($_GET['msg']) && $_GET['msg']=='Password changed')
	
?>

 <p><?php echo "<br><font color=red  >".$_GET['msg']. " </font>" ;?></p>
<form action="core/change_pswd.php" method="POST">
<input type="hidden" name="op" value="change">
<!--Username:<br>-->

<input type="hidden" name="user" size="60" value ="<?php echo $_SESSION[SITE_NAME]['username'];?>" ><br>
Current password:<br>
<input type="password" name="pass" size="60"><br>
<br />
New password:<br>
<input type="password" name="newpass" size="60"><br>
<br />
<input type="submit" name="Submit" value="Change Password" class="btn-small btn-color btn-pad" /></td>
</form>