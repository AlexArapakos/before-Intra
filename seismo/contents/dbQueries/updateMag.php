<?php

function updateMag($dbConn, $mag, $type, $calc)
{
	$query  =  "INSERT INTO MAG (MAGID, QUAKEID, MAGNITUDE, MAGTYPE, CALCULATED, LDDATE)
				VALUES (MAG_SEQ.nextval, QUAKE_SEQ.currval, :mag, :magtype, :calc, SYSDATE)";
		
	$statement = oci_parse($dbConn, $query);
	if ($statement)
	{
		oci_bind_by_name($statement,":mag", $mag);
		oci_bind_by_name($statement,":magtype", $type);
		oci_bind_by_name($statement,":calc", $calc);
		
		$r = oci_execute($statement, OCI_DEFAULT);
		if ($r) 
		{
			oci_free_statement($statement);
			return "Table Mag updated correctly!";
		}
		else
		{
			oci_rollback($dbConn);
			return "error";
		}
	}
	else
	{	
		return "error";
	}
}

?>