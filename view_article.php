 <div id="content">
 <?php
	
			$id = $_GET['id'];
			$line = $db->queryUniqueObject("SELECT * FROM bulletin_posts WHERE id = '$id'");
			$line2 = $db->queryUniqueObject("SELECT * FROM persons WHERE id = '$line->author_id'");
			
				?>
	  <br />
      <legend>Full Details Of Staff Bulletin Article</legend>
      
     <form action="" method="post">
	<fieldset>
	    <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

		 <tr>
		   <td width="37%" ><strong>Department of Article:</strong></td>
		   <td><?php echo $line->dept_of_article; ?></td>
         </tr>		 
       	<tr>
		  <td width="37%" ><strong>Authored By:</strong></td>
		   <td width="63%"><?php echo $line2->firstname.' '.$line2->surname; ?></td>
         </tr>
		<tr>
		   <td width="37%"><strong>Article Title (Header): </strong></td>
		   <td><?php echo $line->title; ?></td>
         </tr>  
		<tr>
		   <td width="37%"><strong>Article Test Message: </strong></td>
		   <td><?php echo $line->post; ?></td>
         </tr>  
         <tr>
           <td width="37%"><strong>Date Posted:</strong></td>
           <td><?php echo $line->date_posted; ?></td>
         </tr>     
         <tr>
           <td width="37%"><strong>Date of Expiry:</strong></td>
           <td><?php echo $line->date_of_expiry; ?></td>
         </tr>     
         <tr>
           <td width="37%"><strong>Date Article Last Edited:</strong></td>
           <td><?php echo $line->date_last_edit; ?></td>
         </tr>     
		 <tr>
			<td width="37%"><strong>Status: </strong></td>
			<td><?php if ($line->publish == 'Y') echo "Published"; else echo "Not Published"; ?></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>

       </table><br/>
	  </fieldset>
	   
	     <tr>
			<td><a href="index.php?c=bulletin_admin" class="btn-small btn-color btn-pad">Close</a><br><br>
	     </tr>
		 
     </form>
     <div align="justify"></div>
<div id="respond"></div>


    </div>