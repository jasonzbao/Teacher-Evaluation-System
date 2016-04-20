<?php
include("db_connect.php");
$surveystring = $_POST['surveystring'];
$title = $_POST['title'];
$title=mysql_real_escape_string($title);
$surveystring = mysql_real_escape_string($surveystring);
$id = $_POST['id'];
if($id==""){
	mysql_query("INSERT INTO surveys(title, surveystring) VALUES ('$title','$surveystring')") or die(mysql_error());
	echo "Success! You can find your survey here at: http://www.onmyfeet.net/survey2/loadSurvey.php?id=".mysql_insert_id();
}else{
	mysql_query("UPDATE surveys SET surveystring='$surveystring' WHERE id='$id'") or die(mysql_error());
	echo "Success! You can find your edited survey here at: http://www.onmyfeet.net/survey2/loadSurvey.php?id=".$id;
}
?>