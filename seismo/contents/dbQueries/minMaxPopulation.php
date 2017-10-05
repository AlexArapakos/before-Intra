<?php
function getMinPop()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT MIN(POPULATION) from SITE ';
	
		$statement = oci_parse($dbConn, $query);

  		if ($statement) 
		{
			$r = oci_execute($statement);
  			if ($r) 
			{ 
				while($row = oci_fetch_array ($statement, OCI_BOTH))
				{				
					oci_free_statement($statement);
					return $row[0];
				}
				oci_free_statement($statement);
				return "error";			
			}
			else
				return "error";
		}
		else
			return "error";
	}
}

function getMaxPop()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT MAX(POPULATION) from SITE ';
	
		$statement = oci_parse($dbConn, $query);

  		if ($statement) 
		{
			$r = oci_execute($statement);
  			if ($r) 
			{ 
				while($row = oci_fetch_array ($statement, OCI_BOTH))
				{				
					oci_free_statement($statement);
					return $row[0];
				}
				oci_free_statement($statement);
				return "error";			
			}
			else
				return "error";
		}
		else
			return "error";
	}
}
?>