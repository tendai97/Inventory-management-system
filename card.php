 <div id="content">
  <?php 
if(isset($_GET['vid'])){
	$_SESSION[SITE_NAME]['visit']=$_GET['vid'];
	$_SESSION[SITE_NAME]['value']=$_GET['vv'];
	$_SESSION[SITE_NAME]['cat']=$_GET['cat'];
}

  if(isset($_POST['notes']) && $_POST['notes'] !=''){
  	$n= $_POST['notes'];
  	$i= $_SESSION['a_no'];
  	$sql= "Update visit_assets set observations='$n' where asset_no='".$_SESSION['a_no']."' and visit='".$_SESSION[SITE_NAME]['visit']."'";
  	mysql_query($sql);
  	echo "<font color=red> Next Asset !!! </font>";
  }
  if(isset($_POST['asset_no']))
{

	  $asset_no=mysql_real_escape_string($_POST['asset_no']);
	  $invalid_count=0;
	  
 $sqlfilter="";
 switch($_SESSION[SITE_NAME]['cat']){
	
	case 'project':
		$sqlfilter="  AND project = '".$_SESSION[SITE_NAME]['value']."'";
		$reason="Project Incorrect !!!!";
	break;

	case 'dept':
		$sqlfilter=" AND dept = '".$_SESSION[SITE_NAME]['value']."'";
		$reason="Department Incorrect !!!!";
	break;
	
	case 'AC':
		$sqlfilter=" AND asset_group ='".$_SESSION[SITE_NAME]['value']."'";
		$reason="Asset Class Incorrect !!!!";
	break;
	
	case 'AT':
		$sqlfilter=" AND asset_type = '".$_SESSION[SITE_NAME]['value']."'";
		$reason="Asset Type Incorrect !!!!";
	break;
	
	case 'custodian':
		$sqlfilter=" AND custodian = '".$_SESSION[SITE_NAME]['value']."'";
		$reason="Custodian Incorrect !!!!";
	break;
	 
 }
 //check if it has been scanned before
 $count = $db->countOf("visit_assets", "asset_no='$asset_no' AND visit='".$_SESSION[SITE_NAME]['visit']."'");
							
if($count > 0)
{
	echo "<font color=red> Asset  ($asset_no) has been scanned already, Next asset!!</font>";
}
else{
	//for inspecting the whole of wwf
	if($_SESSION[SITE_NAME]['cat']=="all"){
		if(strlen($asset_no) == 12){
			$counts = $db->countOf("assets","assert_no='$asset_no'");
			if($counts <= 0 ){

			$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Asset No incorrect !',1)");
			echo "<br><font color=red size=+1 >Asset No incorrect !</font>" ;
			}
			else{
			$ag=ltrim(substr($asset_no,0,4),0);
				
				$result = mysql_query("SELECT id FROM asset_group WHERE code = '$ag'");
				if(mysql_num_rows($result) > 0 ) {
				
					$at=ltrim(substr($asset_no,4,4),0);
				
					$result = mysql_query("SELECT id FROM asset_type WHERE code = '$at'");
					if(mysql_num_rows($result) > 0 ) {
				
						$seq=ltrim(substr($asset_no,8,4),0);
						if( is_numeric ($seq)) {
							$result = mysql_query("SELECT * FROM asset_allocation WHERE asset = '$asset_no' AND active = 1 AND event = 'Allocated' $sqlfilter");
						
								$_SESSION['a_no']= $asset_no;
								$linea = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$asset_no."'");
								while ($www= mysql_fetch_array($result)) {
									# code...
									# 
								$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE id = ".$www['custodian']);
								$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'Y',1)");
								echo "<font color=red size=+1 >Match Found</font>" ;
								?>
								<form class ="assetno" method="post" action="index.php?c=card">

								<table class="table table-striped table-bordered" width="100%" border="1">
				               <legend> Recorded Asset Information</legend>
							      <tr>
							          <td align="center" width="5%"><b>ID</b></td>
							          <td align="center" width="5%"><b>Asset Number</b></td>
							          <td align="center" width="27%"><b>Description</b></td>
							          <td align="center" width="7%"><b>Allocation Date</b></td>
							          <td align="center" width="7%"><b>Project</b></td>
							          <td align="center" width="7%"><b>Department</b></td>
							          <td align="center" width="7%"><b>Custodian</b></td>
							      </tr>
							      <tr>
							      <td><?php echo $www['id'];?></td>
						          <td><?php echo $www['asset'] ; ?></td>
						          <td align="center"><?php echo $linea->asset_description; ?></td>
						          <td align="center"><?php echo $www['insTS'] ; ?></td>
						          <td align="center"><?php echo $www['project'] ; ?></td>
						          <td align="center"><?php echo $www['dept'] ; ?></td>
						          <td align="center"><?php echo $admin->firstname . " " . $admin->surname ; ?></td>
						          </tr>
						          </table>
						      </form>
						  </div>
								<?php } 
								 ?>

				<form method="post" action="">
					<legend>Inspection Observations</legend>
					<label>Conditions / Notes : <font color="green"> *Optional</font></label><br>
					<textarea cols="" rows="4" class="form-control text-input" name="notes"></textarea><br>
					<input type="submit" value="Submit" class="btn btn-primary"></td>
				</form>
				<?php
							}
						else {
							echo "<br><font color=red size=+1 >Sequence incorrect !</font>" ;
						
							$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Sequence incorrect !',1)");
							}
					}
					else{
						echo "<br><font color=red size=+1 >Asset type incorrect !</font>" ;
						
						$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Cost Centre incorrect !',1)");
						
					
					}
				}
				else {
						echo "<br><font color=red size=+1 >Asset Group incorrect !</font>" ;
						
						$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Cost Centre incorrect !',1)");
				}
					
			
		}
	}
	else{
			
			$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Asset No incorrect !',1)");
			echo "<br><font color=red size=+1 >Asset No incorrect !</font>" ;
		}
	}
	
	// for inspecting allocated goods
	else{
		if(strlen($asset_no) == 12){
			$counts = $db->countOf("assets","assert_no='$asset_no'");
			if($counts <= 0 ){

			$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Asset No incorrect !',1)");
			echo "<br><font color=red size=+1 >Asset No incorrect !</font>" ;
			}
			else{
$result = mysql_query("SELECT * FROM asset_allocation WHERE asset = '$asset_no' AND active = 1 AND event = 'Allocated' $sqlfilter");
			
			if(mysql_num_rows($result) > 0) {
				//
				$_SESSION['a_no']= $asset_no;
				$linea = $db->queryUniqueObject("SELECT * FROM assets WHERE active = 1 and assert_no = '".$asset_no."'");
				while ($www= mysql_fetch_array($result)) {
					# code...
					# 
				$admin = $db->queryUniqueObject("SELECT * FROM persons WHERE id = ".$www['custodian']);
				$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'Y',1)");
				echo "<font color=red size=+1 >Match Found</font>" ;
				?>
				<form class ="assetno" method="post" action="index.php?c=card">

				<table class="table table-striped table-bordered" width="100%" border="1">
               <legend> Recorded Asset Information</legend>
			      <tr>
			          <td align="center" width="5%"><b>ID</b></td>
			          <td align="center" width="5%"><b>Asset Number</b></td>
			          <td align="center" width="27%"><b>Description</b></td>
			          <td align="center" width="7%"><b>Allocation Date</b></td>
			          <td align="center" width="7%"><b>Project</b></td>
			          <td align="center" width="7%"><b>Department</b></td>
			          <td align="center" width="7%"><b>Custodian</b></td>
			      </tr>
			      <tr>
			      <td><?php echo $www['id'];?></td>
		          <td><?php echo $www['asset'] ; ?></td>
		          <td align="center"><?php echo $linea->asset_description; ?></td>
		          <td align="center"><?php echo $www['insTS'] ; ?></td>
		          <td align="center"><?php echo $www['project'] ; ?></td>
		          <td align="center"><?php echo $www['dept'] ; ?></td>
		          <td align="center"><?php echo $admin->firstname . " " . $admin->surname ; ?></td>
		          </tr>
		          </table>
		      </form>
		  </div>
				<?php } ?>

				<form method="post" action="">
					<legend>Inspection Observations</legend>
					<label>Conditions / Notes : <font color="green"> *Optional</font></label><br>
					<textarea cols="" rows="4" class="form-control text-input" name="notes"></textarea><br>
					<input type="submit" value="Submit" class="btn btn-primary"></td>
				</form>
				<?php
			}
			else{
				//echo "SELECT * FROM asset_allocation WHERE asset = '$asset_no' AND active = 1 AND event = 'Allocated' $sqlfilter <br>";
				$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'F','$reason!',1)");
				echo "<br><font color=red size=+1 >$reason</font>" ;
			}
		}
		}
		else{
			
			$db->query("insert into `visit_assets`( visit, `asset_no`, `log_date`,matches,reason,scanned)values ( '".$_SESSION[SITE_NAME]['visit']."', '$asset_no', NOW(),'N','Asset No incorrect !',1)");
			echo "<br><font color=red size=+1 >Asset No incorrect !</font>" ;
		}
		
	}
	

	
}
 
 }
	?>
	
	  <?php 

	  if(mysql_num_rows($result) <= 0 || !isset($_POST['asset_no'] ) || $count > 0 )
	  {
	  switch($_SESSION[SITE_NAME]['cat']){
	
	case 'project':
		$ins="Project :- ". $_SESSION[SITE_NAME]['value'];
	break;

	case 'dept':
		$ins=" Department :- ".$_SESSION[SITE_NAME]['value'];
	break;
	
	case 'AC':
		$ins=" Asset_group :- ".$_SESSION[SITE_NAME]['value'];

	break;
	
	case 'AT':
		$ins=" Asset_type :- ".$_SESSION[SITE_NAME]['value'];
		
	break;
	
	case 'custodian':
	    $admin = $db->queryUniqueObject("SELECT * FROM persons WHERE active = 1 and id =".$_SESSION[SITE_NAME]['value']);
		$ins=" Custodian :- ".$admin->firstname." ". $admin->surname;

	break;
	
	case 'all':
		$ins=" WWF as a whole";
	break;
}

	   ?>
<br>
<h3>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Inspection For <?php echo $ins; ?> </h3>
 <br>
<form class ="form" method="post" action="index.php?c=card">

<table class="table-condensed table-striped">
	   <tr>
	   <td>Asset Number:
           </td>
           <td>
<input  type="text" name="asset_no" id="asset_no" placeholder="Enter the barcode" class="form-control text-input"/>
</td>
<td style="margin-left: 150;">
<input type="submit" id="Save" value="Check" name="Submit" class="btn btn-info btn-sm">
</td>
<td>(<font color="blue">This is an alternative if a barcode reader is not available</font>)</td>
</tr>
<tr>
<td>

</td>
</tr> 
</table>

</form>
<form  class ="recon" method="post" action="index.php?c=recon">
	<br>
<b>*********************************************************************************************************************************************</b><br>
<font color="red">To conclude the inspection click the button below </font> <br><br>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <input onclick="return confirmConclusion()" type="submit" id="Save" value="Evaluate" name="Submit" class="btn btn-sm btn-primary">


</form>
</div>
<?php } ?>