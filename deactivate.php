<div id="content">
      <br><legend>Asset Dectivation/Disposal Reason</legend>
      <?php 
	  //var_dump($_SESSION[SITE_NAME]);
	  $line="";
				if( isset($_POST['asset1']))

            {
			
	  $sql="select * from assets  WHERE active =1 and assert_no = '".$_GET['assert_no']."'";
			$line =  $db->queryUniqueObject($sql);

			$asset=mysql_real_escape_string($_POST['asset1']);
			$method=mysql_real_escape_string($_POST['method']);
			$reason=mysql_real_escape_string($_POST['reason']);
					
		 $sql="UPDATE `asset_allocation` SET  active=0  WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="	INSERT INTO `asset_allocation` 
	(`asset`,`asset_group`, `asset_type`,`event`,`allocate_status`,`narrative`,`insU`, `insTS`)	
	VALUES	( '".$_GET['assert_no']."','$line->asset_group','$line->asset_type','Deactivation','Asset Deactivated Permanently','$reason', '".$_SESSION[SITE_NAME]['username']."', NOW())";
		
			$db->query($sql);
			
		$sql="UPDATE `assets`  SET  alloc_status = 'Asset Deactivation - Awaiting Approval', alert_flag='A', `disposal_date` = NOW(),  d_method = '$reason' WHERE `assert_no` = '".$_GET['assert_no']."'";
			$db->query($sql);

			$line = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$_GET['assert_no']."'");
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
					//	echo "Send Asset De-Activation notification email on behalf of ".$line2->firstname.' '.$line2->surname." to ".$admin->firstname.' '.$admin->surname." on email address ".$admin->email."<br>" ; 

				// email setup
										
				$message= "Dear [Approving Admin Officer], \n \nThis is an automatic Asset De-Activation notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Admin Officer) and requires your attention. To APPROVE or DISAPPROVE this De-Activation log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
						
						include 'core/mail_multi.php';
						
						//$zita=$line1->firstname.' '.$line1->surname;
						sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"ALERT: Asset De-Activation - (".$line->assert_no.") - Requires Attention");  															
			$msg="Your proposed Deactivation of this Asset has been Recorded but will ONLY become Effective upon Approval!!" ;

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=assert_admin&cmsg=<?php echo $msg;?>";
					</script>
					<?php   
			}
				
		$asset = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$_GET['assert_no']."'");
				
				?>
				
				
     <form action="" method="post">
       <table width="300"  border="0" cellspacing="0" cellpadding="0">
	   
	    <input type="text" id="asset"  class="form-control" value="<?php  echo $asset->assert_no.':-   '.$asset->asset_description; ?>" readonly/>
		  <input name="asset1" type="hidden" id="asset1"  <?php if (isset($_GET['assert_no'])) echo "value='".$_GET['assert_no']."'"?> />
		  <br />
		  <textarea rows="2" cols="70" name="reason" class="form-control"  placeholder="Enter Full Reason for Deactivation or Disposal" id="reason"  required/><?php echo $line->d_method ;?></textarea>
         </tr> 
            
        </table>
       <br />
      
      <p>
        <?php if ($line->alloc_status == 'Asset Deactivation - Awaiting Approval') { ?>
			<td><a href="index.php?c=assert_admin" class="btn-small btn-color btn-pad">Exit</a><br>
		<?php } else { ?>
			<input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />		
		<?php } ?>
      </p>
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>