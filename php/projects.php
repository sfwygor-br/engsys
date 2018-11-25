<?php
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	session_start();
	connect();
	$page = 'project';
	$section = "";
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./projects.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'project';
			$x = 'insert';
			$section = $section . build_form($GLOBALS['fields_name']['project'], 
											 array("", "Orçamento", "Data Início Prevista", "Data Término Prevista", "Data Início Efetiva &nbsp;", "Data Término Efetiva &nbsp;", "Área", "Total", "Descrição", ""),
											 array("0", "500", "50", "10", "20", "20", "50", "10", "53", "0", "0"), 
											 array("hidden", "budget_filter", "date", "date", "date", "date", "text", "text", "textarea", "hidden"),
											 "./data_process.php",
											 "project", 
											 $x,
											 array("no", "yes", "no", "yes", "no", "yes", "no", "no", "no", "no"),
											 null,
											 9,
											 $_SESSION["iduser_integ"]
											);
		}else if ($action == 'UPDATE'){
			$page = 'project';
			$x = 'update';
			$sql = "Select * from project where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){	
				$section = $section . build_form($GLOBALS['fields_name']['project'], 
												 array("", "Orçamento", "Data Início Prevista", "Data Término Prevista", "Data Início Efetiva &nbsp;", "Data Término Efetiva &nbsp;", "Área", "Total", "Descrição", ""),
												 array("0", "500", "50", "10", "20", "20", "50", "10", "53", "0", "0"), 
												 array("hidden", "budget_filter", "date", "date", "date", "date", "text", "text", "textarea", "hidden"),
												 "./data_process.php", 
												 "project", 
												 $x,
												 array("no", "yes", "no", "yes", "no", "yes", "no", "no", "no", "no"),
												 $rs,
												 null,
												 null,
												 null
												);
				
				$section = $section . "<div id='new-reg' onclick='location=\"./projects.php?action=PROJECTSTAGEINSERT&idproject=".$_GET['idproject']."\"'>Novo</div>";
				$sql = "select idproject_stage,
                               description,
							   initial_date,
							   final_date,
							   case 
							       when status = 0 then
								       'ATIVO'
								   else
									   'ABERTO'
							   end status
						  from project_stage 
						 where idproject = ".$_GET['idproject'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if (($rs == True) and (mysqli_num_rows($rs) > 0)){
					$section = $section . build_grid(array("idproject_stage", "description", "initial_date", "final_date", "status"),
					                                 array("Código", "Descrição", "Data Início", "Data Término", "Status"),													 
													 array("50", "500", "50", "50", "50"),
													 $rs,
													 "./projects.php?action=PROJECTSTAGEUPDATE&idproject=".$_GET['idproject'],
													 array("idproject_stage", "idproject")
													);
				};

				$section = $section . "<div id='new-reg' onclick='location=\"./projects.php?action=ATTACHMENTINSERT&idproject=".$_GET['idproject']."\"'>Novo</div>";
				$sql = "select * from attachment where idproject = ".$_GET['idproject'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if (($rs == True) and (mysqli_num_rows($rs) > 0)){
					$section = $section . build_grid(array("description", "download"),
													 array("Descrição do Anexo", "Download"),													 
													 array("500", "100"),
													 $rs,
													 "./download.php?idproject=".$_GET['idproject'],
													 array("download")
													);
				};
				
				$section = $section . "<div id='new-reg' onclick='location=\"./projects.php?action=OPERATIONINSERT&idproject=".$_GET['idproject']."\"'>Novo</div>";
				$sql = "select * from operation where idproject = ".$_GET['idproject'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if (($rs == True) and (mysqli_num_rows($rs) > 0)){
					$section = $section . build_grid(array("idoperation", "idproject"),
													 array("Código", "projeto"),													 
													 array("50", "50"),
													 $rs,
													 "./projects.php?action=OPERATIONUPDATE&idproject=".$_GET['idproject'],
													 array("idoperation", "idproject")
													);
				};
			};
		};
	}else if ($action == 'PROJECTSTAGEINSERT'){
		$page = 'project_stage';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['project_stage'], 
									     array("", "", "Descrição", "Data Início Prevista &nbsp;", "Data Término Prevista", "Data Início Efetiva &nbsp;", "Data Término Efetiva", "Status"), 
										 array("0", "0", "60", "50", "50", "50", "50", "50"),  
										 array("hidden", "hidden", "textarea", "date", "date", "date", "date", "status"), 
										 "./data_process.php", 
										 "project_stage", 
										 $x,
										 array("yes", "yes", "yes", "no", "yes", "no", "yes", "no"),
										 null,
										 1,
										 $_GET["idproject"]
										);		
	}else if ($action == 'PROJECTSTAGEUPDATE'){
		$page = 'project_stage';
		$x   = 'update';
		$sql = "select * from project_stage where idproject = ".$_GET['idproject'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['project_stage'], 
									     array("", "", "Descrição", "Data Início Prevista &nbsp;", "Data Término Prevista", "Data Início Efetiva &nbsp;", "Data Término Efetiva", "Status"), 
										 array("0", "0", "60", "50", "50", "50", "50", "50"),  
										 array("hidden", "hidden", "textarea", "date", "date", "date", "date", "status"), 
										 "./data_process.php", 
										 "project_stage", 
										 $x,
										 array("yes", "yes", "yes", "no", "yes", "no", "yes", "no"),
										 $rs,
										 null,
										 null
										);	
	}else if ($action == 'ATTACHMENTINSERT'){
		$page = 'attachment';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['attachment'],
		                                 array("", "", "Descrição", "Arquivo"), 									    
										 array("0", "0", "60", "100"), 
										 array("hidden", "hidden", "textarea", "text"), 
										 "./data_process.php", 
										 "attachment", 
										 $x,
										 array("no", "no", "yes", "yes"),
										 null,
										 1,
										 $_GET["idproject"]
										);		
	}else if ($action == 'OPERATIONINSERT'){
		$page = 'operation';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['operation'],
		                                 array("Código", "Projeto"), 									    
										 array("0", "0"), 
										 array("hidden", "hidden"), 
										 "./data_process.php", 
										 "operation", 
										 $x,
										 array("no", "no"),
										 null,
										 1,
										 $_GET["idproject"]
										);
    }else if ($action == 'OPERATIONUPDATE'){
		$page = 'operation';
		$x   = 'update';
		$sql = "select * from operation where idproject = ".$_GET['idproject'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['operation'],
		                                 array("Código", "Projeto"), 									    
										 array("0", "0"), 
										 array("hidden", "hidden"), 
										 "./data_process.php", 
										 "operation", 
										 $x,
										 array("no", "no"),
										 $rs,
										 null,
										 null
										);										
	}else{
		$sql = "select idproject,
					   (select name 
					      from person, 
						       budget 
					     where person.idperson = budget.idperson 
						   and budget.idbudget = project.idproject) name,
					   initial_date,
					   final_date,
					   value
				  from project
				 where iduser_integ = " . $_SESSION["iduser_integ"] . "";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if (($rs == True) and (mysqli_num_rows($rs) > 0)){	
			$section = $section . build_grid(array("idproject", "name", "initial_date", "final_date", "value"), 
											 array("Código", "Cliente", "Data Início", "Data Término", "Valor"),			                                 
											 array("50", "500", "50", "50", "50"),
											 $rs,
											 "./projects.php?action=UPDATE",
											 array("idproject")
											);
		}
	}
	ob_end_clean();		
	load_base_page("Projetos", $page, $section);
	disconnect();
?>