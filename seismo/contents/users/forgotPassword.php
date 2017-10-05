<?php
require_once("../dbConnect.php");
$dbConn=connectToDatabase();
if($dbConn==false)
{
	header('Location: errors/databaseConnectionFailed.htm');
}
else
{
	if(isset($_POST['email']))
	{
		$to=trim($_POST['email']);
		
		require_once("forgotPasswordVerify.php");
		$userPass=verifyForgotPassword($to,$dbConn);
		
		if(!is_array($userPass))
		{		
			require_once("forgotPasswordForm.php");
			forgotPasswordForm($to,$userPass);			
		}
		else
		{
			require_once "Mail.php";
			
			$host = "mailgate.otenet.gr";
			$username = "ikakoz";
			$password = "22100";
			
			
			$from = "seismo@webmaster.com";
			$subject='Seismo-Surfer password request';
			$body = "You asked to retrieve your password.\n\n";
			$body .= "User Elements: \n";
			$body .= "User Name: ".$to."\n";
			$body .= "Password: ".$userPass[0]."\n";
            
			$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);
			
			$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username' => $username, 'password' => $password));
			$mail = $smtp->send($to, $headers, $body);
			
			if (PEAR::isError($mail))
			{
				echo '--><div class="title">Password Reminder</div><div class="roundRightContent"><div class="err">Error: Could not send e-mail.</div></div>';
			}
			else
			{
				echo '--><div class="title">Password Reminder</div><div class="roundRightContent"><p>Your Password Has Been Sent.</p>';
            	echo '<p>We have sent an email to <b>'.$to.'</b>.<br/>';
            	echo 'Please check your inbox now for a message with the subject line, Seismo-Surfer password request.</div>';
			}
		}
	}
	else
	{
		require_once("forgotPasswordForm.php");
		forgotPasswordForm('','');			
	}
}
?>