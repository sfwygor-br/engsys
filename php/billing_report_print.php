<?php
	session_start();
	$aux0 = "";
	$aux1 = "";
	$aux2 = "";
	$aux3 = "";
	$aux4 = "";
	$aux5 = "";
	if ($_POST["search_parameter"] == "processing_date"){
		$aux1 = "  and date_format(b.processing_date, '%y %m %d') >= date_format('".$_POST["dini"]."', '%y %m %d')
		           and date_format(b.processing_date, '%y %m %d') <= date_format('".$_POST["dend"]."', '%y %m %d')";
	}else if ($_POST["search_parameter"] == "maturity_date"){
		$aux1 = "  and date_format(b.maturity_date, '%y %m %d') >= date_format('".$_POST["dini"]."', '%y %m %d')
		           and date_format(b.maturity_date, '%y %m %d') <= date_format('".$_POST["dend"]."', '%y %m %d')";
	}else if ($_POST["search_parameter"] == "payment_date"){
		$aux1 = "  and date_format(b.payment_date, '%y %m %d') >= date_format('".$_POST["dini"]."', '%y %m %d')
		           and date_format(b.payment_date, '%y %m %d') <= date_format('".$_POST["dend"]."', '%y %m %d')";
	};
	
	if ($_POST["type"] != ''){
		$aux2 = "   and e.type = ".$_POST["type"];
	}
	
	if ($_POST["project"] != ''){
		$aux0 = $aux0 . ", project proj";
		$aux5 = $aux5 . ", proj.*";
		$aux3 = "  and proj.idproject = b.idproject
		           and proj.idproject = ".$_POST["project"]."";
	}
	
	if ($_POST["person"] != ''){
		$aux0 = $aux0 . ", person p";
		$aux5 = $aux5 . ", p.*";
		$aux4 = "  and p.idperson = b.idperson
		           and b.idperson = ".$_POST["person"]."";
	}
	
	$sql = "
select b.idbilling,
       b.processing_date,
       b.maturity_date,
       b.payment_date,
       b.value,
       b.value_payed,
       concat(e.idevent, '  ', e.description) as event,
       case when e.type = 0 then 
           'SAÌDA'
       else 
           'ENTRADA'
       end as billing_type,
       sum(b.value) as value_total,
       sum(b.value_payed) as value_payed_total,
	   param.*
  from billing b,
       event e,
	   parameter param
 where 1 = 1
   and b.idevent = e.idevent
   and param.iduser_integ = ".$_SESSION["iduser_integ"]."
   and param.iduser_integ = b.iduser_integ
   $aux1
   $aux2
   $aux3
   $aux4";
  
	include("connection.php");
	connect();
	$aux6 = "";
	$value_total = 0;
	$value_payed_total = 0;
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	
	$aux6 = $aux6 . "<br>
	         <br><div style='text-align: center;'>
	             <div class='title' style='width:600px; height:20px; overflow: hidden; float: left; margin-left: 50px;'>Evento
		         </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Natureza
				 </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Valor
				 </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Valor Pago
				 </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Data Processamento
				 </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Data Pagamento
				 </div> <div class='title' style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>Data Vencimento</div></div><br>";
	
	while($r = mysqli_fetch_assoc($rs)){
		$engineer_name = $r["engineer_name"];
		$crea = $r["CREA"];
		$city = $r["city"];
		$state = $r["state"];
		$phones = $r["phones"];
		$adresses = $r["adresses"];
		$aux6 = $aux6 . "<div style='width:600px; height:20px; overflow: hidden; float: left; margin-left: 50px;'>".$r["event"].
		        "</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["type"].
				"</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["value"].
				"</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["value_payed"].
				"</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["processing_date"].
				"</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["payment_date"].
				"</div> <div style='width:100px; height:20px; overflow: hidden; margin-left: 10px; float: left;'>".$r["maturity_date"]."</div><br>";
		$value_total = $r["value_total"];
		$value_payed_total = $r["value_payed_total"];
	}
	disconnect();
	$aux6 = $aux6 . "
		<div style='float: right; margin-right: 10px; margin-top: 20%; clear:both;'>
			<div class='title'>Total: $value_total<br>
			                   Total Pago: $value_payed_total</div>
		</div>
	";
	
	$screen = "
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='../css/report.css'>
		<title> Relatório de contas </title>
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