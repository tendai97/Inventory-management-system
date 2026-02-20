<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
   <head>
      <meta charset="utf-8">
      <title>AFSC Staff Portal</title>
      <meta name="AFSC Zimbabwe" content="">
      <meta name="" content="">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Google Fonts  -->
	  
	  <style>
      .bb{
        cursor: pointer;
        background-color: #0488cd;
    color: white;
    padding: 16px;
    border: none;
    cursor: pointer;
      }
      .bb:hover, .bb:focus {
    background-color: #0488cd;
}
.dropbtn {
    
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

	<?php
			if($_SESSION[SITE_NAME]['usertype']=="Admin"){
						?>  
            <a href="index.php?c=emp_edit" class="dropbtn btn-small btn-color btn-pad">New Employee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>  

				   <div> 
					   	
              <button onclick="myFunction1()" class="dropbtn btn-small btn-color btn-pad">Employee Management&nbsp;&nbsp;&nbsp;&nbsp;</button>
					    <div id="myDropdwn1" class="dropdown-content">
						<a href="index.php?c=emp_admin&flag=A">Active Employees</a>
						<a href="index.php?c=emp_admin&flag=D">Inactive Employees</a>
				   </div>
				</div>
<script>
				
function myFunction1() {
    document.getElementById("myDropdwn1").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

			<!--a href="index.php?c=dept_admin" class="btn-small btn-color btn-pad">Manage Department&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>--> 
				   <div> 
					   	<button onclick="myFunction2()" class="dropbtn btn-small btn-color btn-pad">Employee Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
					    <div id="myDropdwn2" class="dropdown-content">
						<a href="index.php?c=req_admin&flag=P">Pending Requests</a>
						<a href="index.php?c=req_admin&flag=A">Approved Requests</a>
            <a href="index.php?c=req_admin&flag=D">Declined Requests</a>
				   </div>
				</div>
<script>
				
function myFunction2() {
    document.getElementById("myDropdwn2").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

<?php }

  else
  {
    ?>
<a href="index.php?c=emp_edit" class="dropbtn btn-small btn-color btn-pad">Pending Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
<a href="index.php?c=emp_edit" class="dropbtn btn-small btn-color btn-pad">Approved Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 

<a href="index.php?c=emp_edit" class="dropbtn btn-small btn-color btn-pad">Declined Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 


<?php

  }


 ?>
