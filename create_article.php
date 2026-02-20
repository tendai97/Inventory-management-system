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
	
	$auth = $_GET['auth'];
	if ($_GET['dept'] == 'hra') {$dept = "Human Resources Dept";} elseif ($_GET['dept'] == 'fad') {$dept = "Finance Department";} elseif ($_GET['dept'] == 'prj') {$dept = "Conservation Projects";}				
		
	if(isset($_POST['title']))       {
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
						
			$sql="INSERT INTO `bulletin_posts` (`dept_of_article`, `title`, `post`,`author_id`, `date_posted`, `date_of_expiry`, `active`)
				VALUES
				('$dept', '$title', '$message', '$auth', NOW(), '$expiry_date', '1')";
					$db->query($sql);
			
			$msg = "Staff Bulletin Article Has Been Created Successfully. You will Need To Publish First It Before It Can Be Viewed By ALL Staff!!" ;
	 
		  echo "<script type=\"text/javascript\">
				window.location=\"index.php?c=bulletin_admin&msg=$msg\";
			</script>";
 }
	 

?>
    <br><legend>WWF STAFF Bulletin Article Creation </legend>

    <form action="" method="post">
		<div class="col-lg-9 col-md-9 ">
               <tr>
                   <td><b>DEPARTMENT :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <span style="color: blue;"><?php echo $dept; ?></span></b></td>
               </tr>
               <br/><br/>
               <tr>
                   <td><b>ARTICLE TITLE : </b><br>
                   <input type="text" placeholder="Enter Title Of Article Here" name="title" class="form-control" required/></td>
               </tr>
               <br/>
               <tr>
                    <td><b>EXPIRY DATE (Optional - if none specified Article expires after 2 months) : </b><br>
					<input name="expiry_date" type="text" id="datepicker" placeholder="Expiry Date Of Article"  class="form-control datepicker" ></td>
               </tr>
               <br/>
               <tr>
                   <td><b>ARTICLE MESSAGE : </b><br>
                   <textarea name="message" class="form_inpt" placeholder="Enter Article Text Message Here" required></textarea></td>
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