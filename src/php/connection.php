<?php
	error_reporting(0);
	$GLOBALS['conn'] = new mysqli('localhost', 'root', '', 'ENGSYS');
	function connect(){	 
		if ($GLOBALS['conn']->connect_error) {
			die('Connection failed: ' . $GLOBALS['conn']->connect_error);
		}else{
			#null;
			mysqli_set_charset($GLOBALS['conn'], "utf8");
		}
	}
	
	function disconnect(){
		mysqli_close($GLOBALS['conn']);
	}
?>