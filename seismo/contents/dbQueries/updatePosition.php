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
	
	$query = 'UPDATE POSITION SET LAT=:lat, LON=:lng, ZOOM=:zoom WHERE USERNAME=:userName AND POSITION_NAME=:positionName';
	
	$statement = oci_parse($dbConn, $query);
  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", $userName,100,SQLT_CHR);
		oci_bind_by_name($statement,":positionName", $positionName,100,SQLT_CHR);
		oci_bind_by_name($statement,":lat", $lat);
		oci_bind_by_name($statement,":lng", $lng);
		oci_bind_by_name($statement,":zoom", $zoom);
		
  		$r = oci_execute($statement);
		if ($r) 
		{ 
			if(oci_num_rows($statement)>0)
			{				
				oci_free_statement($statement);
				echo "inserted correctly";
			}
			else
			{
				oci_free_statement($statement);
				echo "Error: The data could not inserted correctly!";
			}
		}
		else
		{
			oci_free_statement($statement);
			echo "Error: Passing incorrect values to the query!";
		}
	}
	else
	{	
		echo "Error: Query's syntax error!";
	}
}
?>