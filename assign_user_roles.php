 <p><br/></p>
      <legend>Assignment Of Roles To User Categories</legend>  

  <?php
	$insUs = $_SESSION[SITE_NAME]['username'];
 	$id = $_GET['id'];
 	$user = $_GET['user'];
	
	if ((isset($_POST['ini'])) && ($_POST['ini'] == "S")) {
		
			$ao = 0; $hra = 0; $fa = 0; $ita = 0; $ex = 0; 
		
			if($_POST['a_init'] == "on") {$a_init = 1; $ao = 1;} else {$a_init = 0;}
			if($_POST['a_apro'] == "on") {$a_apro = 1; $ao = 1;} else {$a_apro = 0;}
			if($_POST['a_insp'] == "on") {$a_insp = 1; $ao = 1;} else {$a_insp = 0;}
			if($_POST['a_othr'] == "on") {$a_othr = 1; $ao = 1;} else {$a_othr = 0;}
			if($_POST['f_init'] == "on") {$f_init = 1; $fa = 1;} else {$f_init = 0;}
			if($_POST['f_apro'] == "on") {$f_apro = 1; $fa = 1;} else {$f_apro = 0;}
			if($_POST['f_insp'] == "on") {$f_insp = 1; $fa = 1;} else {$f_insp = 0;}
			if($_POST['f_othr'] == "on") {$f_othr = 1; $fa = 1;} else {$f_othr = 0;}
			if($_POST['h_init'] == "on") {$h_init = 1; $hra = 1;} else {$h_init = 0;}
			if($_POST['h_apro'] == "on") {$h_apro = 1; $hra = 1;} else {$h_apro = 0;}
			if($_POST['h_insp'] == "on") {$h_insp = 1; $hra = 1;} else {$h_insp = 0;}
			if($_POST['h_othr'] == "on") {$h_othr = 1; $hra = 1;} else {$h_othr = 0;}
			if($_POST['e_insp'] == "on") {$e_insp = 1; $ex = 1;} else {$e_insp = 0;}
			if($_POST['e_othr'] == "on") {$e_othr = 1; $ex = 1;} else {$e_othr = 0;}
			if($_POST['i_insp'] == "on") {$i_insp = 1; $ita = 1;} else {$i_insp = 0;}
			if($_POST['i_othr'] == "on") {$i_othr = 1; $ita = 1;} else {$i_othr = 0;}
			
			$db->query("UPDATE _user  SET ao = $ao, fa = $fa, hra = $hra, ita = $ita, ex = $ex, a_init = $a_init, a_apro = $a_apro, a_insp = $a_insp, a_othr = $a_othr, f_init = $f_init, f_apro = $f_apro, f_insp = $f_insp, f_othr = $f_othr, h_init = $h_init, h_apro = $h_apro, h_insp = $h_insp, h_othr = $h_othr, e_insp = $e_insp, e_othr = $e_othr, i_insp = $i_insp, i_othr = $i_othr  where id = ".$_GET['id']);
											
			echo "<br><font color=green size=+1 >  $user's User Profile Has Been Updated!</font><br><br>" ;  
				  
		}

		$line = $db->queryUniqueObject("SELECT * FROM _user WHERE id = $id"); 
		//$line2 = $db->queryUniqueObject("SELECT * FROM patients WHERE id = $line->patient"); 
					
	if ((isset($_GET['msg'])) && (!isset($_POST['ini']))) echo "<center><font color=green><strong>".$_GET['msg']."</strong></font></center><br/>";
		
				?>
				
	<form action="" method="post">
			<input name="ini" type="hidden"  value="S"/>

	<fieldset> 

	<td><span style="color: blue;">Select User Role Settings Per User Category For This Employee's User Profile :-  </span></td>
     <td><?php echo $line->firstname." ".$line->surname; ?></td>
	<br/><br/>

	 <TABLE class="table table-striped table-bordered" width="850px" border="1">
		<thead>
			<tr><th>User Category</th><th>Initiator</th><th>Approver</th><th>Inspector</th><th>Other</th><th>Applicable Modules</th></tr>
		</thead>
				
		<tbody>
		
		<?php if($line->ao == 1) {  ?>
		<TR>
			<TD>Office Administration</TD>
			<TD align="center"><input name="a_init" type="checkbox" class=""  <?php if($line->a_init) echo "checked";?>/></TD>
			<TD align="center"><input name="a_apro" type="checkbox" class=""  <?php if($line->a_apro) echo "checked";?>/></TD>
			<TD align="center"><input name="a_insp" type="checkbox" class=""  <?php if($line->a_insp) echo "checked";?>/></TD>
			<TD align="center"><input name="a_othr" type="checkbox" class=""  <?php if($line->a_othr) echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, ATM, VLM<br/></span></TD>
		</TR>
		<?php  } if($line->hra == 1) {  ?>
		<TR>
			<TD>HR Adminstration</TD>
			<TD align="center"><input name="h_init" type="checkbox" class=""  <?php if($line->h_init)echo "checked";?>/></TD>
			<TD align="center"><input name="h_apro" type="checkbox" class=""  <?php if($line->h_apro)echo "checked";?>/></TD>
			<TD align="center"><input name="h_insp" type="checkbox" class=""  <?php if($line->h_insp)echo "checked";?>/></TD>
			<TD align="center"><input name="h_othr" type="checkbox" class=""  <?php if($line->h_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, LAM<br/></span></TD>
		</TR>
		<?php  } if($line->fa == 1) {  ?>
		<TR>
			<TD>Finance and Accounting</TD>
			<TD align="center"><input name="f_init" type="checkbox" class=""  <?php if($line->f_init)echo "checked";?>/></TD>
			<TD align="center"><input name="f_apro" type="checkbox" class=""  <?php if($line->f_apro)echo "checked";?>/></TD>
			<TD align="center"><input name="f_insp" type="checkbox" class=""  <?php if($line->f_insp)echo "checked";?>/></TD>
			<TD align="center"><input name="f_othr" type="checkbox" class=""  <?php if($line->f_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, RPO, TAE<br/></span></TD>
		</TR>
		<?php  } if($line->ita == 1) {  ?>
		<TR>
			<TD>IT Systems Admin</TD>
			<TD align="center"><input name="i_init" type="checkbox" class=""  <?php if($line->i_init)echo "checked";?> disabled/></TD>
			<TD align="center"><input name="i_apro" type="checkbox" class=""  <?php if($line->i_apro)echo "checked";?> disabled/></TD>
			<TD align="center"><input name="i_insp" type="checkbox" class=""  <?php if($line->i_insp)echo "checked";?>/></TD>
			<TD align="center"><input name="i_othr" type="checkbox" class=""  <?php if($line->i_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM<br/></span></TD>
		</TR>
		<?php  } if($line->ex == 1) {  ?>
		<TR>
			<TD>Exec Management</TD>
			<TD align="center"><input name="e_init" type="checkbox" class=""  <?php if($line->e_init)echo "checked";?> disabled/></TD>
			<TD align="center"><input name="e_apro" type="checkbox" class=""  <?php if($line->e_apro)echo "checked";?> disabled/></TD>
			<TD align="center"><input name="e_insp" type="checkbox" class=""  <?php if($line->e_insp)echo "checked";?>/></TD>
			<TD align="center"><input name="e_othr" type="checkbox" class=""  <?php if($line->e_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, LAM<br/></span></TD>
		</TR>
		<?php  }  ?>

		</tbody>
						
	</TABLE>

		<strong><span style="color: blue;">KEY for Applicable Modules:- </span></strong><br>
		<span style="color: blue;"><strong>CAM</strong> = Central Administration Module</span><br>
		<span style="color: blue;"><strong>ATM</strong> = Assets Tracking & Management</span><br>
		<span style="color: blue;"><strong>LAM</strong> = Leave & Absence Management</span><br>
		<span style="color: blue;"><strong>VLM</strong> = Vehicle Logging & Management</span><br>
		<span style="color: blue;"><strong>RPO</strong> = Requisitions & Purchase Orders</span><br>
		<span style="color: blue;"><strong>TAE</strong> = Travel Advances & Expenses</span><br><br>

	<?php if($line->ao == 0 && $line->fa == 0 && $line->hra == 0 && $line->ita == 0 && $line->ex == 0) 
					echo "<br><center><font color=red>There Are No User Categories Selected To Assign User Roles To For This User Profile</font></center><br>" ;
		?>
 
 </fieldset>
	 
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
		<a href="index.php?c=user_edit&id=<?php echo $id ?>" class="btn-small btn-color btn-pad">Exit Page</a><br>
      </p>
    </form>