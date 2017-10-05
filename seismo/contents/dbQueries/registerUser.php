<?php 
function registerUser($nickName,$email,$password,$firstName,$lastName,$country,$city,$dbConn)
{
	$query = "INSERT INTO seismo_user(username, password, nickname, country, firstname, lastname, city, lddate)  VALUES (:email, :password,:nickName, :country,:firstName, :lastName, :city, default)";
	$query1 = "INSERT INTO user_role (username, role) VALUES (:email, 'surfer') ";
		
	$statement = oci_parse($dbConn, $query);
	$statement1 = oci_parse($dbConn, $query1);

  	if ($statement && $statement1) 
	{
		oci_bind_by_name($statement,":email", $email,100,SQLT_CHR);
		oci_bind_by_name($statement,":password", $password,30,SQLT_CHR);
		oci_bind_by_name($statement,":nickName", $nickName,30,SQLT_CHR);
		oci_bind_by_name($statement,":country", $country,2,SQLT_CHR);		
		oci_bind_by_name($statement,":firstName", $firstName,50,SQLT_CHR);
		oci_bind_by_name($statement,":lastName", $lastName,50,SQLT_CHR);		
		oci_bind_by_name($statement,":city", $city,50,SQLT_CHR);
		
		oci_bind_by_name($statement1,":email", $email,100,SQLT_CHR);
		
  		$r = oci_execute($statement);
		$r1 = oci_execute($statement1);
		
  		if ($r && $r1 ) 
		{ 		
			if(oci_num_rows($statement)>0 && oci_num_rows($statement1)>0)
			{
				oci_free_statement($statement);
				oci_free_statement($statement1);
				return true;
			}
			else
			{
				oci_free_statement($statement);
				oci_free_statement($statement1);
				return false;
			}
		}
		return "error";
	}
	return "error";
}
?>