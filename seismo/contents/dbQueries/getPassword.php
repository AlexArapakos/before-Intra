<?php
function getPassword($dbConn,$email)
{
	$query = 'SELECT password FROM user_view WHERE username=:userName';
	
	$statement = oci_parse($dbConn, $query);

  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", $email,100,SQLT_CHR);
				
  		$r = oci_execute($statement);
  		if ($r) 
		{ 
			while($row = oci_fetch_array ($statement, OCI_BOTH))
			{				
				oci_free_statement($statement);
				return $row;
			}
			oci_free_statement($statement);
			return false;			
		}
	}
	return "error";
}
?>