<?php
	$GLOBALS['fields_name']['user']           	= array("iduser", "username", "password", "email", "insert_date", "status", "iduser_integ");
	$GLOBALS['fields_type']['user']           	= array("number", "varchar", "varchar", "varchar", "varchar", "number", "number");
	
	$GLOBALS['fields_name']['person'] 			= array("idperson", "name", "fantasy_name", "type", "document", "email", "provider", "insert_date", "iduser_integ");
	$GLOBALS['fields_type']['person'] 			= array("number", "varchar", "varchar", "number", "varchar", "varchar", "number", "date", "number");
	
	$GLOBALS['fields_name']['phone'] 			= array("idphone", "idperson", "ddd", "number");
	$GLOBALS['fields_type']['phone'] 			= array("number", "number", "number", "varchar");
	
	$GLOBALS['fields_name']['adress'] 			= array("idadress", "idperson", "adress", "number", "neighborhood", "city", "postal_code", "state");
	$GLOBALS['fields_type']['adress'] 			= array("number", "number", "varchar", "number", "varchar", "varchar", "varchar", "varchar");
	
	#for data process only
	$GLOBALS['is_key']['person'] 				= array("yes", "no", "no", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['phone'] 				= array("yes", "yes", "no", "no");
	$GLOBALS['is_key']['adress'] 				= array("yes", "yes", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['user']					= array("yes", "no", "no", "no", "no", "no", "yes");
?>
