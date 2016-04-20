<html>
<head>
<title>Temporary</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
var typingTimer;
var doneTypingInterval = 300;
function init(){
	bind_key_up("name",nameChange);
}
function nameChange(){
	$.ajax({
		type:"POST",
		url:"/survey2/pdf/file-create.php",
		data:{
			name: document.getElementById("name").value
		},
		complete: function(response){
			console.log(response['responseText']);
		}
	});
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
</script>
</head>
<body onload="init();">
Enter Name of Evaluee (Format:Last,First): <input type="text" id="name" name="name">
<div id="toAppend">

</div>
</body>
</html>