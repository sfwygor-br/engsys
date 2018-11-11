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
			$section = $section . build_form($GLOBALS['fields_name']['budget'], 
											 array("", "Cliente", "Data Início", "Data Término", "Área", "Tempo de Execução", "Grau de Dificuldade %", "Grau de Volatilidade %", "Valor", ""), 
											 array("0", "1000", "50", "50", "20", "10", "10", "10", "20", "0"),
											 array("hidden", "person_filter", "date", "date", "text", "text", "text", "text", "text", "hidden"), 
											 "./data_process.php", 
											 "budget", 
											 $x,
											 array("yes", "no", "no", "no", "no", "no", "yes", "no", "no", "no"),
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
				$section = $section . build_form($GLOBALS['fields_name']['budget'], 
												 array("", "Cliente", "Data Início", "Data Término", "Área", "Tempo de Execução", "Grau de Dificuldade %", "Grau de Volatilidade %", "Valor", ""), 
												 array("0", "1000", "50", "50", "20", "10", "10", "10", "20", "0"),
												 array("hidden", "person_filter", "date", "date", "text", "text", "text", "text", "text", "hidden"), 
												 "./data_process.php", 
												 "budget", 
												 $x,
												 array("yes", "no", "no", "no", "no", "no", "yes", "no", "no", "no"),
												 $rs,
												 9,
												 null
												);																							  
			};
		};
	}else{
		$sql = "select idbudget,
					   idperson,
					   initial_date,
					   final_date,
					   value
				  from budget
				 where iduser_integ = " . $_SESSION["iduser_integ"] . "";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . build_grid(array("idbudget", "idperson", "initial_date", "final_date", "value"), 
											 array("Código", "Cliente", "Data Início", "Data Término", "Valor"),			                                
											 array("50", "100", "30", "30"),
											 $rs,
											 "./budget.php?action=UPDATE",
											 array("idbudget"));
		}
	}
	ob_end_clean();		
	load_base_page("Orçamento", $page, $section);
	disconnect();
?>