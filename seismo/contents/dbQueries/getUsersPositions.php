<?php
function getCurrentUserPositions($user)
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	if($dbConn==false)
	{
		return "error";
	}

	$query = 'SELECT POSITION_NAME FROM POSITION WHERE USERNAME=:userName';
	
	$statement = oci_parse($dbConn, $query);
  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", trim($user),100,SQLT_CHR);
		
  		$r = oci_execute($statement);
  		if ($r) 
		{ 
			settype($retArray,"array");
			
			$i=0;
			while($row = oci_fetch_array ($statement, OCI_BOTH))
			{				
				$retArray[$i] = $row[0];
				$i++;
			}
			oci_free_statement($statement);
			return $retArray;			
		}
		//oci_free_statement($statement);
		return "error";
	}
	return "error";
}
?>