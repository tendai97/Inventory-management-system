<div id="content">
      <br/><legend><?php if(!isset($_GET['id'])) echo "Add New "; else echo "Update "; ?>Vehicle Usage</legend>
      <?php 
			$insUs=$_SESSION['lims']['username'];

		if(!isset($_GET['id'])&& isset($_POST['name']))

            {
			

			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
			
			$count = $db->countOf("parameters", "type='vhcluse' and name='$name'");
		
		if($count==1)
			{
		echo "<font color=red><strong> Vehicle Usage:-  $name already Exists. Please Verify</strong></font>";
			}
			else
				
			{
						
			if($db->query("insert into parameters values(NULL, 'vhcluse','$code',NULL,'$name','$description','Active','N',NOW(),'".$_SESSION[SITE_NAME]['username']."',NULL,NULL,1)"))
			echo "<br><font color=green><strong> Vehicle Usage:- $name Added Successfully!!</strong></font>" ;
			else
			echo "<br><font color=red size=+1 >Problem in Adding Vehicle Usage!</font>" ;
			
			}
			
			
			}
	////////////////////////////////Vehicle Usage update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['name'])){
			
					
			$name=mysql_real_escape_string($_POST['name']);
			$code=mysql_real_escape_string($_POST['code']);
			$description=mysql_real_escape_string($_POST['description']);
								
					if($db->query("UPDATE parameters  SET name='$name',description='$description',updTS=NOW(),updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id'])) {
					echo "<br><font color=green><strong> Vehicle Usage:- $name  Successfully Updated!!</strong></font>" ;
					$line = $db->queryUniqueObject("SELECT * FROM parameters WHERE active = 1 and id = ".$_GET['id']);
					}
					else
					{echo "<br><font color=red><strong>Problem encountered in Updating Vehicle Usage!!</strong></font>" ;}
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE parameters  SET active='0' where id=".$_GET['id']);

					$msg = "Vehicle Usage Successfuly Deleted!!" ;
					
					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=vehicle_usage&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM parameters WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       
	   <table width="585"  border="0" cellspacing="0" cellpadding="0">
	            
         <tr>
           <td width="185" height="48"><span style="color: blue;">Vehicle Usage Code:</span></td>
           <td width="393"><?php if(isset($_GET['id'])){echo $line->code;}else{?><input name="code" type="text" id="code"  maxlength="20" Placeholder="Enter Vehicle Usage Code" class="form-control" value="<?php echo $line->code; ?>" required/><?php }?></td>
         </tr> 
		 
	    <tr>
           <td width="185" height="43"><span style="color: blue;">Vehicle Usage:</span></td>
          <td width="393"><input name="name" type="text" id="name"  Placeholder="Vehicle Usage" class="form-control" value="<?php echo $line->name; ?>" required/></td>
         </tr>
         <tr>
           <td width="185" height="37"><span style="color: blue;">Full Description:</span></td>
           <td width="393"><input name="description" type="text" id="description"  Placeholder="Vehicle Usage Description" class="form-control" value="<?php echo $line->description; ?>" ></td>
         </tr>
		</table>
		<br/>		 
		<tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>

           <td>
             <input type="submit" name="Submit" value="Save" class="btn-small btn-color btn-pad" /></td>
		   <td align="right"><a href="index.php?c=vehicle_usage" class="btn-small btn-color btn-pad">Back</a></td>

           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>

       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>