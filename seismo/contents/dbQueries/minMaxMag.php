<?php
function getMinMag()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT MIN(magnitude) from mag_view ';
	
		$statement = oci_parse($dbConn, $query);

  		if ($statement) 
		{
			$r = oci_execute($statement);
  			if ($r) 
			{ 
				while($row = oci_fetch_array ($statement, OCI_BOTH))
				{				
					oci_free_statement($statement);
					return str_replace(",", ".",$row[0]);
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

function getMaxMag()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT MAX(magnitude) from mag_view ';
	
		$statement = oci_parse($dbConn, $query);

  		if ($statement) 
		{
			$r = oci_execute($statement);
  			if ($r) 
			{ 
				while($row = oci_fetch_array ($statement, OCI_BOTH))
				{				
					oci_free_statement($statement);
					return str_replace(",", ".",$row[0]);
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