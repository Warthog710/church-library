<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<h4 id="message" align="center"></h4>

	<div align="center">
		<button onclick="returnBook()">Return another book</button>
		<button onclick="goBack()">Go back</button>
	</div>

	<?php

		include '../includes/dbh.php';

		$searchTerm = $_GET['bookcode'];
		$dateTerm = $_GET['date'];
		//echo $dateTerm;

		date_default_timezone_set("America/Los_Angeles");
		$store = date("Y-m-d H:i:sa");

		$sql = "SELECT * FROM resource WHERE id=$searchTerm;";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		//echo $row['id'];

		$sql = "SELECT * FROM transaction_log WHERE timestamp='$dateTerm';";

		$result = mysqli_query($conn, $sql);
		$array = mysqli_fetch_assoc($result);

		$id = $array['resource_id'];
		$user = $array['users_id'];

		$sql = "INSERT INTO transaction_log (resource_id, users_id, type, timestamp) VALUES ('$id', '$user', 1, '$store');";

		mysqli_query($conn, $sql);	
	?>

	<script>
		
		var row = <?php echo json_encode($row) ?>;
		var user = <?php echo json_encode($array) ?>;

		document.getElementById("message").innerHTML = row['title']  + " has been successfully returned!";

		function goBack()
		{
			window.location='admin.php';
		}

		function returnBook()
		{
			window.location='returnbook.php';
		}


	</script>

</body>
</html>