<?php
include("db_connect.php");
$id = $_POST['updateId'];
echo $id;
mysql_query("DELETE FROM evaluees WHERE id='$id'");
?>