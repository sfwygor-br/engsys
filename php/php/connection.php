<?php
	#error_reporting(0);
	$GLOBALS['conn'] = new mysqli('localhost', 'root', '', 'ENGSYS');
	function connect(){	 
		if ($GLOBALS['conn']->connect_error) {
			die('Connection failed: ' . $GLOBALS['conn']->connect_error);
		}else{
			ob_start();
		}
	}
	
	function disconnect(){
		mysqli_close($GLOBALS['conn']);
	}
?>