<?php
require_once("../dbQueries/existingUser.php");
require_once("../dbQueries/existingNickname.php");
require_once("../functions/validation.php");

function verifyRegistration($nickName,$email,$password,$passwordConfirm,$firstName,$lastName,$country,$city,$dbConn)
{
	settype($errArray,"array");
	$nickExists=nicknameExists($dbConn,$nickName);
	$usrExists=userExists($dbConn,$email);
	
	if(empty($nickName))	
		$errArray[] = array('item'=>'nickName','error'=>'You must give a nickname.');
	else if($nickExists==true)
		$errArray[] = array('item'=>'nickName','error'=>'User with this nickname already exists.');
	else if($nickExists=="error")
		$errArray[] = array('item'=>'nickName','error'=>'Error during executing query to the database.');	
	else if(checkEmail($email)==false)
		$errArray[] = array('item'=>'email','error'=>'You must give a valid email.');
	else if($usrExists==true)
		$errArray[] = array('item'=>'email','error'=>'User with this email already exists.');
	else if($usrExists=="error")
		$errArray[] = array('item'=>'email','error'=>'Error during executing query to the database.');
	else if(empty($password))
		$errArray[] = array('item'=>'password','error'=>'You must give a pasword.');
	else if(strlen($password)<6)
		$errArray[] = array('item'=>'password','error'=>'You must give a pasword of at least 6 characters.');
	else if($password!=$passwordConfirm)
		$errArray[] = array('item'=>'passwordConfirm','error'=>'Wrong password confirmation.');
	else if(empty($country))
		$errArray[] = array('item'=>'country','error'=>'You must give a country name.');
		
	if(count($errArray)==0)
		return "";
	else
		return $errArray;
}
?>