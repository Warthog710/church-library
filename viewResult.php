<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<?php

	include 'includes/dbh.php';

	session_start();

	$searchTerm = $_GET['bookcode'];
	$searchBy = $_GET['searchBy'];

	if ($searchBy == "bCode")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.id =$searchTerm;";
		}
		if ($searchBy == "author")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE CONCAT(a.first_name, ' ', a.last_name) LIKE '%$searchTerm%';";
		}
		if ($searchBy == "title")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.title LIKE '%$searchTerm%';";
		}
		if ($searchBy == "isbn")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.resource_id =$searchTerm;";
		}
		if ($searchBy == "publisher")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.publisher LIKE '%$searchTerm%';";
		}

	//$sql = "SELECT * FROM resource WHERE title='$title';";
	$result = mysqli_query($conn, $sql);
	$number = mysqli_num_rows($result);

	if ($number <= 0)
	{
		$oneBook = true;
		$array = 0;
		$number = 0;
		$bookId = 0;
	}
	else
	{
		$oneBook = false;
	}

	$count = 0;

	//Putting results into a two dimensional array.
	while ($row = mysqli_fetch_array($result))
		{
    		$array[$count]['id'] = $row['id'];
    		$array[$count]['title'] = $row['title'];
    		$array[$count]['resource_id'] = $row['resource_id'];
    		$array[$count]['first_name'] = $row['first_name'];
    		$array[$count]['last_name'] = $row['last_name'];
			$array[$count]['publisher'] = $row['publisher'];

    		$bookId[$count] = $row['id'];

    		$count++;
		}

	?>

	<form action="includes/bookTemplate.php" method="get" id="form">
		<input type="text" name="bookcode" placeholder="Enter Book Number" class="inputfield" id="input" hidden>
		<br>
		<div class="radio">
			<input onchange="update()" type="radio" name="searchBy" value="bCode" id="bCode" checked="checked" hidden>
		</div>


	<h3 id="result" align="center"></h3>
	<br>


	<div id="viewButtons" align="center">
	</div>

	<br>
	<br>
	<button type="button" onclick="goBack()">Go Back</button>

	<script>
		
		var row = <?php echo json_encode($array) ?>;
		var number = <?php echo json_encode($number) ?>;
		var bookId = <?php echo json_encode($bookId) ?>;
		var oneBook = <?php echo json_encode($oneBook) ?>;

		//For Debugging purposes.
		//alert(row[0]['title']);
		//alert(row[1]['title']);

		if (oneBook == true)
		{
			document.getElementById("result").innerHTML =  "Your search contained 0 results.";
		}
		else
		{
			document.getElementById("result").innerHTML =  "Your search contained " + number + " results.";
		}

		for (var count = 0; count < number; count++)
		{
			//These variables are used to hold newly created variables.	
			var button = document.createElement("button");
			var text = document.createTextNode(row[count]['title'] + ', by ' + row[count]['first_name'] +  " " + row[count]['last_name'] + ', from ' + row[count]['publisher']);

			//Setting the buttons attributes.
			button.setAttribute('onclick', 'buttonClick(this.id)');
			button.setAttribute('id', count);

			//Appending the text to the button.
			button.appendChild(text);

			//Appending the button element to the viewButtons div.
			document.getElementById("viewButtons").appendChild(button);
   		}

		function buttonClick(clicked_id)
		{
			var id = bookId[clicked_id];

			document.getElementById("input").value = id;

			document.getElementById("form").submit(); 
		}

		function goBack()
		{
			window.location='booksearch.php';
		}




	</script>

</body>
</html>