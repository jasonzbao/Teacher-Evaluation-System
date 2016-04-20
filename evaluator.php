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
?>
<html>
<head>
<title>Evaluator Page</title>
<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style>
.everything{
	width:50%;
	margin:0 auto;
	margin-top: 30px;
}
</style>
<script>
function finishSurvey(){
	$.ajax({
	    type: "POST",
	    url:"finishSurvey.php",
	    data:{
	        observationid: document.getElementById("inProgressObservationSelect").value
	    },
	    complete: function(response){
	    	window.location.replace("evaluator.php");
	    	alert("Your survey is done!");
	    }
    });	
}
function editEvaluation(bool){
	if(bool=="0"){
		window.location.replace("index.php?observationid="+document.getElementById("inProgressObservationSelect").value);
	}else{
		window.location.replace("index.php?observationid="+document.getElementById("submittedStaffEvaluationSeclect").value);
	}
}
</script>
</head>
<body>
<div class="everything">
<a href="logout.php">Logout</a>
<h2>
<?php 
	$result1 = mysql_query("SELECT * FROM evaluators WHERE username='$user'");
	$evaluator = mysql_fetch_array($result1);
	$districtid = $evaluator['districtid'];
	$result3 = mysql_query("SELECT * FROM district WHERE id='$districtid'");
	echo mysql_fetch_array($result3)['name'];
?>
</h2>
<h2 style="font-style:italic;">Welcome 
<?php 	
	echo ucfirst($evaluator['first'])." ".ucfirst($evaluator['last']);
?>
</h2>
<a href="index.php"><button type="button">Create New Staff Evaluation</button></a>&nbsp &nbsp <a href="review.php"><button type="button"> Review Previous </button></a>
<h3>Completed Staff Observations:</h3><button type='button' onclick="editEvaluation(0);">Edit Evaluation</button><button onclick='finishSurvey();' type='button'>Submit Evaluation</button>
<br><br><select id="inProgressObservationSelect" class="question">
<?php
	$evaluatorid = $evaluator['id'];
	$result = mysql_query("SELECT * FROM observation WHERE evaluatorSelect='$evaluatorid' AND completed='0'");
	while($row2 = mysql_fetch_array($result)){
		$evalueeid = $row2['evalueeid'];
		$result2 = mysql_query("SELECT * FROM evaluees WHERE id = '$evalueeid'");
		$row = mysql_fetch_array($result2);
		echo "<option value=".$row2['id'].">".$row['first']." ".$row['last'].$row2['q8']."</option>";
		//."&nbsp<a href='index.php?observationid=".$row2['id']."'><button type='button'>Edit Evaluation</button></a> "."&nbsp<a href='#' onclick='finishSurvey(".$row2['id'].");return false;'><button type='button'>Submit Evaluation</button></a> "
	}
?>
</select>
<h3>Submitted Staff Evaluations:</h3><button type='button' onclick="downloadEvluation();">Download Evaluation</button><button type='button' onclick="editEvaluation(1);">Edit Evaluation</button>
<br><br><select id="submittedStaffEvaluationSeclect" class="question">
<?php
	$evaluatorid = $evaluator['id'];
	$result = mysql_query("SELECT * FROM observation WHERE evaluatorSelect='$evaluatorid' AND completed='1'");
	while($row2 = mysql_fetch_array($result)){
		$evalueeid = $row2['evalueeid'];
		$result2 = mysql_query("SELECT * FROM evaluees WHERE id = '$evalueeid'")or die(mysql_error);
		$row = mysql_fetch_array($result2);
		echo "<option value=".$row2['id'].">".$row['first']." ".$row['last']." ".$row2['q8']."</option>";
	}
?>
</select>
</div>
</body>
</html>