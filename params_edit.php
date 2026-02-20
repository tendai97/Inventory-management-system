<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "Add New "; else echo "Update "; ?>System Parameter</legend>
      <?php 
	  $id = $_GET['id'];
	  $line = "";
				
		if(!isset($_GET['id'])&& isset($_POST['param_name']))

            {
			

			$param_name=mysql_real_escape_string($_POST['param_name']);
			$type=mysql_real_escape_string($_POST['type']);
			$module=mysql_real_escape_string($_POST['module']);
			if($_POST['ao'] == "on") {$ao = 1;} else {$ao = 0;}
			if($_POST['hra'] == "on") {$hra = 1;} else {$hra = 0;}
			if($_POST['fa'] == "on") {$fa = 1;} else {$fa = 0;}
			if($_POST['ita'] == "on") {$ita = 1;} else {$ita = 0;}
			if($_POST['ex'] == "on") {$ex = 1;} else {$ex = 0;}
			
			$count = $db->countOf("param_drpdwn", "type='$type' or param_name='$param_name'");
		
		if($count > 0)
			{
		echo "<font color=red> $name :- System Parameter with same Type or Name already Exists. Please Verify</font>";
			}
			else
				
			{
						
			if($db->query("insert into param_drpdwn values(NULL,'$type','$param_name','$module','$ex','$fa','$hra','$ao','$ita',1)"))
			echo "<br><font color=green size=+1 > System Parameter:- $param_name Added Successfully !</font>" ;
			else
			echo "<br><font color=red size=+1 >Problem in Adding System Parameter!!</font>" ;
			
			}
			
			
			}
	////////////////////////////////System Parameter update/////////////////////////////////
	
			elseif (isset($_GET['id'])&& isset($_POST['param_name'])){
			
					
			$param_name=mysql_real_escape_string($_POST['param_name']);
			$type=mysql_real_escape_string($_POST['type']);
			$module=mysql_real_escape_string($_POST['module']);
			if($_POST['ao'] == "on") {$ao = 1;} else {$ao = 0;}
			if($_POST['hra'] == "on") {$hra = 1;} else {$hra = 0;}
			if($_POST['fa'] == "on") {$fa = 1;} else {$fa = 0;}
			if($_POST['ita'] == "on") {$ita = 1;} else {$ita = 0;}
			if($_POST['ex'] == "on") {$ex = 1;} else {$ex = 0;}
			
					if($db->query("UPDATE param_drpdwn SET param_name='$param_name',module='$module',ex='$ex',fa='$fa',hra='$hra',ao='$ao',ita='$ita' where id=".$_GET['id'])) {
					echo "<br><font color=green size=+1 > System Parameter:- $name  Successfully Updated!</font>" ;
					$line = $db->queryUniqueObject("SELECT * FROM param_drpdwn WHERE active = 1 and id = ".$_GET['id']);
					}
					else
					{echo "<br><font color=red size=+1 >Problem encountered in Updating System Parameter!!</font>" ;}
					
			}
			elseif(isset($_GET['id']) && $_GET['op']=="D"){
					$db->query("UPDATE param_drpdwn  SET active='0' where id=".$_GET['id']);
					
					$msg = "System Parameter Deactivated Successfully!!";

					?>
					<script language="javascript" type="text/javascript">
					window.location = "index.php?c=params_admin&cmsg=<?php echo $msg; ?>";
					</script>
					<?php 
			}
			
			elseif(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM param_drpdwn WHERE id=$id");
			}
				
				?>
     <form action="" method="post">
       
	   <table width="585"  border="0" cellspacing="0" cellpadding="0">
	            
         <tr>
           <td width="185" height="48"><span style="color: blue;">Parameter Type Code:</span></td>
           <td width="393"><?php if(isset($_GET['id'])){echo $line->type;}else{?><input name="type" type="text" id="type"  maxlength="20" Placeholder="Enter Parameter Type Code - Maximum 8 characters" class="form-control" value="<?php echo $line->type; ?>" required/><?php }?></td>
         </tr> 
		 
	    <tr>
           <td width="185" height="43"><span style="color: blue;">Parameter Name:</span></td>
          <td width="393"><input name="param_name" type="text" id="param_name"  Placeholder="Name of System Parameter" class="form-control" value="<?php echo $line->param_name; ?>" required/></td>
         </tr>
         <tr>
           <td width="185" height="37"><span style="color: blue;">Applicable Module:</span></td>
           <td width="393"><select name='module' id="module" class="form-control">
				<option value="" >Select Applicable Module</option>
				<option value="ALL" <?php if($line->module == "ALL" ) echo "selected";?>>All Modules</option>
				<option value="ATM" <?php if($line->module == "ATM" ) echo "selected";?>>Assets Management</option>
				<option value="LAM" <?php if($line->module == "LAM" ) echo "selected";?>>Leave of Absence</option>
				<option value="RPO" <?php if($line->module == "RPO" ) echo "selected";?>>Requistions & Purchase Orders</option>
				<option value="TAE" <?php if($line->module == "TAE" ) echo "selected";?>>Travel Advances & Expenses</option>
				<option value="VLM" <?php if($line->module == "VLM" ) echo "selected";?>>Vehicle Logging</option>
			  </select></td>
         </tr>
       </table>
	   <br/>
	  <span style="color: blue;">Select and Tick User Profiles With Access Privileges To Maintain (Change) This Parameter</span><br>
	   
		  <input name="ex" type="checkbox" id="ex" <?php if ($line->ex == 1) echo "checked"; ?> /> Exec Management
		  <input name="fa" type="checkbox" id="fa" <?php if($line->fa == 1) echo "checked";?>/> Finance and Accounting
		  <input name="hra" type="checkbox" id="hra" <?php if($line->hra == 1) echo "checked";?>/> HR Administration 
		  <input name="ao" type="checkbox" id="ao" <?php if($line->ao == 1) echo "checked";?>/> Office Administration 
		  <input name="ita" type="checkbox" id="ita" <?php if($line->ita == 1) echo "checked";?>/> IT Systems Admin  
		  
		<br/><br/>
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