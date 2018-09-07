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

	<link href="../css/btstylesheet.css" type="text/css" rel="stylesheet"/>

	<div class="allinfo">
		<img class="bookimage" src="../images/genericBook.jpg">

		<div class="info">
			<h2 class="title" id="booktitle" align="center">Doesn't exist or bad DB connection</h2>
			<div class="container">
				<h3>Description:</h3>
				<p class="description" id="bookdescription">Doesn't exist or bad DB connection</p>
				<h3>Info:</h3>
				<p class="isbn" id="bookisbn">Doesn't exist or bad DB connection</p>
				<p class="publisher" id="bookpublisher">Doesn't exist or bad DB connection</p>
				<p class="author" id="bookauthor">Doesn't exist or bad DB connection</p>
				<p class="booknumber" id="bookid">Doesn't exist or bad DB connection</p>
				<p class="status">Status: NOT IMPLEMENTED</p>
			</div>
		</div>
	</div>
	<div class="buttons">
		<button type="submit" name="submit" class="button1" onclick="goback()">Go Back</button>
		<button type="submit" name="submit" class="button2" onclick="checkout()">Checkout</button>
	</div>

	<?php
		include_once 'dbh.php';

		session_start();

		$searchTerm = $_GET['bookcode'];
		$searchBy = $_GET['searchBy'];

		if ($searchBy == "bCode")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.id =$searchTerm;";
		}
		if ($searchBy == "author")
		{
			$stringArray = explode(" ", $searchTerm);
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE a.first_name='$stringArray[0]' AND a.last_name='$stringArray[1]';";
		}
		if ($searchBy == "title")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.title ='$searchTerm';";
		}
		if ($searchBy == "isbn")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.resource_id =$searchTerm;";
		}

		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);

		$_SESSION['bookcode'] = $row['resource_id'];
		$_SESSION['rId'] = $row['id'];
	?>

	<script>
		
		var title = <?php echo json_encode($row['title']) ?>;
		var isbn = <?php echo json_encode($row['resource_id']) ?>;
		var publisher = <?php echo json_encode($row['publisher']) ?>;
		var id = <?php echo json_encode($row['resource_id']) ?>;
		var description = <?php echo json_encode($row['description']) ?>;
		var firstName = <?php echo json_encode($row['first_name']) ?>;
		var lastName = <?php echo json_encode($row['last_name']) ?>;

		if (title == null)
		{
			document.getElementById('booktitle').innerHTML = "Unknown Title";
		}
		else
		{
			document.getElementById('booktitle').innerHTML = title;
		}

		if (isbn == null)
		{
			document.getElementById('bookisbn').innerHTML = "ISBN: Unknown ISBN";
		}
		else
		{
			document.getElementById('bookisbn').innerHTML = "ISBN: " + isbn;
		}

		if (publisher == null)
		{
			document.getElementById('bookpublisher').innerHTML = "Publisher: Unknown Publisher";
		}
		else
		{
			document.getElementById('bookpublisher').innerHTML = "Publisher: " + publisher;
		}

		if (id == null)
		{
			document.getElementById('bookid').innerHTML = "Library Number: Unknown ID";
		}
		else
		{
			document.getElementById('bookid').innerHTML = "Library Number: " + id;
		}

		if (description == null || description == "")
		{
			document.getElementById('bookdescription').innerHTML = "No Description...";
		}
		else
		{
			document.getElementById('bookdescription').innerHTML = description;
		}

		if (firstName == null && lastName == null)
		{
			document.getElementById('bookauthor').innerHTML = "Author: Unknown Author";
		}
		else
		{
			document.getElementById('bookauthor').innerHTML = "Author: " + firstName + " " + lastName;

		}

		function checkout()
		{
			window.location='checkout1.php';
		}

		function goback()
		{
			window.location='../checkout.php';
		}

		function home()
		{
			window.location='../index.php';
		}

	</script>
</body>
</html>

