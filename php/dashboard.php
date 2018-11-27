<?php
    if (!isset($_GET["width"])){
		echo "<script> location='./dashboard.php?width='+screen.width;</script>";	
	}
	include("main.php");
	include("connection.php");
	require_once 'phplot.php';
	session_start();
	connect();
	$sql = "
select 'orange' as color,
       concat('Contas a vencer/vencidas: ', date_format(b.maturity_date, '%d %m %y')) as notification,
	   concat('./billings.php?action=UPDATE&sql_macro= and idbilling = ', b.idbilling) as link
  from billing b,
       configuration c
 where 1 = 1
   and b.iduser_integ = ".$_SESSION["iduser_integ"]."
   and b.iduser_integ = c.iduser_integ
union all
select 'yellow' as color,
       concat('Projetos com prazos a vencer/vencidos: ', date_format(b.final_date, '%d %m %y')) as notification,
	   concat('./projects.php?action=UPDATE&sql_macro= and idproject = ', b.idproject) as link
  from project b,
       configuration c
 where 1 = 1
   and b.iduser_integ = ".$_SESSION["iduser_integ"]."
   and b.iduser_integ = c.iduser_integ
union all
select 'purple' as color,
       concat('Etapas de projetos com prazos a vencer/vencidos: ', date_format(b.final_date, '%d %m %y')) as notification,
	   concat('./projects.php?action=PROJECTSTAGEUPDATE&sql_macro=',b.idproject,' and idproject_stage = ', b.idproject_stage, ' and idproject = ', b.idproject) as link
  from project_stage b,
       configuration c,
	   project p
 where 1 = 1
   and p.iduser_integ = ".$_SESSION["iduser_integ"]."
   and p.idproject      = b.idproject
   and p.iduser_integ = c.iduser_integ;
	"; #b.maturity_date >= round(now() + c.notification_period)
	$section = "
			<div id='notif'>
				<div id='notif-msg-container'>
					<div id='notif-msg'>
						&nbsp;&nbsp;&nbsp;&nbsp;Notificações
					</div>
				</div>
	";
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	while($r = mysqli_fetch_assoc($rs)){
		$section = $section . "
		         <div id='notif-deadline'>
					<a class='a-notif' href='".$r["link"]."' style='color: ".$r["color"].";'>".$r["notification"]."</a>
				 </div>
		";
	}
	$section = $section . "
			</div>
	";
	
	#$width = echo"<script>screen.width</script>";
	$plot = new PHPlot(intval($_GET["width"]) - 30, 300);
	#$plot -> SetUseTTF(true);
	$plot -> SetTitle("Totais: Orcamentos e projetos anual");
	$plot -> SetXTitle("Periodo");
	$plot -> SetYTitle("Quantidade");
	$plot -> SetPrecisionY(1);
	$plot -> SetPlotType("bars");
	$sql = "
