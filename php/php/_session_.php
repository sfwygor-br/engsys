<?php
	if (@$_GET["logout"]=="TRUE"){
		session_destroy();
		echo'1';
		#header("Location: ../index.php");
	}else{
		session_id("1");
		session_start();
		$_SESSION["session"] = $_GET["session_for_user"];
		header("Location: ../index.php");
		exit();
	}
?>