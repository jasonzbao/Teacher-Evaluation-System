<?php
$districtid= $_COOKIE['adistrictid'];
include("db_connect.php");
$districtname = mysql_fetch_array(mysql_query("SELECT name FROM district WHERE id='$districtid'"))['name'];
?>
<html>
<head>
<title>School Administrator Page</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<style>
	body{
		margin-top: 50px;
	    margin-right: 150px;
	    margin-left: 150px;
	}
	#screenCover {
		width: 100%;
		left: 0;
		top: 0;
		position: fixed;
		height: 100%;
		background-color: black;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
		filter: alpha(opacity=50);
		-moz-opacity: 0.5;
		opacity: 0.5;
		z-index:9;
		display:none;
	}
	.popup{position: absolute;width: 500px;height: auto;left: 50%;top: 20%;margin-left: -250px;background-color: white;border:solid 1px #c0c0c0;padding: 10px;border-radius: 10px 10px 0 0;z-index:10;}
	.add {display:inline; color: #7f8c8d; text-decoration:none;}
	.add:hover { font-weight:700;}
	#add:hover { text-decoration:underline; color: #8e44ad;}
</style>
<script>
var districtid = <?php echo $districtid; ?>;
var openwindowid;
function init(){
	$("#newEvaluators").draggable();
}
function mapToggle(){
	$('#'+openwindowid).fadeToggle();
	$('#screenCover').fadeToggle();
}
function changeWindow(id){
	openwindowid = id;
}
function addEvaluator(){
	if(document.getElementById("epassword").value != document.getElementById("confirmPassword").value){
		alert("Make sure your passwords are the same");
	}else{
		if(document.getElementById("efirst").value.length>0){
			if(document.getElementById("elast").value.length>0){
				if(document.getElementById("eusername").value.length>6){
					$.ajax({
						type: "POST",
						url: "addEvaluator.php",
						data:{
							first: document.getElementById("efirst").value,
							last: document.getElementById("elast").value,
							schoolDistrict: districtid,
							username: document.getElementById("eusername").value,
							password: document.getElementById("epassword").value
						},
						complete: function(response){
							alert("Success!");
							location.reload();
						}
					});
				}else{
					alert("Make sure Username is longer than 6 characters");
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
				districtid: districtid,
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
	if(document.getElementById("evalfirst").value.length>0){
		if(document.getElementById("evallast").value.length>0){
			$.ajax({
				type: "POST",
				url: "addEvaluees.php",
				data:{
					first: document.getElementById("first").value,
					last: document.getElementById("last").value,
					schoolDistrict: districtid
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

function updateEvaluee(){
	if(document.getElementById("uevalfirst").value.length>0){
		if(document.getElementById("uevallast").value.length>0){
			$.ajax({
				type: "POST",
				url: "updateEvaluee.php",
				data:{
					first: document.getElementById("uevalfirst").value,
					last: document.getElementById("uevallast").value,
					updateId: document.getElementById("evaluees").value
				},
				complete: function(response){
					alert("Success!");
					location.reload();
				}
			});
		}else{
			alert("Make sure the last name field is filled");
		}
	}else{
		alert("Make sure the first name field is filled");
	}
}

function deleteEvaluee(){
	$.ajax({
				type: "POST",
				url: "deleteEvaluee.php",
				data:{
					updateId: document.getElementById("evaluees").value
				},
				complete: function(response){
					console.log(response['responseText']);
					alert("Success!");
					location.reload();
				}
			});
}
</script>
</head>
<body onload="init();">
<div id="screenCover" onclick="mapToggle()" style="display: none;"></div>
<a href="logout.php">Logout</a>
<br>
Your School District is: <?php echo $districtname;?><br>
(Note: You can only edit items for your own school district)
<br><br>
<div id="editSchoolInstrument">
Edit School District Instrument:<br><br>
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
Evaluees: <a id = "addEvaluees" class="add" href="javascript:$('#newEvaluees').fadeToggle();$('#screenCover').fadeToggle();" onclick="changeWindow('newEvaluees')">Create New Evaluees</a>
<div id="newEvaluees" name="newEvaluees" style="display:none" class="ui-draggable popup">
	First Name: <input type="text" id = "evalfirst" name="evaluee">
	Last Name: <input type="text" id="evallast" name="evaluee">
	<button onClick="addEvaluee()">Submit</button>
</div>
<br>
<select id="evaluees">
	<?php 
	include("db_connect.php");
	$result = mysql_query("SELECT * FROM evaluees WHERE districtid='$districtid'");
	while($row=mysql_fetch_array($result)){
		$evalueeString .= "<option value='".$row['id']."''>".$row['first']." ".$row['last']."</option>";
	}
	echo $evalueeString; 
	?>
</select>
<a href="javascript:$('#updateEvaluee').fadeToggle();$('#screenCover').fadeToggle();"><button style="color:black;" onclick="changeWindow('updateEvaluee')">Update</button></a><button onclick="deleteEvaluee()">Delete</button>
<div id="updateEvaluee" name="updateEvaluee" style="display:none" class="ui-draggable popup">
	First Name: <input type="text" id="uevalfirst">
	Last Name: <input type="text" id="uevallast">
	<button onClick = "updateEvaluee();">Update</button>
</div>
</div>
<br>
<br>
<div id="addEvaluators">
	Evaluators: <a id = "addEvaluators" class="add" href="javascript:$('#newEvaluators').fadeToggle();$('#screenCover').fadeToggle();" onclick="changeWindow('newEvaluators')">Create New Evaluators</a>
<div id="newEvaluators" name="newEvaluators" style="display:none" class="ui-draggable popup">
	First Name: <input type="text" id="evalufirst" name="evaluator">
	Last Name: <input type="text" id="evalulast" name="evaluator">
	<span style="white-space: nowrap;">Username: <input type="text" id="eusername" name="evaluator"></span>
	<span style="white-space: nowrap;">Password: <input type="password" id="epassword" name="evaluator"></span>
	<span style="white-space: nowrap;">Confirm Password: <input type="password" id="confirmPassword" name="evaluator"></span>
	<span style="white-space: nowrap;"><button onClick="addEvaluator()">Submit</button></span>
</div>
<br>
<select id="evaluators">
	<?php 
	$result = mysql_query("SELECT * FROM evaluators WHERE districtid='$districtid'");
	while($row=mysql_fetch_array($result)){
		$evaluatorString .= "<option value='".$row['id']."''>".$row['first']." ".$row['last']."</option>";
	}
	echo $evaluatorString; 
	?>
</select>
<a href="javascript:$('#updateEvaluee').fadeToggle();$('#screenCover').fadeToggle();"><button style="color:black;" onclick="changeWindow('updateEvaluee')">Update</button></a><button onclick="deleteEvaluee()">Delete</button><a href="home.php"><button style="color:black;">Login as Evaluator</button></a>
</div>
</body>
</html>