<html>
<head>
<title>Administrator Page</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<style>
	body{
		margin-top: 50px;
	    margin-right: 150px;
	    margin-left: 150px;
	}
</style>
<script>
function addEvaluator(){
	if(document.getElementById("epassword").value != document.getElementById("confirmPassword").value){
		alert("Make sure your passwords are the same");
	}else{
		if(document.getElementById("efirst").value.length>0){
			if(document.getElementById("elast").value.length>0){
				if(document.getElementById("eusername").value.length>5){
					$.ajax({
						type: "POST",
						url: "addEvaluator.php",
						data:{
							first: document.getElementById("efirst").value,
							last: document.getElementById("elast").value,
							schoolDistrict: document.getElementById("eschoolDistrict").value,
							username: document.getElementById("eusername").value,
							password: document.getElementById("epassword").value
						},
						complete: function(response){
							alert("Success!");
							location.reload();
						}
					});
				}else{
					alert("Make sure Username is longer than 5 characters");
				}
			}else{
				alert("Make sure to enter a last name");
			}
		}else{
			alert("Make sure to enter a first name");
		}
	}
}

function changeInstrument(){
	if(document.getElementById("editInstrument").value!="-"){
		$.ajax({
			type: "POST",
			url: "changeInstrument.php",
			data:{
				districtid: document.getElementById("editInstrumentSD").value,
				instrumentid: document.getElementById("editInstrument").value
			},
			complete:function(response){
				console.log(response['responseText']);
				alert("Success!");
				location.reload();
			}
		});
	}
}
function addEvaluee(){
	if(document.getElementById("first").value.length>0){
		if(document.getElementById("last").value.length>0){
			$.ajax({
				type: "POST",
				url: "addEvaluees.php",
				data:{
					first: document.getElementById("first").value,
					last: document.getElementById("last").value,
					schoolDistrict: document.getElementById("schoolDistrict").value
				},
				complete: function(response){
					alert("Success!");
					location.reload();
				}
			});
		}else{
			alert("Make sure to enter a last name.");
		}
	}else{
		alert("Make sure to enter a first name.");
	}
}

function addSchoolDistrict(){
	if(document.getElementById("districtName").value.length>0){
		$.ajax({
			type: "POST",
			url:"addSchoolDistrict.php",
			data:{
				name: document.getElementById("districtName").value
			},
			complete: function(response){
				alert("Success!");
				location.reload();
			}
		});
	}else{
		alert("Make sure to enter a district name.");
	}
}

function addDistrictAdmin(){
	if(document.getElementById("schoolAdminPass").value!=document.getElementById("schoolAdminConfPass").value){
		alert("Make sure your passwords are the same");
	}else{
		if(document.getElementById("schoolAdminUser").value.length>5){
			$.ajax({
				type: "POST",
				url: "addDistrictAdmin.php",
				data:{
					schoolDistrict: document.getElementById("schoolAdminDist").value,
					username: document.getElementById("schoolAdminUser").value,
					password: document.getElementById("schoolAdminPass").value
				},
				complete: function(response){
					alert("Success!");
					location.reload();
				}
			});
		}else{
			alert("Make sure your username is longer than 5 characters");
		}
	}
}
</script>
</head>
<body>
<a href="logout.php">Logout</a>
<div id="addSchoolDistrict">
Add School District:<br>
Name: <input type="text" id="districtName">
<button onClick="addSchoolDistrict()"> Submit </button>
</div>
<br>
<br>
<div id="addSchoolAdmin">
Add School Administrator:<br>
Username: <input type="text" id="schoolAdminUser">
Password: <input type="password" id="schoolAdminPass">
Confirm Password: <input type="password" id="schoolAdminConfPass">
School District: 
<select id="schoolAdminDist">
	<?php 
	include("db_connect.php");
	$result = mysql_query("SELECT * FROM district");
	while($row=mysql_fetch_array($result)){
		$schoolDistrictString .= "<option value='".$row['id']."''>".$row['name']."</option>";
	}
	echo $schoolDistrictString; 
	?>
</select>
<button onclick="addDistrictAdmin()">Submit</button>
</div>
<br>
<br>
<div id="editSchoolInstrument">
Edit School District Instrument:<br>
<select id="editInstrumentSD"><?php echo $schoolDistrictString;?></select>
Choose Instrument:<br>
<select id="editInstrument">
<option value ="-">---</option>
<option value="1">Bloomfield</option>
<option value="2">Marshall </option>
<option value="3">Daniel11 </option>
</select>
<button onClick="changeInstrument()">Submit</button>
</div>
<br>
<br>

<div id="addEvaluee">
Add Evaluee:<br>
First Name: <input type="text" id = "first" name="evaluee">
Last Name: <input type="text" id="last" name="evaluee">
School District: <select id="schoolDistrict">
<?php
	echo $schoolDistrictString;
?>
</select>
<button onClick="addEvaluee()">Submit</button>
</div>
<br>
<br>

<div id="addEvaluators">
	Add Evaluators:
	<br>
	First Name: <input type="text" id="efirst" name="evaluator">
	Last Name: <input type="text" id="elast" name="evaluator">
	School District: <select id="eschoolDistrict">
	<?php
		echo $schoolDistrictString;
	?>
	</select>
	<span style="white-space: nowrap;">Username: <input type="text" id="eusername" name="evaluator"></span>
	<span style="white-space: nowrap;">Password: <input type="password" id="epassword" name="evaluator"></span>
	<span style="white-space: nowrap;">Confirm Password: <input type="password" id="confirmPassword" name="evaluator"></span>
	<span style="white-space: nowrap;"><button onClick="addEvaluator()">Submit</button></span>
</div>
<br>
<div id="viewSurveys">
Survey's currently in the system (Note that these surveys are not connected to a school district yet):
<br>
<?php
$result =mysql_query("SELECT * FROM surveys");
while($row=mysql_fetch_array($result)){
	echo "<a href='http://www.onmyfeet.net/survey2/loadSurvey.php?id=".$row['id']."'>".$row['title']."</a><br>";
}

?>
<br>
Click below this link to edit surveys:
<br>
<?php
$result =mysql_query("SELECT * FROM surveys");
while($row=mysql_fetch_array($result)){
	echo "<a href='http://www.onmyfeet.net/survey2/editEvaluations.php?id=".$row['id']."'>".$row['title']."</a><br>";
}

?>
<br>
<a href="http://www.onmyfeet.net/survey2/createEvaluation.php"> You can create new Surveys by clicking here </a>
<br>
New Surveys created will be automatically added to the above list.
</div>
</body>
</html>