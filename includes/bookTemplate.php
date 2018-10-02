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
				<p class="status" id="bookstatus">Status: UKNOWN</p>
			</div>
		</div>
	</div>
	<div class="buttons">
		<button type="submit" name="submit" class="button1" onclick="goback()">Go Back</button>
		<button type="submit" name="submit" class="button2" id="checkout" onclick="checkout()">Checkout</button>
	</div>
	<?php
		include_once 'dbh.php';
		session_start();
		$searchTerm = $_GET['bookcode'];
		$searchBy = $_GET['searchBy'];
		$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name, IF(sub.type=2, 'OUT', 'IN') AS bookstatus FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id LEFT JOIN (SELECT t.resource_id, t.type FROM transaction_log t WHERE t.resource_id = $searchTerm ORDER BY timestamp DESC) sub ON sub.resource_id = r.id WHERE r.id =$searchTerm;";
		$result = mysqli_query($conn, $sql);
		//$row = mysqli_fetch_assoc($result);
		$number = mysqli_num_rows($result);
		$count = 0;
		if($number > 1)
		{
			//Putting results into a two dimensional array.
			while ($row = mysqli_fetch_array($result))
			{
    			$array[$count]['id'] = $row['id'];
    			$array[$count]['title'] = $row['title'];
    			$array[$count]['publisher'] = $row['publisher'];
    			$array[$count]['resource_id'] = $row['resource_id'];
    			$array[$count]['description'] = $row['description'];
    			$array[$count]['first_name'] = $row['first_name'];
    			$array[$count]['last_name'] = $row['last_name'];
    			$array[$count]['bookstatus'] = $row['bookstatus'];
    			$count++;
			}
			$_SESSION['bookcode'] = $array[$count - 1]['resource_id'];
			$_SESSION['rId'] = $array[$count - 1]['id'];
		}
		else
		{
			$array = mysqli_fetch_assoc($result);
			$_SESSION['bookcode'] = $array['resource_id'];
			$_SESSION['rId'] = $array['id'];
		}
	?>
	<script>
		var number = <?php echo json_encode($number) ?>;
		var row = <?php echo json_encode($array) ?>;
		if (number > 1)
		{
			var bookstatus = row[number -1 ]['bookstatus'];
			var title = row[number -1 ]['title'];
			var isbn = row[number -1 ]['resource_id'];
			var publisher = row[number -1 ]['publisher'];
			var first_name = row[number -1 ]['first_name'];
			var last_name = row[number -1 ]['last_name'];
			var description = row[number -1 ]['description'];
			var id = row[number -1 ]['id'];
		}
		else
		{
			var bookstatus = row['bookstatus'];
			var title = row['title'];
			var isbn = row['resource_id'];
			var publisher = row['publisher'];
			var first_name = row['first_name'];
			var last_name = row['last_name'];
			var description = row['description'];
			var id = row['id'];
		}
		//alert(number);
		if (bookstatus == "OUT")
		{
			document.getElementById("checkout").removeAttribute("onclick");
			document.getElementById("checkout").innerHTML = "Out";
		}
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
		if (first_name == null && last_name == null)
		{
			document.getElementById('bookauthor').innerHTML = "Author: Unknown Author";
		}
		else
		{
			document.getElementById('bookauthor').innerHTML = "Author: " + first_name + " " + last_name;
		}
		
		if (bookstatus == null)
		{
			document.getElementById('bookstatus').innerHTML = "Status: Unknown Status";
		}
		else
		{
			document.getElementById('bookstatus').innerHTML = "Status: " + bookstatus;
		}
		function checkout()
		{
			window.location='checkout1.php';
		}
		function goback()
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