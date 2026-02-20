 <div id="content">
 <?php
				
	
				$id=$_GET['id'];
				$flag=$_GET['flag'];
				$sql="SELECT * FROM persons WHERE persons.id=$id";
			$line = $db->queryUniqueObject($sql);
			//echo $sql;	
		//		var_dump($line);
				?>
	  <br />
      <legend> 	  View Employee's Details </legend>
      
     <form action="" method="post">
	         <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

       	   <tr>
		  <td width="155" ><strong>Oracle Employee Number:
           </strong></td>
		   <td width="473"><?php echo $line->emp_number; ?></td>
         </tr>
		 <tr><td><strong>Employee First Name(s): </strong></td>
           <td><?php echo $line->firstname; ?></td>
         </tr>
		<tr>
           <td width="155"><strong>Employee Last Name(s):</strong></td>
           <td width="20"><?php echo $line->surname; ?></td>
         </tr>  
         <tr>
           <td width="155"><strong>Nat Identity Number:</strong></td>
           <td width="20"><?php echo $line->id_number; ?></td>
         </tr>     
		 <tr>
           <td><strong>Date of Birth: </strong></td>
           <td><?php echo $line->dob; ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Residential Address:</strong></td>
           <td width="20"><?php echo $line->address; ?></td>
         </tr>
		 <tr>
           <td width="155"><strong>Personal Contact Number:</strong></td>
           <td width="20"><?php echo $line->phone; ?></td>
         </tr>
             
       		<tr>
           <td><strong>Personal email Address: </strong></td>
           <td><?php echo $line->email; ?></td>
         </tr>
		 <tr>
           <td><strong>Passport  Number: </strong></td>
           <td><?php echo $line->passport_no; ?></td>
         </tr>
		
		 <tr>
           <td><strong>Next of Kin: </strong></td>
           <td><?php echo $line->next_kin; ?></td>
         </tr>
		 <tr>
           <td><strong>Next of Kin Contact: </strong></td>
           <td><?php echo $line->kin_no; ?></td>
         </tr>
		 
		 <tr>
           <td><strong>Department within WWF: </strong></td>
           <td><?php $dept = $db->queryUniqueObject( "SELECT * FROM  company_dept where code = '$line->department' and active = 1"); 
					 echo $dept->name; ?>
			</td>
         </tr>
      <tr>
           <td><strong>Departmental Hierarchy Level:</strong></td>
           <td><?php if($line->hierarchy_ind =="C") echo "Country Director Level" ; 
            if($line->hierarchy_ind =="E") echo "Executive Management" ; 
        if($line->hierarchy_ind =="H") echo "Head of Department" ; 
        if($line->hierarchy_ind =="M") echo "Supervisor / Line Manager" ; 
       if($line->hierarchy_ind =="S") echo "Staff Member (Applicant)" ; ?>
      </td>
         </tr>
		 <tr>
           <td><strong>Employment Designation: </strong></td>
           <td><?php echo $line->designation; ?></td>
         </tr>
         
		 <tr>
         <td><strong>Date Joined WWF: </strong></td>
           <td><?php echo $line->join_date; ?></td>
         </tr>
         
		 <tr>
         <td><strong>Engagement Type: </strong></td>
             <td><?php if($line->engagement_type =="FT-Fixed") {echo "Full Time - Fixed Term Contract" ;} 
			  elseif($line->engagement_type =="PT-Fixed") {echo "Part Time - Fixed Term Contract";}
			  elseif($line->engagement_type =="FT-Open") {echo "Full Time - Open Contract"; }
			  elseif($line->engagement_type =="PT-Open") {echo "Part Time - Open Contract"; }
			  elseif($line->engagement_type =="Intern") {echo "Intern";}
			  elseif($line->engagement_type =="Consultant") {echo "Consultant"; }
			  elseif($line->engagement_type =="Casual") {echo "Casual" ; }
			  elseif($line->engagement_type =="Volunteer") {echo "Volunteer" ; }
			  elseif($line->engagement_type =="Suspended") {echo "Suspended" ;} ?></td>
         </tr>
         
		 </table>
	   
     </form>
<div id="respond"></div>
		<br/><p>
			<a href="index.php?c=emp_admin&flag=<?php echo $flag; ?>" class="btn-small btn-color btn-pad">Back</a>
			
			</p>
    </div>