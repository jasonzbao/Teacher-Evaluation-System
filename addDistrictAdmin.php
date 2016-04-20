<?php
include("db_connect.php");
$district = $_POST['schoolDistrict'];
$username = $_POST['username'];
$password = $_POST['password'];
$district = mysql_real_escape_string($district);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
mysql_query("INSERT INTO schoolAdmin(username,password,districtid) VALUES('$username','$password','$district')");
?>