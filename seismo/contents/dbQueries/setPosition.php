<?php

require_once("../dbConnect.php");
$dbConn=connectToDatabase();
if($dbConn==false)
{
	echo "Error: Failed to connect with database!";
}
else
{
	$userName = trim ($_GET['userName']);
	$positionName = trim ($_GET['positionName']);
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$zoom = trim ($_GET['zoom']);
	
	$query = 'SELECT POSITION_NAME FROM POSITION WHERE USERNAME=:userName';
	$query2 = 'INSERT INTO "SEISMO"."POSITION" (USERNAME, POSITION_NAME, LAT, LON, ZOOM) VALUES (:userName, :positionName, :lat, :lng, :zoom)';
	
	$statement1 = oci_parse($dbConn, $query);
	$statement = oci_parse($dbConn, $query2);
  	if ($statement1 && $statement) 
	{
		oci_bind_by_name($statement1,":userName", $userName,100,SQLT_CHR);
		oci_bind_by_name($statement,":userName", $userName,100,SQLT_CHR);
		oci_bind_by_name($statement,":positionName", $positionName,100,SQLT_CHR);
		oci_bind_by_name($statement,":lat", $lat);
		oci_bind_by_name($statement,":lng", $lng);
		oci_bind_by_name($statement,":zoom", $zoom);
		
  		$r = oci_execute($statement1);
		if ($r) 
		{ 
			$i=0;
			while($row = oci_fetch_array ($statement1, OCI_BOTH))
			{				
				if ($positionName == $row[0])
					$i++;
			}
			oci_free_statement($statement1);
			if ($i!=0)
			{
				echo "Error: You have already save a position with the same name!";
			}
		}
		else
		{
			oci_free_statement($statement1);
			echo "Error: Passing incorrect values to the query!";
		}
		
		if (($i==0) || (!$r))
		{
			$r2 = oci_execute($statement);
	  		if ($r2) 
			{ 
				if(oci_num_rows($statement)>0)
				{
					echo "inserted correctly";
				}
				else
				{
					echo "Error: The data could not inserted correctly!";
				}
				oci_free_statement($statement);
			}
			else
			{
				oci_free_statement($statement);
				echo "Error: Passing incorrect values to the query!";
			}
		}
	}
	else
	{	
		echo "Error: Query's syntax error!";
	}
}
?>