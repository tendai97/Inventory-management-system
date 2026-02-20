 <div id="content">
      <legend><?php if(!isset($_GET['id'])) echo "ADD "; else echo "UPDATE "; ?>SYSTEM USER</legend>
      <?php 
	   require 'core/PasswordHash.php';
require 'core/pwqcheck.php';
	  $line="";
	  $insUs=$_SESSION[SITE_NAME]['username'];
				if(!isset($_GET['id'])&& isset($_POST['username']))

            {
		//	var_dump($_POST);
		
			$firstname=mysql_real_escape_string($_POST['firstname']);
			$surname=mysql_real_escape_string($_POST['surname']);
			$password=mysql_real_escape_string($_POST['password']);
			$username=mysql_real_escape_string($_POST['username']);
			$user_type=mysql_real_escape_string($_POST['user_type']);
			$personid=mysql_real_escape_string($_POST['personid']);

//***************************************ex**************************
			
			 $ao="0"; $hra="0"; $fa="0"; $ita="0"; $ex="0";
			 
			if($_POST['AO']=="on"){$ao=1;}else{$ao=0;}
			if($_POST['HRA']=="on"){$hra=1;}else{$hra=0;}
			if($_POST['FA']=="on"){$fa=1;}else{$fa=0;}
			if($_POST['ITA']=="on"){$ita=1;}else{$ita=0;}
			if($_POST['EX']=="on"){$ex=1;}else{$ex=0;}
		
//******************************************assert************************

				$ini=0; $app=0; $ins=0; $oth=0;
-				
			if($_POST['ini']=="on"){$ini=1;}else{$ini=0;}
			if($_POST['app']=="on"){$app=1;}else{$app=0;}
			if($_POST['ins']=="on"){$ins=1;}else{$ins=0;}
			if($_POST['oth']=="on"){$oth=1;}else{$oth=0;}
		
				
			
			
			$count = $db->countOf("_user", "username='$username'");
	
		if($count==1)
			{
		echo "<font color=red> Username already Exists. Please Verify</font>";
			}
			else
			{
			
						
			if($db->query("insert into _user values(NULL,'$firstname','$surname','$username','password123','$user_type','$personid', '$ao', '$hra', '$fa', '$ita','$ex', 1,'$ini','$app','$ins','$oth')"))
			{
				//echo $userid;
						$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
$hash = $hasher->HashPassword("password123");
//echo "update _user set password ='".$hash."' where id = ".$userid;
$db->query("update _user set password ='".$hash."' where username = '$username'");
				
				echo "<br><font color=green size=+1 >  $firstname $surname Added Successfully !</font>" ;}
			else
			echo "<br><font color=red size=+1 >Problem in Adding User!</font>" ;
			
			}
			
			
			}
	////////////////////////////////user update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['username'])){
			
			$firstname=mysql_real_escape_string($_POST['firstname']);
			$surname=mysql_real_escape_string($_POST['surname']);
			$password=mysql_real_escape_string($_POST['password']);
			$username=mysql_real_escape_string($_POST['username']);
			$user_type=mysql_real_escape_string($_POST['user_type']);
			

			$ao="ao=";
			 $hra="hra=";
			 $fa="fa=";
			 $ita="ita=";
			 $ex="ex=";
			if($_POST['AO']=="on"){$ao.=1;}else{$ao.=0;}
			if($_POST['HRA']=="on"){$hra.=1;}else{$hra.=0;}
			if($_POST['FA']=="on"){$fa.=1;}else{$fa.=0;}
			if($_POST['ITA']=="on"){$ita.=1;}else{$ita.=0;}
			if($_POST['EX']=="on"){$ex.=1;}else{$ex.=0;}
					
					//******************************************user************************

				$ini="a_init="; $app="a_apro="; $ins="a_insp="; $oth="a_othr=";
				
			if($_POST['ini']=="on"){$ini.=1;}else{$ini.=0;}
			if($_POST['app']=="on"){$app.=1;}else{$app.=0;}
			if($_POST['ins']=="on"){$ins.=1;}else{$ins.=0;}
			if($_POST['oth']=="on"){$oth.=1;}else{$oth.=0;}
			
					$password="";
					if(isset($_POST['password']))
					$password=", password = '".mysql_real_escape_string($_POST['password'])."'";
