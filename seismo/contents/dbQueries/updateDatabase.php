<?php 

require_once("../dbConnect.php");
require_once("../functions/getGinoaMonthlyList.php");
require_once("../functions/formatDate.php");
require_once("getLastEntry.php");

$dbConn=connectToDatabase();

$dom = new DOMDocument("1.0", 'iso-8859-1');
$node = $dom->createElement("entriesUpdated");
$parnode = $dom->appendChild($node);
header("Content-Type: text/xml");	

$arrayContent = getMonthlyList();
$lastEntry = getLastEntry($dbConn);
$counter = 0;

if($dbConn==false)
{	
	$parnode->setAttribute("num", "error1");
	echo $dom->saveXML();
}
else if(!is_array($arrayContent))
{
	$parnode->setAttribute("num", "error2");
	echo $dom->saveXML();
	oci_close($dbConn);
}
else if (!is_array($lastEntry))
{
	$parnode->setAttribute("num", "error3");
	echo $dom->saveXML();
	oci_close($dbConn);
}
else
{
	$date = $lastEntry[0];
	$date1 = strtotime($date);
	$date2 = date('Y-m-d H:i:s', $date1);
	$lat = floatval ($lastEntry[1]);
	$lon = floatval ($lastEntry[2]);
	$depth = intval ($lastEntry[3]);
	$mag = floatval ($lastEntry[4]);
	//echo count($arrayContent).'<br>';
	
	// for each row of  $arrayContent get date, lat, lon depth and mag
	for ($i = 0; $i < sizeof($arrayContent); ++$i)
	{
		$line = trim($arrayContent[$i]);
		$current_date = trim(substr($line, 0, -32));
		$current_date2 = formatDatetime($current_date);
		$current_lat = floatval (trim(substr($line, 26, -24)));
		$current_lon = floatval (trim(substr($line, 33, -16)));
		$current_depth = intval(trim(substr($line, 40, -8)));
		$current_mag = floatval (trim(substr($line, -3)));
		$mag2 = $current_mag + 0.5;
		//echo 'date='.$current_date2.'   lat='.$current_lat.'   lon='.$current_lon.'   depth='.$current_depth.'   mag='.$current_mag.'   mag='.$mag2.'<br>';
		
		//check if this entry is register on the database
		if((strtotime($current_date2) > strtotime($date2)) || ((strtotime($current_date2)==strtotime($date2)) && (($current_lat!=$lat) || ($current_lon!=$lon) || ($current_depth!=$depth) || ($mag2!=$mag))))
		{
			$counter += 1;
			require_once("updateQuake.php");
			require_once("updateMag.php");
			
			$insertQuake = updateQuake($dbConn, $current_date2, $current_lat, $current_lon, $current_depth);
			if ($insertQuake=='error')
			{
				$counter = "error4";
				break;
			}
			
			$insertMag = updateMag($dbConn, $current_mag, 'ML', '0');
			if ($insertMag=='error')
			{
				$counter = "error5";
				break;
			}
			
			$insertMag = updateMag($dbConn, $mag2, 'Ms', '1');
			if ($insertMag=='error')
			{
				$counter = "error6";
				break;
			}
			
			// Commit the changes to tables
			$r = oci_commit($dbConn);
			if (!r)
			{
				$counter = "error7";
				break;
			}
		}
	}
	$parnode->setAttribute("num", $counter);
	echo $dom->saveXML();
	oci_close($dbConn);
}

?>