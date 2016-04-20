<?php
include("db_connect.php");
print_r($_POST);
$first = $_POST['first'];
$last = $_POST['last'];
$updateid = $_POST['updateId'];
$first = mysql_real_escape_string($first);
$last = mysql_real_escape_string($last);
$updateid = mysql_real_escape_string($updateid);
echo $first;
echo $last;
echo $updateid;
mysql_query("UPDATE evaluees SET first='$first', last='$last' WHERE id='$updateid'") or die(mysql_error);
?>