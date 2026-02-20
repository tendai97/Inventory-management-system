<div id="content">
      <legend>ASSET ALLOCATION </legend>
      <?php 
	 
	  $adesc_no=$_GET['assert_no'];
	  $line="";
	  
			$sql="select * from assets inner join asset_type as atyp on asset_type = atyp.code WHERE assert_no = '$adesc_no'";
			$line =  $db->queryUniqueObject($sql);
	 
			//var_dump($_SESSION);							 
						
			$assert_no=mysql_real_escape_string($_GET['assert_no']);
			$custodian=mysql_real_escape_string($_POST['custodian']);
			$custodian1=mysql_real_escape_string($_POST['code1']);
			$alloc_dept=mysql_real_escape_string($_POST['company_dept']);
			$alloc_project=mysql_real_escape_string($_POST['project']);
			$asset_group=mysql_real_escape_string($_POST['asset_group']);
			$asset_type=mysql_real_escape_string($_POST['asset_type']);
			$narrative=mysql_real_escape_string($_POST['narrative']);
			$insU=$_SESSION[SITE_NAME]['username'];
			
			$AC= $db->queryUniqueObject("SELECT * FROM projects WHERE name= '$alloc_project'");
		$AT= $db->queryUniqueObject("SELECT * FROM company_dept WHERE name='$alloc_dept'");
		$CU= $db->queryUniqueObject("SELECT * FROM persons WHERE id= '$custodian1'");
					
	if(!isset($_GET['id']) && isset($_POST['custodian']))
				 {
			$projassetcount = $db->countOf("asset_allocation","custodian='$custodian1' AND project= '$alloc_project' AND dept='$alloc_dept'");
			$projassetcount++;					
			$allocNo=str_pad($AC->code, 4, 0, STR_PAD_LEFT).str_pad($AT->code, 5, 0, STR_PAD_LEFT).str_pad($custodian1, 4, 0, STR_PAD_LEFT).str_pad($line->asset_group, 4, 0, STR_PAD_LEFT).str_pad($line->asset_type, 4, 0, STR_PAD_LEFT).str_pad($projassetcount, 4, 0, STR_PAD_LEFT);
			
			
		$sql="	INSERT INTO `asset_allocation` 	(`asset`,`custodian`, `asset_group`, `asset_type`,`event`,`allocate_status`,`project`,`dept`,`narrative`,`insU`, `insTS`,alloc_no)	
	VALUES	( '$line->assert_no',	'$custodian1','$line->asset_group','$line->asset_type','Allocate','Allocated - Awaiting Custodian Acceptance','$alloc_project','$alloc_dept', '$narrative', '$insU', NOW(),'$allocNo')";
		//echo $sql;
			//$db->query($sql);
			
			if($db->query($sql))
			{
						$sql="UPDATE `assets` SET alert_flag='E', alloc_status='Allocated - Awaiting Custodian Acceptance',`custodian` = '$custodian' , alloc_project = '$alloc_project' , alloc_dept='$alloc_dept', `updTS` = NOW() , `updU` = '$insU' WHERE	`assert_no` = '$assert_no'  ";
						
						//echo $sql;
			$db->query($sql);
		
		
	
			?>
				<script type="text/javascript"> 

    window.open("tcpdf/examples/barcode1.php?value=<?php echo $allocNo;?>&at=<?php echo $AC->name;?>&ac=<?php echo $AT->name;?>&cu=<?php echo $CU->firstname.' '.$CU->surname;?>" , 'formpopup', 'view text','menubar=yes,scrollbars=yes,resizable=yes,width=640,height=700');
    form.target = 'formpopup';

</script>
		<?php	

		$desc = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '$assert_no'");
		$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE id = ".$_SESSION[SITE_NAME]['person']);
		
		// email setup
		
		$message= "Dear ".$CU->firstname.' '.$CU->surname.", \n \nYou have been allocated Asset # ".$assert_no." (".$desc->asset_description.").\nPlease log onto the WWF Zim ESSC system on https://portal.wwf.org.zw/wwf_dev/landing_page.php? and proceed to the Asset Tracking & Management module to ACCEPT or DECLINE this offer. \n \nYours Sincerely, \n \n".$admin->firstname.' '.$admin->surname."";
			
			include 'core/mail.php';
			
			$zita=$CU->firstname.' '.$CU->surname;
			sendemail( $CU->firstname.' '.$CU->surname,$CU->email,$message,"Notice of Asset Allocation (Attention Required)");
			
			
			//sendemail($zita ,"hmutete@gmail.com",$message,"Asset Allocation");
			
			echo "<br><font color=green size=+1 >  Asset has been Allocated Successfully !</font>" ;
			}
			else
			echo "<br><font color=red size=+1 >Problem in Adding Asset Alocation!</font>" ;
			
			 }
			
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM assets WHERE id=$id");
			}
		
				?>
				
     <form action="" method="post">
       <table width="550"  border="0" cellspacing="0" cellpadding="0">
	  
	   <tr>
           <td width="200" height="39"><strong>Asset Number:</strong></td>
           <td width="800"><?php echo $_GET['assert_no'];?></td>
		   
		   </tr>
		      
         <tr>
           <td width="200" height="47"><strong>Asset Description:</strong></td>
           <td width="800"><?php echo $line->asset_description; ?></td>
         </tr>
			
          <tr>
		 <td width="200" height="35"><strong>Asset Type:</strong></td>
          <td width="800"><?php echo $line->name; ?></td>
           </tr>  
		 	   
          <tr>
		  <td width="200" height="47"><strong>Custodian:</strong></td>
		  <td width="800"><input  type="text" id="code" name="custodian" placeholder="Enter a name to select (pick) Custodian for the Asset" class="form-control text-input"  required/></td>
		   <input name="code1" type="hidden" id="code1"  />
		   </tr>
		   
		 </table>
		 <br />
		 <table width="550"  border="0" cellspacing="0" cellpadding="0">
          <tr>
		   
		    <select name="project" id="category" required>
			 <option value="">Please select the ALLOCATION Project&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</option>
              <?php
			 $cost_centre=$db->query( "SELECT * FROM  projects where active=1 ");
			 while($row = mysql_fetch_array($cost_centre))
		
		{if($row['name']== $line->alloc_project)
			echo ' <option value="'.$row['name'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['name'].'" >'.$row['name'].'</option>';
			}
			
		 ?>
			
            </select>
			</tr>
		 <br />
		  
         <br /> 
		  <tr>
		    <select name="company_dept" id="region" required>
			 <option value="">Please Select the ALLOCATION Department</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM company_dept where active=1");
		  	while($row = mysql_fetch_array($result))
			{
			   ?>
               <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
			   <?php } ?>
            </select>
		</tr>
		 <br /> <br />
	
       </table>
	   
	   	  <table>
      	  
	  <textarea  rows="2" cols="75" name="narrative" placeholder="Optional Comments or Narrative " id="narrative"  /></textarea>
            	  
	  </table>
	       
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="Submit" value="Submit" />
      </p>
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>