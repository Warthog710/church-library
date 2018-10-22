<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<h3 id="header">There are 0 books currently checked out. Maybe later?</h3>

	<div id="rButtons">
	</div>

	<form action="returnbook2.php" method="get" id="form">
		<input type="text" name="bookcode" placeholder="Enter Book Number" class="inputfield" id="input" hidden>
		<input type="text" name="date" placeholder="Enter Book Number" class="inputfield" id="dInput" hidden>
	</form>

	<br><br>
	<button onclick="goBack()">Go back</button>	

	<?php

		include '../includes/dbh.php';

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

		$sql = "SELECT sub.book, sub.title, u.firstname, u.lastname, sub2.timestamp FROM (SELECT * FROM (SELECT checkOut.book, r.title, (IFNULL(checkOut.typeCount, 0) - IFNULL(checkIn.typeCount, 0)) AS checks FROM (SELECT trans.resource_id as book, count(trans.type) typeCount, timeStamp	FROM transaction_log trans WHERE type = 2 GROUP BY book) AS checkOut LEFT JOIN (SELECT trans.resource_id as book, count(trans.type) typeCount FROM transaction_log trans WHERE type = 1 GROUP BY book) AS checkIn ON checkOut.book = checkIn.book JOIN resource r ON r.id = checkOut.book GROUP BY checkOut.book) AS bookList WHERE bookList.checks > 0) AS sub JOIN (SELECT resource_id, max(timestamp) timestamp, t.users_id FROM transaction_log t WHERE type = 2 GROUP BY resource_id) AS sub2 ON sub2.resource_id = sub.book JOIN users u ON u.id = sub2.users_id";

		$result = mysqli_query($conn, $sql);		
		//$row = mysqli_fetch_assoc($result);

		$number = mysqli_num_rows($result);

		if ($number > 0)

		{
			$count = 0;

			//Putting results into a two dimensional array.
			while ($row = mysqli_fetch_array($result))
			{
    			$array[$count]['book'] = $row['book'];
    			$array[$count]['title'] = $row['title'];
    			$array[$count]['first_name'] = $row['firstname'];
    			$array[$count]['last_name'] = $row['lastname'];
     			$array[$count]['timestamp'] = $row['timestamp'];

    			$count++;
			}	
		}	

		else
		{
			$array = 0;
		}
	?>

	<script>

		var number = <?php echo json_encode($number) ?>;
		var row = <?php echo json_encode($array) ?>;
		var goodLogin = <?php echo json_encode($goodLogin) ?>;

		//If the login process was not completed the user will be redirected
		if (goodLogin == false)
		{
			window.location='../index.php';
		}

		if(number > 0)
		{

			document.getElementById("header").innerHTML = "There are " + number + " books currently checked out. <br> Please click the book that you wish to return."; 

			/*var radio = document.createElement("input");	
			var node = document.createTextNode("Testing");
			var element = document.getElementById("rButtons");*/

			for (var count = 0; count < number; count++)
			{	
				var button = document.createElement("button");
				var text = document.createTextNode(row[count]['title'] + "\nChecked out by: " + row[count]['first_name'] + " " + row[count]['last_name'] + " on " + row[count]['timestamp']);
				var linebreak = document.createElement("br");

				//Setting the buttons attributes.
				button.setAttribute('onclick', 'buttonClick(this.id)');
				button.setAttribute('id', count);

				//Appending the text to the button.
				button.appendChild(text);

				//Appending the button element to the viewButtons div.
				document.getElementById("rButtons").appendChild(button);
				document.getElementById("rButtons").appendChild(linebreak);

				/*var radio = document.createElement("input");	
				var element = document.getElementById("rButtons");
				var linebreak = document.createElement("br");
				radio.setAttribute('type', 'button');
				radio.setAttribute('name', 'return');
				radio.setAttribute('onclick', 'buttonClick(this.id)');
				radio.setAttribute('id', count);
				element.appendChild(radio);
				element.appendChild(linebreak);

				document.getElementById(count).value = row[count]['title'] + "\nChecked out by: " + row[count]['first_name'] + " " + row[count]['last_name'] + " on " + row[count]['timestamp'];*/
			}
		}

		function buttonClick(clicked_id)
		{
			//alert(clicked_id);
			var id = row[clicked_id]['book'];
			document.getElementById("input").value = id;
			document.getElementById("dInput").value = row[clicked_id]['timestamp'];

			if(confirm("Are you sure you wish to return\n\n" + row[clicked_id]['title'] + "\n\nChecked out by: " + row[clicked_id]['first_name'] + " " + row[clicked_id]['last_name']))
			{
				document.getElementById("form").submit();
			}
		}

		function goBack()
		{
			window.location='admin.php';
		}

		//alert(number + " " + row[0]['title']);

		


	</script>

</body>
</html>