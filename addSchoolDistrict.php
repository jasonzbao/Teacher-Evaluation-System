<?php
include("db_connect.php");
$name = $_POST['name'];
$name = mysql_real_escape_string($name);
mysql_query("INSERT INTO district(name) VALUES('$name')");
?>