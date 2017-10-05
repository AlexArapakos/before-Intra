<?php 
function nicknameExists($dbConn,$nickname)
{
	$query = 'SELECT nickname FROM user_view WHERE nickname=:nickname';
	
	$statement = oci_parse($dbConn, $query);

  	if ($statement) 
	{
		oci_bind_by_name($statement,":nickname", $nickname,30,SQLT_CHR);
		
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