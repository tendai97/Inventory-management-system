<html>
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
    $( "#datepickers" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>

<div id="content">
      <legend>PARTNER / SUPPLIER PERFORMANCE REVIEW</legend>
	  <?php 
	  $line="";
	  
	        if(isset($_GET['id']))
				
				 {
				
			$sql="select * from supplier_partner where active = 1 and id = ".$_GET['id'];
					$line =  $db->queryUniqueObject($sql);
								
			////////////////////////////////supplier / partner review/////////////////////////////////
	
			if (isset($_GET['id']) && isset($_POST['review_result'])){
				
				//var_dump($_POST);
	  
			$name=mysql_real_escape_string($_POST['name']);
			$description=mysql_real_escape_string($_POST['description']);
			$catergory=mysql_real_escape_string($_POST['catergory']);
			$review_result=mysql_real_escape_string($_POST['review_result']);
			$prefered_supplier=mysql_real_escape_string($_POST['prefered_supplier']);
			$type=mysql_real_escape_string($_POST['type']);
			$code=mysql_real_escape_string($_POST['code']);
			$acc_no=mysql_real_escape_string($_POST['acc_no']);
			$registration_date=mysql_real_escape_string($_POST['registration_date']);
			$perform_rate=mysql_real_escape_string($_POST['perform_rate']);
			$review_date=mysql_real_escape_string($_POST['review_date']);
			$insU=$_SESSION[SITE_NAME]['username'];
			//$date = Date('d/m/Y');
			//echo $date;
			
					if($db->query("UPDATE supplier_partner  SET `review_result` = '$review_result',`prefered_supplier` = '$prefered_supplier', `review_date` = NOW(), `perform_rate` = '$perform_rate',`updU` = '$insU' ,`updTS` = NOW() where id=".$_GET['id']))
						
						{echo "<br><font color=green size=+1 >  $name  (Supplier / Partner Perfomance Review Successfully Recorded!</font>" ;
						$id=$_GET['id'];
						$line = $db->queryUniqueObject("SELECT * FROM supplier_partner WHERE id=$id");}
					else
					echo "<br><font color=red size=+1 >Problem in Updating Supplier / Partner Record!</font>" ;
					
			}
					
				 }

				 elseif(!isset($_GET['id'])&& isset($_POST['name']))

            {
	  //var_dump($_POST);
	  
		echo "<font color=red>Fatal Error Encountered While Attempting To Review Supplier / Partner Perfomance Rating </font>";
			}
							
				?>
     <form action="" method="post">
               
	 <fieldset>
	   
      <legend>Static Information</legend> 
	    <tr>
		  <td width="185" height="48"><span style="color: blue;">Supplier or Partner Classification:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		  <td width="262"><strong><?php if($line->type == "S" ) echo "SUPPLIER"; else echo "PARTNER" ;?>
		  	<input type="hidden" name="type" class="form-control" value="<?php if($line->type == "S" ) echo "Supplier"; else echo "Partner" ;?>"/></strong></td>
		 </tr>
         <br /><br />
		 <tr>
         <td><span style="color: blue;">Name of Supplier or Partner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<td><strong><?php echo $line->name; ?></strong></td>
		</tr>
         <br /><br />
		<tr>
	     <td width="185" height="48"><span style="color: blue;">Category of Supplier / Partner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<td><strong><?php echo $line->catergory; ?></strong></td>
         </tr>
		 <br /><br />
		 <tr>
		 <td width="185" height="48"><span style="color: blue;">Date of Registration with WWF:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		  <td><strong><?php echo $line->registration_date; ?></strong></td>
          <br /><br />
		 </tr>
		 <tr>
          <td width="185" height="48"><span style="color: blue;">WWF Code for Supplier / Partner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		<td><strong><?php echo $line->code; ?></strong></td>
         </tr>
         <br /><br />
        </fieldset>
     	 
	  
	  <fieldset>
      <legend>Review Trading Information</legend> 
	    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 ">
		 
         <td width="185" height="48"><span style="color: blue;">Outcome Of Last Review (Most Recent Session):</span></td>
		 <td width="262"><input value="<?php echo $line->review_result ?>"  class="form-control text-input"  readonly/></td>
		 <br /></div>
	  
		 
	    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
		 
         <td width="185" height="48"><span style="color: blue;">Narrative Outcome Of This Review:</span></td>
		 <td width="262"><input name="review_result" type="text" id="review_result" placeholder="Capture Narrative Result of this Review Session"  class="form-control text-input"  required/></td>
         <br />
		 
          <td width="185" height="48"><span style="color: blue;">Performance Rating of Supplier / Partner:</span></td>
		  <td width="262"><select name="perform_rate" class="form-control" id="category" required>
			 <option value="" <?php if($line->perform_rate == "" ) echo "selected";?>>Select A Perfomance Rating &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			 <option value="0" <?php if($line->perform_rate == "0" ) echo "selected";?>>Un-rated</option>
			 <option value="1" <?php if($line->perform_rate == "1" ) echo "selected";?>>Superior</option>
			 <option value="2" <?php if($line->perform_rate == "2" ) echo "selected";?>>Excellent</option>
			 <option value="3" <?php if($line->perform_rate == "3" ) echo "selected";?>>Above Average</option>
			 <option value="4" <?php if($line->perform_rate == "4" ) echo "selected";?>>Average</option>
			 <option value="5" <?php if($line->perform_rate == "5" ) echo "selected";?>>Below Average</option>
           
            </select></td>
         
		 <br /></div>
	  
	     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	      
		  <td width="185" height="48"><span style="color: blue;">Date of Last Perfomance Review :</span></td>
		  <td width="262"><input readonly name="review_date" type="text" id="datepicker" placeholder="Date of Last Perfomance Review (Read Only)" class="form-control"  value="<?php echo $line->review_date; ?>" /></td>
          <br />
	      <td width="185" height="48"><span style="color: blue;">Preferred Supplier / Partner Indicator :</span></td>
		  <td width="262"><select name="prefered_supplier" class="form-control" id="prefered_supplier" required>
			 <option value="" <?php if($line->perform_rate == "" ) echo "selected";?>>Select A Prefered Partner/Supplier Flag &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
			 <option value="0" <?php if($line->prefered_supplier == "0" ) echo "selected";?>>Not Preferred</option>
			 <option value="1" <?php if($line->prefered_supplier == "1" ) echo "selected";?>>Preferred</option>
			            
            </select></td> 
		  
         <br /><br /></div>
        </fieldset>
     	  	<br /> 
         <tr>
           <?php if(!isset($_GET['id'])) echo '<td><input type="reset" name="Reset" value="Reset" class="btn-small btn-color btn-pad" />
             </td>';?>
           <td>
             <input type="submit" name="Submit" value="Save" class="btn-small btn-color btn-pad" /></td>
         </tr>
         <tr>
           <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
           <td align="left">&nbsp;&nbsp;</td>
         </tr>
       </table>
       
     </form>
     <div align="justify"></div>
<div id="respond"></div>
    </div>