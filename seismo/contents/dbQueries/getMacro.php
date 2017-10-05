<?php 
require_once("../dbConnect.php");
$dbConn=connectToDatabase();

$dom = new DOMDocument("1.0", 'iso-8859-1');
$node = $dom->createElement("quakes");
$parnode = $dom->appendChild($node);	

if($dbConn==false)
{	
	$node = $dom->createElement("quake");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("code", "error");	
	echo $dom->saveXML();
}
else
{		
	$query = "SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.has_macro = 1";
		
	$statement = oci_parse($dbConn, $query);	
	
	if ($statement) 
	{
		$r = oci_execute($statement);
		if ($r) 
		{ 
			header("Content-type: text/xml");				    
    	
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{
				$node = $dom->createElement("quake");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("catalog", trim (stripslashes ($row[0])));
				$newnode->setAttribute("code", trim (stripslashes ($row[1])));
				$newnode->setAttribute("datetime", trim (stripslashes ($row[2])));
				$newnode->setAttribute("lat", floatval (trim (stripslashes (str_replace(",", ".",$row[3])))));
				$newnode->setAttribute("lon", floatval (trim (stripslashes (str_replace(",", ".",$row[4])))));
				$newnode->setAttribute("depth", floatval (trim (stripslashes (str_replace(",", ".",$row[5])))));
				if (!empty($row[6]))
					$newnode->setAttribute("agency", trim (stripslashes ($row[6])));
				else
					$newnode->setAttribute("agency", "Uknown");	
				if (!empty($row[7]))
					$newnode->setAttribute("fe", trim (stripslashes ($row[7])));
				else
					$newnode->setAttribute("fe", "Uknown");
				if ($row[8]==0)
					$newnode->setAttribute("macro", "False");
				else
					$newnode->setAttribute("macro", "True");
				if ($row[9]==0)
					$newnode->setAttribute("info", "False");
				else
					$newnode->setAttribute("info", "True");
				$newnode->setAttribute("mag", floatval (trim (stripslashes (str_replace(",", ".",$row[10])))));										
			}	
			
			oci_free_statement($statement);
			echo $dom->saveXML();
		}
		else
		{
			$node = $dom->createElement("quake");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("code", "error");
			echo $dom->saveXML();			
		}
	}
	else
	{	
		$node = $dom->createElement("quake");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("code", "error");
		echo $dom->saveXML();
	}
}

?>