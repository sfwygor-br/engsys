<?php
	include("./variables.php");
	include("./connection.php");
	
	if(($_POST['action']=='insert') or ($_POST['action']=='update') or ($_POST['action']=='delete')){
		connect();
		if ($_POST['action']=='insert') {
			return(insert_record());
		} else if ($_POST['action']=='update') {
			return(update_record());
		} else if ($_POST['action']=='delete') {
			return(delete_record());
		}
		disconnect();
	}

	function insert_record(){
		$sql = "select sequence('" . $_POST['page'] . "') as id";
		$rs = mysqli_query($GLOBALS['conn'], $sql);
		$sequence = mysqli_fetch_assoc($rs);
		$lastelement = end($GLOBALS['fields_name'][$_POST['page']]);
		$sql = "insert into " . $_POST['page'] . " (";
		$pos = 0;
		$f__ = "";
		$v__ = "";
		$SSS = "";
		foreach($GLOBALS['fields_name'][$_POST['page']] as $field){
			$SSS = $SSS . $_POST[$field];
			$f__ = $f__ . $field;
			if ($field != $lastelement){
				$f__ = $f__ . ", ";
			}
			if ($pos == 0){
				$v__ = $v__ . $sequence['id'] . ", ";
			} else {
				if ($_POST[$field] == ""){
					$v__ = $v__ . "null";
				} else {
					if ($GLOBALS['fields_type'][$_POST['page']][$pos] == "number"){
						$v__ = $v__ . $_POST[$field];
					} else if (($GLOBALS['fields_type'][$_POST['page']][$pos] == "varchar") or ($GLOBALS['fields_type'][$_POST['page']][$pos] == "date")){
						$v__ = $v__ . "'" . $_POST[$field] . "'";
					}
				}
				
				if ($field != $lastelement){				
					$v__ = $v__ . ", ";
				}
			}
			$pos = $pos + 1;
			
		}
		$sql = $sql . $f__ . ") values(" . $v__ . ")";
		echo $sql;
		$rs = mysqli_query($GLOBALS['conn'], $sql);
		if ($rs == True){
			echo "Registro inserido!";
		}else{
			echo mysqli_error($GLOBALS['conn']);
		}
	};
	
	function update_record(){
		$lastelement = end($GLOBALS['fields_name'][$_POST['page']]);
		$sql = "update " . $_POST['page'] . " set ";
		$pos = 0;
		foreach($GLOBALS['fields_name'][$_POST['page']] as $field){
			$sql = $sql . $field . " = ";
			if ($GLOBALS['fields_type'][$_POST['page']][$pos] == "number"){
				$sql = $sql . $_POST[$field];
			} else if (($GLOBALS['fields_type'][$_POST['page']][$pos] == "varchar") or ($GLOBALS['fields_type'][$_POST['page']][$pos] == "date")){
				$sql = $sql . "'" . $_POST[$field] . "'";
			}
			if ($field != $lastelement){
				$sql = $sql . ", ";
			}
			$pos = $pos + 1;
		}
		#$sql = $sql . " where " . $GLOBALS['fields_name'][$_POST['page']][0] . " = " . $_POST[$GLOBALS['fields_name'][$_POST['page']][0]];
		$pos = 0;
		$sql = $sql . " where ";
		foreach($GLOBALS['fields_name'][$_POST['page']] as $field){
			if ($GLOBALS['is_key'][$_POST['page']][$pos] == "yes"){
				$sql = $sql . $field . " = " . $_POST[$field];
			}
			if (end($GLOBALS['is_key'][$_POST['page']])){
				break;
			}
			if ($GLOBALS['is_key'][$_POST['page']][$pos + 1] == "yes"){
				$sql = $sql . " and ";
			}
			$pos = $pos + 1;
		}
		
		$rs = mysqli_query($GLOBALS['conn'], $sql);
		if ($rs == True){
			echo "Registro atualizado!";
		}else{
			echo mysqli_error($GLOBALS['conn']);
		}
	};
	
	function delete_record(){
		$sql = "delete from " . $_POST['page'] . " where ";
		$pos = 0;
		foreach($GLOBALS['fields_name'][$_POST['page']] as $field){
			if ($GLOBALS['is_key'][$_POST['page']][$pos] == "yes"){
				$sql = $sql . $field . " = " . $_POST[$field];
			}
			if ($GLOBALS['is_key'][$_POST['page']][$pos + 1] == "yes"){
				$sql = $sql . " and ";
			}
			$pos = $pos + 1;
		}
		
		$rs = mysqli_query($GLOBALS['conn'], $sql);
		if ($rs == True){
			echo "Registro deletado!";
		}else{
			echo mysqli_error($GLOBALS['conn']);
		}
	}
?>















