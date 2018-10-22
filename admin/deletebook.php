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

	<link href="../css/stylesheet.css" type="text/css" rel="stylesheet"/>

	<form action="deletebook2.php" method="get">
		<input type="text" name="title" placeholder="Enter Book Title" class="inputfield">
		<br>
		<button type="submit" name="submit" class="searchbutton">Search</button>
	</form>

	<?php
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
	?>

	<script>
		//If the login process was not completed the user will be redirected
		var goodLogin = <?php echo json_encode($goodLogin) ?>;

		if (goodLogin == false)
		{
			window.location='../index.php';
		}

		function home()
		{
			window.location='../index.php';
		}

	</script>
</body>
</html>