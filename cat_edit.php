<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="js/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="jquery-1.12.4.js"></script>
  <script src="jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $( function() {
    $( "#datepickers" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>


<div id="content">
      <br><legend><?php if(!isset($_GET['id'])) echo "NEW "; else echo "UPDATE "; ?>Category RECORD</legend>
      <?php 
	  
	require 'core/PasswordHash.php';
	require 'core/pwqcheck.php';
	  $line="";
	  $insUs=$_SESSION[SITE_NAME]['username'];
	  
	   if(!isset($_GET['id'])&& isset($_POST['catname']))

            {
		//var_dump($_POST);
			$catname=mysqli_real_escape_string($db->connection,$_POST['catname']);
		
			
			
			$count = $db->countOf("categories", "name='$catname'");

	
		if($count > 0 )
			{
		echo "<font color=red> Category Record with same name  already Exists on record - Please Verify</font>";
			}
			else if (($count == 0 ))
			{
				//var_dump($_POST);
				
				$sql="INSERT INTO `categories` 
	(`name`, `date`)
	VALUES
	(
	'$catname', NOW())";
				$db->query($sql);
				$personid=mysqli_insert_id($db->connection);;
				
				 
						
				echo "<br><font color=green size=+1 >  $catame Record Added Successfully </font>" ;

										
				}
			else
			echo "<br><font color=red size=+1 >Problem in Adding Category Record!</font>" ;
			
			}
			
			

	////////////////////////////////employee update/////////////////////////////////
	
			else if (isset($_GET['id'])&& isset($_POST['catname'])){
							
			$catname=mysqli_real_escape_string($db->connection,$_POST['invname']);
		
			

				$line = $db->queryUniqueObject("SELECT * FROM categories WHERE id=".$_GET['id']);
			
											if($db->query("UPDATE `categories` 
	SET
	 
	`name` = '$catname' , 
	
	
	WHERE
	`id` = ".$_GET['id']));
		
			
			echo "<br><font color=green size=+1 >  $Catname Record Updated Successfully </font>" ;

			
		}
		if(isset($_GET['id'])){
			
			
				$id=$_GET['id'];
				
				$line = $db->queryUniqueObject("SELECT * FROM  categories  WHERE id=$id");
			}

				
				?>

	<?php
	$count = $db->countOf("categories", "1");

	if($count >0){
		?>
		<h3>Existing Categories </h3>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
			<thead>
          <tr>

            <th width="87"> Cat No. </th>
			<th width="87"> Name </th>
            <th width="91">Date Created</th>

           <!-- <td width="117"><strong>Patient Number </strong></td>-->
			<th width="128"> Category Assets </th>
           <!-- <th width="49">Deactivate</th>
            <td width="52"><strong>Select</strong></td>-->
          
          </tr>
		  </thead>
		  <tbody>
		  	
		  <?php
		  		$sql="SELECT * FROM categories WHERE 1 ";

				$result = $db->query($sql);


				while($row = mysqli_fetch_array($result))

				{ 
					$count = $db->countOf("assets", "category={$row['id']}");

					echo "<tr>
							<td> {$row['id']}</td>
							<td> {$row['name']}</td>
							<td> {$row['date']}</td>
							<td> $count</td>
						</tr>";
					}
					?>


		  </tbody>
		</table>
		  <?php
	} ?>

	
	
    <form action="" method="post" enctype="multipart/form-data">
       	   
        
	 <fieldset>
      <legend>Category Information</legend> 
	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <input name="personid" id="personid" type="hidden">

	  <br />
	  <td width="185" height="48"><span style="color: blue;">Category Name:</span></td>
	  <td width="100%"><input name="catname" type="text" class="form-control" id="catname" placeholder="inventory name" value="<?php echo $line->name ;?>" required/></td>
       <br />

       <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
             <td>
             <input type="submit" name="Submit" value="Save" class="btn-small btn-color btn-pad" /></td>
	   
      
      
	 </div>
	 
	   <tr>
           
           
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
	</tr>
   
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>