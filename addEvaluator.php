<?php
include("db_connect.php");
$first = $_POST['first'];
$last = $_POST['last'];
$district = $_POST['schoolDistrict'];
$username = $_POST['username'];
$password = $_POST['password'];
$first = mysql_real_escape_string($first);
$last = mysql_real_escape_string($last);
$district = mysql_real_escape_string($district);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
mysql_query("INSERT INTO evaluators(username,password,first,last,districtid) VALUES('$username','$password','$first','$last','$district')");
?>