<?php
	function build_grid($fields_name,
	                    $fields_header, 	                     
						$field_size, 
						$recordset,
						$link_adress,
						$key_field){
		$grid = 
"<table>
	<tr>";
	    $headings = "";
		$size_pos = 0;
		foreach ($fields_header as $field){
			$headings = $headings . "
		<th style='width: ".$field_size[$size_pos]."px;'>$field</th>";
			$size_pos = $size_pos + 1;
		};
		$grid = $grid . $headings . "
	</tr>";
	
		$content = "";
		$aux  = "<a class='a-nav' href='$link_adress";
		$aux2 = "</a>";
		$i = 1;
		while($r = mysqli_fetch_assoc($recordset)){
			if ($i % 2){
				$class = "class='tr-odd'";
			}else{
				$class = "class='tr-even'";
			}
			$i = $i+1;
			$content = $content . "
	<tr $class>";
			$link = "";
			$sql_macro  = "";
			$l_cn = 0;
			foreach ($fields_name as $field){
				#if (strtoupper($field) == strtoupper($key_field)){
			    #if (in_array(strtoupper($field), strtoupper($key_field))){
				foreach($key_field as $key){					
					if (strtoupper($field) == strtoupper($key)){						
					#$link = $link . "key" . $l_cn . "=$r[$field]";
					$link = $link . "&" . $key . "=$r[$field]";
					$sql_macro  = $sql_macro . " and " . $key_field[$l_cn] . " = " . $r[$field];	
					}
				}
				$l_cn = $l_cn + 1;
			}			
			
			#echo $sql_macro;
			
			foreach($fields_name as $field){
				if (!empty($link) and (strtoupper($field) == strtoupper($key_field[0]))){
					$content = $content . "
		<td class='td-link'>". $aux . "&" .$link . "&sql_macro=" . $sql_macro . "'>" . $r[$field] . $aux2 ."</td>";
				}else{
				$content = $content . "
		<td>".$r[$field]."</td>";
			}
			};				
			
			$content = $content . "
	</tr>";
		};
		$grid = $grid . $content . "
</table>";
		return $grid;
	}
	
	function build_form($fields_name, 
	                    $placeholder, 
						$field_size, 
						$field_type, 
						$form_action, 
						$table, 
						$action,
						$new_line,
						$recordset,
						$fk,
						$fk_v){
		function yesno($field, $selected){
				$x = "
		<select name='$field' class='field'>";
			if ($selected == '0'){
				$x = $x."
			<option value='0' selected> Sim </option>
			<option value='1'> Não </option>
		</select>";
				
			} else if ($selected == '1'){
				$x = $x."
			<option value='0'> Sim </option>
			<option value='1' selected> Não </option>
		</select>";
			}
			
			return($x);
		};
		
		function status($field, $selected){
				$x = "Situação
		<select name='$field' class='field'>";
			if ($selected == '0'){
				$x = $x."
			<option value='0' selected> Ativo </option>
			<option value='1'> Inativo </option>
		</select>";
				
			} else if ($selected == '1'){
				$x = $x."
			<option value='0'> Ativo </option>
			<option value='1' selected> Inativo </option>
		</select>";
			}
			
			return($x);
		};
		
		function person_type($field, $selected){
			$x = "
		Tipo de Pessoa <select name='$field' class='field'>";
			if ($selected == '0'){
				$x = $x."
			<option value='0' selected> Física </option>
			<option value='1'> Jurídica </option>
		</select>";
				
			} else if ($selected == '1'){
				$x = $x."
			<option value='0'> Física </option>
			<option value='1' selected> Jurídica </option>
		</select>";
			}
			
			return($x);
		}
		
		function person_filter($field, $selected, $size){
			$x = "
		Filtro de pessoa <select name='$field' class='field' style='width: 100%;'>";
		    if (!isset($selected)){
				$x = $x . "
				<option value='null' selected> Selecione a pessoa </option>
				";
			};
			
			$sql = "select idperson,
						   name
			          from person
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					order by name desc";
			connect();
			$aux = "";
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    while($r = mysqli_fetch_assoc($rs)){
				if ($selected == $r["idperson"]){
					$aux = "selected";
				};
				$x = $x . "<option value='" . $r["idperson"] . "' $aux>" . $r["name"] . "</option>";
			}		
            $x = $x . "
			</select>
			</p>
			<p>";			
			return($x);
		}
		
		function person_provider($field, $selected, $size){
			$x = "
		Filtro de prestadores de serviço <select name='$field' class='field' style='width: 100%;'>";
		    if (!isset($selected)){
				$x = $x . "
				<option value='null' selected> Selecione Prestador de Serviços </option>
				";
			};
			
			$sql = "select idperson,
						   name
			          from person
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					   and provider = 0
					order by name desc";
			connect();
			echo $sql;
			$aux = "";
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    while($r = mysqli_fetch_assoc($rs)){
				if ($selected == $r["idperson"]){
					$aux = "selected";
				};
				$x = $x . "<option value='" . $r["idperson"] . "' $aux>" . $r["name"] . "</option>";
			}		
            $x = $x . "
			</select>
			</p>
			<p>";			
			return($x);
		}
		
		function event_filter($field, $selected, $size){
			$x = "
		Filtro de eventos <select name='$field' class='field' style='width: 100%;'>";
		    if (!isset($selected)){
				$x = $x . "
				<option value='null' selected> Selecione o Evento </option>
				";
			};
			
			$sql = "select idevent,
						   description
			          from event
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					order by description desc";
			connect();
			$aux = "";
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    while($r = mysqli_fetch_assoc($rs)){
				if ($selected == $r["idevent"]){
					$aux = "selected";
				};
				$x = $x . "<option value='" . $r["idevent"] . "' $aux>" . $r["description"] . "</option>";
			}		
            $x = $x . "
			</select>
			</p>
			<p>";			
			return($x);
		}
		
		function project_filter($field, $selected, $size){
			$x = "
		Filtro de projetos <select name='$field' class='field' style='width: 100%;'>";
		    if (!isset($selected)){
				$x = $x . "
				<option value='null' selected> Selecione o Projeto </option>
				";
			};
			
			$sql = "select idproject,
						   description
			          from project
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					order by description desc";
			connect();
			$aux = "";
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    while($r = mysqli_fetch_assoc($rs)){
				if ($selected == $r["idproject"]){
					$aux = "selected";
				};
				$x = $x . "<option value='" . $r["idproject"] . "' $aux>" . $r["description"] . "</option>";
			}		
            $x = $x . "
			</select>
			</p>
			<p>";			
			return($x);
		}
		
		function budget_filter($field, $selected, $size){
			$y = "";
			if (isset($selected)){
				$y = " ";
			};
			$x = "Filtro de Orçamentos
		<select name='$field' class='field' style='width: 100%' $y>";
		    if (!isset($selected)){
				$x = $x . "
				<option value='null' selected> Selecione o Orçamento </option>
				";
			}
			
			$sql = "select idbudget,
						   concat('Início: ',initial_date,', Término: ',final_date,', Cliente: ',(select person.name from person where person.idperson = budget.idperson)) as description
			          from budget
					 where iduser_integ = " . $_SESSION["iduser_integ"] . "
					order by description desc";
			connect();
			$aux = "";
			$rs  = mysqli_query($GLOBALS["conn"], $sql);
		    while($r = mysqli_fetch_assoc($rs)){
				if ($selected == $r["idbudget"]){
					$aux = "selected";
				};
				$x = $x . "<option value='" . $r["idbudget"] . "' $aux>" . $r["description"] . "</option>";
			}		
            $x = $x . "
			</select>
			</p>
			<p>";			
			return($x);
		}
		
		function billing_type($field, $selected, $size){
			$x = "&nbsp;Natureza
		<select name='$field' class='field' >";
			if ($selected == '0'){
				$x = $x."
			<option value='0' selected> Entrada </option>
			<option value='1'> Saída </option>
		</select>";
				
			} else if ($selected == '1'){
				$x = $x."
			<option value='0'> Entrada </option>
			<option value='1' selected> Saída </option>
		</select>";
			}
			
			return($x);
		}
		$form = 
"<form method='POST' action='$form_action' id='form'>
    <p>";
		$pos = 0;
		if ($action == 'insert'){
			foreach ($fields_name as $field){
				if ($field_type[$pos] =="person_type"){
					$form = $form . person_type($fields_name[$pos], '0');
					$pos = $pos + 1;
				}else if (($field_type[$pos] =="person_provider")){
					$form = $form . person_provider($fields_name[$pos], null, $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="project_filter")){
					$form = $form . project_filter($fields_name[$pos], null, $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="budget_filter")){
					$form = $form . budget_filter($fields_name[$pos], null, $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="event_filter")){
					$form = $form . event_filter($fields_name[$pos], null, $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="person_filter")){
					$form = $form . person_filter($fields_name[$pos], null, $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="provider_type") or ($field_type[$pos] =="yesno")){
					if ($field_type[$pos] =="provider_type"){
						$form = $form . "&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;Prestador ";
					};
					$form = $form . yesno($fields_name[$pos], '1');
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="status")){
					$form = $form . status($fields_name[$pos], '1');
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="billing_type"){
					$form = $form . billing_type($fields_name[$pos], '0', $field_size[$pos]);
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="textarea"){
					$form = $form.
	"<br />
	<br />
	<label> " . $placeholder[$pos] . "</label><br /> <textarea class='field' style='width: 100%' rows='50' name='".$fields_name[$pos]."'></textarea>";
					$pos = $pos + 1;					
				}else{		
				    $aux = "";
                    if (!empty($fk)){
						if ($GLOBALS["fields_name"][$table][$fk] == $field){
							$aux = " value='$fk_v' ";
						}
					}				
					$form = $form.
	"<label> " . $placeholder[$pos] . "</label> <input class='field' type='".$field_type[$pos]."' size='".$field_size[$pos]."' name='".$fields_name[$pos]."' $aux>";
					if ($new_line[$pos]=="yes"){
						$form = $form."</p>
	<p>";	
					}
				$pos = $pos + 1;
				}
			}
		}else if (($action == 'update') or ($action == 'alterstatus')){
			$r = mysqli_fetch_assoc($recordset);
			$pos = 0;
			foreach ($fields_name as $field){
				if ($field_type[$pos] =="person_type"){
					$form = $form . person_type($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;
				}else if (($field_type[$pos] =="person_provider")){
					$form = $form . person_provider($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="project_filter")){
					$form = $form . project_filter($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="budget_filter")){
					$form = $form . budget_filter($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="event_filter")){
					$form = $form . event_filter($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="person_filter")){
					$form = $form . person_filter($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="provider_type") or ($field_type[$pos] =="yesno")){
					if ($field_type[$pos] =="provider_type"){
						$form = $form . "&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;Prestador ";
					};
					$form = $form . yesno($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="status")){
					$form = $form . status($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="billing_type"){
					$form = $form . billing_type($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="textarea"){
					$form = $form.
	"<br />
	<br />
	<label> " . $placeholder[$pos] . "</label><br /> <textarea class='field' style='width: 100%' rows='50' name='".$fields_name[$pos]."'>". $r[$fields_name[$pos]]."</textarea>";
					$pos = $pos + 1;					
				}else{
				/*	
					
				if ($field_type[$pos] =="person_type"){
					$form = $form . person_type($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;
				}else if (($field_type[$pos] == "person_filter")){
					$form = $form . person_filter($fields_name[$pos], $r[$fields_name[$pos]], $field_size[$pos]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="provider_type") or ($field_type[$pos] =="yesno")){
					$form = $form . yesno($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="status")){
					$form = $form . status($fields_name[$pos], '1');
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="billing_type"){
					$form = $form . yesno($fields_name[$pos], $r[$fields_name[$pos]]);
					$pos = $pos + 1;					
				}else{*/
					$form = $form.
	"<label> " . $placeholder[$pos] . "</label>	<input class='field' type='".$field_type[$pos]."' size='".$field_size[$pos]."' name='".$fields_name[$pos]."' value='".$r[$fields_name[$pos]]."'>";
					if ($new_line[$pos]=="yes"){
						$form = $form."</p>
	<p>";	
					}
				$pos = $pos + 1;
				}
			}
		}
		
		if (in_array($table, array("phone", "adress", "person"))){
			$page_aux = "person";
		} else if (in_array($table, array("project", "project_stage", "attachment", "operation"))){
			$page_aux = "projects";
		} else if (in_array($table, array("billing"))){
			$page_aux = "billings";
		}else{
			$page_aux = $table;
		}
		
		if ($action == "insert"){
			$aux = "<p><input class='button' type='button' value='Gravar' id='insert_btn'><input class='button' type='button' value='Cancelar' id='cancel_btn' onclick='location=\"./".$page_aux.".php\"'>";
		}else if ($action == 'update'){
			$aux = "<p><input class='button' type='button' value='Salvar' id='update_btn'><input class='button' type='button' value='Excluir' id='delete_btn'><input class='button' type='button' value='Cancelar' id='cancel_btn' onclick='location=\"./".$page_aux.".php\"'>";
		}else if ($action == 'alterstatus'){
			$aux = "<p><input class='button' type='button' value='Salvar' id='update_btn'><input class='button' type='button' value='Cancelar' id='cancel_btn' onclick='location=\"./".$page_aux.".php\"'>";
		}
		$form = $form.
	"
	$aux
</form>";
		if ($action == 'insert'){
			
		}else if ($action == 'update'){
			
		}
		#$form = $form .
		
		return($form);
	}
	
	function curdate(){
		return date('Y-m-d');
	}
?>