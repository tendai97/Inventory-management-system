 <div id="content">
 <?php
				
	
				$id=$_GET['id'];
				$sql="SELECT *,assets.asset_description des,asset_group.name AS agdes,asset_type.`name` AS atdes FROM assets  INNER JOIN `asset_type` ON `asset_type`=asset_type.`code` INNER JOIN `asset_group` ON `asset_group` = asset_group.`code` WHERE assets.id=$id";
			$line = $db->queryUniqueObject($sql);
			//echo $sql;	
			//var_dump($line);
				?>
	  <br />
      <legend> 	  Asset Details </legend>
      
     <form action="" method="post">
	         <td align="center"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">

       	   <tr>
		  <td width="155" ><strong>Asset Number:
           </strong></td>
		   <td width="473"><?php echo $line->assert_no; ?></td>
         </tr>
		 <tr><td><strong>Description: </strong></td>
           <td><?php echo $line->des; ?></td>
         </tr>
		<tr>
           <td width="155"><strong>Asset Class:</strong></td>
           <td width="20"><?php echo $line->agdes; ?></td>
         </tr>  
         <tr>
           <td width="155"><strong>Asset Type:</strong></td>
           <td width="20"><?php echo $line->atdes; ?></td>
         </tr>     
		 <tr>
           <td><strong>Allocation Status: </strong></td>
           <td><?php echo $line->alloc_status; ?></td>
         </tr>
		 <tr>
		 <td><strong>Custodian: </strong></td>
			<td><?php 
				$temp = $line->custodian;
				$sql="SELECT * FROM  persons where id = '$temp' and active = 1";
				$line2 = $db->queryUniqueObject($sql);
			 	echo $line2->firstname.' '.$line2->surname;
             ?></td>
         </tr>
		   <tr>
           <td width="155"><strong>Allocation Project :</strong></td>
           <td width="20"><?php echo $line->alloc_project; ?></td>
         </tr>
		 <tr>
           <td width="155"><strong>Allocation Department :</strong></td>
           <td width="20"><?php echo $line->alloc_dept; ?></td>
         </tr>
             
       		<tr>
           <td><strong>Procurement Date: </strong></td>
           <td><?php echo $line->purchase_date; ?></td>
         </tr>
		 <tr>
           <td><strong>Intial Value: </strong></td>
           <td>$<?php echo number_format($line->cost_price,2); ?></td>
         </tr>
		
		 <tr>
           <td><strong>Supplier: </strong></td>
			<td><?php 
				$temp = $line->supplier;
				$sql="SELECT * FROM  supplier_partner where id = '$temp' and active = 1";
				$line2 = $db->queryUniqueObject($sql);
			 	echo $line2->name;
             ?></td>
			 </tr>
		 <tr>
           <td><strong>Serial Number: </strong></td>
           <td><?php echo $line->serial_no; ?></td>
         </tr>
	
		
		 
		 <tr>
           <td><strong>Comments / Physical Asset Location: </strong></td>
           <td><?php echo $line->location; ?></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
		 <tr>
		 <td><strong>Image :</strong></td>
		 <td>
		<img width="125" height="125" alt="" <?php if($line->image!='') echo "src='upload/profile/$line->assert_no.$line->image'"; else echo "src='images/logo2.gif'"; ?> class="imgr">
	   
		</td>

		 </tr>
       </table>
	   
     </form>
     <div align="justify"></div>
<div id="respond"></div>


    </div>