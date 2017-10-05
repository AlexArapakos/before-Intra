<?php 
function userExists($dbConn,$email)
{
	$query = 'SELECT username FROM user_view WHERE username=:email';
	
	$statement = oci_parse($dbConn, $query);

  	if ($statement) 
	{
		oci_bind_by_name($statement,":email", $email,100,SQLT_CHR);
		
  		$r = oci_execute($statement);
  		if ($r) 
		{ 
			if(is_array(oci_fetch_array ($statement, OCI_BOTH)))
			{
				oci_free_statement($statement);
				return true;
			}
			else
			{
				oci_free_statement($statement);
				return false;
			}
		}
	}
	return "error";
}
?>