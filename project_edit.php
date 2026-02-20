<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="jquery-1.12.4.js"></script>
  <script src="jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepickers" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>
<div id="content">
      <?php if ($_GET['op'] <> "D") { ?>
			<br><legend><?php if(!isset($_GET['id'])) echo "ADD NEW "; else echo "UPDATE "; ?>PROJECT</legend>
      <?php  }
	  $line = "";
	  $insUs = $_SESSION[SITE_NAME]['username'];
	  
	       if(isset($_GET['id']))
			{
				$sql="select * from projects where id = ".$_GET['id'];
				$line =  $db->queryUniqueObject($sql);
					
				if(isset($_GET['op']) && $_GET['op'] == "D" && isset($_POST['deactv_trigger']))
					{
					$deactv_trigger=mysql_real_escape_string($_POST['deactv_trigger']);
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
						
					$sql="UPDATE projects set `deactv_trigger` = '$deactv_trigger', `deactv_reason` = '$deactv_reason', `status` = 'Deactivation - Awaiting Approval', `alert_flag` = 'A', `active` = '0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id = ".$_GET['id'];
					 $db->query($sql);	

					$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  
					$line3 = $db->queryUniqueObject("SELECT * FROM projects WHERE id = ".$_GET['id']);

					$sql="SELECT * FROM _user where active = 1 and ao = 1 and a_apro = 1"; 	
						$result = mysql_query($sql);
						$admail = "";
						
							while($row = mysql_fetch_array($result))
						{ 
							$adm_id = $row['personid'];	
							$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $adm_id");
							$admail = "$admin->email, $admail";  }
						 //	echo $admail."<br>";  
						 // echo "Send Project De-Activation notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

							// email setup
						
						$message= "Dear [Approving Admin Officer], \n \nThis is an automatic De-Activation notification message for WWF Project (".$line3->name.") sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Admin Officer) and requires your attention. To APPROVE or DISAPPROVE this De-Activation log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
							
							include 'core/mail_multi.php';
							
							//$zita=$line1->firstname.' '.$line1->surname;
							sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"ALERT: WWF Project De-Activation  - (".$line3->name.") - Requires Attention");  
										
					$msg = "Deactivation of Project Initiated - now awaiting confirmation by Approving Admin Officer";
			
					 ?>
					 <script language="javascript" type="text/javascript">
						window.location = "index.php?c=project_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
				<?php 
					}
	  
				elseif (isset($_GET['id']) && $_GET['op']=="Del"){
					
					$line = $db->queryUniqueObject("SELECT * FROM projects WHERE id = ".$_GET['id']);

					$db->query("UPDATE projects  SET alert_flag='N', active='0', status='Deactivated' where id=".$_GET['id']);
					 
					$db->query("UPDATE budget_codes  SET alert_flag = 'N', active='0', deactv_trigger = '$line->deactv_trigger', deactv_reason = '$line->deactv_reason', status =  'Project Deactivated', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where project_code = '$line->code'");
					 
					$db->query("UPDATE activity_codes  SET alert_flag = 'N', active='0', deactv_trigger = '$line->deactv_trigger', deactv_reason = '$line->deactv_reason', status =  'Project Deactivated', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where project_code = '$line->code'");
					 
					$msg = "Deactivation of Project and ALL Associated Budget Codes Complete - Reactivation Can Only Be Invoked by Initiating Admin Officer";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=project_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

				elseif (isset($_GET['id']) && $_GET['op']=="Rev"){
					
					$line = $db->queryUniqueObject("SELECT * FROM projects WHERE id = ".$_GET['id']);
					
					if ($line->status == 'Deactivation - Awaiting Approval') {
					$sql="UPDATE projects set `deactv_trigger` = NULL, `deactv_reason` = NULL, `status` = 'Active', `alert_flag` = 'N', `active` = '1', updTS = NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Deactivation of Project Declined - Project Restored To Original Active Status"; }
			
					elseif ($line->status == 'Reinstatement - Awaiting Activation' || $line->status == 'New - Awaiting Activation') {
						$sql="UPDATE projects set `status` = 'Activation/Reactivation Declined', `alert_flag` = 'N', `active` = '0', updTS=NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Activation/Reactivation of Project Declined - Project Restored To Original Inactive Status"; }
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=project_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif(isset($_GET['id']) && $_GET['op']=="R"){
					
					$db->query("UPDATE projects  SET alert_flag='A', status='Reinstatement - Awaiting Activation' , `updTS` = NOW(), `updU` = '$insUs'  where id=".$_GET['id']);

					$msg = "Reactivation of Project Initiated - now awaiting confirmation by Approving Admin Officer";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=project_admin&flag=D&msg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif(isset($_GET['id']) && $_GET['op']=="A"){
			
					$db->query("UPDATE projects  SET active = '1', status = 'Active', alert_flag = 'N', deactv_trigger = NULL, deactv_reason = NULL, updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
						
					echo "<br><font color=green size=+1 >  Project $name Activated/Reactivated Successfully !</font>" ;
					 
					$line = $db->queryUniqueObject("SELECT * FROM projects WHERE id = ".$_GET['id']);
					
			}
					
	  		elseif (isset($_GET['id'])&& isset($_POST['name'])){
				 
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$location=mysql_real_escape_string($_POST['location']);
			$donor =mysql_real_escape_string($_POST['donor']);
			$budget_code=mysql_real_escape_string($_POST['budget_code']);
			$budget=mysql_real_escape_string($_POST['budget']);
			$contacts=mysql_real_escape_string($_POST['contacts']);
			$email=mysql_real_escape_string($_POST['email']);
			$wwf_admin=mysql_real_escape_string($_POST['wwf_admin']);
			$wwf_admemail=mysql_real_escape_string($_POST['wwf_admemail']);
			$donor_mgr=mysql_real_escape_string($_POST['donor_mgr']);
			$donor_mgremail=mysql_real_escape_string($_POST['donor_mgremail']);
			$donor_admin=mysql_real_escape_string($_POST['donor_admin']);
			$donor_admemail=mysql_real_escape_string($_POST['donor_admemail']);
			$start_date=mysql_real_escape_string($_POST['start_date']);
			$end_date=mysql_real_escape_string($_POST['end_date']);
				 
				 
				 
				 
				 if($db->query("UPDATE `projects`
SET 
  
	name = '$name',
	description = '$description',
	location = '$location',
	donor = '$donor', 
	budget_code = '$budget_code',
	budget = '$budget',
	contacts = '$contacts', 
	email = '$email',
	donor_mgr = '$donor_mgr',
	donor_mgremail = '$donor_mgremail',
	wwf_admin = '$wwf_admin',
	wwf_admemail = '$wwf_admemail', 
	donor_admin = '$donor_admin',
	donor_admemail = '$donor_admemail',
	start_date = '$start_date', 
	end_date = '$end_date',
	updTS=NOW(),
	updU='".$_SESSION[SITE_NAME]['username']."' 
	where id=".$_GET['id']))


						{echo "<br><font color=green size=+1 > Project $name Has Been Updated Successfully!</font>" ;
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM projects WHERE id=$id");
				
				}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Project!</font>" ;
					
					}
	  
					 }
	  	  
				elseif(!isset($_GET['id'])&& isset($_POST['name']))

            {
			
//var_dump($_POST);
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$location=mysql_real_escape_string($_POST['location']);
			$status = mysql_real_escape_string($_POST['status']);
			$donor =mysql_real_escape_string($_POST['donor']);
			$budget_code=mysql_real_escape_string($_POST['budget_code']);
			$budget=mysql_real_escape_string($_POST['budget']);
			$contacts=mysql_real_escape_string($_POST['contacts']);
			$email=mysql_real_escape_string($_POST['email']);
			$wwf_admin=mysql_real_escape_string($_POST['wwf_admin']);
			$wwf_admemail=mysql_real_escape_string($_POST['wwf_admemail']);
			$donor_mgr=mysql_real_escape_string($_POST['donor_mgr']);
			$donor_mgremail=mysql_real_escape_string($_POST['donor_mgremail']);
			$donor_admin=mysql_real_escape_string($_POST['donor_admin']);
			$donor_admemail=mysql_real_escape_string($_POST['donor_admemail']);
			$start_date=mysql_real_escape_string($_POST['start_date']);
			$end_date=mysql_real_escape_string($_POST['end_date']); 
			
			$count = $db->countOf("projects", "name='$name'");
		
		if($count==1)
			{
		echo "<font color=red> $name already Exists. Please Verify</font>";
			}
			else
			{
					/*
					 ["name"]=> string(4) "hope" ["code"]=> string(8) "12345678" ["description"]=> string(4) "teds" ["location"]=> string(4) "ssss" ["status"]=> string(5) "sssss" ["donor"]=> string(4) "ssss" ["budget"]=> string(4) "ssss" ["contacts"]=> string(4) "ssss" ["email"]=> string(6) "ssssss" ["start_date"]=> string(4) "ssss" ["end_date"]=> string(4) "ssss"
					*/	
					$sql="INSERT INTO `projects` 	
					(`code`, `name`, `description`, `location`, `status`, `alert_flag`, `donor`, `budget_code`, `budget`, `contacts`, `email`, `donor_mgr`, `donor_mgremail`, `wwf_admin`, `wwf_admemail`, `donor_admin`, `donor_admemail`, `start_date`, `end_date`, `insTS`, `insU`)
	VALUES
	( 
	'$code',
	'$name',
	'$description',
	'$location',
	'New - Awaiting Activation', 
	'A',
	'$donor', 
	'$budget_code',
	'$budget',
	'$contacts', 
	'$email',
	'$wwf_admin',
	'$wwf_admemail',
	'$donor_mgr',
	'$donor_mgremail',
	'$donor_admin',
	'$donor_admemail',
	'$start_date', 
	'$end_date', 
	NOW(),
	'".$_SESSION[SITE_NAME]['username']."'
	)";
	
//echo $sql;
			//if($db->query("insert into projects values(NULL,'$code','$name','$description',NOW(),'".$_SESSION[SITE_NAME]['username']."',NULL,NULL,1)"))
			
			$db->query($sql);
            $projects=mysql_insert_id();

			$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  

			$sql="SELECT * FROM _user where active = 1 and ao = 1 and a_apro = 1"; 	
				$result = mysql_query($sql);
				$admail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$adm_id = $row['personid'];	
					$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $adm_id");
					$admail = "$admin->email, $admail";  }
				 //	echo $admail."<br>";  
				 // echo "Send New Project added notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Approving Admin Officer], \n \nThis is an automatic Project addition notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Admin Officer) and requires your attention. To ACTIVATE or DECLINE this new Project log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"ALERT: New WWF Zim Project Added  - (".$name.") - Requires Attention");  
										
			echo "<br><font color=green size=+1 >  Project $name Added Successfully! Now Awaiting Activation By Approving Admin Officer</font>" ;
						
			}
			
			
			}
			
				
				?>
     <form action="" method="post">
     
		<?php if (isset($_GET['op']) && $_GET['op'] == "D") { ?>
			 <br>
			 <fieldset>
			  <legend>Project Deactivation</legend> 
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	            
           <td width="185" height="48"><span style="color: blue;">Project Code:</span></td>
		   <td width="393"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>" readonly/>
				<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Project Code" required/>
				<?php   }  ?> </td>
		   
		   <br />
			  
		   <td width="185" height="37"><span style="color: blue;">Description:</span></td>
			   <td width="393"><input name="description" type="text" class="form-control" value="<?php echo $line->description; ?>" readonly/></td>

			<br />
			  
		   <td width="185" height="42"><span style="color: blue;">Deactivation Trigger:</span></td>
			   <td width="393"><select id="deactv_trigger" name="deactv_trigger" class="form-control"  required>
			   <option  value=""  >Please select a Trigger for Deactivation</option>
			   <option  value="Terminated">Project Termination</option>
			   <option  value="Suspended">Project Suspension</option>
			   <option  value="Deactivated">Other Project Deactivation</option>
			   </select></td>

			<br />
			  
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

			  <td width="185" height="43"><span style="color: blue;">Project Name:</span></td>
			  <td width="393"><input name="name" type="text" class="form-control" value="<?php echo $line->name; ?>" readonly/></td>

			  <br />
			  
			  <td width="185" height="36"><span style="color: blue;">Project Location:</span></td>
			   <td width="393"><input name="location" type="text" class="form-control" value="<?php echo $line->location; ?>" readonly/></td>

			  <br />
			  
		      <td width="185" height="45"><span style="color: blue;">Deactivation Reason:</span></td>
			   <td width="393"><textarea rows="2" cols="53" name="deactv_reason" placeholder="Enter FULL Reason for Deactivation" id="deactv_reason"  required/></textarea></td>

			  <br />
			  
			</div>
			</fieldset>
		<?php }  else  {  ?>
	 <fieldset>
      <legend>Project Static Information</legend> 
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

           <td width="185" height="48"><span style="color: blue;">Project Code:</span></td>
		   <td width="393"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>     [Readonly]" readonly/>
				<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Project Code" required/>
				<?php   }  ?> </td>
		   
		   <br />
			  
		   <td width="185" height="37"><span style="color: blue;">Description:</span></td>
           <td width="393"><input name="description" type="text" id="description"  Placeholder="Project Description" class="form-control" value="<?php echo $line->description; ?>" required/></td>

			<br />
			  
		   <td width="185" height="42"><span style="color: blue;">Project Donor:</span></td>
		   <td width="393"><input name="donor" type="text" id="donor"  Placeholder="Project Donor" class="form-control" value="<?php echo $line->donor; ?>" required/></td>

			<br />
			  
		   <td width="185" height="37"><span style="color: blue;">Holder's contact:</span></td>
		   <td width="393"><input name="contacts" type="text" id="contacts"  Placeholder="Budget Holder's Contact Numbers" class="form-control" value="<?php echo $line->contacts; ?>" required/></td>
			  
			<br />
		</div>	  
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
		   <td width="185" height="43"><span style="color: blue;">Project Name:</span></td>
           <td width="393"><input name="name" type="text" id="name"  Placeholder="Project Name" class="form-control" value="<?php echo $line->name; ?>" required/></td>

			<br />
			  
           <td width="185" height="36"><span style="color: blue;">Project Location:</span></td>
           <td width="393"><input name="location" type="text" id="location"  Placeholder="Project location" class="form-control" value="<?php echo $line->location; ?>" required/></td>

			<br />
			  
		   <td width="185" height="37"><span style="color: blue;">Budget Holder:</span></td>
		   <td width="393"><input name="budget" type="text" id="budget"  Placeholder="Project Budget Holder" class="form-control" value="<?php echo $line->budget; ?>" required/></td>

			<br />
			  
			<td width="185" height="38"><span style="color: blue;">Holder's email:</span></td>
			<td width="393"><input name="email" type="text" id="email"  Placeholder="Budget Holder's Email Address" class="form-control" value="<?php echo $line->email; ?>" required/></td>
			
			<br />
		</div>	  
	 </fieldset>	  
			  
	 <fieldset>
       <legend>Project Adminstration Information</legend> 
	     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

			 <td width="185" height="37"><span style="color: blue;">Donor Project Manager:</span></td>
			 <td width="393"><input name="donor_mgr" type="text" id="donor_mgr"  Placeholder="Donor Project Manager" class="form-control" value="<?php echo $line->donor_mgr; ?>"></td>

			<br />
			  
			 <td width="185" height="37"><span style="color: blue;">Donor Project Admin:</span></td>
			 <td width="393"><input name="donor_admin" type="text" id="donor_admin"  Placeholder="Donor Project Administrator" class="form-control" value="<?php echo $line->donor_admin; ?>"></td>

			<br />
			  
			<td width="185" height="37"><span style="color: blue;">WWF Project Admin:</span></td>
			<td width="393"><input name="wwf_admin" type="text" id="wwf_admin"  Placeholder="WWF Project Administrator" class="form-control" value="<?php echo $line->wwf_admin; ?>"></td>

			<br />
			  
			 <td width="185" height="41"><span style="color: blue;">Start Date:</span></td>
			 <td width="393"><input name="start_date" type="text" id="datepickers"  Placeholder="Project Start Date - Mandatory (YYYY/MM/DD)" class="form-control datepicker" value="<?php echo $line->start_date; ?>" required/></td>

			<br />
		</div>	  
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
			  
		     <td width="185" height="38"><span style="color: blue;">Donor Prjct Mgr email:</span></td>
			 <td width="393"><input name="donor_mgremail" type="text" id="dmgr_email"  Placeholder="Donor Manager's Email Address" class="form-control" value="<?php echo $line->donor_mgremail; ?>" ></td>

			<br />
			  
		     <td width="185" height="38"><span style="color: blue;">Donor Prjct Admin email:</span></td>
			 <td width="393"><input name="donor_admemail" type="text" id="dadmn_email"  Placeholder="Donor Admin's Email Address" class="form-control" value="<?php echo $line->donor_admemail; ?>" ></td>

			<br />
			  
			<td width="185" height="38"><span style="color: blue;">WWF Prjct Admin email:</span></td>
			<td width="393"><input name="wwf_admemail" type="text" id="wwf_admemail"  Placeholder="WWF Admin's Email Address" class="form-control" value="<?php echo $line->wwf_admemail; ?>" ></td>

			<br />
			  
			 <td width="185" height="37"><span style="color: blue;">End Date:</span></td>
			 <td width="393"><input name="end_date" type="text" id="datepicker"  Placeholder="Project End Date - Optional (YYYY/MM/DD)" class="form-control datepicker" value="<?php echo $line->end_date; ?>" /></td>
			<br />
		</div>	  
	 </fieldset>	  
			   
		<?php } ?>

	<fieldset> 
	  <div>
		<?php if(isset($_GET['id'])) { 
		   
		$sql = "SELECT * FROM budget_codes WHERE active = 1 and project_code = $line->code";
			$result = mysql_query($sql);
			
		   ?> 
		   <br><legend>Manage Associated Budget Codes: </legend> 

		                <table class="table table-striped table-bordered">
                            <thead>
                              <tr>
							    	<th>Budget Code</th>
							        <th>Description</th>
							    	<th>Allocation</th>
							    	<th>Status</th>
							    	<th>Action</th>
                              </tr>
                           </thead>
                            <tbody>
							<?php 
								while($rows = mysql_fetch_array($result))
							{ 
							//var_dump();
								?>
                              <tr>
                                
							  <td><a href="index.php?c=budgetcde_detail&id=<?php echo  $rows['id'];?>&src=prj"><?php echo $rows['code']; ?></a></td>
							  <td><?php echo $rows['description'];?></td>
							  <td><?php echo $rows['allocation'];?></td>
							  <td><?php echo $rows['status'];?></td>
							  <td><a href="index.php?c=budgetcde_detail&id=<?php echo  $rows['id'];?>&src=prj">[View]</a>
								  <a href="index.php?c=budget_code_edit&id=<?php echo $rows['id'];?>&src=prj">[Edit]</a>
								  <a onclick="return confirm('CAUTION!! This Action WILL DEACTIVATE the ENTIRE Budget Code including ALL of its associated Activity Codes - Are you sure you want to PROCEED?')" href="index.php?c=budget_code_edit&id=<?php echo $rows['id'];?>&op=D&src=prj">[Deactivate]</a></td>
							  </tr>
							                           							
							<?php 
							} ?> 
						</tbody>	
			</table>				  
		  <?php 
				$count2 = $db->countOf("budget_codes", "active = 1 and project_code = $line->code");
				if ($count2 == 0) { ?>
				  
				 <br><center><font color=red>There Are No <strong>Budget Codes</strong> Associated With This Project At This Time!! To add a Budget Code now <strong><a href="index.php?c=budget_code_edit">click here</a></strong> otherwise add later via <strong><a href="index.php?c=budget_code_admin">Budget Adminstration</a></strong></font></center><br><br> 
		  
			<?php } } ?>

		 </div>						  		  
	 </fieldset>	  

	 <tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
             <td><input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
		     <td><a href="index.php?c=project_admin&flag=A" class="btn-small btn-color btn-pad">Exit</a></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>