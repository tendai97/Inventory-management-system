
<?php 
include('core/core.php');
if(isset($_SESSION[SITE_NAME]['username'])){
	
	include("home.php");
}
else{
?>
<div class="container">

 <div class="row">
					<p>&nbsp;</p>  
                     <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="contact-form">
                        <h3 class="title"><font color = "0000A0"><strong>Employee Self-Service Portal</strong></font></h3>
                        <p><img src="img/banner.jpg" width="725" height="450"></p>
                        <!--div class="divider"></div>-->
                       
                     </div>
                     <div class="col-lg-4 col-md-4 col-xs-12 col-sm-6">
                        <div class="address widget">
                          <h3 class="title"><font color = "0000A0"><strong>Login Panel </strong></font></h3>
                           <ul class="contact-us">
                              <li>                              </li>
                           </ul>
                        </div>
						 <p>&nbsp;</p>  
                        <div class="contact-info widget">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <!-- <form autocomplete="off" method="post" action="core/checklogin.php"  id="loginForm" >-->
					 <form autocomplete="off" method="post" action="core/change_pswd.php"  id="loginForm" >
					 <input class="form-control"  name="op" type="hidden" value="login" required>
                            <label>Username: <span>*</span></label>
                            <input class="form-control" id="username" name="user" type="text" value="" required>
                         <p>&nbsp;</p>
                                                  
                              <label>Password: <span>*</span></label>
                              <input class="form-control" id="password" name="pass" type="password" value="" required>
                         
						 <p>&nbsp;</p>   
                         <p>
                              <input class="btn-small btn-color btn-pad" type="submit" name="login" id="login" value="login">
                               <input class="btn-small btn-color btn-pad" type="reset"   value="Clear">
                            </p>
                         <p><?php echo "<br><font color=red  >".$_GET['msg']. "</font>" ;?></p>
                       </form>
                    </div>
                  </div>
                  
               </div>
            </div>
          <!--  <div class="row">  
			
                <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                    <div class="login-form">
                        <h3>Login </h3>
                    
						 <form method="post" action="core/change_pswd.php"  id="loginForm" role="form">
						  <input class="form-control"  name="op" type="hidden" value="login" required>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" name="user">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pass">
                        </div>                   
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-theme-bg">Login</button>
                       
                        <a href="#">Forget Password?</a>
                    </form>
                    </div>
                </div>
            </div>-->
        </div>
<?php } ?>