<?php
	include("main.php");
	include("connection.php");
	require_once 'phplot.php';
	
	$plot = new PHPlot(1330 , 300);
	#$plot -> SetUseTTF(true);
	$plot -> SetTitle("Totais: Orçamentos e Projetos");
	$plot -> SetXTitle("Período");
	$plot -> SetYTitle("Quantidade");
	#$plot -> SetPrecisionY(1);
	#$plot -> SetPlotType("bars");
	
	$sql = "
			select case
				   when tmp.sqlcode = 0 then
					   'Orçamentos'
				   when tmp.sqlcode = 1 then
					   'Projetos'
				   end legend_text,
				   
				   tmp.by_month month_text,

				   tmp.totals

			from(
				  select count(b.idbudget) as totals,
								 month(b.initial_date) by_month,
								 0 sqlcode
						  from budget b
						 where 1 = 1
						   and b.initial_date <= now()
						   and b.initial_date >= date_format(now(), 'DD/MM/YYYY') - 365
						   and b.final_date <= now()
						   and b.final_date >= date_format(now(), 'DD/MM/YYYY') - 365
						group by month(b.initial_date), month(b.final_date)
						union all
						select count(p.idproject) as totals,
								 month(p.initial_date) by_month,
								 1 sqlcode
						  from project p
						 where 1 = 1
						   and p.initial_date <= now()
						   and p.initial_date >= date_format(now(), 'DD/MM/YYYY') - 365
						   and p.final_date <= now()
						   and p.final_date >= date_format(now(), 'DD/MM/YYYY') - 365
						group by month(p.initial_date), month(p.final_date)
			) tmp	
	";
	
	$data = array();
	connect();
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	$last_legend_text = "";
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
	$legend_text = array();
	$totals_text = array();
	if (($rs == True) and (mysqli_num_rows($rs) > 0)){
		while ($r = mysqli_fetch_assoc($rs)){
			$month = intval($r['month_text']);
			if ($month > 1) {
				$total = 0;
			} else if ($month == 1) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_jan, $total);
			
			if (($month > 2) or ($month < 2)) {
				$total = 0;
			} else if ($month == 2) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_feb, $total);
			
			if (($month > 3) or ($month < 3)) {
				$total = 0;
			} else if ($month == 3) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_mar, $total);
			
			if (($month > 4) or ($month < 4)) {
				$total = 0;
			} else if ($month == 4) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_apr, $total);
			
			if (($month > 5) or ($month < 5)) {
				$total = 0;
			} else if ($month == 5) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_may, $total);
			
			if (($month > 6) or ($month < 6)) {
				$total = 0;
			} else if ($month == 6) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_jun, $total);
			
			if (($month > 7) or ($month < 7)) {
				$total = 0;
			} else if ($month == 7) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_jul, $total);
			
			if (($month > 8) or ($month < 8)) {
				$total = 0;
			} else if ($month == 8) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_aug, $total);
			
			if (($month > 9) or ($month < 9)) {
				$total = 0;
			} else if ($month == 9) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_sep, $total);
			
			if (($month > 10) or ($month < 10)) {
				$total = 0;
			} else if ($month == 10) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_oct, $total);
			
			if (($month > 11) or ($month < 11)) {
				$total = 0;
			} else if ($month == 11) {
				$total	      = $r['totals'];
			}
			
			array_push($arr_nov, $total);
			
			if ($month == 12) {
				$total	      = $r['totals'];
			} else {
				$total	      = 0;
			}
			
			array_push($arr_dec, $total);
			
			if ($last_legend_text <> $r['legend_text']){
				array_push($legend_text, $r['legend_text']);
				$last_legend_text = $r['legend_text'];
			}
		}
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
	echo json_encode($data);
	
	
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
	
	$section = "
			<div id='notification'></div>
			<div id='charts'>
				<img src='".$plot -> EncodeImage()."' alt='Teste' />
			</div>
	";
	
	
	ob_end_clean();
	load_base_page("Dashboard", "dashboard", $section);
?>