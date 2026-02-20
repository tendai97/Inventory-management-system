<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
include_once "core/db.php"; 
session_start(); // Use session variable on this page. This function must put on the top of page.

if( isset($_SESSION['LAST_REQUEST']) &&

    (time() - $_SESSION['LAST_REQUEST'] > 240) ) {

  $sql="UPDATE users set status='Offline' WHERE id = ".$_SESSION[SITE_NAME]['id'] ;
    $result=mysqli_query($db->connection,$sql);


    session_unset();

    session_destroy();
    
    header('location:index.php?c=login&msg=Session%20Expired');

    exit();

}

 

$_SESSION['LAST_REQUEST'] = time();


//var_dump($_SESSION);

include('core/core.php');
if(isset($_GET['app']))
$_SESSION[SITE_NAME]['app']=$_GET['app'];

//var_dump($_SESSION);

if (isset($_SESSION[SITE_NAME]['username'])  )

{

	

	error_reporting (E_ALL ^ E_NOTICE);

$line = $db->queryUniqueObject("SELECT * FROM users WHERE id= ".$_SESSION[SITE_NAME]['id']);
$_SESSION[SITE_NAME]['ao']=$line->ao;
$_SESSION[SITE_NAME]['hra']=$line->hra;
$_SESSION[SITE_NAME]['fa']=$line->fa;
$_SESSION[SITE_NAME]['ita']=$line->ita;
$_SESSION[SITE_NAME]['ex']=$line->ex;
$_SESSION[SITE_NAME]['person']=$line->personid;
//Admin Officer
$_SESSION[SITE_NAME]['a_init']=$line->a_init;
$_SESSION[SITE_NAME]['a_apro']=$line->a_apro;
$_SESSION[SITE_NAME]['a_insp']=$line->a_insp;
$_SESSION[SITE_NAME]['a_othr']=$line->a_othr;
//Fin and Accounting
$_SESSION[SITE_NAME]['f_init']=$line->f_init;
$_SESSION[SITE_NAME]['f_apro']=$line->f_apro;
$_SESSION[SITE_NAME]['f_insp']=$line->f_insp;
$_SESSION[SITE_NAME]['f_othr']=$line->f_othr;
//Human Resources
$_SESSION[SITE_NAME]['h_init']=$line->h_init;
$_SESSION[SITE_NAME]['h_apro']=$line->h_apro;
$_SESSION[SITE_NAME]['h_insp']=$line->h_insp;
$_SESSION[SITE_NAME]['h_othr']=$line->h_othr;
//IT System Admin
$_SESSION[SITE_NAME]['i_insp']=$line->i_insp;
$_SESSION[SITE_NAME]['i_othr']=$line->i_othr;
//Exec Mgt
$_SESSION[SITE_NAME]['e_insp']=$line->e_insp;
$_SESSION[SITE_NAME]['e_othr']=$line->e_othr;

}
?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
   <head>
      <meta charset="utf-8">
      <title>AFSC: Staff Portal</title>
      <meta name="AMERICAN FRIENDS SERVICE COMMITEE" content="">
      <meta name="" content="">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Google Fonts  -->
	  
	  <style>
