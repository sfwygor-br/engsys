<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'user';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./user.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'user';
			$x = 'insert';
			$section = $section . "<fieldset> <b style='font-size: 25pt;'>Cadastrar Usuário</b><br><br><br>" . build_form($GLOBALS['fields_name']['user'], 
												 array("", "&nbsp;Usuário", "&nbsp;&nbsp;&nbsp;&nbsp;Senha", "&nbsp;&nbsp;&nbsp;&nbsp;E-mail", "", "Status", ""), 
												 array("0", "50", "50", "50", "0", "10", "0"),
												 array("hidden", "Text", "password", "email", "hidden", "status", "hidden"), 
												 "./data_process.php", 
												 "user", 
												 $x,
												 array("yes", "yes", "yes", "yes", "no", "no", "no"),
											 null,
											 6,
											 $_SESSION["iduser_integ"]
											)."</fieldset><br>";
		}else if ($action == 'UPDATE'){
			$page = 'user';
			$x = 'update';
			$sql = "Select * from user where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . "<fieldset> <b style='font-size: 25pt;'>Atualizar Usuário</b><br><br><br>" . build_form($GLOBALS['fields_name']['user'], 
												 array("", "&nbsp;Usuário", "&nbsp;&nbsp;&nbsp;&nbsp;Senha", "&nbsp;&nbsp;&nbsp;&nbsp;E-mail", "", "Status", ""), 
												 array("0", "50", "50", "50", "0", "10", "0"),
												 array("hidden", "Text", "password", "email", "hidden", "status", "hidden"), 
												 "./data_process.php", 
												 "user", 
												 $x,
												 array("yes", "yes", "yes", "yes", "no", "no", "no"),
												 $rs,
												 null,
												 null
												)."</fieldset><br>";																							  
			};
		};
	}else{
		if ($_SESSION["iduser"] <> $_SESSION["iduser_integ"]){
			$sql = "select iduser,
						   username,
						   email,
						   case 
								when status = 0 then
									'ATIVO'
								else
									'INATIVO'
							end status
					  from user
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					   and iduser <> " . $_SESSION["iduser_integ"];
		}else{
			$sql = "select iduser,
						   username,
						   email,
						   case 
								when status = 0 then
									'ATIVO'
								else
									'INATIVO'
							end status
					  from user
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "";
		}
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . "<fieldset> <b style='font-size: 25pt;'>Usuários Cadastrados</b><br><br><br>" . build_grid(array("iduser", "username", "email", "status"), 
											 array("Código", "Usuário", "E-mail", "Status"),			                                
											 array("50", "50", "50", "20"),
											 $rs,
											 "./user.php?action=UPDATE",
											 array("iduser"))."</fieldset>";
		}
	}
	ob_end_clean();		
	load_base_page("Usuário", $page, $section);
	disconnect();
?>