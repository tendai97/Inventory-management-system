<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "Add New "; else echo "Update "; ?>Asset Class</legend>
      <?php 
	  $line="";
				if(!isset($_GET['id'])&& isset($_POST['name']))

            {
			

			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			//$region=mysql_real_escape_string($_POST['region']);
			
			$count = $db->countOf("asset_group", "name='$name'");
			$count2 = $db->countOf("asset_group", "code='$code'");
		
		if($count > 0 || $count2 > 0)
			{
		echo "<font color=red> Asset Group ($name) already Exists. Please Verify</font>";
			}
			else
			{
						
			$db->query("insert into asset_group values(NULL, '$code', '$name', '$description', 'New - Awaiting Activation', 'A', NOW(), '".$_SESSION[SITE_NAME]['username']."', NULL, NULL, 1)");

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
				 // echo "Send Asset Return notification email to ".$admin->firstname.' '.$admin->surname." on address ".$admin->email."<br>" ; 

					// email setup
				
				$message= "Dear [Approving Admin Officer], \n \nThis is an automatic Asset Class Registration notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Admin Officer) and requires your attention. To ACTIVATE or DECLINE this Registration log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"ALERT: New Asset Class Registration - (".$name.") - Requires Attention");  
										
			echo "<br><font color=green size=+1 > Asset Class $name  Added Successfully !</font>" ;
			
			}
			
			
			}
	////////////////////////////////Asset Group update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['name'])){
			
					
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			//$region=mysql_real_escape_string($_POST['region']);		
						
					if($db->query("UPDATE asset_group  SET name='$name',description='$description',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']))
					{echo "<br><font color=green size=+1 >  $name   Updated!</font>" ;
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM asset_group WHERE id=$id");
				
				}
					else
					echo "<br><font color=red size=+1 >Problem in Updating !</font>" ;
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="A"){
					
					$db->query("UPDATE asset_group  SET alert_flag='N', status='Active' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=asset_group_admin&msg=Asset Class Activated Successfully!!";
					</script>
					<?php 
			}
			elseif (isset($_GET['id']) && $_GET['op']=="R"){
					
					$db->query("UPDATE asset_group set `status` = 'Declined', `alert_flag` = 'N', `active` = '0' where id=".$_GET['id']);				
						 
					$msg = "Activation of Asset Group Declined By Approving Admin Officer";			

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=asset_group_admin&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE asset_group  SET active='0' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=asset_group_admin&cmsg=Asset Class Successfully De-Activated!!";
					</script>
					<?php 
			}
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM asset_group WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       <table width="550"  border="0" cellspacing="0" cellpadding="0">
	   
	    <tr>
           <td width="100" height="50"><span style="color: blue;">Class Code:</span></td>
           <td width="800"><?php if(isset($_GET['id'])){echo $line->code;}else{?><input name="code" type="text" id="code" placeholder="Enter Asset Class Code" maxlength="4" class="form-control" value="<?php echo $line->code; ?>" required/><?php }?></td> 
         </tr>
         
         <tr>
		 <td width="100" height="50"><span style="color: blue;">Class Name:</span></td>
          <td width="800"><input name="name" type="text" id="name"  placeholder="Asset Class Name" class="form-control" value="<?php echo $line->name; ?>" required/></td>
           </tr>  
		  
         <tr>
           <td width="100" height="50"><span style="color: blue;">Description:</span></td>
           <td width="800"><input name="description" type="text" id="description"  placeholder="Asset Class Description" class="form-control" value="<?php echo $line->description; ?>" required/></td>
         </tr>

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