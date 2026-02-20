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
      <legend><?php if(!isset($_GET['id'])) echo "ADD A "; else echo "UPDATE "; ?>PARTNER or SUPPLIER</legend>
	  <?php 
	  $line="";
	  
	        if(isset($_GET['id']))
				
				 {if(isset($_GET['op']) && $_GET['op']=="D"){
					$sql="UPDATE supplier_partner  SET active='0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id'];
					$db->query($sql);	
					
					echo "<br><font color=green size=+1 >  Supplier / Partner $name De-Activated Successfully !</font>" ;

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=partner_admin";
					</script>
					<?php 
			}
			
					$sql="select * from supplier_partner where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
			
			if(isset($_GET['id']) && $_GET['op']=="A"){
					
					$sql="select * from supplier_partner where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
			
					$db->query("UPDATE supplier_partner  SET alert_flag='N', activity_status='Active', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."'  where id=".$_GET['id']);
											
					echo "<br><font color=green size=+1 >  Supplier / Partner $name Activated Successfully !</font>" ;
					
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
			$acc_no=mysql_real_escape_string($_POST['acc_no']);
			$sp_contact_no=mysql_real_escape_string($_POST['sp_contact_no']);
			$sp_contact_person=mysql_real_escape_string($_POST['sp_contact_person']);
			$email=mysql_real_escape_string($_POST['email']);
			$registration_date=mysql_real_escape_string($_POST['registration_date']);
			$perform_rate=mysql_real_escape_string($_POST['perform_rate']);
			$bank=mysql_real_escape_string($_POST['bank']);
			$bank_acc_name=mysql_real_escape_string($_POST['bank_acc_name']);
			$branch=mysql_real_escape_string($_POST['branch']);
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
			
			echo "<br><font color=green size=+1 > Supplier / Partner $name Added Successfully !</font>" ;
			
			}
			
			
			}
	
							
				?>
     <form action="" method="post" enctype="multipart/form-data">
               
	 <fieldset>
	   
      <legend>Static Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
          <td width="185" height="48"><span style="color: blue;">Supplier or Partner Classification:</span></td>
			<td width="262"><select name="type" id="category" required>
			 <option value="">Select a Trading Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
             <option value="P" <?php if($line->type == "P" ) echo "selected";?>>Partner </option>
			 <option value="S" <?php if($line->type == "S" ) echo "selected";?>>Supplier </option>
            </select></td>
         <br /><br />
         <td width="185" height="48"><span style="color: blue;">Name of Supplier or Partner:</span></td>
		<td width="262"><input name="name" type="text" id="firstname" placeholder="Supplier / Partner Name"  class="validate[required,length[0,100]] form-control text-input" value="<?php echo $line->name; ?>" required/></td>
         <br />
		  <td width="185" height="48"><span style="color: blue;">Description of Supplier / Partner:</span></td>
	    <td width="262"><input name="description" type="text" id="sellingrate"  placeholder="Supplier / Partner Description" class="validate[optional,custom[onlyNumber],length[6,15]] form-control text-input" value="<?php echo $line->description; ?>" ></td>
         <br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	     <br /><br /><br />
	     
	     <td width="185" height="48"><span style="color: blue;">Category (Trade Line) of Supplier / Partner:</span></td>
		<!--input name="catergory" type="text" id="username" placeholder="Supplier / Partner Category"  class="validate[required,length[0,100]] form-control text-input" value="<!?php echo $line->catergory; ?>" required/>-->
		
		<td width="262"><select name="catergory" id="username"  class="form-control" required/>
			 <option value="">Select a Trade Line for the Supplier / Partner</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM parameters where type = 'trdlines' and active=1");
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
		 <td width="262"><input name="activity_status" type="text" id="activity_status" placeholder="Skip (Leave Blank) if New Supplier or Partner"  class="form-control text-input" value="<?php echo $line->activity_status; ?>" /></td>
         <br />
		 
          <td width="185" height="48"><span style="color: blue;">Performance Rating of Supplier / Partner:</span></td>
		  <td width="262"><select name="perform_rate" id="category" required>
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
		  <td width="262"><input readonly name="review_date" type="text" id="review_date" placeholder="Date of Last Perfomance Review (Read Only)" class="form-control"  value="<?php echo $line->review_date; ?>"/></td>
          <br />
	      <td width="185" height="48"><span style="color: blue;">Preferred Supplier / Partner Indicator :</span></td>
		  <td width="262"><select name="prefered_supplier" id="prefered_supplier" required>
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
			if ($line->doc!='') { echo "<a href='upload/profile' target='_explorer.exe'>Click To Open Folder</a> <br/>";}?>  
			<input name="doc" type="file" id="doc"  class="text-input"/></td> <?php } 
			else { ?>
		 <td width="185" height="48"><span style="color: red;"><strong>NOTE:-</strong> Uploading of Attachment Documents ONLY permitted for Approved and Active Supplier/Partners</span></td>
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