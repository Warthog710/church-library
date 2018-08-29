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
		if ($searchBy == "publisher")
		{
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.publisher ='$searchTerm';";
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

    		$bookId[$count] = $row['id'];

    		$count++;
		}

	?>

	<form action="includes/bookTemplate2.php" method="get" id="form">
		<input type="text" name="bookcode" placeholder="Enter Book Number" class="inputfield" id="input" hidden>
		<br>
		<div class="radio">
			<input onchange="update()" type="radio" name="searchBy" value="bCode" id="bCode" checked="checked" hidden>
		</div>


	<h3 id="result" align="center"></h3>
	<br>


	<div class="viewButtons" align="center">

	 <button type="button" id="1" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="2" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="3" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="4" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="5" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="6" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="7" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="8" onclick="buttonClick(this.id)" hidden></button>
	 <br> 
	 <button type="button" id="9" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="10" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="11" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="12" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="13" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="14" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="15" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="16" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="17" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="18" onclick="buttonClick(this.id)" hidden></button> 
	 <br>
	 <button type="button" id="19" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="20" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="21" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="22" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="23" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="24" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="25" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="26" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="27" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="28" onclick="buttonClick(this.id)" hidden></button>
	 <br> 
	 <button type="button" id="29" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="30" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="31" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="32" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="33" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="34" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="35" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="36" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="37" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="38" onclick="buttonClick(this.id)" hidden></button> 
	 <br>
	 <button type="button" id="39" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="40" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="41" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="42" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="43" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="44" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="45" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="46" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="47" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="48" onclick="buttonClick(this.id)" hidden></button> 
	 <br>
	 <button type="button" id="49" onclick="buttonClick(this.id)" hidden></button>
	 <br>
	 <button type="button" id="50" onclick="buttonClick(this.id)" hidden></button>
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

		for (var count = 1; count <= number; count++)
		{
			document.getElementById(count).removeAttribute("hidden");
			document.getElementById(count).innerHTML =  row[count - 1]['title'];

		}

		function buttonClick(clicked_id)
		{
			var id = bookId[clicked_id - 1];

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