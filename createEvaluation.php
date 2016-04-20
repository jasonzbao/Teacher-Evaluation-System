<html>
<head>
<title>New Form Evaluation</title>
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
	var typingTimer;
	var doneTypingInterval = 300;
	var alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split("");
	var numOfStandards = [];
/*
***** NOTE: In the future it may be better to generate html items instead of cloning because more dynamic and easier to change.
*/
function stdChange(addNumber){
	var addNumberV = addNumber.value; //Number of standards to be created
	for(var i=1; i<=addNumberV;i++){
		if(document.getElementById("standardDiv"+i)==null){
			var newStandards = document.getElementById("toBeCloned1").cloneNode(true);
			newStandards.style.display="block";
			newStandards.id="standardDiv"+i;
			for(var k=0; k<newStandards.childNodes.length;k++){ //update all the ids
    			if(newStandards.childNodes[k].id){
        			newStandards.childNodes[k].id+=i;
    			}
			}
			newStandards.childNodes[1].innerHTML = "Standard: " + i;
			document.getElementById("appendStandards").appendChild(newStandards);
			bind_key_up("numSubStandards"+i,subStdChange);
		}
	}
	numOfStandards = Array(addNumberV); 
	addNumberV++;
	while(document.getElementById("standardDiv"+addNumberV)!=null){ //remove standards that should not be there anymore because number of standards has changed.
		document.getElementById("standardDiv"+addNumberV).parentNode.removeChild(document.getElementById("standardDiv"+addNumberV));
		addNumberV++;
	}
}
function subStdChange(addNumber){
	var stdLetter = alphabet[parseInt(addNumber.id.charAt(addNumber.id.length-1))-1]; //get the standard letter from the alphabet
	for(var i=1; i<=addNumber.value;i++){
		if(document.getElementById("subStandardDiv"+stdLetter+i)==null){
			var newSubStandard = document.getElementById("toBeCloned2").cloneNode(true);
			newSubStandard.style.display="block";
			newSubStandard.id = "subStandardDiv" + stdLetter + i;
			newSubStandard.childNodes[1].id="subStandardNumber"+stdLetter+i;
			newSubStandard.childNodes[1].innerHTML = "Substandard Number: " +stdLetter+ i;
			newSubStandard.childNodes[3].id="subStandardId"+stdLetter+i;
			newSubStandard.childNodes[5].id="subStandardText"+stdLetter+i;
			newSubStandard.childNodes[7].childNodes[3].id="imgId"+stdLetter+i;
			newSubStandard.childNodes[7].childNodes[3].value=Math.random()*10000000000000000000; //randomly generate a number for the image id
			document.getElementById("standardDiv" + addNumber.id.charAt(addNumber.id.length-1)).appendChild(newSubStandard);
		}
	}
	numOfStandards[addNumber.id.charAt(addNumber.id.length-1)-1]=addNumber.value;
	checkNumber = addNumber.value+1;
	while(document.getElementById("subStandardDiv"+stdLetter+checkNumber)!=null){
		document.getElementById("subStandardDiv"+stdLetter+checkNumber).parentNode.removeChild(document.getElementById("subStandardDiv"+stdLetter+checkNumber));
		checkNumber++;
	}
}
function init(){
	bind_key_up("numStandards", stdChange);
}
function bind_key_up(id,functionName) {
    $('#'+id).keyup(function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(functionName(document.getElementById(id)), doneTypingInterval);
    });
    $('#'+id).keydown(function(){
        clearTimeout(typingTimer);
    });
}
function submitSurvey(){
	var jsonString = [];
	var counter =0;
	for(var i =1; i<=numOfStandards.length;i++){
		var arrayOfSubStandards = [];
		var standardObject = {};
		for(var j=1; j<=numOfStandards[i-1];j++){
			var objtoBeAppended ={};
			objtoBeAppended.substandardID = document.getElementById("subStandardId"+alphabet[i-1]+j).value; 
			objtoBeAppended.substandardtext = document.getElementById("subStandardText"+alphabet[i-1]+j).value;
			try{
				objtoBeAppended.imagefile = document.getElementById("imgId"+alphabet[i-1]+j).value + "."+document.getElementsByName("rubricImage")[counter].files[0].type.substr(6);
			}catch(err){
				objtoBeAppended.imagefile="";
			}
			arrayOfSubStandards.push(objtoBeAppended);
			counter++;
		}
		standardObject.substandards = arrayOfSubStandards;
		standardObject.SOE = document.getElementById("SOE"+i).checked;
		standardObject.comments = document.getElementById("comments"+i).checked;
		standardObject.standardName = document.getElementById("standardName"+i).value;
		jsonString.push(standardObject);
	}
	console.log(jsonString);
	var tobesent = JSON.stringify(jsonString);
	$.ajax({
		type:"POST",
		url:"submitSurvey.php",
		data:{
			surveystring: tobesent,
			title: document.getElementById("title").value
		},
		complete: function(response){
			alert(response['responseText']);
			//window.location.replace("http://www.onmyfeet.net/survey2/admin.php");
		}
	});
}
</script>
<style>
.subStandards{
	position: relative;
    left: 50px;
}
</style>
</head>
<body onload="init();">
<div id="pageTitle">
Title of Survey: <input type="text" id="title">
</div>
<div id="numStandardDiv" name="numStandardDiv">
	Number Of Standards: <input type="number" id = "numStandards" name="numStandards">
</div>
<div id="appendStandards">

</div>
<div id="toBeCloned1" style="display:none;" name="standards">
	<h2 id="standardNumber"> </h2>
	<h3 style="display:inline">Name of Standard:</h3><input type="text" id="standardName"><br><br>
	Number of Substandards: <input type="number" id="numSubStandards" name="numSubStandards">
	<input type="checkbox" id = "SOE" name="SOE" value="1"> Source Of Error Question
	<input type="checkbox" id = "comments" name="comments" value="1" checked> Comments Question
</div>
<div id="toBeCloned2" style="display:none;" class="subStandards">
	<h3 id="subStandardNumber"></h3>
	Substandard ID (This is the ID that will be used on the PDF file): <input type="text" id="subStandardId" name="subStandardId">
	Substandard Text: <textarea id="subStandardText" name="subStandardText"></textarea>

	<form action="uploadRubric.php" method="post" target="_blank" enctype="multipart/form-data">
	    Rubric Image: <input name="rubricImage" type="file" />
	    <input type="number" name = "rubricImageId" style="visibility:hidden; position:absolute;" id="rubricImageId">
	    <input type="submit" name="submitBtn" value="Upload" />
	</form>
</div>
<br>
<div id="finishing">
<button type="button" onclick="submitSurvey();">Submit</button>
</div>
</body>
</html>