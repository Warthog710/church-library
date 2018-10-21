<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>

	<a href="returnbook.php">Return a Book</a>
	<br>
	<a href="checkedout.php">See all checked out books.</a>
	<br>
	<a href="checkedout4weeks.php">See all books checked out for 4 weeks or more.</a>
	<br>
	<a href="addbook.php">Add a book.</a>
	<br>
	<a href="deletebook.php">Delete a book.</a>
	<br><br>
	<a href="../index.php">Go back</a>
</head>
<body>
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
	</script>

</body>
</html>