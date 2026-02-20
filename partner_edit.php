<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="js/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">
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
      <br><legend><?php if(!isset($_GET['id'])) echo "Add "; elseif ($_GET['op']=="D") echo "De-Activate "; elseif ($_GET['op']=="R") echo "Decline Activation of "; else echo "Update "; ?>Partner or Supplier</legend>
	  <?php 
	  $line="";
	  
	        if(isset($_GET['id']))
				
				 {if(isset($_GET['op']) && $_GET['op']=="D" && isset($_POST['deactv_reason'])){
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);

					$sql="UPDATE supplier_partner  SET `deactv_reason` = '$deactv_reason', `activity_status` = 'Deactivation - Awaiting Approval', `alert_flag` = 'A', active='0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id'];
					$db->query($sql);	

			$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  
			$line3 = $db->queryUniqueObject("SELECT * FROM supplier_partner WHERE id = ".$_GET['id']);

			$sql="SELECT * FROM _user where active = 1 and fa = 1 and f_apro = 1"; 	
				$result = mysql_query($sql);
				$fadmail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$fadm_id = $row['personid'];	
					$fadmin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $fadm_id");
					$fadmail = "$fadmin->email, $fadmail";  }
				 //	echo $fadmail."<br>";  
				 // echo "Send Asset Return notification email to ".$fadmin->firstname.' '.$fadmin->surname." on address ".$fadmin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Approving Finance Officer], \n \nThis is an automatic Supplier/Partner De-Activation notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Finance Officer) and requires your attention. To APPROVE or DISAPPROVE this De-Activation log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Finance Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $fadmin->firstname.' '.$fadmin->surname,$fadmail,$message,"ALERT: Supplier/Partner De-Activation  - (".$line3->name.") - Requires Attention");  
										
					$msg = "Deactivation of Supplier / Partner Initiated - now awaiting confirmation by Approving Finance Officer";

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=partner_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

				elseif (isset($_GET['op']) && $_GET['op']=="R" && isset($_POST['deactv_reason'])){
					$deactv_reason=mysql_real_escape_string($_POST['deactv_reason']);
					
					$sql="UPDATE supplier_partner set `deactv_reason` = '$deactv_reason', `activity_status` = 'Declined', `alert_flag` = 'N', `active` = '0', updTS = NOW(), updU = '".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id'];
							$db->query($sql);	
						 
					$msg = "Activation of Supplier / Partner Declined By Approving Finance Officer";			

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=partner_admin&flag=D&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			
				elseif (isset($_GET['op']) && $_GET['op']=="A"){
					
					$sql="select * from supplier_partner where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
			
					$db->query("UPDATE supplier_partner  SET alert_flag='N', activity_status='Active', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id']);
											
					//echo "<br><font color=green size=+1 >  Supplier / Partner $name Activated Successfully !</font>" ;
					$msg = "Supplier / Partner Activated Successfully!!";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=partner_admin&flag=A&msg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			
				elseif (isset($_GET['op']) && $_GET['op']=="Rev") {
					
					$sql="UPDATE supplier_partner set `deactv_reason` = NULL, `activity_status` = 'Active', `alert_flag` = 'N', `active` = '1', updTS = NOW(), updU = '".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id'];
							$db->query($sql);	
						 
					$msg = "Deactivation of Supplier / Partner Declined - Supplier / Partner Restored To Original Active Status";			

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=partner_admin&flag=A&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}			
			
				elseif (isset($_GET['op']) && $_GET['op']=="Del") {
					
					$db->query("UPDATE supplier_partner SET alert_flag='N', active='0', activity_status='Deactivated', updTS = NOW(), updU = '".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id']);
					 
					$msg = "Deactivation of Supplier / Partner Approved And Now Complete";
			
					?>
					<script language="javascript" type="text/javascript">
						window.location = "index.php?c=partner_admin&flag=D&msg=<?php echo $msg; ?>";
					</script>
					<?php 
			}

			$sql="select * from supplier_partner where active = 1 and id = ".$_GET['id'];
			$line =  $db->queryUniqueObject($sql);
					
			////////////////////////////////supplier / partner update/////////////////////////////////
	
			if (isset($_GET['id'])&& isset($_POST['name'])){
				
				//var_dump($_POST);
	  
			$name=mysql_real_escape_string($_POST['name']);
			$description=mysql_real_escape_string($_POST['description']);
			$catergory=mysql_real_escape_string($_POST['catergory']);
			$activity_status=mysql_real_escape_string($_POST['activity_status']);
			$prefered_supplier=mysql_real_escape_string($_POST['prefered_supplier']);
			$sp_address=mysql_real_escape_string($_POST['sp_address']);
			$type=mysql_real_escape_string($_POST['type']);
			$code=mysql_real_escape_string($_POST['code']);
			$wwf_acc_no=mysql_real_escape_string($_POST['wwf_acc_no']);
			$sp_contact_no=mysql_real_escape_string($_POST['sp_contact_no']);
			$sp_contact_person=mysql_real_escape_string($_POST['sp_contact_person']);
			$email=mysql_real_escape_string($_POST['email']);
			$registration_date=mysql_real_escape_string($_POST['registration_date']);
			$perform_rate=mysql_real_escape_string($_POST['perform_rate']);
			$bank=mysql_real_escape_string($_POST['bank']);
			$bank_acc_name=mysql_real_escape_string($_POST['bank_acc_name']);
			$bank_acc_no=mysql_real_escape_string($_POST['bank_acc_no']);
			$branch=mysql_real_escape_string($_POST['branch']);
			$swift_code=mysql_real_escape_string($_POST['swift_code']);
			$insU=$_SESSION[SITE_NAME]['username'];
			
					if($db->query("UPDATE supplier_partner  SET `name` = '$name', `code` = '$code', `wwf_acc_no` = '$wwf_acc_no',`description` = '$description', `catergory` = '$catergory',`activity_status` = '$activity_status',`prefered_supplier` = '$prefered_supplier', `sp_address` = '$sp_address',`sp_contact_person` = '$sp_contact_person',`sp_contact_no` = '$sp_contact_no',`email` = '$email', `registration_date` = '$registration_date', `perform_rate` = '$perform_rate', `bank` = '$bank', `bank_acc_name` = '$bank_acc_name', `bank_acc_no` = '$bank_acc_no', `branch` = '$branch', `swift_code` = '$swift_code',`updU` = '$insU' ,`updTS` = NOW(), `type` = '$type'  where id=".$_GET['id']))
						
						{
							
			if ($_FILES['doc']['name'])
    				 {
						
						// remove previous one 
						unlink('upload/profile/doc'.$code.'.'.$line->doc);

define('filesDir','upload/profile/');				
$allowedExts = array("pdf", "doc", "jpg", "png");
$temp = explode(".", $_FILES["doc"]["name"]);
$extension = end($temp);
//echo $_FILES["image"]["size"];
//if ( in_array($extension, $allowedExts)) {
  if ($_FILES["doc"]["error"] > 0) {
    echo "Error: " . $_FILES["doc"]["error"] . "<br>";
  } else {
    
	$filesFileTempname=$_FILES["doc"]['tmp_name'];
	//echo $filesFileTempname;
	 move_uploaded_file($filesFileTempname,filesDir.'doc'.$code.'.'.$extension);
	 $sql = "UPDATE	supplier_partner	SET 	doc ='$extension'	WHERE 	id = ".$_GET['id'];
	 $db->query($sql);
  }
//}
    				}		
					
							echo "<br><font color=green size=+1 >  $name  (Supplier / Partner Details Updated Successfully!</font>" ;
						$id=$_GET['id'];
						$line = $db->queryUniqueObject("SELECT * FROM supplier_partner WHERE id=$id");}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Supplier / Partner Details!</font>" ;
					
			}
					
				 }

				 elseif(!isset($_GET['id'])&& isset($_POST['name']))

            {
	  //var_dump($_POST);
	  
			$name=mysql_real_escape_string($_POST['name']);
			$description=mysql_real_escape_string($_POST['description']);
			$catergory=mysql_real_escape_string($_POST['catergory']);
			$activity_status=mysql_real_escape_string($_POST['activity_status']);
			$prefered_supplier=mysql_real_escape_string($_POST['prefered_supplier']);
			$sp_address=mysql_real_escape_string($_POST['sp_address']);
			$type=mysql_real_escape_string($_POST['type']);
			$code=mysql_real_escape_string($_POST['code']);
			$wwf_acc_no=mysql_real_escape_string($_POST['wwf_acc_no']);
			$sp_contact_no=mysql_real_escape_string($_POST['sp_contact_no']);
			$sp_contact_person=mysql_real_escape_string($_POST['sp_contact_person']);
			$email=mysql_real_escape_string($_POST['email']);
			$registration_date=mysql_real_escape_string($_POST['registration_date']);
			$perform_rate=mysql_real_escape_string($_POST['perform_rate']);
			$bank=mysql_real_escape_string($_POST['bank']);
			$bank_acc_name=mysql_real_escape_string($_POST['bank_acc_name']);
			$branch=mysql_real_escape_string($_POST['branch']);
			$bank_acc_no=mysql_real_escape_string($_POST['bank_acc_no']);
			$swift_code=mysql_real_escape_string($_POST['swift_code']);
			$insU=$_SESSION[SITE_NAME]['username'];
			
							
			$count = $db->countOf("supplier_partner", "name='$name'");
			$count2 = $db->countOf("supplier_partner", "code='$code'");
	
		if($count > 0 || $count2 > 0)
			{
		echo "<font color=red>Supplier / Partner Record with same Name or Oracle Assigned Code already Exists on file - Please Verify</font>";
			}
			else
			{
				$sql="INSERT INTO `supplier_partner` 
	(`code`, `name`, `wwf_acc_no`,`description`, `catergory`,`activity_status`,`prefered_supplier`, `sp_contact_person`,`sp_contact_no`,`email`, `sp_address`,`registration_date`, `perform_rate`, `bank`, `bank_acc_name`, `branch`, `bank_acc_no`,`swift_code`,`insU`,`insTS`, `type`, `active`)
	VALUES
	('$code', '$name', '$wwf_acc_no', '$description', '$catergory', 'New - Awaiting Approval', '$prefered_supplier', '$sp_contact_person','$sp_contact_no','$email' , '$sp_address' , '$registration_date', '$perform_rate', '$bank', '$bank_acc_name', '$branch', '$bank_acc_no', '$swift_code', '$insU',NOW(), '$type', '1')";
			
			//echo $sql;			
			
			$db->query($sql);
			$supplier_partner=mysql_insert_id();

			$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = ".$_SESSION[SITE_NAME]['person']);  

			$sql="SELECT * FROM _user where active = 1 and fa = 1 and f_apro = 1"; 	
				$result = mysql_query($sql);
				$fadmail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$fadm_id = $row['personid'];	
					$fadmin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $fadm_id");
					$fadmail = "$fadmin->email, $fadmail";  }
				 //	echo $fadmail."<br>";  
				 // echo "Send Asset Return notification email to ".$fadmin->firstname.' '.$fadmin->surname." on address ".$fadmin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Approving Finance Officer], \n \nThis is an automatic Supplier/Partner Registration notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Finance Officer) and requires your attention. To ACTIVATE or DECLINE this Registration log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Finance Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $fadmin->firstname.' '.$fadmin->surname,$fadmail,$message,"ALERT: New Supplier/Partner Registration  - (".$name.") - Requires Attention");  
										
			echo "<br><font color=green size=+1 > Supplier / Partner $name Added - now awaiting confirmation by Approving Finance Officer!</font>" ;
			
			}
			
			
			}
	
							
				?>
     <form action="" method="post" enctype="multipart/form-data">
               
	 <fieldset>
	   
		<?php if (isset($_GET['op']) && ($_GET['op'] == "D" || $_GET['op'] == "R")) { ?>
	  
	   <table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	            
			<tr>
			  <td width="285" height="43"><span style="color: blue;">Name of Supplier or Partner:</span></td>
			  <td width="293"><?php echo $line->name; ?></td>
			 </tr>
			 <tr>
			   <td width="285" height="37"><span style="color: blue;">Description of Supplier / Partner:</span></td>
			   <td width="293"><?php echo $line->description; ?></td>
			 </tr>
			  <tr>
			   <td width="285" height="36"><span style="color: blue;">Supplier or Partner Classification:</span></td>
			   <td width="293"><?php if($line->type == "P" ) echo "Partner"; else echo "Supplier";?></td>
			 </tr>
			 <tr><td>&nbsp;</td></tr>
			 <?php if ($_GET['op'] == "D")  { ?> 
				 <tr>
				   <td width="285" height="45"><span style="color: blue;">Deactivation Reason:</span></td>
				   <td width="293"><textarea rows="2" cols="58" name="deactv_reason" placeholder="Enter FULL Reason for Deactivation" id="deactv_reason"  required/></textarea></td>
				 </tr>
			 <?php }  else  {  ?>
				 <tr>
				   <td width="285" height="45"><span style="color: blue;">Decline Activation Reason:</span></td>
				   <td width="293"><textarea rows="2" cols="58" name="deactv_reason" placeholder="Enter FULL Reason for Declining Activation" id="deactv_reason"  required/></textarea></td>
				 </tr>
			 <?php }  ?>
       </table>
		<?php }  else  {  ?>

      <legend>Static Information</legend> 
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
          <td width="185" height="48"><span style="color: blue;">Supplier or Partner Classification:</span></td>
			<td width="262"><select name="type" class="form-control" id="category" required>
			 <option value="">Select a Trading Type </option>
             <option value="P" <?php if($line->type == "P" ) echo "selected";?>>Partner </option>
			 <option value="S" <?php if($line->type == "S" ) echo "selected";?>>Supplier </option>
            </select></td>
         <br /></div>
        </fieldset>
     	 
	  <fieldset>
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
         <td width="185" height="48"><span style="color: blue;">Name of Supplier or Partner:</span></td>
		<td width="262"><input name="name" type="text" id="firstname" placeholder="Supplier / Partner Name"  class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->name; ?>" required/></td>
         <br />
		  <td width="185" height="48"><span style="color: blue;">Description of Supplier / Partner:</span></td>
	    <td width="262"><input name="description" type="text" id="sellingrate"  placeholder="Supplier / Partner Description" class="validate[optional,custom[onlyNumber],length[6,15]] form-control text-input" value="<?php echo $line->description; ?>" ></td>
         <br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	     
	     <td width="185" height="48"><span style="color: blue;">Category (Trade Line) of Supplier / Partner:</span></td>
		<!--input name="catergory" type="text" id="username" placeholder="Supplier / Partner Category"  class="validate[required,length[0,100]] form-control text-input" value="<!?php echo $line->catergory; ?>" required/>-->
		
		<td width="262"><select name="catergory" id="username"  class="form-control" required/>
			 <option value="">Select a Trade Line for the Supplier / Partner</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM parameters where type = 'trdlines' and active = 1 order by name");
		  	while($row = mysql_fetch_array($result))
			{if($row['code']== $line->catergory)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';} ?>
            </select></td>
         
		 <br />
          <td width="185" height="48"><span style="color: blue;">Oracle Assigned Code for Supplier / Partner:</span></td>
		<td width="262"><input name="code" type="text" id="surname" placeholder="Supplier / Partner Code"  class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->code; ?>" required/></td>
         
         <br /></div>
        </fieldset>
     	 
	  <fieldset>
      <legend>Contact Information</legend> 
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
           <td width="185" height="48"><span style="color: blue;">Contact Person for Supplier / Partner:</span></td>
		   <td width="262"><input name="sp_contact_person" type="text" id="sp_contact_person"  placeholder="Name of Supplier's / Partner's Contact Person" class="validate[required,length[0,100]] form-control  text-input" value="<?php echo $line->sp_contact_person; ?>" required/></td>
		   <br />
		   <td width="185" height="48"><span style="color: blue;">Email Address of Contact Person:</span></td>
		   <td width="262"><input name="email" type="text" id="username" placeholder="Supplier / Partner Email Address" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->email; ?>" required/></td>
          <br /><br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	      <td width="185" height="48"><span style="color: blue;">Telephone Number of Contact Person:</span></td>
		  <td width="262"><input name="sp_contact_no" type="text" id="username" placeholder="Supplier / Partner Contact No." class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->sp_contact_no; ?>" required/></td>
          <br />
		  <td width="185" height="48"><span style="color: blue;">Physical Address of Supplier / Partner:</span></td>
		  <td width="262"><input name="sp_address" type="text" id="sp_address" placeholder="Supplier / Partner Physical Address" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->sp_address; ?>" required/></td>
		  <br /></div>
        </fieldset>
     	  	 
	  <fieldset>
      <legend>Trading Information</legend> 
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
		 <td width="185" height="48"><span style="color: blue;">WWF Assigned Account No. for Supplier / Partner:</span></td>
		 <td width="262"><input name="wwf_acc_no" type="text" id="wwf_acc_no"  placeholder="WWF Account No. for Supplier / Partner" class="validate[required,length[0,100]] form-control  text-input" value="<?php echo $line->wwf_acc_no; ?>" required/></td>
       	 <br />
         <td width="185" height="48"><span style="color: blue;">Supplier / Partner Activity Status:</span></td>
		 <td width="262"><input name="activity_status" type="text" id="activity_status" placeholder="Skip (Leave Blank) - this field is readonly"  class="form-control text-input" value="<?php echo $line->activity_status; ?>" readonly/></td>
         <br />
		 
          <td width="185" height="48"><span style="color: blue;">Performance Rating of Supplier / Partner:</span></td>
		  <td width="262"><select name="perform_rate" class="form-control" id="category" required>
			 <option value="" <?php if($line->perform_rate == "" ) echo "selected";?>>Select A Perfomance Rating &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			 <option value="0" <?php if($line->perform_rate == "0" ) echo "selected";?>>Un-rated</option>
			 <option value="1" <?php if($line->perform_rate == "1" ) echo "selected";?>>Superior</option>
			 <option value="2" <?php if($line->perform_rate == "2" ) echo "selected";?>>Excellent</option>
			 <option value="3" <?php if($line->perform_rate == "3" ) echo "selected";?>>Above Average</option>
			 <option value="4" <?php if($line->perform_rate == "4" ) echo "selected";?>>Average</option>
			 <option value="5" <?php if($line->perform_rate == "5" ) echo "selected";?>>Below Average</option>
           
            </select></td>
         
		 <br /></div>
	  
	     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	      <td width="185" height="48"><span style="color: blue;">Date of Registration with WWF :</span></td>
		  <td width="262"><input name="registration_date" type="text" id="datepicker" placeholder="Date of Registration with WWF (DD/MM/YYY)" class="form-control datepicker"  value="<?php echo $line->registration_date; ?>" required/></td>
          <br />
		  <td width="185" height="48"><span style="color: blue;">Date of Last Perfomance Review :</span></td>
		  <td width="262"><input readonly name="review_date" type="text" id="review_date" placeholder="Date of Last Perfomance Review (Read Only)" class="form-control"  value="<?php if (isset($_GET['id'])&& $line->review_date <> "") echo $line->review_date; elseif (isset($_GET['id'])) echo "Not Previously Reviewed"; ?>"/></td>
          <br />
	      <td width="185" height="48"><span style="color: blue;">Preferred Supplier / Partner Indicator :</span></td>
		  <td width="262"><select name="prefered_supplier" class="form-control" id="prefered_supplier" required>
			 <option value="" <?php if($line->perform_rate == "" ) echo "selected";?>>Select A Prefered Partner/Supplier Flag &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			 <option value="0" <?php if($line->prefered_supplier == "0" ) echo "selected";?>>Not Preferred</option>
			 <option value="1" <?php if($line->prefered_supplier == "1" ) echo "selected";?>>Preferred</option>
			            
            </select></td> 
		  
         <br /><br /></div>
        </fieldset>
     	  	<br /> 
	  <fieldset>
      <legend>Banking Details</legend> 
	     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">          
		 <td width="185" height="48"><span style="color: blue;">Supplier or Partner's Bankers:</span></td>
		 <td width="262"><input name="bank" type="text" id="username" placeholder="Supplier / Partner Bankers (Name)" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->bank; ?>" required/></td>
         <br />
         <td width="185" height="48"><span style="color: blue;">Supplier / Partner Bank Account Name:</span></td>
		 <td width="262"><input name="bank_acc_name" type="text" id="bank_acc_name" placeholder="Supplier / Partner Bank Account Name" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->bank_acc_name; ?>" required/></td>
         <br />
	     <td width="185" height="48"><span style="color: blue;"><strong>Supplier / Partner Document Upload and Retrieval</strong></span></td><br/>
	     <td><?php if (isset($_GET['id']) && $line->activity_status=='Active') {
			if ($line->doc!='') { echo "<a href='upload/profile/doc$line->code.$line->doc' target='_blank'>Click To Retrieve Document</a> <br/>";}?>  
			<input name="doc" type="file" id="doc"  class="text-input"/></td> <?php } 
			else { ?>
		 <td width="185" height="48"><span style="color: red;"><strong>NOTE:-</strong> Uploading of Attachment Documents ONLY permitted AFTER Approval and Activation of Supplier/Partners</span></td>
		 <?php } ?>

         <br />
		 <br /></div>
	  
	     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
		 <td width="185" height="48"><span style="color: blue;">Branch at which Bank Account is held:</span></td>
		 <td width="262"><input name="branch" type="text" id="username" placeholder="Supplier / Partner Bank Branch" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->branch; ?>" required/></td>
         <br />		 
		 <td width="185" height="48"><span style="color: blue;">Bank Account No. for Supplier / Partner:</span></td>
		 <td width="262"><input name="bank_acc_no" type="text" id="bank_acc_no" placeholder="Supplier / Partner Bank Account No." class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->bank_acc_no; ?>" required/></td>
         <br />
		 <td width="185" height="48"><span style="color: blue;">Fund Transfer SWIFT Code:</span></td>
		 <td width="262"><input name="swift_code" type="text" id="username" placeholder="Supplier / Partner SWIFT Code" class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->swift_code; ?>" ></td>
	     </div></fieldset>
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