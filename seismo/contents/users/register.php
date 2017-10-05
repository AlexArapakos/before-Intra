<?php
require_once("../dbConnect.php");
$dbConn=connectToDatabase();
if($dbConn==false)
{
	header('Location: errors/databaseConnectionFailed.htm');
}
else if(isset($_POST['nickName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordConfirm']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['country']) && isset($_POST['city']))
{
	$nickName=$_POST['nickName'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$passwordConfirm=$_POST['passwordConfirm'];
	$firstName=$_POST['firstName'];
	$lastName=$_POST['lastName'];
	$country=$_POST['country'];
	$city=$_POST['city'];
	
	require_once("registrationVerify.php");
	$errorMessages=verifyRegistration($nickName,$email,$password,$passwordConfirm,$firstName,$lastName,$country,$city,$dbConn);
	
	if(!is_array($errorMessages))
	{
		require_once("../dbQueries/registerUser.php");
		$registerMessage=registerUser($nickName,$email,$password,$firstName,$lastName,$country,$city,$dbConn);

		if($registerMessage==true)
		{
			echo'--><div class="title">Registration</div><div class="roundRightContent">Registration completed succesfully. Please login from the left by inserting your e-mail and password.</div>';
		}
		else
		{
			echo'--><div class="title">Registration</div><div class="roundRightContent"><div class="err">Error: Could not register user. Try again.</div><br/><a href="#" onclick="loadRightLeftContent(\'contents/users/register.php\',\'contents/users/registerMenu.php\',\'none\')">Register again</a></div>';
		}
	}
	else
	{
		require_once("registrationForm.php");
		showRegistrationForm($nickName,$email,$password,$passwordConfirm,$firstName,$lastName,$country,$city,$errorMessages,$dbConn);			
	}
}
else
{
	require_once("registrationForm.php");
	showRegistrationForm('','','','','','','','','',$dbConn);
}
?>
