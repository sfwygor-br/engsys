<?php
	include("./php/connection.php");
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
		!empty($_POST["ca2"]) and
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
			
			$sql = "insert into configuration (iduser_integ, notification_period, disponibility, meter_price)
					                    values('".$id["iduser_integ"]."', '".$_POST["ca1"]."', '".$_POST["ca2"]."', '".$_POST["ca3"]."')";
										
			$rs2 = mysqli_query($GLOBALS["conn"], $sql);
			
			if ($rs2 == True){
				$msg = $msg . "2: As Configurações de Ambiente foram definidas com sucesso!";
			}else{
				echo $sql;
				$msg = "2: As Configurações de Ambiente foram definidas com sucesso!";
			}
			
			$msg = "Usuário cadastrado com sucesso! Usuário e senha enviados para o e-mail cadastrado. ".$msg;
			$result = "<script>alert('$msg'); location='./index.php'</script>";
			
		}else{
			$result = "<script>alert(\"".mysqli_error($GLOBALS['conn'])."\")</script>";
		}
	}
	
/*	$screen = "
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='./css/global.css' />
		<title>Solicitação de uso</title>
	</head>
	<body>
		<div id='maintenance'>
			<form method='POST' action='./signup.php'>
			    <div >E-mail</div> <input class='field' type='email' name='o1'>
				<fieldset><pre> Dados do engenheiro </pre>
					<div >Nome</div> <input class='field' type='text' name='p1'>
					<div >CREA</div> <input class='field' type='text' name='p2'><br />
					<div >Cidade</div> <input class='field' type='text' name='p3'>
					<div >Estado</div> <input class='field' type='text' name='p4'><br />
					<div >Telefones</div> <textarea class='field' name='p5'></textarea>
					<div >Endereços</div> <textarea class='field' name='p6'></textarea>
				</fieldset>
				<fieldset><pre> Configurações do Ambiente </pre>
					<div >Período de Notificação</div> <input class='field' type='text' name='ca1'><br />
					<div >Disponibilidade</div> <input class='field' type='text' name='ca2'>
					<div >Valor do metro²</div> <input class='field' type='text' name='ca3'>
				</fieldset>
				<fieldset><pre> Constantes </pre>
				</fieldset>
				<input class='button' type='submit' value='Salvar'>
			</form>
		</div>
		$result
	</body>
</html>";*/
    $screen = "
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='./css/global.css' />
		<title>Solicitação de uso</title>
    <style type='text/css'>
    #apDiv1 {
	position:absolute;
	width:665px;
	height:209px;
	z-index:1;
	left: -17px;
	top: 114px;
}
    #apDiv2 {
	position:absolute;
	width:194px;
	height:28px;
	z-index:2;
	left: 645px;
	top: 125px;
}
    #apDiv3 {
	position:absolute;
	width:195px;
	height:26px;
	z-index:3;
	left: 417px;
	top: 247px;
}
    #apDiv4 {
	position:absolute;
	width:200px;
	height:26px;
	z-index:4;
	left: 685px;
	top: 247px;
}
    #apDiv5 {
	position:absolute;
	width:341px;
	height:22px;
	z-index:5;
	left: 39px;
	top: 19px;
}
    </style>
	</head>
<body>
		<div id='maintenance'>
			<form method='POST' action='./signup.php'>
			    <div >
			      <p>&nbsp;</p>
			      <p>&nbsp;</p>
			    </div>
			    <div id='apDiv5'>
			      E-mail
			        <div id='apDiv1'> 
			          <p>Nome
  <input name='p1' type='text' size='40'>
			            CREA 
			            <input  type='text' name='p2'>
			          </p>
			          <p>		              &nbsp;&nbsp;Cidade
			            <input type='text' name='p3'>
			          &nbsp;&nbsp;&nbsp;&nbsp;Estado
			          <input  type='text' name='p4'>
			          </p>
			          <p>			          Telefone
			            <input name='p5' type='text' value=''>
			          Endereço
			          <input name='p6' type='text' value=''>
			          </p>
			          <p>&nbsp;</p>
			          <p>Período de Notificação
			            <input  type='text' name='ca1'>
			          </p>			          
                      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor do metro²
			            <input  type='text' name='ca3'>
			          </p>
                  </div>
		          <input  type='email' name='o1'>
			    </div>
				<fieldset>
			  <pre> Dados do engenheiro 
</pre>
				  
				<input class='button' type='submit' value='Solicitar Uso'>
			</form>
		</div>
	</body>
</html>	
	";
	#ob_end_clean();		
	disconnect();
	echo $screen;
?>