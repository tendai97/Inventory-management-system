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
	  <br><legend><?php if(!isset($_GET['id'])) echo "ADD NEW "; else echo "UPDATE "; ?>BUDGET CODE</legend>
      <?php }
	  $line = "";
	  $insUs = $_SESSION[SITE_NAME]['username'];
	  
	       if(isset($_GET['id']))
			{
				$sql="select * from budget_codes where id = ".$_GET['id'];
				$line =  $db->queryUniqueObject($sql);
					
				if(isset($_GET['op']) && $_GET['op'] == "D" && isset($_POST['deactv_trigger']))
					{
					$deactv_trigger=mysql_real_escape_string($_POST['deactv_trigger']);
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
						
					$sql="UPDATE budget_codes set `deactv_trigger` = '$deactv_trigger', `deactv_reason` = '$deactv_reason', `status` = 'Deactivated', `alert_flag` = 'N', active='0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id = ".$_GET['id'];
						$db->query($sql);	
					 
					$db->query("UPDATE activity_codes  SET alert_flag = 'N', active='0', deactv_trigger = '$deactv_trigger', deactv_reason = '$deactv_reason', status =  'Budget Code Deactivated', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where budget_code = '$line->code'");
					 
					$msg = "Deactivation of Budget Code and ALL Associated Activity Codes Completed";
			
					 ?>
					 <script language="javascript" type="text/javascript">
						window.location = "index.php?c=budget_code_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
				<?php 
					}
	  
				elseif (isset($_GET['id']) && $_GET['op']=="Rev" && isset($_POST['deactv_trigger'])){
					
					$deactv_trigger=mysql_real_escape_string($_POST['deactv_trigger']);
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
						
					$line = $db->queryUniqueObject("SELECT * FROM budget_codes WHERE id = ".$_GET['id']);
					
					$sql="UPDATE budget_codes set `deactv_trigger` = '$deactv_trigger', `deactv_reason` = '$deactv_reason', `status` = 'Activation Declined', `alert_flag` = 'N', `active` = '0', updTS = NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Activation of Budget Code Declined - Budget Code Assigned A Deactivated Status"; 
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=budget_code_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif(isset($_GET['id']) && $_GET['op']=="A"){
			
					$db->query("UPDATE budget_codes  SET active = '1', status = 'Active', alert_flag = 'N', deactv_trigger = NULL, deactv_reason = NULL, updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
						
					echo "<br><font color=green size=+1 >  Budget Code $line->code Activated Successfully !</font>" ;
					 
					$line = $db->queryUniqueObject("SELECT * FROM budget_codes WHERE id = ".$_GET['id']);
					
			}
					
	  		elseif (isset($_GET['id'])&& isset($_POST['description'])){
				 
			$project_code=mysql_real_escape_string($_POST['project_code']);
			$description=mysql_real_escape_string($_POST['description']);
			$allocation=mysql_real_escape_string($_POST['allocation']);
			$donor_name=mysql_real_escape_string($_POST['donor_name']);
			$alloc_date=mysql_real_escape_string($_POST['alloc_date']);
			$tele_contacts=mysql_real_escape_string($_POST['tele_contacts']);
			$wwf_admin=mysql_real_escape_string($_POST['wwf_admin']);
			$wwf_admemail=mysql_real_escape_string($_POST['wwf_admemail']);
			$donor_mgr=mysql_real_escape_string($_POST['donor_mgr']);
			$donor_mgremail=mysql_real_escape_string($_POST['donor_mgremail']);
			$donor_admin=mysql_real_escape_string($_POST['donor_admin']);
			$donor_admemail=mysql_real_escape_string($_POST['donor_admemail']);
				 
				 if($db->query("UPDATE `budget_codes`
SET 
  
	description = '$description',
	allocation = '$allocation',
	alloc_date = '$alloc_date',
	donor_name = '$donor_name', 
	project_code = '$project_code',
	tele_contacts = '$tele_contacts', 
	donor_mgr = '$donor_mgr',
	donor_mgremail = '$donor_mgremail',
	wwf_admin = '$wwf_admin',
	wwf_admemail = '$wwf_admemail', 
	donor_admin = '$donor_admin',
	donor_admemail = '$donor_admemail',
	updTS=NOW(),
	updU='".$_SESSION[SITE_NAME]['username']."' 
	where id=".$_GET['id']))


						{echo "<br><font color=green size=+1 > Budget Code $line->code Has Been Updated Successfully!</font>" ;
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM budget_codes WHERE id=$id");
				
				}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Budget Code!</font>" ;
					
					}
	  
					 }
	  	  
				elseif(!isset($_GET['id'])&& isset($_POST['description']))

            {
			
			$code=mysql_real_escape_string($_POST['code']);
			$project_code=mysql_real_escape_string($_POST['project_code']);
			$description=mysql_real_escape_string($_POST['description']);
			$allocation=mysql_real_escape_string($_POST['allocation']);
			$donor_name=mysql_real_escape_string($_POST['donor_name']);
			$alloc_date=mysql_real_escape_string($_POST['alloc_date']);
			$tele_contacts=mysql_real_escape_string($_POST['tele_contacts']);
			$wwf_admin=mysql_real_escape_string($_POST['wwf_admin']);
			$wwf_admemail=mysql_real_escape_string($_POST['wwf_admemail']);
			$donor_mgr=mysql_real_escape_string($_POST['donor_mgr']);
			$donor_mgremail=mysql_real_escape_string($_POST['donor_mgremail']);
			$donor_admin=mysql_real_escape_string($_POST['donor_admin']);
			$donor_admemail=mysql_real_escape_string($_POST['donor_admemail']);
			
			$count = $db->countOf("budget_codes", "code = '$code'");
		
		if($count > 0)
			{
		echo "<font color=red> Budget Code $code already Exists. Please Verify</font>";
			}
			else
			{
					$sql="INSERT INTO `budget_codes` 	
					(`code`, `project_code`, `description`, `allocation`, `alloc_date`, `status`, `alert_flag`, `donor_name`, `tele_contacts`, `donor_mgr`, `donor_mgremail`, `wwf_admin`, `wwf_admemail`, `donor_admin`, `donor_admemail`, `insTS`, `insU`)
	VALUES
	( 
	'$code',
	'$project_code',
	'$description',
	'$allocation',
	'$alloc_date',
	'New - Awaiting Activation', 
	'A',
	'$donor_name', 
	'$tele_contacts', 
	'$donor_mgr',
	'$donor_mgremail',
	'$wwf_admin',
	'$wwf_admemail',
	'$donor_admin',
	'$donor_admemail',
	NOW(),
	'".$_SESSION[SITE_NAME]['username']."'
	)";
	
			$db->query($sql);
            $budgets = mysql_insert_id();
			
			echo "<br><font color=green size=+1 >  Budget Code $code Added Successfully !</font>" ;
						
			}
			
			
			}
			
				
				?>
     <form action="" method="post" enctype="multipart/form-data">

		<?php if (isset($_GET['op']) && ($_GET['op'] == "D" || $_GET['op'] == "Rev")) { ?>
			 <br>
			 <fieldset>
			  <legend>Budget Code Deactivation</legend> 
			  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
				<td width="185" height="48"><span style="color: blue;">Budget Code:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				<td width="262"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>   [Readonly]" readonly/>
				<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Budget Code" required/>
				<?php   }  ?> </td>

			  <br />
			  
			   <td width="185" height="42"><span style="color: blue;">Deactivation/Decline Trigger:</span></td>
			   <td width="393"><select id="deactv_trigger" name="deactv_trigger" class="form-control"  required>
			   <option  value=""  >Please select a Trigger for Deactivation or Decline</option>
			   <option  value="Terminated">Budget Code Termination/Closure</option>
			   <option  value="Declined">Declined Budget Code Activation</option>
			   <option  value="Deactivated">Other Deactivation Reason</option>
			   </select></td>

			   <br />

			   </div>

			  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
			 
			   <td width="185" height="48"><span style="color: blue;">Description of Budget Code:</span></td>
			  <td width="262"><input name="description" type="text" id="description" placeholder="Description of Budget Code"  class="form-control" value="<?php echo $line->description; ?>" /></td>
				 
			  <br />  
			 
			   <td width="185" height="45"><span style="color: blue;">Reason for Deactivation or Activation Decline:</span></td>
			   <td width="393"><textarea rows="2" cols="53" name="deactv_reason" placeholder="Enter FULL Reason for Deactivation or Declining" id="deactv_reason"  required/></textarea></td>
			 <br />
			 </div>
	
		</fieldset>
			 
		<?php }  else  {  ?>
	 
	 <fieldset>
      <legend>Budget Code Statics And Financials</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	    <td width="185" height="48"><span style="color: blue;">Budget Code:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<td width="262"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>   [Readonly]" readonly/>
		<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Budget Code" required/>
 		<?php   }  ?> </td>

	  <br />
	  
       <td width="185" height="48"><span style="color: blue;">Description of Budget Code:</span></td>
	  <td width="262"><input name="description" type="text" id="description" placeholder="Description of Budget Code"  class="form-control" value="<?php echo $line->description; ?>" /></td>
         
      <br />  
	  
      <td width="185" height="48"><span style="color: blue;">Original Allocation in $s:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	      <td width="262"><input name="allocation"  type="text" id="allocation"  placeholder="Amount originally awarded to Budget Code"  class="form-control" value="<?php echo $line->allocation; ?>"/>
	  </td>
         <br />
		 
       <?php if (isset($_GET['id'])){ ?>
		   <td width="185" height="48"><span style="color: blue;">Balance of Allocation in $s:</span></td>
		   <td width="262"><input name="alloc_balance" type="text" class="form-control" value="<?php echo $line->alloc_balance; ?>   [Readonly]" readonly/></td>
		   <br />  
		<?php   }  ?>

	 </div>

	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

	  <td width="185" height="48"><span style="color: blue;">Project Name:</span></td>
      <td width="262"><select name="project_code" id="project_code"  class="form-control" required>
			 <option value="">Please select the Project Code and Name</option>
              <?php
			 $proj=$db->query( "SELECT * FROM  projects where active = 1 ORDER BY name");
			 while($row = mysql_fetch_array($proj))

		{if($row['code']== $line->project_code)
			echo ' <option value="'.$row['code'].'" selected>'.$row['code'].' - '.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['code'].' - '.$row['name'].'</option>';
			}
              ?>
            </select>
			
	  <br />
	   
       <td width="185" height="48"><span style="color: blue;">Project Description:</span></td>
	   <td width="262"><input name="project_description" type="text" class="form-control"  placeholder="Description of Project   [Readonly - based on Project Code]" value="<?php $temp = $line->project_code;
				$sql="SELECT * FROM  projects where code = '$temp' and active = 1";
				$line2 = $db->queryUniqueObject($sql);
			 	echo $line2->description;  ?>" readonly/></td>
       <br />  

	   <td width="185" height="48"><span style="color: blue;">Date of Budget Allocation:</span></td>
	   <td width="262"><input name="alloc_date" type="text" id="datepicker"  placeholder="Date of Allocation (YYYY/MM/DD)" class="datepicker  form-control" value="<?php echo $line->alloc_date; ?>"/></td>         
      <br />

       <?php if (isset($_GET['id'])){ ?>
		   <td width="185" height="48"><span style="color: blue;">Allocation Amount Used To-Date:</span></td>
		   <td width="262"><input name="alloc_expended" type="text" class="form-control" value="<?php echo $line->alloc_expended; ?>   [Readonly]" readonly/></td>
		   <br />  
		<?php   }  ?>

	  </div>	
	</fieldset>
     	 
	<fieldset>
      <legend>Adminstrative and Contact Information</legend> 
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <td width="185" height="48"><span style="color: blue;">Name of Donor:</span></td>
	  <td width="262"><input name="donor_name" type="text" class="form-control" id="donor_name" placeholder="Name of Donor" value="<?php echo $line->donor_name ;?>" required/></td>
      <br />

   	  <td width="185" height="48"><span style="color: blue;">Donor Manager Rep:</span></td>
			<td width="262"><input name="donor_mgr" type="text" class="form-control" id="donor_mgr" placeholder="Donor Manager Representative" value="<?php echo $line->donor_mgr ;?>"/></td>
	  <br />

	  <td width="185" height="48"><span style="color: blue;">Donor Admin Rep:</span></td>
			  <td width="262"><input name="donor_admin" type="text" id="donor_admin"  placeholder="Donor Admin Representative" class="form-control" value="<?php echo $line->donor_admin; ?>"/></td>
	  <br />

	  <td width="185" height="48"><span style="color: blue;">WWF Admin Rep:</span></td>
			  <td width="262"><input name="wwf_admin" type="text" id="wwf_admin"  placeholder="WWF Admin Representative" class="form-control" value="<?php echo $line->wwf_admin; ?>"/></td>
	  <br />
      </div>
      
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <td width="185" height="48"><span style="color: blue;">Telephone Contacts:</span></td>
	  <td width="262"><input name="tele_contacts" type="text" id="tele_contacts" placeholder="Telephone Contacts of Donor"  class="form-control" value="<?php echo $line->tele_contacts; ?>" /></td>        				
      <br />
	  
      <td width="185" height="48"><span style="color: blue;">Donor Manager Email Address:</span></td>
	  <td width="262"><input name="donor_mgremail" type="text" id="donor_mgremail" placeholder="Donor Manager Email Address"  class="form-control" value="<?php echo $line->donor_mgremail; ?>" required/></td>
	  <br />
	  	   	  
       <td width="185" height="48"><span style="color: blue;">Donor Admin Email Address:</span></td>
	  <td width="262"><input name="donor_admemail" type="text" id="donor_admemail" placeholder="Donor Admin Email Address"  class="form-control" value="<?php echo $line->donor_admemail; ?>" /></td>
	   
	   <br /> 
     	
	   <td width="185" height="48"><span style="color: blue;">WWF Admin Email Address:</span></td>
	  <td width="262"><input name="wwf_admemail" type="text" id="wwf_admemail" placeholder="WWF Admin Email Address"  class="form-control" value="<?php echo $line->wwf_admemail; ?>" /></td>
	    
      <br /></div>
      
	  </fieldset>
		<?php } ?>

	<fieldset> 
	  <div>
		<?php if(isset($_GET['id'])) { 
		   
		$sql = "SELECT * FROM activity_codes WHERE active = 1 and budget_code = $line->code";
			$result = mysql_query($sql);
			
		   ?> 
		   <br><legend>Manage Associated Activity Codes: </legend> 

		                <table class="table table-striped table-bordered">
                            <thead>
                              <tr>
							    	<th>Activity Code</th>
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
                                
							  <td><a href="index.php?c=activitycde_detail&id=<?php echo  $rows['id'];?>&src=bdj"><?php echo $rows['code']; ?></a></td>
							  <td><?php echo $rows['description'];?></td>
							  <td><?php echo $rows['allocation'];?></td>
							  <td><?php echo $rows['status'];?></td>
							  <td><a href="index.php?c=activitycde_detail&id=<?php echo  $rows['id'];?>&src=bdj">[View]</a>
								  <a href="index.php?c=activity_code_edit&id=<?php echo $rows['id'];?>&src=bdj">[Edit]</a>
								  <a onclick="return confirm('Confirm you want to Permanently Deactivate This Activity Code?')" href="index.php?c=activity_code_edit&id=<?php echo $rows['id'];?>&op=D&src=prj">[Deactivate]</a></td>
							  </tr>
							                           							
							<?php 
							} ?> 
						</tbody>	
			</table>				  
		  <?php 
				$count2 = $db->countOf("activity_codes", "active = 1 and budget_code = $line->code");
				if ($count2 == 0) { ?>
				  
				 <br><center><font color=red>There Are No <strong>Activity Codes</strong> Associated With This Budget Code At This Time!! To add Activity Codes <strong><a href="index.php?c=activity_code_edit">click here</a></strong> otherwise add later via <strong><a href="index.php?c=activity_code_admin">Budget Adminstration</a></strong></font></center><br><br> 
		  
			<?php } } ?>

		 </div>						  		  
	 </fieldset>	  

		<tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
		     <td><a href="index.php?c=budget_code_admin" class="btn-small btn-color btn-pad">Exit</a></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
      
 
     </form>
	 
     <div align="justify"></div>
<div id="respond"></div>
    </div>