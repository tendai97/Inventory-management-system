<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "ADD "; else echo "UPDATE "; ?>SYSTEM USER PROFILE</legend>
      <?php 
	  require 'core/PasswordHash.php';
	  require 'core/pwqcheck.php';
	  $line = "";
	  $id = $_GET['id'];
	  $insUs = $_SESSION[SITE_NAME]['username'];
	  
	if(!isset($_GET['id'])&& isset($_POST['firstname']))

            {
		//	var_dump($_POST);
		
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
									
			$count = $db->countOf("_user", "username='$username'");
	
		if($count==1)
			{
		echo "<font color=red> Username already Exists. Please Verify</font>";
			}
			else
			{
			
			$db->query("insert into _user values(NULL,'$firstname','$surname','$username','password123','$user_type','$personid', '$ao', '$hra', '$fa', '$ita','$ex', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
			
				//echo $userid;
			$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
			$hash = $hasher->HashPassword("password123");
			//echo "update _user set password ='".$hash."' where id = ".$userid;
			$db->query("update _user set password ='".$hash."' where username = '$username'");
				
				echo "<br><font color=green size=+1 >  $firstname $surname Added Successfully !</font>" ;
			
		if ($_POST['AO']=="on" or $_POST['FA']=="on" or $_POST['HRA']=="on" or $_POST['EX']=="on" or $_POST['ITA']=="on") { 
			
				$msg="Employee User Profile Has Been Updated. Select Which Category Item To Make Further User Role-specific Settings Where Applicable Or EXIT To Main Listing!! ";

			echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=assign_user_roles&id=$id&user=$username&msg=$msg\";
			</script>";
						}	
		else 
				{	
					$db->query("UPDATE _user  SET a_init = 0, a_apro = 0, a_insp = 0, a_othr = 0, f_init = 0, f_apro = 0, f_insp = 0, f_othr = 0, h_init = 0, h_apro = 0, h_insp = 0, h_othr = 0, e_insp = 0, e_othr = 0, i_insp = 0, i_othr = 0  where id = ".$_GET['id']);
					
					$line = $db->queryUniqueObject("SELECT * FROM _user  WHERE id=".$_GET['id']);
					
					echo "<br><font color=green size=+1 >  $username's User Profile Has Been Updated!</font>" ;  }
				  
	  
			}	}
			
	////////////////////////////////user update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['username'])){
			
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
//echo "UPDATE _user  SET $ini,$app,$ins,$oth, $ao,$hra,$fa,$ita,$ex,firstname='$firstname',surname='$surname',username='$username',user_type='$user_type'$password  where id=".$_GET['id'];
					$db->query("UPDATE _user  SET $ao,$hra,$fa,$ita,$ex,username='$username',user_type='$user_type'$password  where id=".$_GET['id']);

		if ($user_type == "User" and ($_POST['AO']=="on" or $_POST['FA']=="on" or $_POST['HRA']=="on" or $_POST['EX']=="on" or $_POST['ITA']=="on")) { 
			
					echo "<br><font color=red>Invalid <strong>User Group / User Category</strong> Combination - User Categories Can ONLY Be Selected For Admins AND Supervisors!!</font><br><br>" ;  
				  
					$line = $db->queryUniqueObject("SELECT * FROM _user  WHERE id=".$_GET['id']);  }
								
		elseif ($_POST['AO']=="on" or $_POST['FA']=="on" or $_POST['HRA']=="on" or $_POST['EX']=="on" or $_POST['ITA']=="on") { 
			
				$msg="Employee User Profile Has Been Updated. You Can Make Further User Role-specific Settings Where Applicable Or EXIT To Main Listing!! ";

			echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=assign_user_roles&id=$id&user=$username&msg=$msg\";
			</script>";
						}	
		else 
				{	
					$db->query("UPDATE _user  SET a_init = 0, a_apro = 0, a_insp = 0, a_othr = 0, f_init = 0, f_apro = 0, f_insp = 0, f_othr = 0, h_init = 0, h_apro = 0, h_insp = 0, h_othr = 0, e_insp = 0, e_othr = 0, i_insp = 0, i_othr = 0  where id = ".$_GET['id']);
					
					echo "<br><font color=green size=+1 >  $username's User Profile Has Been Updated!</font><br><br>" ;  
				  
					$line = $db->queryUniqueObject("SELECT * FROM _user  WHERE id=".$_GET['id']); }
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="R"){
					$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
					$hash = $hasher->HashPassword("password123");
					$db->query("update _user set password ='".$hash."' where id = ".$_GET['id']);

					$line = $db->queryUniqueObject("SELECT * FROM _user WHERE id = ".$_GET['id']);
					$line1 = $db->queryUniqueObject("SELECT * FROM persons WHERE id = $line->personid");
					$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE id = ".$_SESSION[SITE_NAME]['person']);

					$username = $line1->firstname[0].$line1->surname;

					// email setup
				
				$message= "Dear ".$line1->firstname.' '.$line1->surname.", \n \nYour Login Password for access to the WWF Zimbabwe Employee Self Service Centre (ESSC) system has been reset to the default value and your refreshed credentials are; \n \nUsername:   ".$username."    (not case-sensitive)\nPassword:    password123    (default and case-sensitive) \n \nLog onto the system using this link https://portal.wwf.org.zw/wwf_dev/landing_page.php? to change the default password to your own preferred one at first time login. In need of assistance contact the System Adminstrator. \n \nYours Sincerely \n \n".$line2->firstname.' '.$line2->surname."";
					
					include 'core/mail.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $line1->firstname.' '.$line1->surname,$line1->email,$message,"Notification Of User Password RESET for Login access to WWF Zim ESSC System");  
					$db->query("UPDATE persons  SET alert_flag='P' where id = ".$line->personid);
									
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
	   <td width="185" height="48"><span style="color: blue;">Full Name(s) of Employee:</span></td>
	   <td width="262"><input name="firstname" type="text" class="form-control" id="firstname1" placeholder="First Name(s)" value="<?php if(isset($_GET['id'])) { echo $line->firstname." ".$line->surname; } ?>" readonly/></td>
      <input type="hidden" name="personid" id="personid" value="<?php echo $line->personid; ?>"/>
	   <br /></div>
	   <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	   <td width="185" height="48"><span style="color: blue;">System Username of Employee:</span></td>
	   <td width="262"><input name="username" type="text" class="form-control" id="username" placeholder="Username for System Access" value="<?php echo $line->username; ?>" required/></td>
	  <input name="surname" type="hidden" class="form-control" id="surname" placeholder="Surname" value="<?php echo $line->surname; ?>"/>
	   <input name="firstname" type="hidden" class="form-control" id="firstname" placeholder="Surname" value="<?php echo $line->firstname; ?>"/>
      <br /></div>
	  </fieldset>
	    
      <fieldset>
	   <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
		<td width="185" height="48"><span style="color: blue;">User Group Selection:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<select name="user_type" class="form-control">
		<option value="User" >Select a User Group &nbsp; (Only if the Employee is an Administrator and/or a Supervisor)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
		<!--option value="Sup_user"  <?php if($line->user_type =="Sup_user")echo "selected" ?>>Super User</option-->
		<option value="Admin" <?php if($line->user_type =="Admin")echo "selected" ?>>Administrator</option>
		<option value="Super"  <?php if($line->user_type =="Super")echo "selected" ?>>Supervisor</option>
		<option value="Admin_super"  <?php if($line->user_type =="Admin_super")echo "selected" ?>>Administrator & Supervisor</option>
	  </select>
      <br />
	  <td width="185" height="48"><span style="color: blue;">User Category </span><span style="color: red;">(<strong>CAUTION:</strong> Unticking a previously ticked Category DELETES ALL User Role settings for that Category for this User)</span></td><br> 
     <!-- <input name="EX" type="checkbox" class=""   <?php if($line->ex)echo "checked";?>/> Exec Management -->
	   
	   
	  <input name="EX" type="checkbox" class="has_image" id="has_image" <?php if ($line->ex) echo "checked"; ?> /> Exec Management
	 	 

      <input name="FA" type="checkbox" class="has_image" id="" <?php if($line->fa)echo "checked";?>/> Finance and Accounting
		  
	  <input name="HRA" type="checkbox" id="has_image" class="has_image"  <?php if($line->hra)echo "checked";?>/> HR Administration 

      <input name="AO" type="checkbox" id="has_image" class="has_image"  <?php if($line->ao)echo "checked";?>/> Office Administration 
	   
	  <input name="ITA" type="checkbox" id="has_image" class="has_image"  <?php if($line->ita)echo "checked";?>/> IT Systems Admin  
	  
	  <!--div id="addtional1" <!?php if(!isset($_GET['id']) || $line->ex == 0 ||  $line->fa == 0|| $line->hra == 0|| $line->ao == 0|| $line->ita == 0){?> style="display: none;" <!?php } else {?> style="display: block;"  <!?php }?>  style=" visibility: hidden;" class="boxfield" >
	<br />
	<fieldset>

	<legend>Asset Module</legend>
	
	<input name="ini" type="checkbox" class=""  <!?php if($line->a_init)echo "checked";?>/> Initate 
	  <input name="app" type="checkbox" class=""  <!?php if($line->a_apro)echo "checked";?>/> Approve
      <input name="ins" type="checkbox" class=""  <!?php if($line->a_insp)echo "checked";?>/> Inspect
	  <input name="oth" type="checkbox" class=""  <!?php if($line->a_othr)echo "checked";?>/> Other
	
	</fieldset>
	</div>-->
      <br /><br />

	  <tr>
            <td width="486"><font color = "purple">NB: User Roles Settings e.g. Initator or Approver or Ispector Are Available On Next Page Only For Ticked Categories After Submit</font></td>
      </tr><br/><br/>
     
	  <tr>
           <!--td align="right"><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td-->
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr></div>
	  </fieldset>
   
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>