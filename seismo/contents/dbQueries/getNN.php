<?php 

require_once("../dbConnect.php");
$dbConn=connectToDatabase();

$dom = new DOMDocument("1.0");
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
	$lat = $_GET["lat"];
	$lon = $_GET["lon"];	
	$nNum = $_GET["nNum"];
	$mag = $_GET["mag"];
	$source = $_GET["source"];		
		
	$query = "SELECT CATALOG_NAME, QUAKEID , TO_CHAR(DATETIME,'SYYYY-MM-DD HH24:MI:SS'), LATITUDE, LONGITUDE, DEPTH, QUAKE_AGENCY, FECODE, HAS_MACRO, HAS_INFO, MAGNITUDE FROM quake_mag_catalog q WHERE q.magnitude >=:mag AND SDO_NN(q.EPICENTER, MDSYS.SDO_GEOMETRY(2001, 8307, MDSYS.SDO_POINT_TYPE( :lon, :lat, NULL), NULL, NULL), 'sdo_batch_size=0') = 'TRUE' AND q.source = :source AND ROWNUM <= :nNum ORDER BY q.datetime ";
			
    $statement = oci_parse($dbConn, $query);	
	
	if ($statement) 
	{			
		oci_bind_by_name($statement,":mag", $mag);
		oci_bind_by_name($statement,":lon", $lon);
		oci_bind_by_name($statement,":lat", $lat);		
		oci_bind_by_name($statement,":source", $source,10,SQLT_CHR);
		oci_bind_by_name($statement,":nNum", $nNum);		
		
		$r = oci_execute($statement);
		if ($r) 
		{ 
			header("Content-type: text/xml");				    
    	
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{
				$node = $dom->createElement("quake");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("catalog", $row[0]);
				$newnode->setAttribute("code", $row[1]);
				$newnode->setAttribute("datetime", $row[2]);
				$newnode->setAttribute("lat", str_replace(",", ".",$row[3]));
				$newnode->setAttribute("lon", str_replace(",", ".",$row[4]));
				$newnode->setAttribute("depth", $row[5]);
				if (!empty($row[6]))
					$newnode->setAttribute("agency", $row[6]);
				else
					$newnode->setAttribute("agency", "Uknown");	
				if (!empty($row[7]))
					$newnode->setAttribute("fe", $row[7]);
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
				$newnode->setAttribute("mag", str_replace(",", ".",$row[10]));									
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