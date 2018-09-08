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

	<h4 align="center" id="message" hidden>More then one result was found! Please enter the unique id (bold number) for your desired result.</h4>

	<h5 align="center"></h5>

	<div align="center" class="duplicates">
		<p id="1" hidden></p>
		<p id="2" hidden></p>
		<p id="3" hidden></p>
		<p id="4" hidden></p>
		<p id="5" hidden></p>
		<p id="6" hidden></p>
		<p id="7" hidden></p>
		<p id="8" hidden></p>
		<p id="9" hidden></p>
		<p id="10" hidden></p>
		<p id="11" hidden></p>
		<p id="12" hidden></p>
		<p id="13" hidden></p>
		<p id="14" hidden></p>
		<p id="15" hidden></p>
		<p id="16" hidden></p>
		<p id="17" hidden></p>
		<p id="18" hidden></p>
		<p id="19" hidden></p>
		<p id="20" hidden></p>
		<p id="21" hidden></p>
		<p id="22" hidden></p>
		<p id="23" hidden></p>
		<p id="24" hidden></p>
		<p id="25" hidden></p>
		<p id="26" hidden></p>
		<p id="27" hidden></p>
		<p id="28" hidden></p>
		<p id="29" hidden></p>
		<p id="30" hidden></p>
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
		if (dupe == false)
		{
			//alert(row);
			document.getElementById("input").value = row;
			document.getElementById("form").submit();
		}
		else
		{
			document.getElementById("form").removeAttribute("hidden");
			document.getElementById("message").removeAttribute("hidden");
		}
		//For Debugging purposes.
		//alert(row[0]['title']);
		//alert(row[1]['title']);
		//alert(row['id']);
		for (var count = 1; count <= number; count++)
		{
			document.getElementById(count).removeAttribute("hidden");
			document.getElementById(count).innerHTML =  "<b>" + row[count - 1]['id'] + "</b>" + " " + row[count - 1]['title'] + " " + row[count - 1]['resource_id'] + " " + row[count - 1]['first_name'] + " " + row[count - 1]['last_name'];
			if (count > 30)
			{
				break;
			}
			
		}
	</script>
</body>
</html>