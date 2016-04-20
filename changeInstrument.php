<?php
include("db_connect.php");
$districtid = $_POST['districtid'];
$instrumentid = $_POST['instrumentid'];
$districtid = mysql_real_escape_string($districtid);
$instrumentid = mysql_real_escape_string($instrumentid);
mysql_query("UPDATE district SET instrumentid='$instrumentid' WHERE id='$districtid'") or die(mysql_error);

?>