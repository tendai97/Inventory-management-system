<div id="content">
      <legend>Asset Disposal</legend>
      <?php 
	  //var_dump($_SESSION[SITE_NAME]);
	  $line="";
				if( isset($_POST['asset1']))

            {
			
	  $sql="select * from assets  WHERE active =1 and assert_no = '".$_GET['assert_no']."'";
			$line =  $db->queryUniqueObject($sql);

			$asset=mysql_real_escape_string($_POST['asset1']);
			$method=mysql_real_escape_string($_POST['method']);
			$reason=mysql_real_escape_string($_POST['reason']);
					
		 $sql="UPDATE `asset_allocation` SET  active=0  WHERE	asset = '".$_GET['assert_no']."'";
			$db->query($sql);
			
			$sql="	INSERT INTO `asset_allocation` 
	(`asset`,`asset_group`, `asset_type`,`event`,`allocate_status`,`narrative`,`insU`, `insTS`)	
	VALUES	( '".$_GET['assert_no']."','$line->asset_group','$line->asset_type','Disposal','Asset Disposed of Permanently','$reason', '".$_SESSION[SITE_NAME]['username']."', NOW())";
		
			$db->query($sql);
			
		$sql="UPDATE `assets`  SET  alloc_status = 'Asset Disposal - Awaiting Approval', alert_flag='A', d_method = '$reason' 	WHERE	`assert_no` = '".$_GET['assert_no']."'";
			$db->query($sql);
		//$sql="	
		//UPDATE `assets` SET	d_method = '$method', alloc_status='Disposed', `disposal_date` = NOW() , `updTS` = NOW() , `updU` = '".$_SESSION[SITE_NAME]['username']."' , `active` = '0', `custodian` = 'Disposed' 	WHERE	`assert_no` = '$asset'  ";
		//echo $sql;
						
			//$msg=" Your proposed Asset Disposal will ONLY become Effective after Approval!!" ;
			echo "<font color=red > Your proposed Disposal of this Asset has been Recorded but will ONLY become Effective upon Approval!!</font><br><br>" ;
			$line=$db->queryUniqueObject("SELECT * FROM assets WHERE `assert_no` = '".$_GET['assert_no']."'");
			}
				
				?>
				
				
     <form action="" method="post">
       <table width="300"  border="0" cellspacing="0" cellpadding="0">
	   
	    <input type="text" id="asset"  placeholder="Asset Number" class="validate[required,length[0,100]] form-control text-input" <?php if (isset($_GET['assert_no'])) echo "value='".$_GET['assert_no']."' readonly"?> required/>
		  <input name="asset1" type="hidden" id="asset1"  <?php if (isset($_GET['assert_no'])) echo "value='".$_GET['assert_no']."'"?> />
		  <br />
         
         <!--tr>
           
           <td width="473"> 
		   <select id="method" name="method" class="validate[required,length[0,100]] text-input"  required>
		   <option  value=""  >Please select disposal method</option>
		   <option  value="Sale"  >By Sale</option>
		   <option  value="Scrapping"  >By Scrapping</option>
		   </select>
		   </td>
         </tr> 
			<br />
	     <tr>
		  <!--td width="185" height="48"><span style="color: blue;">Remarks / Asset Location:</span></td>-->
		  <textarea rows="2" cols="70" name="reason" placeholder="Enter FULL Reason for Disposal (Stating whether By SALE or SCRAPPING)" id="reason"  required/><?php echo $line->d_method ;?></textarea>
         </tr> 
            
        </table>
       <br />
      
      <p>
        <?php if ($line->alloc_status == 'Asset Disposal - Awaiting Approval') { ?>
			<td><a href="index.php?c=assert_admin" class="btn-small btn-color btn-pad">Exit</a><br>
		<?php } else { ?>
			<input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Submit" />		
		<?php } ?>
      </p>
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>