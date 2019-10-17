<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("builder.php");
	include("variables.php");
	include("connection.php");
	$page = 'reports';
	$section_aux = "
	<script>
		if (document.getElementById('id='req_f_1').value == ''){
			alert('O campo data inicial é obrigatório.');
			return 1;
		};
	</script>
	";
	$section = "";
	connect();
	$sql = "select idproject,
				   description
			  from project
			 where iduser_integ = " . $_SESSION["iduser_integ"] . "
			order by description desc";
	$filter1 = "<select name='project' class='field' style='width: 100%;'>
			 <option value='' selected>Projeto - Não obrigatório<option>
	";
	$rs  = mysqli_query($GLOBALS["conn"], $sql);
	while($r = mysqli_fetch_assoc($rs)){
		$filter1 = $filter1 . "    <option value='".$r["idproject"]."'>".$r["description"]."</option>		
		";
	};
	$filter1 = $filter1 . "</select>";
	
	$filter1_1required = "<select name='project' class='field' style='width: 100%;' required>
			 <option value='' selected>Projeto - Obrigatório<option>
	";
	$rs  = mysqli_query($GLOBALS["conn"], $sql);
	while($r = mysqli_fetch_assoc($rs)){
		$filter1_1required = $filter1_1required . "    <option value='".$r["idproject"]."'>".$r["description"]."</option>		
		";
	};
	$filter1_1required = $filter1_1required . "</select>";
	
	$sql = "select idperson,
				   name
			  from person
			 where iduser_integ = " . $_SESSION["iduser_integ"] . "
			order by name asc";
	$filter2 = "<select name='person' class='field' style='width: 100%;'>
			<option value='' selected>Pessoa - Não obrigatório</option>
	";
	$rs  = mysqli_query($GLOBALS["conn"], $sql);
	while($r = mysqli_fetch_assoc($rs)){
		$filter2 = $filter2 . "    <option value='".$r["idperson"]."'>".$r["name"]."</option>		
		";
	};
	$filter2 = $filter2 . "</select>";
	
	$sql = "select 1 value,
	               'Saída' description
		    union
			select 0 value,
				   'Entrada' description";
	$filter3 = "<select name='type' class='field' style='width: 100%;'>
			<option value='' selected>Natureza - Não obrigatório</option>";
	$rs  = mysqli_query($GLOBALS["conn"], $sql);
	while($r = mysqli_fetch_assoc($rs)){
		$filter3 = $filter3 . "    <option value='".$r["value"]."'>".$r["description"]."</option>		
		";
	};
	$filter3 = $filter3 . "</select>";
	
	$curdate = date('Y-m-d');
	
	
	$section = "
		<!--billing filter-->
		<div id='billing-filter-container-header'>
			Relatório de contas
		</div>
		<div id='billing-filter-container'>
			<form name='form' action='./billing_report_print.php' method='POST'>
				<p>
					Período de: <input type='date' name='dini' class='field' id='req_f_1' value='$curdate' required> á <input type='date' name='dend' class='field' id='req_f_2' value='$curdate' required>
				</p>
				<p>
					<fieldset> Tipo de filtragem <br>
						<input type='radio' name='search_parameter' value='processing_date' checked> Data de processamento
						<input type='radio' name='search_parameter' value='maturity_date'> Data de vencimento
						<input type='radio' name='search_parameter' value='payment_date'> Data de pagamento
					</fieldset>
				</p>
				<p>
					Projeto: $filter1
				</p>
				<p>
					Pessoa: $filter2
				</p>
				<p>
					Pessoa: $filter3
				</p>
				<input type='submit' value='Gerar Relatório' class='button'>
			</form>
		</div>
		
		<!--operation filter-->
		<div id='operation-filter-container-header'>
			Relatório de resultado de cálculo
		</div>
		<div id='operation-filter-container'>
			<form name='form' action='./operation_report_print.php' method='POST'>
				<p>
					Projeto: $filter1_1required
				</p>
				<input type='submit' value='Gerar Relatório' class='button'>
			</form>
		</div>
		
		<!--project stage filter-->
		<div id='ps-filter-container-header'>
			Relatório de etapas de projeto
		</div>
		<div id='ps-filter-container'>
			<form name='form' action='./ps_report_print.php' method='POST'>
				<p>
					Projeto: $filter1_1required
				</p>
				<input type='submit' value='Gerar Relatório' class='button'>
			</form>
		</div>
	";
	disconnect();
	ob_end_clean();		
	load_base_page("Relatórios", $page, $section);
?>