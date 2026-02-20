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
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepickers" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>


<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "NEW "; else echo "UPDATE "; ?>INVENTORY RECORD</legend>
      <?php 
	  
	require 'core/PasswordHash.php';
	require 'core/pwqcheck.php';
	  $line="";
	  $insUs=$_SESSION[SITE_NAME]['username'];
	  
	   if(!isset($_GET['id'])&& isset($_POST['invname']))

            {
		//var_dump($_POST);
			$invname=mysqli_real_escape_string($db->connection,$_POST['invname']);
		
			$sadd=mysqli_real_escape_string($db->connection,$_POST['sadd']);
			//$username=mysql_real_escape_string($_POST['username']);
			$username=$firstname[0].$surname;
			
			
			$user_type=mysqli_real_escape_string($db->connection,$_POST['usertype']);
			
			$category=mysqli_real_escape_string($db->connection,$_POST['category']);
			
			
			
			$count = $db->countOf("assets", "name='$invname'");

	
		if($count > 0 )
			{
		echo "<font color=red> Inventory Record with same name  already Exists on record - Please Verify</font>";
			}
			else if (($count == 0 ))
			{
				//var_dump($_POST);
				
				$sql="INSERT INTO `assets` 
	(`name`, `available`, `category`)
	VALUES
	(
	'$invname', '$sadd', '$category')";
				$db->query($sql);
				$personid=mysqli_insert_id($db->connection);;
				
				 
						
				echo "<br><font color=green size=+1 >  $invname Record Added Successfully </font>" ;

										
				}
			else
			echo "<br><font color=red size=+1 >Problem in Adding inventory Record!</font>" ;
			
			}
			
			

	////////////////////////////////employee update/////////////////////////////////
	
			else if (isset($_GET['id'])&& isset($_POST['invname'])){
							
			$invname=mysqli_real_escape_string($db->connection,$_POST['invname']);
		
			$sadd=mysqli_real_escape_string($db->connection,$_POST['sadd']);

			$cstock=mysqli_real_escape_string($db->connection,$_POST['cstock']);

			$category=mysqli_real_escape_string($db->connection,$_POST['category']);
			

				$line = $db->queryUniqueObject("SELECT * FROM assets WHERE id=".$_GET['id']);
			
											if($db->query("UPDATE `assets` 
	SET
	 
	`name` = '$invname' , 
	`category` = '$category' , 
	`available`=$sadd+$cstock
	
	WHERE
	`id` = ".$_GET['id']));
		
			
			echo "<br><font color=green size=+1 >  $invname Record Updated Successfully </font>" ;

			
		}
		if(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM  assets  WHERE id=$id");
			}

				
				?>
    <form action="" method="post" enctype="multipart/form-data">
       	   
        
	 <fieldset>
      <legend>Inventory Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <input name="personid" id="personid" type="hidden">

	  <br />
	  <td width="185" height="48"><span style="color: blue;">Inventory Name:</span></td>
	  <td width="262"><input name="invname" type="text" class="form-control" id="invname" placeholder="inventory name" value="<?php echo $line->name ;?>" required/></td>
       <br />
	   
      <td width="185" height="48"><span style="color: blue;">Category:</span></td>
	  <td width="262"><select name='category' id ="category" class="form-control">
        <option value="">Select Category</option>
        <?php
			   $result = $db->query("SELECT * FROM categories where active=1");
		  	while($row = mysqli_fetch_array($result))
			{if($row['id']== $line->category)
			echo ' <option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['id'].'" >'.$row['name'].'</option>';} ?>
        
      </select></td>
   
    <!--  <br />
      <input name="middle" type="text" class="form-control" id="middle" placeholder="Middle name" />-->
      
	 </div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
      
      <br />
	  <td width="185" height="48"><span style="color: blue;">Current Stock:</span></td>
	  <td width="262"><input name="cstock" type="text" class="form-control" id="surname" placeholder="cstock" value="<?php if(!isset($_GET['id'])) echo "0"; else echo $line->available ;?>" readonly/></td>
      <br />
      
	  <td width="185" height="48"><span style="color: blue;">Stock to ADD :</span></td>
	  <td width="262"><input name="sadd" type="text" class="form-control" id="sdd" placeholder="enter number to record " value="" required/></td>
              
      
      
      <br />  <br /></div>
      <!-- textarea name="address" placeholder="Address"><?php echo $line->paddress ;?></textarea>
      <br />  <br />
      
    <input name="profession" type="text" class="form-control" id="profession" placeholder="Profession" />-->
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