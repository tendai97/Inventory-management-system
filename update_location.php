

      <?php 
	  ini_set('max_execution_time', 0); 
	  $count = 0;
	  
		$location=$db->query( "SELECT * FROM  assets where active = '1'");

			while($rows = mysql_fetch_array($location))

					{
						$id = $rows['id'];	
						$loc = $rows['comment'];	
						
							$sql="UPDATE  `assets` SET  `location` = '$loc' WHERE `id` = '$id'";
		
									$db->query($sql);
					
							$count = $count + 1;
							} 
		
		echo "<br/>Update done, total count of updated records = " .$count;
		
							?>
				
	