<?php
require_once("contents/dbQueries/checkUserDetails.php");
require_once("contents/functions/validation.php");

function verifyLogin($userName,$password,$dbConn)
{
	settype($errArray,"array");
		
	if(empty($userName) || empty($password))	
		$errArray[] = array('item'=>'nameLogin','error'=>'You must complete both fields.');
	else
	{
		$usrExists=checkUserDetails($dbConn,$userName,md5($password));
	 	if(!is_array($usrExists))
			$errArray[] = array('item'=>'nameLogin','error'=>'You gave wrong values.');
		else
		{
			$_SESSION['userEmail']=$usrExists[0];
			$_SESSION['userName']=$usrExists[2];
			$_SESSION['userRole']=$usrExists[3];
		}
	}	
		
	if(count($errArray)==0)
	{		
		return "";		
	}
	else
		return $errArray;
}
?>