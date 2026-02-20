 <div id="content">
 <?php
				
			$src=$_GET['src'];
			$id=$_GET['id'];
			$sql="SELECT * FROM projects WHERE id=$id";
			$line = $db->queryUniqueObject($sql);
			//echo $sql;	
		//		var_dump($line);
				?>
	  <br />
      <legend> 	  Project Details </legend>
      
     <form action="" method="post">
	    <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

       	 <tr>
		  <td width="155" ><strong>Project Code:
           </strong></td>
		   <td width="473"><?php echo $line->code; ?></td>
         </tr>
		 <tr><td><strong>Project Name: </strong></td>
           <td><?php echo $line->name; ?></td>
         </tr>
		 <tr><td><strong>Description: </strong></td>
           <td><?php echo $line->description; ?></td>
         </tr>
		<tr>
           <td width="155"><strong>Location:</strong></td>
           <td width="20"><?php echo $line->location; ?></td>
         </tr>  
         <tr>
           <td width="155"><strong>Donor:</strong></td>
           <td width="20"><?php echo $line->donor; ?></td>
         </tr>     
		 <tr>
           <td><strong>Budget Code: </strong></td>
           <td><?php echo $line->budget_code; ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Budget Holder:</strong></td>
           <td width="20"><?php echo $line->budget; ?></td>
         </tr>
		 
            <tr>
           <td width="155"><strong>Holder's Contacts:</strong></td>
           <td width="20"><?php echo $line->contacts.",&nbsp;&nbsp;&nbsp;".$line->email; ?></td>
         </tr>
		 <tr>
         <td><strong>WWF Admin & email: </strong></td>
           <td><?php echo $line->wwf_admin.",&nbsp;&nbsp;&nbsp;".$line->wwf_admemail; ?></td>
         </tr>
       	 <tr>
           <td><strong>Donor Manager & email: </strong></td>
           <td><?php echo $line->donor_mgr.",&nbsp;&nbsp;&nbsp;".$line->donor_mgremail; ?></td>
         </tr>
		 <tr>
           <td><strong>Donor Admin & email: </strong></td>
           <td><?php echo $line->donor_admin.",&nbsp;&nbsp;&nbsp;".$line->donor_admemail; ?></td>
         </tr>
		 <tr>
           <td><strong>Project Start Date: </strong></td>
           <td><?php echo $line->start_date; ?></td>
         </tr>
		 <tr>
           <td><strong>Project End Date: </strong></td>
           <td><?php echo $line->end_date; ?></td>
         </tr>
	
	</table>
	<?php 
		
		$sql = "SELECT * FROM budget_codes WHERE active = 1 and project_code = $line->code";
			$result = mysql_query($sql);
			
		   ?> 
		   <br><legend>Associated Budget Codes: </legend> 

		                <table class="table table-striped table-bordered">
                            <thead>
                              <tr>
							    	<th>Budget Code</th>
							        <th>Description</th>
							    	<th>Allocation</th>
							    	<th>Status</th>
							    	<th>Action</th>
                              </tr>
                           </thead>
                            <tbody>
							<?php 
								while($rows = mysql_fetch_array($result))
							{ 
							//var_dump();
								?>
                              <tr>
                                
							  <td><a href="index.php?c=budgetcde_detail&id=<?php echo  $rows['id'];?>&src=prj"><?php echo $rows['code']; ?></a></td>
							  <td><?php echo $rows['description'];?></td>
							  <td><?php echo $rows['allocation'];?></td>
							  <td><?php echo $rows['status'];?></td>
							  <td><a href="index.php?c=budgetcde_detail&id=<?php echo  $rows['id'];?>&src=prj">[View Details]</a></td>
							  </tr>
							                           							
							<?php 
							} ?> 
						</tbody>	
			</table>				  
	   
     </form>
     <div align="justify"></div>
	<div id="respond"></div>
		<tr>
		    <td><?php if ($src == 'bdj') { ?> <a href="index.php?c=budget_code_admin" class="btn-small btn-color btn-pad">Exit</a></td> 
			<?php } else { ?> <a href="index.php?c=project_admin&flag=A" class="btn-small btn-color btn-pad">Exit</a></td>
			<?php } ?>
		</tr>

    </div>