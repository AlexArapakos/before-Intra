<?php		
	function checkEmail($mail)
	{  
  		if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $mail))
    		return true;
  		else 
    		return false;
	}	
?>