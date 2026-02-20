<div id="content">
      <legend><?php if(!isset($_GET['id'])) echo "ADD "; else echo "UPDATE "; ?>SYSTEM USER</legend>
      <?php 
	   require 'core/PasswordHash.php';
require 'core/pwqcheck.php';
	  $line="";
	  $insUs=$_SESSION[SITE_NAME]['username'];
				if(!isset($_GET['id'])&& isset($_POST['firstname']))

            {
		//	var_dump($_POST);
		
			$firstname=mysql_real_escape_string($_POST['firstname']);
			$surname=mysql_real_escape_string($_POST['surname']);
			$password=mysql_real_escape_string($_POST['password']);
			$username=mysql_real_escape_string($_POST['username']);
			$user_type=mysql_real_escape_string($_POST['user_type']);
			$personid=mysql_real_escape_string($_POST['personid']);
			
			 $ao="0";
			 $hra="0";
			 $fa="0";
			 $ita="0";
			 $ex="0";
			if($_POST['AO']=="on"){$ao=1;}else{$ao=0;}
			if($_POST['HRA']=="on"){$hra=1;}else{$hra=0;}
			if($_POST['FA']=="on"){$fa=1;}else{$fa=0;}
			if($_POST['ITA']=="on"){$ita=1;}else{$ita=0;}
			if($_POST['EX']=="on"){$ex=1;}else{$ex=0;}
			if($_POST['IO']=="on"){$io=1;}else{$io=0;}
		
				
			
			
			$count = $db->countOf("_user", "username='$username'");
	
		if($count==1)
			{
		echo "<font color=red> Username already Exists. Please Verify</font>";
			}
			else
			{
			
						
			if($db->query("insert into _user values(NULL,'$firstname','$surname','$username','password123','$user_type','$personid','$io', '$ao', '$hra', '$fa', '$ita','$ex', 1)"))
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
	
			elseif (isset($_GET['id'])&& isset($_POST['firstname'])){
			
					$firstname=mysql_real_escape_string($_POST['firstname']);
					$surname=mysql_real_escape_string($_POST['surname']);
					
					$username=mysql_real_escape_string($_POST['username']);
					$user_type=mysql_real_escape_string($_POST['user_type']);
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
					
					$password="";
					if(isset($_POST['password']))
					$password=", password = '".mysql_real_escape_string($_POST['password'])."'";

					if($db->query("UPDATE _user  SET $ao,$hra,$fa,$ita,$ex,firstname='$firstname',surname='$surname',username='$username',user_type='$user_type'$password  where id=".$_GET['id']))
					{
						$personid=$db->queryUniqueObject("SELECT * from _user where id = ".$_GET['id']);
						//var_dump($personid);
					
						echo "<br><font color=green size=+1 >  $name  Profile Updated!</font>" ;
					}else
					echo "<br><font color=red size=+1 >Problem in Updating !</font>" ;
					
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
       <fieldset>
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
      <input name="firstname" type="text" class="form-control" id="firstname1" placeholder="First Name(s)" value="<?php if(isset($_GET['id'])) { echo $line->personid." (".$line->firstname." ".$line->surname.")"; } ?>" required/>
      <input type="hidden" name="personid" id="personid" value="<?php echo $line->personid; ?>"/>
	   <br />
      <select name="user_type">
		<option >Select a User Category</option>
		<!--option value="Sup_user"  <?php if($line->user_type =="Sup_user")echo "selected" ?>>Super User</option-->
		<option value="Admin" <?php if($line->user_type =="Admin")echo "selected" ?>>Administrator</option>
		<option value="Super"  <?php if($line->user_type =="Super")echo "selected" ?>>Supervisor</option>
		<option value="Admin_super"  <?php if($line->user_type =="Admin_super")echo "selected" ?>>Administrator & Supervisor</option>
	  </select>
      <br /><br /></div>
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	
      <input name="username" type="text" class="form-control" id="username" placeholder="Username for System Access" value="<?php echo $line->username; ?>" required/>
    
	  <input name="surname" type="hidden" class="form-control" id="surname" placeholder="Surname" value="<?php echo $line->surname; ?>"/>
	   <input name="firstname" type="hidden" class="form-control" id="firstname" placeholder="Surname" value="<?php echo $line->firstname; ?>"/>
      <br />
	<!--  <input name="rname" type="text" class="form-control" id="rname" placeholder="Link to Department " value="<?php echo $line->name ;?>"/>
	   input name="rid"  id ="rid" type="hidden"  value="<?php echo $line->code ;?>"/-->
	     <select name="company_dept" id="region" >
			 <option value="">Select a Department &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM company_dept where active=1");
		  	while($row = mysql_fetch_array($result))
			{
			 // if($row['code']==$line->) ?>
			   
               <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
			   <?php } ?>
            </select>
		   
      <br />
	  </fieldset>
	    
	  <strong>User Roles</strong><br> <br />
      <input name="EX" type="checkbox" class=""   <?php if($line->ex)echo "checked";?>/> Exec Management 
      <input name="FA" type="checkbox" class=""  <?php if($line->fa)echo "checked";?>/> Finance and Accounting 
	  <input name="HRA" type="checkbox" class=""  <?php if($line->hra)echo "checked";?>/> HR Administration 
      <input name="AO" type="checkbox" class=""  <?php if($line->ao)echo "checked";?>/> Office Administration 
	  <input name="ITA" type="checkbox" class=""  <?php if($line->ita)echo "checked";?>/> IT Systems Admin  
   
		  
           <br /> 
		   <br /> 
		
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
   
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>