
      <?php 
	  
	  
	  $sql="select * from asset_allocation  WHERE active =1 and asset = '".$_GET['assert_no']."'";
			$line =  $db->queryUniqueObject($sql);
	  $msg="";
	 // var_dump($line); 
	   if($_GET['op']=='Dis'){
		 
			$sql="UPDATE `assets` SET  alloc_status = 'Awaiting Allocation', alert_flag='N', d_method = NULL, custodian = NULL WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="UPDATE `asset_allocation` SET  active=0  WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg=" Deactivation of Asset Denied now Awaiting Re-Allocation!" ;
	 }
	 if($_GET['op']=='Apr'){
		 
			$sql="UPDATE `assets` SET  alloc_status = 'Asset Deactivated / Disposed', alert_flag='N', active=0  , custodian = NULL WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="UPDATE `vehicle_master` SET  alert_flag = 'N', active = 0 WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg=" Deactivation / Disposal of Asset now Completed Successfuly!" ;
	 }
	 if($_GET['op']=='C'){
		 
		 $sql="UPDATE `asset_allocation` SET  active=0  WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="	INSERT INTO `asset_allocation` 
	(`asset`,`custodian`, `asset_group`, `asset_type`,`event`,`allocate_status`,`project`,`dept`,`narrative`,`insU`, `insTS`)	
	VALUES	( '".$_GET['assert_no']."',	NULL,'$line->asset_group','$line->asset_type','Return','Asset Returned - Awaiting Allocation','$line->alloc_project','$line->alloc_dept', '$line->narrative', '".$_SESSION[SITE_NAME]['personid']."', NOW())";
		
			$db->query($sql);
			
			$sql="UPDATE `assets` SET  alloc_status = 'Awaiting Allocation', alert_flag='N', custodian = NULL WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg=" Asset Returned successfully now Awaiting Re-Allocation!" ;
	 }
	 if($_GET['op']=='R'){
		 
			$line = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$_GET['assert_no']."'");
			$cust = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $line->custodian");  

			$sql="SELECT * FROM _user where active = 1 and ao = 1 and a_apro = 1"; 	
				$result = mysql_query($sql);
				$admail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$adm_id = $row['personid'];	
					$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $adm_id");
					$admail = "$admin->email, $admail";  }
				//	echo $admail."<br>";  
				//  echo "Send Asset Return notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Admin Officer], \n \nThis is an automatic Asset Return notification message sent on behalf of ".$cust->firstname.' '.$cust->surname." (Current Custodian) and requires your attention. To ACCEPT or REJECT this Asset Return log onto https://portal.wwf.org.zw/wwf_dev/landing_page.php? and proceed to the Asset Tracking & Management module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"Asset Return Alert on behalf of Current Custodian - (".$line->assert_no.")");  
									
		 $sql="UPDATE `assets` SET  alloc_status = 'Asset Return - Awaiting Confirmation', alert_flag='S' WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg=" Your Returned Asset Requires Confirmation to become Effective!!" ;
	 }
	 if($_GET['op']=='Rej'){
		 
		$reason = $_GET['rea'];
		$assert_no = $_GET['assert_no'];
		$line = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$_GET['assert_no']."'");
		$cust = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $line->custodian");  
		$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE id = ".$_SESSION[SITE_NAME]['person']);
		
		// email setup
		
		$message= "Dear ".$cust->firstname.' '.$cust->surname.", \n \nPlease be advised that your proposed return of Asset # ".$assert_no." (".$line->asset_description.") has been rejected for the reason given below . Please login to accept the Asset back to your custody:- \n\n ".$reason."  \n \nYours Sincerely, \n \n ".$admin->firstname.' '.$admin->surname."";
			
			include 'core/mail.php';
			
			$zita=$cust->firstname.' '.$cust->surname;
			sendemail( $cust->firstname.' '.$cust->surname,$cust->email,$message,"Rejection Notice of Asset Return - (".$assert_no.")");	
			
		 $sql="UPDATE `assets`  SET alert_flag='E', alloc_status='Allocated - Awaiting Custodian Acceptance' WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg="Proposed Asset Return has been Rejected - Asset reverts to Custodian!!" ;
	 }
	 if($_GET['op']=='A'){
		 
		 $sql="UPDATE `asset_allocation` SET  active=0 WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="select * from assets  WHERE active =1 and assert_no = '".$_GET['assert_no']."'";
			$line2 =  $db->queryUniqueObject($sql);
			
		 $sql="	INSERT INTO `asset_allocation` 
	(`asset`,`custodian`, `asset_group`, `asset_type`,`event`,`allocate_status`,`project`,`dept`,`narrative`,`insU`, `insTS`,alloc_no)	
	VALUES	( '".$_GET['assert_no']."',	'$line2->custodian','$line2->asset_group','$line2->asset_type','Allocated','Asset Allocated','$line2->alloc_project','$line2->alloc_dept', '$narrative', '".$_SESSION[SITE_NAME]['personid']."', NOW(),'$line->alloc_no')";
		
			$db->query($sql);
			
			
			$sql="UPDATE `assets` SET  alloc_status = 'Allocated' ,alert_flag='N'  WHERE	assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$msg="Asset has been Allocated to you successfully !" ;
			
	 }
	  if($_GET['op']=='D'){

		$reason = $_GET['rea'];
		$assert_no = $_GET['assert_no'];
		$line = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$_GET['assert_no']."'");
		$cust = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $line->custodian");  
	  
		   $sql="UPDATE `asset_allocation` SET  active=0 WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
		   $sql="	INSERT INTO `asset_allocation` 
	(`asset`,`custodian`, `asset_group`, `asset_type`,`event`,`allocate_status`,`project`,`dept`,`narrative`,`insU`, `insTS`)	
	VALUES	( '".$_GET['assert_no']."',	NULL,'$line->asset_group','$line->asset_type','Reject','Allocation Declined - Awaiting Confirmation','$line->project','$line->dept', '$narrative', '".$_SESSION[SITE_NAME]['personid']."', NOW())";
		
			$db->query($sql);
			
			$sql="UPDATE `assets` SET  alloc_status = 'Allocation Declined - Awaiting Confirmation', alert_flag='S' WHERE  assert_no = '".$_GET['assert_no']."'";
			$db->query($sql);
		 
			$sql="SELECT * FROM _user where active = 1 and ao = 1 and personid <> $cust->id"; 	
				$result = mysql_query($sql);
				$admail = "";
				
					while($row = mysql_fetch_array($result))
				{ 
					$adm_id = $row['personid'];	
					$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id = $adm_id");
					$admail = "$admin->email, $admail";  }
				//	echo $admail."<br>";  
				//  echo "Rejection of Asset Allocation - notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Admin Officer], \n \nThis is an automatic notification message from the system advising that ".$cust->firstname.' '.$cust->surname." has Declined the allocation of Asset No. ".$assert_no." for the reason given below:- \n \n ".$reason." \n \nTo acknowledge this notification and release the Asset for reallocation log onto https://portal.wwf.org.zw/wwf_dev/landing_page.php? and proceed to the Asset Tracking & Management module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"Decline of Asset Allocation by ".$cust->firstname.' '.$cust->surname." - (".$assert_no.")");  
									
			$msg=" You have Declined Asset Allocation successfully !" ;
	 }
				
	  if($_GET['srce']=='cad'){
				?>
				<script language="javascript" type="text/javascript">
window.location = "index.php?c=assert_admin&cmsg=<?php echo $msg;?>&id=<?php echo $_GET['assert_no'];?>";
</script>
				<?php } elseif ($_GET['srce']=='ast') { ?>
				<script language="javascript" type="text/javascript">
window.location = "index.php?c=asset&cmsg=<?php echo $msg;?>&id=<?php echo $_GET['assert_no'];?>";
</script>  
				<?php } else { ?>
				<script language="javascript" type="text/javascript">
window.location = "index.php?c=admin_asset&cmsg=<?php echo $msg;?>&id=<?php echo $_GET['assert_no'];?>";
</script>  
				<?php } ?>
  