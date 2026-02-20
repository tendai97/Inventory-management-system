<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "Add New "; else echo "Update "; ?>Asset Type</legend>
      <?php 
	  $line="";
				if(!isset($_GET['id'])&& isset($_POST['name']))

            {
			
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$class=mysql_real_escape_string($_POST['class']);
			
			$count = $db->countOf("asset_type", "name='$name'");
		
		if($count==1)
			{
		echo "<font color=red> Asset type ($name) already Exists. Please Verify</font>";
			}
			else
			{
						
			$db->query("insert into asset_type values(NULL,'$code','$name','$description','$class', 'New - Awaiting Activation','A',NOW(),'".$_SESSION[SITE_NAME]['username']."',NULL,NULL,1)");

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
				
				$message= "Dear [Approving Admin Officer], \n \nThis is an automatic Asset Type Registration notification message sent on behalf of ".$line2->firstname.' '.$line2->surname." (Initiating Admin Officer) and requires your attention. To ACTIVATE or DECLINE this Registration log onto https://portal.wwf.org.zw/wwf_dev/login.php? and proceed to the WWF Central Administration module.  \n \n \nNB: You may not be the ONLY recipient of this email message therefore any of the other Approving Admin Officers may well attend this matter ahead of you. In such cases you need not take any further action. \n \nBest regards, \n \nWWF ESSC System Administrator";
					
					include 'core/mail_multi.php';
					
					//$zita=$line1->firstname.' '.$line1->surname;
					sendemail( $admin->firstname.' '.$admin->surname,$admail,$message,"ALERT: New Asset Type Registration - (".$name.") - Requires Attention");  
										
			echo "<br><font color=green size=+1 > Asset Type $name Added Successfully !</font>" ;
			
			}
			
			
			}
	////////////////////////////////Asset Type update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['name'])){
			
			$class=mysql_real_escape_string($_POST['class']);
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
					
						
					if($db->query("UPDATE asset_type  SET name='$name',description='$description',updTS=NOW(),class='$class',updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']))
					{echo "<br><font color=green size=+1 > Asset Type $name  Updated Successfully!</font>" ;
					$id=$_GET['id'];
					$line = $db->queryUniqueObject("SELECT * FROM asset_type WHERE id=$id");}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Asset Type!</font>" ;
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="A"){
					
					$db->query("UPDATE asset_type  SET alert_flag='N', status='Active' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=assert_type_admin&msg=Asset Type Activated Successfully!!";
					</script>
					<?php 
			}
			elseif (isset($_GET['id']) && $_GET['op']=="R"){
					
					$db->query("UPDATE asset_type set `status` = 'Declined', `alert_flag` = 'N', `active` = '0' where id=".$_GET['id']);				
						 
					$msg = "Activation of Asset Type Declined By Approving Admin Officer";			

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=asset_type_admin&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE asset_type  SET active='0' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=assert_type_admin&msg=Asset Type Successfully De-Activated!!";
					</script>
					<?php 
			}
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM asset_type WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       <table width="550"  border="0" cellspacing="0" cellpadding="0">
	   
	   <tr>
            <td width="100" height="48"><span style="color: blue;">Asset Class:</span></td>
			
		 <td width="800">
		
             <select name="class" id="category" class="form-control" required>
			 <option value="">Please select an Asset Class </option>
              <?php
			 $cost_centre=$db->query( "SELECT * FROM  asset_group where active=1 ORDER BY name");
			 while($row = mysql_fetch_array($cost_centre))

		{if($row['code']== $line->class)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
			

	
			</td>

         </tr>
	   
	    <tr>
           <td width="100" height="48"><span style="color: blue;">Type Code:</span></td>
           <td width="800"><?php if(isset($_GET['id'])){echo $line->code;}else{?><input name="code" type="text" id="code" placeholder="Enter Asset Type Code" maxlength="4" class="form-control" value="<?php echo $line->code; ?>" required/><?php }?></td> 
         </tr>
         
         <tr>
          <td width="100" height="48"><span style="color: blue;">Type Name:</span></td>
          <td width="800"><input name="name" type="text" id="name"  placeholder="Asset Type Name" class="form-control" value="<?php echo $line->name; ?>" required/></td>
           </tr>  
			
         <tr>
           <td width="100" height="48"><span style="color: blue;">Description:</span></td>
           <td width="800"><input name="description" type="text" id="description"  placeholder="Asset Type Description" class="form-control" value="<?php echo $line->description; ?>" required/></td>
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