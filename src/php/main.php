<?php
	function load_base_page($page_title, $page, $section){
		#ob_start();
		#ob_end_clean();
		session_start();
		if (in_array($page, array("phone", "adress", "person"))){
			$page_aux = "person";
		} else if (in_array($page, array("project", "project_stage", "attachment", "operation"))){
			$page_aux = "projects";
		} else if (in_array($page, array("billing"))){
			$page_aux = "billings";
		}else{
			$page_aux = $page;
		}
		#$page = $v;
		$nav  = "";
		$comp = "";
	    #echo "<script language='JavaScript'>/*<document.location='main.php?r=1&width='+screen.width+'&Height='+screen.height*/ alert(window.innerWidth);</script>";
		if (!empty($page)){
			if ($page == 'dashboard'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav-active'><div class='div-a-nav-active'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
				$comp = "<link type='text/css' rel='stylesheet' href='../css/dashboard.css' />";
			}else if($page == 'budget'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav-active'><div class='div-a-nav-active'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'project'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav-active'><div class='div-a-nav-active'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if(($page == 'person') or ($page == 'phone') or ($page == 'adress')){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav-active'><div class='div-a-nav-active'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'billing'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav-active'><div class='div-a-nav-active'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'event'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav-active'><div class='div-a-nav-active'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'maintenance'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav-active'><div class='div-a-nav-active'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'user'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav-active'><div class='div-a-nav-active'>Usuários</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'reports'){
				$nav =   
				   "    <a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
				    <a href='./budget.php' class='a-nav'><div class='div-a-nav'>Orçamentos</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>			
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./event.php' class='a-nav'><div class='div-a-nav'>Eventos</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./user.php' class='a-nav'><div class='div-a-nav'>Usuários</div></a>
					<a href='./reports.php' class='a-nav-active'><div class='div-a-nav-active'>Relatórios</div></a>";
					$comp = "<link type='text/css' rel='stylesheet' href='../css/report.css' />";
			};
		};
		
		
		if ($page != 'dashboard'){
			$section = "
		<section>
			".$section."
		</section>
		";
		}
		
		$screen =
"<html>
	<head>
		<title>$page_title</title>
		<link type='text/css' rel='stylesheet' href='../css/global.css' />
		<link href='https://cdnjs.cloudflare.com/ajax/libs/vex-js/2.3.3/css/vex-theme-os.css' rel='stylesheet' />
		<link href='https://cdnjs.cloudflare.com/ajax/libs/vex-js/2.3.3/css/vex.min.css' rel='stylesheet' />
		$comp
		<script src='https://cdnjs.cloudflare.com/ajax/libs/vex-js/2.3.3/js/vex.combined.min.js'></script>
		<script src='../js/jquery.js'></script>
		<script type='text/javascript'>
			$(document).ready(function(){
				let i = document.getElementById('update_btn');
				if (i != null){
					document.getElementById ('update_btn').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=update&page=$page',
							success:function(data) {
									//alert(data);
									if (data.trim() != 'Registro atualizado!'){
										alert(data);
									}else{
										alert(data);
										location.reload();
									}
							} 
						});		
					});
				};
				
				i = document.getElementById('insert_btn');
				if (i != null){
					document.getElementById ('insert_btn').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=insert&page=$page',
							success:function(data) {
								//alert(data);
								if (data.trim() != 'Registro inserido!'){
									alert(data);
								}else{
									alert(data);
									location = './$page_aux.php';
								}/*

vex.defaultOptions.className = 'vex-theme-os';

function mostreFeedback(mensagem) {
  $('#feedback').attr('value', mensagem);
}

function confirmacao() {
  vex.dialog.confirm({
    message: 'Você tem certeza que deseja fazer isso?',
    callback: function(resultado) {
      if (resultado) {
        mostreFeedback('Ação confirmada com sucesso');
      } else {
        mostreFeedback('Ação cancelada');
      }
    }
  });

}		
mostreFeedback();	)*/			
		
								
							}  
						});		
					});
				};
				
				i = document.getElementById('delete_btn');
				if (i != null){
					document.getElementById ('delete_btn').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=delete&page=$page',
							success:function(data) {
								//alert(data);
								if (data.trim() != 'Registro deletado!'){
									alert(data);
								}else{
									alert(data);
									location = './$page_aux.php';
								}
							}  
						});		
					});
				};
				
				i = document.getElementById('logout');
				if (i != null){
					document.getElementById ('logout').addEventListener('click', function(){
						if (confirm('Deseja encerrar a sessão?')){
							location = './_session_.php?logout=TRUE';
						}
					});
				};
				
				i = document.getElementById('billing-filter-container-header');
				if (i != null){
					$('#billing-filter-container-header').click(function(){
						if ( $('#billing-filter-container').css('display') == 'none' )
							$('#billing-filter-container').css('display','block');
					  else
						$('#billing-filter-container').css('display','none');
					});					
				};
				
				$('#billing-filter-container-header').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				i = document.getElementById('operation-filter-container-header');
				if (i != null){
					$('#operation-filter-container-header').click(function(){
						if ( $('#operation-filter-container').css('display') == 'none' )
							$('#operation-filter-container').css('display','block');
					  else
						$('#operation-filter-container').css('display','none');
					});					
				};
				
				$('#operation-filter-container-header').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				i = document.getElementById('ps-filter-container-header');
				if (i != null){
					$('#ps-filter-container-header').click(function(){
						if ( $('#ps-filter-container').css('display') == 'none' )
							$('#ps-filter-container').css('display','block');
					  else
						$('#ps-filter-container').css('display','none');
					});					
				};
				
				$('#ps-filter-container-header').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				
				$('#logout').hover(function() {
					$(this).css('cursor','pointer');
					$('.green-dot').css('background-color','red');
				}, function() {
					$(this).css('cursor','auto');
					$('.green-dot').css('background-color',' #4CBB17');
				});
				
				$('#new-reg').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#new-reg2').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#delete_btn').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#insert_btn').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#update_btn').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#cancel_btn').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				$('#billings-update').hover(function() {
					$(this).css('cursor','pointer');
				}, function() {
					$(this).css('cursor','auto');
				});
				
				/*$(window).resize(function() {
					$('body').css('display', 'none');
				});*/
				
			});
		</script>
	</head>

	<body>
	    <div id='nav-container'>
			<header>
				<div id='logo'> ENGSYS </div>
				<nav>
				$nav
				</nav>
				<div id='logout'><div class='green-dot-text'>" . @$_SESSION["username"] . "</div><div class='green-dot'></div></div>
			</header>
			<div class='separator'></div>
		</div>
		<aside>
		</aside>
		<!--<section>
		    <input id='feedback' type='text' readonly style='width: 100%' />
			<input type='button' value='Confirmação' onclick='confirmacao()' /> -->
			$section
		<!--</section>-->
	</body>
</html>";
		
		if (isset($_SESSION["iduser_integ"])){
			echo $screen;
			return 0;
		}else{
			echo"<script> 
			         alert('A sua sessão expirou');
					 location = '../index.php?SessionExpiredTrue';
			     </script>";
			return 1;
		}
	}
?>