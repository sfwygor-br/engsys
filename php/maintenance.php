<?php
    session_start();
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'budget';
	
	$iduser_integ = $_SESSION["iduser_integ"];
	$sql = "select param.*,
	               confi.*,
				   const.*
			  from parameter param,
			       configuration confi,
				   constant const
			 where param.iduser_integ = $iduser_integ
			   and confi.iduser_integ = $iduser_integ
			   and const.iduser_integ = $iduser_integ";
	$rs  = mysqli_query($GLOBALS["conn"], $sql);
	$r 	 = mysqli_fetch_assoc($rs);
	
	$section = "
			<div id='maintenance'>
				<form method='POST' action='./maintenance.php'>
				    <fieldset><pre> Dados do engenheiro </pre>
						Nome <input class='field' type='text' name='p1' value = '".$r['engineer_name']."'>
						CREA <input class='field' type='text' name='p2' value = '".$r['crea']."'><br>
						Cidade <input class='field' type='text' name='p3' value = '".$r['city']."'>
						Estado <input class='field' type='text' name='p4' value = '".$r['state']."'><br>
						Telefones <input class='field' type='text' name='p5' value = '".$r['phones']."'>
						Endereços <input class='field' type='text' name='p6' value = '".$r['adresses']."'>
					</fieldset>
					<fieldset><pre> Configurações do Ambiente </pre>
						Período de Notificação <input class='field' type='text' name='ca1' value = '".$r['notification_period']."'>
						Disponibilidade <input class='field' type='text' name='ca2' value = '".$r['disponibility']."'><br>
						Valor do metro² <input class='field' type='text' name='ca3' value = '".$r['meter_price']."'><br>
					</fieldset>
					<fieldset><pre> Constantes </pre>
					</fieldset>
					<input class='button' type='submit' value='Salvar'
				</form>
			</div>
	";
	ob_end_clean();		
	load_base_page("Configurações", $page, $section);
	disconnect();
?>