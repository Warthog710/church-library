<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>
	
	<meta http-equiv="refresh" content="5; url=admin.php"/>

	

	<?php

		include 'dbh.php';

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

		$title = $_SESSION['deleteTitle'];
		//echo $title;

		$sql = "SELECT * FROM resource WHERE title='$title';";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		$bCode = $row['resource_id'];
		$title = $row['title'];
		$description = $row['description'];
		$publisher = $row['publisher'];
		$pDate = $row['publish_date'];
		$pCount = $row['page_count'];
		$timestamp = $row['timestamp'];

		$sql = "INSERT INTO deleted_resource (resource_id, title, description, publisher, publish_date, page_count, timestamp) VALUES ($bCode, '$title', '$description', '$publisher', '$pDate', $pCount, '$timestamp');";

		mysqli_query($conn, $sql);

		$sql = "DELETE FROM resource WHERE title='$title';";

		mysqli_query($conn, $sql);

	

		//mysqli_query($conn, $sql);

		echo "DELETION SUCCESSFUL";

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