.dropbtn {
    background-color: #0488cd;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
    background-color: #0488cd;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #f1f1f1}

.show {display:block;}
</style>

	  <style>
.ui-autocomplete
{
    position:absolute;
    cursor:default;
    z-index:1001 !important
}
	  </style>
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
      <link rel="stylesheet" href="css/colors/red.css" class="colors">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="css/theme-responsive.css">
      <!-- Switcher CSS -->
      <link href="css/switcher.css" rel="stylesheet">
      <link href="css/spectrum.css" rel="stylesheet">
      <!-- Favicons -->
      <link rel="shortcut icon" href="img/ico/logo3.jpg">
      <link rel="apple-touch-icon" href="img/ico/logo3.jpg">
      <link rel="apple-touch-icon" sizes="72x72" href="img/ico/logo3.jpg">
      <link rel="apple-touch-icon" sizes="114x114" href="img/ico/logo3.jpg">
      <link rel="apple-touch-icon" sizes="144x144" href="img/ico/logo3.jpg">
      <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <!--[if IE]>
      <link rel="stylesheet" href="css/ie.css">
      <![endif]-->
	  
	  <link href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
	  <link href="libs/jquery-timepicker-1.3.2/jquery.timepicker.min.css" rel="stylesheet">
	  
	 
	
   </head>
   <body class="boxed blog">
      <div class="wrap">
         <!-- Header Start -->
         <header id="header">
            <!-- Header Top Bar Start -->
            <!-- Header Top Bar End -->
            <!-- Main Header Start -->
            <div class="main-header">
               <div class="container">
                  <!-- TopNav Start -->
                  <div class="topnav navbar-header">
                     <a class="navbar-toggle down-button" data-toggle="collapse" data-target=".slidedown">
                     <i class="fa fa-angle-down icon-current"></i>
                     </a> 
                  </div>
                  <!-- TopNav End -->
                  <!-- Logo Start -->
                  <div class="logo pull-centre">
                     <h1>
                        <a href="index.php">
                        <img src="img/logo.png" alt="AFSC" width=auto height=auto>
                        </a>
                       <strong style="color: white;size: 18"> INVENTORY SYSTEM </strong>
                     </h1>
                  </div>
                  <!-- Logo End -->
                  <!-- Mobile Menu Start -->
                  <div class="mobile navbar-header">
                     <a class="navbar-toggle" data-toggle="collapse" href=".navbar-collapse">
                     <i class="fa fa-bars fa-2x"></i>
                     </a> 
                  </div>
                  <!-- Mobile Menu End -->
                  <!-- Menu Start -->
                  
                  <!-- Menu End --> 
               </div>
            </div>
			<?php if (isset($_SESSION[SITE_NAME]['username'])  )

{
	?>
            <div class="col-lg-5 col-md-5 col-xs-12 col-sm-6 "><font color="white"><p>Welcome:  <?php echo $_SESSION[SITE_NAME]['fname']." ".$_SESSION[SITE_NAME]['sname']."  [".$_SESSION[SITE_NAME]['usertype']."]"; //var_dump($_SESSION);?>&nbsp;&nbsp;<i class="fa fa-user fa-2x" style="color:#0488cd"></i></p></font></div>
			<?php date_default_timezone_set('Africa/Harare');?>
			 <div class="col-lg-7 col-md-7 col-xs-12 col-sm-6 "><font color="white"><p align="right">Its <?php echo date('g:ia \o\n l jS F Y');?>&nbsp;&nbsp;&nbsp;&nbsp; <a href="index.php?c=home"> <i class="fa fa-home fa-2x"></i><font color="white">Home &nbsp;&nbsp;&nbsp;</font></a><a href="index.php?c=change"><i class="fa fa-key fa-2x"></i><font color="white">Pword Edit  &nbsp;&nbsp;&nbsp;</font></a><a href="core/logout.php?id=<?php echo $_SESSION[SITE_NAME]['id']?>"><i class="fa fa-sign-out fa-2x"></i><font color="white">Logout</font></a></p></font></div>
<?php } ?>
			<!-- Main Header End -->
         </header>
         <!-- Header End -->  
         <!-- Content Start -->
         <div id="main">
            <!-- Title, Breadcrumb Start-->
            <div class="breadcrumb-wrapper">
               <div class="container">
                  <div class="row"></div>
               </div>
   </div>
            <!-- Title, Breadcrumb End-->
            <!-- Main Content start-->
            <div class="content">
               <div class="container">
        
	
	
	  <div class="row">
                    <div class="posts-block col-lg-9 col-md-9 col-sm-8 col-xs-12 bottom-pad">
                       <article class="post hentry">
                                <?php

	if (isset($_GET['c']) &&isset($_SESSION[SITE_NAME]['username']) )
	{
	include($_GET['c'].".php");
}
	else{

	include("login.php");

	}

	?>
                 
                    
                    </div>
                     <div class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12">
                      
                        <!-- Category Widget Start -->
                          <div class="row">
						 
    <div class="buttons">
                        <?php
						  if($_SESSION[SITE_NAME]['app'] =='CA' ){
										include ('ca_side.php');

						  }
						  elseif($_SESSION[SITE_NAME]['app'] =='ATM'){
										include ('atm_side.php');
							
						}
						  elseif($_SESSION[SITE_NAME]['app'] =='LAM'){
										include ('leave/lam_side.php');
							  
						 }
						  elseif($_SESSION[SITE_NAME]['app'] =='VLM'){
										include ('vehicles/vlm_side.php');
							  
						 }
		?>

                 
                     
                   </div>
                     
                           
                        <!-- Category Widget End -->
                      
                     </div>
                     <!-- Sidebar End --> 
                  </div>
               </div>
	
	
            <!-- Main Content end-->
         </div>
         <!-- Content End -->
         <!-- Footer Start -->
         <footer id="footer">
            <!-- Footer Top Start --><!-- Footer Top End --> 
            <!-- Footer Bottom Start -->
            <div class="footer-bottom">
               <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-8 "> &copy; Copyright 2016 <a href="http://www.horizonview.co">Designed for AFSC by ISHMAEL LTD</a>.</div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-4 ">
                        <ul class="social social-icons-footer-bottom">
                           <li class="facebook"><a href="#" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                           <li class="twitter"><a href="#" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                           
                           <li class="linkedin"><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                           <li class="rss"><a href="#" data-toggle="tooltip" title="Rss"><i class="fa fa-rss"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Footer Bottom End --> 
         </footer>
         <!-- Scroll To Top --> 
         <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
      </div>
      <!-- Wrap End -->
    
      <!-- The Scripts -- > 
	  <script src="js/jquery.min.js"></script>
	
     
      <script src="js/bootstrap.js"></script>
      <script src="js/jquery.parallax.js"></script>
      <script src="js/jquery.wait.js"></script> 
      <script src="js/modernizr-2.6.2.min.js"></script> 
      <script src="js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
      <script src="js/jquery.nivo.slider.pack.js"></script>
      <script src="js/jquery.prettyPhoto.js"></script>
      <script src="js/superfish.js"></script>
      <script src="js/tweetMachine.js"></script>
      <script src="js/tytabs.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/jflickrfeed.js"></script>
      <script src="js/imagesloaded.pkgd.min.js"></script>
      <script src="js/waypoints.min.js"></script>
            <script src="js/jquery.gmap.min.js"></script>
      <script src="js/spectrum.js"></script>
      <script src="js/switcher.js"></script>
      <!--<script src="js/custom.js"></script>- ->
	  	 <script src="js/hide.js"></script>
		   
		
         <!--digit countdown plugin- ->
        <script src="js/waypoints.min.js"></script>
        <!--digit countdown plugin- ->
		
		
		
        <script src="js/jquery.counterup.min.js" type="text/javascript">
		</script>
		
		 <script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js" type="text/javascript">
		</script>
		<script src="libs/jquery-timepicker-1.3.2/jquery.timepicker.min.js" type="text/javascript">
		</script>
		 <script src="js/<?php echo $_GET['c'];?>.js"></script>-->
		 <!-- The Scripts -->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.js"></script>
      <script src="js/jquery.parallax.js"></script>
      <script src="js/jquery.wait.js"></script> 
      <script src="js/modernizr-2.6.2.min.js"></script> 
      <script src="js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
      <script src="js/jquery.nivo.slider.pack.js"></script>
      <script src="js/jquery.prettyPhoto.js"></script>
      <script src="js/superfish.js"></script>
      <script src="js/tweetMachine.js"></script>
      <script src="js/tytabs.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/jflickrfeed.js"></script>
      <script src="js/imagesloaded.pkgd.min.js"></script>
      <script src="js/waypoints.min.js"></script>
      <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
      <script src="js/jquery.gmap.min.js"></script>
      <script src="js/spectrum.js"></script>
      <script src="js/switcher.js"></script>
      <!--<script src="js/custom.js"></script>-->
	  	 <script src="js/hide.js"></script>
         <!--digit countdown plugin-->
        <script src="js/waypoints.min.js"></script>
        <!--digit countdown plugin-->
        <script src="js/jquery.counterup.min.js" type="text/javascript">
		</script>
		
		 <script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js" type="text/javascript">
		</script>
		<script src="libs/jquery-timepicker-1.3.2/jquery.timepicker.min.js" type="text/javascript">
		</script>
		      <script src="js/<?php echo $_GET['c']?>.js"></script>
		
		  
   </body> <?php
	  if($_GET['c']=="leave/hoildays"){
		  ?>
		  <link href='assets/css/fullcalendar.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='assets/js/moment.min.js'></script>
<script src='assets/js/jquery.min.js'></script>
<script src='assets/js/jquery-ui.min.js'></script>
<script src='assets/js/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {

		var zone = "02:00";  //Change this to your timezone

	$.ajax({
		url: 'leave/process.php',
        type: 'POST', // Send post data
        data: 'type=fetch',
        async: false,
        success: function(s){
        	json_events = s;
        }
	});


	var currentMousePos = {
	    x: -1,
	    y: -1
	};
		jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			utc: true,
			header: {
				left: 'prevYear,prev',
				center: 'title',
				right: 'next, nextYear '
			},
			editable: true,
			droppable: true, 
			slotDuration: '00:30:00',
			eventReceive: function(event){
				var title = event.title;
				var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
				$.ajax({
		    		url: 'leave/process.php',
		    		data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
		    		type: 'POST',
		    		dataType: 'json',
		    		success: function(response){
		    			event.id = response.eventid;
		    			$('#calendar').fullCalendar('updateEvent',event);
		    		},
		    		error: function(e){
		    			console.log(e.responseText);

		    		}
		    	});
				$('#calendar').fullCalendar('updateEvent',event);
				console.log(event);
			},
			eventDrop: function(event, delta, revertFunc) {
		        var title = event.title;
		        var start = event.start.format();
		        var end = (event.end == null) ? start : event.end.format();
		        $.ajax({
					url: 'leave/process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
		    },
		    eventClick: function(event, jsEvent, view) {
		    	console.log(event.id);
		          var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
		          if (title){
		              event.title = title;
		              console.log('type=changetitle&title='+title+'&eventid='+event.id);
		              $.ajax({
				    		url: 'leave/process.php',
				    		data: 'type=changetitle&title='+title+'&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){	
				    			if(response.status == 'success')			    			
		              				$('#calendar').fullCalendar('updateEvent',event);
				    		},
				    		error: function(e){
				    			alert('Error processing your request: '+e.responseText);
				    		}
				    	});
		          }
			},
			eventResize: function(event, delta, revertFunc) {
				console.log(event);
				var title = event.title;
				var end = event.end.format();
				var start = event.start.format();
		        $.ajax({
					url: 'leave/process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
		    },
			eventDragStop: function (event, jsEvent, ui, view) {
			    if (isElemOverDiv()) {
			    	var con = confirm('Are you sure to delete this event permanently?');
			    	if(con == true) {
						$.ajax({
				    		url: 'leave/process.php',
				    		data: 'type=remove&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){
				    			console.log(response);
				    			if(response.status == 'success'){
				    				$('#calendar').fullCalendar('removeEvents');
            						getFreshEvents();
            					}
				    		},
				    		error: function(e){	
				    			alert('Error processing your request: '+e.responseText);
				    		}
			    		});
					}   
				}
			}
		});

	function getFreshEvents(){
		$.ajax({
			url: 'leave/process.php',
	        type: 'POST', // Send post data
	        data: 'type=fetch',
	        async: false,
	        success: function(s){
	        	freshevents = s;
	        }
		});
		$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
	}


	function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }

	});

</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	}

	#trash{
		width:32px;
		height:32px;
		float:left;
		padding-bottom: 15px;
		position: relative;
	}
		
	#wrap {
		width: 100%;
		margin: 0 auto;
	}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		float: right;
		width: 75%;
	}

</style>

		  
	  <?php
	  }
	 
	  ?>
	  
</html>

