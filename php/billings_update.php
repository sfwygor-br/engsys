<?php
    session_start();
	include("main.php");
	include("connection.php");
	include("builder.php");
	include("variables.php");
	
	$action = @$_POST["payment_date"];
	
	connect();
	$page = 'billing';
	
	$section = "
	    <fieldset> Situação de contas:<br>
		    <form method='POST' action='./billings_update.php'>
				<input type='radio' name='payment_date' value='and payment_date is null' checked> A baixar
				<input type='radio' name='payment_date' value='and payment_date is not null'> A cancelar
				<input type='submit' class='button' value='Selecionar'>
			</form>
		</fieldset> <br>
		
		<table>
			<tr>
				<th>Código</th>
				<th>Evento</th>
				<th>Valor</th>
				<th>Ação</th>
			</tr>
		";
		
	$sql = "select b.*,
                   (select description from event e where e.idevent = b.idevent) as event,
                   concat(' and idbilling = ', idbilling) as sql_macro				   
	          from billing b
			 where 1 = 1
			   $action
			   and iduser_integ = ".$_SESSION["iduser_integ"];
	$rs = mysqli_query($GLOBALS["conn"], $sql);
	while ($r = mysqli_fetch_assoc($rs)){
		$class = "";
		if ($i % 2){
			$class = "class='tr-odd'";
		}else{
			$class = "class='tr-even'";
		}
			$i = $i+1;
		$section = $section . "
			<tr $class>
				<td>".$r["idbilling"]."</td>
				<td>".$r["event"]."</td>
				<td>".$r["value"]."</td>
				<td><a href='./billings.php?action=ALTERSTATUS&sql_macro=".$r["sql_macro"]."'>Baixar</a></td>
			</tr>
		";
	}
	$section = $section . "</table>";
	
	ob_end_clean();		
	load_base_page("Baixa/Cancelamento de Baixas", $page, $section);
	disconnect();
?>