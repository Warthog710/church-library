<!DOCTYPE html>
<html>
<head>
	<title>GRBC Library</title>
</head>
<body>

	<?php
		include_once 'dbh.php';

		$sql = "SELECT sub.book, sub.title, u.firstname, u.lastname, sub2.timestamp
	FROM
	(SELECT * FROM 
		(SELECT checkOut.book, r.title, (IFNULL(checkOut.typeCount, 0) - IFNULL(checkIn.typeCount, 0)) AS checks
			FROM 
				(SELECT trans.resource_id as book, count(trans.type) typeCount, timeStamp
					FROM transaction_log trans
					WHERE type = 2
					GROUP BY book) AS checkOut 
			LEFT JOIN (SELECT trans.resource_id as book, count(trans.type) typeCount
						FROM transaction_log trans
						WHERE type = 1
						GROUP BY book) AS checkIn ON checkOut.book = checkIn.book
			JOIN resource r ON r.id = checkOut.book
			GROUP BY checkOut.book) AS bookList
		WHERE bookList.checks > 0) AS sub
	JOIN (SELECT resource_id, max(timestamp) timestamp, t.users_id
			FROM transaction_log t
			WHERE type = 2
			GROUP BY resource_id) AS sub2 ON sub2.resource_id = sub.book
    JOIN users u ON u.id = sub2.users_id 
    WHERE DATEDIFF(now(), sub2.timestamp) >= 30
";

		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);

		if ($resultCheck > 0) 
		{
    		while($row = mysqli_fetch_assoc($result)) 
    		{
     	  		echo $row['title'] . " checked out by " . $row['firstname'] . " " . $row['lastname'] . " on " . $row['timestamp'] . "<br>";
   			}
		} 
		else 
		{
   			echo "0 resources checked out for 30 days or more.";
		}

	?>

</body>
</html>