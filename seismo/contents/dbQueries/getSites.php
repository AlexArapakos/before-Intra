<?php 

require_once("../dbConnect.php");
$dbConn=connectToDatabase();

$dom = new DOMDocument('1.0', 'iso-8859-1');
$node = $dom->createElement("sites");
$parnode = $dom->appendChild($node);

if($dbConn==false)
{	
	$node = $dom->createElement("site");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("code", "error");
	echo $dom->saveXML();
}
else
{
	$minPop = intval (trim ($_GET["minPop"]));
	$maxPop = intval (trim ($_GET["maxPop"]));	
	
	$query = "SELECT SITECODE, LONGITUDE, LATITUDE, NAME_EN, POPULATION, PREFECTURE_EN, COUNTRY_NAME FROM SITE_VIEW s WHERE s.POPULATION >= :minPop AND s.POPULATION <= :maxPop";
	
	$statement = oci_parse($dbConn, $query);
	
	if ($statement) 
	{
		oci_bind_by_name($statement,":minPop", $minPop);
		oci_bind_by_name($statement,":maxPop", $maxPop);
		
		$r = oci_execute($statement);
		
		if ($r) 
		{
			header("Content-Type: text/xml");
			
			while ($row = oci_fetch_array ($statement, OCI_BOTH))  
			{						
				$node = $dom->createElement("site");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("code", trim (stripslashes ($row[0])));
				$newnode->setAttribute("lon", floatval (trim (stripslashes (str_replace(",", ".",$row[1])))));
				$newnode->setAttribute("lat", floatval (trim (stripslashes (str_replace(",", ".",$row[2])))));  				
				$newnode->setAttribute("nameEn", trim (stripslashes ($row[3])));  			    
				$newnode->setAttribute("population", trim (stripslashes ($row[4])));  				
				$newnode->setAttribute("prefectureEn", trim (stripslashes ($row[5])));				
				$newnode->setAttribute("country", trim (stripslashes ($row[6])));
			}
			oci_free_statement($statement);
			echo $dom->saveXML();
		}
		else
		{
			$node = $dom->createElement("site");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("code", "error");
			echo $dom->saveXML();			
		}
	}
	else
	{	
		$node = $dom->createElement("site");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("code", "error");
		echo $dom->saveXML();
	}
} 	
	
?>