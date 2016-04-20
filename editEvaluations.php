<?php
include("db_connect.php");
$idoftable = $_GET['id']; //to be dynamic later
$surveyData = mysql_fetch_array(mysql_query("SELECT * FROM surveys WHERE id='$idoftable'"));
function changeIdToName($id, $tbl_name){
	$temp = mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE id='$id'"));
	return strtoupper($temp['last']).",".strtoupper($temp['first']);
}
function changeNameToId($name, $tbl_name){
	$last = substr($name, 0, strpos($name, ","));
	$first = substr($name, strpos($name,",")+1);
	return mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE UPPER(first) = UPPER('$first') AND UPPER(last) = UPPER('$last')"))['id'];
}
/*$evaluatorid = changeNameToId($_POST['nEvaluator'],"evaluators");
$evalueeid = changeNameToId($_POST['nEvaluee'],"evaluees");
$observation = mysql_fetch_array(mysql_query("SELECT * FROM observation WHERE evaluatorid = '$evaluatorid' AND evalueeid = '$evalueeid'"))['surveyJSON'];
if($observation == ""){
	$observation=0;
}*/
?>
<html>
<head>
<title>Edit <?php echo $surveyData['title']; ?></title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style>
.question-title{
	font-weight: bold;
}
body{
	font-family: "Segoe UI","Trebuchet MS",Helvetica,Arial,sans-serif;
	font-size:14px;
}
h2{
	font-size: 20px;
}
img{
	max-width: 100%;
}
.question{
	background-color: #f9f9f6;
	margin:10px;
}
.questions{
	width:70%;
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
.first{
	width:70%;
}

</style>
<script>
var alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split("");
var everything = <?php echo $surveyData['surveystring'];?>;
function showRubric(thisOne){
	var allImages = document.getElementsByName(thisOne.name);
	for(i=0; i<allImages.length;i++){
		document.getElementById("img"+allImages[i].value).style.display="none";
	}
	document.getElementById("img"+thisOne.value).style.display="block";
}
function loadSurvey(){
	var counter =1;
	var SOEcounter=1;
	std = [];
	for(var i=1; i<=everything.length;i++){
		//For mean Scores:
		std[i]=new Array();

		var newViewRubricHeader = document.getElementById("tobeclonedRubricHeader").cloneNode(true);
		newViewRubricHeader.id="viewRubric"+i;
		newViewRubricHeader.childNodes[1].childNodes[1].innerHTML="<input type='text' id='standardName"+i+"' value='"+everything[i-1].standardName+"'>";
		newViewRubricHeader.childNodes[3].id="appendRubricChoices"+i;
		newViewRubricHeader.childNodes[5].id="appendClonedImages"+i;
		document.getElementById("mainAppend").appendChild(newViewRubricHeader);
		var newTable = document.getElementById("tobeclonedsurvey").cloneNode(true);
		newTable.id="standardTableDiv"+i;
		newTable.childNodes[1].id="standardTable"+i;
		newTable.childNodes[1].childNodes[3].id="appendsubstandard"+i;
		document.getElementById("mainAppend").appendChild(newTable);
		for(var j=0;j<everything[i-1].substandards.length;j++){
			std[i][(j+1)]=false;
			var newShowRubric = document.getElementById("tobeclonedshowrubricid").cloneNode(true);
			newShowRubric.id="clonedshowrubric"+i+alphabet[j];
			newShowRubric.childNodes[1].name="SR"+i;
			newShowRubric.childNodes[1].value=i+alphabet[j];
			newShowRubric.childNodes[2].textContent = " " + i+alphabet[j] + " Rubric";
			document.getElementById("appendRubricChoices"+i).appendChild(newShowRubric);
			var newRubricImage = document.getElementById("tobeclonedImages").cloneNode(true);
			newRubricImage.id="clonedImages"+i+alphabet[j];
			newRubricImage.childNodes[1].id="img"+i+alphabet[j];
			newRubricImage.childNodes[1].src="./rubrics/"+everything[i-1].substandards[j].imagefile;
			document.getElementById("appendClonedImages"+i).appendChild(newRubricImage);
			var row = document.getElementById("standardTable"+i).insertRow();
			var cell1 = row.insertCell();
			var cell2 = row.insertCell();
			var cell3 = row.insertCell();
			var cell4 = row.insertCell();
			var cell5 = row.insertCell();
			var cell6 = row.insertCell();
			console.log(everything);
			console.log(everything[i-1].substandards[j].substandardID);
			cell1.innerHTML = '<input type="text" id="'+"qtobeadded"+counter+'" value="'+everything[i-1].substandards[j].substandardtext+'"style="width:100%">';;
			cell2.innerHTML = '<input type="text" id="substandardID'+counter+'"value="'+everything[i-1].substandards[j].substandardID+'"style="display:block; margin:auto;">';
			cell3.innerHTML = '<input type="radio" name="'+"q"+counter+ '" value="'+""+i+""+(j+1)+""+4+ '"style="display:block; margin:auto;" onclick="changeScore(this);">';
			cell4.innerHTML = '<input type="radio" name="'+"q"+counter+ '" value="'+""+i+""+(j+1)+""+3+ '"style="display:block; margin:auto;" onclick="changeScore(this);">';
			cell5.innerHTML = '<input type="radio" name="'+"q"+counter+ '" value="'+""+i+""+(j+1)+""+2+ '"style="display:block; margin:auto;" onclick="changeScore(this);">';
			cell6.innerHTML = '<input type="radio" name="'+"q"+counter+ '" value="'+""+i+""+(j+1)+""+1+ '"style="display:block; margin:auto;" onclick="changeScore(this);">';
			counter++;
		}
		var newScores= document.getElementById("tobeclonedscores").cloneNode(true);
		newScores.id="standardScore"+i;
		newScores.childNodes[1].innerHTML = "Std. "+i+" Total Score:";
		newScores.childNodes[2].id="ts"+i;
		newScores.childNodes[4].innerHTML="Std. "+i+" Mean Score:";
		newScores.childNodes[5].id="ms"+i;
		newScores.childNodes[6].id="tn"+i;
		document.getElementById("mainAppend").appendChild(newScores);
		if(everything[i-1].SOE){
			var newSOE = document.getElementById("tobeclonedSOE").cloneNode(true);
			newSOE.id="clonedSOE"+i;
			newSOE.childNodes[1].childNodes[1].innerHTML = "Standard "+i+": Possible sources of evidence for this domain (in addition to direct observation)."
			newSOE.childNodes[3].childNodes[1].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[3].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[5].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[7].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[9].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[11].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[13].childNodes[0].name="qc"+SOEcounter;
			newSOE.childNodes[3].childNodes[15].childNodes[0].name="qc"+SOEcounter;
			document.getElementById("mainAppend").appendChild(newSOE);
		}
		if(everything[i-1].comments){
			var newComment = document.getElementById("tobeclonedComments").cloneNode(true);
			newComment.id="clonedComment"+i;
			newComment.childNodes[1].innerHTML = "Standard "+i+" Comments:";
			newComment.childNodes[3].id="qi"+i;
			document.getElementById("mainAppend").appendChild(newComment);
		}
	}
}
function init(){
	loadSurvey();
}
function changeScore(value){
	var standardNumber = parseInt(value.value.charAt(0));
	var questionNumber = parseInt(value.value.charAt(1));
	var valueNumber = parseInt(value.value.charAt(2));
	if(std[standardNumber][questionNumber]==false){
		document.getElementById("ts"+standardNumber).innerHTML = parseInt(document.getElementById("ts"+standardNumber).innerHTML)+ valueNumber;
		document.getElementById("tn"+standardNumber).innerHTML = parseInt(document.getElementById("tn"+standardNumber).innerHTML) + 1;
		document.getElementById("ms"+standardNumber).innerHTML = Math.round(parseInt(document.getElementById("ts"+standardNumber).innerHTML)*100 / parseInt(document.getElementById("tn"+standardNumber).innerHTML))/100;
		std[standardNumber][questionNumber] = valueNumber;
	}else{
		document.getElementById("ts"+standardNumber).innerHTML = parseInt(document.getElementById("ts"+standardNumber).innerHTML)-parseInt(std[standardNumber][questionNumber])+valueNumber;
		document.getElementById("ms"+standardNumber).innerHTML = Math.round(parseInt(document.getElementById("ts"+standardNumber).innerHTML)*100 / parseInt(document.getElementById("tn"+standardNumber).innerHTML))/100;
		std[standardNumber][questionNumber] = valueNumber;
	}
}
function saveSurvey(){
	var counter=1;
	for(var i=0; i<everything.length;i++){
		everything[i].standardName=document.getElementById("standardName"+(i+1)).value;
		for(var j=0; j<everything[i].substandards.length;j++){
			try {
			    everything[i].substandards[j].substandardtext=document.getElementById("qtobeadded"+counter).value;
			    everything[i].substandards[j].substandardID = document.getElementById("substandardID"+counter).value;
			}
			catch(err) {
			}
			counter++;
		}
	}
	var tobesent = JSON.stringify(everything);
	$.ajax({
		type:"POST",
		url:"submitSurvey.php",
		data:{
			surveystring: tobesent,
			id: <?php echo $idoftable?>,
		},
		complete: function(response){
			alert(response['responseText']);
			window.location.replace("http://www.onmyfeet.net/survey2/admin.php");
		}
	});
}
</script>
</head>
<body onload="init();">
<div class="questions" id="mainAppend">
	
</div>
<div class="questions" style="display:none">
	
	<div id="tobeclonedRubricHeader" class="question">
		<div class="question-header">
			<h2 id="viewRubricNumber" class="question-title">View Standard i Rubrics</h2>
		</div>
		<div id="appendRubricChoicesID" class="question-body">

		</div>
		<div id="appendClonedImages" class="question">

		</div>
	</div>
	<!--Show Rubric Item to be appended-->
	<span id="tobeclonedshowrubricid"> <input  type="radio" name="SR1" value="1A" onclick="showRubric(this);"> i Rubric &nbsp;</span>
	<!-- -->
	<!--Cloned Images to be appended-->
	<div id="tobeclonedImages" class="question">
		<img id="imgid" style="display:none" />
	</div>
	<!-- -->
	<div id="tobeclonedsurvey" class="question">
		<table class="table table-bordered">
		    <thead>
		      	<tr>
		        	<th class="first"></th>
		        	<th> Survey ID </th>
		        	<th>4</th>
		        	<th>3</th>
		        	<th>2</th>
		        	<th>1</th>
		      	</tr>
		    </thead>
		    <tbody id="appendsubstandardID">
		    </tbody>
	  	</table>
	</div>

	<div id="tobeclonedscores" class="question" style="width:50%; display:inline;">
		<h4 class="question-title" style="display:inline;">Std. i Total Score:</h4><h4 class="question-title" style="display:inline;" id="tsid">0</h4>
		<h4 class="question-title" style="display:inline;">Std. i Mean Score:</h4><h4 class="question-title" style="display:inline;" id="msid">0.00</h4><p id="tnid" style="display:none" >0</p>
	</div>

	<div id="tobeclonedSOE" class="question">
		<div class="question-header">
			<h2 class="question-title">Standard i: Possible sources of evidence for this domain (in addition to direct observation).</h2>
		</div>
		<div class="question-body">
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="0"> Assessments &nbsp;</span>
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="1"> Student Work &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="2"> Documentation &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="3"> Relevant Data &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="4"> Student Records &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="5"> Professional Development Materials and Reflections &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="6"> Journals &nbsp;</span>	
			<span style="white-space: nowrap;"><input type="checkbox" name="qcid" value="7"> Other, please specify... &nbsp;	
			<input type="text" name="qcid"></span>
		</div>
	</div>
	<div id="tobeclonedComments" class="question-header">
		<h2 class="question-title" id="stdidcomments">Standard i: Comments:</h2>
		<textarea cols="50" id="qiid" rows="2"></textarea>
		<br>
	</div>
</div>

<br><br><br><br><br>
<div id="footer" class="footer">
	<div id="button-group" style="width:50%;margin:0 auto;">
		<input type="submit" class="button" name="save-changes" onclick="saveSurvey();" value="Save Survey">
	</div>
</div>
</body>
</html>
