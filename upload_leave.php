  <?php
  
  	include_once "core/db.php"; 
  
   	$msg="";
	$line="";
	//$insUs=$_SESSION ['SITE_NAME']['username'];
	  
    $sql="SELECT * FROM persons WHERE  active = 1";

		$line = mysql_query($sql);
			while($row = mysql_fetch_array($line))
	
		{
						 
		$years= $db->queryUniqueObject("SELECT TIMESTAMPDIFF(YEAR, ".$row['join_date'].", CURDATE()) AS years from persons where active = 1");

		//var_dump($years);
			
           $sql="INSERT INTO `leave_master` (`employee`, `firstname`, `surname`, `department`, `date_join`, `contract_end`, `vac_ent`, `vac_taken`, `vac_bal`, `sick_ent`, `sick_taken`, `sick_bal`, `mat_ent`, `mat_taken`, `mat_bal`, `pat_ent`, `pat_taken`, `pat_bal`, `compa_taken`, `unpaid_taken`, `bizabs_taken`, `lve_start_date`, `lve_end_date`, `working_days`, `type`, `address`, `contact_number`, `lve_status`, `insU`, `insTs`,  `active`) VALUES (".$row['id'].", '".$row['firstname']."', '".$row['surname']."', '".$row['department']."', '".$row['join_date']."', '".$row['end_date']."', 25, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, 'At Work', 'Admin', NOW(), 1);";
										
									$db->query($sql);

			 }

			 
 		echo "Initial Upload Of Leave Records For All Employees Completed Successfully!!";			
						
				?>
				
			