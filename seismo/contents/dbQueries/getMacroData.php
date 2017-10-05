<?php 

require_once("../dbConnect.php");
$dbConn=connectToDatabase();

$dom = new DOMDocument("1.0", 'iso-8859-1');
$node = $dom->createElement("macros");
$parnode = $dom->appendChild($node);	

if($dbConn==false)
{	
	$node = $dom->createElement("macro");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("macroId", "error");	
	echo $dom->saveXML();
}
else
{
	$quake = $_GET["quake"];
	$minIntensity = $_GET["minIntensity"];
	$maxIntensity = $_GET["maxIntensity"];
	
	$query = "SELECT * FROM MACRO_VIEW m WHERE m.QUAKEID = :quake AND m.intensity >= :minIntensity AND m.intensity <= :maxIntensity";
	
	$statement = oci_parse($dbConn, $query);	
	
	if ($statement) 
	{	
		oci_bind_by_name($statement,":quake", $quake);
		oci_bind_by_name($statement,":minIntensity", $minIntensity);
		oci_bind_by_name($statement,":maxIntensity", $maxIntensity);
		
		$r = oci_execute($statement);
		if ($r) 
		{ 
			header("Content-type: text/xml");				    
			
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{
				$node = $dom->createElement("macro");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("catalog", trim (stripslashes ($row[0])));
				$newnode->setAttribute("azimuth", floatval (trim (stripslashes (str_replace(",", ".",$row[1])))));
				$newnode->setAttribute("distance", floatval (trim (stripslashes (str_replace(",", ".",$row[2])))));
				$newnode->setAttribute("hypdist", floatval (trim (stripslashes (str_replace(",", ".",$row[3])))));
				$newnode->setAttribute("intensity", floatval (trim (stripslashes (str_replace(",", ".",$row[4])))));
				$newnode->setAttribute("intensityC", trim (stripslashes ($row[5])));				
				$newnode->setAttribute("macroId", trim (stripslashes ($row[6])));				
				$newnode->setAttribute("nameEn", trim (stripslashes ($row[8])));
				$newnode->setAttribute("prefectureEn", trim (stripslashes ($row[11])));
				$newnode->setAttribute("pop", trim (stripslashes ($row[12])));
				$newnode->setAttribute("lon", floatval (trim (stripslashes (str_replace(",", ".",$row[13])))));
				$newnode->setAttribute("lat", floatval (trim (stripslashes (str_replace(",", ".",$row[14])))));
				$newnode->setAttribute("country", trim (stripslashes ($row[15])));
			}	
			
			oci_free_statement($statement);
			echo $dom->saveXML();
		}
		else
		{
			$node = $dom->createElement("macro");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("macroId", "error");
			echo $dom->saveXML();			
		}
	}
	else
	{	
		$node = $dom->createElement("macro");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("macroId", "error");
		echo $dom->saveXML();
	}
}

?>