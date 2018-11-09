<?php
	session_start();
	if(isset($_SESSION["iduser_integ"])){
		echo"<script>location='./php/dashboard.php'</script>";
		header("Location: ./php/dashboard.php");
	}else{
		@$user     = $_POST["username"];
		@$password = $_POST["password"];
		require("./php/connection.php");
		require("./php/security.php");
		$display = True;
		connect();
		
		$status_inactive = "";
		if((!empty($user)) and (!empty($password))){
			#echo"<script>alert($user+$password)</script>";
			$sql = "select * from user where username = '$user' and password = '$password'";
			$rs  = mysqli_query($GLOBALS['conn'], $sql);
			if ($rs == True){			
				if (mysqli_num_rows($rs) == 1) {
					$res = mysqli_fetch_assoc($rs);			
					disconnect();		
                    if ($res["status"] == 0){
						$_SESSION["iduser"]       = $res["iduser"];
						$_SESSION["iduser_integ"] = $res["iduser_integ"];
						$_SESSION["username"]     = $res["username"];
						header("Location: ./php/dashboard.php");	
					}else{
						$status_inactive = "<script>alert('Usuário Inativo: Contate o administrador do sistemma')</script>";
					}
				}else{
					$status_inactive = "<script>alert('Usuário ou Senha inválidos')</script>";
				}
			}
		}
	}
    $screen = "
<html>
	<head>
	
	</head>
		<title>Login Engsys</title>
		<link type='text/css' rel='stylesheet' href='./css/global.css' />
		<link type='text/css' rel='stylesheet' href='./css/custom_login.css' />	
		<link type='text/css' rel='stylesheet' href='./css/fa/all.css' />	
	<body>
		<div id='login'>
			<form class='login-form' method='POST'>
				<input class='input-field' type='text' name='username' placeholer='Usuário'>
				<input class='input-field' type='password' name='password' placeholer='Senha'>
				<input class='login-button' type='submit' value='Login'>
			</form>
			$status_inactive
		</div>
	</body>
</html>";
    echo $screen;
?>