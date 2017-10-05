<?php
function connectToDatabase()
{
	$dbConn = oci_connect('seismo', 'seismo', '//195.251.230.16:1521/ORCL');
	if ($dbConn)
	{
		return $dbConn;
	}
	else
	{
		return false;
	}
}
?>
