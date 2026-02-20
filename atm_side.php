<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
   <head>
      <meta charset="utf-8">
      <title>ASFC Staff Portal</title>
      <meta name="AFSC Zimbabwe" content="">
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


  <?php if($_SESSION[SITE_NAME]['usertype']=="Admin"){?>
    <a href="index.php?c=inv_edit" class="btn-small btn-color btn-pad">New Inventory&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
				   <div> 
					   	<button onclick="myFunction2()" class="btn-small btn-color btn-pad">Inventory Management&nbsp;</button>
					    <div id="myDropdwn2" class="dropdown-content">
						<a href="index.php?c=inv_admin&flag=A">In Stock</a>
						<a href="index.php?c=inv_admin&flag=D">Out of Stock</a>
				   </div>
				</div>
<script>
				
function myFunction2() {
    document.getElementById("myDropdwn2").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.btn-small')) {
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

		  <!--a href="index.php?c=admin_asset" class="btn-small btn-color btn-pad">Asset Management&nbsp;&nbsp;</a> 
		  <a href="index.php?c=dispose" class="btn-small btn-color btn-pad">Dispose</a> -->
		  <?php }
		  if($_SESSION[SITE_NAME]['usertype']=="Admin"){
			  ?>
        <div> 
              <button onclick="myFunction33()" class="btn-small btn-color btn-pad">Inventory Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
              <div id="myDropdwn33" class="dropdown-content">
            <a href="index.php?c=req_admin&flag=P">Pending Requests</a>
              <a href="index.php?c=req_admin&flag=A">Approved Requests</a>
              <a href="index.php?c=req_admin&flag=D">Declined Requests</a>
           </div>
        </div>
<script>
        
function myFunction33() {
    document.getElementById("myDropdwn33").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.btn-small')) {
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
<div> 
              <button onclick="myFunction333()" class="btn-small btn-color btn-pad">Inventory Categories&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
              <div id="myDropdwn333" class="dropdown-content">
            <a href="index.php?c=cat_edit">New Category</a>
              <a href="index.php?c=cat_admin&flag=A">All Categories</a>
              
           </div>
        </div>
<script>
        
function myFunction333() {
    document.getElementById("myDropdwn333").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.btn-small')) {
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
		  
			<br/><br/><br/><br/>

<?php } 

else 
{
  ?>
  
 
 <a href="index.php?c=req_inv" class="dropbtn btn-small btn-color btn-pad">Search Inventory&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
  <a href="index.php?c=emp_req&flag=P" class="dropbtn btn-small btn-color btn-pad">Pending Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
<a href="index.php?c=emp_req&flag=A" class="dropbtn btn-small btn-color btn-pad">Approved Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 

<a href="index.php?c=emp_req&flag=D" class="dropbtn btn-small btn-color btn-pad">Declined Requests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 

  <?php
}
?>

  
		  