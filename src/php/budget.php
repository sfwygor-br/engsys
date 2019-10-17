<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'budget';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./budget.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'budget';
			$x = 'insert';
			$section = $section . "<fieldset> <b style='font-size: 25pt;'>Cadastrar Orçamento</b><br>" . build_form($GLOBALS['fields_name']['budget'], 
												 array("", "Cliente", "Data Início", "Data Término", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Área", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempo de Execução", "&nbsp;Grau de Dificuldade %", "Grau de Volatilidade %", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor", ""), 
												 array("0", "1000", "50", "50", "5", "3", "3", "3", "10", "0"),
												 array("hidden", "person_filter", "date", "date", "text", "text", "text", "text", "text", "hidden"), 
												 "./data_process.php", 
												 "budget", 
												 $x,
												 array("yes", "yes", "no", "yes", "yes", "yes", "yes", "yes", "no", "no"),
											 null,
											 9,
											 $_SESSION["iduser_integ"]
											);
		}else if ($action == 'UPDATE'){
			$page = 'budget';
			$x = 'update';
			$sql = "Select * from budget where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . "<fieldset> <b style='font-size: 25pt;'>Atualizar Orçamento</b><br>" . build_form($GLOBALS['fields_name']['budget'], 
												 array("", "Cliente", "Data Início", "Data Término", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Área", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempo de Execução", "&nbsp;Grau de Dificuldade %", "Grau de Volatilidade %", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor", ""), 
												 array("0", "1000", "50", "50", "5", "3", "3", "3", "10", "0"),
												 array("hidden", "person_filter", "date", "date", "text", "text", "text", "text", "text", "hidden"), 
												 "./data_process.php", 
												 "budget", 
												 $x,
												 array("yes", "yes", "no", "yes", "yes", "yes", "yes", "yes", "no", "no"),
												 $rs,
												 9,
												 null
												);																							  
			};
		};
	}else{
		$sql = "select idbudget,
					   (select name from person where person.idperson = budget.idperson) name,
					   initial_date,
					   final_date,
					   value
				  from budget
				 where iduser_integ = " . $_SESSION["iduser_integ"] . "";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section. "<fieldset> <b style='font-size: 15pt;'>Orçamentos Cadastrados</b> <br><br><br>" . build_grid(array("idbudget", "name", "initial_date", "final_date", "value"), 
											 array("Código", "Cliente", "Data Início", "Data Término", "Valor"),			                                
											 array("100", "300", "130", "140", "100"),
											 $rs,
											 "./budget.php?action=UPDATE",
											 array("idbudget")) . "</fieldset>";
		}
	}
	ob_end_clean();		
	load_base_page("Orçamento", $page, $section);
	disconnect();
?>