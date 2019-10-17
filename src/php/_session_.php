<?php
	if (@$_GET["logout"]=="TRUE"){
		session_start();
		session_destroy();
	    header("Location: ../index.php");
	}else{
		header("Location: ../index.php");
	}
?>