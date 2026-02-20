<div id="content">
      <p><img src="images/admin.jpg" width="217" height="32" /></p>
      <img class="imgr" src="images/logo2.gif" alt="" width="125" height="125" />
      <p align="justify"><a href="index.php?c=user_admin"><img src="images/user.jpg" alt="User Admin" width="280" height="34" /></a></p>
      
	   <?php if ($_SESSION[SITE_NAME]['usertype'] =='Admin'){ ?>   
	   <p align="justify"><a href="index.php?c=mining_venture_admin"><img src="images/account.jpg" width="280" height="34" Alt="Project Admin"/></a></p>  
	   <p align="justify"><a href="index.php?c=company_dept_admin"><img src="images/add_corporate.gif" width="280" height="57" Alt="Department  Admin"/></a></p>
	   <p align="justify"><a href="index.php?c=location"><img src="images/add_corporate.gif" width="280" height="57" Alt="Location Admin"/></a></p>
     <p align="justify"><a href="index.php?c=asset_group_admin"><img src="images/dependant.jpg" width="280" height="34" alt="Asset Class Admin"/></a></p>
	 <p align="justify"><a href="index.php?c=assert_type_admin"><img src="images/account.jpg" width="280" height="34" Alt="Asset Type Admin"/></a></p>
	 <p align="justify"><a href="index.php?c=assert_admin"><img src="images/patient.jpg" width="280" height="57" alt="Asset Admin" /></a></p>
	  <p align="justify"><a href="index.php?c=partner_admin"><img src="images/patient.jpg" width="280" height="57" alt="Supplier / Partner Admin" /></a></p>
    <?php }?>
    
	
	 <?php //if ($_SESSION[SITE_NAME]['usertype'] =='Admin'){ ?>
     <!-- <p align="justify"><a href="index.php?c=system_parameter"><img src="images/parameters.jpg" alt="System Parameters" width="280" height="34" /></a></p>-->
	  <?php //} ?>
      <p align="justify"><br />
    </p>
      <p align="justify">&nbsp;</p>
      <div align="justify"></div>
<div id="respond"></div>
    </div>