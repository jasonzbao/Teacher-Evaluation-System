<?php

$host="localhost"; // Host name 
$username="jasonbao"; // Mysql username 
$password="UUwylTCglVt8"; // Mysql password 
$db_name = "Survey";
mysql_connect("$host", "$username", "$password") or die("cannot connect"); 
mysql_select_db("$db_name") or die("cannot select DB");
$entireFile = file_get_contents("evaluees.txt");
$entireFile = nl2br($entireFile);
$name = explode("<br />", $entireFile);
for ($i = 0; $i < count($name); $i++) {
	$mName = trim($name[$i]);
	$nameArr = explode(" ", $mName);
	$firstTemp = $nameArr[1];
	if (count($nameArr) > 2) $firstTemp = $firstTemp." ".$nameArr[2];
	$first = ucfirst(strtolower($firstTemp));
	$last = ucfirst(strtolower($nameArr[0]));
	$initial = substr($last, 0, 1);
	$mUsername = $first.$initial;
	echo $first." ".$last."\n";
	mysql_query("INSERT INTO evaluees (`id`,  `first`, `last`, `districtid`) VALUES (NULL,  '$first', '$last', '4')");
}
?>