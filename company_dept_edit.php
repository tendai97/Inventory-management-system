<div id="content">
      <h1><?php if(!isset($_GET['id'])) echo "Add New "; else echo "Update "; ?>Department</h1>
      <?php 
	  $line="";
				if(!isset($_GET['id'])&& isset($_POST['name']))

            {
			

			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			
			
			$count = $db->countOf("company_dept", "name='$name'");
		
		if($count==1)
			{
		echo "<font color=red> $name already Exists. Please Verify</font>";
			}
			else
			{
						
			if($db->query("insert into company_dept values(NULL,'$code','$name','$description',NOW(),'".$_SESSION[SITE_NAME]['username']."',NULL,NULL,1)"))
			echo "<br><font color=green size=+1 >  $firstname $surname Added Successfully !</font>" ;
			else
			echo "<br><font color=red size=+1 >Problem in Adding Company / Department!</font>" ;
			
			}
			
			
			}
	////////////////////////////////user update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['name'])){
			
					
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
					
						
					if($db->query("UPDATE company_dept  SET name='$name',description='$description',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']))
					echo "<br><font color=green size=+1 >  $name  Profile Updated!</font>" ;
					else
					echo "<br><font color=red size=+1 >Problem in Updating !</font>" ;
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE company_dept  SET active='0' where id=".$_GET['id']);
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=company_dept_admin";
					</script>
					<?php 
			}
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       <table width="300"  border="0" cellspacing="0" cellpadding="0">
	   
	    <tr>
           <td width="155">Name:</td>
          <td width="473"><input name="name" type="text" id="name"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->name; ?>" required/></td>
         </tr>
         
         <tr>
           <td width="155">Code:</td>
           <td width="473"><?php if(isset($_GET['id'])){echo $line->code;}else{?><input name="code" type="text" id="code"  maxlength="3" class="validate[required,length[0,100]] text-input" value="<?php echo $line->code; ?>" required/><?php }?></td>
         </tr>         
         <tr>
           <td width="155">Description:</td>
           <td width="473"><input name="description" type="text" id="description"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->description; ?>" required/></td>
         </tr>
       
         <tr>
           <td align="right"><input type="reset" name="Reset" value="Reset" />
             &nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;&nbsp;&nbsp;
             <input type="submit" name="Submit" value="Save" /></td>
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