<?php
function sendemail($name1,$email,$ccmail,$message,$subject){
/* check if fields passed are empty

if(/*empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['message'])	||
   !filter_var($email,FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }

echo "Continuing with mail sending......";	*/
$name = $name1;
$email_address = $email;
$message = $message;
	
// create email body and send it	
$to = "$email"; // hi mate thanks for purchase guna theme, just replace your email with emailme@myprogrammingblog.com
$email_subject = "$subject";
$email_body = "$message";
$headers = "From: essc.email@wwf.org.zw\n";
$headers .= "Cc: ".$ccmail." \n";	
//$headers .= "Cc: amacheka@horizonview.co\n";	
mail($to,$email_subject,$email_body,$headers);

return true;
}
//sendemail("zita","hmutete@gmail.com","message","Asset Allocation");

?>