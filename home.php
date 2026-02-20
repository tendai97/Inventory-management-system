<head>

	<script>
	function blinker() {
		$('.blinking').fadeOut(500);
		$('.blinking').fadeIn(1500);
	}
	setInterval(blinker, 2000);
	</script>
	
	<style>
.dropbtn {
    background-color: #0488cd;
    color: white;
    
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
    background-color: turquoise;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: blue;
    padding: 8px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #f1f1f1}

.show {display:block;}
</style>

</head>

	<?php 
	session_start(); // Use session variable on this page. This function must put on the top of page.
include('core/core.php');
	if(!isset($_GET['app'])){?>
	     <div class="container">
		 <?php unset($_SESSION[SITE_NAME]['app']);?>
                  <div class="row">
                    <div class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<br />
                        <!-- Search Widget Start -->
                        <div class="widget search-form">
                           <div class="input-group">
                              <input type="text" value="Search..." onfocus="if(this.value=='Search...')this.value='';" onblur="if(this.value=='')this.value='Search...';" class="search-input form-control">
                              <span class="input-group-btn">
                              <button type="submit" class="subscribe-btn btn"><i class="fa fa-search"></i></button>
                              </span>
                           </div>
                           <!-- /input-group -->
                        </div>
                        <!-- Search Widget End -->
                                                
                        <!-- Category Widget Start -->
                        <div class="widget category">
                           <h3 class="title">Quick Module Links</h3>
                         
						   <ul class="list-unstyled side-nav" id="accordion">
					<?php 
							//var_dump($_SESSION);
							if($_SESSION[SITE_NAME]['usertype']=="Admin" || $_SESSION[SITE_NAME]['usertype']=="Admin_super") {?>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=CA" class=""><i class="fa fa-user"></i> User Administration</a></li>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=ATM"><i class="fa fa-briefcase"></i>  Inventory Management</a></li>
                        <li class="accordion-toggle"><a href="#"><i class="fa fa-book"></i>  Library Management</a></li>
					<?php }
                else{
          ?>
                      <!--
                        <li class="accordion-toggle"><a href="index.php?c=home&app=CA" class=""><i class="fa fa-cloud"></i> User Profile</a></li>
                      -->
                        <li class="accordion-toggle"><a href="index.php?c=home&app=ATM"><i class="fa fa-briefcase"></i>  Inventory Menu</a></li>
                        <li class="accordion-toggle"><a href="#"><i class="fa fa-book"></i>  Library </a></li>
					<?php }?>
                        
                        <!--
						
                        <li class="accordion-toggle"><a href="index.php?c=home&app=LAM"><i class="fa fa-edit"></i> Leave & Absence Management</a></li>
						<ul class="accordion-content" id="ac2"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=VLM"><i class="fa fa-car"></i> Vehicle Logging and Management</a></li>
						<ul class="accordion-content" id="ac4"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=PRO"><i class="fa fa-file"></i> Requisitions & Purchase Orders</a></li>
						<ul class="accordion-content" id="ac5"></ul>
						<li class="accordion-toggle" > <a href="index.php?c=home&app=TAE"><i class="fa fa-suitcase"></i> Travel advances and expenses</a></li>
						<ul class="accordion-content" id="ac3"></ul>       
						-->                 
                       
                    </ul>
                           <p></p>
                            <p></p>
                            <p></p>
                           <footer class="post-footer">
                              <!--a class="btn-small btn-color">Quick Reference Guide</a>-->
			<div> 
				<button onclick="myFunction()" class="dropbtn btn-small btn-color btn-pad">Reference User Guides</button>
				    <div id="myDropdwn" class="dropdown-content">
						<a href="WWF Zim ESSC User Guide.pdf" target="_blank">Complete WWF E.S.S.C. User Guide</a>
						<a href="index.php?c=home_ugselect">Quick Reference Guide By Module</a>
					</div>
			</div>
<script>
				
function myFunction() {
    document.getElementById("myDropdwn").classList.toggle("show");
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
 <script type="text/javascript">
<!--
function popup(url) 
{
 var width  = 800;
 var height = 425;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
// -->
</script>
		
                           </footer>
                        </div>
                        <!-- Category Widget End -->
                        <!-- Ads Widget Start -->
                        <div class="widget ads">
                          <div class="ads-img row"></div>
                          <div class="ads-img row"></div>
                      </div>
                       <!-- Ads Widget End -->
                     </div>
                     <!-- Sidebar End -->                
                     <div class="posts-block col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <br />
						<article class="post hentry">
         	
			<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span> <?php $uss = $db->queryUniqueObject("SELECT * FROM users WHERE id = ".$_SESSION[SITE_NAME]['id']);
			 ?></h3>
                  
				<?php 

        if(($_SESSION[SITE_NAME]['usertype']=="User" )){
          $emp_alerts=0;
          $count = $db->countOf("requests","status='P' and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Pending Requests Awaiting Admin Action  – to view click <a href="index.php?c=emp_req&flag=P&app=ATM">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }

            $count = $db->countOf("requests","status='A' and active =1 and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Admin Has Approved Your Request  – to view  click <a href="index.php?c=emp_req&flag=A&app=ATM&up=A">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }
            $count = $db->countOf("requests","status='D' and active =1 and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Admin Has Declined Your Request  – to view click <a href="index.php?c=emp_req&flag=D&app=ATM&up=D">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }
            if($emp_alerts==0){
            ?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Alerts – to initiate an Action click  <a href="index.php?c=req_inv">here</a><span class="pull-right"></span></h3>
              
                 <?php }




        }

				$alerts=0; 


				if(($_SESSION[SITE_NAME]['usertype']=="Admin" )){
	
						$count = $db->countOf("requests","status='P'");
						if($count > 0)
						{
							$alerts=$alerts+1;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Inventory Request Alerts  – to view or action click <a href="index.php?c=req_admin&&flag=P&app=ATM">here</a><span class="pull-right"></span></h3>
                        <?php
						
						}

						$count = $db->countOf("users","status='New'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Employee Activation Alerts  – to view or action click  <a href="index.php?c=dept_admin&flag=D&app=CA">here</a><span class="pull-right"></span></h3>

                        <?php
						
						}

						$count = $db->countOf("assets","available< 5 ");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Inventory that are Depleted – to view or action click  <a href="index.php?c=inv_admin&flag=D&app=ATM">here</a><span class="pull-right"></span></h3>
                        <?php
                    	}
					}

				
                      
						

					if(($_SESSION[SITE_NAME]['usertype']=="Admin") ){
						$count = $db->countOf("users","status='Online'");
						if($count > 0)
						{
							$alerts++;
						?>
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress">  Number of users Online (   <?php echo $count?>    )  <span class="pull-right"></span></h3>
                     <?php }} ?>
					     
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div>
						<br />
                       </article>
                        <!--div class="blog-divider"></div-->
                        
                        <!--article class="post hentry"> </article-->
                        
                       
                     </div>
                     
                                  
                     <div class="posts-block col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <article class="post hentry">
                            <h3 class="content-title"><strong><font color="purple">WWF ZIM Staff Bulletin Board / News Articles</font></strong></h3>
                              <div class="blog-entry-meta">

                                 <div class="blog-entry-meta-author">
                                    <i class="fa fa-tags"></i>
                                    <a href="javascript: void(0)" onclick="popup('read.php?dept=hra')">Human Resources Dept</a>
                                 </div>
                                 <div class="blog-entry-meta-tags">
                                    <i class="fa fa-tags"></i>
                                     <a href="javascript: void(0)" onclick="popup('read.php?dept=fin')">Finance Department</a>                                 
                                 </div>
                                 <div class="blog-entry-meta-comments">
                                    <i class="fa fa-tags"></i>
                                     <a href="javascript: void(0)" onclick="popup('read.php?dept=con')">Conservation Projects</a>                                 
                                 </div>
                              </div>
                          </header>
                           <div class="post-content"><font color="purple">
                              <p>
                                 “The WWF Zimbabwe Employee Self-Service Centre is an initiative currently under development which seeks to improve administrative systems efficiency and effectiveness. The initiative will see the automation and redesign of some manual processes resulting in improved turnaround time and accuracy. User input /feedback is most welcome and considered central to the organisation getting the best returns from this investment.”
                              </p></font>
                           </div>
                          
                       </article>
                       
                     </div>
                  </div>
               </div>
	<?php }
	else { $alerts=0; ?>
	<br />
		
	<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div>
						<br />
	<?php
	}
	
	?>


					  <!-- 
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Number of New Assets Currently Awaiting Allocation <span class="pull-right">0</span></h3>
                        <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Number of Returned Assets Currently Awaiting Acceptance <span class="pull-right"><font color = "ff0000"><strong>3</strong></font></span></h3>
                        <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
							</div><h3 class="heading-progress"> Number of New Assets Disposed of this year <span class="pull-right">0</span></h3>
                        <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        
                        </div><h3 class="heading-progress"> Number of New Assets Rejected Awaiting Acceptance  <span class="pull-right"><font color = "ff0000"><strong>1</strong></font></span></h3>
                        <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                                                
                        </div> -->
			<?php if(($_SESSION[SITE_NAME]['usertype']=="Admin" ) && $_GET['app']=="ATM"){?>
	
	<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  	
						   <?php 
						$alerts=0;
						//$count = $db->countOf("assets","alert_flag='A' or alert_flag='S'");
						//if($count > 0)
						//{
						//	$alerts++;
						?>
						
					<!--	<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Management Alerts  – to view or action click  <a href="index.php?c=admin_asset&alert=1">here</a><span class="pull-right"></span></h3>
						  --> <?php 
						//}
						//var_dump($_SESSION[SITE_NAME]);
						$count = $db->countOf("assets","active=1");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Total types of Inventory in system  (  <?php echo $count ?>  )</h3>
						   <?php 
						}
						$count = $db->countOf("requests","date=CURDATE()");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Total Requests Made Today      (   <?php echo $count?>  )   <span class="pull-right"></span></h3>
						
						
							<?php }
						if($alerts==0){
						?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Asset Management Alerts – to initiate an Action click  <a href="index.php?c=admin_asset">here</a><span class="pull-right"></span></h3>
							
	<?php }}
	?>
	
	
	<?php if(($_SESSION[SITE_NAME]['usertype']=="Admin" ) && $_GET['app']=="CA"){?>
	
	<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  			   
						<?php 
						if(($_SESSION[SITE_NAME]['usertype']=="Admin" || $_SESSION[SITE_NAME]['usertype']=="Admin_super")  && $uss->h_apro=='1'){
	
							$count = $db->countOf("persons","alert_flag='A' or alert_flag='S'");
							if($count > 0)
							{
								$alerts=$alerts+1;
							?>
							<div class="progress">
	                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
	                            </div>
	                        </div><h3 class="heading-progress"> You have Employee Administration Alerts  – to view or action click <a href="index.php?c=emp_admin&alert=1&flag=D&app=CA">here</a><span class="pull-right"></span></h3>

							<?php
						
						}

						$count = $db->countOf("company_dept","status='New - Awaiting Activation' or status='Deactivation - Awaiting Approval'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Company Department Alerts  – to view or action click  <a href="index.php?c=dept_admin&flag=D&app=CA">here</a><span class="pull-right"></span></h3>

	                        <?php 
							}
						}
						if(($_SESSION[SITE_NAME]['usertype']=="Admin" || $_SESSION[SITE_NAME]['usertype']=="Admin_super") && $uss->a_apro=='1'){	
							$count = $db->countOf("assets","alert_flag='A' or alert_flag='S'");
						if($count > 0 and $_SESSION[SITE_NAME]['a_apro']=="1")
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Administration Alerts  – to view or action click  <a href="index.php?c=assert_admin">here</a><span class="pull-right"></span></h3>
                          <?php 
						}
						$count = $db->countOf("projects","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Projects Administrative Alerts  – to view or action click  <a href="index.php?c=project_admin&alert=1">here</a><span class="pull-right"></span></h3>
         					
         				<?php 
						}
						$count = $db->countOf("asset_type","status='New - Awaiting Activation'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Type Alerts  – to view or action click  <a href="index.php?c=assert_type_admin&alert=A">here</a><span class="pull-right"></span></h3>
                        
                        <?php 
						}
						$count = $db->countOf("asset_group","status='New - Awaiting Activation'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Group Alerts  – to view or action click  <a href="index.php?c=asset_group_admin&alert=A">here</a><span class="pull-right"></span></h3>
						
						
                        
					      <?php 
						}
					}
					if(($_SESSION[SITE_NAME]['usertype']=="Admin" || $_SESSION[SITE_NAME]['usertype']=="Admin_super")  && $uss->f_apro=='1' ){
						$count = $db->countOf("supplier_partner","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							$alerts++;
						?>
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Supplier / Partner Admin Alerts  – to view or action click  <a href="index.php?c=partner_admin&alert=1">here</a><span class="pull-right"></span></h3>
                      
					      <?php 
						}
						//$count = $db->countOf("","alert_flag='A' or alert_flag='S'");
						$count =0;
						if($count > 0)
						{
							$alerts++;
						?>
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Budget Administration Alerts  – to view or action click  <a href="#">here</a><span class="pull-right"></span></h3>
                          
						
                       
						<?php 
						}
					}
						if($alerts==0){
						?>
						 <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
				</div><h3 class="heading-progress"> You have ZERO (0) Administrative Action Items requiring attention!!<span class="pull-right"></span></h3>
						
	<?php } }

if($_SESSION[SITE_NAME]['usertype']=="User" && $_GET['app']=="ATM") {
          $emp_alerts=0;
          $count = $db->countOf("requests","status='P' and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Pending Requests Awaiting Admin Action  – to view click <a href="index.php?c=emp_req&flag=P&app=ATM">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }

            $count = $db->countOf("requests","status='A' and active =1 and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Admin Has Approved Your Request have Pending Requests – to view  click <a href="index.php?c=emp_req&flag=A&app=ATM&up=A">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }
            $count = $db->countOf("requests","status='D' and active =1 and user_id = ".$_SESSION[SITE_NAME]['id']);
            if($count > 0)
            {
              $emp_alerts=$emp_alerts+1;
            ?>
            <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> Admin Has Declined Your Request have Pending Requests – to view click <a href="index.php?c=emp_req&flag=D&app=ATM&up=D">here</a><span class="pull-right"></span></h3>
                        <?php
            
            }
            if($emp_alerts==0){
            ?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Alerts – to initiate an Action click  <a href="index.php?c=req_inv">here</a><span class="pull-right"></span></h3>
              
                 <?php }




        }
  ?>
	