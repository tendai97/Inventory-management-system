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
    $( "#datepicker" ).datepicker();
  } );
  
    $( function() {
    $( "#datepickers" ).datepicker();
  } );
  </script>
</head>


<div id="content">
      <legend><?php if(!isset($_GET['id'])) echo "ADD NEW "; else echo "UPDATE "; ?>LEAVE TYPE</legend>
      <?php 
	  $line="";
	  
	        if(isset($_GET['id']))
				 {
					 if(isset($_GET['op']) && $_GET['op'] == "D")
					{
					$sql="UPDATE leave_type set status = 'Deactivated', `active` = '0', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id = ".$_GET['id'];
					 $db->query($sql);	
					 ?>
					 <script language="javascript" type="text/javascript">
			window.location = "index.php?c=central_leave_admin";
			</script>
			<?php 
					}
	  
					$sql="select * from leave_type where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
					
				if(isset($_GET['id']) && $_GET['op']=="A"){
			
					$sql="select * from leave_type where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
										
					$db->query("UPDATE leave_type  SET status = 'Active', alert_flag='N', updTS=NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
						
					echo "<br><font color=green size=+1 >  Leave Type Activated Successfully !</font>" ;
					 
			}
	  
					$sql="select * from leave_type where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
					
	  			if (isset($_GET['id'])&& isset($_POST['name'])){
				 
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$entitlement=mysql_real_escape_string($_POST['entitlement']);
			$esc_days=mysql_real_escape_string($_POST['esc_days']);
							 
				 if($db->query("UPDATE `leave_type`
SET 
  
	code = '$code',
	name = '$name',
	description = '$description',
	entitlement = '$entitlement',
	esc_days = '$esc_days',
	updTS=NOW(),
	updU='".$_SESSION[SITE_NAME]['username']."' 
	where id=".$_GET['id']))


						{echo "<br><font color=green size=+1 > LEAVE TYPE Has Been Updated Successfully!</font>" ;
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM leave_type WHERE id=$id");
				
				}
					else
					echo "<br><font color=red size=+1 >Problem in Updating LEAVE TYPE!</font>" ;
					
					}
	  
					 }
	  	  
				elseif(!isset($_GET['id'])&& isset($_POST['name']))

            {
			
//var_dump($_POST);
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			$entitlement=mysql_real_escape_string($_POST['entitlement']);
			$esc_days=mysql_real_escape_string($_POST['esc_days']);
							
			$count = $db->countOf("leave_type", "name='$name'");
		
		if($count==1)
			{
		echo "<font color=red> $name - LEAVE TYPE already Exists. Please Verify</font>";
			}
			else
			{
					/*
					 ["name"]=> string(4) "hope" ["code"]=> string(8) "12345678" ["description"]=> string(4) "teds" ["location"]=> string(4) "ssss" ["status"]=> string(5) "sssss" ["donor"]=> string(4) "ssss" ["budget"]=> string(4) "ssss" ["contacts"]=> string(4) "ssss" ["email"]=> string(6) "ssssss" ["start_date"]=> string(4) "ssss" ["end_date"]=> string(4) "ssss"
					*/	
					$sql="INSERT INTO `leave_type` 	
					(`code`, `name`, `description`, `status`, `alert_flag`, `entitlement`, `esc_days`, `insTS`, `insU`)
	VALUES
	( 
	'$code',
	'$name',
	'$description',
	'New - Awaiting Confirmation',
	'A',
	'$entitlement',
    '$esc_days',	
	NOW(),
	'".$_SESSION[SITE_NAME]['username']."'
	)";
	
//echo $sql;
			
			$db->query($sql);
            $leave_type=mysql_insert_id();
			
			echo "<br><font color=green size=+1 >  $name - LEAVE TYPE Added Successfully !</font>" ;
						
			}
			
			
			}
			
				
				?>
     <form action="" method="post">
     
       <table width="100%"  border="0" cellspacing="0" cellpadding="0">
	            
         <tr>
           <td width="185" height="48"><span style="color: blue;">Leave Code:</span></td>
           <td width="393"><input name="code" type="text" id="code"  maxlength="20" Placeholder="Enter Leave Type Code" class="form-control" value="<?php echo $line->code; ?>" required/></td>
         </tr> 
		 
	    <tr>
           <td width="185" height="43"><span style="color: blue;">Leave Type Name:</span></td>
          <td width="393"><input name="name" type="text" id="name"  Placeholder="Leave Type Name" class="form-control" value="<?php echo $line->name; ?>" required/></td>
         </tr>
         <tr>
           <td width="185" height="37"><span style="color: blue;">Description:</span></td>
           <td width="393"><input name="description" type="text" id="description"  Placeholder="Leave Description" class="form-control" value="<?php echo $line->description; ?>" required/></td>
         </tr>
		  <tr>
           <td width="185" height="36"><span style="color: blue;">Annual Entitlement (Where Applicable):</span></td>
           <td width="393"><input name="entitlement" type="text" id="entitlement"  Placeholder="Annual Entitlement (Where Applicable)" class="form-control" value="<?php echo $line->entitlement; ?>" required/></td>
         </tr>
		        
         <tr>
           <td width="185" height="36"><span style="color: blue;">Number of Days to Escalation prompt:</span></td>
           <td width="393"><input name="esc_days" type="text" id="esc_days"  Placeholder="Number of Days to Escalation prompt" class="form-control" value="<?php echo $line->esc_days; ?>" required/></td>
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