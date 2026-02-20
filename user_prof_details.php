 <div id="content">
 <?php
				
	
			$id=$_GET['id'];
			$sql="SELECT * FROM _user WHERE id = $id";
			$line = $db->queryUniqueObject($sql);

			?>
	  <br />
      <legend>Employee's User Profile Details (View Only) </legend>
      
     <form action="" method="post">
	  <td width="185" height="48"><span style="color: blue;"><strong>Static Details</strong></span></td> 
	    <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

		<tr>
		   <td width="30%"><strong>Employee Name: </strong></td>
           <td width="70%"><?php echo $line->firstname.' '.$line->surname; ?></td>
         </tr>
		<tr>
           <td width="30%"><strong>System Access Username:</strong></td>
           <td width="70%"><?php echo $line->username; ?></td>
         </tr>  
         <tr>
           <td width="30%"><strong>User Group (Type):</strong></td>
           <td width="70%"><?php echo $line->user_type; ?></td>
         </tr>     
	 </table>

	  <td width="185" height="48"><span style="color: blue;"><strong>User Category </strong></span></td><br> 
	   
	  <input type="checkbox" readonly <?php if ($line->ex) echo "checked"; ?> /> Exec Management

      <input type="checkbox" readonly <?php if($line->fa)echo "checked";?>/> Finance and Accounting
		  
	  <input type="checkbox" readonly  <?php if($line->hra)echo "checked";?>/> HR Administration 

      <input type="checkbox" readonly  <?php if($line->ao)echo "checked";?>/> Office Administration 
	   
	  <input type="checkbox" readonly  <?php if($line->ita)echo "checked";?>/> IT Systems Admin  

	  <br><br><td width="185" height="48"><span style="color: blue;"><strong>User Roles </strong></span></td><br> 
	  
	 <TABLE class="table table-striped table-bordered" width="850px" border="1">
		<thead>
			<tr><th>User Category</th><th>Initiator</th><th>Approver</th><th>Inspector</th><th>Other</th><th>Applicable Modules</th></tr>
		</thead>
				
		<tbody>
		
		<?php if($line->ao == 1) {  ?>
		<TR>
			<TD>Office Administration</TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->a_init) echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->a_apro) echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->a_insp) echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->a_othr) echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, ATM, VLM<br/></span></TD>
		</TR>
		<?php  } if($line->hra == 1) {  ?>
		<TR>
			<TD>HR Adminstration</TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->h_init)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->h_apro)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->h_insp)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->h_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, LAM<br/></span></TD>
		</TR>
		<?php  } if($line->fa == 1) {  ?>
		<TR>
			<TD>Finance and Accounting</TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->f_init)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->f_apro)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->f_insp)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->f_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM, RPO, TAE<br/></span></TD>
		</TR>
		<?php  } if($line->ita == 1) {  ?>
		<TR>
			<TD>IT Systems Admin</TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->i_init)echo "checked";?> disabled/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->i_apro)echo "checked";?> disabled/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->i_insp)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->i_othr)echo "checked";?>/></TD>
			<TD><span style="color: blue;">CAM<br/></span></TD>
		</TR>
		<?php  } if($line->ex == 1) {  ?>
		<TR>
			<TD>Exec Management</TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->e_init)echo "checked";?> disabled/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->e_apro)echo "checked";?> disabled/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->e_insp)echo "checked";?>/></TD>
			<TD align="center"><input type="checkbox" readonly  <?php if($line->e_othr)echo "checked";?>/></TD>
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

     </form>
<div id="respond"></div>
		<p>
			<a href="index.php?c=user_admin" class="btn-small btn-color btn-pad">Back</a>
			
			</p>
    </div>