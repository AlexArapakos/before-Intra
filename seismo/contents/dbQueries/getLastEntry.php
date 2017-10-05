<?php

function getLastEntry($dbConn)
{
	$query  =  "select *
				from (select TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, MAGNITUDE
					from quake_mag_catalog
					where catalog_name = 'GI-NOA Monthly List'
					order by datetime desc)
				where rownum=1";
	
	$statement = oci_parse($dbConn, $query);
	if ($statement)
	{
		$r = oci_execute($statement);
		if ($r) 
		{
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{
				$lastEntry[0] = trim (stripslashes ($row[0]));
				$lastEntry[1] = floatval (trim (stripslashes (str_replace(",", ".",$row[1]))));
				$lastEntry[2] = floatval (trim (stripslashes (str_replace(",", ".",$row[2]))));
				$lastEntry[3] = intval(trim (stripslashes ($row[3])));
				$lastEntry[4] = floatval (trim (stripslashes (str_replace(",", ".",$row[4]))));
			}
			oci_free_statement($statement);
			return $lastEntry;
		}
		else
		{
			return "error";
		}
	}
	else
	{	
		return "error";
	}
}

?>