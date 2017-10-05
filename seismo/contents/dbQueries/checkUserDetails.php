<?php 
function checkUserDetails($dbConn,$userName,$password)
{
	$query = 'SELECT user_view.username, user_view.password, user_view.nickname, user_role.role FROM user_view INNER JOIN user_role ON user_view.username=user_role.username WHERE user_view.username=:userName';
	
	$statement = oci_parse($dbConn, $query);

  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", $userName,100,SQLT_CHR);
				
  		$r = oci_execute($statement);
  		if ($r) 
		{ 
			while($row = oci_fetch_array ($statement, OCI_BOTH))
			{				
				if(md5($row[1])==$password)
				{
					oci_free_statement($statement);
					return $row;
				}
			}
			oci_free_statement($statement);
			return false;			
		}
	}
	return "error";
}
?>