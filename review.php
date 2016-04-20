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
	    $result=mysql_query($sql);
	    $count=mysql_num_rows($result);
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
	$result1 = mysql_query("SELECT * FROM evaluators WHERE username='$user'");
	$evaluator = mysql_fetch_array($result1);
	$districtid = $evaluator['districtid'];
	//$result3 = mysql_query("SELECT * FROM district WHERE id='$districtid'");
	//echo mysql_fetch_array($result3)['name'];
	$sql = mysql_query("SELECT first,last,id FROM evaluees WHERE districtid='$districtid' ORDER BY evaluees.last ASC");
	while($row = mysql_fetch_array($sql)){
		$resultArray[] = strtoupper($row['last'].",".$row['first']);
		$valueArray[] = $row['id'];
	}
?>
<html>
<head>
<style>
.question-title{
	font-weight: bold;
}
body{
	font-family: "Segoe UI","Trebuchet MS",Helvetica,Arial,sans-serif;
	font-size:14px;
}
.question{
	background-color: #f9f9f6;;
}
.questions{
	width:50%;
	margin:0 auto;
}
.button{
	display: inline-block;
	text-decoration: none;
	border: 1px solid #dedede;
	border-color: #dedede #d8d8d8 #d3d3d3;
	color: #555;
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	padding: 8px 11px;
	overflow: hidden;
	vertical-align: middle;
	line-height: 16px;
	font-family: "Open Sans","Segoe UI","FreeSans",Helvetica,Arial,sans-serif;
	font-size: 14px;
	font-weight: 400;
	background: -webkit-gradient(linear,left top,left bottom,from(#f9f9f9),to(#f0f0f0));
	cursor: pointer;
}
.footer{
  overflow-x: visible;
  background-color: rgba(255,255,255,0.95);
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  margin: 0;
  text-align: center;
  padding: 1em;
  border-top: 1px solid #eee;
  z-index: 100;
}
</style>
<script>
function changeLink(){
	document.getElementById("downloadLink").href="http://onmyfeet.net/survey2/pdf/file-create.php?id="+document.getElementById("evalueeSelect").value;
}
</script>
</head>
<body>
<div class = "header">
<a href="evaluator.php">Home</a>
<a href="logout.php">Logout</a><br><br>
</div>
Select Evaluee<br><br>
<div class="question-body">
		<select id = "evalueeSelect" name="evaluee" onchange="changeLink()">
			<?php 
			$i =0;
			foreach($resultArray as &$value){
				echo "<option value='".$valueArray[$i]."'>".$value."</option>";
				$i++;
				}
			?>
		</select><a id="downloadLink" href="#"><button type='button'>Download Evaluation</button></a>
</div>
</body>
</html>