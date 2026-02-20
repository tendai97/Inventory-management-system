

      <?php 
	  ini_set('max_execution_time', 0); 
	  $count = 0;
	  
			$tlines=$db->query( "SELECT * FROM  trade_lines where active = '1'");

			while($rows = mysql_fetch_array($tlines))

					{
						$code = $rows['code'];
						$name = $rows['name'];
						$description = $rows['description'];

						$sql="insert into parameters values(NULL, 'trdlines','$code',NULL,'$name','$description','Active','N',NOW(),'Admin',NULL,NULL,1)";
									$db->query($sql);
					
							$count = $count + 1;
							} 
		
		//$count2 = $db->countOf("patient_visit", "con_set = '1' and con_stage = 'Bil'");
		
		//echo "Update done, total record count of non Med Aid Patients = " .$count;
		echo "<br/>Trade Lines inserts done, total count of inserted records = " .$count;
		
							?>
				
	