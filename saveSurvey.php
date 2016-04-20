<?php
include('db_connect.php');
$evaluatorid = mysql_real_escape_string($_POST['evaluator']);
$q1 = mysql_real_escape_string($_POST['q1']);
$evaluee = mysql_real_escape_string($_POST['evaluee']);
$last = substr($evaluee, 0, strpos($evaluee, ","));
$first = substr($evaluee, strpos($evaluee,",")+1);
$result = mysql_query("SELECT * FROM evaluees WHERE UPPER(first) = UPPER('$first') AND UPPER(last) = UPPER('$last')");
$evalueeid = mysql_fetch_array($result)['id'];
$q5 = mysql_real_escape_string($_POST['q5']);
$q6 = mysql_real_escape_string($_POST['q6']);
$q7 = mysql_real_escape_string($_POST['q7']);
$q8 = mysql_real_escape_string($_POST['q8']);
$startTime = mysql_real_escape_string($_POST['startTime']);
$evaluator = mysql_real_escape_string($_POST['evaluatorSelect']);
$last = substr($evaluator, 0, strpos($evaluator, ","));
$first = substr($evaluator, strpos($evaluator,",")+1);
$result = mysql_query("SELECT * FROM evaluators WHERE UPPER(first) = UPPER('$first') AND UPPER(last) = UPPER('$last')");
$evaluatorid2 = mysql_fetch_array($result)['id'];
$q9 = mysql_real_escape_string($_POST['q9']);
if($_POST['newsurvey']=="true"){
	mysql_query("INSERT INTO observation(evaluatorid,q1,evalueeid,q5,q6,q7,q8,startTime,evaluatorSelect,q9) VALUES('$evaluatorid', '$q1', '$evalueeid', '$q5', '$q6','$q7','$q8','$startTime','$evaluatorid2','$q9')");
	echo mysql_insert_id();
}else{
	$id = $_POST['observationid'];
	echo $id;
	mysql_query("UPDATE observation SET evaluatorid='$evaluatorid', q1='$q1',evalueeid='$evalueeid',q5='$q5',q6='$q6',q7='$q7',q8='$q8',startTime='$startTime',evaluatorSelect='$evaluatorid2',q9='$q9' WHERE id='$id'");
}
?>