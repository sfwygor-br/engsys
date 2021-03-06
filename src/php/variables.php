﻿<?php
	$GLOBALS['fields_name']['user']           	= array("iduser", "username", "password", "email", "insert_date", "status", "iduser_integ");
	$GLOBALS['fields_type']['user']           	= array("number", "varchar", "varchar", "varchar", "varchar", "number", "number");
	
	$GLOBALS['fields_name']['person'] 			= array("idperson", "name", "fantasy_name", "type", "document", "email", "provider", "insert_date", "iduser_integ");
	$GLOBALS['fields_type']['person'] 			= array("number", "varchar", "varchar", "number", "varchar", "varchar", "number", "date", "number");
	
	$GLOBALS['fields_name']['phone'] 			= array("idphone", "idperson", "ddd", "number");
	$GLOBALS['fields_type']['phone'] 			= array("number", "number", "number", "varchar");
	
	$GLOBALS['fields_name']['adress'] 			= array("idadress", "idperson", "adress", "number", "neighborhood", "city", "postal_code", "state");
	$GLOBALS['fields_type']['adress'] 			= array("number", "number", "varchar", "number", "varchar", "varchar", "varchar", "varchar");
	
	$GLOBALS['fields_name']['budget'] 			= array("idbudget", "idperson", "initial_date", "final_date", "area", "expected_execution_time", "dificulty", "volatility", "value", "iduser_integ");
	$GLOBALS['fields_type']['budget'] 			= array("number", "number", "date", "date", "number", "number", "number", "number", "number", "number");
	
	$GLOBALS['fields_name']['event'] 			= array("idevent", "iduser_integ", "description", "type");
	$GLOBALS['fields_type']['event'] 			= array("number", "number", "varchar", "number");
	
	$GLOBALS['fields_name']['billing'] 			= array("idbilling", "iduser_integ", "idevent", "idperson", "idproject", "processing_date", "maturity_date", "value", "payment_date", "value_payed");
	$GLOBALS['fields_type']['billing'] 			= array("number", "number", "number", "number", "number", "date", "date", "number", "date", "number");
	
	$GLOBALS['fields_name']['project'] 			= array("idproject", "idbudget", "expected_initial_date", "expected_final_date", "initial_date", "final_date", "area", "value", "description", "iduser_integ");
	$GLOBALS['fields_type']['project'] 			= array("number", "number", "date", "date", "date", "date", "varchar", "varchar", "varchar", "number");
	
	$GLOBALS['fields_name']['project_stage'] 	= array("idproject_stage", "idproject", "description", "expected_initial_date", "expected_final_date", "initial_date", "final_date", "status");
	$GLOBALS['fields_type']['project_stage']    = array("number", "number", "varchar", "date", "date", "date", "date", "number");
	
	$GLOBALS['fields_name']['attachment'] 		= array("idattachment", "idproject", "description", "path");
	$GLOBALS['fields_type']['attachment']		= array("number", "number", "varchar", "varchar");
	
	$GLOBALS['fields_name']['operation'] 		= array("idoperation", "idproject", "insert_date", "result");
	$GLOBALS['fields_type']['operation'] 		= array("number", "number", "date", "varchar");
	
	#for data process only
	$GLOBALS['is_key']['person'] 				= array("yes", "no", "no", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['phone'] 				= array("yes", "yes", "no", "no");
	$GLOBALS['is_key']['adress'] 				= array("yes", "yes", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['user']					= array("yes", "no", "no", "no", "no", "no", "yes");
	$GLOBALS['is_key']['budget']				= array("yes", "yes", "no", "no", "no", "no", "no", "no", "no", "yes");
	$GLOBALS['is_key']['event'] 				= array("yes", "yes", "no", "no");
	$GLOBALS['is_key']['billing'] 				= array("yes", "yes", "no", "no", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['project'] 				= array("yes", "no", "no", "no", "no", "no", "no", "no", "no", "yes");
	$GLOBALS['is_key']['project_stage'] 		= array("yes", "yes", "no", "no", "no", "no", "no", "no");
	$GLOBALS['is_key']['attachment'] 			= array("yes", "yes", "no", "no");
	$GLOBALS['is_key']['operation']				= array("yes", "yes");
?>
