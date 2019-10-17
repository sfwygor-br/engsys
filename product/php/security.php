<?php
	function CreateSession($iduser_integ, $iduser, $username){
		session_start();
		$SESSION['USER_SESSION']['USER_INTEGRATION_NUMBER'] = $iduser_integ;
		$SESSION['USER_SESSION']['IDUSER'] 			        = $iduser;
		$SESSION['USER_SESSION']['USERNAME']				= $username;
		return(0);
	}
	
	function DestroySession($user){
		return(0);
	}
?>