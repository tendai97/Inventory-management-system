 <div id="content">
 <?php
				
	
			$id=$_GET['id'];
			$src=$_GET['src'];
			$sql="SELECT * FROM budget_codes WHERE id=$id";
			$line = $db->queryUniqueObject($sql);
			//echo $sql;	
		//		var_dump($line);
				?>
	  <br />
      <legend> 	  Budget Code Details </legend>
      
     <form action="" method="post">
	         <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

       	<tr>
	     <td width="155" ><strong> Budget Code: </strong></td>
		   <td width="473"><?php echo $line->code; ?></td>
         </tr>
		 <tr>
		 <td width="155" ><strong>Description: </strong></td>
           <td width="473"><?php echo $line->description; ?></td>
         </tr>
		<tr>
           <td width="155"><strong>Project Code:</strong></td>
           <td width="473"><?php echo $line->project_code; ?></td>
         </tr>  
		 <tr>
           <td width="155"><strong>Project Name: </strong></td>
           <td width="473"><?php $proj = $db->queryUniqueObject( "SELECT * FROM  projects where code = '$line->project_code' and active = 1"); 
					 echo $proj->name; ?>
			</td>
         </tr>
         <tr>
           <td width="155"><strong>Status:</strong></td>
           <td width="473"><?php echo $line->status; ?></td>
         </tr>     
         <tr>
           <td width="155"><strong>Donor_name:</strong></td>
           <td width="473"><?php echo $line->donor_name; ?></td>
         </tr>     
		 <tr>
           <td width="155"><strong>Telephone Contacts: </strong></td>
           <td width="473"><?php echo $line->tele_contacts; ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Original Allocation Amount:</strong></td>
           <td width="473"><?php echo "$".$line->allocation; ?></td>
         </tr>
         <tr>
           <td width="155"><strong>Date of Allocation:</strong></td>
           <td width="20"><?php echo $line->alloc_date; ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Allocation Spent To-Date:</strong></td>
           <td width="473"><?php echo "$".$line->alloc_expended; ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Balance of Allocation:</strong></td>
           <td width="473"><?php echo "$".$line->alloc_balance; ?></td>
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
	
	</table>
	   
	<?php 
		
		$sql = "SELECT * FROM activity_codes WHERE active = 1 and budget_code = $line->code";
			$result = mysql_query($sql);
			
		   ?> 
		   <br><legend>Associated Activity Codes: </legend> 

		                <table class="table table-striped table-bordered">
                            <thead>
                              <tr>
							    	<th>Activity Code</th>
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
                                
							  <td><a href="index.php?c=activitycde_detail&id=<?php echo  $rows['id'];?>&src=bdj"><?php echo $rows['code']; ?></a></td>
							  <td><?php echo $rows['description'];?></td>
							  <td><?php echo $rows['allocation'];?></td>
							  <td><?php echo $rows['status'];?></td>
							  <td><a href="index.php?c=activitycde_detail&id=<?php echo  $rows['id'];?>&src=bdj">[View Details]</a></td>
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
			<?php } else { ?> <a href="index.php?c=project_detail&id=<?php echo $proj->id; ?>" class="btn-small btn-color btn-pad">Exit</a></td>
			<?php } ?>
		</tr>

    </div>