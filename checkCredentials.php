<?php
$user = $_COOKIE['eusername'];
$pass = $_COOKIE['epassword'];
include('db_connect.php');
$tbl_name = "evaluators";
$user = stripslashes($user);
$pass = stripslashes($pass);
$user = mysql_real_escape_string($user);
$pass = mysql_real_escape_string($pass);
if($user!="" && $pass!=""){
	$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";
	$query_result=mysql_query($sql);
	$result = mysql_fetch_array($query_result);
	$districtid=$result['districtid'];
    $evaluatorid = $result['id'];
    $count=mysql_num_rows($query_result);
    if($count==1){
    }else{
		unset($_COOKIE['username']);
		unset($_COOKIE['password']);
		setcookie('eusername', "", time()-100);
		setcookie('epassword', "", time()-100);
		header('Location:home.php');
    }
}else{
	header('Location:home.php');
}
?>