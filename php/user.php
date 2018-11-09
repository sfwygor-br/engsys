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
			$section = $section . build_form($GLOBALS['fields_name']['user'], 
											 array("", "Usuário", "Senha", "E-mail", "", "Status", "Id Integração"), 
											 array("0", "50", "50", "50", "0", "10", "0"),
											 array("hidden", "Text", "password", "email", "date", "status", "hidden"), 
											 "./data_process.php", 
											 "user", 
											 $x,
											 array("no", "no", "no", "yes", "no", "no", "no"),
											 null,
											 6,
											 $_SESSION["iduser_integ"]
											);
		}else if ($action == 'UPDATE'){
			$page = 'user';
			$x = 'update';
			$sql = "Select * from user where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . build_form($GLOBALS['fields_name']['user'], 
												 array("", "Usuário", "Senha", "E-mail", "", "Status", "Id Integração"), 
												 array("0", "50", "50", "50", "0", "10", "0"),
												 array("hidden", "Text", "password", "email", "date", "status", "hidden"), 
												 "./data_process.php", 
												 "user", 
												 $x,
												 array("no", "no", "no", "yes", "no", "no", "no"),
												 $rs,
												 null,
												 null
												);																							  
			};
		};
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
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . build_grid(array("iduser", "username", "email", "status"), 
											 array("Código", "Usuário", "E-mail", "Status"),			                                
											 array("50", "50", "50", "20"),
											 $rs,
											 "./user.php?action=UPDATE",
											 array("iduser"));
		}
	}
	ob_end_clean();		
	load_base_page("Usuário", $page, $section);
	disconnect();
?>