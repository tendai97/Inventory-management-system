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
	  <br><legend><?php if(!isset($_GET['id'])) echo "ADD NEW "; else echo "UPDATE "; ?>ACTIVITY CODE</legend>
      <?php }
	  $line = "";
	  $insUs = $_SESSION[SITE_NAME]['username'];
	  
	       if(isset($_GET['id']))
			{
				$sql="select * from activity_codes where id = ".$_GET['id'];
				$line =  $db->queryUniqueObject($sql);
					
				if(isset($_GET['op']) && $_GET['op'] == "D" && isset($_POST['deactv_trigger']))
					{
					$deactv_trigger=mysql_real_escape_string($_POST['deactv_trigger']);
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
						
					$sql="UPDATE activity_codes set `deactv_trigger` = '$deactv_trigger', `deactv_reason` = '$deactv_reason', `status` = 'Deactivated', `alert_flag` = 'N', active='0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id = ".$_GET['id'];
					 $db->query($sql);	
					 
					$msg = "Deactivation of Activity Code Completed";
			
					 ?>
					 <script language="javascript" type="text/javascript">
						window.location = "index.php?c=activity_code_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
				<?php 
					}
	  
				elseif (isset($_GET['id']) && $_GET['op']=="Rev" && isset($_POST['deactv_trigger'])){
					
					$deactv_trigger=mysql_real_escape_string($_POST['deactv_trigger']);
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
						
					$line = $db->queryUniqueObject("SELECT * FROM activity_codes WHERE id = ".$_GET['id']);
					
					$sql="UPDATE activity_codes set `deactv_trigger` = '$deactv_trigger', `deactv_reason` = '$deactv_reason', `status` = 'Activation Declined', `alert_flag` = 'N', `active` = '0', updTS = NOW(), updU = '$insUs' where id = ".$_GET['id'];
							$db->query($sql);	
						 
						$msg = "Activation of Activity Code Declined - Activity Code Assigned A Deactivated Status"; 
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=activity_code_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			elseif(isset($_GET['id']) && $_GET['op']=="A"){
			
					$db->query("UPDATE activity_codes  SET active = '1', status = 'Active', alert_flag = 'N', deactv_trigger = NULL, deactv_reason = NULL, updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
						
					echo "<br><font color=green size=+1 >  Activity Code $line->code Activated Successfully !</font>" ;
					 
					$line = $db->queryUniqueObject("SELECT * FROM activity_codes WHERE id = ".$_GET['id']);
					
			}
					
	  		elseif (isset($_GET['id'])&& isset($_POST['description'])){
				 
			$budget_code=mysql_real_escape_string($_POST['budget_code']);
			$description=mysql_real_escape_string($_POST['description']);
			$allocation=mysql_real_escape_string($_POST['allocation']);
			$alloc_date=mysql_real_escape_string($_POST['alloc_date']);
			
			$budget = $db->queryUniqueObject("SELECT * FROM budget_codes WHERE code = $budget_code");
			//$project = $db->queryUniqueObject("SELECT * FROM projects WHERE code = $budget->project_code");			
					 
			if($db->query("UPDATE `activity_codes`
SET 
  
	description = '$description',
	allocation = '$allocation',
	alloc_date = '$alloc_date',
	project_code = '$budget->project_code',
	budget_code = '$budget_code',
	updTS=NOW(),
	updU='".$_SESSION[SITE_NAME]['username']."' 
	where id=".$_GET['id']))


						{echo "<br><font color=green size=+1 > Activity Code $line->code Has Been Updated Successfully!</font>" ;
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM activity_codes WHERE id=$id");
				
				}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Activity Code!</font>" ;
					
					}
	  
					 }
	  	  
				elseif(!isset($_GET['id'])&& isset($_POST['description']))

            {
			
			$code=mysql_real_escape_string($_POST['code']);
			$budget_code=mysql_real_escape_string($_POST['budget_code']);
			$description=mysql_real_escape_string($_POST['description']);
			$allocation=mysql_real_escape_string($_POST['allocation']);
			$alloc_date=mysql_real_escape_string($_POST['alloc_date']);
			
			$budget = $db->queryUniqueObject("SELECT * FROM budget_codes WHERE code = $budget_code");

			$count = $db->countOf("activity_codes", "code = '$code'");
		
		if($count > 0)
			{
		echo "<font color=red> Activity Code $code already Exists. Please Verify</font>";
			}
			else
			{
					$sql="INSERT INTO `activity_codes` 	
					(`code`, `project_code`, `budget_code`, `description`, `allocation`, `alloc_date`, `status`, `alert_flag`, `insTS`, `insU`)
	VALUES
	( 
	'$code',
	'$budget->project_code',
	'$budget_code',
	'$description',
	'$allocation',
	'$alloc_date',
	'New - Awaiting Activation', 
	'A',
	NOW(),
	'".$_SESSION[SITE_NAME]['username']."'
	)";
	
			$db->query($sql);
            $activity = mysql_insert_id();
			
			echo "<br><font color=green size=+1 >  Activity Code $code Added Successfully !</font>" ;
						
			}
			
			
			}
			
				
				?>
     <form action="" method="post" enctype="multipart/form-data">

		<?php if (isset($_GET['op']) && ($_GET['op'] == "D" || $_GET['op'] == "Rev")) { ?>
			 <br>
			 <fieldset>
			  <legend>Activity Code Deactivation</legend> 
			  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
				<td width="185" height="48"><span style="color: blue;">Activity Code:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				<td width="262"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>   [Readonly]" readonly/>
				<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Activity Code" required/>
				<?php   }  ?> </td>

			  <br />
			  
			   <td width="185" height="42"><span style="color: blue;">Deactivation/Decline Trigger:</span></td>
			   <td width="393"><select id="deactv_trigger" name="deactv_trigger" class="form-control"  required>
			   <option  value=""  >Please select a Trigger for Deactivation or Decline</option>
			   <option  value="Terminated">Activity Code Termination/Closure</option>
			   <option  value="Declined">Declined Activity Code Activation</option>
			   <option  value="Deactivated">Other Deactivation Reason</option>
			   </select></td>

			   <br />

			   </div>

			  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
			 
			   <td width="185" height="48"><span style="color: blue;">Description of Activity Code:</span></td>
			  <td width="262"><input name="description" type="text" id="description" placeholder="Description of Activity Code"  class="form-control" value="<?php echo $line->description; ?>" /></td>
				 
			  <br />  
			 
			   <td width="185" height="45"><span style="color: blue;">Reason for Deactivation or Activation Decline:</span></td>
			   <td width="393"><textarea rows="2" cols="53" name="deactv_reason" placeholder="Enter FULL Reason for Deactivation or Declining" id="deactv_reason"  required/></textarea></td>
			 <br />
			 </div>
	
		</fieldset>
			 
		<?php }  else  {  ?>
	 
	 <fieldset>
      <legend>Activity Code Statics And Financials</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	    <td width="185" height="48"><span style="color: blue;">Activity Code:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<td width="262"><?php if (isset($_GET['id'])){ ?> <input name="code" type="text" class="form-control" value="<?php echo $line->code; ?>   [Readonly]" readonly/>
		<?php } else { ?> <input name="code" type="text" class="form-control" id="code" placeholder="Enter Activity Code" required/>
 		<?php   }  ?> </td>

	  <br />
	  
       <td width="185" height="48"><span style="color: blue;">Description of Activity Code:</span></td>
	  <td width="262"><input name="description" type="text" id="description" placeholder="Description of Activity Code"  class="form-control" value="<?php echo $line->description; ?>" /></td>
         
      <br />  
	  
      <td width="185" height="48"><span style="color: blue;">Original Allocation in $s:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	      <td width="262"><input name="allocation"  type="text" id="allocation"  placeholder="Amount originally awarded to Activity Code"  class="form-control" value="<?php echo $line->allocation; ?>"/>
	  </td>
         <br />
		 
       <?php if (isset($_GET['id'])){ ?>
		   <td width="185" height="48"><span style="color: blue;">Balance of Allocation in $s:</span></td>
		   <td width="262"><input name="alloc_balance" type="text" class="form-control" value="<?php echo $line->alloc_balance; ?>   [Readonly]" readonly/></td>
		   <br />  
		<?php   }  ?>

	 </div>

	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

	  <td width="185" height="48"><span style="color: blue;">Project Code & Name:</span></td>
       <?php if (!isset($_GET['id'])){ ?>
		  <td width="262"><input name="project_name" type="text" class="form-control"  placeholder="Name of Project will be based on Budget Code   [Readonly]"  readonly/></td>
		<?php   }  else  { ?>
		  <td width="262"><input name="project_name" type="text" class="form-control"   value="<?php $temp = $line->project_code;
					$sql="SELECT * FROM  projects where code = '$temp' and active = 1";
					$line2 = $db->queryUniqueObject($sql);
					echo $temp.' - '.$line2->name;  ?>   [Readonly]" readonly/></td>
		<?php   }  ?>

		<br />  

       <td width="185" height="48"><span style="color: blue;">Budget Code & Description:</span></td>
       <td width="262"><select name="budget_code" id="budget_code"  class="form-control" required>
			 <option value="">Please select the Budget Code and Description</option>
              <?php
			 $budj=$db->query( "SELECT * FROM  budget_codes where active = 1 ORDER BY project_code, description");
			 while($row = mysql_fetch_array($budj))

		{if($row['code']== $line->budget_code)
			echo ' <option value="'.$row['code'].'" selected>'.$row['code'].' - '.$row['description'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['code'].' - '.$row['description'].'</option>';
			}
              ?>
            </select>
			
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

	<br />
     	 
		<?php } ?>

		<tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
		     <td><a href="index.php?c=activity_code_admin" class="btn-small btn-color btn-pad">Exit</a></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
      
 
     </form>
	 
     <div align="justify"></div>
<div id="respond"></div>
    </div>