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

<body>
<div>
<?php
	
	$id = $_GET['id'];
	$oper = $_GET['op'];
	$msg="";

	$line = $db->queryUniqueObject("SELECT * FROM bulletin_posts WHERE active = 1 and id = $id");

	if (isset($_GET['id'])) {
		
		if ($_GET['op'] == "Del") {     
                       
			$sql="update bulletin_posts set active = 0, Publish = 'N', date_last_edit = NOW() WHERE id = $id";			
				$db->query($sql);			

			$msg ='Staff Bulletin Article Has Been Deleted Successfully!!';  
							
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=bulletin_admin&cmsg=$msg\";
			</script>";
			}
		
		elseif ($_GET['op'] == "Pub") {     
                       
			$sql="update bulletin_posts set active = 1, Publish = 'Y', date_last_edit = NOW() WHERE id = $id";			
				$db->query($sql);			

			$msg ='Staff Bulletin Article Has Been Successfully Published!!';  
							
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=bulletin_admin&msg=$msg\";
			</script>";
				}
		
		elseif	($_GET['op'] == "Unp") {     
                       
			$sql="update bulletin_posts set Publish = 'N', date_last_edit = NOW() WHERE id = $id";			
				$db->query($sql);			

			$msg ='Staff Bulletin Article Has Been Un-Published Successfully!!';  
							
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=bulletin_admin&cmsg=$msg\";
			</script>";
				}
				
		elseif	(isset($_POST['ini']) && isset($_POST['title']))  {
			$title = mysql_real_escape_string($_POST['title']);
			$expiry_date = mysql_real_escape_string($_POST['expiry_date']);
			$message = mysql_real_escape_string($_POST['message']);
			
		if ($expiry_date == "") {
			$today = date("Y-m-d");
			$today_yr_mnth = date("Y-m", strtotime($today));
			$today_year = date("Y", strtotime($today));
			$today_month = date("m", strtotime($today));
			$today_day = date("d", strtotime($today));
			if ($today_month == 11) { $check_year = $today_year + 1; $check_month = 1; }
			elseif ($today_month == 12) { $check_year = $today_year + 1; $check_month = 2; }
			else { $check_year = $today_year; $check_month = $today_month + 2; }
			if ($today_day > 30 && ($check_month == 04 || $check_month == 06 || $check_month == 09 || $check_month == 11)) { $check_day = 30; }
			elseif ($today_day > 28 && $check_month == 02) { $check_day = 28; }
			else { $check_day = $today_day; }
			$expiry_date = $check_year."-".$check_month."-".$check_day;
			//echo $expiry_date; 
			}
						
			$sql="update bulletin_posts set title = '$title', post = '$message', date_of_expiry = '$expiry_date', publish = 'N', date_last_edit = NOW() WHERE id = $id";			
				$db->query($sql);			

			$msg ='Staff Bulletin Article Has Been Updated Successfully!!';  
	 
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=bulletin_admin&msg=$msg\";
			</script>";
		}	}
	 

?>
    <br><legend>WWF STAFF Bulletin Article Update </legend>

    <form action="" method="post">
		<input name="ini" type="hidden"  value="S"/>

		<div class="col-lg-9 col-md-9 ">
               <tr>
                   <td><b>DEPARTMENT :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <span style="color: blue;"><?php echo $line->dept_of_article; ?></span></b></td>
               </tr>
               <br/><br/>
               <tr>
                   <td><b>ARTICLE TITLE : </b><br>
                   <input type="text" value="<?php echo $line->title; ?>" name="title" class="form-control" required/></td>
               </tr>
               <br/>
               <tr>
                    <td><b>EXPIRY DATE (Optional - if none specified Article expires after 2 months) : </b><br>
					<input name="expiry_date" type="text" id="datepicker" value="<?php echo $line->date_of_expiry; ?>"  class="form-control datepicker" ></td>
               </tr>
               <br/>
               <tr>
                   <td><b>ARTICLE MESSAGE : </b><br>
                   <textarea name="message" class="form_inpt" required><?php echo $line->post; ?></textarea></td>
               </tr>
               <br/><br/>
               <tr>
                   <td><input type="submit" name="submit1" value="Save"  class="btn-small btn-color btn-pad"/>
                   <button class="btn-small btn-color btn-pad" onclick="javascript:window.open('','_self').close();history.go(-1);return true;">Cancel</button></td>
               </tr>
         </div>
    </form>

</div>

</body>
<style>
        .form_inpt{
			border: solid 1px #CCC;
	        background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #ffffff), to(#FFFFFF)) !important;
	        background: -moz-linear-gradient(top, #FFFFFF, #ffffff 1px, #FFFFFF 25px) !important;
	        box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
	        -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
	        -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
			border-radius: 5px;
			width: 100%;
			padding: 3px;
			margin-bottom: 7px;
			text-align: left;
		}
		
		.form_date{
			border: solid 1px #CCC;
	        background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF)) !important;
	        background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px) !important;
	        box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
	        -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
	        -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px !important;
			border-radius: 5px;
			width: 150px;
			padding: 7px;
		}
        </style>
        
</html>