<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<form action="includes/booktemplate.php" method="get" align="center"  id="form" hidden>
		<input type="text" name="bookcode" placeholder="Enter Book Number" class="inputfield" id="input">
		<br>
		<div class="radio">
			<input type="radio" name="searchBy" value="bCode" id="bCode" checked="checked">Book Code
		</div>
		<br>
		<button type="submit" name="btnSubmit" class="searchbutton">Search</button>
	</form>

	<h4 align="center" id="message" hidden>More then one result was found! Please enter the unique id for your desired result.</h4>

	<h5 align="center"></h5>

	<div align="center" id="duplicates">
	</div>

	<?php
	include 'includes/dbh.php';
	$searchTerm = $_GET['bookcode'];
	//echo $searchTerm . "<br>";
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
			$sql = "SELECT r.id, r.title, r.publisher, r.resource_id, r.description, a.first_name, a.last_name FROM resource r JOIN authorship au ON au.resource_id = r.id JOIN author a ON au.author_id = a.id WHERE r.publisher ='$searchTerm';";
		}
		$result = mysqli_query($conn, $sql);		
		//$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) > 1)
		{
			$dupe = true;
			$number = mysqli_num_rows($result);
			$count = 0;

			//Putting results into a two dimensional array.
			while ($row = mysqli_fetch_array($result))
			{
    			$array[$count]['id'] = $row['id'];
    			$array[$count]['title'] = $row['title'];
    			$array[$count]['resource_id'] = $row['resource_id'];
    			$array[$count]['first_name'] = $row['first_name'];
    			$array[$count]['last_name'] = $row['last_name'];
    			$count++;
			}
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			$dupe = false;
			$array = $row['id'];
			$number = 0;
		}
	?>

	<script>
		var dupe = <?php echo json_encode($dupe) ?>;
		var row = <?php echo json_encode($array) ?>;
		var number = <?php echo json_encode($number) ?>;


		//If only 1 book is found this code will redirect to the books page.
		if (dupe == false)
		{
			document.getElementById("input").value = row;
			document.getElementById("form").submit();
		}

		//Else, this code will execute and reveal the form where the user can input their desired book
		else
		{
			document.getElementById("form").removeAttribute("hidden");
			document.getElementById("message").removeAttribute("hidden");
		}

		//Creating the necessary elements.
		for (var count = 0; count < number; count++)
		{
			//These variables are used to hold newly created elements.			
			var para = document.createElement("P");	
			var text = document.createTextNode(row[count]['title'] + " | by " + row[count]['first_name'] + " " + row[count]['last_name'] + " | Unique ID: " + row[count]['id']);

			//Appending the text to the paragraph element.
			para.appendChild(text);

			//Appending the paragraph elment to the duplicates ID.
			document.getElementById("duplicates").appendChild(para);			
		}
	</script>
</body>
</html>