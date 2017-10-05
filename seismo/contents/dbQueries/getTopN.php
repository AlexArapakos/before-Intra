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
	$topN = intval (trim ($_GET["topN"]));
	$quakeType = $_GET["quakeType"];	
	$minLat = $_GET["minLat"];
	$maxLat = $_GET["maxLat"];
	$minLon = $_GET["minLon"];
	$maxLon = $_GET["maxLon"];
	$source = $_GET["source"];		
		
	$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source";
		
	if($quakeType==0)
		$query = $query." ORDER BY MAGNITUDE DESC";
	else if($quakeType==1)
		$query = $query." ORDER BY MAGNITUDE ASC";
	else if($quakeType==2)
		$query = $query." ORDER BY DEPTH DESC";
	else if($quakeType==3)
		$query = $query." ORDER BY DEPTH ASC";
	else if($quakeType==4)
		$query = $query." ORDER BY DATETIME DESC";	
	else
		$query = $query." ORDER BY DATETIME ASC";		
		
	$query = $query.") WHERE ROWNUM <= :topN";
		
    $statement = oci_parse($dbConn, $query);	
	
	if ($statement) 
	{						
		oci_bind_by_name($statement,":minLon", $minLon);
		oci_bind_by_name($statement,":minLat", $minLat);
		oci_bind_by_name($statement,":maxLon", $maxLon);
		oci_bind_by_name($statement,":maxLat", $maxLat);
		oci_bind_by_name($statement,":source", $source,10,SQLT_CHR);
		oci_bind_by_name($statement,":topN", $topN);		
		
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