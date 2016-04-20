<?php
	include('db_connect.php');
	$district = $_POST['district'];
	if($_POST['data']=="evaluee"){
		$resultArray = array();
		$sql = mysql_query("SELECT first,last FROM evaluees WHERE districtid='$district' ORDER BY evaluees.last ASC");
		while($row = mysql_fetch_array($sql)){
			$resultArray[] = strtoupper($row['last'].",".$row['first']);
		}
		echo json_encode($resultArray);
		unset($resultArray);
	}
	if($_POST['data']=="evaluator"){
		$resultArray = array();
		$sql = mysql_query("SELECT first,last,id FROM evaluators WHERE districtid='$district' ORDER BY evaluators.last ASC");
		$counter=0;
		while($row=mysql_fetch_array($sql)){
			$resultArray[$counter] = array();
			$resultArray[$counter][0] = strtoupper($row['last'].",".$row['first']);
			$resultArray[$counter][1] = $row['id'];
			$counter++;
		}
		echo json_encode($resultArray);
	}

?>