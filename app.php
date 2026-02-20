<?php
session_start(); // Use session variable on this page. This function must put on the top of page.
include('core/core.php');
//var_dump($_SESSION[SITE_NAME]);
//echo $_SESSION[SITE_NAME][SITE_NAME]['username'];
//exit;
/*if(!isset($_SESSION[SITE_NAME]['username']) ){ // if session variable "username" does not exist.
header("location:login.php?msg=Please%20login%20to%20access%20System%20Control%20Panel%20!"); // Re-direct to index.php
}
elseif (isset($_SESSION[SITE_NAME]['username']) )
{*/
if(isset($_SESSION[SITE_NAME]['username']) ){
	include_once "core/db.php"; 
	error_reporting (E_ALL ^ E_NOTICE);

$line = $db->queryUniqueObject("SELECT * FROM _user WHERE username= '".$_SESSION[SITE_NAME]['username']."'");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WWF-Staff Portal</title>

        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- custom css (blue color by default) -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
		<link href="css/style (2).css" rel="stylesheet" type="text/css" media="screen">
      
        <!-- font awesome for icons -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- flex slider css -->
        <link href="css/flexslider.css" rel="stylesheet" type="text/css" media="screen">
        <!-- animated css  -->
        <link href="css/animate.css" rel="stylesheet" type="text/css" media="screen">
        
        
        
        
        <!--owl carousel css-->
        <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/owl.theme.css" rel="stylesheet" type="text/css" media="screen">
        <!--mega menu -->
        <link href="css/yamm.css" rel="stylesheet" type="text/css">
        <!--popups css-->
        <link href="css/magnific-popup.css" rel="stylesheet" type="text/css">
		
		
		
		
		<!--------------------------------------------------------------------------------------------------->

		
		
		
		
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
		
				
<style>
  .accordion-toggle {cursor: pointer;}
  .accordion-content {display: none;}
  .accordion-content.default {display: block;}
</style>

    </head>
    <body id="boxed">
        <div class="boxed-wrindexer">

     <!--top-bar end here-->
        <!--navigation -->
        <div class="navbar navbar-default navbar-static-top yamm sticky" role="navigation"><!--container-->
        </div><!--navbar-default-->
        <div class="breadcrumb-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h4><img src="img/wwf-logo3.png" width="533" height="85"></h4>
                    </div>
                    <div class="col-sm-6 hidden-xs text-right">
					<?php if(isset($_SESSION[SITE_NAME]['usertype'])){ ?>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li>Side navigation</li>
							<li><a href="core/logout.php">Logout</a></li>
                        </ol>
<?php } ?>
                    </div>
                </div>
            </div>
        </div><!--breadcrumbs-->
        <div class="divide80"></div>
     
	
	        <div class="container">
<?php
if(isset($_SESSION[SITE_NAME]['username']) ){
?>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                    <ul class="list-unstyled side-nav" id="accordion">
                        <li class="accordion-toggle"><a href="index.php?c=home&app=CA" class=""><i class="fa fa-cloud"></i> WWF Central Administration</a></li>
		
                        <li class="accordion-toggle"><a href="index.php?c=home&app=ATM"><i class="fa fa-briefcase"></i>  Asset Tracking & Management</a></li>
						
                        <li class="accordion-toggle"><a href="index.php?c=home&app=LAM"><i class="fa fa-edit"></i> Leave & Absence Management</a></li>
						<ul class="accordion-content" id="ac2"></ul>
                        <li class="accordion-toggle" > <a href="index.php?c=home&app=TAE"><i class="fa fa-suitcase"></i> Travel advances and expenses</a></li>
						<ul class="accordion-content" id="ac3"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=VLM"><i class="fa fa-car"></i> Vehicle Logging and Management</a></li>
						<ul class="accordion-content" id="ac4"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=PRO"><i class="fa fa-file"></i> Purchase Requisitions & Orders</a></li>
						<ul class="accordion-content" id="ac5"></ul>
                       
                    </ul>
               </div><!--sidebar col end-->
               
            </div>
<?php } 
else {
	?>
	  <div class="row">
               
                <div class="col-sm-9">
                    
                  <div class="row">
                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                            
                            <p>
                               .<?php
							   include($_GET['c'].".php");
							   ?>
                           </p>
                        </div>
                       
                    </div><!--1/2 row end-->
                   
                </div>
            </div>
	
<?php	
}
?>
        </div>
	
        <div class="divide60"></div>
             <footer id="footer" name="footer"></footer><!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <script src="js/jquery.easing.1.3.min.js" type="text/javascript"></script>
        <!--sticky header-->
        <script type="text/javascript" src="js/jquery.sticky.js"></script>
        <!--flex slider plugin-->
        <script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
        <!--parallax background plugin-->
        <script src="js/jquery.stellar.min.js" type="text/javascript"></script>
        
        
        <!--digit countdown plugin-->
        <script src="js/waypoints.min.js"></script>
        <!--digit countdown plugin-->
        <script src="js/jquery.counterup.min.js" type="text/javascript"></script>
        <!--on scroll animation-->
        <script src="js/wow.min.js" type="text/javascript"></script> 
        <!--owl carousel slider-->
        <script src="js/owl.carousel.min.js" type="text/javascript"></script>
        <!--popup js-->
        <script src="js/jquery.magnific-popup.min.js" type="text/javascript"></script>
        <!--you tube player-->
        <script src="js/jquery.mb.YTPlayer.min.js" type="text/javascript"></script>
        
        
        <!--customizable plugin edit according to your needs-->
        <script src="js/custom.js" type="text/javascript"></script>
		



    </body>
</html>
<?php
//}

?>
