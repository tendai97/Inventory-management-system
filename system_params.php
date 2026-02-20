 <p><br/></p>
      <legend>General System Parameters Selection </legend>  
		<br/>
  <?php
		
		$param=mysql_real_escape_string($_POST['param']);
        
	if (isset($_POST['ini']) && $_POST['ini'] == "S") {
		
			if ($param == "geoloc") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=location_admin\";
					</script>";  }
						
			elseif ($param == "vehbody") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=vehicle_body\";
					</script>";  }
						
			elseif ($param == "vhcluse") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=vehicle_usage\";
					</script>";  }
						
			elseif ($param == "trdlines") {
							 
				echo "<script type=\"text/javascript\">
						window.location=\"index.php?c=trade_admin\";
					</script>";  }
						
			else {
		
					echo "<font color=red><strong>No Selection Of System Parameters Made - Please Make A Valid And Resubmit!</strong></font><br><br>" ; }
		
	} else {}		
				?>
				
				<form action="" method="post">
      <fieldset>
	   <input name="ini" type="hidden"  value="S"/>
	  
			<p><?php if(isset($_GET['msg']))echo "<br><font color=red  >".$_GET['msg']. "</font>" ;?></p>

				<select name='param' id ="param" class="form-control" required>
				 <option value="">Select The System Parameter To Manage</option>
				  <?php
				 $prm_type = $db->query ("SELECT * FROM  param_drpdwn where active = 1 order by param_name");
				 while($row = mysql_fetch_array($prm_type))
			
					{ if($row['type'] == $line->type)
					echo ' <option value="'.$row['type'].'" selected>'.$row['param_name'].'</option>';
					else
					echo ' <option value="'.$row['type'].'" >'.$row['param_name'].'</option>';
					}
				?>
				</select>
			  <br/>
	  </fieldset>
	 
      <br/>
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
      </p>
    </form>