<?php
include("db_connect.php");
mysql_query("DELETE FROM surveys WHERE id>26");
?>