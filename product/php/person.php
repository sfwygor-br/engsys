﻿<?php
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	session_start();
	connect();
	$page = 'person';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./person.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'person';
			$x = 'insert';
			$section =  $section . "<fieldset> <b style='font-size: 25pt;'>Cadastrar Pessoa</b><br><br><br>" . build_form($GLOBALS['fields_name']['person'], 
											 array("", "Nome/Fantasia", "", "F/J", "CPF/CNPJ", "E-mail", "", "Cadastro", ""), 
											 array("0", "50", "0", "10", "20", "30", "50", "10", "20", "20"), 
											 array("hidden", "Text", "hidden", "person_type", "Text", "email", "provider_type", "date", "hidden"), 
											 "./data_process.php", 
											 "person", 
											 $x,
											 array("no", "yes", "no", "no", "yes", "yes", "no", "no", "no"),
											 null,
											 8,
											 $_SESSION["iduser_integ"]
											)."</fieldset><br>";
		}else if ($action == 'UPDATE'){
			$page = 'person';
			$x = 'update';
			$sql = "Select * from person where idperson = ".$_GET['idperson'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){	
				$section = $section . "<fieldset> <b style='font-size: 25pt;'>Atualizar Pessoa</b><br><br><br>" . build_form($GLOBALS['fields_name']['person'], 
												 array("", "Nome/Fantasia", "", "F/J", "CPF/CNPJ", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail", "", "Cadastro", ""), 
												 array("0", "50", "0", "10", "13", "30", "50", "10", "20", "20"), 
												 array("hidden", "Text", "hidden", "person_type", "Text", "email", "provider_type", "date", "hidden"), 
												 "./data_process.php", 
												 "person", 
												 $x,
												 array("no", "yes", "no", "no", "yes", "yes", "no", "no", "no"),
												 $rs,
												 null,
												 null,
												 null
												)."</fieldset><br>";
				
				$section = $section . "<div id='new-reg' onclick='location=\"./person.php?action=PHONEINSERT&idperson=".$_GET['idperson']."\"'>Novo</div>";
				$sql = "select * from phone where idperson = ".$_GET['idperson'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if ($rs == True){
					$section = $section . "<fieldset> <b style='font-size: 16pt;'>Telefones Cadastrados</b><br>" . build_grid(array("idphone", "ddd", "number"),
					                                 array("Código", "DDD", "Número"),													 
													 array("50", "50", "100"),
													 $rs,
													 "./person.php?action=PHONEUPDATE",
													 array("idphone", "idperson")
													)."</fieldset><br>";
				};
				
				$section = $section . "<div id='new-reg' onclick='location=\"./person.php?action=ADRESSINSERT&idperson=".$_GET['idperson']."\"'>Novo</div>";
				$sql = "select * from adress where idperson = ".$_GET['idperson'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if ($rs == True){
					$section = $section . "<fieldset> <b style='font-size: 16pt;'>Endereços Cadastrados</b><br>" . build_grid(array("idadress", "adress", "number", "neighborhood", "city", "state"),
													 array("Código", "Endereço", "Número", "Bairro", "Cidade", "UF"),													 
													 array("50", "400", "50", "200", "200", "10"),
													 $rs,
													 "./person.php?action=ADRESSUPDATE",
													 array("idadress", "idperson")
													)."</fieldset><br>";
				};
			};
		};									
	}else if ($action == 'PHONEINSERT'){
		$page = 'phone';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['phone'], 
									     array("", "", "DDD", "Número"), 
										 array("0", "0", "10", "40"), 
										 array("hidden", "hidden", "Text", "Text"), 
										 "./data_process.php", 
										 "phone", 
										 $x,
										 array("no", "no", "no"),
										 null,
										 1,
										 $_GET["idperson"]
										);		
	}else if ($action == 'PHONEUPDATE'){
		$page = 'phone';
		$x   = 'update';
		$sql = "select * from phone where idperson = ".$_GET['idperson'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['phone'], 
									     array("", "", "DDD", "Número"), 
										 array("0", "0", "10", "40"), 
										 array("hidden", "hidden", "Text", "Text"), 
										 "./data_process.php", 
										 "phone", 
										 $x,
										 array("no", "no", "no"),
										 $rs,
										 null,
										 null
										);	
	}else if ($action == 'ADRESSINSERT'){
		$page = 'adress';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['adress'],
		                                 array("", "", "Endereço", "Número", "Bairro", "Cidade", "CEP", "UF"), 									    
										 array("0", "0", "50", "10", "30", "40", "12", "4"), 
										 array("hidden", "hidden", "Text", "Text", "Text", "Text", "Text", "Text"), 
										 "./data_process.php", 
										 "adress", 
										 $x,
										 array("no", "no", "yes", "no", "yes", "yes", "no", "no"),
										 null,
										 1,
										 $_GET["idperson"]
										);		
	}else if ($action == 'ADRESSUPDATE'){
		$page = 'adress';
		$x   = 'update';
		$sql = "select * from adress where idperson = ".$_GET['idperson'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['adress'],
		                                 array("", "", "Endereço", "Número", "Bairro", "Cidade", "CEP", "UF"), 									    
										 array("0", "0", "50", "10", "30", "40", "12", "4"), 
										 array("hidden", "hidden", "Text", "Text", "Text", "Text", "Text", "Text"), 
										 "./data_process.php", 
										 "adress", 
										 $x,
										 array("no", "no", "yes", "no", "yes", "yes", "no", "no"),
										 $rs,
										 "idperson",
										 $_GET["idperson"]
										);	
	}else{
		$sql = "select idperson,
					   name,
					   case when provider = 0 then
						   'Sim'
					   else
						   'Não'
					   end c_provider
				  from person where iduser_integ = " . $_SESSION["iduser_integ"];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section =  $section . "<fieldset> <b style='font-size: 16pt;'>Pessoas Cadastradas</b><br><br><br>" . build_grid(array("idperson", "name", "c_provider"), 
											 array("Código", "Nome", "Prestador"),			                                 
											 array("50", "500", "50"),
											 $rs,
											 "./person.php?action=UPDATE",
											 array("idperson")
											);
		}
	}
	ob_end_clean();		
	load_base_page("Pessoas", $page, $section);
	disconnect();
?>