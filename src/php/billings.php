﻿<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'billing';
	if ($action == ""){
		$section = "<div id='billings-update' onclick='location=\"./billings_update.php?action=and payment_date is not null\"'>Contas a baixar/cancelar</div><div id='new-reg' onclick='location=\"./billings.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE') or ($action == 'ALTERSTATUS')){
		if ($action == 'ALTERSTATUS'){
			#$page = 'billing';
			$x = 'alterstatus';
			$sql = "Select * from billing where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . "<fieldset> <b style='font-size: 16pt;'>Contas Cadastradas</b><br>" . build_form($GLOBALS['fields_name']['billing'], 
												 array("", "", "", "", "", "", "", "", "Data de Pagamento", "Valor Pago"),
											     array("0", "0", "0", "0", "0", "0", "0", "0", "5", "20"),
											     array("hidden", "hidden", "hidden", "hidden", "hidden", "hidden", "hidden", "hidden", "date", "text"), 
											     "./data_process.php", 
												 "billings_update", 
												 $x,
												 array("yes", "yes", "yes", "yes", "yes", "yes", "no", "yes", "yes"),
												 $rs,
												 null,
												 null
												);																							  
			};
		}else if ($action == 'INSERT'){
			#$page = 'billing';
			$x = 'insert';
			$section = $section . "<fieldset> <b style='font-size: 25pt;'>Cadastrar Conta</b><br><br><br>" . build_form($GLOBALS['fields_name']['billing'], 
												 array("", "", "idevent", "idperson", "idproject", "Data de Processamento", "Data de Vencimento", "Valor", "", ""),
											     array("0", "0", "1000", "1000", "1000", "0", "50", "5", "5", "5", "5"),
											     array("hidden", "hidden", "event_filter", "person_provider", "project_filter", "date", "date", "text", "hidden", "hidden"), 
											     "./data_process.php", 
												 "billing", 
												 $x,
												 array("yes", "yes", "yes", "yes", "yes", "no", "yes", "yes", "yes", "no"),
											 null,
											 1,
											 $_SESSION["iduser_integ"]
											)."</fieldset>";
		}else if ($action == 'UPDATE'){
			#$page = 'billing';
			$x = 'update';
			$sql = "Select * from billing where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . "<fieldset> <b style='font-size: 25pt;'>Atualizar Conta</b><br><br><br>" . build_form($GLOBALS['fields_name']['billing'], 
												 array("", "", "idevent", "idperson", "idproject", "Data de Processamento", "Data de Vencimento", "Valor", "", ""),
											     array("0", "0", "1000", "1000", "1000", "0", "50", "5", "5", "5", "5"),
											     array("hidden", "hidden", "event_filter", "person_provider", "project_filter", "date", "date", "text", "hidden", "hidden"), 
											     "./data_process.php", 
												 "billing", 
												 $x,
												 array("yes", "yes", "yes", "yes", "yes", "no", "yes", "yes", "yes", "no"),
												 $rs,
												 null,
												 null
												)."</fieldset>";																							  
			};
		};
	}else{
		$sql = "select b.idbilling,
					   e.description,
					   case 
					        when e.type = 0 then
						        'ENTRADA'
                            else
								'SAÍDA'
					    end type
				  from billing b,
				       event e
				 where b.iduser_integ = " . $_SESSION["iduser_integ"] . "
				   and e.idevent = b.idevent";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . "<fieldset> <b style='font-size: 16pt;'>Contas Cadastradas</b><br><br><br>" . build_grid(array("idbilling", "description", "type"), 
											 array("Código", "Descrição", "Natureza"),			                                
											 array("50", "500", "", "20"),
											 $rs,
											 "./billings.php?action=UPDATE",
											 array("idbilling"));
		}
	}
	ob_end_clean();		
	load_base_page("Contas", $page, $section);
	disconnect();
?>