<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<input type="text" name="username" placeholder="Enter Username" id="username">
	<input type="password" name="password" placeholder="Enter Password" id="password">
	<button onclick="validateForm()">Submit</button>

	<?php
		include 'includes/dbh.php';

		$sql = "SELECT * FROM admin;";

		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);
	?>


	<script>
		var row = <?php echo json_encode($row) ?>;

		var usernameHash = 0;
		var passwordHash = 0;
		var count = 0;

		//alert (row['username'] + " " + row['pword']);
			
		function validateForm()
		{
			var password = document.getElementById("password").value;
			var username = document.getElementById("username").value;

			
			if (password == null || password == "" || username == null || username == "")
			{
				alert("You must enter something in both password and username.")
			}
			else
			{
				for (count = 0; count < username.length; count++)
				{
					usernameHash = usernameHash + username.charCodeAt(count);
					//console.log("1st loop");
				}

				for (count = 0; count < password.length; count++)
				{
					passwordHash = passwordHash + password.charCodeAt(count);
					//console.log("2nd loop");
				}

				passwordHash = passwordHash * password.length;
				usernameHash = usernameHash * username.length;

				//console.log(usernameHash + " " + passwordHash);

				if (passwordHash == row['pword'] && usernameHash == row['username'])
				{
					window.location='admin/admin.php';
				}
				else
				{
					usernameHash = 0;
					passwordHash = 0;

					alert("You entered the incorrect username or password. Please try again.");
				}
			}
		}
	</script>

</body>
</html>