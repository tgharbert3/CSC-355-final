<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	
	try{
		require_once('../pdo_connect.php'); //Connect to the database
		$sql = 'SELECT u.username, b.title, ur.rating FROM userReviews ur JOIN users u ON ur.username = u.username JOIN book b ON ur.bookID = b.bookID ORDER BY ur.rating;';
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
	<h2>Two Table Join</h2>

	<table>
		<tr>
			<th>Username</th>
			<th>Title</th>
			<th>Rating</th>
		</tr>	
		<?php foreach ($result as $item) {
			echo "<tr>";
			echo "<td>".$item['username']."</td>";
			echo "<td>".$item['title']."</td>";
			echo "<td>".$item['rating']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>