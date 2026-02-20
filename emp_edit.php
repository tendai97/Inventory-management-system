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
      <br><legend><?php if(!isset($_GET['id'])) echo "NEW "; else echo "UPDATE "; ?>EMPLOYEE RECORD</legend>
      <?php 
	  
	require 'core/PasswordHash.php';
	require 'core/pwqcheck.php';
	  $line="";
	  $insUs=$_SESSION[SITE_NAME]['username'];
	  
	   if(!isset($_GET['id'])&& isset($_POST['firstname']))

            {
		//var_dump($_POST);
			$firstname=mysqli_real_escape_string($db->connection,$_POST['firstname']);
			$surname=mysqli_real_escape_string($db->connection,$_POST['surname']);
			$password=mysqli_real_escape_string($db->connection,$_POST['password']);
			//$username=mysql_real_escape_string($_POST['username']);
			$username=$firstname[0].$surname;
			
			
			$user_type=mysqli_real_escape_string($db->connection,$_POST['usertype']);
			
			$department=mysqli_real_escape_string($db->connection,$_POST['department']);
			
			
			
			$count = $db->countOf("users", "username='$username'");

	
		if($count > 0 )
			{
		echo "<font color=red> Employee Record with same username  already Exists on record - Please Verify</font>";
			}
			else if (($count == 0 ))
			{
				//var_dump($_POST);
				$hasher = new PasswordHash($hash_cost_log2, $hash_portable);
				$hash = $hasher->HashPassword("password123");
				$sql="INSERT INTO `users` 
	(`name`, `surname`, `username`, `password`,`type`, `department`)
	VALUES
	(
	'$firstname', '$surname', '$username', '$hash', '$user_type',	'$department')";
				$db->query($sql);
				$personid=mysqli_insert_id();;
				
				 
						
				echo "<br><font color=green size=+1 >  $firstname $surname's Employee Record Added Successfully </font>" ;

										
				}
			else
			echo "<br><font color=red size=+1 >Problem in Adding Employee Record!</font>" ;
			
			}
			
			

	////////////////////////////////employee update/////////////////////////////////
	
			else if (isset($_GET['id'])&& isset($_POST['firstname'])){
							
			$firstname=mysqli_real_escape_string($db->connection,$_POST['firstname']);
			$surname=mysqli_real_escape_string($db->connection,$_POST['surname']);
			$username=$firstname[0].$surname;
			$user_type=mysqli_real_escape_string($db->connection,$_POST['usertype']);
			$department=mysqli_real_escape_string($db->connection,$_POST['department']);
			

				$line = $db->queryUniqueObject("SELECT * FROM users WHERE id=".$_GET['id']);
			
											if($db->query("UPDATE `users` 
	SET
	 
	`name` = '$firstname' , 
	`surname` = '$surname' , 
	`username`='$username',
	`department` = '$department' ,
	`type` = '$user_type' 
	
	WHERE
	`id` = ".$_GET['id']));
		
			
			echo "<br><font color=green size=+1 >  $firstname $surname's Employee Record Updated Successfully </font>" ;

			
		}
		if(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM  users  WHERE id=$id");
			}

				
				?>
    <form action="" method="post" enctype="multipart/form-data">
       	   
        
	 <fieldset>
      <legend>Personal Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <input name="personid" id="personid" type="hidden">

	  <br />
	  <td width="185" height="48"><span style="color: blue;">Employee's First Name(s):</span></td>
	  <td width="262"><input name="firstname" type="text" class="form-control" id="name" placeholder="Employee's First Names" value="<?php echo $line->name ;?>" required/></td>
       <br />
	   
      <td width="185" height="48"><span style="color: blue;">Employee's Role:</span></td>
	  <td width="262"><select name='usertype' id ="usertype" class="form-control">
        <option value="">Select Role</option>
        <option value="Admin" <?php if($line->type == "Admin" ) echo "selected";?>>Admin</option>
        <option value="User" <?php if($line->type =="User" ) echo "selected";?>>User</option>
        
      </select></td>
   
    <!--  <br />
      <input name="middle" type="text" class="form-control" id="middle" placeholder="Middle name" />-->
      
	 </div>
	  
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
      
      <br />
	  <td width="185" height="48"><span style="color: blue;">Employee's Last Name(s):</span></td>
	  <td width="262"><input name="surname" type="text" class="form-control" id="surname" placeholder="Employee's Last Names" value="<?php echo $line->surname ;?>" required/></td>
      <br />
      
	  <td width="185" height="48"><span style="color: blue;">Employee's Department :</span></td>
	       <td width="262"><select name="department" id="region"  class="form-control" >
			 <option value="">Select a Department for the Employee</option>
			 <?php
			   $result = $db->query("SELECT * FROM department where active=1");
		  	while($row = mysqli_fetch_array($result))
			{if($row['id']== $line->department)
			echo ' <option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['id'].'" >'.$row['name'].'</option>';} ?>
			</select>
              
      
      
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