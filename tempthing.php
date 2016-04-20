<?php
include("db_connect.php");
include_once("dBug.php");
//$name = $_POST['name'];
$name="bao,jason";
function changeNameToId($name, $tbl_name){
	$last = substr($name, 0, strpos($name, ","));
	$first = substr($name, strpos($name,",")+1);
	return mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE UPPER(first) = UPPER('$first') AND UPPER(last) = UPPER('$last')"))['id'];
}
$id = changeNameToId($name,"evaluees");
$result = mysql_query("SELECT * FROM observation WHERE evalueeid='$id'");
$arrayEvaluations = array();
while($row = mysql_fetch_array($result)){
	$tobeappended = json_decode($row['surveyJSON']);
	array_push($arrayEvaluations,$tobeappended);
}
new dBug($arrayEvaluations);
?>