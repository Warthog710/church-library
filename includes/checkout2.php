<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>

	<div class="topbar">
		<img src="../images/logoplaceholder.png" class="logo">
		<button type="submit" name="submit" class="navbutton" onclick="home()">Home</button>	
	</div>
</head>
<body>

	<link href="../css/chstylesheet.css" type="text/css" rel="stylesheet"/>

	<div class="text">
		<h3 align="center">It seems you are a new user. Please enter your email so we can keep track of the book.</h3>
		<h4 align="center">If you are not a new user please use the Go Back button and re-enter your name.</h4>
	</div>

	<div class = "container">
		<form action="checkout3.php" method="get">
				<input type="text" id="theEmail" name="email" placeholder="Enter E-Mail" class="inputfield1">
				<br>
				<button type="submit" name="submit" onclick="return validateEmail()" class="searchbutton">Submit</button>
		</form>
		<button class="goback" onclick="goback()">Go Back</button>
	</div>

	<?php

	include_once 'dbh.php';

	session_start();

	//$test = $_SESSION['bookcode'];
	//echo $test;

	$firstName = $_GET['firstname'];
	$lastName = $_GET['lastname'];

	$_SESSION['firstname'] = $firstName;
	$_SESSION['lastname'] = $lastName;

	$sql = "SELECT * FROM users WHERE firstname='$firstName';";

	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	if ($row['firstname'] != null || $row['firstname'] != "")
	{
		$_SESSION['userFlag'] = true;
	}
	else
	{
		$_SESSION['userFlag'] = false;
	}

	?>

	<script>
	
	function validateEmail() {
		var email;
		var filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			
		email = document.getElementById("theEmail").value;
			
		if (email=="") {
			alert("Please Enter An E-Mail Address");
			return false;
		}
		
		if (!filter.test(email)) {
			alert('Please provide a valid email address');
			email.focus;
			return false;
		}
	}
		
		var firstName = <?php echo json_encode($row['firstname']) ?>;

		if (firstName != null && firstName != "")
		{
			window.location='checkout3.php';
		}

		function home()
		{
			window.location='../index.php';
		}

		function goback()
		{
			window.location='checkout1.php';
		}
	</script>
	
	


</body>
</html>
