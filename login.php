<?php
	include('db_connect.php');
	if($_POST['eSubmit'] == "Submit"){
		$user=$_POST['eusername'];
		$pass=$_POST['epassword'];
		$tbl_name = "evaluators";
		$user = stripslashes($user);
		$pass = stripslashes($pass);
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";	
		$result=mysql_query($sql);	
		$count=mysql_num_rows($result);
		if($count==1){
			$expire = time() + 60*60*24;
			setcookie("eusername", $user, $expire);
			setcookie("epassword", $pass, $expire);	
			header('Location:evaluator.php');
		}
	}elseif($_POST['saSubmit']=="Submit"){
		$user=$_POST['sausername'];
		$pass=$_POST['sapassword'];
		$tbl_name = "administrator";
		$user = stripslashes($user);
		$pass = stripslashes($pass);
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";	
		$result=mysql_query($sql);	
		$count=mysql_num_rows($result);
		if($count==1){
			$expire = time() + 60*60*24;
			setcookie("sausername", $user, $expire);
			setcookie("sapassword", $pass, $expire);	
			header('Location:admin.php');
		}
	}elseif($_POST['aSubmit']=="Submit"){
		$user=$_POST['ausername'];
		$pass=$_POST['apassword'];
		$tbl_name = "schoolAdmin";
		$user = stripslashes($user);
		$pass = stripslashes($pass);
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$sql="SELECT * FROM $tbl_name WHERE username='$user' and password='$pass'";	
		$result=mysql_query($sql);	
		$count=mysql_num_rows($result);
		if($count==1){
			$district = mysql_fetch_array($result)['districtid'];
			$expire = time() + 60*60*24;
			setcookie("adistrictid",$district,$expire);
			setcookie("ausername", $user, $expire);
			setcookie("apassword", $pass, $expire);	
			header('Location:schoolAdministrator.php');
		}
	}else{
		echo "Failure";
	}
?>