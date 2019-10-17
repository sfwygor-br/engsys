<?php
	session_start();
	
	$sql = "
select ps.*,
	   concat(ps.expected_initial_date,' / ',ps.expected_final_date,'  --  ',ps.initial_date,' / ',ps.final_date) dates,
	   case when ps.final_date is not null then
		   'CONCLUÍDO'
	   else
		   'EM EXECUÇÃO'
	   end ps_status,
	   param.*,
	   p.description
  from project_stage ps,
	   parameter param,
	   project p,
	   budget b
 where 1 = 1
   and param.iduser_integ = ".$_SESSION["iduser_integ"]."
   and param.iduser_integ = b.iduser_integ
   and b.idbudget = p.idbudget
   and p.idproject = ps.idproject
   and p.idproject = ".$_POST["project"];
  
	include("connection.php");
	connect();
	$aux6 = "";
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	
	if (mysqli_num_rows($rs) <= 0) {
		echo"<script> alert('A consulta não retornou dados.'); location='./reports.php';</script>";
	}
	
	$aux6 = $aux6 . "<br>
	         <br><div style='text-align: center;'>
	             <div class='title' style='width:600px; height:20px; overflow: hidden; float: left; margin-left: 50px;'>Etapa - Descrição
		         </div> <div class='title' style='width:350px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Datas: Início/Termino prevista -- Início/Termino efetiva
				 </div> <div class='title' style='width:150px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Status</div><br>
				 ";
	
	while($r = mysqli_fetch_assoc($rs)){
		$engineer_name = $r["engineer_name"];
		$crea = $r["CREA"];
		$city = $r["city"];
		$state = $r["state"];
		$phones = $r["phones"];
		$adresses = $r["adresses"];
		$aux6 = $aux6 . "<div style='float:left; clear:both;'><div style='width:600px; height:20px; overflow: hidden; float: left; margin-left: 50px;'>".$r["description"].
		        "</div> <div style='width:350px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["dates"].
				"</div> <div style='width:150px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["ps_status"]."</div></div><br>
				";
	}
	
	$chart_sql = "
					select sum(p.expected_final_date - p.expected_initial_date) as project_predicted,
						   sum(ps.expected_final_date - ps.expected_initial_date) as predicted,
						   sum(ps.final_date - ps.initial_date) as efective
					  from project_stage ps,
						   project p,
						   budget b
					 where p.idproject = ps.idproject
					   and p.idbudget = p.idbudget
					   and b.iduser_integ = ".$_SESSION["iduser_integ"]."
					group by p.idproject
	";
	
	disconnect();
	
	$screen = "
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='../css/report.css'>
		<title> Relatório de Etapa de Projeto </title>
	</head>
	<body>
		<div id='main'>
			<div id='header'>
				<div id='engineer-data'>
					<div class='title'>Engenheiro:<br>
											 CREA:<br>
										   Cidade:<br>
										   Estado:<br>
										 Telefone:<br>
										 Endereço:
					</div>
				</div>
				<div id='engineer-data-rs'>
					&nbsp;$engineer_name<br>
					&nbsp;$crea<br>
					&nbsp;$city<br>
					&nbsp;$state<br>
					&nbsp;$phones<br>
					&nbsp;$adresses<br>
				</div>
				<div style='height: 20px; margin-top:50px; float: left; font-weight: bold; font-size: 30pt;'> Relatório de Etapa de Projeto</div>
			</div>
			<div id='body'>
			    $aux6
			</div>
		</div>
	</body>
</html>
";
echo $screen;	
	
	
	
?>