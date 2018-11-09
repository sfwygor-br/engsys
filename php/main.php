<?php
	function load_base_page($page_title, $page, $section){
		ob_start();
		ob_end_clean();
		session_start();
		#$page = $v;
		$nav  = "";
	    #echo "<script language='JavaScript'>/*<document.location='main.php?r=1&width='+screen.width+'&Height='+screen.height*/ alert(window.innerWidth);</script>";
		if (!empty($page)){
			if ($page == 'dashboard'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav-active'><div class='div-a-nav-active'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'projects'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav-active'><div class='div-a-nav-active'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if(($page == 'person') or ($page == 'phone') or ($page == 'adress')){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav-active'><div class='div-a-nav-active'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'billings'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav-active'><div class='div-a-nav-active'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'maintenance'){
				$nav =   
				   "	<a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav-active'><div class='div-a-nav-active'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav'><div class='div-a-nav'>Relatórios</div></a>";
			}else if($page == 'reports'){
				$nav =   
				   "    <a href='./dashboard.php' class='a-nav'><div class='div-a-nav'>DASHBOARD</div></a>
					<a href='./projects.php' class='a-nav'><div class='div-a-nav'>Projetos</div></a>
					<a href='./person.php' class='a-nav'><div class='div-a-nav'>Pessoas</div></a>			
					<a href='./billings.php' class='a-nav'><div class='div-a-nav'>Contas</div></a>
					<a href='./maintenance.php' class='a-nav'><div class='div-a-nav'>Manutenções</div></a>
					<a href='./reports.php' class='a-nav-active'><div class='div-a-nav-active'>Relatórios</div></a>";
			};
		};
		$screen =
"<html>
	<head>
		<title>$page_title</title>
		<link type='text/css' rel='stylesheet' href='../css/global.css' />
		<script src='../js/jquery.js'></script>
		<script type='text/javascript'>
			$(document).ready(function(){
				let i = document.getElementById('update');
				if (i != null){
					document.getElementById ('update').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=update&page=$page',
							success:function(data) {
								alert(data);
							} 
						});		
					});
				};
				
				i = document.getElementById('insert');
				if (i != null){
					document.getElementById ('insert').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=insert&page=$page',
							success:function(data) {
								alert(data);
							}  
						});		
					});
				};
				
				i = document.getElementById('delete');
				if (i != null){
					document.getElementById ('delete').addEventListener('click', function(){
						$.ajax({
							type: 'POST',
							url: './data_process.php',
							data: $('#form').serialize()+'&action=delete&page=$page',
							success:function(data) {
								alert(data);
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
			});
		</script>
	</head>

	<body>
		<header>
			<div id='logo'> ENGSYS </div>
			<nav>
			$nav
			</nav>
			<div id='logout'><div class='green-dot-text'>" . $_SESSION["username"] . "</div><div class='green-dot'></div></div>
		</header>
		<div class='separator'></div>
		<aside>
		</aside>
		<section>
			$section
		</section>
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