select tmp.*
  from(
       select 'Abertura de orçamentos' indicator_name,
                
              (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 1
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 2
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 3
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 4
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 5
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 6
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,
               
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 7
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 8
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 9
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 10
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 11
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,
               
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(initial_date) = 12
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
union all
select tmp.*
  from(
       select 'Encerramento de orçamentos' indicator_name,
                
              (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 1
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 2
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 3
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 4
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 5
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 6
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,
               
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 7
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 8
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,
                
               (select coalesce(count(idbudget
			     and iduser_integ = ".$_SESSION["iduser_integ"]."), 0)
                 from budget 
                where month(final_date) = 9
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 10
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,
                
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 11
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,
               
               (select coalesce(count(idbudget), 0)
                 from budget 
                where month(final_date) = 12
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
union all
select tmp.*
  from(
       select 'Abertura de projetos' indicator_name,
                
              (select coalesce(count(idproject), 0)
                 from project
                where month(initial_date) = 1
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 2
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 3
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 4
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 5
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 6
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,
               
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 7
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 8
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,
                
               (select coalesce(count(idproject
			     and iduser_integ = ".$_SESSION["iduser_integ"]."), 0)
                 from project 
                where month(initial_date) = 9
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 10
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 11
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,
               
               (select coalesce(count(idproject), 0)
                 from project 
                where month(initial_date) = 12
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
union all
select tmp.*
  from(
       select 'Encerramento de projetos' indicator_name,
                
              (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 1
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 2
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 3
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 4
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 5
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 6
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,
               
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 7
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 8
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 9
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 10
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,
                
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 11
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,
               
               (select coalesce(count(idproject), 0)
                 from project 
                where month(final_date) = 12
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
	";
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	$data = array();
	$legend_text = array();
	$arr_jan = array();
	$arr_feb = array();
	$arr_mar = array();
	$arr_apr = array();
	$arr_may = array();
	$arr_jun = array();
	$arr_jul = array();
	$arr_aug = array();
	$arr_sep = array();
	$arr_oct = array();
	$arr_nov = array();
	$arr_dec = array();
	array_push($arr_jan, "Janeiro");
	array_push($arr_feb, "Fevereiro");
	array_push($arr_mar, "Março");
	array_push($arr_apr, "Abril");
	array_push($arr_may, "Maio");
	array_push($arr_jun, "Junho");
	array_push($arr_jul, "Julho");
	array_push($arr_aug, "Agosto");
	array_push($arr_sep, "Setembro");
	array_push($arr_oct, "Outubro");
	array_push($arr_nov, "Novembro");
	array_push($arr_dec, "Dezembro");
	while($r = mysqli_fetch_assoc($rs)){
		array_push($legend_text, $r["indicator_name"]);
		array_push($arr_jan, $r["jan"]);
		array_push($arr_feb, $r["feb"]);
		array_push($arr_mar, $r["mar"]);
		array_push($arr_apr, $r["apr"]);
		array_push($arr_may, $r["may"]);
		array_push($arr_jun, $r["jun"]);
		array_push($arr_jul, $r["jul"]);
		array_push($arr_aug, $r["aug"]);
		array_push($arr_sep, $r["sep"]);
		array_push($arr_oct, $r["oct"]);
		array_push($arr_nov, $r["nov"]);
		array_push($arr_dec, $r["dec_"]);
	}
	array_push($data, $arr_jan);
	array_push($data, $arr_feb);
	array_push($data, $arr_mar);
	array_push($data, $arr_apr);
	array_push($data, $arr_may);
	array_push($data, $arr_jun);
	array_push($data, $arr_jul);
	array_push($data, $arr_aug);
	array_push($data, $arr_sep);
	array_push($data, $arr_oct);
	array_push($data, $arr_nov);
	array_push($data, $arr_dec);
	
	
	// $data = array(
        // array('Janeiro', 10, 15, 23, 13),
        // array('Fevereiro', 15, 3, 8, 8),
        // array('Março', 23,4,0,5),
        // array('Abril', 13,25,6,0),
        // array('Maio', 19,45,1,0),
        // array('Junho', 5,30,0,7),
	// );
	#legend_text = array('EVENTO 1', 'EVENTO 2', 'EVENTO 3', 'EVENTO 4', 'EVENTO 5', 'EVENTO 6');
	$plot -> SetDataValues($data);
	$plot -> SetYDataLabelPos('plotin');
	$plot -> SetPrintImage(False);
	
	$plot -> SetLegend($legend_text);
	
	$plot -> DrawGraph();
	
	$section = $section . "
			<div id='charts'>
				<div id='notif-msg-container'>
					<div id='notif-msg'>
						&nbsp;&nbsp;&nbsp;&nbsp;Dados gráficos - Orçamentos e Projetos
					</div>
				</div>
				<img src='".$plot -> EncodeImage()."' alt='Teste' />
			</div>
	";

	unset($plot);
	unset($date);
	unset($legend_text);
	unset($arr_jan);
	unset($arr_feb);
	unset($arr_mar);
	unset($arr_apr);
	unset($arr_may);
	unset($arr_jun);
	unset($arr_jul);
	unset($arr_aug);
	unset($arr_sep);
	unset($arr_oct);
	unset($arr_nov);
	unset($arr_dec);	
	$plot = new PHPlot(intval($_GET["width"]) - 30, 300);
	#$plot -> SetUseTTF(true);
	$plot -> SetTitle("Totais: Orcamentos e projetos anual");
	$plot -> SetXTitle("Periodo");
	$plot -> SetYTitle("Valores");
	$plot -> SetPrecisionY(2);
	$plot -> SetPlotType("bars");
	
	$sql = "
select tmp.*
  from(
       select 'Total de entradas previstas' indicator_name,

              (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 1
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 2
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 3
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 4
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 5
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 6
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(maturity_date) = 7
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 8
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(maturity_date) = 9
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 10
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 11
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,

               (select coalesce(sum(value), 0)
                 from billing
                where month(maturity_date) = 12
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
union all
select tmp.*
  from(
       select 'Total de entradas efetivadas' indicator_name,

              (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 1
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jan,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 2
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") feb,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 3
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") mar,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 4
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") apr,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 5
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") may,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 6
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jun,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 7
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") jul,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 8
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") aug,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 9
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") sep,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 10
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") oct,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 11
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") nov,

               (select coalesce(sum(value_payed), 0)
                 from billing
                where month(payment_date) = 12
				  and type = 0
				  and iduser_integ = ".$_SESSION["iduser_integ"].") dec_
      )tmp
	";
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	$data = array();
	$legend_text = array();
	$arr_jan = array();
	$arr_feb = array();
	$arr_mar = array();
	$arr_apr = array();
	$arr_may = array();
	$arr_jun = array();
	$arr_jul = array();
	$arr_aug = array();
	$arr_sep = array();
	$arr_oct = array();
	$arr_nov = array();
	$arr_dec = array();
	array_push($arr_jan, "Janeiro");
	array_push($arr_feb, "Fevereiro");
	array_push($arr_mar, "Março");
	array_push($arr_apr, "Abril");
	array_push($arr_may, "Maio");
	array_push($arr_jun, "Junho");
	array_push($arr_jul, "Julho");
	array_push($arr_aug, "Agosto");
	array_push($arr_sep, "Setembro");
	array_push($arr_oct, "Outubro");
	array_push($arr_nov, "Novembro");
	array_push($arr_dec, "Dezembro");
	while($r = mysqli_fetch_assoc($rs)){
		array_push($legend_text, $r["indicator_name"]);
		array_push($arr_jan, $r["jan"]);
		array_push($arr_feb, $r["feb"]);
		array_push($arr_mar, $r["mar"]);
		array_push($arr_apr, $r["apr"]);
		array_push($arr_may, $r["may"]);
		array_push($arr_jun, $r["jun"]);
		array_push($arr_jul, $r["jul"]);
		array_push($arr_aug, $r["aug"]);
		array_push($arr_sep, $r["sep"]);
		array_push($arr_oct, $r["oct"]);
		array_push($arr_nov, $r["nov"]);
		array_push($arr_dec, $r["dec_"]);
	}
	array_push($data, $arr_jan);
	array_push($data, $arr_feb);
	array_push($data, $arr_mar);
	array_push($data, $arr_apr);
	array_push($data, $arr_may);
	array_push($data, $arr_jun);
	array_push($data, $arr_jul);
	array_push($data, $arr_aug);
	array_push($data, $arr_sep);
	array_push($data, $arr_oct);
	array_push($data, $arr_nov);
	array_push($data, $arr_dec);
	
	
	// $data = array(
        // array('Janeiro', 10, 15, 23, 13),
        // array('Fevereiro', 15, 3, 8, 8),
        // array('Março', 23,4,0,5),
        // array('Abril', 13,25,6,0),
        // array('Maio', 19,45,1,0),
        // array('Junho', 5,30,0,7),
	// );
	#legend_text = array('EVENTO 1', 'EVENTO 2', 'EVENTO 3', 'EVENTO 4', 'EVENTO 5', 'EVENTO 6');
	$plot -> SetDataValues($data);
	$plot -> SetYDataLabelPos('plotin');
	$plot -> SetPrintImage(False);
	
	$plot -> SetLegend($legend_text);
	
	$plot -> DrawGraph();
	
	$section = $section . "
			<div id='charts'>
				<div id='notif-msg-container'>
					<div id='notif-msg'>
						&nbsp;&nbsp;&nbsp;&nbsp;Dados gráficos - Financeiro
					</div>
				</div>
				<img src='".$plot -> EncodeImage()."' alt='Teste' />
			</div>
	";
	
	
	ob_end_clean();
	load_base_page("Dashboard", "dashboard", $section);
?>