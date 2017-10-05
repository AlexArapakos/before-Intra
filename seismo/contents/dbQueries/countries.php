<?php 
function getCountries($dbConn)
{
	$query = 'SELECT councode, name FROM country ORDER BY name';

  	$statement = oci_parse($dbConn, $query);
  	if ($statement) 
	{
      	$r = oci_execute($statement);
  		if ($r) 
		{
    		settype($retArray,"array");
	
			while ($row = oci_fetch_array ($statement, OCI_BOTH)) 
			{
				$retArray[] = $row;
			}
			oci_free_statement($statement);
			return $retArray;
		}
	}
	return "error";
}

?>
