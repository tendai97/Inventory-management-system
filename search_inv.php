<div id="content">

      <legend>Select Inspection Coverage</legend>
<?php 

if(isset($_POST['cat']))
{
	$cat=mysql_real_escape_string($_POST['cat']);
	$sqlfilter="";
	
	if($cat=="all"){
		$sqlfilter="";
		
	}
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
window.location = "<?php echo "index.php?c=card"; ?>";
</script>
<?php
}
?>
<form class ="accountNo" method="post" action="index.php?c=location">

<input type="radio" name="cat" value="AC"> Inventory Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="cat" value="AT"> Inventory Name



<!-- CSS -->
<style>
  .accordion-toggle {cursor: pointer;}
  .accordion-content {display: none;}
  .accordion-content.default {display: block;}
</style>

<!-- HTML -->
<div id="accordion">
  <h4 class="accordion-toggle-project"></h4>
  
  <h4 class="accordion-toggle-AC"></h4>
  <div class="accordion-content">
    
	<select name="asset_group" id="category" class="form-control">
			 <option value="">Please select a Asset Class </option>
              <?php
			 $cost_centre=$db->query( "SELECT * FROM  categories where active=1 ORDER BY name");
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
			 $asset_type=$db->query( "SELECT * FROM  assets where active=1 ORDER BY name");
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
    
	<input  type="text" id="code"  class="validate[required,length[0,100]] text-input form-control"  />
		   <input name="code1" type="hidden" id="code1"  />
	
  </div>
 
</div>
<table>
<tr>
           
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
         </tr>
		 </table>
   
</form>


</div>