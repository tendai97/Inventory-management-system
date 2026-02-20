 <p><br/></p>
      <legend>Employee DeActivation - Capture Reason</legend> 

		<tr><td><span style="color: red;"><strong>CAUTION:-</strong> Avoid Using Special Abbreviation Characters Such As ' or & or ) When Capturing REASON In The Text Box Below!!</span></td></tr><br/><br/>	  
  
  <?php
        
		$id = $_GET['id'];
		$reason=mysql_real_escape_string($_POST['reason']);
		
	if(isset($_POST['ini']) && $_POST['ini'] == "S"){
					 
		//echo "am in";
		echo "<script type=\"text/javascript\">
			window.location=\"index.php?c=emp_edit&id=$id&op=D&rea=$reason\";
		</script>";

		}			
				$line = $db->queryUniqueObject("SELECT * FROM  persons  WHERE id=$id");
			
				?>
				
	<form action="" method="post">
	  
	   <input name="ini" type="hidden"  value="S"/>

	 <fieldset>
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <td width="185" height="48"><span style="color: blue;">Employee's National ID #:</span></td>
	  <td width="262"><input type="text" class="form-control" id="id_number" value="<?php echo $line->id_number ;?>" readonly/></td>

	  <br />
	  <td width="185" height="48"><span style="color: blue;">Employee's First Name(s):</span></td>
	  <td width="262"><input type="text" class="form-control" id="name" value="<?php echo $line->firstname ;?>" readonly/></td>
       <br />
       </div>
	   
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <td width="185" height="48"><span style="color: blue;">Employee's Date of Birth:</span></td>
	  <td width="262"><input type="text" id="datepicker"  class="form-control datepicker" value="<?php echo $line->dob; ?>" readonly/></td>
      
      <br />
	  <td width="185" height="48"><span style="color: blue;">Employee's Last Name(s):</span></td>
	  <td width="262"><input type="text" class="form-control" id="surname" value="<?php echo $line->surname ;?>" readonly/></td>
      <br />
      </div>
	  </fieldset>

	  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 ">
	  <td width="185" height="48"><span style="color: blue;">Reason For Deactivation:</span></td>
	  <textarea  rows="2" cols="114"   name="reason" placeholder="Enter Reason For Deactivation" id="reason"  required/></textarea>
 	  <br /><br /> 
      </div>
 
      <br />
      <tr>
           <td><input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
		   <td><a href="index.php?c=emp_admin&flag=A" class="btn-small btn-color btn-pad">Exit</a></td>
      </tr>
    </form>