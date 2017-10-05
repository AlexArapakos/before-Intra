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
	$minMag = $_GET["minMag"];
	$maxMag = $_GET["maxMag"];
	$minDepth = intval (trim ($_GET["minDepth"]));
	$maxDepth = intval (trim ($_GET["maxDepth"]));
	$minLat = $_GET["minLat"];
	$maxLat = $_GET["maxLat"];
	$minLon = $_GET["minLon"];
	$maxLon = $_GET["maxLon"];
	$minDate = $_GET["minDate"];
	$maxDate = $_GET["maxDate"];
	$source = $_GET["source"];
	$mag = $_GET["mag"];
	$depth = $_GET["depth"];
	$time = $_GET["time"];
	
	if($mag==1 && $depth==1 && $time==1)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.magnitude >= :minMag AND q.magnitude <= :maxMag AND q.depth >= :minDepth AND q.depth <= :maxDepth AND q.datetime >= TO_DATE(:minDate, 'syyyy-mm-dd') AND q.datetime <= TO_DATE(:maxDate, 'syyyy-mm-dd') AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($mag==1 && $depth==1 && $time==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.magnitude >= :minMag AND q.magnitude <= :maxMag AND q.depth >= :minDepth AND q.depth <= :maxDepth AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($mag==1 && $time==1 && $depth==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.magnitude >= :minMag AND q.magnitude <= :maxMag AND q.datetime >= TO_DATE(:minDate, 'syyyy-mm-dd') AND q.datetime <= TO_DATE(:maxDate, 'syyyy-mm-dd') AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($time==1 && $depth==1 && $mag==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.depth >= :minDepth AND q.depth <= :maxDepth AND q.datetime >= TO_DATE(:minDate, 'syyyy-mm-dd') AND q.datetime <= TO_DATE(:maxDate, 'syyyy-mm-dd') AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($mag==1 && $depth==0 && $time==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.magnitude >= :minMag AND q.magnitude <= :maxMag AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($depth==1 && $mag==0 && $time==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.depth >= :minDepth AND q.depth <= :maxDepth AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($time==1 && $depth==0 && $mag==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.datetime >= TO_DATE(:minDate, 'syyyy-mm-dd') AND q.datetime <= TO_DATE(:maxDate, 'syyyy-mm-dd') AND q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	else if($time==0 && $depth==0 && $mag==0)
		$query = "SELECT * FROM (SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.LONGITUDE >= :minLon AND q.LONGITUDE <= :maxLon AND q.LATITUDE >= :minLat AND q.LATITUDE <= :maxLat AND q.source = :source ORDER BY q.datetime DESC) WHERE ROWNUM <= 1000";
	
	$statement = oci_parse($dbConn, $query);	
	
	if ($statement) 
	{
		if($mag==1 && $depth==1 && $time==1)
		{
			oci_bind_by_name($statement,":minMag", $minMag);
			oci_bind_by_name($statement,":maxMag", $maxMag);
			oci_bind_by_name($statement,":minDepth", $minDepth);
			oci_bind_by_name($statement,":maxDepth", $maxDepth);			
			oci_bind_by_name($statement,":minDate", $minDate,11,SQLT_CHR);
			oci_bind_by_name($statement,":maxDate", $maxDate,11,SQLT_CHR);			
			
		}
		else if($mag==1 && $depth==1 && $time==0)
		{
			oci_bind_by_name($statement,":minMag", $minMag);
			oci_bind_by_name($statement,":maxMag", $maxMag);
			oci_bind_by_name($statement,":minDepth", $minDepth);
			oci_bind_by_name($statement,":maxDepth", $maxDepth);
		}
		else if($mag==1 && $time==1 && $depth==0)
		{
			oci_bind_by_name($statement,":minMag", $minMag);
			oci_bind_by_name($statement,":maxMag", $maxMag);
			oci_bind_by_name($statement,":minDate", $minDate,11,SQLT_CHR);
			oci_bind_by_name($statement,":maxDate", $maxDate,11,SQLT_CHR);	
		}
		else if($time==1 && $depth==1 && $mag==0)
		{
			oci_bind_by_name($statement,":minDepth", $minDepth);
			oci_bind_by_name($statement,":maxDepth", $maxDepth);			
			oci_bind_by_name($statement,":minDate", $minDate,11,SQLT_CHR);
			oci_bind_by_name($statement,":maxDate", $maxDate,11,SQLT_CHR);
		}
		else if($mag==1 && $depth==0 && $time==0)
		{
			oci_bind_by_name($statement,":minMag", $minMag);
			oci_bind_by_name($statement,":maxMag", $maxMag);
		}
		else if($depth==1 && $mag==0 && $time==0)
		{
			oci_bind_by_name($statement,":minDepth", $minDepth);
			oci_bind_by_name($statement,":maxDepth", $maxDepth);
		}
		else if($time==1 && $depth==0 && $mag==0)
		{
			oci_bind_by_name($statement,":minDate", $minDate,11,SQLT_CHR);
			oci_bind_by_name($statement,":maxDate", $maxDate,11,SQLT_CHR);
		}
		
		oci_bind_by_name($statement,":minLon", $minLon);
		oci_bind_by_name($statement,":minLat", $minLat);
		oci_bind_by_name($statement,":maxLon", $maxLon);
		oci_bind_by_name($statement,":maxLat", $maxLat);
		oci_bind_by_name($statement,":source", $source,10,SQLT_CHR);
		
		
		
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