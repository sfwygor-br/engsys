<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'billing';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./billings.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			#$page = 'billing';
			$x = 'insert';
			$section = $section . build_form($GLOBALS['fields_name']['billing'], 
											 array("", "", "idevent", "idperson", "idproject", "", "Data de Processamento", "Data de Vencimento", "Valor", "", ""),
											 array("0", "0", "1000", "1000", "1000", "0", "50", "50", "20", "50", "50"),
											 array("hidden", "hidden", "event_filter", "person_provider", "project_filter", "hidden", "date", "date", "text", "hidden", "hidden"), 
											 "./data_process.php", 
											 "billing", 
											 $x,
											 array("yes", "yes", "yes", "yes", "yes", "yes", "no", "yes", "yes", "yes"),
											 null,
											 1,
											 $_SESSION["iduser_integ"]
											);
		}else if ($action == 'UPDATE'){
			#$page = 'billing';
			$x = 'update';
			$sql = "Select * from billing where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . build_form($GLOBALS['fields_name']['billing'], 
												 array("", "", "idevent", "idperson", "idproject", "", "Data de Processamento", "Data de Vencimento", "Valor", "", ""),
											 array("0", "0", "1000", "1000", "1000", "0", "50", "50", "20", "50", "50"),
											 array("hidden", "hidden", "event_filter", "person_provider", "project_filter", "hidden", "date", "date", "text", "hidden", "hidden"), 
											 "./data_process.php", 
												 "billing", 
												 $x,
												 array("yes", "yes", "yes", "yes", "yes", "yes", "yes", "no", "yes", "no"),
												 $rs,
												 null,
												 null
												);																							  
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
				       event e,
					   person p
				 where b.iduser_integ = " . $_SESSION["iduser_integ"] . "
				   and e.idevent = b.idevent
				   and p.idperson = b.idperson";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . build_grid(array("idbilling", "description", "type"), 
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