//echo "UPDATE _user  SET $ini,$app,$ins,$oth, $ao,$hra,$fa,$ita,$ex,firstname='$firstname',surname='$surname',username='$username',user_type='$user_type'$password  where id=".$_GET['id'];
					if($db->query("UPDATE _user  SET $ini,$app,$ins,$oth, $ao,$hra,$fa,$ita,$ex,firstname='$firstname',surname='$surname',username='$username',user_type='$user_type'$password  where id=".$_GET['id']))
					{
						$personid=$db->queryUniqueObject("SELECT * from _user where id = ".$_GET['id']);
						//var_dump($personid);
					
						echo "<br><font color=green size=+1 >  $name  Profile Updated!</font>" ;
					}else
					echo "<br><font color=red size=+1 >Problem in Updating !</font>" ;
					
					$line = $db->queryUniqueObject("SELECT * FROM _user  WHERE id=".$_GET['id']);
			}
			elseif(isset($_GET['id']) && $_GET['op']=="R"){
					$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
					$hash = $hasher->HashPassword("password123");
					$db->query("update _user set password ='".$hash."' where id = ".$_GET['id']);
					$msg= "User Password has been Reset Successfully!!";
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=user_admin&msg=User Password has been Reset Successfully!!";
					</script>
					<?php 
					
			}
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM _user  WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       <table width="525"  border="0" cellspacing="0" cellpadding="0">
	          
         <tr>
      <td width="185" height="48"><strong>First Name(s):</strong></td>
      <td width="262"><?php if(isset($_GET['id'])) { echo $line->firstname; } ?> </td>
       <br />
	   </tr> 
	   <tr>
       <td width="185" height="43"><strong>Last Name(s):</strong></td>
	   <td width="262"><?php if(isset($_GET['id'])) { echo $line->surname; } ?> </td>
	   </tr> 
	   <tr>
       <td width="185" height="43"><strong>System Username:</strong></td>
	   <td width="262">
	   <input name="username" type="text" class="form-control" id="username" placeholder="Username for System Access" value="<?php echo $line->username; ?>" required/>
	   </tr> 
	   <tr>
       <td width="185" height="43"><strong>User Category:</strong></td>
	   <td width="262"><select name="user_type">
		<option >Select a User Category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
		<!--option value="Sup_user"  <?php if($line->user_type =="Sup_user")echo "selected" ?>>Super User</option-->
		<option value="Admin" <?php if($line->user_type =="Admin")echo "selected" ?>>Administrator</option>
		<option value="Super"  <?php if($line->user_type =="Super")echo "selected" ?>>Supervisor</option>
		<option value="Admin_super"  <?php if($line->user_type =="Admin_super")echo "selected" ?>>Administrator & Supervisor</option>
	  </select></td></tr>
      <br /><br />
	   </table> 
	   <table width="447"  border="0" cellspacing="0" cellpadding="0">
	      <br />      
         <tr><strong>User Roles</strong><br></tr>
     <!-- <input name="EX" type="checkbox" class=""   <?php if($line->ex)echo "checked";?>/> Exec Management -->
	   
	   
	  <input name="EX" type="checkbox" class="has_image" id="has_image" <?php if ($line->ex) echo "checked"; ?> /> Exec Management
	 	 

      <input name="FA" type="checkbox" class="has_image" id="" <?php if($line->fa)echo "checked";?>/> Finance and Accounting
		  <input name="HRA" type="checkbox" id="has_image" class="has_image"  <?php if($line->hra)echo "checked";?>/> HR Administration 

      <input name="AO" type="checkbox" id="has_image" class="has_image"  <?php if($line->ao)echo "checked";?>/> Office Administration 
	   
	  <input name="ITA" type="checkbox" id="has_image" class="has_image"  <?php if($line->ita)echo "checked";?>/> IT Systems Admin  
	  
	  <br/><br/>
	 <div id="addtional1" <?php if(!isset($_GET['id']) || $line->ex == 0 ||  $line->fa == 0|| $line->hra == 0|| $line->ao == 0|| $line->ita == 0){?> style="display: none;" <?php } else {?> style="display: block;"  <?php }?>  style=" visibility: hidden;" class="boxfield" >
	<!--<textarea  rows="5" cols="80" name="textural" placeholder="Text to be Appended to Test"><?php echo $line->textural;?></textarea>
	<br><br>
	<img  width="100" height="120" src="upload/test_img/testimg<?php echo $_GET['id'].".".$line->extention;?>" alt="No Image"/>
	<input type="file" name="image" >-->
	
	<legend>Asset Management</legend>
	
	<input name="ini" type="checkbox" class=""  <?php if($line->a_init)echo "checked";?>/> Initate 
	  <input name="app" type="checkbox" class=""  <?php if($line->a_apro)echo "checked";?>/> Approve
      <input name="ins" type="checkbox" class=""  <?php if($line->a_insp)echo "checked";?>/> Inspect
	  <input name="oth" type="checkbox" class=""  <?php if($line->a_othr)echo "checked";?>/> Other
	
	<br>
	<br>
	
	</div>
 		
		  <tr>
           <!--td align="right"><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td-->
           <td>
             <input type="submit" name="Submit" value="Save" class="btn-small btn-color btn-pad" /></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
   
       </table> 
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>