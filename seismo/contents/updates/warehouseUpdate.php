<?php 

$dbConn = oci_connect('seismodw', 'seismodw', '//195.251.230.16:1521/ORCL');
if($dbConn)
{	
	$query  =  "begin execute immediate 'grant execute on etl_sp to public'; etl_sp; end;";
	
	$statement = oci_parse($dbConn, $query);
	if ($statement)
	{
		$r = oci_execute($statement);
		if ($r) 
		{
			oci_free_statement($statement);
			echo "Warehouse updated correctly!";
		}
		else
		{
			echo "error3";
		}
	}
	else
	{	
		echo "error2";
	}
	oci_close($dbConn);
}
else
{
	echo "error1";
}

?>