<?php
include("db_connect.php");
$observationid = $_POST['observationid'];
mysql_query("UPDATE observation SET completed=1 WHERE id='$observationid'");

?>