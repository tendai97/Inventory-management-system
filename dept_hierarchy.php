<div id="content">
      <legend>SET DEPARTMENTAL AUTHORISATION HIERARCHY</legend>
      <?php 
	   
	  $line="";
	  $line = $db->queryUniqueObject("SELECT * FROM company_dept  WHERE id=".$_GET['id']);
			
	  if(isset($_GET['id']) && isset($_POST['name']))
	  {
		 $name=$_POST['name'];
		 if($_POST['AO']=="on"){$emp=1;}else{$emp=0;}
		 if($_POST['HRA']=="on"){$super=1;}else{$super=0;}
		 if($_POST['FA']=="on"){$hod=1;}else{$hod=0;}
		 if($_POST['EX']=="on"){$exec=1;}else{$exec=0;}
			 
		 $db->query("UPDATE company_dept  SET exec = '$exec', super = '$super', hod = '$hod', emp = '$emp', updTS = NOW(), updU='".$_SESSION[SITE_NAME]['username']."' where id=".$_GET['id']);
						
					echo "<br><font color=green size=+1 >  $name:- Departmental Hierarchy Successfully Updated!</font>" ;
					 	
				$line = $db->queryUniqueObject("SELECT * FROM company_dept WHERE id=".$_GET['id']);
			}
				
				?>
     <form action="" method="post">
      
	    
	  <tr>
	   <td width="185" height="48"><span style="color: blue;">Name of Department:</span></td>
	   <td width="200"><input name="name" class="form-control" id="name" value="<?php echo $line->name?>" readonly/></td>
	   </tr><br/>
	   <tr>
	   <td width="185" height="48"><span style="color: blue;">Description:</span></td>
	   <td width="200"><input name="description" class="form-control" id="description" value="<?php echo $line->description?>" readonly/></td>
	   </tr>
	   <br/><br/>
	 
	  <span style="color: blue;">Select All Applicable Authorisation Levels - (Employee Checkbox Always Ticked As Default) </span><br> <br />
	   
	  <input name="EX" type="checkbox" id="has_image" <?php if ($line->exec == 1) echo "checked"; ?> /> Exec Management
	 	
      <input name="FA" type="checkbox" id="has_image" <?php if($line->hod == 1)echo "checked";?>/> Head of Department
	  
	  <input name="HRA" type="checkbox" id="has_image" <?php if($line->super == 1)echo "checked";?>/> Immediate Supervisor 

      <input name="AO" type="checkbox" id="has_image" <?php echo "checked";?> readonly/> Employee (Applicant) 
	   
	  <!--input name="ITA" type="checkbox" id="has_image" class="has_image"  <!?php if($line->ita)echo "checked";?>/> IT Systems Admin  
	  
	  <!--div id="addtional1" <!?php if(!isset($_GET['id']) || $line->ex == 0 ||  $line->fa == 0|| $line->hra == 0|| $line->ao == 0|| $line->ita == 0){?> style="display: none;" <!?php } else {?> style="display: block;"  <!?php }?>  style=" visibility: hidden;" class="boxfield" >
	<!--<textarea  rows="5" cols="80" name="textural" placeholder="Text to be Appended to Test"><!?php echo $line->textural;?></textarea>
	<br><br>
	<img  width="100" height="120" src="upload/test_img/testimg<!?php echo $_GET['id'].".".$line->extention;?>" alt="No Image"/>
	<input type="file" name="image" >-->
	<br/><br/>
	
	 
	<!--fieldset>

	<legend>Asset Module</legend>
	
	<input name="ini" type="checkbox" class=""  <!?php if($line->a_init)echo "checked";?>/> Initate 
	  <input name="app" type="checkbox" class=""  <!?php if($line->a_apro)echo "checked";?>/> Approve
      <input name="ins" type="checkbox" class=""  <!?php if($line->a_insp)echo "checked";?>/> Inspect
	  <input name="oth" type="checkbox" class=""  <!?php if($line->a_othr)echo "checked";?>/> Other
	
	</fieldset>
	</div>
   <br /><br />
		<tr>
           <!--td align="right"><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td-->
           <td>
             <input type="submit" name="Submit" value="Save" class="btn-small btn-color btn-pad" /></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
   
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>