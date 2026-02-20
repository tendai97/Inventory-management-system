 <p><br/></p>
      <legend>Departmental Selection Menu For Bulletin Posting</legend>  

  <?php

    $author = $_SESSION [SITE_NAME]["person"];
	//$dept = $_POST['dept_check'] ; 

	if ((isset($_POST['dept_check'])) && ($_POST['dept_check'] == "hra")) {
		
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=create_article&dept=hra&auth=$author\";
			</script>";
		}

	elseif ((isset($_POST['dept_check'])) && ($_POST['dept_check'] == "fad")) {
		
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=create_article&dept=fad&auth=$author\";
			</script>";
		}

	elseif ((isset($_POST['dept_check'])) && ($_POST['dept_check'] == "prj")) {
		
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=create_article&dept=prj&auth=$author\";
			</script>";
		}
	
	elseif ((isset($_POST['ini'])) && (!isset($_POST['dept_check']))) {
			
			echo "<font color=red><strong> ****** No Department Selected - Please Make A Valid Selection Or EXIT This Page ******</strong></font><br>"; 

	} else {}		
		
				?>
				
				<form action="" method="post">
     <fieldset> 
	   <input name="ini" type="hidden"  value="S"/>
	<td>You Are Logged On As: <input type="text" value="<?php echo $_SESSION[SITE_NAME]['fname']." ".$_SESSION[SITE_NAME]['sname'] ; ?>" name="user" class="form-control" style="width: 250px;" readonly/><span style="color: blue;">(Logout And Login Again If Necessary)</span></td>  
	<br/><br/>
	<td><span style="color: blue;">Select A Department To Create An Article For :-  </span></td>
	<br/><br/>

	 <TABLE class="table table-striped table-bordered" width="850px" border="1">
		<thead>
			<tr><th>Select</th><th>Department</th><th>Status</th><th>Comments</th></tr>
		</thead>
				
		<tbody>
		
		<TR>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['hra'] == "1") { ?> <INPUT type="radio" name="dept_check" value="hra"/> <?php } else { ?> <INPUT type="radio" name="dept_check" disabled> <?php } ?> </TD>
			<TD>Human Resources Dept</TD>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['hra'] == "1") { echo "<font color=green>Applicable</font>"; } else { echo "<font color=red>Not Applicable</font>"; } ?> </TD>
			<TD><span style="color: blue;">Select and input details of Human Resources Article ONLY<br/></span></TD>
		</TR>
		<TR>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['fa'] == "1") { ?> <INPUT type="radio" name="dept_check" value="fad"/> <?php } else { ?> <INPUT type="radio" name="dept_check" disabled> <?php } ?> </TD>
			<TD>Finance Department</TD>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['fa'] == "1") { echo "<font color=green>Applicable</font>"; } else { echo "<font color=red>Not Applicable</font>"; } ?> </TD>
			<TD><span style="color: blue;">Select and input details of Finance Department Article ONLY<br/></span></TD>
		</TR>
		<TR>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['ao'] == "1") { ?> <INPUT type="radio" name="dept_check" value="prj"/> <?php } else { ?> <INPUT type="radio" name="dept_check" disabled> <?php } ?> </TD>
			<TD>Conservation Projects</TD>
			<TD><?php 
				if ($_SESSION[SITE_NAME]['ao'] == "1") { echo "<font color=green>Applicable</font>"; } else { echo "<font color=red>Not Applicable</font>"; } ?> </TD>
			<TD><span style="color: blue;">Select and input details of Conservation Projects Article ONLY<br/></span></TD>
		</TR>

		</tbody>
						
	</TABLE>
	  </fieldset>
	 
      <p>
        <input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />
		<a href="index.php?c=bulletin_admin" class="btn-small btn-color btn-pad">Exit Page</a><br>
      </p>
    </form>