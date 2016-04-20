<?php
include("db_connect.php");
$first = $_POST['first'];
$last = $_POST['last'];
$district = $_POST['schoolDistrict'];
$first = mysql_real_escape_string($first);
$last = mysql_real_escape_string($last);
$district = mysql_real_escape_string($district);
mysql_query("INSERT INTO evaluees(first,last,districtid) VALUES('$first','$last','$district')");

?>