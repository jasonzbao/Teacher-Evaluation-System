<html>
<head>
<title>Test Uploads</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
$("document").ready(function(){ 
    $("#myForm").submit(function(e) {
		 $.ajax({
		 	url: 'uploadFile.php',
		 	type: 'POST',
		 	data: new FormData( this ),
		 	processData: false,
      		contentType: false,
		 	complete: function(response){
		 		console.log(response);
		 	}
		 });
		 return false;
    });
});
</script>
</head>
<body>
	<form id="myForm" >
	    Rubric Image: <input name="imageFile" id = "imageFile" type="file" />
	    <input type="submit" name="submitBtn" value="Upload" />
	</form>
</body>
</html>