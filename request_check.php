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
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="css/theme-responsive.css">
      <!-- Switcher CSS -->
      <link href="css/switcher.css" rel="stylesheet">
      <link href="css/spectrum.css" rel="stylesheet">
      <!-- Favicons -->
      <link rel="shortcut icon" href="img/ico/favicon.ico">
      <link rel="apple-touch-icon" href="img/ico/apple-touch-icon.png">
      <link rel="apple-touch-icon" sizes="72x72" href="img/ico/apple-touch-icon-72.png">
      <link rel="apple-touch-icon" sizes="114x114" href="img/ico/apple-touch-icon-114.png">
      <link rel="apple-touch-icon" sizes="144x144" href="img/ico/apple-touch-icon-144.png">
      <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <!--[if IE]>
      <link rel="stylesheet" href="css/ie.css">
      <![endif]-->
	  
	  <link href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
	  <link href="libs/jquery-timepicker-1.3.2/jquery.timepicker.min.css" rel="stylesheet">

	  


   <?php
             
				include_once "core/db.php"; 

				$inv_id = $_GET['inv_id'];
        $cat_id= $_GET['cat'];
        $u_id= $_GET['u_id'];
        $cat = $db->queryUniqueObject("SELECT * FROM categories WHERE id= '$cat_id'");
        $inv = $db->queryUniqueObject("SELECT * FROM assets WHERE id = $inv_id");

        if(isset($_POST['req']))
        {
          $av = $_POST['stk'];
          $qty = $_POST['req'];
          if(floatval($av)<floatval($qty))
          {
            echo "$av<$qty<font color=red> <strong> You can not request more than wats available";
          }
          else
          {
            $sql= "INSERT INTO `requests`( `user_id`, `asset_id`, `quantity`, `date`, `status`, `active`) VALUES ($u_id,$inv->id,$qty,NOW(),'P',1)";
            $db->query($sql);
            ?>
            <script language="javascript" type="text/javascript">
           
            window.opener.location.href="index.php?c=emp_req&flag=P&msg=Request Sent ---- Awaiting Admin Action";
            window.close('','_self');

          </script>

<?php
          }
        }

		       ?>
   
   <form method="post" id ='reqq'>
   
	<fieldset>
 <legend>Make New Request</legend> 
 	  <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 ">
	  <td><span style="color: blue;">Inventory Name</span></td>
      <input name="rname" type="text" class="form-control" id="rname" placeholder="Referer Name" readonly="" value="<?php echo $inv->name;?>" />
      <br />
	  <td><span style="color: blue;">Inventory Category</span></td>
	  <input name="code" type="text" class="form-control" id="code" placeholder="Referer code"  readonly="" value="<?php echo $cat->name;?>"/>
      <br />
	  <td><span style="color: blue;">Stock Available.:</span><font color="green"> </font></td>
      <input name="stk" type="text" class="form-control" id="stk" placeholder="Contact Number" readonly="" value="<?php echo $inv->available?> "/>
      <br />
	  <td><span style="color: blue;">Request Amount.:</span><font color="green"> </font></td>
      <input name="req" type="text" class="form-control" id="req" placeholder="Enter Request Quantity" required="" />
      <br />
	<br />
	  </fieldset>
	    <p>
        <button class="btn-small btn-color btn-pad" type="submit" onclick="checkform()" >Submit</button>
      </p>
	  </form>
<script type="text/javascript">
   function checkform() {
    if(document.reqq.stk.value < document.reqq.req.value ) {
        alert("You cannot request more than whats available");
        return false;
    } else if(document.reqq.stk.value > document.reqq.req.value) {
        document.reqq.submit();
    }
}
  
</script>
   
