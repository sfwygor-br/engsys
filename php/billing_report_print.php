<?php
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
		$aux0 = $aux0 . ", event e ";
		$aux5 = $aux5 . ", e.*";
		$aux2 = "   and e.type = ".$_POST["type"]."
		            and e.idevent = b.idevent";
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
	
	$sql = "select b.*
	               $aux5
	          from billing b
			       $aux0
			 where 1 = 1
			 $aux1
			 $aux2
			 $aux3
			 $aux4";
	echo $sql;
?>