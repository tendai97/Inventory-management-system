<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="jquery-1.12.4.js"></script>
  <script src="jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>

      <br/><legend>Select Fleet Vehicle History View Coverage (Filter by)</legend>
<?php 

if(isset($_POST['cat']))
{
	$cat=mysql_real_escape_string($_POST['cat']);
	$sqlfilter="";
	
	if($cat=="dept"){
		$sqlfilter=mysql_real_escape_string($_POST['dept']);
		
	}
		if($cat=="employee"){
		$sqlfilter=mysql_real_escape_string($_POST['code1']);
		
	}
					
	if($cat=="type"){
		$sqlfilter=mysql_real_escape_string($_POST['veh_type']);
		
	}
	if($cat=="usage"){
		$sqlfilter=mysql_real_escape_string($_POST['veh_usage']);
		
	}

	if (isset($_POST['start']) AND ($_POST['start'])!="" AND isset($_POST['end']) AND ($_POST['end'])!="") 
		{
			$start = $_POST['start'];
			$end = $_POST['end'];

			?>
			<script language="javascript" type="text/javascript">
				window.location = "<?php echo "index.php?c=vehicles/filtered_vehicle_hist&retrv=range&start=$start&end=$end&cat=$cat&filt=$sqlfilter"; ?>";
			</script>
		<?php  }
		
	else { 

			?>
			<script language="javascript" type="text/javascript">
				window.location = "<?php echo "index.php?c=vehicles/filtered_vehicle_hist&retrv=full&cat=$cat&filt=$sqlfilter"; ?>";
			</script>
		<?php  } }	?>
		
<form method="post" action="">

<div class="col-lg-9 col-md-9">

<!--<input type="radio" name="cat" value="all">WWF  -->
<input type="radio" name="cat" value="dept"> Department 
<input type="radio" name="cat" value="employee"> Employee
<input type="radio" name="cat" value="type"> Vehicle Type 
<input type="radio" name="cat" value="usage"> Vehicle Usage



<!-- CSS -->
<style>
  .accordion-toggle {cursor: pointer;}
  .accordion-content {display: none;}
  .accordion-content.default {display: block;}
</style>

<!-- HTML -->
<div id="accordion">
  <h4 class="accordion-toggle-dept"></h4>
  <div class="accordion-content">
    
	<select name="dept" id="dept" class="form-control">
			 <option value="">Please Select a Department</option>
               
			   <?php
			   $result = mysql_query("SELECT * FROM company_dept where active = 1 ORDER by name");
		  	while($row = mysql_fetch_array($result))
			{
			   ?>
               <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
			   <?php } ?>
            </select>
  </div>
  <h4 class="accordion-toggle-employee"></h4>
  <div class="accordion-content">
    
		  <td width="800"><input type="text" id="code" placeholder="Enter a name to select (pick) Employee" class="form-control text-input"/></td>
			 <input name="code1" type="hidden" id="code1"  />
  </div>
 
  <h4 class="accordion-toggle-type"></h4>
  <div class="accordion-content">
    
	<select name="veh_type" id="veh_type" class="form-control">
			 <option value="">Please select a Vehicle Type </option>
              <?php
			 $vtype = $db->query( "SELECT * FROM  parameters where type = 'vehbody' and active = 1 ORDER BY name");
			 while($row = mysql_fetch_array($vtype))

		{if($row['code']== $line->veh_type)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
	
  </div>
  <h4 class="accordion-toggle-usage"></h4>
  <div class="accordion-content">
    
	<select name="veh_usage" id="veh_usage" class="form-control">
			 <option value="">Please select Vehicle Usage Category </option>
              <?php
			 $v_use = $db->query( "SELECT * FROM  parameters where type = 'vhcluse' and active = 1 ORDER BY name");
			 while($row = mysql_fetch_array($v_use))

		{if($row['code']== $line->veh_usage)
			echo ' <option value="'.$row['code'].'" selected>'.$row['name'].'</option>';
			else
			echo ' <option value="'.$row['code'].'" >'.$row['name'].'</option>';
			}
              ?>
            </select>
	
  </div>

<br/>
 		<tr>
            <td width="486"><font color = "purple"><strong>NOTE: Full History Will Be Retrieved If No Date Range Is Specified</strong></font></td>
         </tr><br/><br/>
		 <table width="797" border="0" cellspacing="0" cellpadding="0">
			
				<td>From Date: <input type="text" name="start"  placeholder="Enter Search Start Date" id="datepicker">   To Date: <input type="text" name="end"  placeholder="Enter Search End Date" id="datepicker1"></td>   
						   
	    </table>
<br/>
          
           <td>
             <input type="submit" name="Submit" value="Submit" class="btn-small btn-color btn-pad" /></td>
         
</div>   
</div>   
</form>
