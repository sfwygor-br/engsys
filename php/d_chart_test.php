<?
	require_once 'phplot.php';
	
	$chart_test = new PHPlot(500 , 350);
	$chart_test -> SetTitle("Gráfico Teste");
	$chart_test -> SetXTitle("Eixo X");
	$chart_test -> SetYTitle("Eixo Y");
	#$chart_test -> SetPrecisionY(1);
	#$chart_test -> SetPlotType("bars");
	
	$data = array(
        array('Janeiro', 10),
        array('Fevereiro', 5),
        array('Março', 4),
        array('Abril', 8),
        array('Maio', 7),
        array('Junho', 5),
	);
	
	$chart_test -> SetDataValues($data);
	#$chart_test -> SetYDataLabelPos('plotin');
	$chart_test -> DrawGraph();
?>