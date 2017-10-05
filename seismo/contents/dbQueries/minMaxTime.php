<?php

function getMinTime()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT TO_CHAR(MIN(DATETIME),\'DD/MM/SYYYY\') from quake_mag_catalog ';
	
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

function getMaxTime()
{
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	
	if($dbConn==false)
	{	
		return "error";
	}
	else
	{
		$query = 'SELECT TO_CHAR(MAX(DATETIME),\'DD/MM/SYYYY\') from quake_mag_catalog ';
	
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