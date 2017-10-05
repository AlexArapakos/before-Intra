<?php
require_once("../dbQueries/getPassword.php");
require_once("../functions/validation.php");

function verifyForgotPassword($email,$dbConn)
{
	settype($errArray,"array");
		
	if(checkEmail($email)==false)
		return "You must give a valid email.";
	else
	{
		$usrExists=getPassword($dbConn,$email);
		if($usrExists==false)
			return 'User with this email does not exist.';
		else if ($usrExists=="error")
			return 'Error during executing query to the database.';
		else
			return $usrExists;	
	}
	return "error";		
}
?>