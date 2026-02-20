<div id="content">
      <br/><legend><?php if(!isset($_GET['id'])) echo "Add New "; elseif ($_GET['op']=="D") echo "Deactivate "; else echo "Update "; ?>Department</legend>
      <?php 
	  $line="";
	  $insUs = $_SESSION[SITE_NAME]['username'];

	  if(!isset($_GET['id'])&& isset($_POST['name']))

            {
			

			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$location=mysql_real_escape_string($_POST['location']);
			
			$count = $db->countOf("company_dept", "name='$name'");
		
		if($count==1)
			{
		echo "<font color=red> $name already Exists. Please Verify</font>";
			}
			else
				
			{
						
			if($db->query("insert into company_dept values(NULL,'$code','$name','$description','$location','New - Awaiting Activation','A',1,0,0,1,NULL,NOW(),'".$_SESSION[SITE_NAME]['username']."',NULL,NULL,1)"))  {

			$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  

			$sql="SELECT * FROM _user where active = 1 and hra = 1 and h_apro = 1"; 	
				$result = mysql_query($sql);
				$hradmail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$hradm_id = $row['personid'];	
					$hradmin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $hradm_id");
					$hradmail = "$hradmin->email, $hradmail";  }
				 //	echo $hradmail."<br>";  
				 // echo "Send New Department added notification email to ".$hradmin->firstname.' '.$hradmin->surname." on address ".$hradmin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Approving Human Resources Officer], \n \nThis is an automatic Department addition notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating HR Officer) and requires your attention. To ACTIVATE or DECLINE this new Department log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving HR Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $hradmin->firstname.' '.$hradmin->surname,$hradmail,$message,"ALERT: New WWF Zim Department Added  - (".$name.") - Requires Attention");  
										
			echo "<br><font color=green size=+1 > Department:- $name Added Successfully! Now Awaiting Activation By Approving HR Officer</font>" ;  }
			else
			echo "<br><font color=red size=+1 >Problem in Adding Department!</font>" ;
			
			}
			
			
			}
	////////////////////////////////Dept update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['name'])){
			
					
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$location=mysql_real_escape_string($_POST['location']);
								
					if($db->query("UPDATE company_dept  SET name='$name',description='$description',location='$location',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id'])) {
					echo "<br><font color=green size=+1 > Department:- $name  Successfully Updated!</font>" ;
					$line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE active = 1 and id = ".$_GET['id']);
					}
					else
					{echo "<br><font color=red size=+1 >Problem in Updating Department!</font>" ;}
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D" && isset($_POST['deactv_reason'])){
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);

					$db->query("UPDATE company_dept  SET `deactv_reason` = '$deactv_reason', `status` = 'Deactivation - Awaiting Approval', `alert_flag` = 'A', active='0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);

					$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  
					$line3 = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id = ".$_GET['id']);

					$sql="SELECT * FROM _user where active = 1 and hra = 1 and h_apro = 1"; 	
						$result = mysql_query($sql);
						$hradmail = "";
						
							while($row = mysql_fetch_array($result))
						{ 
							$hradm_id = $row['personid'];	
							$hradmin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $hradm_id");
							$hradmail = "$hradmin->email, $hradmail";  }
						 //	echo $hradmail."<br>";  
						 // echo "Send Department De-Activation notification email to ".$hradmin->firstname.' '.$hradmin->surname." on address ".$hradmin->email."<br>" ; 

							// email setup
						
						$message= "Dear [Approving Human Resources Officer], \n \nThis is an automatic De-Activation notification message for WWF Department (".$line3->name.") sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating HR Officer) and requires your attention. To APPROVE or DISAPPROVE this De-Activation log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving HR Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
							
							include 'core/mail_multi.php';
							
							//$zita=$line1->firstname.' '.$line1->surname;
							sendemail( $hradmin->firstname.' '.$hradmin->surname,$hradmail,$message,"ALERT: WWF Department De-Activation  - (".$line3->name.") - Requires Attention");  
										
					$msg = "Deactivation of Department Initiated - now awaiting confirmation by Approving Human Resources Officer";

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=dept_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			
			elseif (isset($_GET['id']) && $_GET['op']=="Del"){
					
					$db->query("UPDATE company_dept  SET alert_flag='N', active='0', status='Deactivated' where id=".$_GET['id']);
					 
					$msg = "Deactivation of Department Completed - Reactivation Can Only Be Invoked by Initiating Admin Officer";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=dept_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

				elseif (isset($_GET['id']) && $_GET['op']=="Rev" && isset($_POST['deactv_reason'])){
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
					
					$line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id = ".$_GET['id']);
					
					if ($line->status == 'Deactivation - Awaiting Approval') {
					$sql="UPDATE company_dept set `deactv_reason` = NULL, `status` = 'Active', `alert_flag` = 'N', `active` = '1', updTS = NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Deactivation of Department Declined - Department Restored To Original Active Status"; }
			
					elseif ($line->status == 'Reinstatement - Awaiting Activation' || $line->status == 'New - Awaiting Activation') {
						$sql="UPDATE company_dept set `deactv_reason` = '$deactv_reason', `status` = 'Activation/Reactivation Declined', `alert_flag` = 'N', `active` = '0', updTS=NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Activation/Reactivation of Department Declined - Department Restored To Original Inactive Status"; }
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=dept_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif(isset($_GET['id']) && $_GET['op']=="R"){
					
					$db->query("UPDATE company_dept  SET alert_flag='A', status='Reinstatement - Awaiting Activation' , `updTS` = NOW(), `updU` = '$insUs'  where id=".$_GET['id']);

					$msg = "Reactivation of Department Initiated - now awaiting confirmation by Approving Admin Officer";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=dept_admin&flag=D&msg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif (isset($_GET['id']) && $_GET['op']=="A"){
				
					$db->query("UPDATE company_dept  SET active = '1', status = 'Active', alert_flag = 'N', deactv_reason = NULL, updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
					
					//echo "<br><font color=green size=+1 >  Department $name Activated/Reactivated Successfully!!</font>" ;
					$msg = "Department Activated/Reactivated Successfully!!";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=dept_admin&flag=A&msg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
	  
			
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       
	   <table width="585"  border="0" cellspacing="0" cellpadding="0">
	            
         <tr>
           <td width="185" height="48"><span style="color: blue;">Dept Code:</span></td>
           <td width="393"><?php if(isset($_GET['id'])){echo $line->code;}else{?><input name="code" type="text" id="code"  maxlength="20" Placeholder="Enter Department Code" class="form-control" value="<?php echo $line->code; ?>" required/><?php }?></td>
         </tr> 
		 
		<?php if (isset($_GET['op']) && ($_GET['op'] == "D" || $_GET['op'] == "Rev")) { ?>
			<tr>
			  <td width="185" height="43"><span style="color: blue;">Department Name:</span></td>
			  <td width="393"><?php echo $line->name; ?></td>
			 </tr>
			 <tr>
			   <td width="185" height="37"><span style="color: blue;">Description:</span></td>
			   <td width="393"><?php echo $line->description; ?></td>
			 </tr>
			  <tr>
			   <td width="185" height="36"><span style="color: blue;">Department Location:</span></td>
			   <td width="393"><?php echo $line->location; ?></td>
			 </tr>
			 <tr><td>&nbsp;</td></tr>
			  <tr>
			   <td width="185" height="45"><span style="color: blue;">Deactivation or Decline Reason:</span></td>
			   <td width="393"><textarea rows="2" cols="58" name="deactv_reason" placeholder="Enter FULL Reason for Deactivation or Decline" id="deactv_reason"  required/></textarea></td>
			 </tr>
		<?php }  else  {  ?>
			<tr>
			   <td width="185" height="43"><span style="color: blue;">Dept Name:</span></td>
			  <td width="393"><input name="name" type="text" id="name"  Placeholder="Department Name" class="form-control" value="<?php echo $line->name; ?>" required/></td>
			 </tr>
			 <tr>
			   <td width="185" height="37"><span style="color: blue;">Description:</span></td>
			   <td width="393"><input name="description" type="text" id="description"  Placeholder="Department Description" class="form-control" value="<?php echo $line->description; ?>" ></td>
			 </tr>
			  <tr>
			   <td width="185" height="36"><span style="color: blue;">Dept Location:</span></td>
			   <td width="393"><input name="location" type="text" id="location"  Placeholder="Department location" class="form-control" value="<?php echo $line->location; ?>" ></td>
			 </tr>
		<?php } ?>
	     
		 <tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
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