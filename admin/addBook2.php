<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<meta http-equiv="refresh" content="5; url=admin.php"/>

	<h3 align=center>Entry Successful!</h3>

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

	$title = $_POST['title'];
	$publisher = $_POST['publisher'];
	$author_first = $_POST['authorf'];
	$author_last = $_POST['authorl'];
	$isbn = $_POST['isbn'];
	$publishDate = $_POST['publishDate'];
	$pageCount = $_POST['pageCount'];
	$description = $_POST['description'];

	$existingAuthor = false;

	date_default_timezone_set('America/Los_Angeles');
  	$timeStamp = date('Y-m-d H:i:s');

	//echo $title . " " . $publisher . " " . $isbn;
	//echo $author_first . " " . $author_last . "<br>" /*. " " . $pageCount*/;
	//echo $publishDate . " " . $description;
	//echo $title . $publisher . $authorf . $authorl . $isbn . "<br>";

	$sql = "SELECT * FROM author WHERE first_name='$author_first' AND last_name='$author_last';";

	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	if (mysqli_num_rows($result) > 0)
	{
		$existingAuthor = true;
		$authorID = $row['id'];
		//echo $authorID;
	}

	if ($existingAuthor == true)
	{
		$sql = "INSERT INTO resource (`resource_id`, `title`, `description`, `publisher`, `publish_date`, `page_count`, `timestamp`) VALUES ('$isbn', '$title', '$description', '$publisher', '$publishDate', $pageCount, '$timeStamp');";

		mysqli_query($conn, $sql);

		$sql = "SELECT * FROM resource WHERE title='$title' AND resource_id=$isbn;";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		//echo $row['id'];

		$resource_id = $row['id'];

		$sql = "INSERT INTO authorship (author_id, resource_id, primary_author, timestamp) VALUES ($authorID, $resource_id, 1, '$timeStamp');";

		mysqli_query($conn, $sql);
	}

	else
	{
		$sql = "INSERT INTO resource (`resource_id`, `title`, `description`, `publisher`, `publish_date`, `page_count`, `timestamp`) VALUES ('$isbn', '$title', '$description', '$publisher', '$publishDate', $pageCount, '$timeStamp');";

		mysqli_query($conn, $sql);

		$sql = "INSERT INTO author (`first_name`, `last_name`, `timestamp`) VALUES ('$author_first', '$author_last', '$timeStamp');";

		mysqli_query($conn, $sql);

		$sql = "SELECT * FROM author WHERE first_name='$author_first' AND last_name='$author_last';";

		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);

		$authorID = $row['id'];

		$sql = "SELECT * FROM resource WHERE title='$title' AND resource_id=$isbn;";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		//echo $row['id'];

		$resource_id = $row['id'];

		$sql = "INSERT INTO authorship (author_id, resource_id, primary_author, timestamp) VALUES ($authorID, $resource_id, 1, '$timeStamp');";

		mysqli_query($conn, $sql);
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