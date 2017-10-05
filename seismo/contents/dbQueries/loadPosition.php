<?php

require_once("../dbConnect.php");
$dbConn=connectToDatabase();

$dom = new DOMDocument("1.0", 'iso-8859-1');
$node = $dom->createElement("positions");
$parnode = $dom->appendChild($node);

if($dbConn==false)
{
	$node = $dom->createElement("position");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("lat", "error");
	$newnode->setAttribute("lng", "Error: Failed to connect with database!");	
	echo $dom->saveXML();
}
else
{
	$userName = trim ($_GET['userName']);
	$positionName = trim ($_GET['positionName']);
	
	$query = "SELECT LAT, LON, ZOOM FROM POSITION WHERE USERNAME=:userName AND POSITION_NAME=:positionName";
	
	$statement = oci_parse($dbConn, $query);
  	if ($statement) 
	{
		oci_bind_by_name($statement,":userName", $userName,100,SQLT_CHR);
		oci_bind_by_name($statement,":positionName", $positionName,100,SQLT_CHR);
		
  		$r = oci_execute($statement);
		if ($r) 
		{ 
			header("Content-type: text/xml");				    
			
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{
				$node = $dom->createElement("position");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("lat", floatval (trim (stripslashes (str_replace(",", ".",$row[0])))));
				$newnode->setAttribute("lng", floatval (trim (stripslashes (str_replace(",", ".",$row[1])))));
				$newnode->setAttribute("zoom", trim (stripslashes ($row[2])));
			}	
			
			oci_free_statement($statement);
			echo $dom->saveXML();
		}
		else
		{
			oci_free_statement($statement);
			$node = $dom->createElement("position");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("lat", "error");
			$newnode->setAttribute("lng", "Error: Passing incorrect values to the query!");
			echo $dom->saveXML();
		}
	}
	else
	{
		$node = $dom->createElement("position");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("lat", "error");
		$newnode->setAttribute("lng", "Error: Query's syntax error!");
		echo $dom->saveXML();
	}
}
?>