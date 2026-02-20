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
      <legend><?php if(!isset($_GET['id'])) echo "ADD NEW "; else echo "UPDATE "; ?>ASSET </legend>
      <?php 
	  $line="";
	  
				if(!isset($_GET['id'])&& isset($_POST['asset_type']))

            {
		
			$issupported=mysql_real_escape_string($_POST['issupported']);
			$support_details=mysql_real_escape_string($_POST['support_details']);
			$estimated_period=mysql_real_escape_string($_POST['estimated_period']);
			$disposal_date=mysql_real_escape_string($_POST['disposal_date']);
				
			$voucher_local_value=mysql_real_escape_string($_POST['voucher_local_value']);
			$project=mysql_real_escape_string($_POST['project']);
			$donor=mysql_real_escape_string($_POST['donor']);
			$gl_code=mysql_real_escape_string($_POST['gl_code']);
			$warranty_period=mysql_real_escape_string($_POST['warranty_period']);

			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);			
			$asset_description=mysql_real_escape_string($_POST['asset_description']);
			$company_dept=mysql_real_escape_string($_POST['company_dept']);
			$asset_type=mysql_real_escape_string($_POST['asset_type']);
			$mining_venture=mysql_real_escape_string($_POST['mining_venture']);
			$serial_no=mysql_real_escape_string($_POST['serial_no']);
			
			$ac = $db->queryUniqueObject("SELECT * FROM asset_type WHERE code = '$asset_type'");
			//var_dump($ac);
			//$asset_group=mysql_real_escape_string($_POST['asset_group']);
			$asset_group=mysql_real_escape_string($ac->class);
			$comment=mysql_real_escape_string($_POST['comment']);
			$purchase_date=mysql_real_escape_string($_POST['purchase_date']);
			//$custodian=mysql_real_escape_string($_POST['custodian']);
			$supplier=mysql_real_escape_string($_POST['supplier']);
			$cost_price=mysql_real_escape_string($_POST['cost_price']);
			$insU=$_SESSION[SITE_NAME]['username'];
			
			$make=mysql_real_escape_string($_POST['make']);
			$model=mysql_real_escape_string($_POST['model']);
			$acc_voucher=mysql_real_escape_string($_POST['acc_voucher']);
			$voucher_og_value=mysql_real_escape_string($_POST['voucher_og_value']);
			
			//var_dump($_POST);
			$veh_img_ext = '';
			/*$count = $db->countOf("assets", "description='$description'");
		
		if($count==1)
			{
		echo "<font color=red> Asset  ($description) already Exists. Please Verify</font>";
			}
			else
			{*/
			$assetcount = $db->countOf("assets","asset_group = '$asset_group' and asset_type = '$asset_type' ");
			$assetcount++;
			//list($dd, $mm, $yy) = explode('/', $_POST['purchase_date']);
						
			$assetNo=str_pad($asset_group, 4, 0, STR_PAD_LEFT).str_pad($asset_type, 4, 0, STR_PAD_LEFT).str_pad($assetcount, 4, 0, STR_PAD_LEFT);
			$sql="INSERT INTO `assets` 	( 
	`assert_no`, 
	`asset_type`, 
	`asset_group`,
	`alloc_status`,  
	`purchase_date`, 
	`asset_description`, 
	`make`, 
	`model`, 
	`serial_no`, 
	`supplier`, 
	`cost_price`, 
	`acc_voucher`, 
	`voucher_og_value`, 
	`voucher_local_value`, 
	`location`, 
	`donor`, 
	`gl_code`, 
	`warranty_period`, 
	`issupported`, 
	`support_details`, 
	`estimated_period`, 
	`insU`, 
	`syscount`, 
	`image`, 
	`insTS`
	)
	VALUES
	('$assetNo', 
	'$asset_type', 
	'$asset_group',
	'New Asset - Awaiting Confirmation', 
	'$purchase_date', 
	'$asset_description', 
	'$make', 
	'$model', 
	'$serial_no', 
	'$supplier', 
	'$cost_price', 
	'$acc_voucher', 
	'$voucher_og_value', 
	'$voucher_local_value', 
	'$comment', 
	'$donor', 
	'$gl_code', 
	'$warranty_period', 
	'$issupported', 
	'$support_details', 
	'$estimated_period', 
	'$insU',  
	1, 
	'$image', 
	NOW()
	)";
			if($db->query(  $sql))
			{
					$visitId=mysql_insert_id();
				
				/////////////////////////////////upload of picture////////////////////////////////////
				define('filesDir','upload/profile/');				
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["image"]["name"]);
$extension = end($temp);
//echo $_FILES["image"]["size"];
if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/jpg")
|| ($_FILES["image"]["type"] == "image/pjpeg")
|| ($_FILES["image"]["type"] == "image/x-png")
|| ($_FILES["image"]["type"] == "image/png"))
//&& ($_FILES["image"]["size"] < 20000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br>";
  } else {
    /*echo "Upload: " . $_FILES["image"]["name"] . "<br>";
    echo "Type: " . $_FILES["image"]["type"] . "<br>";
    echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["image"]["tmp_name"];*/
	$filesFileTempname=$_FILES["image"]['tmp_name'];
	//echo $filesFileTempname;
	
	 move_uploaded_file($filesFileTempname,filesDir.$assetNo.'.'.$extension);
	 if ($asset_group == 'MV00') { $veh_img_ext = '$extension'; }
	 $sql = "UPDATE	assets	SET 	image='$extension'	WHERE 	id = $visitId";
	 $db->query($sql);
  }
}

	if ($_FILES['image2']['name'])
    				 {
						
						// remove it
						//unlink('upload/profile/doc'.$_POST['asset_no'].'.'.$line->image2);

define('filesDir','upload/profile/');				
$allowedExts = array("pdf", "doc", "jpg", "png");
$temp = explode(".", $_FILES["image2"]["name"]);
$extension = end($temp);
//echo $_FILES["image"]["size"];
//if ( in_array($extension, $allowedExts)) {
  if ($_FILES["image2"]["error"] > 0) {
    echo "Error: " . $_FILES["image2"]["error"] . "<br>";
  } else {
    
	$filesFileTempname=$_FILES["image2"]['tmp_name'];
	//echo $filesFileTempname;
	 move_uploaded_file($filesFileTempname,filesDir.'doc'.$assetNo.'.'.$extension);
	 $sql = "UPDATE	assets	SET 	image2='$extension'	WHERE 	id = $visitId";
	 $db->query($sql);
  }
//}
    				}		
					
				$AC= $db->queryUniqueObject("SELECT * FROM asset_group WHERE code= '$asset_group'");
				$AT= $db->queryUniqueObject("SELECT * FROM asset_type WHERE code='$asset_type'");
		
		if ($asset_group == 'MV00') {
			$sql="INSERT INTO `vehicle_master` 	(`assert_no`, `alloc_status`, `asset_description`, `make`, `model`, `reg_no`, `comment`, `insU`, `image`, `insTS`	)
					VALUES	('$assetNo', 'New - Available', '$asset_description', '$make', '$model', '$serial_no', '$comment', '$insU', '$extension', NOW()	)";				
			$db->query($sql); }
			
				echo "<br><font color=green size=+1 >  $assetNo Added Successfully !</font>" ;
			?>
			<script type="text/javascript"> 

    window.open("tcpdf/examples/barcode1.php?value=<?php echo $assetNo;?>&at=<?php echo $AC->name;?>&ac=<?php echo $AT->name;?>" , 'formpopup', 'view text','menubar=yes,scrollbars=yes,resizable=yes,width=640,height=700');
    form.target = 'formpopup';

