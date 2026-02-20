<html> 
      <!-- Library CSS -->
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/bootstrap-theme.css">
      <link rel="stylesheet" href="css/fonts/font-awesome/css/font-awesome.css">
      <link rel="stylesheet" href="css/animations.css" media="screen">
      <link rel="stylesheet" href="css/superfish.css" media="screen">
      <link rel="stylesheet" href="css/prettyPhoto.css" media="screen">
      <!-- Theme CSS -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Skin -->
      <link rel="stylesheet" href="css/colors/blue.css" class="colors">
<head>  
<script type='text/javascript'>
window.onunload = function(){
window.opener.location.reload();
window.close('','_self');return true;}
</script>
</head>  

 <p><br/></p>
      <legend>&nbsp;&nbsp;&nbsp;Intended Pupose Or Usage Of Fleet Vehicle</legend>  

  <?php
		include_once "core/db.php"; 
		
		$id = $_GET['id'];
		
		$line = $db->queryUniqueObject("select * from vehicle_requests where  id = $id");

	?>
						 
	<form action="" method="post">
	   	<tr>&nbsp;&nbsp;&nbsp;<textarea  rows="2" cols="107"   name="reason"  readonly/><?php echo $line->rqst_purpose; ?></textarea><tr/>
	   
      <br /> 

	  <p>
		<input class="btn-small btn-color btn-pad" type="submit" name="register" id="register" value="Close" />
      </p>
	   
     </form>
