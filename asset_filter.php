
      <legend>Select Assets View Coverage (Filter by)</legend>
<?php 

if(isset($_POST['cat']))
{
	$cat=mysql_real_escape_string($_POST['cat']);
	$sqlfilter="";
	
	if($cat=="project"){
		$sqlfilter=mysql_real_escape_string($_POST['project']);
		
	}
	if($cat=="dept"){
		$sqlfilter=mysql_real_escape_string($_POST['company_dept']);
		
	}
	if($cat=="AC"){
		$sqlfilter=mysql_real_escape_string($_POST['asset_group']);
		
	}
	if($cat=="AT"){
		$sqlfilter=mysql_real_escape_string($_POST['asset_type']);
		
	}
		if($cat=="custodian"){
		$sqlfilter=mysql_real_escape_string($_POST['code1']);
		
	}
					
		?>
		<script language="javascript" type="text/javascript">
window.location = "<?php echo "index.php?c=filtered_assets&cat=$cat&filt=$sqlfilter"; ?>";
</script>
<?php
}
?>
<form method="post" action="">

<div class="col-lg-7 col-md-7">

<!--<input type="radio" name="cat" value="all">WWF  -->
<input type="radio" name="cat" value="project">Project 
<input type="radio" name="cat" value="dept"> Department 
<input type="radio" name="cat" value="AC"> Asset Class 
<input type="radio" name="cat" value="AT"> Asset Type 
<input type="radio" name="cat" value="custodian"> Custodian



<!-- CSS -->
<style>
  .accordion-toggle {cursor: pointer;}
  .accordion-content {display: none;}
  .accordion-content.default {display: block;}
</style>

<!-- HTML -->
<div id="accordion">
  <h4 class="accordion-toggle-project"></h4>
  <div class="accordion-content ">
    
	<select name="project" id="region" class="form-control">
			 <option value="">Please Select a Project</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM projects where active=1");
		  	while($row = mysql_fetch_array($result))
			{
			   ?>
               <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
			   <?php } ?>
            </select>
			
  </div>
  <h4 class="accordion-toggle-dept"></h4>
  <div class="accordion-content">
    
	<select name="company_dept" id="region" class="form-control">
			 <option value="">Please Select a Department</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM company_dept where active=1");
		  	while($row = mysql_fetch_array($result))
			{
			   ?>
               <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
			   <?php } ?>
            </select>
	
  </div>
  <h4 class="accordion-toggle-AC"></h4>
  <div class="accordion-content">
    
	<select name="asset_group" id="category" class="form-control">
			 <option value="">Please select a Asset Class </option>
              <?php
			 $cost_centre=$db->query( "SELECT * FROM  asset_group where active=1 ORDER BY name");
			 while($row = mysql_fetch_array($cost_centre))

		{if($row['code']== $line->asset_group)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
	
  </div>
  <h4 class="accordion-toggle-AT"></h4>
  <div class="accordion-content">
    
	<select name="asset_type" id="category" class="form-control">
			 <option value="">Please select a Asset Type </option>
              <?php
			 $asset_type=$db->query( "SELECT * FROM  asset_type where active=1 ORDER BY name");
			 while($row = mysql_fetch_array($asset_type))

		{if($row['code']== $line->asset_type)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
	
  </div>
  <h4 class="accordion-toggle-custodian"></h4>
  <div class="accordion-content">
    
		  <td width="800"><input type="text" id="code" placeholder="Enter a name to select (pick) Custodian" class="form-control text-input"/></td>
			 <input name="code1" type="hidden" id="code1"  />
	
  </div>
 

<br/>
          
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
         
</div>   
</div>   
</form>
