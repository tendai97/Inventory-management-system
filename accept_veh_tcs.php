<html> 
      <!-- Library CSS -->
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/bootstrap-theme.css">
      <link rel="stylesheet" href="css/fonts/font-awesome/css/font-awesome.css">
      <link rel="stylesheet" href="css/animations.css" media="screen">
      <link rel="stylesheet" href="css/superfish.css" media="screen">
      <link rel="stylesheet" href="css/prettyPhoto.css" media="screen">
      <!-- Theme CSS -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Skin -->
      <link rel="stylesheet" href="css/colors/blue.css" class="colors">
<head>  
<script type="text/javascript">
function CheckColors(val){
 var element=document.getElementById('color');
 if(val=='pick a color'||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script> 
<script type='text/javascript'>
window.onunload = function(){
window.opener.location.reload();
window.close('','_self');return true;}
</script>
</head>  

 <p><br/></p>
      <legend>Acceptance of Terms and Conditions of WWF Fleet Vehicle use</legend>  
		<br/>
  <?php
		include_once "core/db.php"; 
		
		$id = $_GET['id'];
		
		if (isset($_POST['choice']) && ($_POST['choice'] == "Y")) {
			
				$sql="UPDATE  `vehicle_requests` SET `alert_flag` = 'N', `request_status` = 'Approved' WHERE `id` = '$id'";
						$db->query($sql); 
						
				$line = $db->queryUniqueObject("select * from vehicle_requests where  id = $id");
				$line2 = $db->queryUniqueObject("select * from _user where  personid = $line->employee");
				
				$sql=" INSERT INTO `vehicle_trans` 	( `request_id`, `reg_no`, `action`,	`reason`, `insU`, `insTS`)
					VALUES
					( '$id', '$line->reg_no', 'Accept', 'Acceptance of Direct Allocated Vehicle', '$line2->username', NOW())";
						$db->query($sql); }

		elseif (isset($_POST['choice']) && ($_POST['choice'] == "N")) { 
			
				$sql="UPDATE  `vehicle_requests` SET `alert_flag` = 'S', `request_status` = 'User Declined', status_reason = 'User Did Not Accept WWF Vehicle Usage Terms & Conditions' WHERE `id` = '$id'";
						$db->query($sql); 
						
			$line = $db->queryUniqueObject("select * from vehicle_requests where  id = $id");
			$line2 = $db->queryUniqueObject("select * from _user where  personid = $line->employee");
			$line4 = $db->queryUniqueObject("SELECT * FROM vehicle_master WHERE active = 1 and reg_no = '$line->reg_no'");
			
			if ($line4->alloc_rqst_id == $id) {
				$count = $db->countOf("vehicle_requests","reg_no = '$line->reg_no' and (request_status = 'Approved' or request_status = 'Trip Details Mismatch' or request_status = 'Accepted' or request_status = 'Direct Assignment')");
				if ($count == 0) {
					$sql="update vehicle_master set alloc_status = 'Available', alloc_rqst_id = '0', alloc_emp = '0', date_nxt_bkd = NULL, time_nxt_bkd = NULL, updU = '$updU', updTS = NOW() WHERE reg_no = '$line->reg_no'";
						$db->query($sql); }
				else { 
					$sql="SELECT * FROM vehicle_requests where reg_no = '$line->reg_no' and id <> '$id' and (request_status = 'Approved' or request_status = 'Trip Details Mismatch' or request_status = 'Accepted' or request_status = 'Direct Assignment')"; 	
						$result = mysql_query($sql);
						$erly_bkngtym = '9999-99-99-99:99:99';
								while($row = mysql_fetch_array($result))
							{ 
								$new_id = $row['id']; $new_bkdate = $row['date_bkd_frm']; $new_bktime = $row['est_time_out']; $new_bkngtym = $new_bkdate."-".$new_bktime;  
								if ( $new_bkngtym < $erly_bkngtym ) { $erly_bkngtym = $new_bkngtym; $erly_id = $new_id; } }	

								$earliest = $db->queryUniqueObject("SELECT * FROM vehicle_requests WHERE id = '$erly_id'");
								$sql="update vehicle_master set alloc_status = 'Booked', alloc_rqst_id = '$erly_id', alloc_emp = '$earliest->employee', date_nxt_bkd = '$earliest->date_bkd_frm', time_nxt_bkd = '$earliest->est_time_out', updU = '$updU', updTS = NOW() WHERE reg_no = '$earliest->reg_no'";
										$db->query($sql); } }

				$sql=" INSERT INTO `vehicle_trans` 	( `request_id`, `reg_no`, `action`,	`reason`, `insU`, `insTS`)
					VALUES
					( '$id', '$line->reg_no', 'Decline', 'User Declined WWF Vehicle Usage Terms & Conditions', '$line2->username', NOW())";
						$db->query($sql); 
		 
			$emp = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $line->employee");  

			$sql="SELECT * FROM _user where active = 1 and ao = 1 personid <> $emp->id"; 	
				$result = mysql_query($sql);
				$admail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$adm_id = $row['personid'];	
					$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $adm_id");
					$admail = "$admin->email, $admail";  }
				//	echo $admail."<br>";  
				//  echo "Send T&Cs Rejection for Direct Vehicle Assignment - notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Admin Officer], \n \nThis is an automatic notification message from the system advising that ".$emp->firstname.' '.$emp->surname." had been Directly Assigned Fleet Vehicle Registration No. ".$line->reg_no." but opted to DECLINE the WWF Vehicle Usage Terms and Conditions and will not be using the Vehicle. To acknowledge this notification and release the Vehicle log onto https://portal.wwf.org.zw/wwf_dev/landing_page.php? and proceed to the Vehicle Logging and Management module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"Rejection of WWF Vehicle Usage T&Cs on Direct Vehicle Assignment - (".$line->reg_no.")");  
									
						}  ?>
						 
	<form action="" method="post">
      <fieldset>
	   <input name="ini" type="hidden"  value="S"/>
	  
		<div>
			<input   type="text" class="form-control"  placeholder="By Choosing I ACCEPT Below You Are Agreeing To The Terms And Conditions Of Allocation And Usage Of WWF Vehicles" readonly/><br/><br/>
			<tr>
			   <td width="486"><font color = "purple">**** To View A Copy Of The Terms & Conditions Document click <a href="Vehicle Use Policy WWF Zimbabwe.pdf" target="_blank"><font color = "blue"><strong>"here"</strong></font></a> (Remember To Select An Option Below Thereafter) **** </font></td>
			</tr>

		</div>
	  </fieldset>
	 
      <br />
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<input type="radio" name="choice" id="choice" value="Y">&nbsp;&nbsp;&nbsp;&nbsp;I ACCEPT<br />  
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<input type="radio" name="choice" id="choice"  value="N">&nbsp;&nbsp;&nbsp;&nbsp;I DO NOT Accept 
		    </tr>
	  <p>&nbsp;</p>
			<tr>
			   <td><font color = "red">&nbsp;&nbsp;&nbsp;NOTE:- Clicking <strong>Submit</strong> Without Selecting Either Option Above Returns You To <strong>"Your Pending Fleet Vehicle Requests"</strong></font></td>
			</tr>
	  <p>
		<input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
      </p>
    </form>