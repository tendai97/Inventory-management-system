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
                        <li class="accordion-toggle"><a href="index.php?c=home&app=CA" class=""><i class="fa fa-cloud"></i> WWF Central Administration</a></li>
					<?php }?>
					
                        <li class="accordion-toggle"><a href="index.php?c=home&app=ATM"><i class="fa fa-briefcase"></i>  Asset Tracking & Management</a></li>
						
                        <li class="accordion-toggle"><a href="index.php?c=home&app=LAM"><i class="fa fa-edit"></i> Leave & Absence Management</a></li>
						<ul class="accordion-content" id="ac2"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=VLM"><i class="fa fa-car"></i> Vehicle Logging and Management</a></li>
						<ul class="accordion-content" id="ac4"></ul>
                        <li class="accordion-toggle"><a href="index.php?c=home&app=PRO"><i class="fa fa-file"></i> Requisitions & Purchase Orders</a></li>
						<ul class="accordion-content" id="ac5"></ul>
						<li class="accordion-toggle" > <a href="index.php?c=home&app=TAE"><i class="fa fa-suitcase"></i> Travel advances and expenses</a></li>
						<ul class="accordion-content" id="ac3"></ul>                        
                       
                    </ul>
                           <p></p>
                            <p></p>
                            <p></p>
                           <footer class="post-footer">
                              <!--a class="btn-small btn-color">Quick Reference Guide</a>-->
			<div> 
				<button onclick="myFunction()" class="btn-small btn-color btn-pad">Reference User Guides</button>
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
  if (!event.target.matches('')) {
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
         	
			<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  
				<?php if($_SESSION[SITE_NAME]['usertype']=="Admin"){?>
	
                   		<?php 
						$alerts=0;
						$count = $db->countOf("persons","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Employee Administration Alerts  – to view or action click <a href="index.php?c=emp_admin&alert=1">here</a><span class="pull-right"></span></h3>
                        <?php
						$alerts=$alerts+1;
						}
						$count = $db->countOf("assets","alert_flag='A' or alert_flag='S'");
						if($count > 0 and $_SESSION[SITE_NAME]['a_apro']=="1")
						{
							//$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Administration Alerts  – to view or action click  <a href="index.php?c=assert_admin&app=ATM&alert=1">here</a><span class="pull-right"></span></h3>
                          <?php 
						  $alerts=$alerts+1;
						}
						$count = $db->countOf("projects","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							//$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Projects Administrative Alerts  – to view or action click  <a href="index.php?c=project_admin&alert=1">here</a><span class="pull-right"></span></h3>
                        
					      <?php
						  $alerts=$alerts+1;
						}
						$count = $db->countOf("supplier_partner","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							//$alerts++;
						?>
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Supplier / Partner Admin Alerts  – to view or action click  <a href="index.php?c=partner_admin&alert=1">here</a><span class="pull-right"></span></h3>
                      
					      <?php
						  $alerts=$alerts+1;
						}
						//$count = $db->countOf("","alert_flag='A' or alert_flag='S'");
						$count =0;
						if($count > 0)
						{
							//$alerts++;
						?>
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Budget Administration Alerts  – to view or action click  <a href="#">here</a><span class="pull-right"></span></h3>
                           <?php 
						   $alerts=$alerts+1;
						}
						$count =0;
						//$count = $db->countOf("","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							//$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Annual Calendar Admin Alerts  – to view or action click  <a href="#">here</a><span class="pull-right"></span></h3>
                       
						<?php 
						$alerts=$alerts+1;
						}
						if($alerts==0){
						?>
						 <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Administrative Action Items requiring attention!!<span class="pull-right"></span></h3>
						
	<?php }  } 
	
			$emp = $db->queryUniqueObject("SELECT * FROM persons WHERE id =".$_SESSION[SITE_NAME]['person']);

			if($emp->hierarchy_ind  == "C") {
				
					$count = $db->countOf("emp_leaves","active = '1' and alert_flag='S' and employee <> '$emp->id' and dept_level = 'C' ");
						if($count > 0)
							{
							
							?>
							<div class="progress">
								<div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
								</div>
							</div><h3 class="heading-progress"> You have SUPERVISORY Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/dept_pending_apps&dept=<?php echo $emp->department;?>&app=LAM&alert=1">here</a><span class="pull-right"></span></h3>
							   <?php 
							}	
						}	
			elseif($emp->hierarchy_ind <> "S") {
				
					$count = $db->countOf("emp_leaves","active = '1' and alert_flag='S' and employee <> '$emp->id' and department = '$emp->department' and dept_level = '$emp->hierarchy_ind' ");
						if($count > 0)
							{
							
							?>
							<div class="progress">
								<div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
								</div>
							</div><h3 class="heading-progress"> You have SUPERVISORY Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/dept_pending_apps&dept=<?php echo $emp->department;?>&app=LAM&alert=1">here</a><span class="pull-right"></span></h3>
							   <?php 
							}	
						
			}							
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
						$count = $db->countOf("assets","alert_flag='E' and custodian='".$_SESSION[SITE_NAME]['person']." '");
						//echo $_SESSION[SITE_NAME]['person'];
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Management Alerts  – to view or action click  <a href="index.php?c=asset&app=ATM&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						$count = $db->countOf("visit","isnull(conclusion_date) and auditor='".$_SESSION[SITE_NAME]['username']."'");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have an Unfinished Assets Inspection Alert  – to action click  <a href="index.php?c=visit&app=ATM&alert=1">here</a><span class="pull-right"></span></h3>
						
						
							<?php 
						}
						$count = $db->countOf("emp_leaves","active = '1' and alert_flag='E' and employee ='".$_SESSION[SITE_NAME]['person']." '");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have SELF Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/emp_outstanding_app&app=LAM&emp=<?php echo $_SESSION[SITE_NAME]['person']?>&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						$count = $db->countOf("vehicle_requests","active = '1' and alert_flag='E' and employee ='".$_SESSION[SITE_NAME]['person']." '");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have SELF Vehicle Management Alerts  – to view or action click  <a href="index.php?c=vehicles/emp_pending_rqsts&app=VLM&emp=<?php echo $_SESSION[SITE_NAME]['person']?>&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						if($alerts==0){
						?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Employee Action Items requiring attention!!<span class="pull-right"></span></h3>
								
	<?php } 
	
	?>
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
                          <header class="post-header">
                            <h3 class="content-title"><strong><font color="purple">WWF ZIM Staff Bulletin Board / News Articles</font></strong></h3>
                              <div class="blog-entry-meta">

                                 <div class="blog-entry-meta-author">
                                    <i class="fa fa-tags"></i>
                                    <a href="#" class="blog-entry-meta-author">Human Resources Dept</a>
                                 </div>
                                 <div class="blog-entry-meta-tags">
                                    <i class="fa fa-tags"></i>
                                   <a href="#">Finance Department</a><a href="#"></a>
                                 </div>
                                 <div class="blog-entry-meta-comments">
                                    <i class="fa fa-tags"></i>
                                    <a href="#" class="blog-entry-meta-comments">Conservation Projects</a>
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
	else { ?>
	<br />
		<?php if($_GET['app']=="CA"){?>
	
	<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  			   
						<?php 
						$alerts=0;
						$count = $db->countOf("persons","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Employee Administration Alerts  – to view or action click <a href="index.php?c=emp_admin&alert=1">here</a><span class="pull-right"></span></h3>
                        <?php 
						}
						$count = $db->countOf("assets","alert_flag='A' or alert_flag='S'");
						if($count > 0 and $_SESSION[SITE_NAME]['a_apro']=="1")
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Administration Alerts  – to view or action click  <a href="index.php?c=assert_admin&app=ATM&alert=1">here</a><span class="pull-right"></span></h3>
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
						$count =0;
						//$count = $db->countOf("","alert_flag='A' or alert_flag='S'");
						if($count > 0)
						{
							$alerts++;
						?>
					   
					   <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Annual Calendar Admin Alerts  – to view or action click  <a href="#">here</a><span class="pull-right"></span></h3>
                       
						<?php }
						if($alerts==0){
						?>
						 <div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
				</div><h3 class="heading-progress"> You have ZERO (0) Administrative Action Items requiring attention!!<span class="pull-right"></span></h3>
						
	<?php } ?>
	
	<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div>
						<br />
	
	<?php } if($_GET['app']=="ATM"){?>
	
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
						$count = $db->countOf("assets","alert_flag='E' and custodian='".$_SESSION[SITE_NAME]['person']." '");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have Asset Management Alerts  – to view or action click  <a href="index.php?c=asset&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						$count = $db->countOf("visit","isnull(conclusion_date) and auditor='".$_SESSION[SITE_NAME]['username']."'");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have an Unfinished Assets Inspection Alert  – to action click  <a href="index.php?c=visit&alert=1">here</a><span class="pull-right"></span></h3>
						
						
							<?php }
						if($alerts==0){
						?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) Asset Management Alerts – to initiate an Action click  <a href="index.php?c=admin_asset">here</a><span class="pull-right"></span></h3>
							
	<?php }
	?>
	
	<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div>
						<br />
	<?php
	}	if($_GET['app']=="LAM"){?>
	
	<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  	
						   <?php 
						   
	
				$emp = $db->queryUniqueObject("SELECT * FROM persons WHERE id =".$_SESSION[SITE_NAME]['person']);

				if($emp->hierarchy_ind  == "C") {
				
					$count = $db->countOf("emp_leaves","active = '1' and alert_flag='S' and employee <> '$emp->id' and dept_level = 'C' ");
						if($count > 0)
							{
							
							?>
							<div class="progress">
								<div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
								</div>
							</div><h3 class="heading-progress"> You have SUPERVISORY Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/dept_pending_apps&dept=<?php echo $emp->department;?>&app=LAM&alert=1">here</a><span class="pull-right"></span></h3>
							   <?php 
							}	
						}	
				elseif($emp->hierarchy_ind <> "S") {
					
						$count = $db->countOf("emp_leaves","active = '1' and alert_flag='S' and employee <> '$emp->id' and department = '$emp->department' and dept_level = '$emp->hierarchy_ind' ");
							if($count > 0)
								{
							
							?>
							<div class="progress">
								<div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
								</div>
							</div><h3 class="heading-progress"> You have SUPERVISORY Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/dept_pending_apps&dept=<?php echo $emp->department;?>">here</a><span class="pull-right"></span></h3>
							   <?php 
							}	
						
			}									   
						   
						$alerts=0;
						
						$count = $db->countOf("emp_leaves","alert_flag='E' and employee ='".$_SESSION[SITE_NAME]['person']." '");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have SELF Leave of Absence Management Alerts  – to view or action click  <a href="index.php?c=leave/emp_outstanding_app&emp=<?php echo $_SESSION[SITE_NAME]['person']?>&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						
						if($alerts==0){
						?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have ZERO (0) SELF Leave Management Alerts – click  <a href="index.php?c=leave/apply&emp=<?php echo $_SESSION[SITE_NAME]['person']?>">here</a> to make a New Leave Application <span class="pull-right"></span></h3>
							
	<?php }
	?>
	
	<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div>
						<br />
	<?php
	}     if($_GET['app']=="VLM"){?>
	
	<h3 class="heading-progress"><font color = "ff0000"><p class="blinking"><strong> **** YOUR DASHBOARD ALERTS **** </strong></p></font><span class="pull-right"></span></h3>
                  	
						   <?php 
						   
	
				$emp = $db->queryUniqueObject("SELECT * FROM persons WHERE id =".$_SESSION[SITE_NAME]['person']);

				if($_SESSION[SITE_NAME]['ao'] == "1" and $emp->hierarchy_ind <> "S") {
					
						$count = $db->countOf("vehicle_requests","active = '1' and alert_flag='S' and employee <> '$emp->id' ");
							if($count > 0)
								{
							
							?>
							<div class="progress">
								<div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
								</div>
							</div><h3 class="heading-progress"> You have SUPERVISORY Vehicle Fleet Management Alerts  – to view or action click  <a href="index.php?c=vehicles/pending_requests">here</a><span class="pull-right"></span></h3>
							   <?php 
							}	
						
			}									   
						   
						$alerts=0;
						
						$count = $db->countOf("vehicle_requests","alert_flag='E' and employee ='".$_SESSION[SITE_NAME]['person']." '");
						if($count > 0)
						{
							$alerts++;
						?>
						<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have SELF Vehicle Fleet Management Alerts  – to view or action click  <a href="index.php?c=vehicles/emp_pending_rqsts&emp=<?php echo $_SESSION[SITE_NAME]['person']?>&alert=1">here</a><span class="pull-right"></span></h3>
						   <?php 
						}
						
						if($alerts==0){
						?>  
<div class="progress">
                            <div class="progress-bar" style="width: 88%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="82" role="progressbar">
                            </div>
                        </div><h3 class="heading-progress"> You have NO (0) SELF Vehicle Fleet Management Alerts – click  <a href="index.php?c=vehicles/vehicle_request&emp=<?php echo $_SESSION[SITE_NAME]['person']?>">here</a> to make a New Allocation Request <span class="pull-right"></span></h3>
							
	<?php }
	?>
	
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
			<?php }			
	?>