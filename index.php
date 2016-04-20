<?php
	include("checkCredentials.php");
	$newSurvey = "true";
	if(isset($_GET['observationid'])){
		$newSurvey="false";	
		$observationid = $_GET['observationid'];
		$sql = mysql_query("SELECT * FROM observation WHERE id='$observationid'");
		$result = mysql_fetch_array($sql);
		if($result==""){
			$result=0;
		}else{
			$result["evalueeid"] = changeIdToName($result["evalueeid"],"evaluees");
		}
	}else{
		$result=0;
		$observationid=-1;
	}
	function changeIdToName($id, $tbl_name){
		$temp = mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE id='$id'"));
		return strtoupper($temp['last']).",".strtoupper($temp['first']);
	}
	function changeIdToNameD($id, $tbl_name){
		$temp = mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE id='$id'"));
		return $temp['name'];
	}
?>
<html>
<head>
<title>Staff Observation Page 1</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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
var newSurvey=true;
var evalueeArray = new Array();
var evaluatorArray = new Array();
var district =
<?php
	echo $districtid;
?>;
var loadData;
function init(){
	$('#q8').datepicker({ 
     dateFormat: 'dd-mm-yy'
     }).datepicker("setDate", new Date());
	$.ajax({
        type: "POST",
        url:"getData.php",
        data:{
            data: "evaluee",
            district: district
        },
        complete: function(response){
            evalueeArray = JSON.parse(response['responseText']);
        }
    });
    $.ajax({
        type: "POST",
        url:"getData.php",
        data:{
            data: "evaluator",
            district: district
        },
        complete: function(response){
            evaluatorArray = JSON.parse(response['responseText']);
            console.log(evaluatorArray);
            changeEvaluator();
        }
    });
    /* Gets the first and last names of the evaluators and evaluees */
    loadData = <?php echo json_encode($result); ?>;
    if(loadData==0){
    }else{
    	document.getElementsByName("q1")[loadData.q1].checked = true;
        document.getElementById("q4").value = loadData.evalueeid;
        document.getElementsByName("q5")[loadData.q5].checked = true;
        document.getElementsByName("q6")[loadData.q6].checked = true;
        document.getElementsByName("q7")[loadData.q7].checked = true;
        document.getElementById("q8").value = loadData.q8;
        document.getElementById("time").value = loadData.startTime;
        document.getElementById("nObservationId").value=loadData.id;
    }
}
function q2(question){
	var change = document.getElementById("lastName");
	var selectEvaluees = document.getElementById("evalueeSelect");
	var rLength = selectEvaluees.options.length;
	for(i=1; i<rLength;i++){
		selectEvaluees.remove(1);
	}
	document.getElementById("qWho").style.display="block";
	if(question.value==0){
		change.innerHTML = "Last Name A thru J";
		var filtered = evalueeArray.filter(function(el){return el[0]>='A' && el[0]<='J'});
		for(var i = 0; i < filtered.length; i++) {
    		var opt = document.createElement('option');
    		opt.innerHTML = filtered[i];
    		opt.value = filtered[i];
    		selectEvaluees.appendChild(opt);
		}
	}else if(question.value==1){
		change.innerHTML = "Last Name K thru P";
		var filtered = evalueeArray.filter(function(el){return el[0]>='K' && el[0]<='P'});
		for(var i = 0; i < filtered.length; i++) {
    		var opt = document.createElement('option');
    		opt.innerHTML = filtered[i];
    		opt.value = filtered[i];
    		selectEvaluees.appendChild(opt);
		}
	}else if(question.value==2){
		change.innerHTML = "Last Name Q thru Z";
		var filtered = evalueeArray.filter(function(el){return el[0]>='Q' && el[0]<='Z'});
		for(var i = 0; i < filtered.length; i++) {
    		var opt = document.createElement('option');
    		opt.innerHTML = filtered[i];
    		opt.value = filtered[i];
    		selectEvaluees.appendChild(opt);
		}
	}
}
function changeEvaluator(){
	var selectEvaluator = document.getElementById("evaluatorSelect");
	for(var i = 0; i < evaluatorArray.length; i++) {
    	var opt = document.createElement('option');
    	opt.innerHTML = evaluatorArray[i][0];
    	opt.value = evaluatorArray[i][1];
    	selectEvaluator.appendChild(opt);
	}
	document.getElementById("evaluatorSelect").value = loadData.evaluatorSelect;
}
function changeValidate(changed){
	document.getElementById("q4").value = changed.value;
}
function submitSurvey(alertyesorno){
	var q1value;
	var q5value;
	var q6value;
	var q7value;
	for(var i =0; i<document.getElementsByName("q1").length;i++){
		if(document.getElementsByName("q1")[i].checked){
			q1value = document.getElementsByName("q1")[i].value;
		}
	}
	for(var i =0; i<document.getElementsByName("q5").length;i++){
		if(document.getElementsByName("q5")[i].checked){
			q5value = document.getElementsByName("q5")[i].value;
		}
	}
	for(var i =0; i<document.getElementsByName("q6").length;i++){
		if(document.getElementsByName("q6")[i].checked){
			q6value = document.getElementsByName("q6")[i].value;
		}
	}
	for(var i =0; i<document.getElementsByName("q7").length;i++){
		if(document.getElementsByName("q7")[i].checked){
			q7value = document.getElementsByName("q7")[i].value;
		}
	}
	var evaluator = <?php echo $evaluatorid;?>;
	var newornot=true;
	if(!<?php echo $newSurvey;?>){
		newornot=false;
	}else{
		if(!newSurvey){
			newornot = false;
		}
	}
	$.ajax({
        type: "POST",
        url:"saveSurvey.php",
        data:{
        	newsurvey: newornot,
        	observationid:document.getElementById("nObservationId").value,
            q1: q1value,
            evaluee: document.getElementById("q4").value,
            q5: q5value,
            q6: q6value,
            q7: q7value,
            q8: document.getElementById("q8").value,
            startTime: document.getElementById("time").value,
            evaluatorSelect: document.getElementById("evaluatorSelect").value,
            q9: document.getElementById("q9").value,
            evaluator: evaluator
        },
        complete: function(response){
        	console.log(response['responseText']);
        	document.getElementById("nObservationId").value=response['responseText'];
        	if(alertyesorno){
        		alert("Done");
        		//window.location(°http://www.onmyfeet.net/survey2/pdf/file-create.php?name="+document.getElementById("nObservationId").value);
        	}else{
        		document.getElementById("submitObservation").submit();
        	}
        	newSurvey=false;
        }
    });
}
</script>
</head>
<body onload="init();">
<div class = "header">
<a href="evaluator.php">Home</a>
<a href="logout.php">Logout</a>
</div>
<div class="questions">
	<div class="question" >
		<div class="question-header">
			<h1 class="question-title" id="districtName"><?php echo changeIdToNameD($districtid,"district");?></h1>
		</div>
		<div class="question-header">
			<h2 class="question-title">I have read the applicable District certificated staff evaluation protocol, and agree to proceed with the evaluation ?</h2>
		</div>
		<div class="question-body">
			<input type="radio" name="q1" value="0">Yes (Proceed with Evaluation)
			<input type="radio" name="q1" value="1">No (Terminate the Evaluation)
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">Q1: WHO IS the EVALUEE</h2>
		</div>
		<div class="extra-content">
			<p> If name not listed in dropdown category, please choose NAME NOT LISTED, and then IN Q.7 below enter LAST, FIRST NAME. </p>
		</div>
		<div class="question-body">
			<input type="radio" name="q2" value="0" onclick="q2(this);">Last Name A thru J
			<input type="radio" name="q2" value="1" onclick="q2(this);">Last Name K thru P
			<input type="radio" name="q2" value="2" onclick="q2(this);">Last Name Q thru Z
		</div>
	</div>
	<div id = "qWho" class="question" style="display:none">
		<div class="question-header">
			<h2 id="lastName" class="question-title"></h2>
		</div>
		<div class="question-body">
			<select id = "evalueeSelect" name="evaluee" onchange = "changeValidate(this);">
				<option value="-1"> -- </option>
			</select>
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">Validate WHO IS EVALUEE??</h2>
		</div>
		<div class="question-body">
			<input type="text" id="q4" disabled>
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">
				Q1A. Is the EVALUEE tenured?
			</h2>
		</div>
		<div class="question-body">
			<input type="radio" name="q5" value="0">Yes 
			<input type="radio" name="q5" value="1">No 
		</div>
	</div>
	<div class="question" style="display: inline-block; width: 50%; float: left;">
		<div class="question-header">
			<h2 class="question-title">
				Q2. Evaluee Classification
			</h2>
		</div>
		<div class="question-body">
			<input type="radio" name="q6" value="0" >Teacher <br>
			<input type="radio" name="q6" value="1" >ABA Teacher <br>
			<input type="radio" name="q6" value="2" >Child Study Team<br>
			<input type="radio" name="q6" value="3" >Guidance Services<br>
			<input type="radio" name="q6" value="4" >Media Services<br>
			<input type="radio" name="q6" value="5" >School Nurse<br>
		</div>
	</div>
	<div class="question" style="display: inline-block; width: 50%;">
		<div class="question-header">
			<h2 class="question-title">
				Q3. Type of Evaluation
			</h2>
		</div>
		<div class="question-body">
			<input type="radio" name="q7" value="0" >Long Observation<br>
			<input type="radio" name="q7" value="1" >Short Observation (Teacher Only)<br>
			<input type="radio" name="q7" value="2" >Student Growth Objective (SGO)<br>
			<input type="radio" name="q7" value="3" >Student Growth Percentile (SGP)<br>
			<input type="radio" name="q7" value="4" >Professional Observation<br>
		</div>
	</div>
	<div class="question" style="clear:both;">
		<div class="question-header">
			<h2 class="question-title">
				Q4. Date of Observation
			</h2>
		</div>
		<div class="question-body">
			<input type="date" id="q8" name="q8">
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">
				Q5. Start Time of Observation
			</h2>
		</div>
		<div class="question-body">
			<select id="time" name="time"><option value="-1">---</option><option value="0">7:30 am</option><option value="1">8:00 am</option><option value="2">8:30 am</option><option value="3">9:00 am</option><option value="4">9:30 am</option><option value="5">10:00 am</option><option value="6">10:30 am</option><option value="7">11:00 am</option><option value="8">11:30 am</option><option value="9">12 Noon</option><option value="10">12:30 pm</option><option value="11">1:00 pm</option><option value="12">1:30 pm</option><option value="13">2:00 pm</option><option value="14">2:30 pm</option><option value="15">3:00 pm</option><option value="16">3:30 pm</option><option value="17">4:00 pm</option></select>
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">
				Q6. WHO IS the EVALUATOR
			</h2>
		</div>
		<div class="question-body">
			<select id = "evaluatorSelect" name="evaluator" >
				<option value="-1"> -- </option>
			</select>
		</div>
	</div>
	<div class="question">
		<div class="question-header">
			<h2 class="question-title">
				Q7. Please type Last Name, First Name if not listed on dropdown menu Q1.
			</h2>
		</div>
		<div class="question-body">
			<input type="text" id="q9">
		</div>
	</div>
</div>
<br><br><br><br><br>
<div id="footer" class="footer">
	<div id="button-group" style="width:50%;margin:0 auto;">
		<input type="submit" class="button" onclick="submitSurvey(true);" name="save-changes" value="Save &amp; Continue Editing"></a>
		<input id="next-submit-button" type="submit" class="button" onclick="submitSurvey(false);" value="Next">
		<form action = "staffEvaluation.php" id="submitObservation" method="POST" style="display:inline;">
			<input id="nObservationId" name = "nObservationId" style="display:none" readonly>
		</form>
	</div>
</div>
<script>
  $(function() {
    $( "#q8" ).datepicker();
  });
  </script>
</body>
</html>