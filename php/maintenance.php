<?php
    session_start();
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'maintenance';
	$iduser_integ = $_SESSION["iduser_integ"];
	if(isset($_POST["p1"]) and
	   isset($_POST["p2"]) and
	   isset($_POST["p3"]) and
	   isset($_POST["p4"]) and
	   isset($_POST["p5"]) and
	   isset($_POST["p6"]) and
	   isset($_POST["ca1"]) and
	   isset($_POST["ca3"])){
		$sql = "update parameter
				   set engineer_name = ".$_POST["p1"].",    
					   crea			 = ".$_POST["p2"].",
					   city			 = ".$_POST["p3"].",
					   state		 = ".$_POST["p4"].",
					   phones		 = ".$_POST["p5"].",
					   adresses		 = ".$_POST["p6"]."
				 where iduser_integ  = $iduser_integ";
		$rs = mysqli_query($GLOBALS["conn"], $sql);
		
		$sql = "update configuration
				   set notification_period = ".$_POST["ca1"].",    
					   meter_price  	   = ".$_POST["ca3"]."
				 where iduser_integ  = $iduser_integ";
		$rs = mysqli_query($GLOBALS["conn"], $sql);
		
		echo"<script> location='./maintenance.php'; </script>";
	} else {
		$sql = "select param.*,
					   confi.*
				  from parameter param,
					   configuration confi
				 where param.iduser_integ = $iduser_integ
				   and confi.iduser_integ = $iduser_integ";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$r 	 = mysqli_fetch_assoc($rs);
		
		$section = "
				<div id='maintenance'>
					<form method='POST' action='./maintenance.php?action=UPDATE'>
						<fieldset><pre> Dados do engenheiro </pre>
							Nome <input class='field' type='text' name='p1' value = '".$r['engineer_name']."'>
							CREA <input class='field' type='text' name='p2' value = '".$r['CREA']."' readonly><br>
							Cidade <input class='field' type='text' name='p3' value = '".$r['city']."'>
							Estado <input class='field' type='text' name='p4' value = '".$r['state']."'><br>
							Telefones <input class='field' type='text' name='p5' value = '".$r['phones']."'>
							Endereços <input class='field' type='text' name='p6' value = '".$r['adresses']."'>
							Período de Notificação <input class='field' type='text' name='ca1' value = '".$r['notification_period']."'><br>
							Valor do metro² <input class='field' type='text' name='ca3' value = '".$r['meter_price']."'><br>
						</fieldset>
						<input class='button' type='submit' value='Salvar'>
					</form>
				</div>
		";
		if($_SESSION["iduser"] != $_SESSION["iduser_integ"]){
			$section = "<script> alert('Você não tem permissão para acessar a área de manutenções do ambiente. Contate o administrador.'); </script>";
		}
		ob_end_clean();		
		load_base_page("Configurações", $page, $section);
		disconnect();
	}
?>