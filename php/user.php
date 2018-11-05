<?php
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'user';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./person.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'person';
			$x = 'insert';
			$section = $section . build_form($GLOBALS['fields_name']['person'], 
											 array("Código", "Nome", "Nome Fantasia", "F/J", "CPF/CNPJ", "E-mail", "P", "Cadastro", "IUI"), 
											 array("0", "50", "50", "10", "20", "20", "50", "10", "20", "20"), 
											 array("hidden", "Text", "Text", "person_type", "Text", "email", "provider_type", "date", "hidden"), 
											 "./data_process.php", 
											 "person", 
											 $x,
											 array("no", "yes", "yes", "no", "no", "yes", "no", "no", "no"),
											 null
											);
		}else if ($action == 'UPDATE'){
			$page = 'person';
			$x = 'update';
			$sql = "Select * from person where idperson = ".$_GET['idperson'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){	
				$section = $section . build_form($GLOBALS['fields_name']['person'], 
											     array("Código", "Nome", "Nome Fantasia", "F/J", "CPF/CNPJ", "E-mail", "P", "Cadastro", "IUI"), 
												 array("0", "50", "50", "10", "20", "20", "50", "10", "20", "20"), 
												 array("hidden", "Text", "Text", "person_type", "Text", "email", "provider_type", "date", "hidden"), 
												 "./person_process.php", 
												 "person", 
												 $x,
												 array("no", "yes", "yes", "no", "no", "yes", "no", "no", "no"),
												 $rs
												);
				
				$section = $section . "<div id='new-reg' onclick='location=\"./person.php?action=PHONEINSERT\"'>Novo</div>";
				$sql = "select * from phone where idperson = ".$_GET['idperson'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if ($rs == True){
					$section = $section . build_grid(array("idphone", "idperson", "ddd", "number"),
					                                 array("Código", "", "DDD", "Número"),													 
													 array("50", "0", "50", "100"),
													 $rs,
													 "./person.php?action=PHONEUPDATE",
													 array("idphone", "idperson"));
				};
				
				$section = $section . "<div id='new-reg' onclick='location=\"./person.php?action=ADRESSINSERT\"'>Novo</div>";
				$sql = "select * from adress where idperson = ".$_GET['idperson'];
				$rs  = mysqli_query($GLOBALS["conn"], $sql);
				if ($rs == True){
					$section = $section . build_grid(array("Código", "", "Endereço", "Número", "Bairro", "Cidade", "UF"),
													 array("idadress", "idperson", "adress", "number", "neighborhood", "city", "state"),
													 array("50", "0", "400", "50", "200", "200", "10"),
													 $rs,
													 "./person.php?action=ADRESSUPDATE",
													 array("idadress", "idperson"));
				};
			};
		};									
	}else if ($action == 'PHONEINSERT'){
		$page = 'phone';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['phone'], 
									     array("Código", "DDD", "Número"), 
										 array("0", "0", "10", "40"), 
										 array("hidden", "Text", "Text"), 
										 "./phone_process.php", 
										 "phone", 
										 $x,
										 array("no", "no", "no"),
										 null
										);		
	}else if ($action == 'PHONEUPDATE'){
		$page = 'phone';
		$x   = 'update';
		$sql = "select * from phone where idperson = ".$_GET['idperson'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['phone'], 
									     array("Código", "DDD", "Número"), 
										 array("0", "0", "10", "40"), 
										 array("hidden", "hidden", "Text", "Text"), 
										 "./data_process.php", 
										 "phone", 
										 $x,
										 array("no", "no", "no"),
										 $rs
										);	
	}else if ($action == 'ADRESSINSERT'){
		$page = 'adress';
		$x = 'insert';
		$section = $section . build_form($GLOBALS['fields_name']['adress'],
		                                 array("Código", "Endereço", "Número", "Bairro", "Cidade", "CEP", "UF"), 									    
										 array("0", "0", "64", "10", "50", "40", "12", "4"), 
										 array("hidden", "Text", "Text", "Text", "Text", "Text", "Text"), 
										 "./data_process.php", 
										 "adress", 
										 $x,
										 array("no", "no", "no", "no", "no", "no", "no"),
										 null
										);		
	}else if ($action == 'ADRESSUPDATE'){
		$page = 'adress';
		$x   = 'update';
		$sql = "select * from adress where idperson = ".$_GET['idperson'].$_GET['sql_macro'];
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		$section = $section . build_form($GLOBALS['fields_name']['adress'],
		                                 array("Código", "Endereço", "Número", "Bairro", "Cidade", "CEP", "UF"), 									    
										 array("0", "0", "64", "10", "50", "40", "12", "4"), 
										 array("hidden", "Text", "Text", "Text", "Text", "Text", "Text"), 
										 "./data_process.php", 
										 "adress", 
										 $x,
										 array("no", "no", "no", "no", "no", "no", "no"),
										 $rs
										);	
	}else{
		$sql = "select idperson,
					   name,
					   case when provider = 0 then
						   'Sim'
					   else
						   'Não'
					   end c_provider
				  from person";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . build_grid(array("Código", "Nome", "Prestador"),
			                                 array("idperson", "name", "c_provider"), 
											 array("50", "500", "50"),
											 $rs,
											 "./person.php?action=UPDATE",
											 array("idperson"));
		}
	}
	ob_end_clean();		
	load_base_page("Pessoas", $page, $section);
	disconnect();
?>