 <p><br/></p>
      <legend>Enter Reason For <?php if ($_GET['op'] == "Rej") echo "Rejecting Asset Return"; else echo "Declining Asset Allocation";?> </legend> 

		<tr><td><span style="color: red;"><strong>CAUTION:-</strong> Refrain From Using Special Abbreviation Characters Such As ' or & or ) When Entering Text In The Space Below!!</span></td></tr><br/><br/>	  
  
  <?php
        
	if(isset($_POST['ini']) && $_POST['ini'] == "S"){
					 
		$oper = $_GET['op'];
		$srce = $_GET['srce'];
		$assert_no = $_GET['assert_no'];
		$reason=mysql_real_escape_string($_POST['reason']);
		
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=accept_decline&srce=$srce&op=$oper&assert_no=$assert_no&rea=$reason\";
			</script>";
			
				 } else {}
			
				?>
				
				<form action="" method="post">
      <fieldset>
	  
	   <input name="ini" type="hidden"  value="S"/>

		<?php if ($_GET['op'] == "Rej") { ?>
			<textarea  rows="2" cols="125"   name="reason" placeholder="Comment / Reason For Rejecting Asset Return" id="reason"  required/></textarea>
		<?php } else { ?>
			<textarea  rows="2" cols="125"   name="reason" placeholder="Comment / Reason For Declining Asset Allocation" id="reason"  required/></textarea>
		<?php } ?>

		<br /> 
 
      <br />
      <br />
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
      </p>
    </form>