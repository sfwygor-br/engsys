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
		$aux  = "<a href='$link_adress";
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
		<td>". $aux . "&" .$link . "&sql_macro=" . $sql_macro . "'>" . $r[$field] . $aux2 ."</td>";
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
				$x = "
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
		<select name='$field' class='field'>";
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
		
		function billing_type(){
			
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
				}else if (($field_type[$pos] =="provider_type") or ($field_type[$pos] =="yesno")){
					$form = $form . yesno($fields_name[$pos], '1');
					$pos = $pos + 1;					
				}else if (($field_type[$pos] =="status")){
					$form = $form . status($fields_name[$pos], '1');
					$pos = $pos + 1;					
				}else if ($field_type[$pos] =="billing_type"){
					$form = $form . yesno($fields_name[$pos], '0');
					$pos = $pos + 1;					
				}else{		
				    $aux = "";
                    if (!empty($fk)){
						if ($GLOBALS["fields_name"][$table][$fk] == $field){
							$aux = " value='$fk_v' ";
						}
					}				
					$form = $form.
	"<input class='field' type='".$field_type[$pos]."' placeholder='".$placeholder[$pos]."' size='".$field_size[$pos]."' name='".$fields_name[$pos]."' $aux>";
					if ($new_line[$pos]=="yes"){
						$form = $form."</p>
	<p>";	
					}
				$pos = $pos + 1;
				}
			}
		}else if ($action == 'update'){
			$r = mysqli_fetch_assoc($recordset);
			$pos = 0;
			foreach ($fields_name as $field){
				if ($field_type[$pos] =="person_type"){
					$form = $form . person_type($fields_name[$pos], $r[$fields_name[$pos]]);
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
				}else{
					$form = $form.
	"<input class='field' type='".$field_type[$pos]."' placeholder='".$placeholder[$pos]."' size='".$field_size[$pos]."' name='".$fields_name[$pos]."' value='".$r[$fields_name[$pos]]."'>";
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
		}else{
			$page_aux = $table;
		}
		
		if ($action == "insert"){
			$aux = "<p><input class='button' type='button' value='Gravar' id='insert'><input class='button' type='button' value='Cancelar' onclick='location=\"./".$page_aux.".php\"'>";
		}else if ($action == 'update'){
			$aux = "<p><input class='button' type='button' value='Salvar' id='update'><input class='button' type='button' value='Excluir' id='delete'><input class='button' type='button' value='Cancelar' onclick='location=\"./".$page_aux.".php\"'>";
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
?>