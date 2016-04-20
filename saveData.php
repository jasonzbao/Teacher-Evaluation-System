<?php
include("db_connect.php");
$observationid = $_POST['observationid'];
$surveyJSON = $_POST['data'];
mysql_query("UPDATE observation SET surveyJSON='$surveyJSON' WHERE id='$observationid'");
?>