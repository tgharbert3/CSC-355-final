<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	
	try{
		require_once('../pdo_connect.php'); //Connect to the database
		$sql = 'SELECT b.title, AVG(ur.rating) AS average_rating FROM book b JOIN userReviews ur ON b.bookID = ur.bookID GROUP BY b.title';
		$result = $dbc-> query($sql);
	} catch (PDOException $e){
		echo $e->getMessage();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2>Average Ratings (Aggregate Function)</h2>

	<table>
		<tr>
			<th>Title</th>
			<th>Average Rating</th>
		</tr>	
		<?php foreach ($result as $item) {
			echo "<tr>";
			echo "<td>".$item['title']."</td>";
			echo "<td>".$item['average_rating']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>