</script>
<?php
			}
			
			else
			echo "<br><font color=red size=+1 >Problem in Adding Asset !</font>" ;
			
			//}
			
			}
	////////////////////////////////asset update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['asset_no'])){
			
			$assert_no=mysql_real_escape_string($_POST['asset_no']);
			$make=mysql_real_escape_string($_POST['make']);
			$model=mysql_real_escape_string($_POST['model']);
			$asset_description=mysql_real_escape_string($_POST['asset_description']);
			$serial_no=mysql_real_escape_string($_POST['serial_no']);
			$acc_voucher=mysql_real_escape_string($_POST['acc_voucher']);
			$voucher_og_value=mysql_real_escape_string($_POST['voucher_og_value']);
			$voucher_local_value=mysql_real_escape_string($_POST['voucher_local_value']);
			$donor=mysql_real_escape_string($_POST['donor']);
			$comment=mysql_real_escape_string($_POST['comment']);
			$purchase_date=mysql_real_escape_string($_POST['purchase_date']);
			//$custodian=mysql_real_escape_string($_POST['custodian']);
			$gl_code=mysql_real_escape_string($_POST['gl_code']);
			$supplier=mysql_real_escape_string($_POST['supplier']);
			$cost_price=mysql_real_escape_string($_POST['cost_price']);
			$warranty_period=mysql_real_escape_string($_POST['warranty_period']);
			$issupported=mysql_real_escape_string($_POST['issupported']);
			$support_details=mysql_real_escape_string($_POST['support_details']);
			$estimated_period=mysql_real_escape_string($_POST['estimated_period']);
			
			$line=$db->queryUniqueObject("SELECT * FROM assets WHERE id=".$_GET['id']);
						//echo "UPDATE assets  SET  cost_price='$cost_price',`purchase_date` = '$purchase_date', `custodian` = '$custodian', `supplier` = '$supplier',  `asset_description` = '$description',  `serial_no` = '$serial_no', `comment` = '$comment',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id'];
					if($db->query("UPDATE assets  SET  cost_price='$cost_price',`purchase_date` = '$purchase_date', `make` = '$make', `model` = '$model', `supplier` = '$supplier', `donor` = '$donor', `gl_code` = '$gl_code', `warranty_period` = '$warranty_period', `issupported` = '$issupported', `support_details` = '$support_details', `estimated_period` = '$estimated_period',  `asset_description` = '$asset_description', `voucher_og_value` = '$voucher_og_value', `voucher_local_value` = '$voucher_local_value', `location` = '$comment',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']))
					{
							if ($_FILES['image']['name'])
    				 {
						
						// remove it
						unlink('upload/profile/'.$_POST['asset_no'].'.'.$line->image);

define('filesDir','upload/profile/');				
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["image"]["name"]);
$extension = end($temp);
//echo $_FILES["image"]["size"];
if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/jpg")
|| ($_FILES["image"]["type"] == "image/pjpeg")
|| ($_FILES["image"]["type"] == "image/x-png")
|| ($_FILES["image"]["type"] == "image/png"))
//&& ($_FILES["image"]["size"] < 20000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br>";
  } else {
    /*echo "Upload: " . $_FILES["image"]["name"] . "<br>";
    echo "Type: " . $_FILES["image"]["type"] . "<br>";
    echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["image"]["tmp_name"];*/
	$filesFileTempname=$_FILES["image"]['tmp_name'];
	//echo $filesFileTempname;
	 move_uploaded_file($filesFileTempname,filesDir.$_POST['asset_no'].'.'.$extension);
	 $sql = "UPDATE	assets	SET 	image='$extension'	WHERE 	id = ".$_GET['id'];
	 $db->query($sql);
  }
} /*else {
  echo "<br><font color=red size=+1 >  Invalid file!</font>";
}*/
    				}
			if ($_FILES['image2']['name'])
    				 {
						
						// remove it
						unlink('upload/profile/doc'.$_POST['asset_no'].'.'.$line->image2);

define('filesDir','upload/profile/');				
$allowedExts = array("pdf", "doc", "jpg", "png");
$temp = explode(".", $_FILES["image2"]["name"]);
$extension = end($temp);
//echo $_FILES["image"]["size"];
//if ( in_array($extension, $allowedExts)) {
  if ($_FILES["image2"]["error"] > 0) {
    echo "Error: " . $_FILES["image2"]["error"] . "<br>";
  } else {
    
	$filesFileTempname=$_FILES["image2"]['tmp_name'];
	//echo $filesFileTempname;
	 move_uploaded_file($filesFileTempname,filesDir.'doc'.$_POST['asset_no'].'.'.$extension);
	 $sql = "UPDATE	assets	SET 	image2 ='$extension'	WHERE 	id = ".$_GET['id'];
	 $db->query($sql);
  }
//}
    				}		
					
	 $sql = "UPDATE	`vehicle_master` SET `make` = '$make', `model` = '$model', `asset_description` = '$asset_description', `comment` = '$comment', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where assert_no = '$assert_no'";
	 $db->query($sql);
						
						echo "<br><font color=green size=+1 >  Asset   Updated Successfully!</font>" ;
						$line=$db->queryUniqueObject("SELECT * FROM assets WHERE id=".$_GET['id']);
					} else
					echo "<br><font color=red size=+1 >Problem in Updating !</font>" ;
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE assets  SET  alloc_status = 'Asset Deactivation - Awaiting Approval', alert_flag='A' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=assert_admin";
					</script>
					<?php 
			}
				elseif(isset($_GET['id']) && $_GET['op']=="Con"){
									
					$id=$_GET['id'];
					$line = $db->queryUniqueObject("SELECT * FROM assets WHERE id = $id");
								
					if ($line->asset_group <> 'MV00') {
						$db->query("UPDATE asset_allocation  SET active='0' where asset = '".$_GET['assert_no']."'");
						$db->query("UPDATE assets  SET alert_flag='N', alloc_status='Awaiting Allocation' where id=".$_GET['id']);
						
						?>
						<script language="javascript" type="text/javascript">
						window.location = "index.php?c=admin_asset";
						</script>
						<?php 
					} else {
						?>
						<script language="javascript" type="text/javascript">
						window.location = "index.php?c=vehicles/vehicle_capture&state=new&assert=<?php echo $line->assert_no ;?>";
						</script>
						<?php }
			}
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM assets WHERE id = $id");
			}
				
				?>
     <form action="" method="post" enctype="multipart/form-data">
	
	    <legend>Asset Details</legend> 

	   <?php if (isset($_GET['id'])){?>
	    <tr>
           <td width="185"height="48"><span style="color: blue;"><strong>Asset Number:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span></td>
          <td width="262"><?php echo $line->assert_no; ?>
		  <input type="hidden" name="asset_no" class="form-control" value="<?php echo $line->assert_no; ?>"/>
		  </td>
         </tr>
		 <br />
		 
         <?php }?>
		 
		 <br />
		 <fieldset>
      
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	    <td width="185" height="48"><span style="color: blue;">Asset Class:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	      <td width="262"><?php if (isset($_GET['id'])){
		  $res = $db->queryUniqueObject("SELECT * FROM  asset_group where active=1 and code='".$line->asset_group."'");
		  echo $res->name; } else { ?><br /> 
		  <td width="262"><?php echo "[NOTE: Asset Class Automatically Assigned Based on Type!!]";

		  }
		  
		  ?>
		  
		  <!--label for="asset_group"></label>
             <select name="asset_group" id="category" >
			 <option value="">Select an Asset Class &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
              <!?php
			 $asset_group=$db->query( "SELECT * FROM  asset_group where active=1");
			 while($row = mysql_fetch_array($asset_group))

		{if($row['code']== $line->asset_group)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>

			<!?php }?></td>-->
	  <br />
	  <br />
	  
	  <?php if (isset($_GET['id'])){
		   ?>
		   	 <td width="185" height="48"><span style="color: blue;">Asset Serial No.:&nbsp;&nbsp;&nbsp;</span></td>
	  <?php echo $line->serial_no; }?> 
	  <?php if (isset($_GET['id'])){
	  ?> <br /><br /> <?php } ?>
	  <td width="185" height="48"><span style="color: blue;">Make of Asset:</span></td>
	  <td width="262"><input name="make" type="text" class="form-control" id="make" placeholder="Make of Asset" value="<?php echo $line->make ;?>" required/>
       <br /></td>
	   
       <td width="185" height="48"><span style="color: blue;">Description of Asset:</span></td>
	  <td width="262"><input name="asset_description" type="text" id="asset_description" placeholder="Description of Asset"  class="form-control" value="<?php echo $line->asset_description; ?>" /></td>
         
      <br />  <br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	      <td width="185" height="48"><span style="color: blue;">Asset Type:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	      <td width="262"><?php if (isset($_GET['id'])){
		  $res2 = $db->queryUniqueObject("SELECT * FROM  asset_type where active=1 and code='".$line->asset_type."'");
		  echo $res2->name; }else{ ?>
		  
		  <label for="asset_type"></label>
             <select name="asset_type" id="category" required>
			 <option value="">Select an Asset Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
              <?php
			 $asset_type=$db->query( "SELECT * FROM  asset_type where active=1 ORDER BY name");
			 while($row = mysql_fetch_array($asset_type))

		{if($row['code']== $line->asset_type)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
<!--<input  type="text" id="asset_type"  class="validate[required,length[0,100]] text-input" value=""/>
<input name="asset_type" type="hidden" id="aset_type1"  class="validate[required,length[0,100]] text-input" value=""/>-->
			<?php }?></td>
      <br /> 
      <br />
	  
	  <?php if (isset($_GET['id'])){
		   ?>
		   	 <td width="185" height="48"><span style="color: blue;">Account Voucher No.:&nbsp;&nbsp;&nbsp;</span></td>
	  <?php echo $line->acc_voucher; }?> 
	  <?php if (isset($_GET['id'])){
	  ?> <br /><br /> <?php } ?>
	  <td width="185" height="48"><span style="color: blue;">Model of Asset:</span></td>
	  <td width="262"><input name="model" type="text" class="form-control" id="model" placeholder="Model of Asset" value="<?php echo $line->model ;?>" required/></td>
      <br />
      <?php if (!isset($_GET['id'])){
		   ?>
		   	 <td width="185" height="48"><span style="color: blue;">Asset Serial / Reg No.:</span></td>
			<td width="262"><input name="serial_no" type="text" class="form-control" id="serial_no" placeholder="Enter Asset Serial or Reg Number" value="<?php echo $line->serial_no ;?>"/></td>
			<?php } else {?>
			  <td width="185" height="48"><span style="color: blue;">Date of Purchase of Asset:</span></td>
			  <td width="262"><input name="purchase_date" type="text" id="datepicker"  placeholder="Asset Purchase Date (DD/MM/YYYY)" class="datepicker  form-control" value="<?php echo $line->purchase_date; ?>"/></td>
			  <?php } ?>
			  <br />
      </div>
      
	  </fieldset>
      	  
	  <fieldset>
      <legend>Accounting Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <?php if (!isset($_GET['id'])){
		   ?>
	  <td width="185" height="48"><span style="color: blue;">Account Voucher No.:</span></td>
	  <td width="262"><input name="acc_voucher" type="text" id="acc_voucher"  placeholder="Account Voucher Number"  class="form-control" value="<?php echo $line->acc_voucher; ?>" required/></td>
	  <br /><?php } ?>
	   
       <td width="185" height="48"><span style="color: blue;">Cost Price of Asset:</span></td>
	  <td width="262"><input name="cost_price" type="text" id="cost_price" placeholder="Cost Price of Asset"  class="form-control" value="<?php echo $line->cost_price; ?>" required/></td>
         
      <br />
	  	
	  <td width="185" height="48"><span style="color: blue;">Insurance Value:</span></td>
	  <td width="262"><input name="voucher_og_value" type="text" id="voucher_og_value" placeholder="Insurance Value"  class="form-control" value="<?php echo $line->voucher_og_value; ?>" /></td>        
				
      <br />
	  
       <td width="185" height="48"><span style="color: blue;">General Ledger Code:</span></td>
	  <td width="262"><input name="gl_code" type="text" id="gl_code" placeholder="General Ledger Code"  class="form-control" value="<?php echo $line->gl_code; ?>" required/></td>
	    <br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
		<?php if (!isset($_GET['id'])){
		   ?>
			  <td width="185" height="48"><span style="color: blue;">Date of Purchase of Asset:</span></td>
			  <td width="262"><input name="purchase_date" type="text" id="datepicker"  placeholder="Asset Purchase Date (DD/MM/YYYY)" class="datepicker  form-control" value="<?php echo $line->purchase_date; ?>"/></td>
			  <br /><?php } ?>
         
	  <td width="185" height="48"><span style="color: blue;">Asset Supplier's Name:</span></td>
	  <td width="262"><input type="text" id="supplier1"  placeholder="Enter a name to select (pick) Supplier for the Asset"  class="form-control" value="<?php 
				if (isset($_GET['id'])) { $temp = $line->supplier;
				$sql="SELECT * FROM  supplier_partner where id = '$temp' and active = 1";
				$line2 = $db->queryUniqueObject($sql);
			 	echo $line2->name; }
             ?>" /></td>
		   <input type="hidden" id="supplier"  name="supplier" value="<?php echo $line->supplier; ?>" required/></td>
	  <br />
	   	  
       <td width="185" height="48"><span style="color: blue;">Estimated Current Value:</span></td>
	  <td width="262"><input name="voucher_local_value" type="text" id="voucher_local_value" placeholder="Estimated Current Value"  class="form-control" value="<?php echo $line->voucher_local_value; ?>" /></td>
	   
	   <br /> 
     	
	   <td width="185" height="48"><span style="color: blue;">Asset Donor (Name or Code):</span></td>
	  <td width="262"><input name="donor" type="text" id="donor" placeholder="Asset Donor Code"  class="form-control" value="<?php echo $line->donor; ?>" /></td>
	    
      <br /></div>
      
	  </fieldset>
      <br />
	  
	  <fieldset>
      <legend>Maintenance & Warranty Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  
	  <td width="185" height="48"><span style="color: blue;">Asset Warranty Period in Years:</span></td>
	  <td width="262"><input name="warranty_period" type="text" id="warranty_period"  placeholder="Asset Warranty Period in Years"  class="form-control" value="<?php echo $line->warranty_period; ?>" /></td>
	  <br />
	   
       <td width="185" height="48"><span style="color: blue;">Asset condition and Maintenance contract holder:</span></td>
	  <td width="262"><input name="support_details" type="text" id="support_details" placeholder="Asset condition and Maintenance contract holder"  class="form-control" value="<?php echo $line->support_details; ?>" /></td>
         
      <br /></div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">

	  <td width="185" height="48"><span style="color: blue;">Life Expectancy Period in Years:</span></td>
	  <td width="262"><input name="estimated_period" type="text" id="estimated_period"  placeholder="Life Expectancy Period in Years"  class="form-control" value="<?php echo $line->estimated_period; ?>" /></td>
	  <br />
	   
	  <td width="185" height="48"><span style="color: blue;">Remarks / Asset Location:</span></td>
	  <td width="262"><textarea rows="2" cols="53" name="comment" placeholder="Remarks / Asset Location" id="comment"><?php echo $line->location ;?></textarea></td>

	   
      <br /></div>
      
	  </fieldset>
      <br />
		 	 <!-- -->
		 
		 			 		 
         <fieldset>
	    <td width="300" height="48"><span style="color: blue;"><strong>Asset Image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span></td>
	   <br/><br/>
		<?php if($line->image!='') { ?> <td><img width="225" height="125" alt="" <?php echo "src='upload/profile/$line->assert_no.$line->image'";?>  class="imgr"><br/><br/> <?php } ?>
		<input name="image" type="file" id="image"  class="text-input"/>
			   
		</td>
	   </fieldset>
	    <br />
		 	 <!-- -->
		 
		 			 		 
         <fieldset>
	    <td width="300" height="48"><span style="color: blue;"><strong>Asset Document &nbsp;&nbsp;&nbsp;&nbsp;</strong></span></td>
	   <td> 
	    
	    <?php if($line->image2!='') {
			echo "<br/> <a href='upload/profile/doc$line->assert_no.$line->image2' > Download </a> <br/>";} ?>  
	   <input name="image2" type="file" id="image2"  class="text-input"/>;
	   
	   </td>
	   </fieldset>
	   <br />
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
      
 
     </form>
	 
     <div align="justify"></div>
<div id="respond"></div>
    </div>