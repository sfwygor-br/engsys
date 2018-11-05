<?php
	@$user     = $_POST["username"];
	@$password = $_POST["password"];
	require('connection.php');
	require('header.php');
	$display = True;
	connect();
	
 	if((!empty($user)) and (!empty($password))){
		#echo"<script>alert($user+$password)</script>";
		$sql = "select * from _0_usuario where usuario = '$user' and senha = '$password'";
		$rs  = mysqli_query($GLOBALS['conn'], $sql);
		if ($rs == True){			
			if (mysqli_num_rows($rs) == 1) {
				$res = mysqli_fetch_assoc($rs);
				ob_end_clean();				
				header("Location: ./php/_session_.php?session_for_user=".$res['id_0_usuario']."");
                exit();
			}else{
				echo'usuário ou senha inválidos';
			}
		}
	};
	$screen_login = "
	$screen_header
	<div id='login'>
		<form class='login-form' method='POST'>
			<input class='input-field' type='text' name='username' id='id_username'>
			<input class='input-field' type='password' name='password' id='id_password'>
			<input class='login-button' id='id_login_btn' type='submit' value='Login'>
		</form>
	</div>
	";
	echo $screen_login;
	disconnect();
?>	