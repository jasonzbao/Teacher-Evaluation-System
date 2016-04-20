<html>
<head>
<title>Home Page</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style>
#login{
	position: absolute;
	width: 500px;
	height: auto;
	left: 50%;
	top: 20%;
	margin-left: -250px;
	background-color: white;
	border: solid 1px #c0c0c0;
	padding: 10px;
	border-radius: 10px 10px 0 0;
	z-index: 10;
}
</style>
</head>
<body>
<div id="login">
	Login for Staff:<br><br>
	<form id="sLogin" name="sLogin" method="post" action="login.php">
		Username: <input style="position:absolute; right:50%;" name="susername" id="susername" type="text"/><br><br>
	    Password: <input style="position:absolute; right:50%;" name="spassword" id = "spassword" type ="password">
	    <input style="position:absolute; right:30%;" type="submit" name="sSubmit" id="sSubmit" value="Submit">
	</form>
	Login for Evaluators:<br><br>
	<form id="eLogin" name="eLogin" method="post" action="login.php">
	    Username: <input style="position:absolute; right:50%;" name="eusername" id="eusername" type="text"/><br><br>
	    Password: <input style="position:absolute; right:50%;" name="epassword" id = "epassword" type ="password">
	    <input style="position:absolute; right:30%;" type="submit" name="eSubmit" id="eSubmit" value="Submit">
	</form>
	Login for School Administrators:<br><br>
	<form id="aLogin" name="aLogin" method="post" action="login.php">
	    Username: <input style="position:absolute; right:50%;" name="ausername" id="ausername" type="text"/><br><br>
	    Password: <input style="position:absolute; right:50%;"name="apassword" id = "apassword" type ="password">
	    <input style="position:absolute; right:30%;"type="submit" name="aSubmit" id="aSubmit" value="Submit">
	</form>
</div>
</body>
</html>