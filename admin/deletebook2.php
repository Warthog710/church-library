<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<h3>Please confirm that you wish to delete</h3>
	<h3 id="title">TITLE</h3>

	<button onclick="confirm()">Confirm</button>
	<button onclick="goback()">Go Back</button>

	<?php

	include_once 'dbh.php';

	session_start();

	//Checks to see if the login process was successfully completed.
	if(isset($_SESSION['goodLogin']))
	{
	if($_SESSION['goodLogin'] == true)
		{
			$goodLogin = true;
		}
		else
		{
			$goodLogin = false;
		}
	}
	else
	{
		$goodLogin = false;
	}

	$title = $_GET['title'];

	$_SESSION['deleteTitle'] = $title;
	
	$sql = "SELECT * FROM resource WHERE title='$title';";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	//echo $row['title'];

	?>

	<script>
		var title = <?php echo json_encode($row['title']) ?>;

		//If the login process was not completed the user will be redirected
		var goodLogin = <?php echo json_encode($goodLogin) ?>;

		if (goodLogin == false)
		{
			window.location='../index.php';
		}

		document.getElementById('title').innerHTML = title;

		function confirm()
		{
			window.location='deletebook3.php';
		}

		function goback()
		{
			window.location='admin.php'
		}
	</script>

</body>
</html>