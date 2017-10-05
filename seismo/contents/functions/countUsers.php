<?php		

define("MAX_IDLE_TIME", 3); 

function getOnlineUsers()
{	
	if ($directory_handle = opendir(session_save_path())) 
	{
		$numUsers = 0;
        while (false !== ($file = readdir($directory_handle))) 
		{
            if ($file != "." && $file != "..") 
			{
                if(time()- fileatime(session_save_path() . '\\' . $file) < MAX_IDLE_TIME * 60) 
				{
					$numUsers++;
				} 
            }
        }
        closedir($directory_handle);
        return $numUsers;
	} 
	else 
	{
		return false;		
	}
}
?>