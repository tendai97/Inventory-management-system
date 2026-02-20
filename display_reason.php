 <div id="content">
 <?php
				
	
		$id=$_GET['id'];
		$src=$_GET['src'];
 	    if ($src == 'Emp') $line = $db->queryUniqueObject("SELECT * FROM persons WHERE id = $id"); 
		elseif ($src == 'Proj') $line = $db->queryUniqueObject("SELECT * FROM projects WHERE id = $id"); 
		elseif ($src == 'Supp') $line = $db->queryUniqueObject("SELECT * FROM supplier_partner WHERE id = $id"); 
		elseif ($src == 'Asset') $line = $db->queryUniqueObject("SELECT * FROM assets WHERE id = $id"); 
 	    else $line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id = $id");

				?>
	  <br />
      <legend>Reason For Inactive Status</legend><br />  
      
     <form action="" method="post">

	 <?php if ($src == 'Asset')  {  ?>
		  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
				<input class="form-control" value="Date of Deactivation/Disposal:- <?php echo $line->disposal_date ;?>" readonly/>
		  </div>
		  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
				<textarea  rows="2" cols="50"  class="form-control"  name="reason" id="reason"  readonly/><?php echo $line->d_method; ?></textarea>
		  </div><br>
	 <?php }  else  {  ?>
	   	<textarea  rows="2" cols="112"   name="reason" id="reason"  readonly/><?php echo $line->deactv_reason; ?></textarea>
	 <?php } ?>
	   
      <br /> 
	   
     </form>
         
<div id="respond"></div>
		<br/><p>

		<?php if ($src == 'Emp') { ?> 
			<a href="index.php?c=emp_admin&flag=D" class="btn-small btn-color btn-pad">Back</a>
		<?php }  elseif ($src == 'Proj') { ?> 
			<a href="index.php?c=project_admin&flag=D" class="btn-small btn-color btn-pad">Back</a>
		<?php }  elseif ($src == 'Supp') { ?> 
			<a href="index.php?c=partner_admin&flag=D" class="btn-small btn-color btn-pad">Back</a>
		<?php }  elseif ($src == 'Asset') { ?> 
			<a href="index.php?c=inactive_assets" class="btn-small btn-color btn-pad">Back</a>
		<?php }  else  {  ?>
			<a href="index.php?c=dept_admin&flag=D" class="btn-small btn-color btn-pad">Back</a>
		<?php }  ?>

			</p>
    </div>