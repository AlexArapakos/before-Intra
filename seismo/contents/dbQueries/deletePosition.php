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
	
	$query = 'DELETE FROM POSITION WHERE USERNAME=:userName AND POSITION_NAME=:positionName';
	
	$statement = oci_parse($dbConn, $query);
  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", $userName,100,SQLT_CHR);
		oci_bind_by_name($statement,":positionName", $positionName,100,SQLT_CHR);
		
  		$r = oci_execute($statement);
		if ($r) 
		{ 
			if(oci_num_rows($statement)>0)
			{				
				oci_free_statement($statement);
				echo "deleted correctly";
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