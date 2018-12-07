﻿<?php
	include("./php/connection.php");
	require_once("./php/mailer/class.phpmailer.php");
	connect();
	$result = "";
	if (!empty($_POST["o1"]) and
	    !empty($_POST["p1"]) and
	    !empty($_POST["p2"]) and
		!empty($_POST["p3"]) and
		!empty($_POST["p4"]) and
		!empty($_POST["p5"]) and
		!empty($_POST["p6"]) and
		!empty($_POST["ca1"]) and
		!empty($_POST["ca3"])
	   ){
		$sql = "select create_user('".$_POST["o1"]."', '".$_POST["p2"]."') as iduser_integ";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if (($rs == True) and (mysqli_num_rows($rs) > 0)){
			$id = mysqli_fetch_assoc($rs);
			
			$sql = "insert into parameter (iduser_integ, engineer_name, crea, city, state, phones, adresses)
			                        values('".$id["iduser_integ"]."', '".$_POST["p1"]."', '".$_POST["p2"]."', '".$_POST["p3"]."', '".$_POST["p4"]."', '".$_POST["p5"]."', '".$_POST["p6"]."')";
			
			$rs2 = mysqli_query($GLOBALS["conn"], $sql);
			
			$msg = "";
			
			if ($rs2 == True){
				$msg = "1: Os Parametros foram definidos com sucesso!";
			}else{
				$msg = "1: Aviso - Os Parâmetros não foram definidos com sucesso!";
			}				
			
			$sql = "insert into configuration (iduser_integ, notification_period, meter_price)
					                    values('".$id["iduser_integ"]."', '".$_POST["ca1"]."', '".$_POST["ca3"]."')";
										
			$rs2 = mysqli_query($GLOBALS["conn"], $sql);
			
			if ($rs2 == True){
				$msg = $msg . "2: As Configurações de Ambiente foram definidas com sucesso!";
			}else{
				$msg = "2: As Configurações de Ambiente foram definidas com sucesso!";
			}
			
			$msg = "Usuário cadastrado com sucesso! Usuário e senha enviados para o e-mail cadastrado. ".$msg;
			$result = "<script>alert('$msg'); location='./index.php'</script>";
			
			$sql = "select username, password, iduser_integ from user where iduser_integ = ".$id["iduser_integ"];
			$rs = mysqli_query($GLOBALS["conn"], $sql);
			$data = mysqli_fetch_assoc($rs);
			#$headers = "From: naoresponda@engsys.com" . "\r\n";
			$email_body = "
   Ola ".$_POST["p1"].", voce acabou de solicitar acesso ao sistema de genrenciamento de projetos ENGSYS.
   Abaixo estao listados informaçoes importantes sobre a sua conta, para sua segurança, pedimos que ao acessar o sistema pela primeira vez, voce realize a troca de seu nome de usuario e senha.
			
   Usuario:    ".$data["username"]."
   Senha:      ".$data["password"]."
   Integracao: ".$data["iduser_integ"]."

   Att, Equipe ENGSYS.
";
			
			#define('GUSER', 'feecaragua@gmail.com');	// <-- Insira aqui o seu GMail
			#define('GPWD', 'Hexadecimal123#');		// <-- Insira aqui a senha do seu GMail
			
			function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
				global $error;
				$mail = new PHPMailer();
				$mail->charSet = "UTF-8";
				$mail->IsSMTP();		// Ativar SMTP
				$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
				$mail->SMTPAuth = true;		// Autenticação ativada
				$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
				$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
				$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
				$mail->Username = 'feecaragua@gmail.com';
				$mail->Password = 'Hexadecimal123#';
				$mail->SetFrom($de, $de_nome);
				$mail->Subject = $assunto;
				$mail->Body = $corpo;
				$mail->AddAddress($para);
				if(!$mail->Send()) {
					$error = 'Mail error: '.$mail->ErrorInfo; 
					return false;
				} else {
					$error = 'Mensagem enviada!';
					return true;
				}
			}
			
			smtpmailer($_POST["o1"], "feecaragua@gmail.com", "Equipe Engsys", "ENGSYS - Solicitacao de Uso", $email_body);
			#mail($_POST["o1"], "ENGSYS - Solicitação de Uso", $email_body, $headers, "naoresponda@engsys.com");
			
			
		}else{
			$result = "<script>alert(\"".mysqli_error($GLOBALS['conn'])."\")</script>";
		}
	}
	
	$screen = "
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='./css/global.css' />
		<title>Solicitação de uso</title>
	</head>
	<body>
		<div id='maintenance'>
			<form method='POST' action='./signup.php'>
			    <div class='label-signup'>E-mail</div>&nbsp;&nbsp;&nbsp; <input class='field-signup' type='email' name='o1'>
				<fieldset><pre> Dados do engenheiro </pre>
					<div class='label-signup'>Nome</div> <input class='field-signup' type='text' name='p1'>
					<div class='label-signup'>CREA</div> <input class='field-signup' type='text' name='p2'><br />
					<div class='label-signup'>Cidade</div> <input class='field-signup' type='text' name='p3'>
					<div class='label-signup'>Estado</div> <input class='field-signup' type='text' name='p4'><br />
					<div class='label-signup'>Telefones</div> <textarea class='field-signup' name='p5'></textarea>
					<div class='label-signup'>Endereços</div> <textarea class='field-signup' name='p6'></textarea>
					<div class='label-signup'>Período de Notificação</div> <input class='field-signup' type='text' name='ca1'><br />
					<!--<div class='label-signup'>Disponibilidade</div> <input class='field-signup' type='hidden' name='ca2'>-->
					<div class='label-signup'>Valor do metro²</div> <input class='field-signup' type='text' name='ca3'>
				</fieldset>
				<input class='button' type='submit' value='Salvar'>
			</form>
		</div>
		$result
	</body>
</html>";
	ob_end_clean();		
	disconnect();
	echo $screen;
?>