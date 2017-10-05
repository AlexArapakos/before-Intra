<?php

function updateQuake($dbConn, $date, $lat, $lon, $depth)
{
	$query  =  "INSERT INTO QUAKE (QUAKEID, HAS_MACRO, DATETIME, EPICENTER, DEPTH, CATALOG_ID, LDDATE, FECODE, HAS_INFO)
				VALUES (QUAKE_SEQ.nextval, '0', TO_DATE(:quakedate, 'SYYYY-MM-DD HH24:MI:SS'), mdsys.SDO_GEOMETRY(2001, 8307, SDO_POINT_TYPE(:lon, :lat, NULL), NULL, NULL), :depth, '22', SYSDATE, '0', '0')";
	
	$statement = oci_parse($dbConn, $query);
	if ($statement)
	{
		oci_bind_by_name($statement,":quakedate", $date, 24);
		oci_bind_by_name($statement,":lat", $lat);
		oci_bind_by_name($statement,":lon", $lon);
		oci_bind_by_name($statement,":depth", $depth);
	
		$r = oci_execute($statement, OCI_DEFAULT);
		if ($r) 
		{
			oci_free_statement($statement);
			return "Table Quake updated correctly!";
		}
		else
		{
			return "error";
		}
	}
	else
	{	
		return "error";
	}
}

?>