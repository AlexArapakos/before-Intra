<?php
require_once("contents/dbConnect.php");
$dbConn=connectToDatabase();
if($dbConn==false)
{
	header('Location: errors/databaseConnectionFailed.htm');
}
else
{
	// User wants to disconnect
	if(isset($_POST['logout']) && $_POST['logout']=="Logout")
	{
		unset($_SESSION['userEmail']);
		unset($_SESSION['userName']);
		unset($_SESSION['userRole']);
			
		if(isset($_COOKIE['seismoSurfer']) && isset($_COOKIE['seismoSurfer']['username']) && isset($_COOKIE['seismoSurfer']['password']))
		{
			setcookie("seismoSurfer[username]",'', time()-3600*24*7);
			setcookie("seismoSurfer[password]",'', time()-3600*24*7);				
		}
		//echo 'Thank you for using Seismo Surfer!<br/>';
	  	//echo 'You have been succesfully logged out.<br/>';		
		echo 'Welcome, guest';
		require_once("contents/users/loginForm.php");
		showLoginForm('','','NO','');
	}
	else
	{
		// User wants to be remembered
		if(isset($_COOKIE['seismoSurfer']) && isset($_COOKIE['seismoSurfer']['username']) && isset($_COOKIE['seismoSurfer']['password']))
		{
			$cookieName = $_COOKIE['seismoSurfer']['username'];
			$cookiePass = $_COOKIE['seismoSurfer']['password'];
			
			require_once("contents/dbQueries/checkUserDetails.php");
			$userDetails = checkUserDetails($dbConn,$cookieName,$cookiePass);
			
			if(is_array($userDetails))
			{	
				$_SESSION['userEmail']=$userDetails[0];
				$_SESSION['userName']=$userDetails[2];
				$_SESSION['userRole']=$userDetails[3];
				setcookie("seismoSurfer[username]", $cookieName, time()+3600*24*7);
				setcookie("seismoSurfer[password]", $cookiePass, time()+3600*24*7);
				echo 'Welcome, '.$_SESSION['userRole'].' '.$_SESSION['userName'];
				require_once("contents/users/logout.php");				
			}
			else
			{
				require_once("contents/users/loginForm.php");
				echo 'Welcome, guest';
				showLoginForm($userName,$password,$remember,array('item'=>'nameLogin','error'=>'You gave wrong values.'));	
			}	
			
		}
		else
		{
			//User wants to login
			if(isset($_POST['nameLogin']) && isset($_POST['passLogin']))
			{
				$userName=$_POST['nameLogin'];
				$password=$_POST['passLogin'];				
			
				$remember=isset($_POST['remindPassword'])?'YES':'NO';
			
				require_once("contents/users/loginVerify.php");		
				$errorMessages=verifyLogin($userName,$password,$dbConn);
				
				if(!is_array($errorMessages))
				{
					if($remember=='YES')
					{
						setcookie("seismoSurfer[username]", $userName, time()+3600*24*7);
						setcookie("seismoSurfer[password]", md5($password), time()+3600*24*7);
					}		
					echo 'Welcome, '.$_SESSION['userRole'].' '.$_SESSION['userName'];			
					require_once("contents/users/logout.php");
				}
				else
				{					
					require_once("contents/users/loginForm.php");
					echo 'Welcome, guest';
					showLoginForm($userName,$password,$remember,$errorMessages);
				}						
			}
			else
			{
				//User is already login
				if(isset($_SESSION['userEmail']) && isset($_SESSION['userName']) && isset($_SESSION['userRole']))
				{
					echo 'Welcome, '.$_SESSION['userRole'].' '.$_SESSION['userName'];
					require_once("contents/users/logout.php");
				}
				//User enters SeismoSurfer for the first time
				else
				{
					require_once("contents/users/loginForm.php");
					echo 'Welcome, guest';
					showLoginForm('','','NO','');
				}
			}
		}
	}
}

?>