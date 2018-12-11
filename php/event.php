<?php
    session_start();
	@$action = $_GET["action"];
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	connect();
	$page = 'event';
	if ($action == ""){
		$section = "<div id='new-reg' onclick='location=\"./event.php?action=INSERT\"'>Novo</div>";
	}
	
	if (($action == 'INSERT') or ($action == 'UPDATE')){
		
		if ($action == 'INSERT'){
			$page = 'event';
			$x = 'insert';
			$section = $section . "<fieldset> <b style='font-size: 25pt;'>Cadastrar Evento</b><br><br><br>" . build_form($GLOBALS['fields_name']['event'], 
											 array("", "", "Descrição", "Natureza"), 
											 array("0", "0", "50", "200"),
											 array("hidden", "hidden", "text", "billing_type"), 
											 "./data_process.php", 
											 "event", 
											 $x,
											 array("yes", "yes", "yes", "yes"),
											 null,
											 1,
											 $_SESSION["iduser_integ"]
											)."</fieldset>";
		}else if ($action == 'UPDATE'){
			$page = 'event';
			$x = 'update';
			$sql = "Select * from event where iduser_integ = ".$_SESSION['iduser_integ']. $_GET['sql_macro'];
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    if ($rs == True){
				$section = $section . "<fieldset> <b style='font-size: 25pt;'>Atualizar Evento</b><br><br><br>" . build_form($GLOBALS['fields_name']['event'], 
												 array("", "", "Descrição", "Natureza"), 
												 array("0", "0", "50", "200"),
												 array("hidden", "hidden", "text", "billing_type"), 
												 "./data_process.php", 
												 "event", 
												 $x,
												 array("yes", "yes", "yes", "yes"),
												 $rs,
												 null,
												 null
												)."</fieldset>";																							  
			};
		};
	}else{
		$sql = "select idevent,
					   description,
					   case 
					        when type = 0 then
						        'ENTRADA'
                            else
								'SAÍDA'
					    end type
				  from event
				 where iduser_integ = " . $_SESSION["iduser_integ"] . "";
		$rs  = mysqli_query($GLOBALS["conn"], $sql);
		if ($rs == True){	
			$section = $section . "<fieldset> <b style='font-size: 16pt;'>Eventos Cadastrados</b><br><br><br>" . build_grid(array("idevent", "description", "type"), 
											 array("Código", "Descrição", "Natureza"),			                                
											 array("50", "500", "", "20"),
											 $rs,
											 "./event.php?action=UPDATE",
											 array("idevent"))."</fieldset><br>";
		}
	}
	ob_end_clean();		
	load_base_page("Eventos", $page, $section);
	disconnect();
?>