<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<form action="login.php" method="post">
  		<input type="text" name="username" placeholder="Enter Username" id="username">
		<input type="password" name="password" placeholder="Enter Password" id="password">
 		<input type="submit" value="Submit">
	</form> 

	<p id="message" hidden>The password or username you entered was incorrect.</p>

	<?php
		include 'includes/dbh.php';

		//------------------Mod Here------------------

		/*$hash = password_hash("temp", PASSWORD_DEFAULT);
		$sql = "UPDATE login SET password = '$hash';";		
		mysqli_query($conn, $sql);
		$sql = "UPDATE login SET username = '$hash';";
		mysqli_query($conn, $sql);*/

		session_start();

		//Checking to see if session exists.
		if (isset($_SESSION['firstLoad']))
		{
			$sql = "SELECT * FROM login WHERE id=1;";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);

			//Grabbing posted variables if they exist.
			if (isset($_POST['password']) && isset($_POST['username']))
			{
				$password = $_POST['password'];
				$username = $_POST['username'];
			}
			else
			{
				//If the variables don't exist the code will exit.
				exit;
			}

			//Verifying the password and username.
			if(password_verify($password, $row['password']) && password_verify($username, $row['username']))
			{
				$goodLogin = true;
				echo "is good";
				$_SESSION['goodLogin'] = true;
			}
			else
			{
				$goodLogin = false;
			}
		}

		//Setting the session variable after first load.
		else
		{
			$_SESSION['firstLoad'] = 1;
			$goodLogin = "firstLoad";
		}		
	?>


	<script>
		var goodLogin = <?php echo json_encode($goodLogin) ?>;	

		//If the password and username were correct...
		if (goodLogin == true)
		{
			window.location='admin/admin.php';
		}
		else
		{
			document.getElementById("message").removeAttribute("hidden");
		}
	</script>

</body>
</html>