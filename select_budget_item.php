 <p><br/></p>
      <legend>Selection Of Budget Setting To Manage</legend>  
		<br/>
  <?php
		
		$param=mysql_real_escape_string($_POST['param']);
        
	if (isset($_POST['ini']) && $_POST['ini'] == "S") {
		
			if ($param == "B") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=budget_code_admin\";
					</script>";  }
						
			elseif ($param == "A") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=activity_code_admin\";
					</script>";  }
						
			else {
		
					echo "<font color=red><strong>No Selection Of Budget Setting Made - Please Make A Valid Selection And Resubmit!</strong></font><br><br>" ; }
		
	} else {}		
				?>
				
				<form action="" method="post">
      <fieldset>
	   <input name="ini" type="hidden"  value="S"/>
	  
			<p><?php if(isset($_GET['msg']))echo "<br><font color=red  >".$_GET['msg']. "</font>" ;?></p>

			  <select name='param' id="param" class="form-control" required>
				<option value="" >Select The Budget Setting To Manage</option>
				<option value="B" <?php if($line->param == "B" ) echo "selected";?>>Budget Codes</option>
				<option value="A" <?php if($line->param == "A" ) echo "selected";?>>Activity Codes</option>
			  </select>
			  <br/>
	  </fieldset>
	 
      <br/>
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
      </p>
    </form>