 <?php
 include_once "core/db.php"; 
session_start();
session_destroy();
unset($_SESSION[SITE_NAME]["id"]);
unset($_SESSION[SITE_NAME]["username"]);
unset($_SESSION[SITE_NAME]["usertype"]);

header("location:index.php?c=login&msg=You%20have%20been%20logged%20out!");
?>