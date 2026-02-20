 <div id="content">
 <?php
				
	
			$id=$_GET['id'];
			$src=$_GET['src'];
			$sql="SELECT * FROM activity_codes WHERE id=$id";
			$line = $db->queryUniqueObject($sql);
			//echo $sql;	
		//		var_dump($line);
				?>
	  <br />
      <legend> 	  Activity Code Details </legend>
      
     <form action="" method="post">
	         <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

       	<tr>
	     <td width="155" ><strong> Activity Code: </strong></td>
		   <td width="473"><?php echo $line->code; ?></td>
         </tr>
		 <tr>
		 <td width="155" ><strong>Description: </strong></td>
           <td width="473"><?php echo $line->description; ?></td>
         </tr>
         <tr>
           <td width="155"><strong>Status:</strong></td>
           <td width="473"><?php echo $line->status; ?></td>
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
           <td width="155"><strong>Budget Code:</strong></td>
           <td width="473"><?php echo $line->budget_code; ?></td>
         </tr>  
		 <tr>
           <td width="155"><strong>Budget Code Description: </strong></td>
           <td width="473"><?php $budj = $db->queryUniqueObject( "SELECT * FROM  budget_codes where code = '$line->budget_code' and active = 1"); 
					 echo $budj->description; ?>
		</td>
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
	
	</table>
	   
	   </form>
     <div align="justify"></div>
	<div id="respond"></div>
		<tr>
		    <td><?php if ($src == 'act') { ?> <a href="index.php?c=activity_code_admin" class="btn-small btn-color btn-pad">Exit</a></td> 
			<?php } else { ?> <a href="index.php?c=budgetcde_detail&id=<?php echo $budj->id; ?>" class="btn-small btn-color btn-pad">Exit</a></td>
			<?php } ?>
		</tr>

    </div>